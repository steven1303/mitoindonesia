<section class="content-header">
    <h1>
        Create Transfer Branch
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Inventory</a></li>
        <li class="active"><a href="#"> Create Transfer Receipt</a></li>
    </ol>
</section>
<section class="content">
    @canany(['adjustment.store', 'adjustment.update'], Auth::user())
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create Transfer Receipt</h3>
                </div>
                <form role="form" id="TransferReceiptForm" method="POST">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="id_branch" name="id_branch">
                    <input type="hidden" id="id_transfer" name="id_transfer">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="box-body">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Transfer No</label>
                                <select class="form-control select2" id="transfer" name="transfer" style="width: 100%;" readonly>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>From Branch</label>
                                <input type="text" class="form-control" id="branch" name="branch" readonly>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button id="btnSave" type="submit" class="btn btn-primary">Create</button>
                        <button type="button" class="btn btn-secondary" onclick="cancel()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcanany
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Transfer Receipt</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="transferReceiptTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Document No</th>
                                <th>From Branch</th>
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
    var table = $('#transferReceiptTable')
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
        "ajax": "{{route('local.record.transfer_receipt') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'receipt_transfer_no', name: 'receipt_transfer_no'},
            {data: 'branch_name', name: 'branch_name'},
            {data: 'receipt_transfer_date', name: 'receipt_transfer_date'},
            {data: 'status_transfer', name: 'status_transfer'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });
    @canany(['transfer.store', 'transfer.update'], Auth::user())
    $(function(){

        $('#transfer').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.search.transfer') }}",
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

        $('#transfer').on('select2:select', function (e) {
            var data = e.params.data;
            $('#id_transfer').val(data.id);
            $('#id_branch').val(data.branch_id);
            $('#branch').val(data.branch_name);
        });

	    $('#TransferReceiptForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
                if (save_method == 'add')
			    {
                    url = "{{route('local.transfer_receipt.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('transfer_receipt') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#TransferReceiptForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#TransferReceiptForm')[0].reset();
                            cancel();
                            success(data.stat, data.message);
                            if (data.process == 'add')
                            {
                                ajaxLoad("{{ url('transfer_receipt_detail') }}" + '/' + data.id);
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
        $('#TransferReceiptForm')[0].reset();
        $('#btnSave').text('Create');
        $('#formTitle').text('Create Receipt Transfer');
        $('#transfer').val(null).trigger('change');
        $("#transfer").prop("disabled", false);
        $('#btnSave').attr('disabled',false);
        $('input[name=_method]').val('POST');
    }
    @endcanany
    @can('transfer.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('transfer_receipt') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#btnSave').text('Update');
            $('#formTitle').text('Edit Transfer Receipt');
            $('#id').val(data.id);
            var newOption = new Option(data.receipt_transfer_no, data.id_transfer, true, true);
            $('#transfer').append(newOption).trigger('change');
            $("#transfer").prop("disabled", true);
            $('#branch').val(data.from.city);
            $('#keterangan').val(data.keterangan);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('transfer.print', Auth::user())
    function print_transfer(id){
        window.open("{{ url('transfer_receipt_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('adjustment.approve', Auth::user())
    function approve(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('transfer_receipt') }}" + '/' + id + "/approve",
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
    @can('transfer.delete', Auth::user())
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
                    url : "{{ url('transfer_receipt') }}" + '/' + id,
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
