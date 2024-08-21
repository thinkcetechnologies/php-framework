var sidebar_toggler = document.querySelector(".toggle");
var sidebar_main_panel = document.querySelector(".sidebar-panel");
var open_sidebar_panel = document.querySelector("#open");
var main_panel = document.querySelector(".main-panel");
var title = document.querySelectorAll("#sidebar-item-title");


var close = false;

sidebar_toggler.addEventListener("click", function(event) {
    //sidebar_main_panel.style.backgroundColor = "red";
    sidebar_main_panel.style.width = "50px";
    main_panel.style.marginLeft = "60px";
    open_sidebar_panel.style.display = "block";
    sidebar_toggler.style.display = "none";

    for ( i = 0; i < title.length; i++) {
        title[i].style.display = "none";
    }


});

open_sidebar_panel.addEventListener("click", function(event) {
    //sidebar_main_panel.style.backgroundColor = "red";
    sidebar_main_panel.style.width = "250px";
    sidebar_toggler.style.display = "block";
    main_panel.style.marginLeft = "260px";
    open_sidebar_panel.style.display = "none";
    for (i = 0; i < title.length; i++) {
        title[i].style.display = "inline-block";
    }

});