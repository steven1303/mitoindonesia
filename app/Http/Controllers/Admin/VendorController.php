<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VendorController extends SettingAjaxController
{
    public function index()
    {
        $data = [];
        return view('admin.content.vendor')->with($data);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'name' => $request['name'],
            'address1' => $request['address1'],
            'address2' => $request['address2'],
            'city' => $request['city'],
            'phone' => $request['phone'],
            'npwp' => $request['npwp'],
            'id_branch' => Auth::user()->id_branch,
        ];

        $activity = Vendor::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new Vendor Success', 'stat' => 'Success']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error Vendor Store', 'stat' => 'Error']);
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

        $data = Vendor::find($id);
        $data->name    = $request['name'];
        $data->address1    = $request['address1'];
        $data->address2   = $request['address2'];
        $data->city = $request['city'];
        $data->phone    = $request['phone'];
        $data->npwp    = $request['npwp'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Vendor Success', 'stat' => 'Success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Vendor::findOrFail($id);
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
        Vendor::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Customer Success Deleted', 'stat' => 'Success']);
    }

    public function recordVendor(){
        $data = Vendor::where('id_branch','=', Auth::user()->id_branch)->get();
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

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchVendor(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $tags = Vendor::where([
            ['name','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->id,
                'text'  => $tag->name,
            ];
        }

        return response()->json($formatted_tags);
    }
}
