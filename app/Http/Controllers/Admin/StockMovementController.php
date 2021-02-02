<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SettingAjaxController;

class StockMovementController extends SettingAjaxController
{
    public function index($id)
    {
        $data = [];
        return view('admin.content.stock_movement')->with($data);
    }
}
