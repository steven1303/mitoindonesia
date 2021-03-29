<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class PricelistController extends SettingAjaxController
{
    public function index()
    {
        if(Auth::user()->can('pricelist.view')){
            $data = [];
            return view('admin.content.pricelist')->with($data);
        }
        return view('admin.components.403');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('pricelist.update')){
            $data = StockMaster::findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Pricelist Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('pricelist.update')){
            $data = StockMaster::find($id);
            // $data->harga_modal    = preg_replace('/\D/', '',$request['harga_modal']);
            $data->harga_modal    = intval(preg_replace('/,.*|[^0-9]/', '',$request['harga_modal']));
            $data->harga_jual    = preg_replace('/\D/', '',$request['harga_jual']);
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Pricelist Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Pricelist Access Denied', 'stat' => 'Error']);
    }

    public function recordPricelist(){
        if(Auth::user()->can('pricelist.view')){
            $data = StockMaster::where('id_branch','=', Auth::user()->id_branch)->latest()->get();
            $access =  Auth::user();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('soh', function($data){
                    $action = "";
                    return $action;
                })
                ->addColumn('soh', function($data){
                    $soh = $data->stock_movement->sum('in_qty') - $data->stock_movement->sum('out_qty');
                    return $soh;
                })
                ->addColumn('avg_modal_format', function($data){
                    $avg_modal =  $data->stock_movement()->where('order_qty','>', 0)->count();
                    if($avg_modal > 0){
                        $avg_modal = $data->stock_movement()->where('order_qty','>', 0)->sum('harga_modal') / $data->stock_movement()->where('order_qty','>', 0)->count();
                    }
                    return "Rp. ".number_format($avg_modal,0, ",", ".");
                })
                ->addColumn('avg_jual_format', function($data){
                    $avg_jual = $data->stock_movement()->where('sell_qty','>', 0)->count();
                    if($avg_jual > 0){
                        $avg_jual = $data->stock_movement()->where('sell_qty','>', 0)->sum('harga_jual')  / $data->stock_movement()->where('sell_qty','>', 0)->count();
                    }
                    return "Rp. ".number_format($avg_jual,0, ",", ".");
                })
                ->addColumn('modal_format', function($data){
                    return "Rp. ".number_format($data->harga_modal,0, ",", ".");
                })
                ->addColumn('jual_format', function($data){
                    return "Rp. ".number_format($data->harga_jual,0, ",", ".");
                })
                ->addColumn('action', function($data)  use($access){
                    $stock_movement = "javascript:ajaxLoad('".route('local.stock_movement.index', $data->id)."')";
                    $action = "";
                    $title = "'".$data->name."'";
                    if($access->can('pricelist.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit Price</button> ';
                    }
                    return $action;
                })
                ->rawColumns(['action'])->make(true);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Pricelist Access Denied', 'stat' => 'Error']);
    }
}
