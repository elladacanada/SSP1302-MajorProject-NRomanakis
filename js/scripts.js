(function($){

    $("#sort_by").on("change", function(e){
        $("form#storePage").submit();
    });

    $("#mobileFilterButton").on("click",function(e){
        e.preventDefault();
        setTimeout( function(){
            $("#filterRow").toggleClass("show");
        }, 300);
            
    });

})(jQuery);