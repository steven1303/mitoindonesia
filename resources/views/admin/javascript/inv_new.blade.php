<script type="text/javascript">
    var save_method;
    save_method = 'add';
    var table = $('#invoiceTable')
        .DataTable({
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            "processing": true,
            "serverSide": true,
            responsive: true,
            "ajax": "{{ route('local.record.inv.new') }}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'inv_no',
                    name: 'inv_no'
                },
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data: 'total_inv',
                    name: 'total_inv'
                },
                {
                    data: 'status_inv',
                    name: 'status_inv'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

    $('#customer').select2({
        placeholder: "Select and Search",
        ajax: {
            url: "{{ route('local.search.customer') }}",
            dataType: 'json',
            data: function(params) {
                return {
                    q: $.trim(params.term)
                }
            },
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        },
    })

    $('#InvoiceForm').validator().on('submit', function(e) {
        var id = $('#id').val();
        if (!e.isDefaultPrevented()) {
            if (save_method == 'add') {
                url = "{{ route('local.inv.new.store') }}";
                $('input[name=_method]').val('POST');
            }
            $.ajax({
                url: url,
                type: "POST",
                data: $('#InvoiceForm').serialize(),
                success: function(data) {
                    table.ajax.reload();
                    if (data.stat == 'Success') {
                        save_method = 'add';
                        $('input[name=_method]').val('POST');
                        $('#btnSave').text('Submit');
                        success(data.stat, data.message);
                        if (data.process == 'add') {
                            ajaxLoad("{{ url('inv_new_detail') }}" + '/' + data.inv_id);
                        }
                    }
                    if (data.stat == 'Error') {
                        error(data.stat, data.message);
                    }
                    if (data.stat == 'Warning') {
                        error(data.stat, data.message);
                    }
                },
                error: function(data) {
                    if (data.status == 422) {
                        if (data.responseJSON.errors.po_internal !== undefined) {
                            $('span.po_internal_error').text(data.responseJSON.errors.po_internal[
                                0]);
                        }
                    } else {
                        error('Error', 'Oops! Something Error! Try to reload your page first...');
                    }
                }
            });
            return false;
        }
    });

    @can('invoice.print', Auth::user())
    function print_inv(id){
        window.open("{{ url('inv_print') }}" + '/' + id,"_blank");
    }
    @endcan
    @can('invoice.verify1', Auth::user())
    function verify1(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('inv') }}" + '/' + id + "/verify1",
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
    @can('invoice.verify2', Auth::user())
    function verify2(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('inv') }}" + '/' + id + "/verify2",
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
    @can('invoice.approve', Auth::user())
    function approve(id) {
        save_method = 'edit';
        $.ajax({
        url: "{{ url('inv_new') }}" + '/' + id + "/approve",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            table.ajax.reload();
            success(data.stat, data.message);
            //fungsi print otomatis setelah approval
            print_inv(id);
        },
        error : function() {
            error('Error', 'Nothing Data');
        }
        });
    }
    @endcan

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
                    url : "{{ url('inv_new') }}" + '/' + id,
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
