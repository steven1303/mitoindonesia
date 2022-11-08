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
        "ajax": "{{route('local.record.sppb.new') }}",
        "columns": [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'sppb_no', name: 'sppb_no'},
            {data: 'po_no', name: 'po_no'},
            {data: 'sppb_date', name: 'sppb_date'},
            {data: 'status', name: 'status'},
            {data: 'action', name:'action', orderable: false, searchable: false}
        ]
    });

    $('#po_internal').select2({
        placeholder: "Select and Search",
        ajax:{
            url:"{{route('local.search.po_internal.new') }}",
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
    @can('sppb.new.store', Auth::user())
    $('#SppbNewForm').validator().on('submit', function (e) {
        var id = $('#id').val();
        if (!e.isDefaultPrevented()){
            if (save_method == 'add')
            {
                url = "{{route('local.sppb.new.store') }}";
                $('input[name=_method]').val('POST');
            }
            $.ajax({
                url : url,
                type : "POST",
                data : $('#SppbNewForm').serialize(),
                success : function(data) {
                    table.ajax.reload();
                    if(data.stat == 'Success'){
                        save_method = 'add';
                        $('input[name=_method]').val('POST');
                        $('#id').val('');
                        $('#SppbNewForm')[0].reset();
                        $('#po_internal').val(null).trigger('change');
                        $('#btnSave').text('Submit');
                        success(data.stat, data.message);
                        if (data.process == 'add')
                        {
                            ajaxLoad("{{ url('sppb_new_detail') }}" + '/' + data.sppb_id);
                        }
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
                        if(data.responseJSON.errors.po_internal !== undefined){
                            $('span.po_internal_error').text(data.responseJSON.errors.po_internal[0]);
                        }
                    }else{
                        error('Error', 'Oops! Something Error! Try to reload your page first...');
                    }
                }
            });
            return false;
        }
    });
    @endcan
    @can('sppb.new.delete', Auth::user())
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
                    url : "{{ url('sppb_new') }}" + '/' + id,
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
