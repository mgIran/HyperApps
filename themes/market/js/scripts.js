$(function() {
    $("body").on('click','.dropdown-toggle', function () {
        var $this = $(this);
        var $ul = $this.next('.sidebar-dropdown');
        if($ul.css("display") == 'block')
        {
            $ul.stop().slideUp();
        }else if($ul.css("display") == 'none')
        {
            $('.sidebar-dropdown').not($ul).slideUp();
            $ul.slideDown();
        }
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
});