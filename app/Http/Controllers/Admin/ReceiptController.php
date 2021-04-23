<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\PoStock;
use App\Models\RecStock;

use App\Models\SpbdDetail;
use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\PoStockDetail;
use App\Models\StockMovement;
use App\Models\RecStockDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;
use App\Http\Requests\Admin\StoreDetailReceiptRequest;

class ReceiptController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('receipt.view')){
            $data = [];
            return view('admin.content.rec')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('receipt.view')){
            $rec = RecStock::findOrFail($id);
            $data = [
                'rec' => $rec
            ];
            return view('admin.content.rec_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function rec_no(){
        $tanggal = Carbon::now();
        $format = 'REC/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $po_stock_no = RecStock::where([
            ['rec_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $po_stock_no);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('receipt.update')){
            $po = RecStock::findOrFail($id);
            $data = array(
                "id" => $po->id,
                "rec_no" => $po->rec_no,
                "po_stock" => $po->id_po_stock,
                "name_po_stock" => $po->po_stock->po_no,
                "id_vendor" => $po->id_vendor,
                "vendor_name" => $po->vendor->name,
                "rec_date" => $po->rec_date,
                "rec_inv_ven" => $po->rec_inv_ven,
                "ppn" => $po->ppn,
            );
            return json_encode($data);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        if(Auth::user()->can('receipt.update')){
            $rec = RecStockDetail::findOrFail($id);
            $data = array(
                "id" => $rec->id,
                "id_rec" => $rec->id_spbd,
                "id_po_detail" => $rec->id_po_detail,
                "stock_master" => $rec->stock_master->stock_no,
                "id_stock_master" => $rec->id_stock_master,
                "terima" => $rec->terima,
                "order" => $rec->order,
                "satuan" => $rec->stock_master->satuan,
                "keterangan" => $rec->keterangan,
                "keterangan1" => $rec->po_detail->keterangan,
                'price' =>$rec->price,
                'disc' => $rec->disc,
            );
            return json_encode($data);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('receipt.store')){
            $draf = RecStock::where([
                ['status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            if($draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Submit the previous Draf Receipt First', 'stat' => 'Warning']);
            }

            $data = [
                'id_branch' => Auth::user()->id_branch,
                'rec_no' => $this->rec_no(),
                'id_vendor' => $request['vendor'],
                'id_po_stock' => $request['po_stock'],
                'rec_inv_ven' => $request['rec_inv_ven'],
                'rec_date' => Carbon::now(),
                'ppn' => preg_replace('/\D/', '',$request['ppn']),
                'status' => 1,
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
            ];

            $activity = RecStock::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new Receipt Stock Success' , 'stat' => 'Success', 'rec_id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error Receipt Stock Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(StoreDetailReceiptRequest $request, $id)
    {
        if(Auth::user()->can('receipt.store')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_rec' => $id,
                'id_po_detail' => $request['id_po_detail'],
                'id_stock_master' => $request['id_stock_master'],
                'order' => $request['qty'],
                'terima' => $request['terima'],
                'bo' => $request['qty'] - $request['terima'],
                'price' => preg_replace('/\D/', '',$request['price']),
                'disc' => preg_replace('/\D/', '',$request['disc']),
                'keterangan' => $request['keterangan'],
                'rec_detail_status' => 1,
            ];
            $activity = RecStockDetail::create($data);
            $po_detail = PoStockDetail::find($request['id_po_detail']);
            $po_detail->rec_qty = $po_detail->rec_detail->sum('terima');
            $po_detail->update();
            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item PO Stock Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item PO Stock Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('receipt.update')){
            $data = RecStock::find($id);
            $data->id_po_stock    = $request['po_stock'];
            $data->id_vendor    = $request['vendor'];
            $data->rec_inv_ven    = $request['rec_inv_ven'];
            $data->ppn    = $request['ppn'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Receipt Stock Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('receipt.update')){
            $data = RecStockDetail::find($id);
            $data->terima    = $request['terima'];
            $data->keterangan    = $request['keterangan'];
            $data->update();

            $po_detail = PoStockDetail::find($data->id_po_detail);
            $po_detail->rec_qty = $po_detail->rec_detail->sum('terima');
            $po_detail->update();

            return response()
                ->json(['code'=>200,'message' => 'Edit Item Receipt Stock Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('receipt.delete')){
            RecStock::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Receipt Stock Success Deleted', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        $rec_detail = RecStockDetail::find($id);
        RecStockDetail::destroy($id);
        $po_detail = PoStockDetail::find($rec_detail->id_po_detail);
        $po_detail->rec_qty = $po_detail->rec_detail->sum('terima');
        $po_detail->update();
        return response()
            ->json(['code'=>200,'message' => 'Receipt Stock item Success Deleted', 'stat' => 'Success']);
    }

    public function recordRec(){
        $data = RecStock::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('po_stock_no', function($data){
                $action = $data->po_stock()->count();
                if($data->po_stock()->count() > 0){
                    $action = $data->po_stock->po_no;
                }
                return $action;
            })
            ->addColumn('action', function($data)  use($access){
                $rec_detail = "javascript:ajaxLoad('".route('local.rec.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->rec_no."'";
                if($data->status == 1){
                    if($access->can('receipt.view')){
                        $action .= '<a href="'.$rec_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    }
                    if($access->can('receipt.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('receipt.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->status == 2){
                    if($access->can('receipt.view')){
                        $action .= '<a href="'.$rec_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('receipt.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_receipt('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }

                return $action;
            })
            ->rawColumns(['action','po_stock_no'])->make(true);
    }

    public function recordRec_detail($id, $rec_stat = NULL){
        $data = RecStockDetail::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['id_rec','=', $id],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data)  use($rec_stat, $access){
                $action = "";
                $title = "'".$data->stock_master->stock_no."'";
                if($data->receipt->status == 1){
                    if($access->can('receipt.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('receipt.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($rec_stat == 1){
                    if($access->can('receipt.store')){
                        $action .= '<button id="'. $data->id .'" onclick="addItem('. $data->id .')" class="btn btn-info btn-xs"> Add Item</button> ';
                    }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rec_open($id)
    {
        if(Auth::user()->can('receipt.open')){
            $data = RecStock::findOrFail($id);
            if($data->receipt_detail->count() < 1)
            {
                return response()->json(['code'=>200,'message' => 'Error, have Receipts item not added...', 'stat' => 'Error']);
            }
            $data->status = 2;
            $data->rec_open = Carbon::now();
            $movement = $this->rec_movement($data->receipt_detail);

            $po_stock = PoStock::findOrFail($data->id_po_stock);

            if($data->po_stock->po_stock_detail->sum('qty') == $data->po_stock->po_stock_detail->sum('rec_qty')){
                $po_stock->po_status = 6;
            }else{
                $po_stock->po_status = 5;
            }
            // $po_stock->po_status = 5;
            $po_stock->update();

            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Open Receipt Stock Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);
    }

    public function rec_movement($data)
    {
        foreach ($data as $detail ) {
            $data = [
                'id_stock_master' => $detail->id_stock_master,
                'id_branch' => $detail->id_branch,
                'move_date' => $detail->receipt->rec_date,
                // 'bin' => "-",
                'type' => 'RC',
                'doc_no' => $detail->receipt->rec_no,
                'order_qty' => 0,
                'sell_qty' => 0,
                'in_qty' => $detail->terima,
                'out_qty' => 0,
                'harga_modal' => $detail->price,
                'harga_jual' => 0,
                'user' => Auth::user()->name,
                'ket' => 'PO ('.$detail->po_detail->po_stock->po_no.')',
            ];

            $movement = StockMovement::create($data);
            $stock_master = StockMaster::find($detail->id_stock_master);
            $stock_master->harga_modal = $detail->price;
            $stock_master->update();
        }
    }
}
