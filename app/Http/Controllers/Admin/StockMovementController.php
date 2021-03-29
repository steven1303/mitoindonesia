<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockMaster;
use Illuminate\Http\Request;
use App\Models\StockMovement;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class StockMovementController extends SettingAjaxController
{
    public function index($id)
    {
        if(Auth::user()->can('stock.master.movement')){
            $stock_master = StockMaster::where([
                ['id', '=', $id],
                ['id_branch', '=', Auth::user()->id_branch]
            ])->first();

            $avg_jual = $stock_master->stock_movement()->where([
                ['sell_qty','>', 0],
                ['status','=', 0]
            ])->count();
            $avg_modal =  $stock_master->stock_movement()->where([
                ['order_qty','>', 0],
                ['status','=', 0]
            ])->count();
            if($avg_modal > 0){
                $avg_modal = $stock_master->stock_movement()->where([['order_qty','>', 0],['status','=', 0]])->sum('harga_modal') / $stock_master->stock_movement()->where([['order_qty','>', 0],['status','=', 0]])->count();
            }
            if($avg_jual > 0){
                $avg_jual = $stock_master->stock_movement()->where([['sell_qty','>', 0],['status','=', 0]])->sum('harga_jual')  / $stock_master->stock_movement()->where([['sell_qty','>', 0],['status','=', 0]])->count();
            }
            $data = [
                'stock_detail' => $stock_master,
                'avg_modal' => $avg_modal,
                'avg_jual' => $avg_jual,
            ];
            return view('admin.content.stock_movement')->with($data);
        }
        return view('admin.components.403');
    }

    public function recordStockMovement($id){
        if(Auth::user()->can('stock.master.movement')){
            $data = StockMovement::where([
                ['id_stock_master', '=', $id],
                ['id_branch','=', Auth::user()->id_branch],
            ])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status_desc', function($data){
                    $action = "";
                    if($data->status == 0){
                        $action = "Accept";
                    }else{
                        $action = "Reject";
                    }
                    return $action;
                })
                ->addColumn('action', function($data){
                    $action = "";
                    return $action;
                })
                ->rawColumns(['action'])->make(true);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Stock Movement Access Denied', 'stat' => 'Error']);
    }
}
