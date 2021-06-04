<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Spbd;
use App\Models\PoStock;
use App\Models\SpbdDetail;
use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\PoStockDetail;
use App\Models\StockMovement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class PoStockController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('po.stock.view')){
            $data = [
                // 'po_stock' => $this->po_stock_no()
            ];
            return view('admin.content.po_stock')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('po.stock.view')){
            $po_stock = PoStock::findOrFail($id);
            $data = [
                'po_stock' => $po_stock
            ];
            return view('admin.content.po_stock_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function po_stock_no(){
        $tanggal = Carbon::now();
        $format = 'POS/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $po_stock_no = PoStock::where([
            ['po_no','like', $format.'%'],
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
        if(Auth::user()->can('po.stock.update')){
            $po = PoStock::findOrFail($id);
            $data = array(
                "id" => $po->id,
                "po_no" => $po->po_no,
                "id_spbd" => $po->id_spbd,
                "name_spbd" => $po->spbd->spbd_no,
                "id_vendor" => $po->spbd->id_vendor,
                "vendor_name" => $po->spbd->vendor->name,
                "po_ord_date" => $po->po_ord_date,
                "ppn" => $po->ppn,
            );
            return json_encode($data);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        if(Auth::user()->can('po.stock.update') || Auth::user()->can('receipt.store')){
            $po = PoStockDetail::findOrFail($id);
            $data = array(
                "id" => $po->id,
                "id_spbd_detail" => $po->id_spbd_detail,
                "id_spbd" => $po->id_spbd,
                "stock_master" => $po->stock_master->stock_no,
                "id_stock_master" => $po->id_stock_master,
                "qty" => $po->qty,
                'rec_qty' => $po->rec_qty,
                "satuan" => $po->stock_master->satuan,
                "keterangan" => $po->keterangan,
                "keterangan1" => $po->spbd_detail->keterangan,
                'price' =>$po->price,
                'disc' => $po->disc,
            );
            return json_encode($data);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('po.stock.store')){
            $po_draf = PoStock::where([
                ['po_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            $spbd = PoStock::where([
                ['id_spbd','=', $request['spbd']],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            if($spbd > 0){
                return response()
                    ->json(['code'=>200,'message' => 'The SPBD already used', 'stat' => 'Warning']);
            }

            if($po_draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf PO Stock First', 'stat' => 'Warning']);
            }
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'po_no' => $this->po_stock_no(),
                'id_spbd' => $request['spbd'],
                'id_vendor' => $request['vendor'],
                'po_ord_date' => Carbon::now(),
                'po_status' => 1,
                'spbd_user_id' => Auth::user()->id,
                'spbd_user_name' => Auth::user()->name,
            ];

            $activity = PoStock::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new PO Stock Success' , 'stat' => 'Success', 'po_id' => $activity->id , 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error PO Stock Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(Request $request, $id)
    {
        if(Auth::user()->can('po.stock.store')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_po' => $id,
                'id_spbd_detail' => $request['id_spbd_detail'],
                'id_stock_master' => $request['id_stock_master'],
                'qty' => $request['qty'],
                'price' => preg_replace('/\D/', '',$request['price']),
                'disc' => preg_replace('/\D/', '',$request['disc']),
                'keterangan' => $request['keterangan'],
                'po_detail_status' => 1,
            ];

            $activity = PoStockDetail::create($data);

            $spbd_detail = SpbdDetail::find($request['id_spbd_detail']);
            $spbd_detail->po_qty = $request['qty'];
            $spbd_detail->update();


            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item PO Stock Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item PO Stock Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('po.stock.update')){
            $data = PoStock::find($id);
            $data->id_spbd    = $request['spbd'];
            $data->id_vendor    = $request['vendor'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit PO Stock Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('po.stock.update')){
            $data = PoStockDetail::find($id);
            $data->price    = preg_replace('/\D/', '',$request['price']);
            $data->disc    = preg_replace('/\D/', '',$request['disc']);
            $data->keterangan    = $request['keterangan'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Item PO Stock Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('po.stock.delete')){
            PoStock::find($id)->spbd->spbd_detail()->update(['po_qty' => 0]);
            PoStock::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'PO Stock Success Deleted', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        $po_detail = PoStockDetail::find($id);
        PoStockDetail::destroy($id);
        $spbd_detail = SpbdDetail::find($po_detail->id_spbd_detail);
        $spbd_detail->po_qty = $spbd_detail->po_qty - $po_detail->qty;
        $spbd_detail->update();
        return response()
            ->json(['code'=>200,'message' => 'PO Stock item Success Deleted', 'stat' => 'Success']);
    }

    public function recordPoStock(){
        $data = PoStock::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_po_stock', function($data){
                $po_status = "";
                if($data->po_status == 1){
                    $po_status = "Draft";
                }elseif ($data->po_status == 2) {
                    $po_status = "Request";
                }elseif ($data->po_status == 3) {
                    $po_status = "Verified 1";
                }elseif ($data->po_status == 4) {
                    $po_status = "Verified 2";
                }elseif ($data->po_status == 5) {
                    $po_status = "Approved";
                }elseif ($data->po_status == 6) {
                    $po_status = "Partial";
                }elseif ($data->po_status == 7) {
                    $po_status = "Closed";
                }else {
                    $po_status = "Reject";
                }
                return $po_status;
            })
            ->addColumn('no_spbd', function($data){
                return $data->spbd->spbd_no;
            })
            ->addColumn('action', function($data) use($access){
                $po_stock_detail = "javascript:ajaxLoad('".route('local.po_stock.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->po_no."'";
                if($data->po_status == 1){
                    if($access->can('po.stock.view')){
                        $action .= '<a href="'.$po_stock_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    }
                    if($access->can('po.stock.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('po.stock.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                elseif ($data->po_status == 2){
                    if($access->can('po.stock.view')){
                        $action .= '<a href="'.$po_stock_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('po.stock.verify')){
                        $action .= '<button id="'. $data->id .'" onclick="verify1('. $data->id .')" class="btn btn-info btn-xs"> Verify 1</button> ';
                    }
                    // fungsi print otomatis
                    // if($access->can('po.stock.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_po_stock('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // }
                    // fungsi print otomatis
                }
                elseif ($data->po_status == 3){
                    if($access->can('po.stock.view')){
                        $action .= '<a href="'.$po_stock_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('po.stock.verify')){
                        $action .= '<button id="'. $data->id .'" onclick="verify2('. $data->id .')" class="btn btn-info btn-xs"> Verify 2</button> ';
                    }
                    // fungsi print otomatis
                    // if($access->can('po.stock.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_po_stock('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // }
                    // fungsi print otomatis
                }
                elseif ($data->po_status == 4){
                    if($access->can('po.stock.view')){
                        $action .= '<a href="'.$po_stock_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('po.stock.approve')){
                        $id_button = "'approve_".$data->id."'";
                        $action .= '<button id='. $id_button .' onclick="approve('. $data->id .','.$id_button.')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    // // fungsi print otomatis
                    // if($access->can('po.stock.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_po_stock('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // }
                    // fungsi print otomatis
                }
                else{
                    if($access->can('po.stock.view')){
                        $action .= '<a href="'.$po_stock_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('po.stock.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_po_stock('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordPoStock_detail($id, $rec_stat = NULL){
        if($rec_stat == 1){
            $data = PoStockDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['id_po','=', $id],
            ])->whereRaw('po_stock_details.qty <> po_stock_details.rec_qty')->latest()->get();
        }else {
            $data = PoStockDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['id_po','=', $id],
            ])->latest()->get();
        }
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('price_format', function($data){
                return "Rp. ".number_format($data->price,0, ",", ".");
            })
            ->addColumn('disc_format', function($data){
                return "Rp. ".number_format($data->disc,0, ",", ".");
            })
            ->addColumn('selisih', function($data){
                return $data->qty - $data->rec_detail->sum('terima');
            })
            ->addColumn('action', function($data)  use($rec_stat, $access){
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->po_stock->po_status == 1){
                    if($access->can('po.stock.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('po.stock.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->po_stock->po_status == 2){
                    if($access->can('po.stock.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                }
                if($rec_stat == 1){
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function po_stock_open($id)
    {
        if(Auth::user()->can('po.stock.open')){
            $data = PoStock::findOrFail($id);
            if($data->spbd->spbd_detail->count() != $data->po_stock_detail->count())
            {
                return response()->json(['code'=>200,'message' => 'Error, have SPBD item not added...', 'stat' => 'Error']);
            }
            $data->po_status = 2;
            $data->ppn = 0;
            $data->po_open = Carbon::now();
            if($data->vendor->status_ppn == 1){
                $data->ppn = $data->po_stock_detail->sum('total') * 0.1;
            }
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Open PO Stock Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify1($id)
    {
        if(Auth::user()->can('po.stock.verify')){
            $data = PoStock::findOrFail($id);
            $data->po_status = 3;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'PO Stock Verified Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify2($id)
    {
        if(Auth::user()->can('po.stock.verify')){
            $data = PoStock::findOrFail($id);
            $data->po_status = 4;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'PO Stock Verified Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        if(Auth::user()->can('po.stock.approve')){
            $data = PoStock::findOrFail($id);
            $data->po_status = 5;
            $movement = $this->po_movement($data->po_stock_detail);
            $spbd = Spbd::findOrFail($data->id_spbd);
            $spbd->spbd_status = 4;
            $spbd->update();
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'PO Stock Approve Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error PO Stock Access Denied', 'stat' => 'Error']);
    }

    public function po_movement($data)
    {
        foreach ($data as $detail ) {
            $data = [
                'id_stock_master' => $detail->id_stock_master,
                'id_branch' => $detail->id_branch,
                'move_date' => $detail->po_stock->po_ord_date,
                // 'bin' => "-",
                'type' => 'PO',
                'doc_no' => $detail->po_stock->po_no,
                'order_qty' => $detail->qty,
                'sell_qty' => 0,
                'in_qty' => 0,
                'out_qty' => 0,
                'harga_modal' => $detail->price,
                'harga_jual' => 0,
                'user' => Auth::user()->name,
                'ket' => 'PO Approved at ('.Carbon::now().')',
            ];

            $movement = StockMovement::create($data);
            $stock_master = StockMaster::find($detail->id_stock_master);
            $stock_master->harga_modal = $detail->price;
            $stock_master->update();
        }
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchPo_stock(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $tags = PoStock::where([
            ['po_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['po_status','=', 5],
        ])->orWhere([
            ['po_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['po_status','=', 6],
        ])->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->id,
                'text'  => $tag->po_no,
                'vendor'  => $tag->id_vendor,
                'vendor_name'  => $tag->vendor->name,
                'ppn'  => $tag->ppn,
                'total_bef_ppn' => $tag->po_stock_detail->sum('total'),
                'total' => $tag->po_stock_detail->sum('total') + $tag->ppn,
            ];
        }

        return response()->json($formatted_tags);
    }
}
