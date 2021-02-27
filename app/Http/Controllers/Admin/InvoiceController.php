<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Sppb;
use App\Models\Invoice;
use App\Models\SppbDetail;
use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\StockMovement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class InvoiceController extends SettingAjaxController
{
    public function index()
    {
        $data = [];
        return view('admin.content.inv')->with($data);
    }

    public function detail($id)
    {
        $inv = Invoice::findOrFail($id);
        $data = [
            'invoice' => $inv
        ];
        return view('admin.content.inv_detail')->with($data);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inv = Invoice::findOrFail($id);
        $data = array(
            "id" => $inv->id,
            "datemask2" => $inv->top_date,
            "sppb" => $inv->id_sppb,
            "sppb_no" => $inv->sppb->sppb_no,
            "customer_name" => $inv->sppb->customer->name,
            "customer" => $inv->id_customer,
            "po_cust" => $inv->po_cust,
            "inv_kirimke" => $inv->inv_kirimke,
            "inv_alamatkirim" => $inv->inv_alamatkirim,
            "mata_uang" => $inv->mata_uang,
        );
        return json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_detail($id)
    {
        $inv_detail = InvoiceDetail::findOrFail($id);
        $data = array(
            "id" => $inv_detail->id,
            "id_sppb_detail" => $inv_detail->id_sppb_detail,
            "id_stock_master" => $inv_detail->id_stock_master,
            "stock_master" => $inv_detail->stock_master->name,
            "qty" => $inv_detail->qty - 0,
            "satuan" => $inv_detail->stock_master->satuan,
            "keterangan1" => $inv_detail->sppb_detail->keterangan,
            "price" => $inv_detail->stock_master->harga_jual,
            "disc" => $inv_detail->disc - 0,
            "keterangan" => $inv_detail->keterangan,
        );
        return json_encode($data);
    }

    public function store(Request $request)
    {
        $draf = Invoice::where([
            ['inv_status','=', 1],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count();

        if($draf > 0){
            return response()
                ->json(['code'=>200,'message' => 'Use the previous Draf Invoice First', 'stat' => 'Warning']);
        }

        $data = [
            'id_branch' => Auth::user()->id_branch,
            'inv_no' => $this->inv_no(),
            'id_sppb' => $request['sppb'],
            'id_customer' => $request['customer'],
            'po_cust' => $request['po_cust'],
            'inv_kirimke' => $request['inv_kirimke'],
            'inv_alamatkirim' => $request['inv_alamatkirim'],
            'mata_uang' => $request['mata_uang'],
            'date' => Carbon::now(),
            'top_date' => $request['top_date'],
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

    public function store_detail(Request $request, $id)
    {
        $inv = Invoice::findOrFail($id);
        $price = preg_replace('/\D/', '',$request['price']);
        $disc = preg_replace('/\D/', '',$request['disc']);
        $subtotal = ($request['qty'] * $price) - 0;
        $total_befppn = ($subtotal  - $disc ) - 0;
        $total_ppn = ($total_befppn  + (($inv->customer->ppn * $total_befppn) / 100) ) - 0;
        $data = [
            'id_branch' => Auth::user()->id_branch,
            'id_inv' => $id,
            'id_sppb_detail' => $request['id_sppb_detail'],
            'id_stock_master' => $request['id_stock_master'],
            'qty' => $request['qty'],
            'price' => $price,
            'disc' => $disc,
            'subtotal' => $subtotal,
            'total_befppn' => $total_befppn,
            'total_ppn' => $total_ppn,
            'keterangan' => $request['keterangan'],
            'inv_detail_status' => 1,
        ];

        $activity = InvoiceDetail::create($data);

        $spbd_detail = SppbDetail::find($request['id_sppb_detail']);
        $spbd_detail->inv_qty = $request['qty'];
        $spbd_detail->update();


        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new item PO Stock Success', 'stat' => 'Success', 'process' => 'update']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error item PO Stock Store', 'stat' => 'Error']);
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

        $data = Invoice::find($id);
        $data->id_sppb    = $request['sppb'];
        $data->id_customer    = $request['customer'];
        $data->po_cust    = $request['po_cust'];
        $data->inv_kirimke    = $request['inv_kirimke'];
        $data->inv_alamatkirim    = $request['inv_alamatkirim'];
        $data->mata_uang    = $request['mata_uang'];
        $data->top_date    = $request['top_date'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Invoice Success', 'stat' => 'Success']);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_detail(Request $request, $id)
    {
        $data = InvoiceDetail::find($id);
        $price = preg_replace('/\D/', '',$request['price']);
        $disc = preg_replace('/\D/', '',$request['disc']);
        $subtotal = ($request['qty'] * $price) - 0;
        $total_befppn = ($subtotal  - $disc ) - 0;
        $total_ppn = ($total_befppn  + (($data->invoice->customer->ppn * $total_befppn) / 100) ) - 0;

        $data->disc    = $disc;
        $data->keterangan    = $request['keterangan'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Item Invoice Success', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Invoice::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Invoice Success Deleted', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_detail($id)
    {
        $inv_detail = InvoiceDetail::find($id);
        InvoiceDetail::destroy($id);
        $sppb_detail = SppbDetail::find($inv_detail->id_sppb_detail);
        $sppb_detail->inv_qty = $sppb_detail->inv_qty - $inv_detail->qty;
        $sppb_detail->update();
        return response()
            ->json(['code'=>200,'message' => 'Invoice item Success Deleted', 'stat' => 'Success']);
    }

    public function recordInv(){
        $data = Invoice::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_inv', function($data){
                $action = "";
                if($data->inv_status == 1){
                    $action = "Draf";
                }elseif($data->inv_status == 2){
                    $action = "Request";
                }elseif($data->inv_status == 3){
                    if($data->pelunasan->count() < 1){
                        $action = "Approved";
                    }
                    elseif($data->inv_detail->sum('total_ppn') == $data->pelunasan->sum('balance'))
                    {
                        $action = "Closed";
                    }else{
                        $action = "Partial";
                    }

                }else{
                    $action = "Batal";
                }
                return $action;
            })
            ->addColumn('action', function($data){
                $invoice_detail = "javascript:ajaxLoad('".route('local.inv.detail.index', $data->id)."')";
                $action = "";
                $title = "'".$data->inv_no."'";
                if($data->inv_status == 1){
                    $action .= '<a href="'.$invoice_detail.'" class="btn btn-warning btn-xs"> Draf</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                if($data->inv_status == 2){
                    $action .= '<a href="'.$invoice_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="print_inv('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                }
                if($data->inv_status == 3){
                    $action .= '<a href="'.$invoice_detail.'" class="btn btn-success btn-xs"> Open</a> ';
                    $action .= '<button id="'. $data->id .'" onclick="print_inv('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
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
            ->rawColumns(['action'])->make(true);
    }

    public function recordInv_detail($id, $inv_stat = NULL){
        $data = InvoiceDetail::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['id_inv','=', $id],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data)  use($inv_stat){
                $action = "";
                $title = "'".$data->stock_master->name."'";
                if($data->invoice->inv_status == 1){
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                }
                if($data->invoice->inv_status == 2){
                    $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                }
                if($inv_stat == 1){
                    $action .= '<button id="'. $data->id .'" onclick="addItem('. $data->id .')" class="btn btn-info btn-xs"> Add Item</button> ';
                }
                return $action;
            })
            ->addColumn('nama_stock', function($data){
                $action = $data->stock_master->name;
                return $action;
            })
            ->addColumn('satuan', function($data){
                $action = $data->stock_master->satuan;
                return $action;
            })
            ->addColumn('format_balance', function($data){
                // $action = $data->stock_master->satuan;
                return "Rp. ".number_format($data->price,0, ",", ".");
            })
            ->rawColumns(['action'])->make(true);
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function inv_open($id)
    {
        $data = Invoice::findOrFail($id);
        $data->inv_status = 2;
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Request Invoice Success', 'stat' => 'Success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $data = Invoice::findOrFail($id);
        $data->inv_status = 3;
        $this->inv_movement($data->inv_detail);
        $data->update();
        $sppd = Sppb::findOrFail($data->id_sppb);
        $sppd->sppb_status = 4;
        $sppd->update();
        return response()
            ->json(['code'=>200,'message' => 'SPBD Approve Success', 'stat' => 'Success']);
    }

    public function inv_movement($data)
    {
        foreach ($data as $detail ) {
            $data = [
                'id_stock_master' => $detail->id_stock_master,
                'id_branch' => $detail->id_branch,
                'move_date' => $detail->invoice->date,
                // 'bin' => "-",
                'type' => 'INV',
                'doc_no' => $detail->invoice->inv_no,
                'order_qty' => 0,
                'sell_qty' => $detail->qty,
                'in_qty' => 0,
                'out_qty' => 0,
                'harga_modal' => 0,
                'harga_jual' => $detail->price,
                'user' => Auth::user()->name,
                'ket' => 'SPPB ('.$detail->sppb_detail->sppb->sppb_no.')',
            ];

            $movement = StockMovement::create($data);
            $stock_master = StockMaster::find($detail->id_stock_master);
            $stock_master->harga_jual = $detail->price;
            $stock_master->update();
        }
    }
}
