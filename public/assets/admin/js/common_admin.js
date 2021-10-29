function login(event){
    $('.form-error-text').text('');
    $.ajax({
        url: sBaseUrl+'/authenticate',
        type: 'POST',
        data: $('#adminLoginForm').serialize(),
        dataType: 'JSON',
        success: function(ajaxResponse){
            if(ajaxResponse.status){
                location.href = sBaseUrl+'/dashboard';
            }else if(typeof ajaxResponse.email_error !== 'undefined' && ajaxResponse.email_error){
                $('#email_error').text(ajaxResponse.message);
            }
        },
        error: function(ajaxResponse){
            if(typeof ajaxResponse.status !== 'undefined' && (ajaxResponse.status === 422 || ajaxResponse.status === '422')){
                var responseJson = ajaxResponse.responseJSON.errors;
                for (let [key, value] of Object.entries(responseJson)) {
                    $('#'+key+'_error').text(value);
                }


            }
        }

    })
}

function register(event){
    $('.form-error-text').text('');
    $.ajax({
        url: sBaseUrl+'/registerNewUser',
        type: 'POST',
        data: $('#adminRegistrationForm').serialize(),
        dataType: 'JSON',
        success: function(ajaxResponse){
            if(ajaxResponse.status){
                location.href = sBaseUrl+'/dashboard';
            }else if(typeof ajaxResponse.name_error !== 'undefined' && ajaxResponse.name_error){
                $('#name_error').text(ajaxResponse.message);
            }
        },
        error: function(ajaxResponse){
            if(typeof ajaxResponse.status !== 'undefined' && (ajaxResponse.status === 422 || ajaxResponse.status === '422')){
                var responseJson = ajaxResponse.responseJSON.errors;
                for (let [key, value] of Object.entries(responseJson)) {
                    $('#'+key+'_error').text(value);
                }


            }
        }

    })
}



function getMainPagesList(){
    var oTable  =  $("#mainPagesDataTable").DataTable({
        "aoColumns":  [
            { "sTitle": "Id", "sWidth": "10", "bSortable": true  },//1
            { "sTitle": "Name", "sWidth": "10", "bSortable": false  },//5
            { "sTitle": "Email", "sWidth": "10", "bSortable": false },//5
            { "sTitle": "Mobile", "sWidth": "10", "bSortable": false },//5
            { "sTitle": "Created At", "sWidth": "10", "bSortable": false  },//5
            { "sTitle": "Updated At", "sWidth": "10", "bSortable": false  },//5
            { "sTitle": "Action", "sWidth": "10", "bSortable": false  },//5
        ],
        aaSorting: [[0, 'desc']],
        "fnPreDrawCallback": function() {
            // gather info to compose a message
            //showOverlay();
            return true;
        },
        "fnDrawCallback": function() {
            // in case your overlay needs to be put away automatically you can put it here
            //hideOverlay();
        },
        "bStateSave": true,
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem( 'DataTables_'+window.location.pathname, JSON.stringify(oData) );
        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse( localStorage.getItem('DataTables_'+window.location.pathname) );
        },
        "bFilter": true,
        "bProcessing": true,
        "bServerSide": true,
        "destroy": true,
        "bFilter": false,
        "bLengthChange": false,
        "bPaginate": true,
        "sAjaxSource": sBaseUrl+"/ajax",
        "fnServerParams": function(aoData) {
            aoData.push({"name": "control", "value": 'GET_USER_LIST'});
        }
    });
}


function followUser(objData = {}){
    if(typeof objData.user_id == 'undefined' || !objData.user_id){
        alert('Something went wrong. Please refresh and try again.');
    } else if(typeof objData.name == 'undefined' || !objData.name){
        alert('Something went wrong. Please refresh and try again.');
    } else{
        openCommonModal({modalId: 'common_modal', title: 'Alert!', contentToShow: '<p>Do you really want to follow <b>'+objData.name+'</b>?</p>', AgreeBtnHtml: '<button type="button" class="btn btn-primary" onclick="sendFollowRequest({user_id: '+objData.user_id+'})">Yes</button>', disAgreeBtnHtml: '<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'});
    }
}

function sendFollowRequest(objData = {}){
    if(typeof objData.user_id == 'undefined' || !objData.user_id){
        alert('Something went wrong. Please refresh and try again.');
    } else{
        showOverlay();
        objData.control = 'FOLLOW_USER';
        $.ajax({
            url: sBaseUrl+'/ajax',
            type: 'POST',
            data: objData,
            dataType: 'JSON',
            success: function(ajaxResponse){
                hideOverlay();
                $('#common_modal').modal('hide');
                if(typeof ajaxResponse.status !== 'undefined' && ajaxResponse.status){
                    openCommonModal({modalId: 'common_modal', title: 'Congratulation!', contentToShow: '<p>'+ajaxResponse.message+'</p>', AgreeBtnHtml: '<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>'});
                    getMainPagesList();
                } else{
                    openCommonModal({modalId: 'common_modal', title: 'Oops!', contentToShow: '<p>'+ajaxResponse.message+'</p>', AgreeBtnHtml: '<button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>'});
                }
            },
            error: function(ajaxResponse){
                if(typeof ajaxResponse.status !== 'undefined' && (ajaxResponse.status === 422 || ajaxResponse.status === '422')){
                    var responseJson = ajaxResponse.responseJSON.errors;
                    var sErrorMsg = '';
                    for (let [key, value] of Object.entries(responseJson)) {
                        sErrorMsg += value;
                    }
                    openCommonModal({modalId: 'common_modal', title: 'Oops!', contentToShow: '<p>'+sErrorMsg+'</p>', AgreeBtnHtml: '<button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>'});
                }
            }
        })
    }
}

function openCommonModal(objData = {}){
    if(typeof objData.modalId !== 'undefined' && objData.modalId){
        $('#'+objData.modalId+' .modal-title').text('');
        $('#'+objData.modalId+' #contentToShow').html('');
        $('#'+objData.modalId+' #agreeHtml').html('');
        $('#'+objData.modalId+' #disAgreeHtml').html('');
        if(typeof objData.title !== 'undefined' && objData.title){
            $('#'+objData.modalId+' .modal-title').text(objData.title);
        }
        if(typeof objData.contentToShow !== 'undefined' && objData.contentToShow){
            $('#'+objData.modalId+' #contentToShow').html(objData.contentToShow);
        }
        if(typeof objData.AgreeBtnHtml !== 'undefined' && objData.AgreeBtnHtml){
            $('#'+objData.modalId+' #agreeHtml').html(objData.AgreeBtnHtml);
        }
        if(typeof objData.disAgreeBtnHtml !== 'undefined' && objData.disAgreeBtnHtml){
            $('#'+objData.modalId+' #disAgreeHtml').html(objData.disAgreeBtnHtml);
        }
        $('#'+objData.modalId).modal();
    }

}

function openPostStatusModal(){
    $('#post_status_modal').modal();
}


function showOverlay() {
    $('#overlay-layer').show();
}

function hideOverlay() {
    $('#overlay-layer').hide();
}

$(document).ready(function(){
    getMainPagesList();
    openStatusModalUploadError();
});

function openStatusModalUploadError(){
    if(typeof sUserStatusUpdatedMessage !== 'undefined' && sUserStatusUpdatedMessage){
        sUserStatusUpdatedMessage = JSON.parse(sUserStatusUpdatedMessage);
        if(typeof sUserStatusUpdatedMessage.status === 'undefined' || !sUserStatusUpdatedMessage.status){
            openPostStatusModal();
        } else if(typeof sUserStatusUpdatedMessage.status !== 'undefined' && sUserStatusUpdatedMessage.status){
            openCommonModal({modalId: 'common_modal', title: 'Congratulation!', contentToShow: '<p>'+sUserStatusUpdatedMessage.message+'</p>', AgreeBtnHtml: '<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>'});
        }
    }
}


function logOut(){
    showOverlay();
    $.ajax({
        url:sBaseUrl+'/ajax',
        type: 'POST',
        data: { 'control': 'LOG_OUT' },
        dataType: 'JSON',
        success: function(ajaxResponse){
            hideOverlay();
            if(typeof ajaxResponse.status && ajaxResponse.status){
                location.href = sBaseUrl+'/';
            }
        }

    })
}


function viewStatusOfParticularUser(objData = {}){
    if(typeof objData.user_id === 'undefined' || !objData.user_id){
        alert('Something went wrong. Please refresh and try again.');
    } else{
        showOverlay();
        $.ajax({
            url:sBaseUrl+'/ajax',
            type: 'POST',
            data: {'user_id': objData.user_id, 'control': 'VIEW_STATUS_OF_PARTICULAR_USER' },
            dataType: 'JSON',
            success: function(ajaxResponse){
                hideOverlay();
                if(typeof ajaxResponse.status && ajaxResponse.status && typeof ajaxResponse.htmlData !== 'undefined' && ajaxResponse.htmlData){
                    $('#user_status_modal').modal();
                    $('#user_status_modal .modal-body').html( ajaxResponse.htmlData);
                    getMainPagesList();
                } else{
                    openCommonModal({modalId: 'common_modal', title: 'Oops!', contentToShow: '<p>'+ajaxResponse.message+'</p>', AgreeBtnHtml: '<button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>'});
                }
            }
        })
    }
}


$(document).on('click','#postStatusBtn', function(e){
    var sStatusContent = $('#post_status_content').val();
    var sStatusImage = $('#post_status_image').val();
    $('#post_status_content_error').text('');
    $('#post_status_image_error').text('');
    var bError = false;
    if(typeof sStatusContent == 'undefined' || !sStatusContent){
        bError = true;
        $('#post_status_content_error').text('Please enter comments you want.');
    }
    if(typeof sStatusImage == 'undefined' || !sStatusImage){
        bError = true;
        $('#post_status_image_error').text('Please upload image.');
    }
    if(!bError){
        showOverlay();
        $('#postStatusForm').submit();
    }
    e.preventDefault();
})


