$(document).on('pageinit', function() {
    $("#connexionButton").hide();
    $("#loginButton").on("click", function(){
        inputsLogin= $("#homepage .ui-input-text");
        $(inputsLogin.get(0)).show();
        $(inputsLogin.get(1)).show();
        $("#loginPage form div:last-child").show();
        $("#loginButton").hide();
    });
});


