$(function() {
    $("body").on('click','.dropdown-toggle', function () {
        var  $this = $(this);
        $(".dropdown-toggle").not($this).removeClass('active');
        $this.addClass('active');
    });

    $('body').on('click', '.add-multipliable-input', function(){
        var input=document.createElement('input');
        input.type='text';
        input.name='Apps[permissions]['+$('.multipliable-input').length+']';
        input.placeholder='دسترسی';
        input.className='form-control multipliable-input';
        var container=document.getElementsByClassName('multipliable-input-container');
        $(container).append(input);
        return false;
    });

    $('body').on('click', '.remove-multipliable-input', function(){
        if($('.multipliable-input').length>1)
            $('.multipliable-input-container .multipliable-input:last').remove();
        return false;
    });

    if($(".app-description").height()>150)
        $(".app-description").next().show();
    $('body').on('click', '.more-text', function(){
        var $h = $(".app-description").height();
        if($(this).parent().hasClass('open'))
        {
            $(this).parent().animate({height:150},0).removeClass('open');
            $(this).find('span:first-child').removeClass('icon-rotate-180');
            $(this).find('span:last-child').html('توضیحات بیشتر');
        }
        else if($h>150)
        {
            $(this).parent().animate({height:$h+80},0).addClass('open');
            $(this).find('span:first-child').addClass('icon-rotate-180');
            $(this).find('span:last-child').html('بستن');
        }
        return false;
    });

});