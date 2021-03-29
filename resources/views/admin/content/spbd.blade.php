<section class="content-header">
    <h1>
        Create SPBD
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">SPBD</a></li>
        <li class="active"><a href="#"> Create SPBD</a></li>
    </ol>
</section>
<section class="content">
    @canany(['spbd.store', 'spbd.update'], Auth::user())
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create SPBD</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SpbdForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            {{-- <div class="col-xs-4">
                                <div class="form-group">
                                    <label>SPBD No</label>
                                    <input type="text" class="form-control" id="spbd_no" name="spbd_no" placeholder="Input SPBD No">
                                </div>
                            </div> --}}
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Vendor</label>
                                    <select class="form-control select2" id="vendor" name="vendor" style="width: 100%;">
                                        <option></option>
                                    </select>
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
    @endcanany
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List SPBD</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="SpbdTable">
                        <thead>
                            <tr>
                                <th>ID</th>
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
    var table = $('#SpbdTable')
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
        "ajax": "{{route('local.record.spbd') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'spbd_no', name: 'spbd_no'},
            {data: 'spbd_date', name: 'spbd_date'},
            {data: 'status_spbd', name: 'status_spbd'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    @canany(['spbd.store', 'spbd.update'], Auth::user())
    $(function(){
        $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });

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

	    $('#SpbdForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.spbd.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('spbd') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#SpbdForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#SpbdForm')[0].reset();
                            $('#vendor').val(null).trigger('change');
                            $('#btnSave').text('Submit');
                            success(data.stat, data.message);
                            if (data.process == 'add')
                            {
                                ajaxLoad("{{ url('spbd_detail') }}" + '/' + data.spbd_id);
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
        $('#SpbdForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create SPBD');
        $('#btnSave').attr('disabled',false);
        $('#vendor').val(null).trigger('change');
        $('input[name=_method]').val('POST');
    }
    @endcanany
    @can('spbd.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('spbd') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#btnSave').text('Update');
            $('#formTitle').text('Edit SPBD');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            var newOption = new Option(data.vendor.name, data.id_vendor, true, true);
            $('#vendor').append(newOption).trigger('change');
            // $('#spbd_no').val(data.spbd_no);
            $('#datemask').val(data.spbd_date);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('spbd.print', Auth::user())
    function print_spbd(id){
        window.open("{{ url('spbd_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('spbd.approve', Auth::user())
    function approve(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('spbd') }}" + '/' + id + "/approve",
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
    @can('spbd.delete', Auth::user())
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
                    url : "{{ url('spbd') }}" + '/' + id,
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
