<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class VendorController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('vendor.view')){
            $data = [];
            return view('admin.content.vendor')->with($data);
        }
        return view('admin.components.403');
    }

    public function info($id)
    {
        if(Auth::user()->can('vendor.info')){
            $vendor = Vendor::findOrFail($id);
            $data = [
                'vendor' => $vendor
            ];
            return view('admin.content.vendor_info')->with($data);
        }
        return view('admin.components.403');
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('vendor.store')){
            $ppn_status = 0;
            if($request->has('status_ppn')){
                $ppn_status = 1;
            }
            $data = [
                'name' => $request['name'],
                'email' => $request['email'],
                'address1' => $request['address1'],
                'address2' => $request['address2'],
                'city' => $request['city'],
                'phone' => $request['phone'],
                'pic' => $request['pic'],
                'telp' => $request['telp'],
                'npwp' => $request['npwp'],
                'status_ppn' => $ppn_status,
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
        return response()
            ->json(['code'=>200,'message' => 'Error Vendor Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('vendor.update')){
            $ppn_status = 0;
            if($request->has('status_ppn')){
                $ppn_status = 1;
            }
            $data = Vendor::find($id);
            $data->name    = $request['name'];
            $data->address1    = $request['address1'];
            $data->address2   = $request['address2'];
            $data->city = $request['city'];
            $data->phone    = $request['phone'];
            $data->npwp    = $request['npwp'];
            $data->pic = $request['pic'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->status_ppn = $ppn_status;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Vendor Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Vendor Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('vendor.update')){
            $data = Vendor::findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Vendor Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('vendor.delete')){
            Vendor::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Vendor Success Deleted', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Vendor Access Denied', 'stat' => 'Error']);
    }

    public function recordVendor(){
        if(Auth::user()->can('vendor.view')){
            $data = Vendor::where('id_branch','=', Auth::user()->id_branch)->get();
            $access =  Auth::user();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data) use($access){
                    $vendor_detail = "javascript:ajaxLoad('".route('local.vendor.info', $data->id)."')";
                    $action = "";
                    $title = "'".$data->name."'";
                    if($access->can('vendor.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('vendor.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                    if($access->can('vendor.info')){
                        $action .= '<a href="'.$vendor_detail.'" class="btn btn-warning btn-xs"> Info</a> ';
                    }
                    return $action;
                })
                ->rawColumns(['action'])->make(true);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Vendor Access Denied', 'stat' => 'Error']);
    }

    public function po_stock($id){
        if(Auth::user()->can('vendor.info')){
            $data = Vendor::findOrFail($id);
            return DataTables::of($data->po_stock)
                ->addIndexColumn()
                ->addColumn('status', function($data){
                    $po_status = "";
                    if($data->po_status == 1){
                        $po_status = "Draft";
                    }elseif ($data->po_status == 2) {
                        $po_status = "Request";
                    }elseif ($data->po_status == 3) {
                        $po_status = "Verified";
                    }elseif ($data->po_status == 4) {
                        $po_status = "Approved";
                    }elseif ($data->po_status == 5) {
                        $po_status = "Partial";
                    }elseif ($data->po_status == 6) {
                        $po_status = "Closed";
                    }else {
                        $po_status = "Reject";
                    }
                    return $po_status;
                })
                ->addColumn('action', function($data){
                    $action = "";
                    return $action;
                })
                ->addColumn('item', function($data){
                    return $data->po_stock_detail->count();
                })
                ->addColumn('spbd_no', function($data){
                    return $data->spbd->spbd_no;
                })
                ->addColumn('total_harga', function($data){
                    return "Rp. ".number_format(($data->po_stock_detail->sum('total') + $data->ppn),0, ",", ".");
                })
                ->rawColumns(['action'])->make(true);
        }
            return response()
                ->json(['code'=>200,'message' => 'Error Vendor Access Denied', 'stat' => 'Error']);
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
