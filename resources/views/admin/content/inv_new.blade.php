<section class="content-header">
    <h1>
        Create Invoice
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">SPBD</a></li>
        <li class="active"><a href="#"> Create Invoice</a></li>
    </ol>
</section>
<section class="content">
    @canany(['invoice.store', 'invoice.update'], Auth::user())
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title" id="formTitle">Create Invoice</h3>
                    </div>
                    <div class="box-body">
                        <form role="form" id="InvoiceForm" method="POST">
                            {{ csrf_field() }} {{ method_field('POST') }}
                            <div class="box-body">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select class="form-control select2" id="customer" name="customer"
                                            style="width: 100%;">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <button id="btnSave" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcanany
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">List Invoice</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped" id="invoiceTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>total</th>
                                <th>Status</th>
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

@include('admin.javascript.inv_new')
