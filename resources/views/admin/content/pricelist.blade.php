<section class="content-header">
    <h1>
        Pricelist
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Transaction</a></li>
        <li class="active"><a href="#"> Pricelist</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Pricelist</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="stockMasterTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock No</th>
                                <th> Name</th>
                                <th>Bin</th>
                                <th>SOH</th>
                                <th>Avg Modal</th>
                                <th>Avg Jual</th>
                                <th>Modal</th>
                                <th>Jual</th>
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
        <form role="form" id="PriceListForm" method="POST">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" id="id" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 id="modal_title" class="modal-title">Edit Price</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label>Stock No</label>
                                <input type="text" class="form-control" id="stock_master" name="stock_master" placeholder="Input QTY" readonly>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="name" readonly>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Harga Modal</label>
                                <input type="text" class="form-control" id="harga_modal" name="harga_modal" onchange="format_decimal_limit()">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Harga Jual</label>
                                <input type="text" class="form-control" id="harga_jual" name="harga_jual" onchange="format_decimal_limit()">
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
        "ajax": "{{route('local.record.pricelist') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'stock_no', name: 'stock_no'},
            {data: 'name', name: 'name'},
            {data: 'bin', name: 'bin'},
            {data: 'soh', name: 'soh'},
            {data: 'avg_modal_format', name: 'avg_modal_format'},
            {data: 'avg_jual_format', name: 'avg_jual_format'},
            {data: 'modal_format', name: 'modal_format'},
            {data: 'jual_format', name: 'jual_format'},
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

    $(function(){
	    $('#PriceListForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
                url = "{{ url('pricelist') . '/' }}" + id;
				$('input[name=_method]').val('PATCH');
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#PriceListForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#PriceListForm')[0].reset();
                            $('#btnSave').text('Submit');
                            $('#modal-input-item').modal('hide')
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
        url: "{{ url('pricelist') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            $('#stock_master').val(data.stock_no);
            $('#name').val(data.name);
            $('#harga_modal').val(data.harga_modal - 0);
            $('#harga_jual').val(data.harga_jual - 0);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function cancel(){
        save_method = 'add';
        $('#PriceListForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#btnSave').attr('disabled',false);
    }

</script>
