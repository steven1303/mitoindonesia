<script type="text/javascript">
    $('#datemask1').inputmask('yyyy-mm-dd', {
        'placeholder': 'yyyy-mm-dd'
    });
    $('#datemask2').inputmask('yyyy-mm-dd', {
        'placeholder': 'yyyy-mm-dd'
    });

    var save_method;
    save_method = 'add';
    var table = $('#invSppbTable')
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
            "ajax": "{{ route('local.record.sppb_detail', ['id' => $invoice->id_sppb, 'inv_stat' => 1]) }}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
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
                    data: 'format_price',
                    name: 'format_price'
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

    var table1 = $('#invoiceDetailTable')
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
            "ajax": "{{ route('local.record.inv_detail', $invoice->id) }}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
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

    $(function() {

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
    })

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
    @canany(['invoice.store', 'invoice.update'], Auth::user())
        $(function() {
            $('#datemask').inputmask('yyyy-mm-dd', {
                'placeholder': 'yyyy-mm-dd'
            });

            $('#invoiceForm').validator().on('submit', function(e) {
                var id = $('#id').val();
                if (!e.isDefaultPrevented()) {
                    if (save_method == 'add') {
                        url = "{{ route('local.inv.store_detail', $invoice->id) }}";
                        $('input[name=_method]').val('POST');
                    } else {
                        url = "{{ url('inv_detail') . '/' }}" + id;
                        $('input[name=_method]').val('PATCH');
                    }
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $('#invoiceForm').serialize(),
                        success: function(data) {
                            table.ajax.reload();
                            table1.ajax.reload();
                            if (data.stat == 'Success') {
                                save_method = 'add';
                                $('input[name=_method]').val('POST');
                                $('#id').val('');
                                $('#invoiceForm')[0].reset();
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
                            error('Error',
                                'Oops! Something Error! Try to reload your page first...'
                            );
                        }
                    });
                    return false;
                }
            });
        });

        function addItem(id) {
            save_method = 'add';
            $.ajax({
                url: "{{ url('sppb') }}" + '/' + id + "/edit_detail",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-input-item').modal('show');
                    $('#btnSave').text('Update');
                    $('#formTitle').text('Add Item');
                    $('#btnSave').attr('disabled', false);
                    $('#id_sppb_detail').val(data.id);
                    $('#stock_master').val(data.stock_master.stock_no);
                    $('#id_stock_master').val(data.id_stock_master);
                    $('#qty').val(data.qty);
                    $('#price').val(data.stock_master.harga_jual - 0);
                    $('#satuan').val(data.stock_master.satuan);
                    $('#keterangan1').val(data.keterangan);
                    format_decimal_limit();
                },
                error: function() {
                    error('Error', 'Nothing Data');
                }
            });
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $.ajax({
                url: "{{ url('inv_detail') }}" + '/' + id + "/edit_detail",
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

        function cancel() {
            save_method = 'add';
            $('#invoiceForm')[0].reset();
            $('#btnSave').text('Submit');
            $('#formTitle').text('Create Stock Adjustment');
            $('#btnSave').attr('disabled', false);
            $('#stock_master').val(null).trigger('change');
            $('input[name=_method]').val('POST');
        }
    @endcanany
    @can('invoice.open', Auth::user())
        function open_inv_Form() {
            $.ajax({
                url: "{{ route('local.inv.open.index', $invoice->id) }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if (data.stat == "Success") {
                        success(data.stat, data.message);
                        // print_inv("{{ $invoice->id }}"); // fungsi untuk hilangkan print sebelum approval
                        ajaxLoad("{{ route('local.inv.index') }}");
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
    @can('invoice.print', Auth::user())
        function print_inv(id) {
            window.open("{{ url('inv_print') }}" + '/' + id, "_blank");
        }
    @endcan
    @can('invoice.delete', Auth::user())
        function deleteData(id, title) {
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
                            url: "{{ url('inv_detail') }}" + '/' + id,
                            type: "POST",
                            data: {
                                '_method': 'DELETE',
                                '_token': csrf_token
                            },
                            success: function(data) {
                                table.ajax.reload();
                                table1.ajax.reload();
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
    @endcan
    @can('invoice.reject', Auth::user())
        function reject() {
            $.ajax({
                url: "{{ route('local.inv.pembatalan', $invoice->id) }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    if (data.stat == "Error") {
                        error(data.stat, data.message);
                    }
                    if (data.stat == "Success") {
                        success(data.stat, data.message);
                        ajaxLoad("{{ route('local.inv.index') }}");
                    }
                },
                error: function() {
                    error('Error', 'Nothing Data');
                }
            });
        }
    @endcan
</script>
