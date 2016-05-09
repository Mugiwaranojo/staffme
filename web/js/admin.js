$( document ).on( "pageinit", "#adminpage", function( event ) {
    $('#fileupload').fileupload({
                done: function (e, data) {
                        if(!data.result.success){
                                data.result= JSON.parse(data.result);
                        }
                        $('<p/>').text(data.result.msg).appendTo('#files');
                },
                fail: function (e, data) {
                        console.log(data);
                        console.log(e);
                },
                progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css(
                                'width',
                                progress + '%'
                        );
                }
        }).prop('disabled', !$.support.fileInput)
    .parent().addClass($.support.fileInput ? undefined : 'disabled');
    updateConsultantsAdminList();
});

function updateConsultantsAdminList(){
    $.ajax({
        url: "/api/consultants",
        type: "get", //send it through get method
        data: "inputKeywords=&rangeAvailability-a=0&rangeAvailability-b=8&valueOnMissionSince=0&language-level=&exp-choice=",
        success: function(response) {
            updateConsultantsAdmin(response.consultants);
        }
    });
}

function updateConsultantsAdmin(consultants){
    var htmltable="<table><thead><tr><th></th>";
    htmltable+="<th>id</th><th>firstname</th><th>lastname</th><th>Role</th><th>ISU</th><th>Skills level</th><th>Main tags</th><th>Technical tags</th><th>Functional tag</th><th>Recent Tag</th><th>Activity area</th><th>Email</th><th>Phone</th>";
    htmltable+="</tr></thead>";
    htmltable+="<tbody>";
    for(var i=0;i<consultants.length;i++){
        var consultant="<tr class='consultantlist-avaibality-"+consultants[i].availability.value+"'>";
            consultant+="<td><button class='removeEditConsultantButton' onclick='removeEditAdminConsultant(this)' disabled><i class='fa fa-trash'></i></button>"
            consultant+="<button class='editConsultantButton' onclick='editAdminConsultant(this)'><i class='fa fa-pencil'></i></button>"
            consultant+="<button class='cancelEditConsultantButton' onclick='cancelEditAdminConsultant(this)'><i class='fa fa-remove'></i></button>"
            consultant+="<button class='validEditConsultantButton' onclick='validEditAdminConsultant(this)'><i class='fa fa-check'></i></button>"
            consultant+="</td>";
            consultant+="<td>"+displayEditFields(consultants[i].id)+"</td>";
            consultant+="<td>"+displayEditFields(consultants[i].firstname)+"</td>"
            consultant+="<td>"+displayEditFields(consultants[i].lastname)+"</td>";
            consultant+="<td>"+displayEditFields(consultants[i].function_title)+"</td>";
            consultant+="<td>"+displayEditFields(consultants[i].isu)+"</td>";
            consultant+="<td>"+displayEditFields(consultants[i].skills_level)+"</td>";
            consultant+="<td>"+displayEditFields(displayTags(consultants[i].main_tag))+"</td>";
            consultant+="<td>"+displayEditFields(displayTags(consultants[i].technical_tag))+"</td>"; 
            consultant+="<td>"+displayEditFields(displayTags(consultants[i].functional_tag))+"</td>"; 
            consultant+="<td>"+displayEditFields(displayTags(consultants[i].new_tag))+"</td>"; 
            consultant+="<td>"+displayEditFields(displayTags(consultants[i].activity_area))+"</td>"; 
            consultant+="<td>"+displayEditFields(consultants[i].email)+"</td>"; 
            consultant+="<td>"+displayEditFields(consultants[i].phone)+"</td>"; 
            consultant+="</tr>";       
        htmltable+=consultant;
    }
    htmltable+="</tbody>";
    htmltable+="</table>";
    $(".allUserEditList").html(htmltable);
    
}

function editAdminConsultant(obj){
    $(obj).hide();
    $(obj).parent().parent().find(".removeEditConsultantButton").hide();
    $(obj).parent().parent().find(".cancelEditConsultantButton").show();
    $(obj).parent().parent().find(".validEditConsultantButton").show();
    $(obj).parent().parent().find("span").hide();
    $(obj).parent().parent().find("input").show();
}
function cancelEditAdminConsultant(obj){
    $(obj).hide();
    $(obj).parent().parent().find(".validEditConsultantButton").hide();
    $(obj).parent().parent().find(".editConsultantButton").show();
    $(obj).parent().parent().find(".removeEditConsultantButton").show();
    $(obj).parent().parent().find("input").hide();
    $(obj).parent().parent().find("span").show();
}

function validEditAdminConsultant(obj){
    $(obj).parent().parent().find(".cancelEditConsultantButton").hide();
    cancelEditAdminConsultant(obj);
}

function displayEditFields(value){
    var string= "<span>"+value+"</span>";
    string+= "<input value='"+value+"'/>";
    return string;        
}