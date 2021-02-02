<section class="content-header">
    <h1>
        Stock Movement Part $kode Part
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">Inventory</a></li>
        <li><a href="#">Stock Master</a></li>
        <li class="active"><a href="#"> Stock Movement</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-yellow">
                    <h3 class="widget-user-username">Part Number</h3>
                    <h5 class="widget-user-desc">Part Name</h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li>
                            <a href="#">Branch Name <span class="pull-right badge bg-blue">SOH</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail Price</h3>
                </div>
                <div class="box-body">
                    <table class="table table-condensed">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 300px">Keterangan</th>
                            <th>Harga</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>Harga Modal</td>
                            <td>Harga Modal</td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Harga rata-rata modal</td>
                            <td>Harga Modal</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>Harga Jual</td>
                            <td>Harga Jual</td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td>Harga rata-rata jual</td>
                            <td>Harga Jual</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">History Stock Movement</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped"  id="stockMasterTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Movement Type</th>
                                    <th>Tanggal</th>
                                    <th>In</th>
                                    <th>Out</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                      </div>
                </div>
            </div>
        </div>
    </div>
</section>
