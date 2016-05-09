$( document ).on( "pageinit", "#favoritespage", function( event ) {
    updateConsultantsFavorites();
});

$( document ).on( "pageinit", "#myresearches", function( event ) {
    updateConsultantsResearches();
});

function updateConsultantsResearches(){
    $(".ui-loader").show();
    $.ajax({
        url: "/api/searches",
        type: "get", //send it through get method
        success: function(response) {
            if(response.length===0){
                $(".list_researches").html("<p>No result</p>");
            }else{
                displayUserResearches(response);
            }
             $(".ui-loader").hide();
        }
    });
}

function displayUserResearches(researches){
    var string="";
    for(var i=0;i<researches.length;i++){
        string+="<div class='user_research ui-btn'>";
        string+="<a href='/search?"+researches[i].query+"'><span>"+researches[i].name+"</span></a>";
        string+="<input value='"+researches[i].name+"'/>"
        string+="<button class='removeResearchButton' onclick='removeResearch(this, "+researches[i].id+")'><i class='fa fa-trash'></i></button>";
        string+="<button class='validResearchButton' onclick='validResearchName(this, "+researches[i].id+")'><i class='fa fa-check'></i></button>";
        string+="<button class='cancelResearchButton' onclick='cancelEditResearchName(this)'><i class='fa fa-remove'></i></button>";
        string+="<button class='editResearchButton' onclick='editResearchName(this)'><i class='fa fa-pencil'></i></button>";
        string+="</div>";
    }
    $(".list_researches").html(string);
}

function validResearchName(obj, id){
    var inputName= $(obj).parent().find("input").get(0);
    $(obj).parent().find("a span").html(inputName.value);
    cancelEditResearchName(obj);
}

function removeResearch(obj, id){
    if(confirm("Are Sure you yant delete this research?")){
        $(obj).parent().hide();
    }
}

function editResearchName(obj){
    $(obj).hide();
    $(obj).parent().find("a").hide();
    $(obj).parent().find(".removeResearchButton").hide();
    $(obj).parent().find(".cancelResearchButton").show();
    $(obj).parent().find(".validResearchButton").show();
    $(obj).parent().find("input").show();
}

function cancelEditResearchName(obj){
    $(obj).hide();
    $(obj).parent().find("a").show();
    $(obj).parent().find(".cancelResearchButton").hide();
    $(obj).parent().find(".validResearchButton").hide();
    $(obj).parent().find("input").hide();
    $(obj).parent().find(".editResearchButton").show();
    $(obj).parent().find(".removeResearchButton").show();
}



function updateConsultantsFavorites(){
    $(".ui-loader").show();
    $.ajax({
        url: "/api/favorites/consultants",
        type: "get", //send it through get method
        success: function(response) {
            //console.log(response);
            if(response.length===0){
                $(".result_list").html("<p>No result</p>");
            }else{
                consultantsArray= response.consultants;
                favoritesArray = response.favorites;
                current_consultant=1;
                updateConsultantsList(consultantsArray);
                updateConsultantsDetails(consultantsArray);
                init_swap();
                initListButton();
            }
            $(".nav_consultant").hide();
            $(".ui-loader").hide();
            $(".searchTop").slideDown();
            $(".result_top").slideDown();
            $(".result_list").slideDown();
        },
        error: function(xhr) {
          //Do Something to handle error
        }
    });
}