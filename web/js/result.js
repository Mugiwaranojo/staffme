var current_consultant=1;
var consultantsArray;

function updateConsultants(){
    $(".ui-loader").show();
    $.ajax({
        url: "/api/consultants",
        type: "get", //send it through get method
        data:  $("#formSearch").serialize(),
        success: function(response) {
            //console.log(response);
            if(response.length===0){
                $("#result_list").html("<p>No result</p>")
                $("#buttonDetails").unbind('click');
            }else{
                consultantsArray= response;
                current_consultant=1;
                updateConsultantsList(consultantsArray);
                updateConsultantsDetails(consultantsArray);
                init_swap();
                initListButton();
            }
            $("#nav_consultant_matches").html(response.length+" matches")
            $("#nav_consultant_matches").show();
            $("#nav_consultant").hide();
            $(".ui-loader").hide();
            $("#formSearch").slideUp();
            $("#searchTop").slideDown();
            $("#result_top").slideDown();
            $("#result_list").slideDown();
        },
        error: function(xhr) {
          //Do Something to handle error
        }
    });
}

function init_swap(){
    $(".consultants_details").on("swipeleft",function(){
        $(this).addClass('rotate-right').delay(700).fadeOut(1);
        if ( $(this).is(':last-child') ) {
            current_consultant=1;
            $('.consultants_details:nth-child(1)').removeClass ('rotate-left rotate-right').fadeIn(300);
        } else {
            current_consultant++;
            $(this).next().removeClass('rotate-left rotate-right').fadeIn(400);
        }
        $("#nav_consultant span").html(" "+current_consultant+"/"+consultantsArray.length+" ");
    });  

    $(".consultants_details").on("swiperight",function(){
        $(this).addClass('rotate-left').delay(700).fadeOut(1);
        if ( $(this).is(':first-child') ) {
            current_consultant= consultantsArray.length;;
            $('.consultants_details:nth-child('+current_consultant+')').removeClass ('rotate-left rotate-right').fadeIn(300);
        } else {
            current_consultant--;
            $(this).prev().removeClass('rotate-left rotate-right').fadeIn(400);
        }
        $("#nav_consultant span").html(" "+current_consultant+"/"+consultantsArray.length+" ");
    });
    $("#nav_consultant .ui-block-a").unbind('click');
    $("#nav_consultant .ui-block-a").on("click", function(){
        $('.consultants_details:nth-child('+current_consultant+')').addClass('rotate-left').delay(700).fadeOut(1);
        if(current_consultant==1){
            current_consultant= consultantsArray.length;
        }else{
            current_consultant--;
        }
        $('.consultants_details:nth-child('+current_consultant+')').removeClass ('rotate-left rotate-right').fadeIn(300);
        $("#nav_consultant span").html(" "+current_consultant+"/"+consultantsArray.length+" ");
    });
    $("#nav_consultant .ui-block-c").unbind('click');
    $("#nav_consultant .ui-block-c").on("click", function(){
        $('.consultants_details:nth-child('+current_consultant+')').addClass('rotate-right').delay(700).fadeOut(1);
        if(current_consultant==consultantsArray.length){
            current_consultant=1;
        }else{
            current_consultant++;
        }
        $('.consultants_details:nth-child('+current_consultant+')').removeClass ('rotate-left rotate-right').fadeIn(300);
        $("#nav_consultant span").html(" "+current_consultant+"/"+consultantsArray.length+" ");
    });
    $("#nav_consultant span").html(" "+current_consultant+"/"+consultantsArray.length+" ");
}

function initListButton(){
    $("#result_list div").on("click", function(){
        current_consultant= $(this).data("consultantNumber");
        $('.consultants_details').addClass('rotate-right');
        $('.consultants_details:nth-child('+current_consultant+')').removeClass ('rotate-left rotate-right').fadeIn(300);
        $("#nav_consultant span").html(" "+current_consultant+"/"+consultantsArray.length+" ");
        $("#result_list").hide();
        $("#result_details").show();
        $("#nav_consultant").show();
        $("#nav_consultant_matches").hide();
        $(".consultants_details_bottom").show();
        $("#buttonDetails").html("<i class='fa fa-list'></i> LIST");
        $("#buttonDetails").data('value',"list");
    });
    $("#buttonDetails").unbind('click');
    $("#buttonDetails").on("click", function(){
        if($(this).data('value')==="details"){
            $("#result_list").hide();
            $("#result_details").show();
            $("#nav_consultant").show();
            $("#nav_consultant_matches").hide();
            $('.consultants_details:nth-child('+current_consultant+')').removeClass ('rotate-left rotate-right').fadeIn(300);
            $('.consultants_details:nth-child('+current_consultant+')').show();
            $(".consultants_details_bottom").show();
            $(this).html("<i class='fa fa-list'></i> LIST");
            $(this).data('value',"list");
        }else{
            $("#nav_consultant").hide();
            $("#result_details").hide();
            $(".consultants_details_bottom").hide();
            $("#nav_consultant_matches").show();
            $("#result_list").show();
            $(this).html("<i class='fa fa-clone'></i> DETAILS");
            $(this).data('value',"details");
        }
    });
}



function updateConsultantsList(consultants){
    var htmlLists="";
    for(var i=0;i<consultants.length;i++){
        var number=i+1;
        var consultant="<div data-consultant-number='"+number+"'>";
        consultant+="<span>"+consultants[i].firstname+" "+consultants[i].lastname+"</span>";
        consultant+="<span>"+consultants[i].function_title+"</span>";
        consultant+="<i class='fa fa-heart-o'></i>"
        consultant+="<span class='status_availability availability_"+getAvailabilityStatus(consultants[i])+"'></span>";
        consultant+="</div>\n";
        htmlLists+=consultant;
    }
    $("#result_list").html(htmlLists);
}

function updateConsultantsDetails(consultants){
    var htmlDetails="";
    for(var i=0;i<consultants.length;i++){
        var consultant="<div class='consultants_details'>";
                consultant+="<div class='consultants_details_main'>";
                    consultant+="<span class='status_availability availability_"+getAvailabilityStatus(consultants[i])+"'></span>";
                    consultant+="<div><i class='fa fa-user'></i> "+consultants[i].firstname+" "+consultants[i].lastname+"</div>";
                    consultant+="<div><i class='fa fa-suitcase'></i> "+consultants[i].function_title+"</div>";
                    consultant+="<div><i class='fa fa-signal'></i> "+consultants[i].skills_level+"</div>";
                    consultant+="<div><i class='fa fa-flag'></i> ISU: "+consultants[i].isu+"</div>";
                    consultant+="<div><i class='fa fa-spinner'></i> STATUS: "+displayStatus(consultants[i])+"</div>";
                    if(consultants[i].mission_end){
                        var dateEndMission= new Date(consultants[i].mission_end);
                        consultant+="<div><i class='fa fa-hourglass-3'></i> MISSION END: "+displayDate(dateEndMission)+"</div>";
                    }
                consultant+="</div>\n";
                consultant+="<div class='consultants_details_main_tag'>";
                    consultant+="<span><i class='fa fa-tag'></i> MAIN TAG</span>";
                    consultant+=displayTags(consultants[i].main_tag);
                consultant+="</div>\n";
                consultant+="<div class='consultants_details_functional_tag'>";
                    consultant+="<span><i class='fa fa-pencil'></i> FUNCTIONAL TAG</span>";
                    consultant+=displayTags(consultants[i].functional_tag);
                consultant+="</div>\n";
                consultant+="<div class='consultants_details_technical_tag'>";
                    consultant+="<span><i class='fa fa-wrench'></i> TECHNICAL TAG</span>";
                    consultant+=displayTags(consultants[i].technical_tag);
                consultant+="</div>\n";
                consultant+="<div class='consultants_details_new_tag'>";
                    consultant+="<span><i class='fa fa-bookmark-o'></i> NEW TAG</span>";
                    consultant+=displayTags(consultants[i].new_tag);
                consultant+="</div>\n";
                /*consultant+="<div class='consultants_details_wishes'>";
                    consultant+="<span>WISHES</span>: ";
                    consultant+=displayTags(consultants[i].wishes);
                consultant+="</div>\n";*/
                consultant+="<div class='consultants_details_activity_area'>";
                    consultant+="<span><i class='fa fa-plane'></i> ACTIVITY AREA</span>";
                    consultant+=displayTags(consultants[i].activity_area);
                consultant+="</div>\n";
                consultant+="<div class='consultants_details_languages'>";
                    consultant+="<span><i class='fa fa-language'></i> LANGUAGE</span>";
                    consultant+=displayLanguages(consultants[i].languages);
                consultant+="</div>\n";
                consultant+="<div class='consultants_details_manager'>";
                    consultant+="<span><i class='fa fa-mobile-phone'></i> CONTACT</span>";
                    consultant+=consultants[i].manager;
                consultant+="</div>\n";
                /*consultant+="<div class='consultants_details_adress'>";
                    consultant+="<span>ADRESS</span>: ";
                    consultant+=consultants[i].adresse;
                consultant+="</div>\n";*/
                consultant+="<div class='consultants_details_id'>";
                    consultant+="<span><i class='fa fa-key'></i> ID</span>";
                    consultant+=consultants[i].id;
                consultant+="</div>\n";
                consultant+="<div class='consultants_details_bottom ui-grid-b'>";
                    consultant+="<a class='ui-block-a ui-btn' href='#' data-role='button'><i class='fa fa-heart-o'></i></a>";
                    consultant+="<a class='ui-block-b ui-btn' href='mailto:"+consultants[i].email+"' data-icon='email' data-role='button'><i class='fa fa-envelope-o'></i></a>";
                    consultant+="<a class='ui-block-c ui-btn' href='tel:"+consultants[i].phone+"' data-icon='phone' data-role='button'><i class='fa fa-phone'></i></a>";
                consultant+="</div>\n";
            consultant+="</div>\n";
        htmlDetails+=consultant;
    }
    $("#result_details").html(htmlDetails);
}

function displayTags(tags){
    var tagString="";
    for(var i=0; i<tags.length;i++){
        tagString+=tags[i];
        if(i!==tags.length-1){
            tagString+=", ";
        }
    }
    return tagString;
}

function displayStatus(objConsultant){
    var statusString ="";
    switch(objConsultant.availability.value){
        case 1:
            statusString+=objConsultant.client;
            if(objConsultant.availability.complement){
                statusString+=" (BEGIN:"+objConsultant.availability.complement+")";
            }
            break;
        case 2:
             statusString+="SEAK LEAVE";
             break;
        case 3:
            statusString+="INTERCONTRACT";
            if(objConsultant.availability.complement){
                statusString+=" (BEGIN:"+objConsultant.availability.complement+")";
            }
            break;
        case 4:
            statusString+="PART TIME JOB "+"("+objConsultant.availability.complement+")";
            break;
        case 5:
            statusString+="RESIGNING";
            break;
    }
    return statusString;
}

function displayLanguages(objLanguages){
    var languagesString="";
    var languagesLevels= ["UNKNOWN","BEGGINER","INTERMEDIATE","USUAL","MATERNAL"];
    for(i in objLanguages){
        languagesString+=objLanguages[i].name+":"+languagesLevels[objLanguages[i].value];
        if(i!=objLanguages.length-1){
            languagesString+="/ ";
        }
    }
    return languagesString;
}

function displayDate(dateValue){
   var yyyy = dateValue.getFullYear().toString();
   var mm = (dateValue.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = dateValue.getDate().toString();
   return  (dd[1]?dd+"":"0"+dd[0]) +"/"+ (mm[1]?mm+"":"0"+mm[0])+ "/" + yyyy  ; 
}

function getAvailabilityStatus(objConsultant){
    if((objConsultant.availability.value==1||objConsultant.availability==4)
            &&objConsultant.mission_end){
        if(dateDiffInWeeks(objConsultant.mission_end)<=4){
            return 6;
        }
    }
    if(objConsultant.availability.value==5){
        return objConsultant.availability.value;
    }
    return objConsultant.availability.value;
    
}

function dateDiffInWeeks(dateString){
    var d1 = new Date();
    var d2 = new Date(dateString);
    return parseInt(((d2.getTime()-d1.getTime())/(24*3600*1000))/7);
}