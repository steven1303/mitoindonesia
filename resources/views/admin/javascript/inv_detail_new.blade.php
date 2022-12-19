<script type="text/javascript">
    $('#datemask1').inputmask('yyyy-mm-dd', {
        'placeholder': 'yyyy-mm-dd'
    });
    $('#datemask2').inputmask('yyyy-mm-dd', {
        'placeholder': 'yyyy-mm-dd'
    });

    $('#invoiceForm').validator().on('submit', function(e) {
        if (!e.isDefaultPrevented()) {
            url = "{{ route('local.inv.new.update', $invoice->id) }}";
            $('input[name=_method]').val('PATCH');
            $.ajax({
                url: url,
                type: "POST",
                data: $('#invoiceForm').serialize(),
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                    $('#buttonUpdate').attr('disabled', true);
                },
                success: function(data) {
                    table.ajax.reload();
                    if (data.stat == 'Success') {
                        success(data.stat, data.message);
                    }
                    if (data.stat == 'Error') {
                        error(data.stat, data.message);
                    }
                    if (data.stat == 'Warning') {
                        error(data.stat, data.message);
                    }
                    $('#buttonUpdate').attr('disabled', false);
                },
                error: function(data) {
                    if (data.status == 422) {
                        if (data.responseJSON.errors.qty !== undefined) {
                            $('span.qty_error').text(data.responseJSON.errors.qty[0]);
                        }
                        if (data.responseJSON.errors.id_stock_master !== undefined) {
                            $('span.stock_master_error').text(data.responseJSON.errors.stock_master[
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
