<section class="content-header">
    <h1>
        SPPB New @if($sppb->sppb_status == 1 ) Draft @endif @if($sppb->sppb_status == 2 ) Open @endif
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">SPPB</a></li>
        <li><a href="#">SPPB Draft</a></li>
        <li class="active"><a href="#">SPPB Detail</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">SPPB {{ $sppb->sppb_no }}</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SpbdNewForm" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" id="SpbdNewMethod" name="_method" value="PATCH">
                        <div class="box-body">
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>SPPB No</label>
                                    <input type="text" class="form-control" id="sppb_no" name="sppb_no" placeholder="Input SPBD No" readonly value="{{ $sppb->sppb_no }}">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>PO Internal No</label>
                                    <input type="text" class="form-control" id="po_no" name="po_no" placeholder="Input SPBD No" readonly value="{{ $sppb->po_no }}">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Document No</label>
                                    <input type="text" class="form-control" id="doc_no" name="doc_no" placeholder="Input Doc No" value="{{ $sppb->doc_no }}">
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="datemask" name="spbd_date" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="{{ $sppb->sppb_date }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            @if($sppb->sppb_status == 1 || $sppb->sppb_status == 2 )
                                <button id="btnSave" type="button" onclick="open_sppb_Form()" class="btn btn-success">Open / Request</button>
                                <button id="btnSaveUpdate" type="submit" class="btn btn-primary">Update</button>
                            @endif
                            <button class="btn btn-secondary" type="button" onclick="ajaxLoad('{{route('local.sppb.new.index')}}')">Save</button>
                            @can('sppb.pembatalan', Auth::user())
                                @if($sppb->sppb_status == 3 || $sppb->sppb_status == 4 )                                                       
                                    <button class="btn btn-danger" type="button" onclick="reject()">Reject</button>
                                @endif
                                @if($sppb->sppb_status == 5 )                                                       
                                    <button class="btn btn-danger" type="button" onclick="reject()">Batal</button>
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
                    <h3 class="box-title">SPPB Item</h3><br/><br/>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="sppbNewDetailTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>QTY</th>
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
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">PO Internal Item</h3><br/><br/>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="poInternalDetailTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Stock Master</th>
                                <th>QTY</th>
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
@canany(['sppb.store', 'sppb.update'], Auth::user())
<div class="modal fade" id="modal-input-item">
    <div class="modal-dialog modal-lg">
        <form role="form" id="SpbdDetailForm" method="POST">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" id="id" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 id="modal_title" class="modal-title">Adds Items</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Stock No</label>
                                <select class="form-control select2" id="stock_master" name="stock_master" style="width: 100%;">
                                    <option></option>
                                </select>
                                <span class="text-danger error-text stock_master_error"></span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>QTY</label>
                                <input type="number" class="form-control" id="qty" name="qty" placeholder="Input QTY">
                                <span class="text-danger error-text qty_error"></span>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-xs-3">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" id="price" name="price" placeholder="Price" readonly>
                                <span class="text-danger error-text price_error"></span>
                            </div>
                        </div> --}}
                        <div class="col-xs-9">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Input keterangan">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"  onclick="cancel()">Cancel</button>
                    <button id="button_modal" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcanany

@include('admin.javascript.sppb_new_detail')