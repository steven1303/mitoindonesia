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
                            ajaxLoad("{{ url('sppb_new_detail') }}" + '/' + data.sppb_id);
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
</script>
