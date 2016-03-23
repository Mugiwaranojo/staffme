$(document).on('pageinit', function() {
    $( "#rangeAvailability-a, #rangeAvailability-b" ).unbind( "slidestop");
    $("#rangeAvailability-a, #rangeAvailability-b").bind( "slidestop", function(event) {
        onAvaibalityChange(event);   
    });
    
    $( "#rangeOnMissionSince-a, #rangeOnMissionSince-b" ).unbind( "slidestop");
    $("#rangeOnMissionSince-a, #rangeOnMissionSince-b").bind( "slidestop", function(event) {
        onMissionSinceChange(event);   
    });

    $("#buttonValidSearch, #buttonValidSearch2").unbind("click");
    $("#buttonValidSearch, #buttonValidSearch2").on("click", function(){
        updateConsultants();
        return false; 
    });
    
    
    $("#buttonMoreFilter").unbind("click");
    $("#buttonMoreFilter").on("click", function(){
        if($("#buttonMoreFilter i").get(0).className=="fa fa-chevron-right"){
            $("#buttonMoreFilter i").get(0).className="fa fa-chevron-down";
            $("#buttonMoreFilter").attr("style", "margin-top: 50px;")
            $("#buttonValidSearch").hide();
            $("#moreFilter").slideDown();
        }else{
            $("#buttonMoreFilter").attr("style", "margin-top: 0px;")
            $("#buttonValidSearch").show();
            $("#moreFilter").slideUp();
            $("#buttonMoreFilter i").get(0).className="fa fa-chevron-right";
        }
        return false;
    });

    $("#buttonSearchPage, #searchTop").unbind("click");
    $("#buttonSearchPage, #searchTop").on("click", function(){
        $("#result_top").hide();
        $("#result_details").hide();
        $("#result_list").hide();
        $("#formSearch").slideDown();
        $("#searchTop").hide();
    });
    
    
    $("#searchTop").hide();
});

function onAvaibalityChange(event){
    var left=0;
    if(event.target.id==="rangeAvailability-b"){
        left= $($(".ui-btn-b").get(1)).position().left-10;
        $("#availabilityValueB").attr("style", "left:"+left+"px");
        $("#availabilityValueB").html(setAvaibalityValue($("#rangeAvailability-b")[0].valueAsNumber));
    }else{
        left= $($(".ui-btn-b").get(0)).position().left;
        $("#availabilityValueA").attr("style", "left:"+left+"px");
        $("#availabilityValueA").html(setAvaibalityValue($("#rangeAvailability-a")[0].valueAsNumber));
    }

    if($($(".ui-btn-b").get(0)).position().left===$($(".ui-btn-b").get(1)).position().left){
        left= $($(".ui-btn-b").get(1)).position().left;
        $("#availabilityValueA").attr("style", "left:"+left+"px");
        $("#availabilityValueA").html($("#availabilityValueB").html());
    }
}

function onMissionSinceChange(event){
    var left=0;
    if(event.target.id==="rangeOnMissionSince-b"){
        left= $($(".ui-btn-b").get(5)).position().left-10;
        $("#onMissionSinceValueB").attr("style", "left:"+left+"px");
        $("#onMissionSinceValueB").html(setOnMissionSinceValue($("#rangeOnMissionSince-b")[0].valueAsNumber));
    }else{
        left= $($(".ui-btn-b").get(4)).position().left;
        $("#onMissionSinceValueA").attr("style", "left:"+left+"px");
        $("#onMissionSinceValueA").html(setOnMissionSinceValue($("#rangeOnMissionSince-a")[0].valueAsNumber));
    }

    if($($(".ui-btn-b").get(4)).position().left===$($(".ui-btn-b").get(5)).position().left){
        left= $($(".ui-btn-b").get(5)).position().left;
        $("#onMissionSinceValueA").attr("style", "left:"+left+"px");
        $("#onMissionSinceValueA").html($("#availabilityValueB").html());
    }
}

function setAvaibalityValue(value){
    switch (value){
        case 0:
            return "ASAP";
        case 1:
            return "1 week";
        case 8:
            return "+ 8 weeks";
        default:
            return value+" weeks";
    }  
}

function setOnMissionSinceValue(value){
    if(value<2){
        return "-1 year";
    }else if(value<6){
         return "-"+value+" years";
    }else{
        value= value-1;
        return "+ "+value+" years";
    }
}