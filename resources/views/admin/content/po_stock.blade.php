<section class="content-header">
    <h1>
        Create PO Stock
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Ordering</a></li>
        <li class="active"><a href="#"> Create PO Stock</a></li>
    </ol>
</section>
<section class="content">
    @canany(['po.stock.store', 'po.stock.update'], Auth::user())
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create PO Stock</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="PoStockForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>SPBD No</label>
                                    <select class="form-control select2" id="spbd" name="spbd" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <select class="form-control select2" id="vendor" name="vendor" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="Vendor Name" readonly>
                                    <input type="hidden" id="vendor" name="vendor">
                                </div>
                            </div> -->
                            {{-- <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PPN</label>
                                    <input type="text" class="form-control" id="ppn" name="ppn" placeholder="PPN %" readonly>
                                </div>
                            </div> --}}
                        </div>
                        <div class="box-footer">
                            <button id="btnSave" type="submit" class="btn btn-primary">Submit</button>
                            <button class="btn btn-secondary" type="button" onclick="cancel()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcanany
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List PO Stock</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="poStockTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>PO No</th>
                                <th>SPBD No</th>
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
        "ajax": "{{route('local.record.po_stock') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'po_no', name: 'po_no'},
            {data: 'no_spbd', name: 'no_spbd'},
            {data: 'po_ord_date', name: 'po_ord_date'},
            {data: 'status_po_stock', name: 'status_po_stock'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    @canany(['po.stock.store', 'po.stock.update'], Auth::user())
    $(function(){
        $('#vendor').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.search.vendor') }}",
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

        $('#spbd').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.search.spbd') }}",
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

        $('#spbd').on('select2:select', function (e) {
            var data = e.params.data;
            $('#vendor').val(data.vendor);
            $('#vendor_name').val(data.vendor_name);
            // $('#ppn').val(data.ppn);
        });

	    $('#PoStockForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.po_stock.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('po_stock') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#PoStockForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#PoStockForm')[0].reset();
                            $('#btnSave').text('Submit');
                            $('#spbd').val(null).trigger('change');
                            success(data.stat, data.message);
                            if (data.process == 'add')
                            {
                                ajaxLoad("{{ url('po_stock_detail') }}" + '/' + data.po_id);
                            }
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
        $('#PoStockForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Po Stock');
        $('#spbd').val(null).trigger('change');
        $('#btnSave').attr('disabled',false);
        $('input[name=_method]').val('POST');
    }
    @endcanany
    @can('po.stock.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('po_stock') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#btnSave').text('Update');
            $('#formTitle').text('Edit PO Stock');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            $('#po_no').val(data.po_no);
            var newOption = new Option(data.name_spbd, data.id_spbd, true, true);
            $('#spbd').append(newOption).trigger('change');
            $('#vendor').val(data.id_vendor);
            $('#vendor_name').val(data.vendor_name);
            // $('#ppn').val(data.ppn);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('po.stock.print', Auth::user())
    function print_po_stock(id){
        window.open("{{ url('po_stock_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('po.stock.verify1', Auth::user())
    function verify1(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('po_stock') }}" + '/' + id + "/verify1",
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
    @endcan
    @can('po.stock.verify2', Auth::user())
    function verify2(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('po_stock') }}" + '/' + id + "/verify2",
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
    @endcan
    @can('po.stock.approve', Auth::user())
    function approve(id,button_id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('po_stock') }}" + '/' + id + "/approve",
        type: "GET",
        dataType: "JSON",
        beforeSend:function(){
            document.getElementById(button_id).disabled = true;
        },
        success: function(data) {
            table.ajax.reload();
            success(data.stat, data.message);
            // fungsi print otomatis
            print_po_stock(id);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('po.stock.delete', Auth::user())
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
                    url : "{{ url('po_stock') }}" + '/' + id,
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
