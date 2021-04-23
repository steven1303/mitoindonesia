<section class="content-header">
    <h1>
        Receipt Stock  @if($rec->status == 1 ) Draft @endif @if($rec->status == 2 ) Open @endif
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Receipt Stock</a></li>
        <li><a href="#">Receipt Stock Draft</a></li>
        <li class="active"><a href="#">Receipt Stock Detail</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Receipt Stock {{ $rec->rec_no }}</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SpbdForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Receipt No</label>
                                    <input type="text" class="form-control" value="{{ $rec->rec_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Stock No</label>
                                    <input type="text" class="form-control" value="{{ $rec->po_stock->po_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <input type="text" class="form-control" value="{{ $rec->vendor->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask" value="{{ $rec->rec_date }}" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Invoice Customer</label>
                                    <input type="text" class="form-control" value="{{ $rec->rec_inv_ven }}" readonly>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PPN</label>
                                    <input type="text" class="form-control"  id="rec_ppn" value="{{ $rec->ppn }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="button" onclick="open_receipt_Form()" class="btn btn-success">Print</button>
                            <button class="btn btn-secondary" type="button" onclick="ajaxLoad('{{route('local.rec.index')}}')">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Receipt item</h3><br/><br/>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="recTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>Order</th>
                                <th>Terima</th>
                                <th>Satuan</th>
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
                    <h3 class="box-title">PO Stock item</h3><br/><br/>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="poStockDetailTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>QTY</th>
                                <th>Satuan</th>
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
@canany(['receipt.store', 'receipt.update'], Auth::user())
<div class="modal fade" id="modal-input-item">
    <div class="modal-dialog modal-lg">
        <form role="form" id="RecDetailForm" method="POST">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="id_po_detail" name="id_po_detail">
            <input type="hidden" class="form-control" id="disc" name="disc" readonly>
            <input type="hidden" class="form-control" id="price" name="price" readonly>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 id="modal_title" class="modal-title">Adds Items</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label>Stock No</label>
                                <input type="text" class="form-control" id="stock_master" name="stock_master" placeholder="Input QTY" readonly>
                                <input type="hidden" id="id_stock_master" name="id_stock_master">
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label>Order</label>
                                <input type="text" class="form-control" id="qty" name="qty" readonly>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label>terima</label>
                                <input type="text" class="form-control" id="terima" name="terima" placeholder="QTY">
                                <span class="text-danger error-text terima_error"></span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" readonly>
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label>Keterangan PO</label>
                                <input type="text" class="form-control" id="keterangan1" name="keterangan1" readonly>
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label>Keterangan Receipt</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input keterangan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnSave" type="button" class="btn btn-default pull-left" data-dismiss="modal"  onclick="cancel()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcanany
<script type="text/javascript">
    var save_method;
    save_method = 'add';
    var table = $('#recTable')
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
        "ajax": "{{route('local.record.rec_detail', $rec->id ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'order', name: 'order'},
            {data: 'terima', name: 'terima'},
            {data: 'satuan', name: 'satuan'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    var table1 = $('#poStockDetailTable')
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
        "ajax": "{{route('local.record.po_stock_detail', [ 'id' => $rec->id_po_stock, 'rec_stat' => $rec->status]  ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'selisih', name: 'selisih'},
            // {data: 'price_format', name: 'price_format'},
            // {data: 'disc_format', name: 'disc_format'},
            {data: 'satuan', name: 'satuan'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    function format_decimal_limit(){
        VMasker(document.getElementById("price")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });

        VMasker(document.getElementById("disc")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });

        VMasker(document.getElementById("rec_ppn")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });
    }
    @canany(['receipt.store', 'receipt.update'], Auth::user())
    $(function(){
        format_decimal_limit();
        $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });

	    $('#RecDetailForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.rec.store_detail', $rec->id) }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('rec_detail') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#RecDetailForm').serialize(),
                    beforeSend:function(){
                        $(document).find('span.error-text').text('');
                    },
				    success : function(data) {
                        table.ajax.reload();
                        table1.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#RecDetailForm')[0].reset();
                            $('#btnSave').text('Submit');
                            success(data.stat, data.message);
                            $('#modal-input-item').modal('hide')
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
                            if(data.responseJSON.errors.terima !== undefined){
                                $('span.terima_error').text(data.responseJSON.errors.terima[0]);
                            }
                        }else{
                            error('Error', 'Oops! Something Error! Try to reload your page first...');
                        }
					    // error('Error', 'Oops! Something Error! Try to reload your page first...');
				    }
			    });
			    return false;
		    }
	    });
    });
    function cancel(){
        save_method = 'add';
        $('#RecDetailForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Stock Adjustment');
        $('#btnSave').attr('disabled',false);
        $('#stock_master').val(null).trigger('change');
        $('input[name=_method]').val('POST');
    }
    @endcanany
    @can('receipt.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('rec_detail') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        beforeSend:function(){
            $(document).find('span.error-text').text('');
        },
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#btnSave').text('Update');
            $('#modal_title').text('Edit Item');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            $('#id_po_detail').val(data.id_po_detail);
            $('#stock_master').val(data.stock_master);
            $('#id_stock_master').val(data.id_stock_master);
            $('#price').val(data.price - 0);
            $('#disc').val(data.disc - 0);
            $('#qty').val((data.order) - 0);
            $('#terima').val((data.terima) - 0);
            $('#satuan').val(data.satuan);
            $('#keterangan').val(data.keterangan);
            $('#keterangan1').val(data.keterangan1);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('receipt.store', Auth::user())
    function addItem(id) {
        save_method = 'add';
        $.ajax({
        url: "{{ url('po_stock_detail') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        beforeSend:function(){
            $(document).find('span.error-text').text('');
        },
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#formTitle').text('Add Item');
            $('#btnSave').attr('disabled',false);
            $('#id_po_detail').val(data.id);
            $('#stock_master').val(data.stock_master);
            $('#id_stock_master').val(data.id_stock_master);
            $('#price').val(data.price - 0);
            $('#disc').val(data.disc - 0);
            $('#qty').val((data.qty - data.rec_qty) - 0);
            $('#satuan').val(data.satuan);
            $('#keterangan1').val(data.keterangan);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('receipt.open', Auth::user())
    function open_receipt_Form() {
        $.ajax({
        url: "{{route('local.rec.open.index', $rec->id) }}",
        type: "GET",
        dataType: "JSON",
        beforeSend:function(){
            $(document).find('span.error-text').text('');
        },
        success: function(data) {
            if(data.stat == 'Success'){
                // print_receipt("{{ $rec->id }}"); // fungsi print otomatis
                success(data.stat, data.message);
                ajaxLoad("{{ route('local.rec.index') }}");
            }
            if(data.stat == 'Error'){
                error(data.stat, data.message);
            }
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('receipt.print', Auth::user())
    function print_receipt(id){
        window.open("{{ url('receipt_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('receipt.delete', Auth::user())
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
                    url : "{{ url('rec_detail') }}" + '/' + id,
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
