<section class="content-header">
    <h1>
        SPB  Detail
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">SPB</a></li>
        <li><a href="#">SPB Draft</a></li>
        <li class="active"><a href="#">SPB Detail</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">SPB No. {{ $spb->spb_no }} <b>(  @if($spb->spb_status == 1 ) Draft @endif @if($spb->spb_status == 2 ) Open @endif @if($spb->spb_status == 3 ) Approved @endif ) </b></h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SpbForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>SPB No</label>
                                    <input type="text" class="form-control" id="spbd_no" name="spbd_no" readonly value="{{ $spb->spb_no }}">
                                </div>
                            </div>
                            <!-- <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <input type="text" class="form-control" id="vendor" name="vendor" readonly value="">
                                </div>
                            </div> -->
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask" name="spbd_date" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $spb->spb_date }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($spb->spb_status == 1 || $spb->spb_status == 2 )
                                <button id="btnSave" type="button" onclick="open_spb_Form()" class="btn btn-success">Open / Request</button>
                            @endif
                            <button class="btn btn-secondary" type="button" onclick="ajaxLoad('{{route('local.spb.index')}}')">Save</button> 
                            @can('spb.pembatalan', Auth::user())
                                @if($spb->spb_status == 3)                                                       
                                <button class="btn btn-danger" type="button" onclick="reject()">Reject</button>
                                @endif
                            @endcan
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
                    <h3 class="box-title">SPB Detail</h3><br/><br/>
                    @if ($spb->spb_status == 1 || $spb->spb_status == 2 )
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-input-item">Add Items</button>
                    @endif
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="stockMasterTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produk</th>
                                <th>Keterangan</th>
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
@canany(['spb.store', 'spb.update'], Auth::user())
<div class="modal fade" id="modal-input-item">
    <div class="modal-dialog">
        <form role="form" id="SpbDetailForm" method="POST">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" id="id" name="id">
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
                                <label>Produk</label>
                                <input type="text" class="form-control" id="product" name="product" placeholder="Input product">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input keterangan">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>QTY</label>
                                <input type="number" class="form-control" id="qty" name="qty" placeholder="Input QTY">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan">
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
        "ajax": "{{route('local.record.spb_detail', $spb->id ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'product', name: 'product'},
            {data: 'keterangan', name: 'keterangan'},
            {data: 'qty', name: 'qty'},
            {data: 'satuan', name: 'satuan'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });
    @canany(['spb.store', 'spb.update'], Auth::user())
    $(function(){

	    $('#SpbDetailForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.spb.store_detail', $spb->id) }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('spb_detail') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#SpbDetailForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#SpbDetailForm')[0].reset();
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
				    error : function(){
					    error('Error', 'Oops! Something Error! Try to reload your page first...');
				    }
			    });
			    return false;
		    }
	    });
    });
    function cancel(){
        save_method = 'add';
        $('#SpbDetailForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Stock Adjustment');
        $('#btnSave').attr('disabled',false);
        $('#stock_master').val(null).trigger('change');
        $('input[name=_method]').val('POST');
    }
    @endcanany
    @can('spb.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('spb') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#button_modal').text('Update');
            $('#modal_title').text('Edit Item');
            $('#button_modal').attr('disabled',false);
            $('#id').val(data.id);
            $('#qty').val(data.qty);
            $('#satuan').val(data.satuan);
            $('#product').val(data.product);
            $('#keterangan').val(data.keterangan);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('spb.open', Auth::user())
    function open_spb_Form() {
        $.ajax({
        url: "{{route('local.spb.open.index', $spb->id) }}",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            if(data.stat == "Error")
            {
                error(data.stat, data.message);
            }
            if(data.stat == "Success"){
                success(data.stat, data.message);
                // print otomatis setelah request / open
                // print_spb( "{{ $spb->id }}" );
                ajaxLoad("{{ route('local.spb.index') }}");
            }
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('spb.print', Auth::user())
    function print_spb(id){
        window.open("{{ url('spb_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('spb.delete', Auth::user())
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
                    url : "{{ url('spb_detail') }}" + '/' + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success : function(data) {
                        table.ajax.reload();
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
    @can('spb.pembatalan', Auth::user())
    function reject()
    {
        $.ajax({
        url: "{{route('local.spb.pembatalan', $spb->id) }}",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            if(data.stat == "Error")
            {
                error(data.stat, data.message);
            }
            if(data.stat == "Success"){
                success(data.stat, data.message);
                ajaxLoad("{{ route('local.spb.index') }}");
            }
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
</script>
