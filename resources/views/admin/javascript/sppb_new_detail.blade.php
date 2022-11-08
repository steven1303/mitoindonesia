<script type="text/javascript">
    var save_method;
    save_method = 'add';
    var table1 = $('#sppbNewDetailTable')
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
        "ajax": "{{route('local.record.sppb_detail.new', $sppb->id ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'qty', name: 'qty'},
            {data: 'satuan', name: 'satuan'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    var table2 = $('#poInternalDetailTable')
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
        "ajax": "{{route('local.record.po_internal_detail.new', ['id' => $sppb->id_po_internal , 'status' => 'SppbNew'] ) }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'nama_stock', name: 'nama_stock'},
            {data: 'qty', name: 'qty'},
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
    }

    $('#SpbdNewForm').validator().on('submit', function (e) {
        if (!e.isDefaultPrevented()){
            if (save_method == 'add')
            {
                url = "{{route('local.sppb.new.update', $sppb->id) }}";
            } 
            $.ajax({
                url : url,
                type : "POST",
                data : $('#SpbdNewForm').serialize(),
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                    $('#btnSaveUpdate').attr('disabled',true);
                },
                success : function(data) {
                    table.ajax.reload();
                    if(data.stat == 'Success'){
                        save_method = 'add';
                        success(data.stat, data.message);
                        $('#btnSaveUpdate').attr('disabled',false);
                    }
                    if(data.stat == 'Error'){
                        error(data.stat, data.message);
                    }
                    if(data.stat == 'Warning'){
                        error(data.stat, data.message);
                    }
                },
                error : function(data){
                    error('Error', 'Oops! Something Error! Try to reload your page first...');
                    $('#btnSaveUpdate').attr('disabled',false);
                }
            });
            return false;
        }
    });

    @canany(['sppb.store', 'sppb.update'], Auth::user())
    $(function(){
        $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });

	    $('#SpbdDetailForm').validator().on('submit', function (e) {
		    var id = $('#id').val();
		    if (!e.isDefaultPrevented()){
			    if (save_method == 'add')
			    {
				    url = "{{route('local.sppb.store_detail', $sppb->id) }}";
				    $('input[name=_method]').val('POST');
			    } else {
				    url = "{{ url('sppb_detail') . '/' }}" + id;
				    $('input[name=_method]').val('PATCH');
                }
			    $.ajax({
				    url : url,
				    type : "POST",
				    data : $('#SpbdDetailForm').serialize(),
                    beforeSend:function(){
                        $(document).find('span.error-text').text('');
                    },
				    success : function(data) {
                        table.ajax.reload();
                        if(data.stat == 'Success'){
                            save_method = 'add';
                            $('input[name=_method]').val('POST');
                            $('#id').val('');
                            $('#SpbdDetailForm')[0].reset();
                            $('#btnSave').text('Submit');
                            $('#stock_master').val(null).trigger('change');
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
				    error : function(data){
                        if(data.status == 422){
                            if(data.responseJSON.errors.qty !== undefined){
                                $('span.qty_error').text(data.responseJSON.errors.qty[0]);
                            }
                            if(data.responseJSON.errors.id_stock_master !== undefined)
                            {
                                $('span.stock_master_error').text(data.responseJSON.errors.stock_master[0]);
                            }
                        }else{
                            error('Error', 'Oops! Something Error! Try to reload your page first...');
                        }
				    }
			    });
			    return false;
		    }
	    });
    });

    function cancel(){
        save_method = 'add';
        $('#SpbdDetailForm')[0].reset();
        $('#btnSave').text('Submit');
        $('#formTitle').text('Create Stock Adjustment');
        $('#btnSave').attr('disabled',false);
        $('#stock_master').val(null).trigger('change');
        $('#button_modal').text('Save Changes');
        $('input[name=_method]').val('POST');
        $(document).find('span.error-text').text('');
    }

    @endcanany
    @can('sppb.update', Auth::user())
    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
        url: "{{ url('sppb') }}" + '/' + id + "/edit_detail",
        type: "GET",
        dataType: "JSON",
        beforeSend:function(){
            $(document).find('span.error-text').text('');
        },
        success: function(data) {
            $('#modal-input-item').modal('show');
            $('#button_modal').text('Update');
            $('#modal_title').text('Edit Item');
            $('#button_modal').attr('disabled',false);
            $('#id').val(data.id);
            $('#stock_master').val(data.id_stock_master);
            var newOption = new Option(data.stock_master.stock_no, data.id_stock_master, true, true);
            $('#stock_master').append(newOption).trigger('change');
            $('#qty').val(data.qty - 0);
            $('#satuan').val(data.stock_master.satuan);
            $('#keterangan').val(data.keterangan);
            format_decimal_limit();
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('sppb.open', Auth::user())
    function open_sppb_Form() {
        $.ajax({ 
        url: "{{route('local.sppb.open.index', $sppb->id) }}",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            if(data.stat == "Error")
            {
                error(data.stat, data.message);
            }
            if(data.stat == "Success"){                
                success(data.stat, data.message);
                // print_sppb("{{ $sppb->id }}"); // fungsi untuk hilangkan print sebelum aproval
                ajaxLoad("{{ route('local.sppb.index') }}");
            }  
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
    @can('sppb.print', Auth::user())
    function print_sppb(id){
        window.open("{{ url('sppb_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('sppb.delete', Auth::user())
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
                    url : "{{ url('sppb_detail') }}" + '/' + id,
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
    @can('sppb.pembatalan', Auth::user())
    function reject()
    {
        $.ajax({
        url: "{{route('local.sppb.pembatalan', $sppb->id) }}",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            if(data.stat == "Error")
            {
                error(data.stat, data.message);
            }
            if(data.stat == "Success"){
                success(data.stat, data.message);
                ajaxLoad("{{ route('local.sppb.index') }}");
            }
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan
</script>
