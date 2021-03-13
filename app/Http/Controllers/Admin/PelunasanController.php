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
        $data = [];
        return view('admin.content.pelunasan')->with($data);
    }

    public function add_pelunasan($id)
    {
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelunasan = Pelunasan::findOrFail($id);
        $data = array(
            "id" => $pelunasan->id,
            "id_invoice" => $pelunasan->id_inv,
            "inv_no" => $pelunasan->invoice->inv_no,
            "inv_total" => $pelunasan->invoice->inv_detail->sum('total_ppn'),
            "inv_sisa" => $pelunasan->invoice->inv_detail->sum('total_ppn') - $pelunasan->invoice->pelunasan->sum('balance'),
            "balance" => $pelunasan->balance - 0,
            "payment" => $pelunasan->payment_method,
            "note" => $pelunasan->notes,
            "keterangan" => $pelunasan->keterangan,
        );
        return json_encode($data);
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
        $data = [
            'id_branch' => Auth::user()->id_branch,
            'pelunasan_no' => $this->pelunasan_no(),
            'id_inv' => $request['id_invoice'],
            'balance' => preg_replace('/\D/', '',$request['balance']),
            'payment_method' => $request['payment'],
            'notes' => $request['note'],
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = Pelunasan::find($id);
        $data->balance    =  preg_replace('/\D/', '',$request['balance']);
        $data->payment_method    = $request['payment'];
        $data->notes    = $request['note'];
        $data->keterangan    = $request['keterangan'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Pelunasan Success', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pelunasan::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Pelunasan Success Deleted', 'stat' => 'Success']);
    }

    public function recordInvPelunasan(){
        $data = Invoice::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['inv_status','=', 4],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $invoice_detail = "javascript:ajaxLoad('".route('local.inv.detail.index', $data->id)."')";
                $action = "";
                $total_tagihan = $data->inv_detail->sum('total_ppn') - $data->pelunasan->sum('balance') - 0;
                if($data->inv_status == 4 && $total_tagihan != 0){
                    $action .= '<button id="'. $data->id .'" onclick="addPelunasan('. $data->id .')" class="btn btn-info btn-xs"> Add Pelunasan</button> ';
                }
                return $action;
            })
            ->addColumn('sppb_no', function($data){
                return $data->sppb->sppb_no;
            })
            ->addColumn('total_inv', function($data){
                return "Rp. ".number_format($data->inv_detail->sum('total_ppn'),0, ",", ".");
                // return $data->inv_detail->sum('total_ppn');
            })
            ->addColumn('total_pelunasan', function($data){
                $total_tagihan = $data->inv_detail->sum('total_ppn') - $data->pelunasan->sum('balance');
                return "Rp. ".number_format($total_tagihan, 0, ",", ".");
                // return $data->inv_detail->sum('total_ppn');
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordPelunasan(){
        $data = Pelunasan::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                $action = "";
                if($data->status == 1){
                    $title = "'".$data->pelunasan_no."'";
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-primary btn-xs"> Approve</button> ';
                }else{
                    $action .= '<button id="'. $data->id .'" onclick="print_pelunasan('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
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
        $data = Pelunasan::findOrFail($id);
        $data->status = 2;
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Pelunasan Approve Success', 'stat' => 'Success']);
    }
}
