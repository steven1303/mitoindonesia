<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Pelunasan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class PelunasanController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('pelunasan.view')){
            $data = [];
            return view('admin.content.pelunasan')->with($data);
        }
        return view('admin.components.403');
    }

    public function add_pelunasan($id)
    {
        if(Auth::user()->can('pelunasan.store')){
            $inv = Invoice::findOrFail($id);
            $data = array(
                "id" => $inv->id,
                "inv_no" => $inv->inv_no,
                "inv_total" => $inv->inv_detail->sum('total_ppn'),
                "inv_sisa" => $inv->inv_detail->sum('total_ppn') - $inv->pelunasan->sum('balance'),
            );
            return json_encode($data);
            return true;
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
        if(Auth::user()->can('pelunasan.update')){
            $pelunasan = Pelunasan::findOrFail($id);
            $data = array(
                "id" => $pelunasan->id,
                "id_invoice" => $pelunasan->id_inv,
                "inv_no" => $pelunasan->invoice->inv_no,
                "inv_total" => $pelunasan->invoice->inv_detail->sum('total_ppn'),
                "inv_sisa" => $pelunasan->invoice->inv_detail->sum('total_ppn') - $pelunasan->invoice->pelunasan->sum('balance'),
                "balance" => $pelunasan->balance - 0,
                "payment" => $pelunasan->payment_method,
                "pelunasan_date" => $pelunasan->pelunasan_date,
                "note" => $pelunasan->notes,
                "keterangan" => $pelunasan->keterangan,
            );
            return json_encode($data);
        }
        return response()->json(['code'=>200,'message' => 'Error Pelunasan Access Denied', 'stat' => 'Error']);
    }

    public function pelunasan_no(){
        $tanggal = Carbon::now();
        $format = 'CRN/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $pelunasan_no = Pelunasan::where([
            ['pelunasan_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $pelunasan_no);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('pelunasan.store')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'pelunasan_no' => $this->pelunasan_no(),
                'id_inv' => $request['id_invoice'],
                'balance' => preg_replace('/\D/', '',$request['balance']),
                'payment_method' => $request['payment'],
                'pelunasan_date' => $request['pelunasan_date'],
                'keterangan' => $request['keterangan'],
                'user_name' => Auth::user()->name,
                'user_id' => Auth::user()->id,
                'status' => 1,
            ];
            $activity = Pelunasan::create($data);
            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new Pelunasan Success' , 'stat' => 'Success', 'inv_id' => $activity->id ]);
            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error Pelunasan Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error Pelunasan Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('pelunasan.update')){
            $data = Pelunasan::find($id);
            $data->balance    =  preg_replace('/\D/', '',$request['balance']);
            $data->payment_method    = $request['payment'];
            $data->pelunasan_date    = $request['pelunasan_date'];
            $data->keterangan    = $request['keterangan'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Pelunasan Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Pelunasan Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('pelunasan.delete')){
            Pelunasan::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Pelunasan Success Deleted', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Pelunasan Access Denied', 'stat' => 'Error']);
    }

    public function recordInvPelunasan(){
        $data = Invoice::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['inv_status','=', 4],
        ])->orWhere([
            ['id_branch','=', Auth::user()->id_branch],
            ['inv_status','=', 5],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data) use($access){
                $invoice_detail = "javascript:ajaxLoad('".route('local.inv.detail.index', $data->id)."')";
                $action = "";
                $total_tagihan = $data->inv_detail->sum('total_ppn') - $data->pelunasan->sum('balance') - 0;
                if($data->inv_status == 4 && $total_tagihan != 0){
                    if($access->can('pelunasan.store')){
                        $action .= '<button id="'. $data->id .'" onclick="addPelunasan('. $data->id .')" class="btn btn-info btn-xs"> Add Pelunasan</button> ';
                    }
                }
                if($data->inv_status == 5 && $total_tagihan != 0){
                    if($access->can('pelunasan.store')){
                        $action .= '<button id="'. $data->id .'" onclick="addPelunasan('. $data->id .')" class="btn btn-info btn-xs"> Add Pelunasan</button> ';
                    }
                }
                return $action;
            })
            ->addColumn('sppb_no', function($data){
                return $data->sppb->sppb_no;
            })
            ->addColumn('total_inv', function($data){
                return "Rp. ".number_format($data->inv_detail->sum('total_ppn'),0, ",", ".");
            })
            ->addColumn('total_pelunasan', function($data){
                $total_tagihan = $data->inv_detail->sum('total_ppn') - $data->pelunasan->sum('balance');
                return "Rp. ".number_format($total_tagihan, 0, ",", ".");
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordPelunasan(){
        $data = Pelunasan::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data) use($access){
                $action = "";
                if($data->status == 1){
                    $title = "'".$data->pelunasan_no."'";
                    if($access->can('pelunasan.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('pelunasan.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                    if($access->can('pelunasan.approve')){
                        $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-primary btn-xs"> Approve</button> ';
                    }
                }else{
                    if($access->can('pelunasan.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_pelunasan('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                return $action;
            })
            ->addColumn('invoice_no', function($data){
                return $data->invoice->inv_no;
            })
            ->addColumn('format_balance', function($data){
                return "Rp. ".number_format($data->balance,0, ",", ".");
            })
            ->addColumn('tanggal', function($data){
                return $data->created_at->isoFormat('D MMMM Y');
            })
            ->rawColumns(['action'])->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        if(Auth::user()->can('pelunasan.approve')){
            $data = Pelunasan::findOrFail($id);
            $data->status = 2;
            if($data->invoice->inv_detail->sum('total_ppn') == $data->invoice->pelunasan->sum('balance') ){
                $data->invoice->inv_status = 6;
                $data->invoice->update();
            }else{
                $data->invoice->inv_status = 5;
                $data->invoice->update();
            }
            $data->pelunasan_open = Carbon::now();
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Pelunasan Approve Success', 'stat' => 'Success']);
        }
        return response()->json(['code'=>200,'message' => 'Error Pelunasan Access Denied', 'stat' => 'Error']);
    }
}
