<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class CustomerController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('customer.view')){
            $data = [];
            return view('admin.content.customer')->with($data);
        }
        return view('admin.components.403');
    }

    public function info($id)
    {
        if(Auth::user()->can('customer.info')){
            $customer = Customer::findOrFail($id);
            $data = [
                'customer' => $customer
            ];
            return view('admin.content.customer_info')->with($data);
        }
        return view('admin.components.403');
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('customer.store')){
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
                'npwp' => $request['npwp'],
                'ktp' => $request['ktp'],
                'bod' => $request['bod'],
                'pic' => $request['pic'],
                'telp' => $request['telp'],
                'status_ppn' => $ppn_status,
                'id_branch' => Auth::user()->id_branch,
            ];
            $activity = Customer::create($data);
            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new Customer Success', 'stat' => 'Success']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error Customer Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Customer Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('customer.update')){
            $ppn_status = 0;
            if($request->has('status_ppn')){
                $ppn_status = 1;
            }
            $data = Customer::find($id);
            $data->name    = $request['name'];
            $data->address1    = $request['address1'];
            $data->address2   = $request['address2'];
            $data->city = $request['city'];
            $data->phone    = $request['phone'];
            $data->npwp    = $request['npwp'];
            $data->ktp    = $request['ktp'];
            $data->bod    = $request['bod'];
            $data->pic = $request['pic'];
            $data->telp = $request['telp'];
            $data->email = $request['email'];
            $data->status_ppn = $ppn_status;
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Customer Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Customer Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('customer.update')){
            $data = Customer::findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Customer Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('customer.delete')){
            Customer::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Customer Success Deleted', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Customer Access Denied', 'stat' => 'Error']);
    }

    public function recordCustomer(){
        if(Auth::user()->can('customer.view')){
            $data = Customer::where('id_branch','=', Auth::user()->id_branch)->get();
            $access =  Auth::user();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data) use($access){
                    $invoice_detail = "javascript:ajaxLoad('".route('local.customer.info', $data->id)."')";
                    $action = "";
                    $title = "'".$data->name."'";
                    if($access->can('customer.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('customer.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                    if($access->can('customer.info')){
                        $action .= '<a href="'.$invoice_detail.'" class="btn btn-warning btn-xs"> Info</a> ';
                    }
                    return $action;
                })
                ->addColumn('piutang', function($data){
                    // $check = $data->invoice->count();
                    // $piutang = 0;
                    // if($check > 0){
                    //     $piutang = $data->invoice->get()->inv_detail->sum('total_ppn') - $data->invoice->get()->pelunasan->sum('balance');
                    // }
                    // if($piutang > 0){
                    //     $piutang = $piutang - 0;
                    // }
                    return "Rp. ".number_format($data->total_ppn,0, ",", ".");
                })
                ->rawColumns(['action'])->make(true);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Customer Access Denied', 'stat' => 'Error']);
    }

    public function invoice($id){
        if(Auth::user()->can('customer.info')){
            $data = Customer::findOrFail($id);
            return DataTables::of($data->invoice)
                ->addIndexColumn()
                ->addColumn('status', function($data){
                    $action = "";
                    if($data->inv_status == 1){
                        $action = "Draf";
                    }elseif($data->inv_status == 2){
                        $action = "Request";
                    }elseif($data->inv_status == 3){
                        $action = "Verified";
                    }elseif($data->inv_status == 4){
                        $action = "Approved";
                    }elseif($data->inv_status == 5){
                        $action = "Partial";
                    }elseif($data->inv_status == 6){
                        $action = "Closed";
                    }else{
                        $action = "Batal";
                    }
                    return $action;
                })
                ->addColumn('action', function($data){
                    $action = "";
                    return $action;
                })
                ->addColumn('total_harga', function($data){
                    return "Rp. ".number_format($data->inv_detail->sum('total_ppn'),0, ",", ".");
                })
                ->addColumn('item', function($data){
                    return $data->inv_detail->count();
                })
                ->rawColumns(['action'])->make(true);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Customer Access Denied', 'stat' => 'Error']);
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchCustomer(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $tags = Customer::where([
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
