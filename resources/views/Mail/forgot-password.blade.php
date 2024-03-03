<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Use the latest (edge) version of IE rendering engine -->
    <title>EmailTemplate-Responsive</title>
    <!-- The title tag shows in email notifications, like Android 4.4. -->
    <!-- Please use an inliner tool to convert all CSS to inline as inpage or external CSS is removed by email clients -->
    <!-- important in CSS is used to prevent the styles of currently inline CSS from overriding the ones mentioned in media queries when corresponding screen sizes are encountered -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans|PT+Sans|Source+Sans+Pro|Titillium+Web" rel="stylesheet">
    <!-- CSS Reset -->
    <style type="text/css">
			
/* What it does: Remove spaces around the email design added by some email clients. */
      /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
html,  body {
	margin: 0 !important;
	padding: 0 !important;
	height: 100% !important;
	width: 100% !important;
}
/* What it does: Stops email clients resizing small text. */
* {
	-ms-text-size-adjust: 100%;
	-webkit-text-size-adjust: 100%;
}
/* What it does: Forces Outlook.com to display emails full width. */
.ExternalClass {
	width: 100%;
}
h1, h2, h3, h4, h5, h6{
	font-family: sans-serif;	
}
/* What is does: Centers email on Android 4.4 */
div[style*="margin: 16px 0"] {
	margin: 0 !important;
}
/* What it does: Stops Outlook from adding extra spacing to tables. */
table,  td {
	mso-table-lspace: 0pt !important;
	mso-table-rspace: 0pt !important;
}
/* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
table {
	border-spacing: 0 !important;
	border-collapse: collapse !important;
	table-layout: fixed !important;
	margin: 0 auto !important;
}
table table table {
	table-layout: auto;
}
/* What it does: Uses a better rendering method when resizing images in IE. */
img {
	-ms-interpolation-mode: bicubic;
}
/* What it does: Overrides styles added when Yahoo's auto-senses a link. */
.yshortcuts a {
	border-bottom: none !important;
}
/* What it does: Another work-around for iOS meddling in triggered links. */
a[x-apple-data-detectors] {
	color: inherit !important;
}

			/*
			Font Family
			=================
			Arial, sans-serif, serif, EmojiFont
			"Open Sans", Helvetica, Arial, sans-serif, serif, EmojiFont
			wf_segoe-ui_normal, "Segoe UI", "Segoe WP", Tahoma, Arial, sans-serif, serif, EmojiFont;
			Arial, Tahoma, Verdana, sans-serif, serif, EmojiFont
			font-family: 'Open Sans', sans-serif;
			font-family: 'Source Sans Pro', sans-serif;
			font-family: 'PT Sans', sans-serif;
			font-family: 'Titillium Web', sans-serif;
			*/

</style>

    <!-- Progressive Enhancements -->
    <style type="text/css">
        
        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }
			 .heading2{ 
				 font-size: 30px;
				 text-transform: uppercase;
				 color: #212121;
				 margin: 0;
				 text-align: center;
			  }
			 .heading4{ 
				 font-size: 18px;
				 text-transform: uppercase;
				 color: #212121;
				 margin: 0;
				 text-align: center;
			  }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
            }

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid,
            .fluid-centered {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            /* And center justify these ones. */
            .fluid-centered {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }
        
            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
                
        }

    </style>
    </head>
    <body bgcolor="#e0e0e0" width="100%" style="margin: 0;" yahoo="yahoo">
    <table bgcolor="#e0e0e0" cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" style="border-collapse:collapse;">
      <tr>
        <td><center style="width: 100%;">
            
            <!-- Visually Hidden Preheader Text : BEGIN -->
            <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;"> Dear {{$name}}  Your password reset link has been generated.. </div>
            <!-- Visually Hidden Preheader Text : END --> 
            
            <!-- Email Header : BEGIN -->
            <table align="center" width="600" class="email-container">
            <tr>
                <td style="padding: 20px 0; text-align: center">
                    @if($file_path!='')
                        <img src="{{$message->embed($logo)}}" width="200" alt="alt_text" border="0">
                    @else
                        <img src="{{$message->embed(public_path().'/mail/image/logo.png')}}" width="200" alt="alt_text" border="0">
                    @endif
                </td>
              </tr>
          </table>
            <!-- Email Header : END --> 
            
            <!-- Email Body : BEGIN -->
            <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="600" class="email-container">
            
            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td class="full-width-image">
                <br><br>
								<h2 class="heading2">FORGET</h2>
								<h4 class="heading4">Your Password?</h4>
                <br>
                <img src="{{$message->embed(public_path().'/mail/image/il-password-reset@2x.png')}}" width="600" alt="alt_text" border="0" align="center" style="width: 100%; max-width: 600px; height: auto;"></td>
              </tr>
            <!-- Hero Image, Flush : END --> 
            
            <!-- 1 Column Text : BEGIN -->
							<tr>
								<td style="padding:0 40px 40px; text-align: center; font-family: sans-serif; font-size: 13px; mso-height-rule: exactly; line-height: 20px; color: #555555;"> 
               <h3 style=" font-family: 'Open Sans', sans-serif; color: #212121">Not to worry, we got you! Let's get you a new password.</h3>
               <p></p>
                <br>
                
                <!-- Button : Begin -->
                
                <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto">
                    <tr>
                    <td style="border-radius: 3px; background: #4890d9; text-align: center;" class="button-td"><a href="{{$reset_link}}" style="background: #4890d9; border: 15px solid #4890d9; padding: 0 10px;color: #ffffff; font-family: 'Open Sans', sans-serif; font-size: 14px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold; text-transform: uppercase" class="button-a"> 
                      <!--[if mso]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]-->Reset Password<!--[if mso]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]--> 
                      </a></td>
                  </tr>
                  </table>
                
                <!-- Button : END --></td>
              </tr>
            <!-- 1 Column Text : BEGIN --> 
            
            <!-- Background Image with Text : BEGIN -->
            <tr>
                <td bgcolor="#4890d9" valign="middle" style="text-align: center; background-position: center center !important; background-size: cover !important;"><!--[if gte mso 9]>
                    <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:600px;height:175px; background-position: center center !important;">
                    <v:fill type="tile" src="assets/Responsive/Image_600x230.png" color="#222222" />
                    <v:textbox inset="0,0,0,0">
                    <![endif]-->
                
                <div>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
											<td valign="middle" style="text-align: center; padding: 10px; font-family: 'Open Sans', sans-serif; font-size: 14px; mso-height-rule: exactly; line-height: 20px; color: #ffffff;"><br><p>You recently requested to reset your password for Account. This is done for your protection.</p>
											</td>
										</tr>
										<tr>
                    	<td valign="middle" style="text-align: center; padding: 10px; font-family: 'Open Sans', sans-serif; font-size: 12px; mso-height-rule: exactly; line-height: 20px; color: #ffffff;">
                     	<p style="margin: 0;">If you did not request a password reset, please ignore this email or reply us to let us know. This password reset is valid for the next 24 Hrs.</p>
                      <p style="margin: 0;">If you ignore this email, your password won't be changed.</p><br>
                      </td>
                      </tr>
                  </table>
                  </div>
                
                <!--[if gte mso 9]>
                    </v:textbox>
                    </v:rect>
                    <![endif]--></td>
              </tr>
            <!-- Background Image with Text : END --> 
            
          </table>
            <!-- Email Body : END --> 
            
            <!-- Email Footer : BEGIN -->
            
            <!-- Email Footer : END -->
            
          </center></td>
      </tr>
    </table>
</body>
</html>
