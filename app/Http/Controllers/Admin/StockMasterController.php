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
        if(Auth::user()->can('stock.master.view')){
            $data = [];
            return view('admin.content.stock_master')->with($data);
        }
        return view('admin.components.403');
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('stock.master.store')){
            $data = [
                'stock_no' => $request['stock_no'],
                'name' => $request['name'],
                'bin' => $request['bin'],
                'satuan' => $request['satuan'],
                'min_soh' => $request['min_soh'],
                'max_soh' => $request['max_soh'],
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
        return response()
            ->json(['code'=>200,'message' => 'Error Stock Master Access Denied', 'stat' => 'Error']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('stock.master.update')){
            $data = StockMaster::findOrFail($id);
            return $data;
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Stock Master Access Denied', 'stat' => 'Error']);
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
        if(Auth::user()->can('stock.master.update')){
            $data = StockMaster::find($id);
            $data->stock_no    = $request['stock_no'];
            $data->name    = $request['name'];
            $data->bin    = $request['bin'];
            $data->satuan    = $request['satuan'];
            $data->min_soh    = $request['min_soh'];
            $data->max_soh    = $request['max_soh'];
            $data->update();
            return response()
                ->json(['code'=>200,'message' => 'Edit Stock Master Success', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Stock Master Access Denied', 'stat' => 'Error']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('stock.master.delete')){
            StockMaster::destroy($id);
            return response()
                ->json(['code'=>200,'message' => 'Stock Master Success Deleted', 'stat' => 'Success']);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Stock Master Access Denied', 'stat' => 'Error']);
    }

    public function recordStockMaster(){
        if(Auth::user()->can('stock.master.view')){
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
                ->addColumn('action', function($data)  use($access){
                    $stock_movement = "javascript:ajaxLoad('".route('local.stock_movement.index', $data->id)."')";
                    $action = "";
                    $title = "'".$data->name."'";
                    if($access->can('stock.master.update')){
                        $action .= '<button id="'. $data->id .'" onclick="editForm('. $data->id .')" class="btn btn-info btn-xs"> Edit</button> ';
                    }
                    if($access->can('stock.master.delete')){
                        $action .= '<button id="'. $data->id .'" onclick="deleteData('. $data->id .','.$title.')" class="btn btn-danger btn-xs"> Delete</button> ';
                    }
                    if($access->can('stock.master.movement')){
                        $action .= '<a href="'.$stock_movement.'" class="btn btn-primary btn-xs"> History</a> ';
                    }
                    return $action;
                })
                ->rawColumns(['action'])->make(true);
        }
        return response()
            ->json(['code'=>200,'message' => 'Error Stock Master Access Denied', 'stat' => 'Error']);
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
                'harga_jual' => $tag->harga_jual,
                'harga_modal' => $tag->harga_modal,
            ];
        }

        return response()->json($formatted_tags);
    }
}
