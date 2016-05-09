$(document).on('pageinit', function() {
    
    /*$( document ).on( "swipeleft swiperight", "#searchpage", function( e ) {
        // We check if there is no open panel on the page because otherwise
        // a swipe to close the left panel would also open the right panel (and v.v.).
        // We do this by checking the data that the framework stores on the page element (panel: open).
        if ( $.mobile.activePage.jqmData( "panel" ) !== "open" ) {
            if ( e.type === "swipeleft"  ) {
                $( "#right-panel" ).panel( "open" );
            } else if ( e.type === "swiperight" ) {
                $( "#left-panel" ).panel( "open" );
            }
        }
    */
    $.ajax({
        url: "/api/tags",
        type: "get", //send it through get method
        success: function(response) {
            var availableTags= response;
            $( "#inputKeywords" ).unbind("keydown");
            $( "#inputKeywords" )
            // don't navigate away from the field on tab when selecting an item
            .bind("keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                                    $( this ).autocomplete( "instance" ).menu.active ) {
                          event.preventDefault();
  
                    }
            })
            .autocomplete({
                    minLength: 0,
                    source: function( request, response ) {
                            // delegate back to autocomplete, but extract the last term
                            response( $.ui.autocomplete.filter(
                                    availableTags , extractLast( request.term ) ) );
                    },
                    focus: function() {
                            // prevent value inserted on focus
                            return false;
                    },
                    select: function( event, ui ) {
                            var terms = split( this.value );
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push( ui.item.value );
                            // add placeholder to get the comma-and-space at the end
                            terms.push( "" );
                            this.value = terms.join( ", " );
                            return false;
                    }
            });
            $("#inputKeywords").attr('autocomplete', 'on');
        }  
    });
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
            $("#buttonMoreFilter").addClass("activeMoreFilter");
            $("#buttonValidSearch").hide();
            $("#moreFilter").slideDown();
        }else{
            $("#buttonMoreFilter").removeClass("activeMoreFilter");
            $("#buttonValidSearch").show();
            $("#moreFilter").slideUp();
            $("#buttonMoreFilter i").get(0).className="fa fa-chevron-right";
        }
        return false;
    });

    $("#buttonSearchPage, #searchTop, #buttonSearchBack").unbind("click");
    $("#buttonSearchPage, #searchTop, #buttonSearchBack").on("click", function(){
        backtoSearch();
    });
    
    $(".searchTop").hide();
    
    $(".buttonMenuHome").unbind("click");
    $(".buttonMenuHome").on("click", function(){
       backtoSearch();
    });
    
    changeFormFields();
});

$( document ).on( "pageinit", "#searchpage", function( event ) {
   
});

function split( val ) {
    return val.split( /,\s*/ );
}
function extractLast( term ) {
    return split( term ).pop();
}
                
function backtoSearch(){
    $(".result_top").hide();
    $(".result_details").hide();
    $(".result_list").hide();
    $("#formSearch").slideDown();
    $(".searchTop").hide();
}

function split( val ) {
  return val.split( /,\s*/ );
}
function extractLast( term ) {
  return split( term ).pop();
}

function onAvaibalityChange(event){
    var left=0;
    if(event.target.id==="rangeAvailability-b"){
        left= $($(".ui-btn-b").get(1)).position().left+10;
        $("#availabilityValueB").attr("style", "left:"+left+"px");
        $("#availabilityValueB").html(setAvaibalityValue($("#rangeAvailability-b")[0].valueAsNumber));
    }else{
        left= $($(".ui-btn-b").get(0)).position().left+10;
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

function $_GET(param) {
	var vars = {};
	window.location.href.replace( location.hash, '' ).replace( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
}

function changeFormFields(){
    if(window.location.href==="http://localhost/myresearches"){
        console.log(window.location.href);
        window.location.reload();
    }
    var inputs= $_GET();
    var nbr=0;
    for(var i in inputs){
        if(i!="language-choice%5B0%5D"){
            $("#"+i).val(inputs[i]);
            nbr++;
        }
    }
    if(nbr>0){
        updateConsultants();
    }
}