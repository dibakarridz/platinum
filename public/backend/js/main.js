$(document).ready(function () {
    setTimeout(function () {
        $("#notify").remove();
    }, 5000);
    
   
});

$('.openPopup').on('click',function(){
    let url = $(this).attr('data-action-url');
    var title = $(this).attr('data-title');
    // AJAX request
    $.ajax({
        url: url,
        type: 'get',
        beforeSend: function(){
            ajaxindicatorstart();
        },
        success: function (response) {
            ajaxindicatorstop();
            $('#dynamicAjaxModalBody').html(response.html);
            $('#ajaxModalLabel').html(title);
            $("#ajaxModal").modal('show');
            
        
        }
    });
});

function deleteConfirm(route,message){
    var lines = message.split('?');
    if(lines[1]!=''){
        $('#DeleteAjaxModalBody').html(lines[0]+'?<br><span class="label label-danger" style="font-size:15px !important;">'+lines[1]+'<span>');
    }else{
        $('#DeleteAjaxModalBody').html(message);
    }
    $(document).find('#deleteForm').attr('action',route);
}

function statusChange(route,title){
    $('#modalTitle').html(title);
    $(document).find('#statusChangeForm').attr('action', route);
  
}

function restoreConfirm(route,message){
    console.log(route);
    console.log(message);
    $('#RestoreAjaxModalBody').html(message);
    $(document).find('#restoreForm').attr('action', route);
  
}

function quoteStatusChange(route,status,msg){
    $("#okBtn").prop("value", status);
    $('#changeStatusAjaxModalBody').html(msg);
    $(document).find('#quoteStatusChangeForm').attr('action', route);
  
}
function resendConfirm(route,quoteID,quotedID,msg){
    $("#quote_id").prop("value", quoteID);
    $("#quoted_id").prop("value", quotedID);
    $('#resendQuoteAjaxModalBody').html(msg);
    $(document).find('#resendQuotedForm').attr('action', route);
  
}




function checkall(){
    var id=[];
    if ($("#multi_check").is(':checked')) {
        $(".single_check").each(function () {
            $(this).prop("checked", true);
        });    
        } else {
        $(".single_check").each(function () {
            $(this).prop("checked", false);
        });
        }
}
$(document).ready(function(){
    $(".single_check").click(function(){
        $("#multi_check").prop("checked", false);
            var i=0;
        $(".single_check").each(function () {
            if(!$(this).is(':checked')) {
                i=1;
            }
        });
        if(i == 0){
            $("#multi_check").prop("checked", true);
        }
    });
});
$('body').on('click','.apply_action',function(){
   
    var actionUrl = $(document).find('.actionUrl').val();
    var action_value = $('#id_label_single option:selected').val();
    var ids = [];
    $.each($("input[name='single_check']:checked"), function(){
        ids.push($(this).val());
    });
    
    if(action_value =='' || action_value==null || typeof action_value=="undefined")
    {
        toastr.error("Please select action", "Select Action", {
            positionClass: "toast-top-center",
            timeOut: 5e3,
            closeButton: !0,
            newestOnTop: !0,
            progressBar: !0
        })
    }else if($.isEmptyObject(ids)) {
        toastr.error("Please Checked At lest One item", "Select Checkbox", {
            positionClass: "toast-top-center",
            timeOut: 5e3,
            closeButton: !0,
            newestOnTop: !0,
            progressBar: !0
        })
    }else{
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: actionUrl,
            data: {action_value:action_value,ids:ids},
            beforeSend: function(){
                ajaxindicatorstart();
            },
            success: function (response) {
                ajaxindicatorstop();
                if(response.status==true){
                        window.location.href=response.url;
                }else{
                    toastr.error(response.msg, "", {
                        positionClass: "toast-top-center",
                        timeOut: 5e3,
                        closeButton: !0,
                        progressBar: !0
                        
                    })
                    $('#example4').load(' #example4');
                    $('#activeCount').html('<a href="javascript:void(0)" class="badge badge-rounded badge-info" id="activeCount">All ('+response.activeCount+')</a>');
                    $('#trashedCount').html('<a href="javascript:void(0)" class="badge badge-rounded badge-danger" id="trashedCount">Trashed ('+response.trashedCount+')</a>');
                    
                }
            }
        });
    }
});

function passwordGenerate(){
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$!&*#%";

    for (var i = 0; i < 8; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    $('#copyTarget').val(text);
}

function reg_pass(){
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$!&*#%";
    for (var i = 0; i < 8; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));
    $('#copyTarget').val(text);
}

function copyToClipboard(elem) {
    // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);

    // copy the selection
    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }

    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}

$('#copyButton').click(function(){
    //alert('1');
    var new_password = $('#copyTarget').val();
    //alert(new_password);
    $('input[name=password]').val(new_password);
    $('input[name=confirm_password]').val(new_password);
});


