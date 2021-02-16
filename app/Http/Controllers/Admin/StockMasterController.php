<?php

namespace App\Http\Controllers\Admin;

use App\Models\StockMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\SettingAjaxController;

class StockMasterController extends SettingAjaxController
{
    public function index()
    {
        $data = [];
        return view('admin.content.stock_master')->with($data);
    }

    public function store(Request $request)
    {
        // return $request;
        $data = [
            'stock_no' => $request['stock_no'],
            'name' => $request['name'],
            'bin' => $request['bin'],
            'satuan' => $request['satuan'],
            'id_branch' => Auth::user()->id_branch,
        ];

        $activity = StockMaster::create($data);

        if ($activity->exists) {
            return response()
                ->json(['code'=>200,'message' => 'Add new Stock Master Success', 'stat' => 'Success']);

        } else {
            return response()
                ->json(['code'=>200,'message' => 'Error Stock Master Store', 'stat' => 'Error']);
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
        $data = StockMaster::findOrFail($id);
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

        $data = StockMaster::find($id);
        $data->stock_no    = $request['stock_no'];
        $data->name    = $request['name'];
        $data->bin    = $request['bin'];
        $data->satuan    = $request['satuan'];
        $data->update();
        return response()
            ->json(['code'=>200,'message' => 'Edit Stock Master Success', 'stat' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StockMaster::destroy($id);
        return response()
            ->json(['code'=>200,'message' => 'Stock Master Success Deleted', 'stat' => 'Success']);
    }

    public function recordStockMaster(){
        $data = StockMaster::where('id_branch','=', Auth::user()->id_branch)->latest()->get();
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
            ->addColumn('action', function($data){
                $stock_movement = "javascript:ajaxLoad('".route('local.stock_movement.index', $data->id)."')";
                $action = "";
                $title = "'".$data->name."'";
                $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                $action .= '<a href="'.$stock_movement.'" class="btn btn-primary btn-xs"> History</a> ';
                return $action;
            })
            ->rawColumns(['action'])->make(true);
    }

    /**
     * Search a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchStockMaster(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $tags = StockMaster::where([
            ['stock_no','like','%'.$term.'%'],
            ['id_branch','=', Auth::user()->id_branch]
        ])->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = [
                'id'    => $tag->id,
                'text'  => $tag->stock_no,
                'name'  => $tag->name,
                'satuan'  => $tag->satuan,
            ];
        }

        return response()->json($formatted_tags);
    }
}
