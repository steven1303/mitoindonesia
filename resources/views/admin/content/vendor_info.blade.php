<section class="content-header">
    <h1>
        Vendor Information
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Settings</a></li>
        <li><a href="#"> Vendor</a></li>
        <li class="active"><a href="#"> Information</a></li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Detail Vendor</h3>
                </div>
                <div class="box-body">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <strong>Name</strong> : {{ $vendor->name }}<br>
                            <strong>Alamat</strong> :
                            <address>
                                {{ $vendor->address1 }}<br>
                                {{ $vendor->address2 }}<br>
                                {{ $vendor->city }}<br>
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>PIC</b> : {{ $vendor->pic }}<br>
                            <b>Email</b> : {{ $vendor->email }}<br>
                            <b>Telp</b> : {{ $vendor->telp }}<br>
                            <b>Phone</b> : {{ $vendor->phone }}<br>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>NPWP</b> : {{ $vendor->npwp }}<br>
                            <b>Ppn</b> : @if ($vendor->status_ppn == 1)Aktif @else Non Aktif @endif<br>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Invoice</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="customerTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Po Customer</th>
                                <th>SPBD No</th>
                                <th>Item</th>
                                <th>Total harga</th>
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
    var save_method;
    save_method = 'add';
    var table = $('#customerTable')
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
        "ajax": "{{route('local.vendor.po_stock', [ 'id' => $vendor->id ] ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'po_no', name: 'po_no'},
            {data: 'spbd_no', name: 'spbd_no'},
            {data: 'item', name: 'item'},
            {data: 'total_harga', name: 'total_harga'},
            {data: 'status', name: 'status'},
        ]
    });

    $(function(){
        $('#bod').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
    });
</script>
