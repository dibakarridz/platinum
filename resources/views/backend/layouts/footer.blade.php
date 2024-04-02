<div class="footer" style="padding-left:24.1875rem !important;">
    @php($setting = Setting())
    <div class="">
        <p>{{ $setting->copyright ?? '' }}</p>
    </div>
</div>
<!-- delete confirm modal -->
    <div class="modal fade" id="deleteConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deletemodalTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="deletemodalTitle">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="DeleteAjaxModalBody">
                        <p id="deleteMsg"></p>
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                            <button type="button" class="btn btn-xs btn-primary" data-bs-dismiss="modal">Close</button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!-- restore confirm modal -->
    <div class="modal fade" id="restoreConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deletemodalTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="restoremodalTitle">Please Confirm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="RestoreAjaxModalBody">
                       
                    </div>
                    <div class="modal-footer">
                        <form id="restoreForm" action="" method="POST">
                            @csrf
                            @method('GET')
                            <button type="button" class="btn btn-xs btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-xs btn-primary">Restore</button>
                            
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- restore confirm modal -->

        <!-- status change modal -->
        <div class="modal fade" id="statusChange" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="modalTitle">Status Change</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="AjaxModalBody">
                        <p>Select below button for set current status</p>
                    </div>
                    <div class="modal-footer">
                        <form id="statusChangeForm" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-success btn-sm" name="status" value="1">Active</button>
                      <button type="submit" class="btn btn-sm btn-danger btn-sm" name="status" value="0">Inactive</button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- Quotes status change modal -->
        <div class="modal fade" id="QuotesChangeStatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="modalTitle">Status Change</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="changeStatusAjaxModalBody">
                        <p>Select below button for set current status</p>
                    </div>
                    <div class="modal-footer">
                        <form id="quoteStatusChangeForm" action="" method="POST">
                            @csrf
                            @method('PUT')
                           
                            <button type="button" class="btn btn-sm btn-danger btn-xs" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary btn-xs" name="status" id="okBtn" value="">Ok</button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.modal-dialog -->
        </div>

<!-- Start modal resend quoted -->
    <div class="modal fade" id="resendConfirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-primary" id="resendModalTitle">Resend Quotation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="resendQuoteAjaxModalBody">
                       
                    </div>
                    <div class="modal-footer">
                        <form id="resendQuotedForm" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="quote_id" id="quote_id" value="">
                            <input type="hidden" name="quoted_id" id="quoted_id" value="">
                            <button type="button" class="btn btn-sm btn-danger btn-xs" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary btn-xs" name="btnSubmit">Ok</button>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.modal-dialog -->
        </div>
<!-- End modal resend quoted -->

<!-- dynamic modal with populate data -->
    
    <div class="modal fade" id="ajaxModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ajaxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajaxModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body" id="dynamicAjaxModalBody">
                   
                </div>
                
            </div>
        </div>
    </div>
    
  