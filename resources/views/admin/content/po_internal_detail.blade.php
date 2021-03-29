<section class="content-header">
    <h1>
        PO Internal @if($po_internal->po_status == 1 ) Draft @endif @if($po_internal->po_status == 2 ) Open @endif
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">PO Internal</a></li>
        <li><a href="#">PO Internal Draft</a></li>
        <li class="active"><a href="#">PO Internal Detail</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">PO Internal {{ $po_internal->po_no }}</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SpbdForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Internal No</label>
                                    <input type="text" class="form-control" id="sppb_no" name="sppb_no" placeholder="Input SPBD No" readonly value="{{ $po_internal->po_no }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <input type="text" class="form-control" id="customer" name="customer" placeholder="Input Vendor" readonly value="{{ $po_internal->customer->name }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask" name="spbd_date" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $po_internal->created_at }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($po_internal->po_status == 1 || $po_internal->po_status == 2 )
                                <button id="btnSave" type="button" onclick="open_po_internal_Form()" class="btn btn-success">Open / Request</button>
                            @endif
                            <button class="btn btn-secondary" type="button" onclick="ajaxLoad('{{route('local.po_internal.index')}}')">Save</button>
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
                    <h3 class="box-title">PO Internal Detail</h3><br/><br/>
                    @if($po_internal->po_status == 1 || $po_internal->po_status == 2 )
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-input-item" onclick="cancel()">Add Items</button>
                    @endif
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="sppbDetailTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>QTY</th>
                                <th>Price</th>
                                <th>Disc</th>
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
@canany(['po.internal.store', 'po.internal.update'], Auth::user())
<div class="modal fade" id="modal-input-item">
    <div class="modal-dialog modal-lg">
        <form role="form" id="PoInternalDetailForm" method="POST">
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
                                <label>Stock No</label>
                                <select class="form-control select2" id="stock_master" name="stock_master" style="width: 100%;">
                                    <option></option>
                                </select>
                                <span class="text-danger error-text stock_master_error"></span>
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
                                <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>price</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Input Price">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Disc</label>
                                <input type="text" class="form-control" id="disc" name="disc" placeholder="Input Discount">
                            </div>
                        </div>
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
    var table = $('#sppbDetailTable')
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
        "ajax": "{{route('local.record.po_internal_detail', $po_internal->id ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'qty', name: 'qty'},
            {data: 'price_format', name: 'price_format'},
            {data: 'disc_format', name: 'disc_format'},
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
    }
    @canany(['po.internal.store', 'po.internal.update'], Auth::user())
    $(function(){
        $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });

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
            $('#price').val(data.harga_jual - 0);
            $('#disc').val(0);
            format_decimal_limit();
        });

	    $('#PoInternalDetailForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.po_internal.store_detail', $po_internal->id) }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('po_internal_detail') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#PoInternalDetailForm').serialize(),
                    beforeSend:function(){
                        $(document).find('span.error-text').text('');
                    },
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#PoInternalDetailForm')[0].reset();
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
                            if(data.responseJSON.errors.qty !== undefined){
                                $('span.qty_error').text(data.responseJSON.errors.qty[0]);
                            }
                            if(data.responseJSON.errors.id_stock_master !== undefined)
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
        $('#PoInternalDetailForm')[0].reset();
        $('#formTitle').text('Create Stock Adjustment');
        $('#btnSave').attr('disabled',false);
        $('#stock_master').val(null).trigger('change');
        $('#button_modal').text('Save Changes');
        $('input[name=_method]').val('POST');
        $(document).find('span.error-text').text('');
    }
    @endcanany
    @can('po.internal.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('po_internal') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        beforeSend:function(){
            $(document).find('span.error-text').text('');
        },
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#button_modal').text('Update');
            $('#modal_title').text('Edit Item');
            $('#button_modal').attr('disabled',false);
            $('#id').val(data.id);
            $('#stock_master').val(data.id_stock_master);
            var newOption = new Option(data.stock_master.stock_no, data.id_stock_master, true, true);
            $('#stock_master').append(newOption).trigger('change');
            $('#qty').val(data.qty);
            $('#price').val(data.price);
            $('#disc').val(data.disc);
            $('#satuan').val(data.stock_master.satuan);
            $('#keterangan').val(data.keterangan);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('po.internal.open', Auth::user())
    function open_po_internal_Form() {
        $.ajax({
            url: "{{route('local.po_internal.open.index', $po_internal->id) }}",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                success(data.stat, data.message);
                print_sppb("{{ $po_internal->id }}");
                ajaxLoad("{{ route('local.po_internal.index') }}");
            },
            error : function() {
                error('Error', 'Nothing Data');
            }
        });
    }
    @endcan
    @can('po.internal.print', Auth::user())
    function print_po_internal(id){
        window.open("{{ url('po_internal_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('po.internal.delete', Auth::user())
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
                    url : "{{ url('po_internal_detail') }}" + '/' + id,
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
</script>
