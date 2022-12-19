<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\InvoiceNew;
use App\Http\Controllers\Admin\SettingAjaxController;

class InvoiceNewController extends SettingAjaxController
{
    use InvoiceNew;
    public function index()
    {
        if(Auth::user()->can('invoice.view')){
            $data = [];
            return view('admin.content.inv_new')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('invoice.view')){
            $inv = Invoice::findOrFail($id);
            $data = [
                'invoice' => $inv
            ];
            return view('admin.content.inv_detail_new')->with($data);
        }
        return view('admin.components.403');
    }

    public function inv_no(){
        $tanggal = Carbon::now();
        $format = 'INV/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $inv_no = Invoice::where([
            ['inv_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $inv_no);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('invoice.store')){
            $draf = Invoice::where([
                ['inv_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            $sppb = Invoice::where([
                ['id_sppb','=', $request['sppb']],
                ['id_branch','=', Auth::user()->id_branch],
                ['inv_status','<>', 8]
            ])->count();

            if($sppb > 0){
                return response()
                    ->json(['code'=>200,'message' => 'SPPB is already used', 'stat' => 'Error']);
            }

            if($draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf Invoice First', 'stat' => 'Error']);
            }

            $customer = Customer::find($request['customer']);

            $data = [
                'id_branch' => Auth::user()->id_branch,
                'inv_no' => $this->inv_no(),
                'id_sppb' => 0,
                'id_customer' => $request['customer'],
                'po_cust' => 'Null',
                'inv_kirimke' => $customer->address1,
                'inv_alamatkirim' => $customer->address1,
                'mata_uang' => "RUPIAH",
                'date' => Carbon::now(),
                'top_date' => Carbon::now(),
                'inv_status' => 1,
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
            ];

            $activity = Invoice::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new Invoice Success' , 'stat' => 'Success', 'inv_id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error Invoice Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    public function update($id, Request $request){
        if(Auth::user()->can('invoice.update')){
            $data = Invoice::find($id);
            $data->top_date    = $request['top_date'];
            $data->po_cust    = $request['po_cust'];
            $data->mata_uang    = $request['mata_uang'];
            $data->inv_alamatkirim    = $request['inv_alamatkirim'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Invoice Detail Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    public function destroy($id)
    {
        if(Auth::user()->can('invoice.delete')){
            Invoice::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Invoice Success Deleted', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Invoice Access Denied', 'stat' => 'Error']);
    }

    public function recordInv(){
        $data = Invoice::where([
            ['id_sppb','=', 0],
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_inv', function($data){
                $action = "";
                if($data->inv_status == 1){
                    $action = "Draf";
                }elseif($data->inv_status == 2){
                    $action = "Request";
                }elseif($data->inv_status == 3){
                    $action = "Verified 1";
                }elseif($data->inv_status == 4){
                    $action = "Verified 2";
                }elseif($data->inv_status == 5){
                    $action = "Approved";
                }elseif($data->inv_status == 6){
                    $action = "Partial";
                }elseif($data->inv_status == 7){
                    $action = "Closed";
                }
                else{
                    $action = "Batal";
                }
                return $action;
            })
            ->addColumn('action', function($data) use($access){
                return $this->button_list1($data, $access);
            })
            ->addColumn('total_inv', function($data){
                // return $data->inv_detail->sum('total_ppn');
                return "Rp. ".number_format($data->inv_detail->sum('total_ppn'),0, ",", ".");
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordListSppb($invoice){

    }
}
