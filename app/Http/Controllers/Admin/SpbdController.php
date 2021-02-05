<?php

namespace App\Http\Controllers\Admin;

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
        $data = [];
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

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'spbd_no' => $request['spbd_no'],
            'id_branch' => Auth::user()->id_branch,
            'spbd_date' => $request['spbd_date'],
            'spbd_user_id' => Auth::user()->id,
            'spbd_user_name' => Auth::user()->name,
            'spbd_status' => 1,
        ];

        $activity = Spbd::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new SPBD Success' , 'stat' => 'Success', 'spbd_id' => $activity->id]);

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
            'id_vendor' => $request['vendor'],
            'keterangan' => $request['keterangan'],
            'id_branch' => Auth::user()->id_branch,
            'spbd_detail_status' => 1,
        ];

        $activity = SpbdDetail::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new item SPBD Success', 'stat' => 'Success']);

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
        $data = Spbd::findOrFail($id);
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
        $data->spbd_no    = $request['spbd_no'];
        $data->spbd_date    = $request['spbd_date'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Stock SPBD Success', 'stat' => 'Success']);
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
            ->json(['code'=>200,'message' => 'Stock Master Success Deleted', 'stat' => 'Success']);
    }

    public function recordSpbd(){
        $data = Spbd::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $spbd_detail = "javascript:ajaxLoad('".route('local.spbd.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->spbd_no."'";
                if($data->spbd_status == 1){
                    $action .= '<a href="'.$spbd_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                }
                $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordSpbd_detail($id){
        $data = SpbdDetail::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['spbd_id','=', $id],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $spbd_detail = "javascript:ajaxLoad('".route('local.spbd.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->spbd_id."'";
                if($data->spbd_status == 1){
                    $action .= '<a href="'.$spbd_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                }
                $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }
}
