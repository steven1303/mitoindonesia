<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Adjustment;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\AdjustmentDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class AdjustmentController extends SettingAjaxController
{
    public function index()
    {
        $data = [];
        return view('admin.content.adjustment')->with($data);
    }

    public function detail($id)
    {
        $adj = Adjustment::findOrFail($id);
        $data = [
            'adj' => $adj
        ];
        return view('admin.content.adjustment_detail')->with($data);
    }

    public function adj_no(){
        $tanggal = Carbon::now();
        $format = 'ADJ/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $spbd_no = Adjustment::where([
            ['adj_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $spbd_no);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'adj_no' => $this->adj_no(),
            'id_branch' => Auth::user()->id_branch,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'status' => 1,
        ];

        $activity = Adjustment::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new Adjustment Success' , 'stat' => 'Success', 'id' => $activity->id, 'process' => 'add']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error Adjustment Store', 'stat' => 'Error']);
        }
    }

    public function store_detail(Request $request, $id)
    {
        // return $request;
        $data = [
            'id_branch' => Auth::user()->id_branch,
            'adj_id' => $id,
            'id_stock_master' => $request['stock_master'],
            'in_qty' => $request['in_qty'],
            'out_qty' => $request['out_qty'],
            'harga_modal' => preg_replace('/\D/', '',$request['harga_modal']),
            'harga_jual' => preg_replace('/\D/', '',$request['harga_jual']),
            'keterangan' => $request['keterangan'],
        ];

        $activity = AdjustmentDetail::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new item Adjustment Success', 'stat' => 'Success', 'process' => 'update']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error item Adjustment Store', 'stat' => 'Error']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        $data = AdjustmentDetail::with('stock_master')->findOrFail($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_detail(Request $request, $id)
    {
        // return $request;
        $data = AdjustmentDetail::find($id);
        $data->id_stock_master    = $request['stock_master'];
        $data->in_qty    = $request['in_qty'];
        $data->out_qty    = $request['out_qty'];
        $data->harga_modal    = preg_replace('/\D/', '',$request['harga_modal']);
        $data->harga_jual    = preg_replace('/\D/', '',$request['harga_jual']);
        $data->keterangan    = $request['keterangan'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Item Adjustment Success', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Adjustment::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Adjustment Success Deleted', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        AdjustmentDetail::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Adjustment Detail Success Deleted', 'stat' => 'Success']);
    }

    public function recordAdj(){
        $data = Adjustment::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_adj', function($data){
                $status = "";
                if($data->status == 1){
                    $status = "Draft";
                }elseif ($data->status == 2) {
                    $status = "Request";
                }else {
                    $status = "Approved";
                }
                return $status;
            })
            ->addColumn('action', function($data){
                $adj_detail = "javascript:ajaxLoad('".route('local.adj.detail.index', $data->id)."')";
                $adj_approve = "javascript:ajaxLoad('".route('local.spbd.approve', $data->id)."')";
                $action = "";
                $title = "'".$data->adj_no."'";
                if($data->status == 1){
                    $action .= '<a href="'.$adj_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                elseif($data->status == 2){
                    $action .= '<a href="'.$adj_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="print_spbd('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                }
                else{
                    $action .= '<a href="'.$adj_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="print_adj('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                }

                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordAjd_detail($id){
        $data = AdjustmentDetail::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['adj_id','=', $id],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->adj->status == 1){
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                return $action;
            })
            ->addColumn('nama_stock', function($data){
                $action = $data->stock_master->name;
                return $action;
            })
            ->addColumn('format_modal', function($data){
                return "Rp. ".number_format($data->harga_modal,0, ",", ".");
            })
            ->addColumn('format_jual', function($data){
                return "Rp. ".number_format($data->harga_jual,0, ",", ".");
            })
            ->addColumn('satuan', function($data){
                $action = $data->stock_master->satuan;
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adj_open($id)
    {
        $data = Adjustment::findOrFail($id);
        $data->status = 2;
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Open Adjustment Success', 'stat' => 'Success']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $data = Adjustment::findOrFail($id);
        $data->status = 3;
        $movement = $this->po_movement($data->adj_detail);
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Adjustment Approve Success', 'stat' => 'Success']);
    }

    public function po_movement($data)
    {
        foreach ($data as $detail ) {
            $data = [
                'id_stock_master' => $detail->id_stock_master,
                'id_branch' => $detail->id_branch,
                'move_date' => $detail->adj->created_at,
                // 'bin' => "-",
                'type' => 'ADJ',
                'doc_no' => $detail->adj->adj_no,
                'order_qty' => 0,
                'sell_qty' => 0,
                'in_qty' => $detail->in_qty,
                'out_qty' => $detail->out_qty,
                'harga_modal' => $detail->harga_modal,
                'harga_jual' => $detail->harga_jual,
                'user' => Auth::user()->name,
                'ket' => 'Adjustment Approved at ('.Carbon::now().')',
            ];

            $movement = StockMovement::create($data);
            // $stock_master = StockMaster::find($detail->id_stock_master);
            // $stock_master->harga_modal = $detail->price;
            // $stock_master->update();
        }
    }
}
