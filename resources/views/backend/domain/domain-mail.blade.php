    <div class="card mt-4">
    <form class="needs-validation" id="sendMailForm" action="{{route('admin.domain.send.mail',['id' => $domain->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input id="sender_email" type="email" name="sender_email" placeholder="Enter sender email"
                            class="form-control @error('sender_email') is-invalid @enderror" requried>

                        @error('sender_email')
                            <div class="invalid-feedback" id="error_sender_email">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div><!-- /.row -->
            

            <div class="row">
                <div class="col-sm-6 d-flex align-items-center"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-xs btn-danger left" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="form_submit()" class="btn btn-xs btn-primary" id="sendMailSubBtn">Send</button>
                </div>
            </div>
    </form>
    </div>
<script>
  

</script> 