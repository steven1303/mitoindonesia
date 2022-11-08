<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\SppbNew;
use App\Models\InvoiceNew;
use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\PoInternalNew;
use App\Models\SppbNewDetail;
use App\Models\StockMovement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreSppbNewRequest;
use App\Http\Requests\Admin\UpdateSppbNewRequest;
use App\Http\Requests\Admin\StoreDetailSppbRequest;
use App\Http\Requests\Admin\UpdateDetailSppbRequest;
use App\Http\Controllers\Admin\SettingAjaxController;

class SppbNewController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('sppb.new.view')){
            $data = [];
            return view('admin.content.sppb_new')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('sppb.new.view')){
            $sppb = SppbNew::poInternal()->findOrFail($id);
            $data = [
                'sppb' => $sppb
            ];
            return view('admin.content.sppb_new_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function sppb_no(){
        $tanggal = Carbon::now();
        $format = 'SPPB/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $sppb_no = SppbNew::where([
            ['sppb_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $sppb_no);
    }

    public function store(StoreSppbNewRequest $request)
    {
        if(Auth::user()->can('sppb.new.store')){
            $draf = SppbNew::where([
                ['sppb_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            if($draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf SPPB First', 'stat' => 'Warning']);
            }

            $data = [
                'id_branch' => Auth::user()->id_branch,
                'sppb_no' => $this->sppb_no(),
                'id_po_internal' => $request['po_internal'],
                'sppb_date' => Carbon::now(),
                'sppb_status' => 1,
                'sppb_user_name' => Auth::user()->name,
                'sppb_user_id' => Auth::user()->id,
            ];

            $activity = SppbNew::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new SPPB Success' , 'stat' => 'Success', 'sppb_id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error SPPB Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(StoreDetailSppbRequest $request, $id)
    {
        if(Auth::user()->can('sppb.new.store')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'sppb_id' => $id,
                'id_stock_master' => $request['stock_master'],
                'qty' => $request['qty'],
                // 'price' => intval(preg_replace('/,.*|[^0-9]/', '',$request['price'])),
                'keterangan' => $request['keterangan'],
                'sppb_detail_status' => 1,
            ];

            $activity = SppbNewDetail::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item SPPB Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item SPPB Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('sppb.new.update')){
            $data = SppbNew::with('customer')->findOrFail($id);
            return $data;
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        if(Auth::user()->can('sppb.new.update') || Auth::user()->can('invoice.store')){
            $data = SppbNewDetail::with('stock_master')->findOrFail($id);
            return $data;
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSppbNewRequest $request, $id)
    {
        if(Auth::user()->can('sppb.new.update')){
            $data = SppbNew::find($id);
            $data->sppb_date    = Carbon::now();
            $data->doc_no    = $request['doc_no'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit SPPB Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_detail(UpdateDetailSppbRequest $request, $id)
    {
        if(Auth::user()->can('sppb.new.update')){
            $data = SppbNewDetail::find($id);
            $data->id_stock_master    = $request['stock_master'];
            $data->qty    = $request['qty'];
            // $data->price    = preg_replace('/\D/', '',$request['price']);
            $data->keterangan    = $request['keterangan'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Item SPPB Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('sppb.new.delete')){
            SppbNew::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'SPPB Success Deleted', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        SppbNewDetail::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'SPPB Detail Success Deleted', 'stat' => 'Success']);
    }

    public function recordSppb(){
        $data = SppbNew::poInternal()->where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function($data){
                $sppb_status = "";
                if($data->sppb_status == 1){
                    $sppb_status = "Draft";
                }elseif ($data->sppb_status == 2) {
                    $sppb_status = "Request";
                }elseif ($data->sppb_status == 3) {
                    $sppb_status = "Verified 1";
                }elseif ($data->sppb_status == 4) {
                    $sppb_status = "Verified 2";
                }elseif ($data->sppb_status == 5) {
                    $sppb_status = "Approved";
                }elseif ($data->sppb_status == 6) {
                    $sppb_status = "Closed";
                }else {
                    $sppb_status = "Batal";
                }
                return $sppb_status;
            })
            ->addColumn('action', function($data) use($access){
                $sppb_detail = "javascript:ajaxLoad('".route('local.sppb.new.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->sppb_no."'";
                if($data->sppb_status == 1){
                    if($access->can('sppb.new.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    }
                    if($access->can('sppb.new.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                elseif($data->sppb_status == 2){
                    if($access->can('sppb.new.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.new.verify1')){
                        $action .= '<button id="'. $data->id .'" onclick="verify1('. $data->id .')" class="btn btn-info btn-xs"> Verify 1</button> ';
                    }
                    // fungsi untuk hilangkan print sebelum approval
                    // if($access->can('sppb.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // } 
                    
                }
                elseif($data->sppb_status == 3){
                    if($access->can('sppb.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.new.verify2')){
                        $action .= '<button id="'. $data->id .'" onclick="verify2('. $data->id .')" class="btn btn-info btn-xs"> Verify 2</button> ';
                    }
                    // fungsi untuk hilangkan print sebelum approval
                    // if($access->can('sppb.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // } 
                    
                }
                elseif($data->sppb_status == 4){
                    if($access->can('sppb.new.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.new.approve')){
                        $action .= '<button id="approve'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    // fungsi untuk hilangkan print sebelum approval
                    // if($access->can('sppb.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // } 
                    
                }
                elseif($data->sppb_status == 5){
                    if($access->can('sppb.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }else {
                    if($access->can('sppb.view')){
                        $action .= '<a href="'.$sppb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('sppb.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_sppb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }

                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordSppb_detail($id, $inv_stat = NULL){
        if($inv_stat == 1){
            $data = SppbNewDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['sppb_id','=', $id],
            ])->whereRaw('sppb_details.qty <> sppb_details.inv_qty')->latest()->get();
        }else{
            $data = SppbNewDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['sppb_id','=', $id],
            ])->latest()->get();
        }
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data)  use($inv_stat, $access){
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->sppb->sppb_status == 1){
                    if($access->can('sppb.new.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('sppb.new.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->sppb->sppb_status == 2){
                    if($access->can('sppb.new.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('sppb.new.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
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
            ->addColumn('format_price', function($data){
                $action = $data->stock_master->name;
                return "Rp. ".number_format($data->stock_master->harga_jual,0, ",", ".");
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

        $tags = SppbNew::where([
            ['sppb_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['sppb_status','=', 5],
        ])->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->id,
                'text'  => $tag->sppb_no,
                'customer'  => $tag->id_customer,
                'customer_name'  => $tag->customer->name,
                'customer_address' => $tag->customer->address1.' , '.$tag->customer->address2,
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
        if(Auth::user()->can('sppb.new.open')){
            $data = SppbNew::findOrFail($id);
            if($data->sppb_detail->count() < 1)
            {
                return response()->json(['code'=>200,'message' => 'Error, SPPB item empty...', 'stat' => 'Error']);
            }
            $data->sppb_status = 2;
            $data->sppb_open = Carbon::now();
            if($data->po_cust_status == 1){
                $po_internal = PoInternalNew::where('po_no',$data->sppb_po_cust)
                    ->update([
                        'po_status' => 4,
                        'doc_no' => $data->sppb_no,
                        ]);
            }
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Open SPPB Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify1($id)
    {
        if(Auth::user()->can('sppb.verify1')){
            $data = SppbNew::findOrFail($id);
            $data->sppb_status = 3;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'SPPB Verify1 Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    

    public function sppb_movement($data)
    {
        foreach ($data as $detail ) {
            $data = [
                'id_stock_master' => $detail->id_stock_master,
                'id_branch' => $detail->id_branch,
                'move_date' => $detail->sppb->sppb_date,
                // 'bin' => "-",
                'type' => 'SPPB',
                'doc_no' => $detail->sppb->sppb_no,
                'order_qty' => 0,
                'sell_qty' => 0,
                'in_qty' => 0,
                'out_qty' => $detail->qty,
                'harga_modal' => 0,
                'harga_jual' => $detail->price,
                'user' => Auth::user()->name,
                'ket' => 'SPPB Approved at ('.Carbon::now().')',
            ];

            $movement = StockMovement::create($data);
            $stock_master = StockMaster::find($detail->id_stock_master);
            // $stock_master->harga_jual = $detail->price;
            $stock_master->update();
        }
    }

    public function pembatalan($id)
    {
        if(Auth::user()->can('sppb.pembatalan')){
            $data = SppbNew::findOrFail($id);
            // status verify 1 & 2
            if($data->sppb_status == 3 ||  $data->sppb_status == 4 )
            {
                $data->sppb_status = 2;
                $data->update();
                return response()
                    ->json(['code'=>200,'message' => 'SPPB Reject Success', 'stat' => 'Success']);
            }
            if($this->pembatalan_check($data))
            {
                $data->sppb_status = 7;
                $data->update();
                $this->pembatalan_movement($data->sppb_no);
                return response()
                    ->json(['code'=>200,'message' => 'SPPB Reject Success', 'stat' => 'Success']);
            }
            return response()
                    ->json(['code'=>200,'message' => 'Invoice Sudah ada / SPPB tidak bisa di revisi', 'stat' => 'Error']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPPB Access Denied', 'stat' => 'Error']);
    }

    public function pembatalan_check($data)
    {
        $invoice = InvoiceNew::where('id_sppb','=', $data->id )->count();
        if($data->sppb_status == 5 && $invoice < 1 )
        {
            return true;
        }
        return false;
    }

    public function pembatalan_movement($data)
    {
        $stock_movement_sppb = StockMovement::where([
            ['doc_no','=', $data ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->update(['status' => 1, 'ket' => "Pembatalan SPPB"]);
    }
}
