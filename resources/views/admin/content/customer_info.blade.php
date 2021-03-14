<section class="content-header">
    <h1>
        Customer
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Settings</a></li>
        <li><a href="#"> Customer</a></li>
        <li class="active"><a href="#"> Information</a></li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Information Customer</h3>
                </div>
                <div class="box-body">
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <strong>Name</strong> : {{ $customer->name }}<br>
                            <strong>Alamat</strong> :
                            <address>
                                {{ $customer->address1 }}<br>
                                {{ $customer->address2 }}<br>
                                {{ $customer->city }}<br>
                            </address>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>PIC</b> : {{ $customer->pic }}<br>
                            <b>Email</b> : {{ $customer->email }}<br>
                            <b>Telp</b> : {{ $customer->telp }}<br>
                            <b>Phone</b> : {{ $customer->phone }}<br>
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <b>KTP</b> : {{ $customer->ktp }}<br>
                            <b>NPWP</b> : {{ $customer->npwp }}<br>
                            <b>BOD</b> : {{ $customer->bod }}<br>
                            <b>Ppn</b> : @if ($customer->status_ppn == 1)Aktif @else Non Aktif @endif<br>
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
                                <th>Invoice No</th>
                                <th>Po Customer</th>
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
        "ajax": "{{route('local.customer.inv', [ 'id' => $customer->id ] ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'inv_no', name: 'inv_no'},
            {data: 'po_cust', name: 'po_cust'},
            {data: 'item', name: 'item'},
            {data: 'total_harga', name: 'total_harga'},
            {data: 'status', name: 'status'},
        ]
    });

    $(function(){
        $('#bod').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
    });
</script>
