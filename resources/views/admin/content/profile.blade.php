<section class="content-header">
    <h1>
        Admin / User
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Tools</a></li>
        <li class="active"><a href="#"> Admin</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Profile {{Auth::user()->name}}</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="adminForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Input Username" value="{{Auth::user()->username}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Input nama" value="{{Auth::user()->name}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Input email" value="{{Auth::user()->email}}" readonly>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control" id="role" disabled>
                                        <option value="0">Empty</option>
										@foreach ($roles as $role)
										<option value="{{ $role->id }}" @if ( Auth::user()->id_role == $role->id ) selected @endif >{{ $role->role_name }}</option>
										@endforeach
									</select>
                                </div>
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select name="branch" class="form-control" id="branch" @cannot('admin.branch', Auth::user()) disabled @endcannot>
                                        <option value="0">Empty</option>
										@foreach ($branches as $branch)
										<option value="{{ $branch->id }}" @if (Auth::user()->id_branch == $branch->id ) selected @endif >{{ $branch->name }}</option>
										@endforeach
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
</section>
<script type="text/javascript">
    $(function(){
	    $('#adminForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
                $('input[name=_method]').val('PATCH');
                url = "{{route('local.profile.update', Auth::user()->id ) }}";
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#adminForm').serialize(),
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#adminForm')[0].reset();
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
</script>
