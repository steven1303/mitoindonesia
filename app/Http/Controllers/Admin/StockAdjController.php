<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class StockAdjController extends SettingAjaxController
{
    public function index()
    {
        $data = [];
        return view('admin.content.stock_adjustment')->with($data);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'id_stock_master' => $request['stock_master'],
            'id_branch' => Auth::user()->id_branch,
            'move_date' => Carbon::now(),
            // 'bin' => "-",
            'type' => 'ADJ',
            'doc_no' => 'Adjusment',
            'order_qty' => 0,
            'sell_qty' => 0,
            'in_qty' => $request['in_qty'],
            'out_qty' => $request['out_qty'],
            'harga_modal' => $request['harga_modal'],
            'harga_jual' => $request['harga_jual'],
            'user' => Auth::user()->name,
            'ket' => $request['ket'],
        ];

        $activity = StockMovement::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new Stock Adjusment Success', 'stat' => 'Success']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error Stock Adjusment Store', 'stat' => 'Error']);
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
        $data = StockMovement::with('stock_master')->findOrFail($id);
        return $data;
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

        $data = StockMovement::find($id);
        $data->id_stock_master    = $request['stock_master'];
        // $data->bin    = $request['bin'];
        $data->order_qty    = 0;
        $data->sell_qty    = 0;
        $data->in_qty    = $request['in_qty'];
        $data->out_qty    = $request['out_qty'];
        $data->harga_modal    = $request['harga_modal'];
        $data->harga_jual    = $request['harga_jual'];
        $data->user    =  Auth::user()->name;
        $data->ket    =  $request['ket'].' (Revisi '.Carbon::now().')';
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Stock Adjusment Success', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StockMovement::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Stock Adjusment Success Deleted', 'stat' => 'Success']);
    }

    public function recordStockAdjustment(){
        $data = StockMovement::where([
            ['id_branch','=', Auth::user()->id_branch],
            ['type','=','ADJ']
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('soh', function($data){
                $action = "";
                return $action;
            })
            ->addColumn('stock_no', function($data){
                $action = $data->stock_master->stock_no;
                return $action;
            })
            ->addColumn('action', function($data){
                // $stock_movement = "javascript:ajaxLoad('".route('local.stock_movement.index', $data->id)."')";
                $action = "";
                $title = "'".$data->doc_no."'";
                $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                // $action .= '<a href="'.$stock_movement.'" class="btn btn-primary btn-xs"> Detail</a> ';
                return $action;
            })
            ->rawColumns(['action','stock_no','soh'])->make(true);
    }
}
