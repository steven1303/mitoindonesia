<script type="text/javascript">
    $('#datemask1').inputmask('yyyy-mm-dd', {
        'placeholder': 'yyyy-mm-dd'
    });
    $('#datemask2').inputmask('yyyy-mm-dd', {
        'placeholder': 'yyyy-mm-dd'
    });

    function format_decimal_limit() {
        VMasker(document.getElementById("price")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });
        VMasker(document.getElementById("disc")).maskMoney({
            precision: 0,
            separator: '.',
            delimiter: '.',
            unit: 'Rp',
        });
    }

    var table1 = $('#invoiceSppbTable')
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
            "ajax": "{{ route('local.record.inv.new.sppb', ['invoice' => 0, 'customer' => $invoice->id_customer]) }}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'sppb_no',
                    name: 'sppb_no'
                },
                {
                    data: 'sppb_date',
                    name: 'sppb_date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

    var table2 = $('#listSppbTable')
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
            "ajax": "{{ route('local.record.inv.new.sppb', ['invoice' => $invoice->id, 'customer' => $invoice->id_customer]) }}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'sppb_no',
                    name: 'sppb_no'
                },
                {
                    data: 'sppb_date',
                    name: 'sppb_date'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

    var table3 = $('#invDetailTable')
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
            "ajax": "{{ route('local.record.inv_detail.new', $invoice->id) }}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'sppb_no',
                    name: 'sppb_no'
                },
                {
                    data: 'nama_stock',
                    name: 'nama_stock'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'format_balance',
                    name: 'format_balance'
                },
                {
                    data: 'disc',
                    name: 'disc'
                },
                {
                    data: 'satuan',
                    name: 'satuan'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
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
                    table1.ajax.reload();
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

    $('#invoiceDetailForm').validator().on('submit', function(e) {
        var id = $('#id').val();
        if (!e.isDefaultPrevented()) {
            url = "{{ url('inv_new_detail') . '/' }}" + id;
            $.ajax({
                url: url,
                type: "POST",
                data: $('#invoiceDetailForm').serialize(),
                success: function(data) {
                    table1.ajax.reload();
                    table2.ajax.reload();
                    table3.ajax.reload();
                    if (data.stat == 'Success') {
                        save_method = 'add';
                        $('#invoiceDetailForm')[0].reset();
                        $('#btnSave').text('Submit');
                        success(data.stat, data.message);
                        $('#modal-input-item').modal('hide')
                    }
                    if (data.stat == 'Error') {
                        error(data.stat, data.message);
                    }
                    if (data.stat == 'Warning') {
                        error(data.stat, data.message);
                    }
                },
                error: function() {
                    error('Error', 'Oops! Something Error! Try to reload your page first...');
                }
            });
            return false;
        }
    });

    function addItem(sppb) {
        console.log(sppb)
        $.ajax({
            url: "{{ url('add/inv_sppb_new') }}" + '/' + {{ $invoice->id }} + '/' + sppb,
            type: "GET",
            dataType: "JSON",
            beforeSend: function() {
                document.getElementById(sppb).disabled = true;
            },
            success: function(data) {
                table1.ajax.reload();
                table2.ajax.reload();
                table3.ajax.reload();
                document.getElementById(sppb).disabled = false;
                console.log(sppb);
            },
            error: function() {
                error('Error', 'Oops! Something Error! Try to reload your page first...');
            }
        })
    }

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $.ajax({
            url: "{{ url('inv_new_detail') }}" + '/' + id + "/edit_detail",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#modal-input-item').modal('show');
                $('#btnSave').text('Update');
                $('#modal_title').text('Edit Item');
                $('#btnSave').attr('disabled', false);
                $('#id').val(data.id);
                $('#id_sppb_detail').val(data.id);
                $('#stock_master').val(data.stock_master);
                $('#id_stock_master').val(data.id_stock_master);
                $('#qty').val(data.qty);
                $('#price').val(data.price - 0);
                $('#disc').val(data.disc);
                $('#satuan').val(data.satuan);
                $('#keterangan').val(data.keterangan);
                $('#keterangan1').val(data.keterangan1);
                format_decimal_limit();
            },
            error: function() {
                error('Error', 'Nothing Data');
            }
        });
    }

    function deleteItem(sppb, title) {
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
                        url: "{{ url('inv_new_detail') }}" + '/' + sppb,
                        type: "POST",
                        data: {
                            '_method': 'DELETE',
                            '_token': csrf_token
                        },
                        beforeSend: function() {
                            document.getElementById('delete_' + sppb).disabled = true;
                        },
                        success: function(data) {
                            table1.ajax.reload();
                            table2.ajax.reload();
                            table3.ajax.reload();
                            swal({
                                type: 'success',
                                title: 'Deleted',
                                text: 'Poof! Your record has been deleted!',
                            });
                        },
                        error: function() {
                            swal({
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
    @can('invoice.open', Auth::user())
        function open_inv_Form() {
            $.ajax({
                url: "{{ route('local.inv.new.open.index', $invoice->id) }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if (data.stat == "Success") {
                        success(data.stat, data.message);
                        // print_inv("{{ $invoice->id }}"); // fungsi untuk hilangkan print sebelum approval
                        ajaxLoad("{{ route('local.inv.new.index') }}");
                    }
                    if (data.stat == "Error") {
                        error(data.stat, data.message);
                    }

                },
                error: function() {
                    error('Error', 'Nothing Data');
                }
            });
        }
    @endcan
</script>
