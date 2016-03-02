jQuery(function($){
    setInterval(function(){
        $(".alert").fadeOut(2000);
    }, 20000);
    $('.nav-tabs > li').click(function(event){
        if ($(this).hasClass('disabled')) {
            return false;
        }
    });
});
