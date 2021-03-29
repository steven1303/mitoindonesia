<section class="content-header">
    <h1>
        Adjustment  Detail
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Inventory</a></li>
        <li><a href="#">Adjustment Draft</a></li>
        <li class="active"><a href="#">Adjustment Detail</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Adjustment {{ $adj->adj_no }} <b>(  @if($adj->status == 1 ) Draft @endif @if($adj->status == 2 ) Open @endif @if($adj->status == 3 ) Approved @endif ) </b></h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SpbdForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Adjustment No</label>
                                    <input type="text" class="form-control" id="adj_no" name="adj_no" placeholder="Input SPBD No" readonly value="{{ $adj->adj_no }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask" name="date" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $adj->created_at }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($adj->status == 1 )
                                <button id="btnSave" type="button" onclick="open_adj_Form()" class="btn btn-success">Open / Request</button>
                            @endif
                            <button class="btn btn-secondary" type="button" onclick="ajaxLoad('{{route('local.adj.index')}}')">Save</button>
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
                    <h3 class="box-title">Adjustment Detail</h3><br/><br/>
                    @if ($adj->status == 1 )
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-input-item">Add Items</button>
                    @endif
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="stockMasterTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Price in</th>
                                <th>Price out</th>
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
        <form role="form" id="AdjDetailForm" method="POST">
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
                            <label>In QTY</label>
                            <input type="text" class="form-control" id="in_qty" name="in_qty" placeholder="Input QTY">
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label>Out QTY</label>
                            <input type="text" class="form-control" id="out_qty" name="out_qty" placeholder="Input QTY">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" readonly>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>Harga Modal</label>
                            <input type="text" class="form-control" id="harga_modal" name="harga_modal" placeholder="Input Modal" onchange="format_decimal_limit()">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="text" class="form-control" id="harga_jual" name="harga_jual" placeholder="Input Jual" onchange="format_decimal_limit()">
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
        "ajax": "{{route('local.record.adj_detail', $adj->id ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'in_qty', name: 'in_qty'},
            {data: 'out_qty', name: 'out_qty'},
            {data: 'format_modal', name: 'format_modal'},
            {data: 'format_jual', name: 'format_jual'},
            {data: 'satuan', name: 'satuan'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    function format_decimal_limit(){
        VMasker(document.getElementById("harga_modal")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });

        VMasker(document.getElementById("harga_jual")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });
    }
    @canany(['adjustment.store', 'adjustment.update'], Auth::user())
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
            $('#satuan').val(data.satuan);
            $('#harga_jual').val(data.harga_jual - 0);
            $('#harga_modal').val(data.harga_modal - 0);
            format_decimal_limit();
        });

	    $('#AdjDetailForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.adj.store_detail', $adj->id) }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('adj_detail') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#AdjDetailForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#AdjDetailForm')[0].reset();
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
    function cancel(){
        save_method = 'add';
        $('#AdjDetailForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#btnSave').attr('disabled',false);
        $('#stock_master').val(null).trigger('change');
        $('input[name=_method]').val('POST');
    }
    @endcanany
    @can('adjustment.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('adj') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#button_modal').text('Update');
            $('#modal_title').text('Edit Item');
            $('#button_modal').attr('disabled',false);
            $('#id').val(data.id);
            // $('#stock_master').val(data.id_stock_master);
            var newOption = new Option(data.stock_master.stock_no, data.id_stock_master, true, true);
            $('#stock_master').append(newOption).trigger('change');
            $('#in_qty').val(data.in_qty - 0);
            $('#out_qty').val(data.out_qty- 0);
            $('#harga_modal').val(data.harga_modal - 0);
            $('#harga_jual').val(data.harga_jual - 0);
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
    @can('adjustment.update', Auth::user())
    function open_adj_Form() {
        $.ajax({
        url: "{{route('local.adj.open.index', $adj->id) }}",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            success(data.stat, data.message);
            print_adj( "{{ $adj->id }}" );
            ajaxLoad("{{ route('local.adj.index') }}");
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('adjustment.print', Auth::user())
    function print_adj(id){
        window.open("{{ url('adj_print') }}" + '/' + id,"_blank");
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
                    url : "{{ url('adj_detail') }}" + '/' + id,
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
