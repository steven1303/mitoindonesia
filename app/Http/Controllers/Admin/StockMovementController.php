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
        $stock_master = StockMaster::where([
            ['id', '=', $id],
            ['id_branch', '=', Auth::user()->id_branch]
        ])->first();

        $avg_modal =( $stock_master->stock_movement()->where('order_qty','>', 0)->sum('harga_modal') / $stock_master->stock_movement()->where('order_qty','>', 0)->count() );
        $avg_jual = $stock_master->stock_movement()->where('sell_qty','>', 0)->sum('harga_jual')  / $stock_master->stock_movement()->where('sell_qty','>', 0)->count();
        $data = [
            'stock_detail' => $stock_master,
            'avg_modal' => $avg_modal,
            'avg_jual' => $avg_jual,
        ];
        return view('admin.content.stock_movement')->with($data);
    }

    public function recordStockMovement($id){
        $data = StockMovement::where([
            ['id_stock_master', '=', $id],
            ['id_branch','=', Auth::user()->id_branch],
        ])->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('soh', function($data){
                $action = "";
                return $action;
            })
            ->addColumn('action', function($data){
                $stock_movement = "javascript:ajaxLoad('".route('local.stock_movement.index', $data->id)."')";
                $action = "";
                $title = "'".$data->name."'";
                $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                $action .= '<a href="'.$stock_movement.'" class="btn btn-primary btn-xs"> Info</a> ';
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }
}
