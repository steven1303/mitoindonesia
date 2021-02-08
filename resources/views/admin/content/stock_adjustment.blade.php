<section class="content-header">
    <h1>
        Stock Adjustment
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Inventory</a></li>
        <li class="active"><a href="#"> Stock Adjustment</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create Stock Adjustment</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="stockAdjForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Stock Master</label>
                                    <select class="form-control select2" id="stock_master" name="stock_master" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label>Order QTY</label>
                                    <input type="text" class="form-control" id="order_qty" name="order_qty" placeholder="Input Order QTY">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label>Sell QTY</label>
                                    <input type="text" class="form-control" id="sell_qty" name="sell_qty" placeholder="Input Sell QTY">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label>In QTY</label>
                                    <input type="text" class="form-control" id="in_qty" name="in_qty" placeholder="Input In QTY">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label>Out QTY</label>
                                    <input type="text" class="form-control" id="out_qty" name="out_qty" placeholder="Input Out QTY">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Bin</label>
                                    <input type="text" class="form-control" id="bin" name="bin" placeholder="Input Bin">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Harga Modal</label>
                                    <input type="text" class="form-control" id="harga_modal" name="harga_modal" placeholder="Input Harga Modal">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <input type="text" class="form-control" id="harga_jual" name="harga_jual" placeholder="Input Harga Jual">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" id="ket" name="ket" placeholder="Input Keterangan">
                                </div>
                            </div>
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
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Stock Adjustment</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="stockMasterTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Doc No</th>
                                <th>Order</th>
                                <th>Sell</th>
                                <th>In</th>
                                <th>Out</th>
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
        "ajax": "{{route('local.record.stock_adj') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'stock_no', name: 'stock_no'},
            {data: 'doc_no', name: 'doc_no'},
            {data: 'order_qty', name: 'order_qty'},
            {data: 'sell_qty', name: 'sell_qty'},
            {data: 'in_qty', name: 'in_qty'},
            {data: 'out_qty', name: 'out_qty'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    $(function(){
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

	    $('#stockAdjForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.stock_adj.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('stock_adj') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#stockAdjForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#stock_master').val(null).trigger('change');
                            $('#stockAdjForm')[0].reset();
                            $('#btnSave').text('Submit');
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

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('stock_adj') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#btnSave').text('Update');
            $('#formTitle').text('Edit Adjustment');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            $('#stock_master').val(data.id_stock_master);
            var newOption = new Option(data.stock_master.stock_no, data.id_stock_master, true, true);
            $('#stock_master').append(newOption).trigger('change');
            $('#order_qty').val(data.order_qty);
            $('#sell_qty').val(data.sell_qty);
            $('#in_qty').val(data.in_qty);
            $('#out_qty').val(data.out_qty);
            $('#bin').val(data.bin);
            $('#harga_modal').val(data.harga_modal);
            $('#harga_jual').val(data.harga_jual);
            $('#ket').val(data.ket);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function cancel(){
        save_method = 'add';
        $('#stockAdjForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Stock Adjustment');
        $('#btnSave').attr('disabled',false);
        $('input[name=_method]').val('POST');
        $('#stock_master').val(null).trigger('change');
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
                    url : "{{ url('stock_adj') }}" + '/' + id,
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
