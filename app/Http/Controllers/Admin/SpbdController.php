<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Spbd;
use App\Models\PoStock;
use App\Models\SpbdDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class SpbdController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('spbd.view')){
            $data = [
                // 'spbd_no' => $this->spbd_no()
            ];
            return view('admin.content.spbd')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('spbd.view')){
            $spbd = Spbd::findOrFail($id);
            $data = [
                'spbd' => $spbd
            ];
            return view('admin.content.spbd_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function spbd_no(){
        $tanggal = Carbon::now();
        $format = 'SPBD/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $spbd_no = Spbd::where([
            ['spbd_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $spbd_no);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('spbd.store')){
            $spbd_draf = Spbd::where([
                ['spbd_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            if($spbd_draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf SPBD First', 'stat' => 'Warning']);
            }
            $data = [
                'spbd_no' => $this->spbd_no(),
                'id_branch' => Auth::user()->id_branch,
                'id_vendor' => $request['vendor'],
                'spbd_date' => Carbon::now(),
                'spbd_user_id' => Auth::user()->id,
                'spbd_user_name' => Auth::user()->name,
                'spbd_status' => 1,
            ];

            $activity = Spbd::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new SPBD Success' , 'stat' => 'Success', 'spbd_id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error SPBD Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(Request $request, $id)
    {
        if(Auth::user()->can('spbd.store')){
            $data = [
                'spbd_id' => $id,
                'id_stock_master' => $request['stock_master'],
                'qty' => $request['qty'],
                'keterangan' => $request['keterangan'],
                'id_branch' => Auth::user()->id_branch,
                'spbd_detail_status' => 1,
            ];

            $activity = SpbdDetail::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item SPBD Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item SPBD Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('spbd.update')){
            $data = Spbd::with('vendor')->findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        if(Auth::user()->can('spbd.update') || Auth::user()->can('po.stock.store')){
            $data = SpbdDetail::with('stock_master')->findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('spbd.update')){
            $data = Spbd::find($id);
            // $data->spbd_no    = $request['spbd_no'];
            $data->id_vendor    = $request['vendor'];
            // $data->spbd_date    = Carbon::now();
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit SPBD Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('spbd.update')){
            $data = SpbdDetail::find($id);
            $data->id_stock_master    = $request['stock_master'];
            $data->qty    = $request['qty'];
            $data->keterangan    = $request['keterangan'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Item SPBD Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('spbd.delete')){
            Spbd::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'SPBD Success Deleted', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        if(Auth::user()->can('spbd.delete')){
            SpbdDetail::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'SPBD Detail Success Deleted', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
    }

    public function recordSpbd(){
        $data = Spbd::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_spbd', function($data){
                $spbd_status = "";
                if($data->spbd_status == 1){
                    $spbd_status = "Draft";
                }elseif ($data->spbd_status == 2) {
                    $spbd_status = "Request";
                }elseif ($data->spbd_status == 3) {
                    $spbd_status = "Approved";
                }elseif ($data->spbd_status == 4) {
                    $spbd_status = "Closed";
                }else {
                    $spbd_status = "Reject";
                }
                return $spbd_status;
            })
            ->addColumn('action', function($data) use($access){
                $spbd_detail = "javascript:ajaxLoad('".route('local.spbd.detail.index', $data->id)."')";
                $spbd_approve = "javascript:ajaxLoad('".route('local.spbd.approve', $data->id)."')";
                $action = "";
                $title = "'".$data->spbd_no."'";
                if($data->spbd_status == 1){
                    if($access->can('spbd.view')){
                        $action .= '<a href="'.$spbd_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    }
                    if($access->can('spbd.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('spbd.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                elseif($data->spbd_status == 2){
                    if($access->can('spbd.view')){
                        $action .= '<a href="'.$spbd_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('spbd.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('spbd.approve')){
                        $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    // matikan fungsi print saat spbd masih request
                    // if($access->can('spbd.print')){
                    //     $action .= '<button id="'. $data->id .'" onclick="print_spbd('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    // }
                    // matikan fungsi print saat spbd masih requests
                }
                else{
                    if($access->can('spbd.view')){
                        $action .= '<a href="'.$spbd_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('spbd.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_spbd('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordSpbd_detail($id, $po_stat = NULL){
        if($po_stat == 1){
            $data = SpbdDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['spbd_id','=', $id],
            ])->whereRaw('spbd_details.qty <> spbd_details.po_qty')->latest()->get();
        }else{
            $data = SpbdDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['spbd_id','=', $id],
            ])->latest()->get();
        }
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data)  use($po_stat, $access){
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->spbd->spbd_status == 1){
                    if($access->can('spbd.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('spbd.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->spbd->spbd_status == 2){
                    if($access->can('spbd.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('spbd.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($po_stat == 1){
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
    public function searchSpbd(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $tags = Spbd::where([
            ['spbd_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['spbd_status','=', 3],
        ])->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->id,
                'text'  => $tag->spbd_no,
                'vendor'  => $tag->id_vendor,
                'vendor_name'  => $tag->vendor->name,
                'ppn'  => $tag->vendor->ppn,
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
    public function spbd_open($id)
    {
        if(Auth::user()->can('spbd.open')){
            $data = Spbd::findOrFail($id);
            if($data->spbd_detail->count() < 1)
            {
                return response()->json(['code'=>200,'message' => 'Error, SPBD item empty...', 'stat' => 'Error']);
            }
            $data->spbd_status = 2;
            $data->spbd_open = Carbon::now();
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Open SPBD Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        if(Auth::user()->can('spbd.approve')){
            $data = Spbd::findOrFail($id);
            $data->spbd_status = 3;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'SPBD Approve Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPBD Access Denied', 'stat' => 'Error']);
    }

    public function pembatalan($id)
    {
        $data = Spbd::findOrFail($id);
        if($this->pembatalan_check($data))
        {
            $data->spbd_status = 2;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'SPBD Reject Success', 'stat' => 'Success']);
        }
        return response()
                ->json(['code'=>200,'message' => 'PO Stock Sudah ada / SPBD tidak bisa di revisi', 'stat' => 'Error']);
    }

    public function pembatalan_check($data)
    {
        $po_stock = PoStock::where('id_spbd','=', $data->id )->count();
        if($data->spbd_status == 3 && $po_stock < 1 )
        {
            return true;
        }
        return false;
        
    }
}
