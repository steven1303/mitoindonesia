<section class="content-header">
    <h1>
        Create Invoice
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">SPBD</a></li>
        <li class="active"><a href="#"> Create Invoice</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create Invoice</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="InvoiceForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>TOP Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask2" name="top_date" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>SPPB No</label>
                                    <select class="form-control select2" id="sppb" name="sppb" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Vendor Name" readonly>
                                    <input type="hidden" id="customer" name="customer">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Customer</label>
                                    <input type="text" class="form-control" id="po_cust" name="po_cust" placeholder="Input PO No Customer" readonly>
                                </div>
                            </div>
                            <div class="col-xs-2">
                                <div class="form-group">
                                    <label>Mata Uang</label>
                                    <input type="text" class="form-control" id="mata_uang" name="mata_uang" placeholder="Input Mata Uang">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Alamat Customer</label>
                                    <input type="text" class="form-control" id="inv_kirimke" name="inv_kirimke" placeholder="Input Alamat Customer" readonly>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Alamat Pengantaran</label>
                                    <input type="text" class="form-control" id="inv_alamatkirim" name="inv_alamatkirim" placeholder="Input Alamat Pengantaran">
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
                    <h3 class="box-title">List Invoice</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="invoiceTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Invoice No</th>
                                <th>SPPB No</th>
                                <th>Date</th>
                                <th>total</th>
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
    var table = $('#invoiceTable')
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
        "ajax": "{{route('local.record.inv') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'inv_no', name: 'inv_no'},
            {data: 'sppb_no', name: 'sppb_no'},
            {data: 'date', name: 'date'},
            {data: 'total_inv', name: 'total_inv'},
            {data: 'status_inv', name: 'status_inv'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    $(function(){
        $('#datemask1').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
        $('#datemask2').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });

        $('#sppb').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.search.sppb') }}",
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

        $('#sppb').on('select2:select', function (e) {
            var data = e.params.data;
            $('#customer').val(data.customer);
            $('#customer_name').val(data.customer_name);
            $('#po_cust').val(data.customer_po);
            $('#inv_kirimke').val(data.customer_address);
        });

	    $('#InvoiceForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.inv.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('inv') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#InvoiceForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#InvoiceForm')[0].reset();
                            $('#btnSave').text('Submit');
                            $('#spbd').val(null).trigger('change');
                            success(data.stat, data.message);
                            if (data.process == 'add')
                            {
                                ajaxLoad("{{ url('inv_detail') }}" + '/' + data.inv_id);
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

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('inv') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#btnSave').text('Update');
            $('#formTitle').text('Edit Invoice');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            // $('#inv_no').val(data.inv_no);
            $('#datemask1').val(data.datemask1);
            $('#datemask2').val(data.datemask2);
            var newOption = new Option(data.sppb_no, data.sppb, true, true);
            $('#sppb').append(newOption).trigger('change');
            $('#customer_name').val(data.customer_name);
            $('#customer').val(data.customer);
            $('#po_cust').val(data.po_cust);
            $('#inv_kirimke').val(data.inv_kirimke);
            $('#inv_alamatkirim').val(data.inv_alamatkirim);
            $('#mata_uang').val(data.mata_uang);
            // $('#ppn').val(data.ppn - 0);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function print_inv(id){
        window.open("{{ url('inv_print') }}" + '/' + id,"_blank");
    }

    function approve(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('inv') }}" + '/' + id + "/approve",
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
        $('#InvoiceForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Invoice');
        $('#btnSave').attr('disabled',false);
        $('#sppb').val(null).trigger('change');
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
                    url : "{{ url('inv') }}" + '/' + id,
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
