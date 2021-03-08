<section class="content-header">
    <h1>
        Create Receipt
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Receipt</a></li>
        <li class="active"><a href="#"> Create Receipt</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create Receipt</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="RecForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            {{-- <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Receipt No</label>
                                    <input type="text" class="form-control" id="rec_no" name="rec_no" placeholder="Input Rec No">
                                </div>
                            </div> --}}
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Stock No</label>
                                    <select class="form-control select2" id="po_stock" name="po_stock" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="Vendor Name" readonly>
                                    <input type="hidden" id="vendor" name="vendor">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Invoice Customer</label>
                                    <input type="text" class="form-control" id="rec_inv_ven" name="rec_inv_ven" placeholder="Invoice Customer">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PPN</label>
                                    <input type="text" class="form-control" id="ppn" name="ppn" placeholder="Input % PPN" readonly>
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
                    <h3 class="box-title">List Receipt</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="recTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Receipt No</th>
                                <th>PO No</th>
                                <th>Date</th>
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
    var table = $('#recTable')
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
        "ajax": "{{route('local.record.rec') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'rec_no', name: 'rec_no'},
            {data: 'po_stock_no', name: 'po_stock_no'},
            {data: 'rec_date', name: 'rec_date'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    function format_decimal_limit(){
        VMasker(document.getElementById("ppn")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });
    }

    $(function(){
        $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });

        $('#po_stock').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.search.po_stock') }}",
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

        $('#po_stock').on('select2:select', function (e) {
            var data = e.params.data;
            $('#vendor').val(data.vendor);
            $('#vendor_name').val(data.vendor_name);
            $('#ppn').val(data.ppn);
            format_decimal_limit();
        });

	    $('#RecForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.rec.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('rec') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#RecForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#RecForm')[0].reset();
                            $('#btnSave').text('Submit');
                            $('#po_stock').val(null).trigger('change');
                            success(data.stat, data.message);
                            if (data.process == 'add')
                            {
                                ajaxLoad("{{ url('rec_detail') }}" + '/' + data.rec_id);
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
        url: "{{ url('rec') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#btnSave').text('Update');
            $('#formTitle').text('Edit PO Stock');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            // $('#rec_no').val(data.rec_no);
            var newOption = new Option(data.name_po_stock, data.po_stock, true, true);
            $('#po_stock').append(newOption).trigger('change');
            $('#vendor').val(data.id_vendor);
            $('#vendor_name').val(data.vendor_name);
            $('#datemask').val(data.rec_date);
            $('#rec_inv_ven').val(data.rec_inv_ven);
            $('#ppn').val(data.ppn);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function print_receipt(id){
        window.open("{{ url('receipt_print') }}" + '/' + id,"_blank");
    }

    function cancel(){
        save_method = 'add';
        $('#RecForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Stock Adjustment');
        $('#po_stock').val(null).trigger('change');
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
                    url : "{{ url('rec') }}" + '/' + id,
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
