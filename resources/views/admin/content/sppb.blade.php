<section class="content-header">
    <h1>
        Create SPPB
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">SPPB</a></li>
        <li class="active"><a href="#"> Create SPPB</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create SPPB</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SppbForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>SPPB No</label>
                                    <input type="text" class="form-control" id="sppb_no" name="sppb_no" placeholder="Input SPPB No">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <select class="form-control select2" id="customer" name="customer" style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Customer</label>
                                    <input type="text" class="form-control" id="sppb_po_cust" name="sppb_po_cust" placeholder="Input PO Customer">
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
                    <h3 class="box-title">List SPPB</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="sppbTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>SPPB No</th>
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
    var table = $('#sppbTable')
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
        "ajax": "{{route('local.record.sppb') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'sppb_no', name: 'sppb_no'},
            {data: 'sppb_date', name: 'sppb_date'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    $(function(){

        $('#customer').select2({
            placeholder: "Select and Search",
            ajax:{
                url:"{{route('local.search.customer') }}",
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

	    $('#SppbForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.sppb.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('sppb') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#SppbForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#SppbForm')[0].reset();
                            $('#customer').val(null).trigger('change');
                            $('#btnSave').text('Submit');
                            success(data.stat, data.message);
                            if (data.process == 'add')
                            {
                                ajaxLoad("{{ url('sppb_detail') }}" + '/' + data.sppb_id);
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
        url: "{{ url('sppb') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#btnSave').text('Update');
            $('#formTitle').text('Edit SPBD');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            var newOption = new Option(data.customer.name, data.id_customer, true, true);
            $('#sppb_no').val(data.sppb_no);
            $('#customer').append(newOption).trigger('change');
            $('#sppb_po_cust').val(data.sppb_po_cust);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }

    function print_sppb(id){
        window.open("{{ url('sppb_print') }}" + '/' + id,"_blank");
    }

    function approve(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('sppb') }}" + '/' + id + "/approve",
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
        $('#SppbForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Stock Adjustment');
        $('#btnSave').attr('disabled',false);
        $('#customer').val(null).trigger('change');
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
                    url : "{{ url('sppb') }}" + '/' + id,
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
