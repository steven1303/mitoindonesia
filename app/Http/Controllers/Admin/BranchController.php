<?php

namespace App\Http\Controllers\Admin;


use App\Models\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class BranchController extends SettingAjaxController
{
    //
    public function index()
    {
        if(Auth::user()->can('branch.view')){
            $data = [];
            return view('admin.content.branch')->with($data);
        }
        return view('admin.components.403');
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('branch.store')){
            $data = [
                'name' => $request['name'],
                'city' => $request['city'],
                'address' => $request['address'],
                'phone' => $request['phone'],
                'npwp' => $request['npwp'],
            ];
            $activity = Branch::create($data);
            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new Branch Success', 'stat' => 'Success']);
            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error Branch Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Branch Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('branch.update')){
            $data = Branch::find($id);
            $data->name    = $request['name'];
            $data->city = $request['city'];
            $data->address    = $request['address'];
            $data->phone    = $request['phone'];
            $data->npwp    = $request['npwp'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Branch Success', 'stat' => 'Success']);
        }
        return response()
        ->json(['code'=>200,'message' => 'Error Branch Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('branch.update')){
            $data = Branch::findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Branch Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('branch.delete')){
            Branch::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Branch Success Deleted', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Branch Access Denied', 'stat' => 'Error']);
    }

    public function recordBranch(){
        if(Auth::user()->can('branch.view')){
            $data = Branch::all();
            $access =  Auth::user();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data)  use($access){
                    $action = "";
                    $title = "'".$data->name."'";
                    if($access->can('branch.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('branch.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button>';
                    }
                    return $action;
                })
                ->rawColumns(['action'])->make(true);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Branch Access Denied', 'stat' => 'Error']);
    }
}
