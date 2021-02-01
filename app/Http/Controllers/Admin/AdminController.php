<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Admin;
use App\Models\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\SettingAjaxController;

class AdminController extends SettingAjaxController
{
    //
    public function index()
    {
        $role = Role::all();
        $branch = Branch::all();
        $data = [
            'roles' => $role,
            'branches' => $branch,
        ];
        return view('admin.content.admin')->with($data);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'username' => $request['username'],
            'password' => Hash::make($request['password']),
            'name' => $request['nama'],
            'email' => $request['email'],
            'id_role' => $request['role'],
            'id_branch' => $request['branch'],
        ];

        $activity = Admin::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new Admin Success', 'stat' => 'Success']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error Admin Store', 'stat' => 'Error']);
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

        $admin = Admin::find($id);
        $admin->name    = $request['nama'];
        $admin->username = $request['username'];
        $admin->email    = $request['email'];
        $admin->id_role    = $request['role'];
        $admin->id_branch    = $request['branch'];
        if($request->get('password') != NULL || $request->get('password') != "" ){
            $admin->password = Hash::make($request['password']);
        }
        $admin->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Admin Success', 'stat' => 'Success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return $admin;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Admin Success Deleted', 'stat' => 'Success']);
    }

    public function recordAdmin(){
        $admin = Admin::all();
        return DataTables::of($admin)
            ->addIndexColumn()
            ->addColumn('action', function($admin){
                $action = "";
                $title = "'".$admin->username."'";
                $action .= '<button id="'. $admin->id .'" onclick="editForm('. $admin->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                $action .= '<button id="'. $admin->id .'" onclick="deleteData('. $admin->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button>';
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }
}
