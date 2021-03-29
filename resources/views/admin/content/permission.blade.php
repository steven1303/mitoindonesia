<section class="content-header">
    <h1>
        Permission
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Tools</a></li>
        <li class="active"><a href="#"> Permission</a></li>
    </ol>
</section>
<section class="content">
    @canany(['permission.store', 'permission.update'], Auth::user())
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create Permission</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="permissionForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Permission Name</label>
                                    <input type="text" class="form-control" id="permission_name" name="permission_name" placeholder="Input Name Permission">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Permission For</label>
                                    <input type="text" class="form-control" id="permission_for" name="permission_for" placeholder="Input Category Permission">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Permission Status</label>
                                    <select class="form-control"  id="status" name="status">
                                        <option value=1>Aktif</option>
                                        <option value=0>Non Aktif</option>
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
                    <h3 class="box-title">List Permission</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="permissionTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Permission Name</th>
                                <th> For</th>
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
    var table = $('#permissionTable')
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
        "ajax": "{{route('local.record.permission') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'name', name: 'name'},
            {data: 'for', name: 'for'},
            {data: 'stat', name: 'stat'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    @canany(['permission.store', 'permission.update'], Auth::user())
    $(function(){
	    $('#permissionForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.permission.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('permission') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#permissionForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#permissionForm')[0].reset();
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

    function cancel(){
        save_method = 'add';
        $('#permissionForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Add Roles');
        $('#btnSave').attr('disabled',false);
        $('input[name=_method]').val('POST');
    }
    @endcanany

    @can('permission.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('permission') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#btnSave').text('Update');
            $('#formTitle').text('Edit Roles');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            $('#permission_name').val(data.name);
            $('#permission_for').val(data.for);
            $('#status').val(data.stat);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan

    @can('permission.delete', Auth::user())
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
                    url : "{{ url('permission') }}" + '/' + id,
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
