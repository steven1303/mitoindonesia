<section class="content-header">
    <h1>
        Transfer  Detail
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Inventory</a></li>
        <li><a href="#">Transfer Receipt</a></li>
        <li class="active"><a href="#">Transfer Receipt Detail</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Transfer No {{ $transfer->receipt_transfer_no }} <b>(  @if($transfer->transfer_status == 1 ) Draft @endif @if($transfer->transfer_status == 2 ) Open @endif @if($transfer->transfer_status == 3 ) Approved @endif @if($transfer->transfer_status == 4 ) Closed @endif @if($transfer->transfer_status == 5 ) Reject @endif )  </b></h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SpbdForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Transfer No</label>
                                    <input type="text" class="form-control" id="receipt_transfer_no" name="receipt_transfer_no" placeholder="Input Transfer No" readonly value="{{ $transfer->receipt_transfer_no }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask" name="date" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $transfer->receipt_transfer_date }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <input type="text" class="form-control" id="branch" name="transfer_no" placeholder="Input Transfer Branch" readonly value="{{ $transfer->from->city }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="transfer_no" placeholder="Input Transfer Branch" readonly value="{{ $transfer->keterangan }}">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($transfer->receipt_transfer_status == 1 || $transfer->receipt_transfer_status == 2 )
                                <button id="btnSave" type="button" onclick="open_transfer_Form()" class="btn btn-success">Request</button>
                            @endif
                            <button class="btn btn-secondary" type="button" onclick="ajaxLoad('{{route('local.transfer_receipt.index')}}')">Save</button>
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
                    <h3 class="box-title">Receipt Detail</h3><br/><br/>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="TransferReceiptTable">
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
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Transfer Detail</h3><br/><br/>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="TransferTable">
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
@canany(['adjustment.store', 'adjustment.update'], Auth::user())
<div class="modal fade" id="modal-input-item">
    <div class="modal-dialog">
        <form role="form" id="TransferDetailForm" method="POST">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="id_stock_master_from" name="id_stock_master_from">
            <input type="hidden" id="id_transfer_detail" name="id_transfer_detail">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 id="modal_title" class="modal-title">Adds Items</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Stock No branch {{ $transfer->from->city }}</label>
                            <input type="text" class="form-control" id="stock_master_from" name="stock_master_from" placeholder="Stock No" readonly>

                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Stock No branch {{ $transfer->branch->city }}</label>
                            <select class="form-control select2" id="stock_master" name="stock_master" style="width: 100%;">
                                <option></option>
                            </select>
                            <span class="text-danger error-text stock_master_error"></span>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>QTY</label>
                            <input type="number" class="form-control" id="qty" name="qty" placeholder="QTY Transfer" readonly>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>terima</label>
                            <input type="number" class="form-control" id="terima" name="terima" placeholder="Input Terima" readonly>
                            <span class="text-danger error-text terima_error"></span>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" readonly>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input keterangan">
                        </div>
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"  onclick="cancel()">Cancel</button>
                    <button id="button_modal" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcanany
<script type="text/javascript">
    var save_method;
    save_method = 'add';
    var table1 = $('#TransferReceiptTable')
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
        "ajax": "{{route('local.record.transfer_receipt_detail', $transfer->id) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'qty', name: 'qty'},
            {data: 'satuan', name: 'satuan'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    var table2 = $('#TransferTable')
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
        "ajax": "{{route('local.record.transfer_detail', [ 'id' => $transfer->transfer->id, 'rec_stat' => $transfer->receipt_transfer_status]) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'sisa', name: 'sisa'},
            {data: 'satuan', name: 'satuan'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    @canany(['adjustment.store', 'adjustment.update'], Auth::user())
    
    $(function(){
        $('#datemask').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });

        $('#stock_master').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.search.stock_master') }}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    }
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
        })

        $('#stock_master').on('select2:select', function (e) {
            var data = e.params.data;
            console.log(data);
            $('#satuan').val(data.satuan);
        });

	    $('#TransferDetailForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.transfer_receipt.store_detail', $transfer->id) }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('transfer_receipt_detail') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#TransferDetailForm').serialize(),
                    beforeSend:function(){
                        $(document).find('span.error-text').text('');
                    },
				    success : function(data) {
                        table1.ajax.reload();
                        table2.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#TransferDetailForm')[0].reset();
                            $('#btnSave').text('Submit');
                            $('#stock_master').val(null).trigger('change');
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
                            if(data.responseJSON.errors.stock_master !== undefined)
                            {
                                $('span.stock_master_error').text(data.responseJSON.errors.stock_master[0]);
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
    function cancel(){
        save_method = 'add';
        $('#TransferDetailForm')[0].reset();
        $('#btnSave').attr('disabled',false);
        $('#stock_master').val(null).trigger('change');
        $('input[name=_method]').val('POST');
    }
    @can('receipt.store', Auth::user())
    function addItem(id) {
        save_method = 'add';
        $.ajax({
        url: "{{ url('transfer') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        beforeSend:function(){
            $(document).find('span.error-text').text('');
        },
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#formTitle').text('Add Item');
            $('#btnSave').attr('disabled',false);
            $('#id_transfer_detail').val(data.id);
            $('#stock_master_from').val(data.stock_master.stock_no);
            $('#id_stock_master_from').val(data.id_stock_master);
            $('#price').val(data.price - 0);
            $('#disc').val(data.disc - 0);
            $('#qty').val((data.qty - data.rec_qty) - 0);
            $('#terima').val((data.qty - data.rec_qty) - 0);
            $('#satuan').val(data.stock_master.satuan);
            $('#keterangan1').val(data.keterangan);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @endcanany
    @can('adjustment.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('transfer_receipt') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#button_modal').text('Update');
            $('#modal_title').text('Edit Item');
            $('#button_modal').attr('disabled',false);
            $('#id').val(data.id);
            $('#id_transfer_detail').val(data.id_transfer_detail);
            $('#stock_master_from').val(data.stock_master.stock_no);
            $('#id_stock_master_from').val(data.id_stock_master_form);
            var newOption = new Option(data.stock_master.stock_no, data.id_stock_master, true, true);
            $('#qty').val((data.transfer_detail.qty - data.transfer_detail.rec_qty + data.qty) - 0);
            $('#stock_master').append(newOption).trigger('change');
            $('#price').val(data.price - 0);
            $('#terima').val(( data.qty) - 0);
            $('#satuan').val(data.stock_master.satuan);
            $('#keterangan1').val(data.keterangan);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('adjustment.update', Auth::user())
    function open_transfer_Form() {
        $.ajax({
        url: "{{route('local.transfer_receipt.open.index', $transfer->id) }}",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            if(data.stat == 'Success')
            {
                success(data.stat, data.message);
                print_transfer( "{{ $transfer->id }}" );
                ajaxLoad("{{ route('local.transfer_receipt.index') }}");
            }
            if(data.stat == 'Error')
            {
                error(data.stat, data.message);
            }
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('adjustment.print', Auth::user())
    function print_transfer(id){
        window.open("{{ url('transfer_receipt_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('adjustment.delete', Auth::user())
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
                    url : "{{ url('transfer_receipt_detail') }}" + '/' + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success : function(data) {
                        table1.ajax.reload();
                        table2.ajax.reload();
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
