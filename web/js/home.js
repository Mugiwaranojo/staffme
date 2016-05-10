$(document).on('pageinit', '.homepage', function() {
    $(".loginButton").on("click", function(){
        inputsLogin= $(".homepage .ui-input-text").show();
        $(".loginPage form div:last-child").show();
        $(".loginPage form div:last-child").on("click", function(){
             $(".loginPage form").submit();
        });
        $(".loginButton").hide();
    });
});


