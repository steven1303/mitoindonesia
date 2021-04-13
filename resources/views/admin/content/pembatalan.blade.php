<section class="content-header">
    <h1>
        Pembatalan
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Settings</a></li>
        <li class="active"><a href="#"> Pembatalan</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @can('pembatalan.po.stock', Auth::user())
                    <li class="active"><a href="#tab_1" data-toggle="tab">PO Stock</a></li>
                    @endcan
                    @can('pembatalan.po.non.stock', Auth::user())
                    <li><a href="#tab_2" data-toggle="tab">PO Non Stock</a></li>
                    @endcan
                    @can('pembatalan.invoice', Auth::user())
                    <li><a href="#tab_3" data-toggle="tab">Invoice</a></li>
                    @endcan
                </ul>
              <div class="tab-content">
                @can('pembatalan.po.stock', Auth::user())
                <div class="tab-pane active" id="tab_1">
                    <form role="form" id="PoStockForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Stock</label>
                                    <select class="form-control select2" id="po_stock_no" name="po_stock_no" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Keterangan PO Stock</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input keterangan">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button id="btnSave" type="submit" class="btn btn-primary">Submit</button>
                            <button class="btn btn-secondary" type="button" onclick="cancel()">Cancel</button>
                        </div>
                    </form>
                </div>
                @endcan
                <!-- /.tab-pane -->
                @can('pembatalan.po.non.stock', Auth::user())
                <div class="tab-pane" id="tab_2">
                    <form role="form" id="PoNonStockForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Non Stock</label>
                                    <select class="form-control select2" id="po_non_stock_no" name="po_non_stock_no" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Keterangan PO Non Stock</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input keterangan">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button class="btn btn-secondary" type="button" onclick="cancel()">Cancel</button>
                        </div>
                    </form>
                </div>
                @endcan
                <!-- /.tab-pane -->
                @can('pembatalan.invoice', Auth::user())
                <div class="tab-pane" id="tab_3">
                    <form role="form" id="InvoiceForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Invoice No</label>
                                    <select class="form-control select2" id="invoice_no" name="invoice_no" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>                               
                            </div>                            
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label></label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="status_sppb" name="status_sppb"> SPPB Batal
                                         </label>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Keterangan Invoice</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input keterangan">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button class="btn btn-secondary" type="button" onclick="cancel()">Cancel</button>
                        </div>
                    </form>
                </div>
                @endcan
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List PO Internal</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="poStockTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CR No</th>
                                <th>Type</th>
                                <th>Doc No</th>
                                <th>Date</th>
                                <th>Status</th>
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
<script type="text/javascript">
    var save_method;
    save_method = 'add';
    var table = $('#poStockTable')
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
        "ajax": "{{route('local.record.pembatalan') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'pembatalan_no', name: 'pembatalan_no'},
            {data: 'type_pembatalan', name: 'type_pembatalan'},
            {data: 'doc_no', name: 'doc_no'},
            {data: 'tanggal', name: 'tanggal'},
            {data: 'status_pembatalan', name: 'status_pembatalan'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    $(function(){

        $('#po_stock_no').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.pembatalan.search.po_stock') }}",
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

        $('#po_non_stock_no').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.pembatalan.search.po_non_stock') }}",
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

        $('#invoice_no').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.pembatalan.search.inv') }}",
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

	    $('#PoStockForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
                url = "{{route('local.pembatalan.store', 1) }}";
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#PoStockForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#PoStockForm')[0].reset();
                            $('#po_stock_no').val(null).trigger('change');
                            success(data.stat, data.message);
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

        $('#PoNonStockForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
                url = "{{route('local.pembatalan.store', 2) }}";
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#PoNonStockForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#PoNonStockForm')[0].reset();
                            $('#po_non_stock_no').val(null).trigger('change');
                            success(data.stat, data.message);
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

        $('#InvoiceForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
                url = "{{route('local.pembatalan.store', 3) }}";
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#InvoiceForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#InvoiceForm')[0].reset();
                            $('#btnSave').text('Submit');
                            $('#invoice_no').val(null).trigger('change');
                            success(data.stat, data.message);
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

    function print_pembatalan(id){
        window.open("{{ url('pembatalan_print') }}" + '/' + id,"_blank");
    }

    function approve(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('pembatalan') }}" + '/' + id + "/approve",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            table.ajax.reload();
            success(data.stat, data.message);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function cancel(){
        save_method = 'add';
        $('#PoStockForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Po Internal');
        $('#customer').val(null).trigger('change');
        $('#btnSave').attr('disabled',false);
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
                    url : "{{ url('pembatalan') }}" + '/' + id,
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
