(function($){

    $("#sort_by").on("change", function(e){
        $("form#storePage").submit();
    });

    $("#mobileFilterButton").on("click",function(e){
        e.preventDefault();
        setTimeout( function(){
            $("#filterRow").slideToggle(300);
        }, 300);
            
    });

    $("#goBack").on("click", function(){
        window.history.back();
    })
    


})(jQuery);