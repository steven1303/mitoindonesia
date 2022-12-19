<section class="content-header">
    <h1>
        Invoice @if ($invoice->inv_status == 1)
            Draft
            @endif @if ($invoice->inv_status == 2)
                Open
            @endif
            {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Invoice</a></li>
        <li><a href="#">Invoice Draft</a></li>
        <li class="active"><a href="#">Invoice Detail</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title" id="formTitle">Invoice {{ $invoice->inv_no }}</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="invoiceForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Invoice No</label>
                                    <input type="text" class="form-control" id="inv_no" name="inv_no"
                                        value="{{ $invoice->inv_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Invoice Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask1" name="date" class="form-control"
                                            data-inputmask="'alias': 'yyyy-mm-dd'" data-mask
                                            value="{{ $invoice->date }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>TOP Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask2" name="top_date" class="form-control"
                                            data-inputmask="'alias': 'yyyy-mm-dd'" data-mask
                                            value="{{ $invoice->top_date }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <input type="text" class="form-control" id="inv_no" name="inv_no"
                                        value="{{ $invoice->customer->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Customer</label>
                                    <input type="text" class="form-control" id="po_cust" name="po_cust"
                                        placeholder="Input PO No Customer" value="{{ $invoice->po_cust }}">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Mata Uang</label>
                                    <input type="text" class="form-control" id="mata_uang" name="mata_uang"
                                        value="{{ $invoice->mata_uang }}">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Alamat Customer</label>
                                    <input type="text" class="form-control" id="inv_kirimke" name="inv_kirimke"
                                        value="{{ $invoice->inv_kirimke }}" readonly>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Alamat Pengantaran</label>
                                    <input type="text" class="form-control" id="inv_alamatkirim"
                                        name="inv_alamatkirim" value="{{ $invoice->inv_alamatkirim }}">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if ($invoice->inv_status == 1)
                                <button id="btnSave" type="button" onclick="open_inv_Form()"
                                    class="btn btn-success">Open / Request</button>
                                <button id="buttonUpdate" class="btn btn-warning" type="submit">Update</button>
                            @endif
                            <button class="btn btn-secondary" type="button"
                                onclick="ajaxLoad('{{ route('local.inv.new.index') }}')">back</button>
                            @can('invoice.reject', Auth::user())
                                @if ($invoice->inv_status == 3 || $invoice->inv_status == 4)
                                    <button class="btn btn-danger" type="button" onclick="reject()">Reject</button>
                                @endif
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">SPPB List</h3><br /><br />
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="invoiceDetailTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>QTY</th>
                                <th>price</th>
                                <th>disc</th>
                                <th>Satuan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">SPPB item</h3><br /><br />
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="invSppbTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>QTY</th>
                                <th>price</th>
                                <th>Satuan</th>
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
@canany(['invoice.store', 'invoice.update'], Auth::user())

<div class="modal fade" id="modal-input-item">
    <div class="modal-dialog">
        <form role="form" id="SppbList">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 id="modal_title" class="modal-title">Adds SPPB</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

    <div class="modal fade" id="modal-input-item">
        <div class="modal-dialog">
            <form role="form" id="InvoiceDetailForm" method="POST">
                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="id_sppb_detail" name="id_sppb_detail">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 id="modal_title" class="modal-title">Adds Items</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Stock No</label>
                                    <input type="text" class="form-control" id="stock_master" name="stock_master"
                                        placeholder="Input QTY" readonly>
                                    <input type="hidden" id="id_stock_master" name="id_stock_master">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>QTY</label>
                                    <input type="text" class="form-control" id="qty" name="qty"
                                        placeholder="Input QTY" readonly>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="satuan" name="satuan"
                                        placeholder="Satuan" readonly>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" id="price" name="price"
                                        placeholder="Price">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" class="form-control" id="disc" name="disc"
                                        placeholder="Discount">
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <div class="form-group">
                                    <label>Keterangan SPPB</label>
                                    <input type="text" class="form-control" id="keterangan1" name="keterangan1"
                                        placeholder="Input keterangan" readonly>
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <div class="form-group">
                                    <label>Keterangan Invoice</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan"
                                        placeholder="Input keterangan">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"
                            onclick="cancel()">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endcanany

@include('admin.javascript.inv_detail_new', ['invoice', $invoice])
