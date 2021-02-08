<?php

namespace App\Http\Controllers\Admin;

use App\Models\Spbd;
use App\Models\SpbdDetail;

use App\Models\Sppb;
use App\Models\SppbDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class SppbController extends SettingAjaxController
{
    public function index()
    {
        $data = [];
        return view('admin.content.sppb')->with($data);
    }

    public function detail($id)
    {
        $sppb = Sppb::findOrFail($id);
        $data = [
            'sppb' => $sppb
        ];
        return view('admin.content.sppb_detail')->with($data);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'id_branch' => Auth::user()->id_branch,
            'sppb_no' => $request['sppb_no'],
            'sppb_date' => $request['sppb_date'],
            'id_customer' => $request['customer'],
            'sppb_po_cust' => $request['sppb_po_cust'],
            'sppb_status' => 1,
            'sppb_user_name' => Auth::user()->name,
            'sppb_user_id' => Auth::user()->id,
        ];

        $activity = Sppb::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new SPPB Success' , 'stat' => 'Success', 'sppb_id' => $activity->id, 'process' => 'add']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error SPPB Store', 'stat' => 'Error']);
        }
    }

    public function store_detail(Request $request, $id)
    {
        // return $request;
        $data = [
            'id_branch' => Auth::user()->id_branch,
            'sppb_id' => $id,
            'id_stock_master' => $request['stock_master'],
            'qty' => $request['qty'],
            'price' => $request['price'],
            'keterangan' => $request['keterangan'],
            'sppb_detail_status' => 1,
        ];

        $activity = SppbDetail::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new item SPPB Success', 'stat' => 'Success', 'process' => 'update']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error item SPPB Store', 'stat' => 'Error']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Sppb::with('customer')->findOrFail($id);
        return $data;
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        $data = SppbDetail::with('stock_master')->findOrFail($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = Sppb::find($id);
        $data->sppb_no    = $request['sppb_no'];
        $data->sppb_date    = $request['sppb_date'];
        $data->id_customer    = $request['customer'];
        $data->sppb_po_cust    = $request['sppb_po_cust'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit SPPB Success', 'stat' => 'Success']);
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
        $data = SppbDetail::find($id);
        $data->id_stock_master    = $request['stock_master'];
        $data->qty    = $request['qty'];
        $data->price    = $request['price'];
        $data->keterangan    = $request['keterangan'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Item SPPB Success', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sppb::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'SPPB Success Deleted', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        SppbDetail::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'SPPB Detail Success Deleted', 'stat' => 'Success']);
    }

    public function recordSppb(){
        $data = Sppb::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $sppb_detail = "javascript:ajaxLoad('".route('local.sppb.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->sppb_no."'";
                if($data->sppb_status == 1){
                    $action .= '<a href="'.$sppb_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                if($data->sppb_status == 2){
                    $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                }

                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordSppb_detail($id, $inv_stat = NULL){
        if($inv_stat == 1){
            $data = SppbDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['sppb_id','=', $id],
            ])->whereRaw('sppb_details.qty <> sppb_details.inv_qty')->latest()->get();
        }else{
            $data = SppbDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['sppb_id','=', $id],
            ])->latest()->get();
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data)  use($inv_stat){
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->sppd->sppb_status == 1){
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                if($inv_stat == 1){
                    $action .= '<button id="'. $data->id .'" onclick="addItem('. $data->id .')" class="btn btn-info btn-xs"> Add Item</button> ';
                }
                return $action;
            })
            ->addColumn('nama_stock', function($data){
                $action = $data->stock_master->name;
                return $action;
            })
            ->addColumn('satuan', function($data){
                $action = $data->stock_master->satuan;
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchSppb(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $tags = Sppb::where([
            ['sppb_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['sppb_status','=', 2],
        ])->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->id,
                'text'  => $tag->sppb_no,
                'customer'  => $tag->id_customer,
                'customer_name'  => $tag->customer->name,
                'customer_po'  => $tag->sppb_po_cust,
            ];
        }

        return response()->json($formatted_tags);
    }


     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sppb_open($id)
    {
        $data = Sppb::findOrFail($id);
        $data->sppb_status = 2;
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Open SPPB Success', 'stat' => 'Success']);
    }
}
