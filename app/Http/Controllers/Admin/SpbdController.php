<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Spbd;
use App\Models\SpbdDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class SpbdController extends SettingAjaxController
{
    public function index()
    {
        $data = [
            'spbd_no' => $this->spbd_no()
        ];
        return view('admin.content.spbd')->with($data);
    }

    public function detail($id)
    {
        $spbd = Spbd::findOrFail($id);
        $data = [
            'spbd' => $spbd
        ];
        return view('admin.content.spbd_detail')->with($data);
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

    public function store_detail(Request $request, $id)
    {
        // return $request;
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Spbd::with('vendor')->findOrFail($id);
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
        $data = SpbdDetail::with('stock_master')->findOrFail($id);
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

        $data = Spbd::find($id);
        // $data->spbd_no    = $request['spbd_no'];
        $data->id_vendor    = $request['vendor'];
        // $data->spbd_date    = Carbon::now();
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit SPBD Success', 'stat' => 'Success']);
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
        $data = SpbdDetail::find($id);
        $data->id_stock_master    = $request['stock_master'];
        $data->qty    = $request['qty'];
        $data->keterangan    = $request['keterangan'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Item SPBD Success', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Spbd::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'SPBD Success Deleted', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        SpbdDetail::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'SPBD Detail Success Deleted', 'stat' => 'Success']);
    }

    public function recordSpbd(){
        $data = Spbd::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
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
            ->addColumn('action', function($data){
                $spbd_detail = "javascript:ajaxLoad('".route('local.spbd.detail.index', $data->id)."')";
                $spbd_approve = "javascript:ajaxLoad('".route('local.spbd.approve', $data->id)."')";
                $action = "";
                $title = "'".$data->spbd_no."'";
                if($data->spbd_status == 1){
                    $action .= '<a href="'.$spbd_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                elseif($data->spbd_status == 2){
                    $action .= '<a href="'.$spbd_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="print_spbd('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                }
                else{
                    $action .= '<a href="'.$spbd_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="print_spbd('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
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
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data)  use($po_stat){
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->spbd->spbd_status == 1){
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                if($data->spbd->spbd_status == 2){
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
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
        $data = Spbd::findOrFail($id);
        $data->spbd_status = 2;
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Open SPBD Success', 'stat' => 'Success']);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $data = Spbd::findOrFail($id);
        $data->spbd_status = 3;
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'SPBD Approve Success', 'stat' => 'Success']);
    }
}
