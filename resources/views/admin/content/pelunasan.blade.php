<section class="content-header">
    <h1>
        Pelunasan
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Transaction</a></li>
        <li class="active"><a href="#"> Pelunasan</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Invoice</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="invoiceTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>total</th>
                                <th>Sisa</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                  </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Pelunasan</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="pelunasanTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelunasan No</th>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>Bayar</th>
                                <th>Action</th>
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
@canany(['pelunasan.store', 'pelunasan.update'], Auth::user())
<div class="modal fade" id="modal-input-item">
    <div class="modal-dialog">
        <form role="form" id="PelunasanForm" method="POST">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="id_invoice" name="id_invoice">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 id="modal_title" class="modal-title">Adds Pelunasan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Invoice No</label>
                                <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" readonly>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Total Invoice</label>
                                <input type="text" class="form-control" id="total_inv" name="total_inv" placeholder="Total Invoice" oninput="format_decimal_limit()" readonly>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Sisa</label>
                                <input type="text" class="form-control" id="sisa" name="sisa" placeholder="Sisa Invoice" oninput="format_decimal_limit()" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Bayar</label>
                                <input type="text" class="form-control" id="balance" name="balance" placeholder="Bayar" oninput="format_decimal_limit()">
                                <span class="text-danger error-text balance_error"></span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select class="form-control" id="payment" name="payment">
                                    <option value="1">Cash</option>
                                    <option value="2">Transfer</option>
                                    <option value="3">Cek</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label>Tanggal Bayar</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" id="pelunasan_date" name="pelunasan_date" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input keterangan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"  onclick="cancel()">Cancel</button>
                    <button id="btnSave" type="submit" class="btn btn-primary">Add Pelunasan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcanany
<script type="text/javascript">
    var save_method;
    save_method = 'add';
    var table = $('#invoiceTable')
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
        "ajax": "{{route('local.record.pelunasan_inv') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'inv_no', name: 'inv_no'},
            {data: 'date', name: 'date'},
            {data: 'total_inv', name: 'total_inv'},
            {data: 'total_pelunasan', name: 'total_pelunasan'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    var table1 = $('#pelunasanTable')
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
        "ajax": "{{route('local.record.pelunasan') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'pelunasan_no', name: 'pelunasan_no'},
            {data: 'invoice_no', name: 'invoice_no'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'format_balance', name: 'format_balance'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    function format_decimal_limit(){
        VMasker(document.getElementById("total_inv")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });

        VMasker(document.getElementById("sisa")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });

        VMasker(document.getElementById("balance")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });
    }
    @canany(['pelunasan.store', 'pelunasan.update'], Auth::user())
    $(function(){

        $('#pelunasan_date').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });

        $('#PelunasanForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.pelunasan.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('pelunasan') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#PelunasanForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        table1.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#PelunasanForm')[0].reset();
                            $('#btnSave').text('Submit');
                            $('#spbd').val(null).trigger('change');
                            success(data.stat, data.message);
                            $('#modal-input-item').modal('hide');
                        }
                        if(data.stat == 'Error'){
                            error(data.stat, data.message);
                        }
                        if(data.stat == 'Warning'){
                            error(data.stat, data.message);
                        }
				    },
				    error : function(data){
					    if(data.status == 422){
                            if(data.responseJSON.errors.qty !== undefined){
                                $('span.qty_error').text(data.responseJSON.errors.qty[0]);
                            }
                            if(data.responseJSON.errors.balance !== undefined)
                            {
                                $('span.balance_error').text(data.responseJSON.errors.balance[0]);
                            }
                        }else{
                            error('Error', 'Oops! Something Error! Try to reload your page first...');
                        }
				    }
			    });
			    return false;
		    }
	    });
    });

    function addPelunasan(id) {
        save_method = 'add';
        $.ajax({
        url: "{{ url('pelunasan') }}" + '/' + id + "/add",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#btnSave').text('Add Pelunasan');
            $('#modal_title').text('Input Pelunasan');
            $('#btnSave').attr('disabled',false);
            $('#id_invoice').val(data.id);
            $('#invoice_no').val(data.inv_no);
            $('#total_inv').val(data.inv_total - 0);
            $('#sisa').val(data.inv_sisa);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function editForm(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('pelunasan') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#btnSave').text('Edit Pelunasan');
            $('#formTitle').text('Edit Pelunasan');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            $('#id_invoice').val(data.id_invoice);
            $('#invoice_no').val(data.inv_no);
            $('#total_inv').val(data.inv_total);
            $('#sisa').val(data.inv_sisa);
            $('#balance').val(data.balance);
            $('#payment').val(data.payment);
            $('#pelunasan_date').val(data.pelunasan_date);
            $('#note').val(data.note);
            $('#keterangan').val(data.keterangan);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcanany
    @can('pelunasan.print', Auth::user())
    function print_pelunasan(id){
        window.open("{{ url('pelunasan_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('pelunasan.approve', Auth::user())
    function approve(id) {
        $.ajax({
        url: "{{ url('pelunasan') }}" + '/' + id + "/approve",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            table.ajax.reload();
            table1.ajax.reload();
            success(data.stat, data.message);
            print_pelunasan(id);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('pelunasan.delete', Auth::user())
    function deleteData(id, title){
        swal({
            title: 'Are you sure want to delete ' + title + ' ?',
            text: 'You won\'t be able to revert this!',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        })
        .then((willDelete) => {
            if (willDelete.value) {
                var csrf_token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url : "{{ url('pelunasan') }}" + '/' + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success : function(data) {
                        table.ajax.reload();
                        table1.ajax.reload();
                        swal({
                            type: 'success',
                            title: 'Deleted',
                            text: 'Poof! Your record has been deleted!',
                        });
                    },
                    error : function () {
                        swal( {
                            type: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!'
                        });
                    }
                });
            } else {
                swal({
                    type: 'success',
                    title: 'Canceled',
                    text: 'Your record is still safe!',
                });
            }
        });
    }
    @endcan
</script>
