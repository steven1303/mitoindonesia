<section class="content-header">
    <h1>
        Create SPPB
        {{-- <small>it all starts here</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="#">SPPB</a></li>
        <li class="active"><a href="#"> Create SPPB</a></li>
    </ol>
</section>
<section class="content">
    @canany(['sppb.store', 'sppb.update'], Auth::user())
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"  id="formTitle">Create SPPB</h3>
                </div>
                <div class="box-body">
                    <form role="form" id="SppbNewForm" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <input type="hidden" id="id" name="id">
                        <div class="box-body">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>PO Internal</label>
                                    <select class="form-control select2" id="po_internal" name="po_internal" style="width: 100%;">
                                        <option></option>
                                    </select>
                                    <span class="text-danger error-text po_internal_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button id="btnSave" type="submit" class="btn btn-primary">Submit</button>
                            <button class="btn btn-secondary" type="button" onclick="cancel()">Cancel</button>
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
                    <h3 class="box-title">List SPPB</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped"  id="sppbTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>SPPB No</th>
                                <th>PoInternal No</th>
                                <th>Date</th>
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

@include('admin.javascript.sppb_new')
