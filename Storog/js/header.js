$(document).ready(function(){
    var adv_search_button = $("#advanced_search_button");
    var adv_search = $("#advanced_search");
    var lang_select = $("#lang_select_button");
    var lang_box = $("#lang_select_box");
    
    adv_search_button.on("click", (function(e){
        e.preventDefault();
        
        adv_search.slideToggle(400);
    }));
    
    lang_select.on("click", function(e){
        lang_box.slideToggle(200);
    });
    
    $("#lang_select_list li").on("click", function(e){
        var lang = $(this).data("lang");
        
        $.ajax({
            url:"functions/set_language.php",
            type:"post",
            data: {
                "lang":lang
            },
            success: function(data){
                if (data === "true")
                    location.reload();
                else
                    alert("Error switching languages")
            }
       });
    });
});