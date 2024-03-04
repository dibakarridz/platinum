@extends('backend.layouts.app')

@section('title')
    Create
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
    @stack('styles')
@endsection

@section('content')
	<div class="content-body">
        <div class="container-fluid">
            <div id="notify">@include('backend.layouts.alerts')</div>
            <div class="row ">
                <div class="col-sm-6 d-flex align-items-center">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('admin.domains.index')}}">Domains</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
                    </ol>
                </div>
                <div class="col-sm-6 d-flex flex-row-reverse align-items-center">

                </div>
            </div>


        <div class="card mt-4">
        <form action="http://localhost/platinum/admin/store" method="get" class="wpcf7-form init" aria-label="Contact form" novalidate="novalidate" data-status="init">
<div style="display: none;">
<input type="hidden" name="_wpcf7" value="1323">
<input type="hidden" name="_wpcf7_version" value="5.8.7">
<input type="hidden" name="_wpcf7_locale" value="en_GB">
<input type="hidden" name="_wpcf7_unit_tag" value="wpcf7-f1323-p315-o1">
<input type="hidden" name="_wpcf7_container_post" value="315">
<input type="hidden" name="_wpcf7_posted_data_hash" value="">
</div>
<h3 style="background:#f7cf00;padding:3px;">Your Details
</h3>
<input class="wpcf7-form-control wpcf7-hidden" value="NLH" type="hidden" name="website_code">
<input class="wpcf7-form-control wpcf7-hidden" value="http://nationwidelimohire.co.uk/limo-hire-prices/" type="hidden" name="redirect_url">
<div class="qlft">
	<p>Name
	</p>
</div>
<div class="qrft">
	<p><span class="wpcf7-form-control-wrap" data-name="name-cl1"><input size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" value="" type="text" name="name-cl1"></span>
	</p>
</div>
<div style="clear:both;">
	<div class="qlft">
		<p>Tel No.
		</p>
	</div>
	<div class="qrft">
		<p><span class="wpcf7-form-control-wrap" data-name="phone-cl1"><input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" value="" type="text" name="phone-cl1"></span>
		</p>
	</div>
	<div style="clear:both;">
		<div class="qlft">
			<p>Email Address
			</p>
		</div>
		<div class="qrft">
			<p><span class="wpcf7-form-control-wrap" data-name="email-cl1"><input size="40" class="wpcf7-form-control wpcf7-email wpcf7-validates-as-required wpcf7-text wpcf7-validates-as-email form-control" aria-required="true" aria-invalid="false" value="" type="email" name="email-cl1"></span>
			</p>
		</div>
		<div style="clear:both;">
			<h3 style="background:#f7cf00;padding:3px;margin-top:30px">Hire Details
			</h3>
			<div class="qlft">
				<p>Pickup Point
				</p>
			</div>
			<div class="qrft">
				<p><span class="wpcf7-form-control-wrap" data-name="pickup-cl1"><input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" value="" type="text" name="pickup-cl1"></span>
				</p>
			</div>
			<div style="clear:both;">
				<div class="qlft">
					<p>Pickup Postcode
					</p>
				</div>
				<div class="qrft">
					<p><span class="wpcf7-form-control-wrap" data-name="pickpostcode-cl1"><input size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required form-control" aria-required="true" aria-invalid="false" value="" type="text" name="pickpostcode-cl1"></span>
					</p>
				</div>
				<div style="clear:both;">
					<div class="qlft">
						<p>Pickup Date &amp; Time
						</p>
					</div>
					<div class="qrft">
						<p><span class="wpcf7-form-control-wrap" data-name="Pickdate-111"><input class="wpcf7-form-control wpcf7-date wpcf7-validates-as-date" aria-invalid="false" value="Pickup Date (dd/mm/yyyy)" type="date" name="Pickdate-111"></span> at <span class="wpcf7-form-control-wrap" data-name="ddl-hr"><select class="wpcf7-form-control wpcf7-select" aria-invalid="false" name="ddl-hr"><option value="">—Please choose an option—</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select></span><span class="wpcf7-form-control-wrap" data-name="ddl-minute"><select class="wpcf7-form-control wpcf7-select" aria-invalid="false" name="ddl-minute"><option value="">—Please choose an option—</option><option value="00">00</option><option value="15">15</option><option value="30">30</option><option value="45">45</option></select></span><span class="wpcf7-form-control-wrap" data-name="ddl-time"><select class="wpcf7-form-control wpcf7-select" aria-invalid="false" name="ddl-time"><option value="">—Please choose an option—</option><option value="AM">AM</option><option value="PM">PM</option></select></span>
						</p>
					</div>
					<div style="clear:both;">
						<div class="qlft">
							<p>No. of Passengers
							</p>
						</div>
						<div class="qrft">
							<p><span class="wpcf7-form-control-wrap" data-name="number-passengers"><input size="40" class="wpcf7-form-control wpcf7-text" aria-invalid="false" value="" type="text" name="number-passengers"></span>
							</p>
						</div>
						<div style="clear:both;">
							<div class="qlft">
								<p>Return
								</p>
							</div>
							<div class="qrft">
								<p><span class="wpcf7-form-control-wrap" data-name="jtype-cl1"><select class="wpcf7-form-control wpcf7-select" aria-invalid="false" name="jtype-cl1"><option value="">—Please choose an option—</option><option value="Yes">Yes</option><option value="No">No</option></select></span>
								</p>
							</div>
							<div style="clear:both;">
								<div class="qlft">
									<p>Destination Point
									</p>
								</div>
								<div class="qrft">
									<p><span class="wpcf7-form-control-wrap" data-name="dest-cl1"><input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" value="" type="text" name="dest-cl1"></span>
									</p>
								</div>
								<div style="clear:both;">
									<div class="qlft">
										<p>Destination Postcode
										</p>
									</div>
									<div class="qrft">
										<p><span class="wpcf7-form-control-wrap" data-name="destpostcode-cl1"><input size="40" class="wpcf7-form-control wpcf7-text form-control" aria-invalid="false" value="" type="text" name="destpostcode-cl1"></span>
										</p>
									</div>
									<div style="clear:both;">
										<div class="qlft">
											<p>Return Date &amp; Time
											</p>
										</div>
										<div class="qrft">
											<p><span class="wpcf7-form-control-wrap" data-name="Returndate-111"><input class="wpcf7-form-control wpcf7-date wpcf7-validates-as-date" aria-invalid="false" value="Return Date (dd/mm/yyyy)" type="date" name="Returndate-111"></span> at <span class="wpcf7-form-control-wrap" data-name="Returnddl-hr"><select class="wpcf7-form-control wpcf7-select" aria-invalid="false" name="Returnddl-hr"><option value="">—Please choose an option—</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select></span><span class="wpcf7-form-control-wrap" data-name="Returnddl-minute"><select class="wpcf7-form-control wpcf7-select" aria-invalid="false" name="Returnddl-minute"><option value="">—Please choose an option—</option><option value="00">00</option><option value="15">15</option><option value="30">30</option><option value="45">45</option></select></span><span class="wpcf7-form-control-wrap" data-name="Returnddl-time"><select class="wpcf7-form-control wpcf7-select" aria-invalid="false" name="Returnddl-time"><option value="">—Please choose an option—</option><option value="AM">AM</option><option value="PM">PM</option></select></span>
											</p>
										</div>
										<div style="clear:both;">
											<div class="qlft">
												<p>Details of Journey to get a better quote
												</p>
											</div>
											<div class="qrft">
												<p><span class="wpcf7-form-control-wrap" data-name="journey-details-cl1"><textarea cols="40" rows="5" class="wpcf7-form-control wpcf7-textarea wpcf7-validates-as-required" aria-required="true" aria-invalid="false" name="journey-details-cl1"></textarea></span>
												</p>
											</div>
											<div style="clear:both;">
												<div class="qlft">
													<p>Occasion
													</p>
												</div>
												<div class="qrft">
													<p><span class="wpcf7-form-control-wrap" data-name="Occasion-cl1"><select class="wpcf7-form-control wpcf7-select" aria-invalid="false" name="Occasion-cl1"><option value="">—Please choose an option—</option><option value="Wedding">Wedding</option><option value="Night Out">Night Out</option><option value="School Prom">School Prom</option><option value="Graduation">Graduation</option><option value="Birthday">Birthday</option><option value="Airport">Airport</option><option value="Other">Other</option></select></span>
													</p>
												</div>
												<div style="clear:both;">
													<p><input class="wpcf7-form-control wpcf7-submit has-spinner" type="submit" value="GET MY QUOTE">
													</p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><div class="wpcf7-response-output" aria-hidden="true"></div>
</form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @parent   
    <!-- <script src="{{url('backend/ckeditor/ckeditor.js')}}"></script> -->
    <!-- <script src="{{url('backend/js/ckeditor-config.js')}}"></script> -->
    <script src="{{url('backend/vendor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{url('backend/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/select2-init.js')}}"></script>
    <script>
        
    
        var Editor = document.querySelector('.ckeditor');
        ClassicEditor.create(Editor);
        // ClassicEditor
        //     .create( document.querySelector( '.ckeditor' ), {
        //     plugins: [ SourceEditing, Markdown, /* ... */ ],
        //     toolbar: [ 'sourceEditing', /* ... */ ]
        // })
        $("#domain").submit(function(e) {
            var content = $('.ckeditor').val();
            html = $(content).text();
            if ($.trim(html) == '') {
                $('#error_template').text("This field is required");
                e.preventDefault();
            } 
        });
       
        $('#domain').validate({
            ignore: [],
            debug: false,
        rules: {
            domain: {
                required: true,
                url: true
            },
            unique_id: {
                required: true,
            },
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            driver: {
                required: true,
            },
            host: {
                required: true,
            },
            port: {
                required: true,
            },
            username: {
                required: true,
            },
            password: {
                required: true,
            },
            encryption: {
                required: true,
            },
            title: {
                required: true,
            },
            success_message: {
                required: true,
            },
            error_message: {
                required: true,
            },
            template: {
                required: true,
            },
        },
        messages: {
            domain: {
                required: "This field is required",
            },
            unique_id: {
                required: "This field is required",
            },
            name: {
                required: "This field is required",
            },
            email: {
                required: "This field is required",
            },
            driver: {
                required: "This field is required",
            },
            host: {
                required: "This field is required",
            },
            port: {
                required: "This field is required",
            },
            username: {
                required: "This field is required",
            },
            password: {
                required: "This field is required",
            },
            encryption: {
                required: "This field is required",
            },
            title: {
                required: "This field is required",
            },
            success_message: {
                required: "This field is required",
            },
            error_message: {
                required: "This field is required",
            },
            template: {
                required: "This field is required",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });

    //CKEDITOR.replace('template');
    </script>
    @stack('scripts')
@endsection