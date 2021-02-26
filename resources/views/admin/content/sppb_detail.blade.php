<section class="content-header">
    <h1>
        SPPB  @if($sppb->sppb_status == 1 ) Draft @endif @if($sppb->sppb_status == 2 ) Open @endif
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">SPPB</a></li>
        <li><a href="#">SPPB Draft</a></li>
        <li class="active"><a href="#">SPPB Detail</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">SPPB {{ $sppb->sppb_no }}</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SpbdForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>SPPB No</label>
                                    <input type="text" class="form-control" id="sppb_no" name="sppb_no" placeholder="Input SPBD No" readonly value="{{ $sppb->sppb_no }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <input type="text" class="form-control" id="customer" name="customer" placeholder="Input Vendor" readonly value="{{ $sppb->customer->name }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Customer</label>
                                    <input type="text" class="form-control" id="sppb_po_cust" name="sppb_po_cust" placeholder="Input PO Customer" readonly value="{{ $sppb->sppb_po_cust }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask" name="spbd_date" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $sppb->sppb_date }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($sppb->sppb_status == 1 )
                                <button id="btnSave" type="button" onclick="open_sppb_Form()" class="btn btn-success">Open / Request</button>
                            @endif
                            <button class="btn btn-secondary" type="button" onclick="ajaxLoad('{{route('local.sppb.index')}}')">Save</button>
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
                    <h3 class="box-title">SPPB Detail</h3><br/><br/>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-input-item">Add Items</button>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="sppbDetailTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>QTY</th>
                                <th>Satuan</th>
                                {{-- <th>Price</th> --}}
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

<div class="modal fade" id="modal-input-item">
    <div class="modal-dialog">
        <form role="form" id="SpbdDetailForm" method="POST">
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
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label>QTY</label>
                            <input type="text" class="form-control" id="qty" name="qty" placeholder="Input QTY">
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" readonly>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Price" readonly>
                        </div>
                    </div>
                    <div class="col-xs-9">
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
        "ajax": "{{route('local.record.sppb_detail', $sppb->id ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'qty', name: 'qty'},
            {data: 'satuan', name: 'satuan'},
            // {data: 'status', name: 'status'},
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
    }

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
            format_decimal_limit();
        });

	    $('#SpbdDetailForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.sppb.store_detail', $sppb->id) }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('sppb_detail') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#SpbdDetailForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#SpbdDetailForm')[0].reset();
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
				    error : function(){
					    error('Error', 'Oops! Something Error! Try to reload your page first...');
				    }
			    });
			    return false;
		    }
	    });
    });

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('sppb') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
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
            // $('#price').val(data.price);
            $('#satuan').val(data.stock_master.satuan);
            $('#keterangan').val(data.keterangan);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function open_sppb_Form() {
        $.ajax({
        url: "{{route('local.sppb.open.index', $sppb->id) }}",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            success(data.stat, data.message);
            print_sppb("{{ $sppb->id }}");
            ajaxLoad("{{ route('local.sppb.index') }}");
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function print_sppb(id){
        window.open("{{ url('sppb_print') }}" + '/' + id,"_blank");
    }

    function cancel(){
        save_method = 'add';
        $('#SpbdDetailForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Stock Adjustment');
        $('#btnSave').attr('disabled',false);
        $('#stock_master').val(null).trigger('change');
        $('input[name=_method]').val('POST');
    }

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
                    url : "{{ url('sppb_detail') }}" + '/' + id,
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
</script>
