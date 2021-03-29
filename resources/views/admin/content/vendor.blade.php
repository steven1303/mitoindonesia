<section class="content-header">
    <h1>
        Vendor
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Settings</a></li>
        <li class="active"><a href="#"> Vendor</a></li>
    </ol>
</section>
<section class="content">
    @canany(['vendor.store', 'vendor.update'], Auth::user())
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create Vendor</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="vendorForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Input Name Branch">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Input City">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Email (Optional)</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Input Email">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" id="npwp" name="npwp" placeholder="Input NPWP">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Address 1</label>
                                    <input type="text" class="form-control" id="address1" name="address1" placeholder="Input Address">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Address 2</label>
                                    <input type="text" class="form-control" id="address2" name="address2" placeholder="Input Address">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Input Phone">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Telp (Optional)</label>
                                    <input type="text" class="form-control" id="telp" name="telp" placeholder="Input Telp">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>PIC (Optional)</label>
                                    <input type="text" class="form-control" id="pic" name="pic" placeholder="Input PIC">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="status_ppn" name="status_ppn"> PPN 10%
                                    </label>
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
                    <h3 class="box-title">List Vendor</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="vendorTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>NPWP</th>
                                <th>Phone</th>
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
    var table = $('#vendorTable')
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
        "ajax": "{{route('local.record.vendor') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'name', name: 'name'},
            {data: 'city', name: 'city'},
            {data: 'npwp', name: 'npwp'},
            {data: 'phone', name: 'phone'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    @canany(['vendor.store', 'vendor.update'], Auth::user())
    $(function(){
	    $('#vendorForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.vendor.store') }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('vendor') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#vendorForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#vendorForm')[0].reset();
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
        $('#vendorForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Add Branch');
        $('#btnSave').attr('disabled',false);
        $('input[name=_method]').val('POST');
    }
    @endcanany
    @can('vendor.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('vendor') }}" + '/' + id + "/edit",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#btnSave').text('Update');
            $('#formTitle').text('Edit Customer');
            $('#btnSave').attr('disabled',false);
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#city').val(data.city);
            $('#address1').val(data.address1);
            $('#address2').val(data.address2);
            $('#phone').val(data.phone);
            $('#npwp').val(data.npwp);
            $('#pic').val(data.pic);
            $('#telp').val(data.telp);
            $('#email').val(data.email);
            if(data.status_ppn == 1){
                document.getElementById('status_ppn').checked  = true;
            }else{
                document.getElementById('status_ppn').checked  = false;
            }
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan

    @can('vendor.delete', Auth::user())
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
                    url : "{{ url('vendor') }}" + '/' + id,
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
