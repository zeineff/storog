$(document).ready(function(){
    $("#advanced_search_button").on("click", (function(e){
        e.preventDefault();
        
        $("#advanced_search").slideDown(400);
        $("#advanced_search_button").slideUp(400);
        $("#advanced_search").css("margin-top", "50px");
    }));
});