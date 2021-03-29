<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Spb;
use App\Models\SpbDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class SpbController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('spb.view')){
            $data = [];
            return view('admin.content.spb')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('spb.view')){
            $spb = Spb::findOrFail($id);
            $data = [
                'spb' => $spb
            ];
            return view('admin.content.spb_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function spb_no(){
        $tanggal = Carbon::now();
        $format = 'SPB/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $spb_no = Spb::where([
            ['spb_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $spb_no);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('spb.store')){
            $draf = Spb::where([
                ['spb_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();
            if($draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf SPB First', 'stat' => 'Warning']);
            }
            $data = [
                'spb_no' => $this->spb_no(),
                'id_branch' => Auth::user()->id_branch,
                'id_vendor' => $request['vendor'],
                'spb_date' => Carbon::now(),
                'spb_user_id' => Auth::user()->id,
                'spb_user_name' => Auth::user()->name,
                'spb_status' => 1,
            ];
            $activity = Spb::create($data);
            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new SPB Success' , 'stat' => 'Success', 'spb_id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error SPB Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPB Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(Request $request, $id)
    {
        if(Auth::user()->can('spb.store')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'spb_id' => $id,
                'keterangan' => $request['keterangan'],
                'qty' => $request['qty'],
                'satuan' => $request['satuan'],
                'spb_detail_status' => 1,
            ];

            $activity = SpbDetail::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item SPB Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item SPB Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('spb.update')){
            $data = Spb::with('vendor')->findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPB Access Denied', 'stat' => 'Error']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        if(Auth::user()->can('spb.update')){
            $data = SpbDetail::findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPB Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('spb.update')){
            $data = Spb::find($id);
            $data->id_vendor    = $request['vendor'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit SPB Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPB Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('spb.update')){
            $data = SpbDetail::find($id);
            $data->keterangan    = $request['keterangan'];
            $data->qty    = $request['qty'];
            $data->satuan    = $request['satuan'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Item SPB Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('spb.delete')){
            Spb::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'SPB Success Deleted', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPB Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        SpbDetail::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'SPB Detail Success Deleted', 'stat' => 'Success']);
    }

    public function recordSpb(){
        $data = Spb::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_spb', function($data){
                $spb_status = "";
                if($data->spb_status == 1){
                    $spb_status = "Draft";
                }elseif ($data->spb_status == 2) {
                    $spb_status = "Request";
                }elseif ($data->spb_status == 3) {
                    $spb_status = "Approved";
                }elseif ($data->spb_status == 4) {
                    $spb_status = "Closed";
                }else {
                    $spb_status = "Reject";
                }
                return $spb_status;
            })
            ->addColumn('action', function($data) use($access){
                $spb_detail = "javascript:ajaxLoad('".route('local.spb.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->spb_no."'";
                if($data->spb_status == 1){
                    if($access->can('spb.view')){
                        $action .= '<a href="'.$spb_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    }
                    if($access->can('spb.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('spb.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                elseif($data->spb_status == 2){
                    if($access->can('spb.view')){
                        $action .= '<a href="'.$spb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('spb.approve')){
                        $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    if($access->can('spb.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_spb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                else{
                    if($access->can('spb.view')){
                        $action .= '<a href="'.$spb_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('spb.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_spb('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }

                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordSpb_detail($id, $po_stat = NULL){
        if($po_stat == 1){
            $data = SpbDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['spb_id','=', $id],
                ['spb_detail_status','=', 1],
            ])->latest()->get();
        }else{
            $data = SpbDetail::where([
                ['id_branch','=', Auth::user()->id_branch],
                ['spb_id','=', $id],
            ])->latest()->get();
        }
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data)  use($po_stat, $access){
                $action = "";
                $title = "'".$data->keterangan."'";
                if($data->spb->spb_status == 1){
                    if($access->can('spb.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('spb.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->spb->spb_status == 2){
                    if($access->can('spb.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                }
                if($po_stat == 1){
                    $action .= '<button id="'. $data->id .'" onclick="addItem('. $data->id .')" class="btn btn-info btn-xs"> Add Item</button> ';
                }
                return $action;
            })
            ->addColumn('satuan', function($data){
                $action = $data->satuan;
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
    public function searchSpb(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $tags = Spb::where([
            ['spb_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['spb_status','=', 3],
        ])->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->id,
                'text'  => $tag->spb_no,
                'vendor'  => $tag->id_vendor,
                'vendor_name'  => $tag->vendor->name,
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
    public function spb_open($id)
    {
        if(Auth::user()->can('spb.open')){
            $data = Spb::findOrFail($id);
            $data->spb_status = 2;
            $data->spb_open = Carbon::now();
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Open SPB Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPB Access Denied', 'stat' => 'Error']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        if(Auth::user()->can('spb.approve')){
            $data = Spb::findOrFail($id);
            $data->spb_status = 3;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'SPB Approve Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error SPB Access Denied', 'stat' => 'Error']);
    }
}
