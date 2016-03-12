$(document).on('pageinit', function() {
    $.ajax({
        url: "/api/consultants",
        type: "get", //send it through get method
        data:$_GET(false),
        success: function(response) {
          console.log(response);
          updateConsultantsList(response);
        },
        error: function(xhr) {
          //Do Something to handle error
        }
      });
});

function updateConsultantsList(consultants){
    var htmlLists="";
    for(var i=0;i<consultants.length;i++){
        var consultant="<button class='ui-grid-b'>";
        consultant+="<span class='ui-block-a'>"+consultants[i].firstname+" "+consultants[i].lastname+"</span>";
        consultant+="<span class='ui-block-b'>"+consultants[i].isu+"</span>";
        consultant+="<span class='ui-block-c'>"+consultants[i].function_title+"</span>";
        consultant+="</button>\n";
        htmlLists+=consultant;
    }
    $("#result_list").html(htmlLists);
}

function updateConsultantsDetailss(consultants){
    var htmlDetails="";
    for(var i=0;i<consultants.length;i++){
        var consultant="<div class='consultants_details'>";
        consultant+="<div class='consultants_details_main'>";
        consultant+="<div>"+consultants[i].firstname+" "+consultants[i].lastname+"</div>";
        consultant+="<div>"+consultants[i].function_title+"</div>";
        consultant+="<div>"+consultants[i].skills_level+"</div>";
        consultant+="<div>ISU: "+consultants[i].isu+"</div>";
        consultant+="<div>STATUS: "+consultants[i].availability+"</div>";
        consultant+="<div>MISSION END: "+consultants[i].mission_end+"</div>";
        consultant+="</div>\n";
        consultant+="<div class='consultants_details_main_tag'>";
        consultant+=displayTags(consultants[i].main_tag);
        consultant+="</div>\n";
        consultant+="<div class='ui-grid-a'>";
        consultant+="<div class='consultants_details_functional_tag ui-block-a'>";
        consultant+=displayTags(consultants[i].functional_tag);
        consultant+="</div>\n";
        consultant+="<div class='consultants_details_technical_tag ui-block-b'>";
        consultant+=displayTags(consultants[i].technical_tag);
        consultant+="</div>\n";
        consultant+="</div>\n";
        htmlDetails+=consultant;
    }
    $("#result_details").html(htmlDetails);
}

function displayTags(tags){
    var tagString="";
    for(tag in tags){
        tagString+=tag+", ";
    }
    return tagString.sub(0, -2);
}