<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TransferReceipt;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\TransferReceiptDetail;
use App\Http\Controllers\Admin\SettingAjaxController;

class TransferReceiptController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('transfer.view')){
            $data = [];
            return view('admin.content.transfer_receipt')->with($data);
        }
        return view('admin.components.403');
    }

    public function detail($id)
    {
        if(Auth::user()->can('transfer.view')){
            $transfer = TransferReceipt::findOrFail($id);
            $data = [
                'transfer' => $transfer
            ];
            return view('admin.content.transfer_receipt_detail')->with($data);
        }
        return view('admin.components.403');
    }

    public function transfer_receipt_no(){
        $tanggal = Carbon::now();
        $format = 'TR/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $transfer = TransferReceipt::where([
            ['receipt_transfer_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $transfer);
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('transfer.store')){
            $draf = TransferReceipt::where([
                ['receipt_transfer_status','=', 1],
                ['id_branch','=', Auth::user()->id_branch]
            ])->count();

            if($draf > 0){
                return response()
                    ->json(['code'=>200,'message' => 'Use the previous Draf Transfer Receipt First', 'stat' => 'Warning']);
            }
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_transfer' => $request['id_transfer'],
                'receipt_transfer_no' => $this->transfer_receipt_no(),
                'from_branch' => $request['id_branch'],
                'receipt_transfer_date' => Carbon::now(),
                'receipt_transfer_status' => 1,
                'keterangan' => $request['keterangan'],
                'user_id' => Auth::user()->id,
                'user_name' => Auth::user()->name,
            ];

            $activity = TransferReceipt::create($data);

            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new Transfer Receipt Success' , 'stat' => 'Success', 'id' => $activity->id, 'process' => 'add']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error Transfer Receipt Store', 'stat' => 'Error']);
            }
        }
        return response()->json(['code'=>200,'message' => 'Error Transfer Receipt Access Denied', 'stat' => 'Error']);
    }

    public function store_detail(StoreDetailReceiptRequest $request, $id)
    {
        if(Auth::user()->can('transfer.update')){
            $data = [
                'id_branch' => Auth::user()->id_branch,
                'id_rec' => $id,
                'id_po_detail' => $request['id_po_detail'],
                'id_stock_master' => $request['id_stock_master'],
                'order' => $request['qty'],
                'terima' => $request['terima'],
                'bo' => $request['qty'] - $request['terima'],
                'price' => preg_replace('/\D/', '',$request['price']),
                'disc' => preg_replace('/\D/', '',$request['disc']),
                'keterangan' => $request['keterangan'],
                'rec_detail_status' => 1,
            ];
            $activity = RecStockDetail::create($data);
            $po_detail = PoStockDetail::find($request['id_po_detail']);
            $po_detail->rec_qty = $po_detail->rec_detail->sum('terima');
            $po_detail->update();
            if ($activity->exists) {
                return response()
                    ->json(['code'=>200,'message' => 'Add new item PO Stock Success', 'stat' => 'Success', 'process' => 'update']);

            } else {
                return response()
                    ->json(['code'=>200,'message' => 'Error item PO Stock Store', 'stat' => 'Error']);
            }
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Receipt Access Denied', 'stat' => 'Error']);
    }

    public function recordTransferReceipt(){
        $data = TransferReceipt::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_transfer', function($data){
                $status = "";
                if($data->receipt_transfer_status == 1){
                    $status = "Draft";
                }elseif ($data->receipt_transfer_status == 2) {
                    $status = "Request";
                }elseif ($data->receipt_transfer_status == 3) {
                    $status = "Approved";
                }elseif ($data->receipt_transfer_status == 4) {
                    $status = "Closed";
                }else {
                    $status = "Reject";
                }
                return $status;
            })
            ->addColumn('branch_name', function($data){
                return $data->from->city;
            })
            ->addColumn('action', function($data) use($access){
                $transfer_detail = "javascript:ajaxLoad('".route('local.transfer_receipt.detail.index', $data->id)."')";
                $transfer_approve = "javascript:ajaxLoad('".route('local.transfer.approve', $data->id)."')";
                $action = "";
                $title = "'".$data->transfer_no."'";
                if($data->transfer_status == 1){
                    if($access->can('transfer.view')){
                        $action .= '<a href="'.$transfer_detail.'" class="btn btn-warning btn-xs"> Draft</a> ';
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .','.$title.')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('transfer.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                elseif($data->transfer_status == 2){
                    if($access->can('transfer.view')){
                        $action .= '<a href="'.$transfer_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('transfer.approve')){
                        $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    }
                    if($access->can('transfer.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_transfer('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                else{
                    if($access->can('transfer.view')){
                        $action .= '<a href="'.$transfer_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    }
                    if($access->can('transfer.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_transfer('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }

                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    public function recordTransfer_detail($id){


        $data = TransferReceiptDetail::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['id_receipt_transfer','=', $id],
        ])->latest()->get();

        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data) use($access){
                $action = "";
                $title = "'".$data->stock_master->name."'";

                if($data->transfer_receipt->receipt_transfer_status == 1){
                    if($access->can('transfer.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('transfer.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                if($data->transfer->receipt_transfer_status == 2){
                    if($access->can('transfer.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('transfer.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                }
                return $action;
            })
            ->addColumn('nama_stock', function($data){
                $action = $data->stock_master->name;
                return $action;
            })
            ->addColumn('format_harga', function($data){
                return "Rp. ".number_format($data->price,0, ",", ".");
            })
            ->addColumn('format_total', function($data){
                return "Rp. ".number_format($data->total,0, ",", ".");
            })
            ->addColumn('satuan', function($data){
                $action = $data->stock_master->satuan;
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }
}
