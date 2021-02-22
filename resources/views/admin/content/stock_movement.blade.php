<section class="content-header">
    <h1>
        Stock Movement Part
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Inventory</a></li>
        <li><a href="#">Stock Master</a></li>
        <li class="active"><a href="#"> Stock Movement</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-yellow">
                    <h3 class="widget-user-username">{{ $stock_detail->stock_no }}</h3>
                    <h5 class="widget-user-desc">{{ $stock_detail->name }}</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li>
                            <a href="#">{{ $stock_detail->branch->name }} <span class="pull-right badge bg-blue">{{ $stock_detail->stock_movement->sum('in_qty') - $stock_detail->stock_movement->sum('out_qty') }}</span></a>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-sm-3 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $stock_detail->stock_movement->sum('order_qty') }}</h5>
                                <span class="description-text">Order</span>
                            </div>
                        </div>
                        <div class="col-sm-3 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $stock_detail->stock_movement->sum('sell_qty') }}</h5>
                                <span class="description-text">Sell</span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="description-block">
                                <h5 class="description-header">{{ $stock_detail->stock_movement->sum('in_qty') }}</h5>
                                <span class="description-text">In</span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="description-block">
                                <h5 class="description-header">{{ $stock_detail->stock_movement->sum('out_qty') }}</h5>
                                <span class="description-text">Out</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Price</h3>
                </div>
                <div class="box-body">
                    <table class="table table-condensed">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 300px">Keterangan</th>
                            <th>Harga</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>Harga Modal</td>
                            <td>{{ "Rp. ".number_format($stock_detail->harga_modal,0, ",", ".") }}</td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Harga rata-rata modal</td>
                            <td>{{ "Rp. ".number_format($avg_modal,0, ",", ".") }}</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Harga Jual</td>
                            <td>{{ "Rp. ".number_format($stock_detail->harga_jual,0, ",", ".") }} </td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>Harga rata-rata jual</td>
                            <td>{{ "Rp. ".number_format($avg_jual,0, ",", ".") }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">History Stock Movement</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="stockMasterTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Type</th>
                                <th>Document</th>
                                <th>Tanggal</th>
                                <th>Order</th>
                                <th>Sell</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var table = $('#stockMasterTable')
    .DataTable({
        'paging'      	: true,
        'lengthChange'	: true,
        'searching'   	: true,
        'ordering'    	: true,
        'info'        	: true,
        'autoWidth'   	: false,
        "processing"	: true,
        "serverSide"	: true,
        responsive      : true,
        "ajax": "{{route('local.record.stock_movement', $stock_detail->id ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'type', name: 'type'},
            {data: 'doc_no', name: 'doc_no'},
            {data: 'move_date', name: 'move_date'},
            {data: 'order_qty', name: 'order_qty'},
            {data: 'sell_qty', name: 'sell_qty'},
            {data: 'in_qty', name: 'in_qty'},
            {data: 'out_qty', name: 'out_qty'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });
</script>
