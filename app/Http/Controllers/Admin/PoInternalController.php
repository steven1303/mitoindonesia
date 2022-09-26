<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\PoInternal;
use Illuminate\Http\Request;
use App\Models\PoInternalDetail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class PoInternalController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('po.internal.view')){
            $data = [
            ];
            return view('admin.content.po_internal')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('po.internal.view')){
            $po_internal = PoInternal::findOrFail($id);
            $data = [
                'po_internal' => $po_internal
            ];
            return view('admin.content.po_internal_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function po_internal_no(){
        $tanggal = Carbon::now();
        $format = 'POI/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $po_internal_no = PoInternal::where([
            ['po_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $po_internal_no);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('po.internal.store')){
            $po_draf = PoInternal::where([
                ['po_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            if($po_draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf PO Internal First', 'stat' => 'Warning']);
            }
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'po_no' => $this->po_internal_no(),
                'id_customer' => $request['customer'],
                'doc_no' => "",
                'po_status' => 1,
                'po_user_name' => Auth::user()->name,
                'po_user_id' => Auth::user()->id,
            ];

            $activity = PoInternal::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new PO Internal Success' , 'stat' => 'Success', 'po_id' => $activity->id , 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error PO Internal Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error PO Internal Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(Request $request, $id)
    {
        if(Auth::user()->can('po.internal.store')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_po' => $id,
                'id_stock_master' => $request['stock_master'],
                'qty' => $request['qty'],
                'price' => intval(preg_replace('/,.*|[^0-9]/', '',$request['price'])),
                'disc' => intval(preg_replace('/,.*|[^0-9]/', '',$request['disc'])),
                'keterangan' => $request['keterangan'],
                'po_detail_status' => 1,
            ];

            $activity = PoInternalDetail::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item PO Internal Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item SPPB Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error PO Internal Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('po.internal.update')){
            $data = PoInternal::with('customer')->findOrFail($id);
            return $data;
        }
        return response()->json(['code'=>200,'message' => 'Error PO Internal Access Denied', 'stat' => 'Error']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        if(Auth::user()->can('po.internal.update')){
            $data = PoInternalDetail::with('stock_master')->findOrFail($id);
            return $data;
        }
        return response()->json(['code'=>200,'message' => 'Error PO Internal Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('po.internal.update')){
            $data = PoInternal::find($id);
            $data->id_customer    = $request['customer'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit PO Internal Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error PO Internal Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('po.internal.update')){
            $data = PoInternalDetail::find($id);
            $data->id_stock_master    = $request['stock_master'];
            $data->qty    = $request['qty'];
            $data->price    = preg_replace('/\D/', '',$request['price']);
            $data->disc    = preg_replace('/\D/', '',$request['disc']);
            $data->keterangan    = $request['keterangan'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Item PO Internal Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error PO Internal Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        PoInternalDetail::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'PO Internal Item Success Deleted', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('po.internal.delete')){
            PoInternal::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'PO Internal Success Deleted', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error PO Internal Access Denied', 'stat' => 'Error']);
    }

    public function recordPoInternal(){
        $data = PoInternal::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_po_internal', function($data){
                $po_status = "";
                if($data->po_status == 1){
                    $po_status = "Draft";
                }elseif ($data->po_status == 2) {
                    $po_status = "Request";
                }elseif ($data->po_status == 3) {
                    $po_status = "Approved";
                }elseif ($data->po_status == 4) {
                    $po_status = "Closed";
                }else {
                    $po_status = "Reject";
                }
                return $po_status;
            })
            ->addColumn('action', function($data) use($access){
                $po_internal_detail = "javascript:ajaxLoad('".route('local.po_internal.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->po_no."'";
                if($data->po_status == 1){
                    if($access->can('po.internal.view')){
                        $action .= '<a href="'.$po_internal_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    }
                    if($access->can('po.internal.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('po.internal.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                elseif ($data->po_status == 2){
                    if($access->can('po.internal.view')){
                        $action .= '<a href="'.$po_internal_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('po.internal.approve')){
                        $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    if($access->can('po.internal.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_po_internal('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                else{
                    if($access->can('po.internal.view')){
                        $action .= '<a href="'.$po_internal_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('po.internal.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_po_internal('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordPoInternal_detail($id){

        $data = PoInternalDetail::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['id_po','=', $id],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('price_format', function($data){
                return "Rp. ".number_format($data->price,0, ",", ".");
            })
            ->addColumn('disc_format', function($data){
                return "Rp. ".number_format($data->disc,0, ",", ".");
            })
            ->addColumn('action', function($data) use($access){
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->po_internal->po_status == 1){
                    if($access->can('po.internal.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('po.internal.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->po_internal->po_status == 2){
                    if($access->can('po.internal.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('po.internal.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
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
    public function po_internal_open($id)
    {
        if(Auth::user()->can('po.internal.open')){
            $data = PoInternal::findOrFail($id);
            if($data->po_internal_detail->count() < 1)
            {
                return response()->json(['code'=>200,'message' => 'Error, PO Internal item empty...', 'stat' => 'Error']);
            }
            $data->po_status = 2;
            $data->ppn = 0;
            $data->po_open = Carbon::now();
            if($data->customer->status_ppn == 1){
                $data->ppn = $data->po_internal_detail->sum('total') * 0.11;
            }
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Open PO Stock Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error PO Internal Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        if(Auth::user()->can('po.internal.approve')){
            $data = PoInternal::findOrFail($id);
            $data->po_status = 3;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'PO Internal Approve Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error PO Internal Access Denied', 'stat' => 'Error']);
    }
}
