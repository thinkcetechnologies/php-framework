$(document).ready(function () {
    $("#username").keyup(function () {
        var username = $("#username").val();
        if(username.length >=4){
            $.post("accounts/search", {"username": username, "search": 1}, function (response) {
                if(response == "true"){
                    $("#username-feedback").html("");
                    $("#username-error-message").html("Username already exists!");

                }else if(response == "false"){
                    $("#username-error-message").html("");
                    $("#username-feedback").html("Username is available!");

                }
            });
        }
    });
});