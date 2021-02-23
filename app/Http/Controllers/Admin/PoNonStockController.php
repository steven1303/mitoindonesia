<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\SpbDetail;
use App\Models\PoNonStock;
use App\Models\Spb;
use Illuminate\Http\Request;
use App\Models\PoNonStockDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class PoNonStockController extends SettingAjaxController
{
    public function index()
    {
        $data = [
            // 'po_stock' => $this->po_stock_no()
        ];
        return view('admin.content.po_non_stock')->with($data);
    }

    public function detail($id)
    {
        $po_non_stock = PoNonStock::findOrFail($id);
        $data = [
            'po_stock' => $po_non_stock
        ];
        return view('admin.content.po_non_stock_detail')->with($data);
    }

    public function po_non_stock_no(){
        $tanggal = Carbon::now();
        $format = 'PON/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $po_stock_no = PoNonStock::where([
            ['po_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $po_stock_no);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'id_branch' => Auth::user()->id_branch,
            'po_no' => $this->po_non_stock_no(),
            'id_spb' => $request['spb'],
            'id_vendor' => $request['vendor'],
            'po_status' => 1,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ];

        $activity = PoNonStock::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new PO Non Stock Success' , 'stat' => 'Success', 'po_id' => $activity->id , 'process' => 'add']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error PO Non Stock Store', 'stat' => 'Error']);
        }
    }

    public function store_detail(Request $request, $id)
    {
        // return $request;
        $data = [
            'id_branch' => Auth::user()->id_branch,
            'id_po' => $id,
            'id_spb_detail' => $request['id_spb_detail'],
            'price' => preg_replace('/\D/', '',$request['price']),
            'disc' => preg_replace('/\D/', '',$request['disc']),
            'keterangan' => $request['keterangan'],
            'po_detail_status' => 1,
        ];

        $activity = PoNonStockDetail::create($data);

        $spbd_detail = SpbDetail::find($request['id_spb_detail']);
        $spbd_detail->spb_detail_status = 2;
        $spbd_detail->update();


        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new item PO Non Stock Success', 'stat' => 'Success', 'process' => 'update']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error item PO Non Stock Store', 'stat' => 'Error']);
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
        $po = PoNonStock::findOrFail($id);
        $data = array(
            "id" => $po->id,
            "po_no" => $po->po_no,
            "id_spb" => $po->id_spb,
            "name_spb" => $po->spb->spb_no,
            "id_vendor" => $po->spb->id_vendor,
            "vendor_name" => $po->spb->vendor->name,
        );
        return json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        $po = PoNonStockDetail::findOrFail($id);
        $data = array(
            "id" => $po->id,
            "id_spb_detail" => $po->id_spb_detail,
            "qty" => $po->spb_detail->qty,
            "satuan" => $po->spb_detail->satuan,
            "keterangan" => $po->keterangan,
            "keterangan1" => $po->spb_detail->keterangan,
            'price' =>$po->price - 0,
            'disc' => $po->disc - 0,
        );
        return json_encode($data);
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

        $data = PoNonStock::find($id);
        $data->id_spb   = $request['spb'];
        $data->id_vendor    = $request['vendor'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit PO Non Stock Success', 'stat' => 'Success']);
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
        $data = PoNonStockDetail::find($id);
        $data->price    = preg_replace('/\D/', '',$request['price']);
        $data->disc    = preg_replace('/\D/', '',$request['disc']);
        $data->keterangan    = $request['keterangan'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Item PO Non Stock Success', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PoNonStock::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'PO Non Stock Success Deleted', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        $po_detail = PoNonStockDetail::find($id);
        PoNonStockDetail::destroy($id);
        $spbd_detail = SpbDetail::find($po_detail->id_spb_detail);
        $spbd_detail->spb_detail_status = 1;
        $spbd_detail->update();
        return response()
            ->json(['code'=>200,'message' => 'PO Non Stock item Success Deleted', 'stat' => 'Success']);
    }

    public function recordPoNonStock(){
        $data = PoNonStock::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_po_stock', function($data){
                $po_status = "";
                if($data->po_status == 1){
                    $po_status = "Draft";
                }elseif ($data->po_status == 2) {
                    $po_status = "Request";
                }else{
                    $po_status = "Approved";
                }
                return $po_status;
            })
            ->addColumn('action', function($data){
                $po_non_stock_detail = "javascript:ajaxLoad('".route('local.po_non_stock.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->po_no."'";
                if($data->po_status == 1){
                    $action .= '<a href="'.$po_non_stock_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                elseif ($data->po_status == 2){
                    $action .= '<a href="'.$po_non_stock_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="print_po_stock('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                }
                else{
                    $action .= '<a href="'.$po_non_stock_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="print_po_stock('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                }
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordPoNonStock_detail($id, $rec_stat = NULL){
        $data = PoNonStockDetail::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['id_po','=', $id],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('price_format', function($data){
                return "Rp. ".number_format($data->price,0, ",", ".");
            })
            ->addColumn('disc_format', function($data){
                return "Rp. ".number_format($data->disc,0, ",", ".");
            })
            ->addColumn('satuan', function($data){
                return $data->spb_detail->satuan;
            })
            ->addColumn('qty', function($data){
                return $data->spb_detail->qty;
            })
            ->addColumn('keterangan_spb', function($data){
                return $data->spb_detail->keterangan;
            })
            ->addColumn('action', function($data)  use($rec_stat){
                $action = "";
                $title = "'".$data->spb_detail->keterangan."'";
                if($data->po_non_stock->po_status == 1){
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                if($rec_stat == 1){
                    $action .= '<button id="'. $data->id .'" onclick="addItem('. $data->id .')" class="btn btn-info btn-xs"> Add Item</button> ';
                }
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
    public function po_stock_open($id)
    {
        $data = PoNonStock::findOrFail($id);
        $data->po_status = 2;
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Open PO Non Stock Success', 'stat' => 'Success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $data = PoNonStock::findOrFail($id);
        $data->po_status = 3;
        $spb = SPB::findOrFail($data->id_spb);
        $spb->spb_status = 4;
        $spb->update();
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'PO Non Stock Approve Success', 'stat' => 'Success']);
    }
}
