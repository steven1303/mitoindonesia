<section class="content-header">
    <h1>
        Permission
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Tools</a></li>
        <li><a href="#">Role</a></li>
        <li class="active"><a href="#"> Accesss</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Access Permission</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="formPermission_role" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id" value="{{ $role->id }}">
                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="form-group col-md-2">
                                    <label>Role Name</label>
                                    <input type="text" value="{{ $role->role_name }}" class="form-control form-control-sm" readonly="true">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="permission"><b>Admins Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Admins')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Roles Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Roles')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Permissions Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Permissions')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Branch Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Branch')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Customer Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Customer')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Vendor Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Vendor')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="permission"><b>StockMaster Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'StockMaster')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Pricelist Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Pricelist')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>SPBD Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'SPBD')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>PoStock Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'PoStock')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Receipt Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Receipt')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>SPB Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'SPB')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="permission"><b>PoNonStock Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'PoNonStock')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>SPPB Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'SPPB')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>PoInternal Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'PoInternal')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Invoice Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Invoice')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Adjustment Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Adjustment')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Pelunasan Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Pelunasan')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="permission"><b>Pembatalan Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Pembatalan')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                <div class="col-md-2">
                                    <label for="permission"><b>Transfer Access</b></label>
                                    @foreach ($permissions as $permission)
                                    @if ($permission->for == 'Transfer')
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="permission[]" value="{{ $permission->id }}"
                                            @foreach ($role->permissions as $permit)
                                            @if ($permit->id == $permission->id)
                                            checked
                                            @endif
                                            {{-- @if ($role->id == 1)
                                            disabled
                                            @endif --}}
                                            @endforeach
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">

                            </div>
                        </div>
                        <div class="box-footer">
                            <button id="btnSave" type="submit" class="btn btn-primary">Submit</button>
                            {{-- <button class="btn btn-secondary" type="button" onclick="cancel()">Cancel</button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(function(){

	$('#formPermission_role').validator().on('submit', function (e) {
		var id = $('#id').val();
		if (!e.isDefaultPrevented()){
			url = "{{ route('local.update.rolePermission',$role->id) }}";
			$.ajax({
				url : url,
				type : "POST",
				data : $('#formPermission_role').serialize(),
				success : function(data) {
					if(data.stat == 'Success'){
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
