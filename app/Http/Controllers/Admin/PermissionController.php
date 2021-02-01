<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Admin\SettingAjaxController;

class PermissionController extends SettingAjaxController
{
    //
    public function index()
    {
        $data = [];
        return view('admin.content.permission')->with($data);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'name' => $request['permission_name'],
            'for' => $request['permission_for'],
            'stat' => $request['status'],
        ];

        $activity = Permission::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new Permission Success', 'stat' => 'Success']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error Permission Store', 'stat' => 'Error']);
        }
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

        $data = Permission::find($id);
        $data->name    = $request['permission_name'];
        $data->for    = $request['permission_for'];
        $data->stat    = $request['status'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Permission Success', 'stat' => 'Success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Permission::findOrFail($id);
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Permission Success Deleted', 'stat' => 'Success']);
    }

    public function recordPermission(){
        $data = Permission::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $action = "";
                $title = "'".$data->name."'";
                $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button>';
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }
}
