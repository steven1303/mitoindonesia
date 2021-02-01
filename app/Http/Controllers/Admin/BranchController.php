<?php

namespace App\Http\Controllers\Admin;


use App\Models\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Admin\SettingAjaxController;

class BranchController extends SettingAjaxController
{
    //
    public function index()
    {
        $data = [];
        return view('admin.content.branch')->with($data);
    }

    public function store(Request $request)
    {
        // return $request;
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Branch::findOrFail($id);
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
        Branch::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Branch Success Deleted', 'stat' => 'Success']);
    }

    public function recordBranch(){
        $data = Branch::all();
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
