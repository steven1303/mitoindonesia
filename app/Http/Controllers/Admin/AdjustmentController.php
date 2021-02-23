<?php

namespace App\Http\Controllers\Admin;

use App\Models\Adjustment;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\SettingAjaxController;

class AdjustmentController extends SettingAjaxController
{
    public function index()
    {
        $data = [];
        return view('admin.content.adjustment')->with($data);
    }

    public function detail($id)
    {
        $adj = Adjustment::findOrFail($id);
        $data = [
            'adj' => $adj
        ];
        return view('admin.content.adjustment_detail')->with($data);
    }

    public function adj_no(){
        $tanggal = Carbon::now();
        $format = 'ADJ/'.Auth::user()->branch->name.'/'.$tanggal->format('y').'/'.$tanggal->format('m');
        $spbd_no = Adjustment::where([
            ['adj_no','like', $format.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->count() + 1;
        return $format.'/'.sprintf("%03d", $spbd_no);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'adj_no' => $this->spbd_no(),
            'id_branch' => Auth::user()->id_branch,
            'user_id' => Auth::user()->id,
            'user_name' => Auth::user()->name,
            'status' => 1,
        ];

        $activity = Adjustment::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new Adjustment Success' , 'stat' => 'Success', 'adj_id' => $activity->id, 'process' => 'add']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error Adjustment Store', 'stat' => 'Error']);
        }
    }
}
