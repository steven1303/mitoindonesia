<section class="content-header">
    <h1>
        PO Stock  @if($po_stock->po_status == 1 ) Draft @endif @if($po_stock->po_status == 2 ) Open @endif
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">PO Stock</a></li>
        <li><a href="#">PO Stock Draft</a></li>
        <li class="active"><a href="#">PO Stock Detail</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">PO Stock {{ $po_stock->po_no }} <b>(  @if($po_stock->po_status == 1 ) Draft @endif @if($po_stock->po_status == 2 ) Open @endif @if($po_stock->po_status == 3 ) Approved @endif ) </b></h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SpbdForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>SPBD No</label>
                                    <input type="text" class="form-control" id="spbd_no" name="spbd_no" placeholder="Input SPBD No" readonly value="{{ $po_stock->spbd->spbd_no }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <input type="text" class="form-control" id="vendor" name="vendor" placeholder="Input Vendor" readonly value="{{ $po_stock->spbd->vendor->name }}">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label>PPN</label>
                                    <input type="text" class="form-control" id="ppn" name="ppn" placeholder="Input Vendor" readonly value="{{ $po_stock->ppn - 0 }} %">
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask" name="spbd_date" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $po_stock->po_ord_date }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button id="btnSave" type="button" onclick="open_po_stock_Form()" class="btn btn-success">Open / Request</button>
                            <button class="btn btn-secondary" type="button" onclick="ajaxLoad('{{route('local.po_stock.index')}}')">Save</button>
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
                    <h3 class="box-title">PO Stock item</h3><br/><br/>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="poStockDetailTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>QTY</th>
                                <th>price</th>
                                <th>disc</th>
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
                    <h3 class="box-title">SPBD item</h3><br/><br/>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="poSpbdTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>QTY</th>
                                <th>Order</th>
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

<div class="modal fade" id="modal-input-item">
    <div class="modal-dialog">
        <form role="form" id="PoDetailForm" method="POST">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="id_spbd_detail" name="id_spbd_detail">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 id="modal_title" class="modal-title">Adds Items</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Stock No</label>
                                <input type="text" class="form-control" id="stock_master" name="stock_master" placeholder="Input QTY" readonly>
                                <input type="hidden" id="id_stock_master" name="id_stock_master">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>QTY</label>
                                <input type="text" class="form-control" id="qty" name="qty" placeholder="Input QTY" readonly>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" readonly>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control number" id="price" name="price" placeholder="Price"  oninput="format_decimal_limit()">
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Discount</label>
                                <input type="text" class="form-control number" id="disc" name="disc" placeholder="Discount"  oninput="format_decimal_limit()">
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label>Keterangan SPBD</label>
                                <input type="text" class="form-control" id="keterangan1" name="keterangan1" placeholder="Input keterangan" readonly>
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label>Keterangan PO Stock</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input keterangan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"  onclick="cancel()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var save_method;
    save_method = 'add';
    var table = $('#poSpbdTable')
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
        "ajax": "{{route('local.record.spbd_detail', [ 'id' => $po_stock->id_spbd, 'po_stat' => 1] ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'qty', name: 'qty'},
            {data: 'po_qty', name: 'po_qty'},
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
        "ajax": "{{route('local.record.po_stock_detail', $po_stock->id ) }}",
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

    $(function(){

        // var cleaveC = new Cleave('#price', {
        //     numeral: true,
        //     numeralThousandsGroupStyle: 'thousand'
        // });
        // var cleaveC = new Cleave('#disc', {
        //     numeral: true,
        //     numeralThousandsGroupStyle: 'thousand'
        // });


        $(".number").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });

	    $('#PoDetailForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.po_stock.store_detail', $po_stock->id) }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('po_stock_detail') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#PoDetailForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        table1.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#PoDetailForm')[0].reset();
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

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('po_stock_detail') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#btnSave').text('Update');
            $('#modal_title').text('Edit Item');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            $('#id_spbd_detail').val(data.id);
            $('#stock_master').val(data.stock_master);
            $('#id_stock_master').val(data.id_stock_master);
            $('#qty').val(data.qty);
            $('#price').val(data.price);
            $('#disc').val(data.disc);
            $('#satuan').val(data.satuan);
            $('#keterangan').val(data.keterangan);
            $('#keterangan1').val(data.keterangan1);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function addItem(id) {
        save_method = 'add';
        $.ajax({
        url: "{{ url('spbd') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#btnSave').text('Update');
            $('#formTitle').text('Add Item');
            $('#btnSave').attr('disabled',false);
            $('#id_spbd_detail').val(data.id);
            $('#stock_master').val(data.stock_master.stock_no);
            $('#id_stock_master').val(data.id_stock_master);
            $('#qty').val(data.qty);
            $('#satuan').val(data.stock_master.satuan);
            $('#keterangan1').val(data.keterangan);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function open_po_stock_Form() {
        $.ajax({
        url: "{{route('local.po_stock.open.index', $po_stock->id) }}",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            success(data.stat, data.message);
            print_po_stock("{{ $po_stock->id }}");
            ajaxLoad("{{ route('local.po_stock.index') }}");
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function print_po_stock(id){
        window.open("{{ url('po_stock_print') }}" + '/' + id,"_blank");
    }

    function cancel(){
        save_method = 'add';
        $('#PoDetailForm')[0].reset();
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
                    url : "{{ url('po_stock_detail') }}" + '/' + id,
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
</script>
