<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Spbd;
use App\Models\Sppb;
use App\Models\Spb;
use App\Models\Invoice;
use App\Models\PoStock;
use App\Models\Pembatalan;
use App\Models\PoNonStock;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class PembatalanController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('pembatalan.view')){
            $data = [
            ];
            return view('admin.content.pembatalan')->with($data);
        }
        return view('admin.components.403');
    }

    public function pembatalan_no(){
        $tanggal = Carbon::now();
        $format = 'CN/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $po_stock_no = Pembatalan::where([
            ['pembatalan_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $po_stock_no);
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchPoStock(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $tags = PoStock::where([
            ['po_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['po_status','<>', 1],
            ['po_status','<>', 5],
            ['po_status','<>', 6],
            ['po_status','<>', 7],
        ])->get();
        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->po_no,
                'text'  => $tag->po_no,
                'vendor'  => $tag->id_vendor,
                'vendor_name'  => $tag->vendor->name,
                'ppn'  => $tag->ppn,
                'total_bef_ppn' => $tag->po_stock_detail->sum('total'),
                'total' => $tag->po_stock_detail->sum('total') + $tag->ppn,
            ];
        }
        return response()->json($formatted_tags);
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchPoNonStock(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $tags = PoNonStock::where([
            ['po_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['po_status','<>', 1],
        ])->get();
        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->po_no,
                'text'  => $tag->po_no,
            ];
        }
        return response()->json($formatted_tags);
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchInvoice(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return response()->json([]);
        }
        $tags = Invoice::where([
            ['inv_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch],
            ['inv_status','<>', 1],
            ['inv_status','<>', 5],
            ['inv_status','<>', 6],
            ['inv_status','<>', 7],
        ])->get();
        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->inv_no,
                'text'  => $tag->inv_no,
            ];
        }
        return response()->json($formatted_tags);
    }

    public function store(Request $request, $type)
    {
        // return $request;
        $pembatalan_draf = Pembatalan::where([
            ['status','=', 1],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count();
        $doc_no = "";
        if($type == 1){

            $doc_no = $request['po_stock_no'];
        }
        if ($type == 2) {
            $doc_no = $request['po_non_stock_no'];
        }
        if ($type == 3) {
            if($request->has('status_sppb')){
                $type = 4;
            }
            $doc_no = $request['invoice_no'];
        }
        if($pembatalan_draf > 10){
            return response()
                ->json(['code'=>200,'message' => 'Use the previous Draf Pembatalan First', 'stat' => 'Warning']);
        }
        $data = [
            'id_branch' => Auth::user()->id_branch,
            'pembatalan_no' => $this->pembatalan_no(),
            'pembatalan_type' => $type,
            'doc_no' => $doc_no,
            'keterangan' => $request['keterangan'],
            'status' => 1,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
        ];
        $activity = Pembatalan::create($data);
        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new Pembatalan Success' , 'stat' => 'Success', 'po_id' => $activity->id , 'process' => 'add']);
        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error Pembatalan Store', 'stat' => 'Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pembatalan::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Pembatalan Success Deleted', 'stat' => 'Success']);
    }

    public function recordPembatalan(){
        $data = Pembatalan::where([
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        $access =  Auth::user();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status_pembatalan', function($data){
                $status = "";
                if($data->status == 1){
                    $status = "Draft";
                }elseif ($data->status == 2) {
                    $status = "Approved";
                }else {
                    $status = "Reject";
                }
                return $status;
            })
            ->addColumn('type_pembatalan', function($data){
                $type = "";
                if($data->pembatalan_type == 1){
                    $type = "PO Stock";
                }
                if ($data->pembatalan_type == 2) {
                    $type = "PO Non Stock";
                }
                if ($data->pembatalan_type == 3) {
                    $type = "Invoice";
                }
                if ($data->pembatalan_type == 4) {
                    $type = "Invoice & SPPB";
                }
                return $type;
            })
            ->addColumn('tanggal', function($data){
                $action = date("d M Y", strtotime($data->created_at));
                return $action;
            })
            ->addColumn('action', function($data) use($access){
                $action = "";
                $title = "'".$data->pembatalan_no."'";
                if($data->status == 1){
                    $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    $action .= '<button id="'. $data->id .'" onclick="approve('. $data->id .')" class="btn btn-info btn-xs"> Approve</button> ';
                }
                if($data->status == 2){
                    if($access->can('pembatalan.print')){
                        $action .= '<button id="'. $data->id .'" onclick="print_pembatalan('. $data->id .')" class="btn btn-normal btn-xs"> Print</button> ';
                    }
                }
                return $action;
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
        $data = Pembatalan::findOrFail($id);
        $data->status = 2;
        $data->po_open = Carbon::now();
        if($data->pembatalan_type == 1){
            $this->pembatalan_po_stock($data->doc_no, $data->pembatalan_no);
        }
        if($data->pembatalan_type == 2){
            $this->pembatalan_po_non_stock($data->doc_no, $data->pembatalan_no);
        }
        if($data->pembatalan_type == 3){
            $this->pembatalan_invoice($data->doc_no, $data->pembatalan_no);
        }
        if($data->pembatalan_type == 4){
            $this->pembatalan_invoice_sppb($data->doc_no, $data->pembatalan_no);
        }
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Pembatalan Approve Success', 'stat' => 'Success']);
    }

    public function pembatalan_po_stock($no_po, $pembatalan_no)
    {
        $po_stock = PoStock::where([
            ['po_no','=', $no_po ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->first();

        $spbd = Spbd::where([
            ['spbd_no','=', $po_stock->spbd->spbd_no ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->update(['spbd_status' => 5]);

        $stock_movement = StockMovement::where([
            ['doc_no','=', $no_po ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->update(['status' => 1, 'ket' => $pembatalan_no]);
        $po_stock->po_status = 7;
        $po_stock->update();
    }

    public function pembatalan_po_non_stock($no_po, $pembatalan_no)
    {
        $po_non_stock = PoNonStock::where([
            ['po_no','=', $no_po ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->first();

        $spb = Spb::where([
            ['spb_no', '=', $po_non_stock->spb->spb_no],
            ['id_branch','=', Auth::user()->id_branch],
        ])->update(['spb_status' => 5]);

        $po_non_stock->po_status = 5;
        $po_non_stock->update();
    }

    public function pembatalan_invoice($no_inv, $pembatalan_no)
    {
        $inv = Invoice::where([
            ['inv_no','=', $no_inv ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->first();
        $inv->inv_status = 7;
        $inv->update();        
        
        $sppb = Sppb::where([
            ['sppb_no','=', $inv->sppb->sppb_no ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->first();
        $sppb->sppb_status = 3;
        $sppb->sppb_detail()->update(['inv_qty' => 0 ]);
        $sppb->update();

        $stock_movement_inv = StockMovement::where([
            ['doc_no','=', $no_inv ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->update(['status' => 1, 'ket' => $pembatalan_no]);
    }

    public function pembatalan_invoice_sppb($no_inv, $pembatalan_no)
    {
        $inv = Invoice::where([
            ['inv_no','=', $no_inv ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->first();
        $inv->inv_status = 7;
        $inv->update();
        
        
        $sppb = Sppb::where([
            ['sppb_no','=', $inv->sppb->sppb_no ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->update(['sppb_status' => 5]);

        $stock_movement_inv = StockMovement::where([
            ['doc_no','=', $no_inv ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->update(['status' => 1, 'ket' => $pembatalan_no]);

        $stock_movement_sppb = StockMovement::where([
            ['doc_no','=', $inv->sppb->sppb_no ],
            ['id_branch','=', Auth::user()->id_branch],
        ])->update(['status' => 1, 'ket' => $pembatalan_no]);
    }
}
