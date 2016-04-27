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

    if($(".app-description").height()>230)
        $(".app-description").next().show();
    $('body').on('click', '.more-text', function(){
        var $h = $(".app-description").height();
        if($h>230)
        {
            $(this).parent().animate({height:$h+80},0).addClass('open');
            $(this).remove();
        }
        return false;
    });

    $("body").on('click',".os-menu-trigger",function(){
        var $this = $(this);
        var $osMenu = $('.os-menu');
        if($osMenu.hasClass('open'))
        {
            $osMenu.find('.svg-close').removeClass('bounceIn bounceOut animated').addClass('bounceOut animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                $(this).removeClass('bounceOut animated');
            });
            $('body,html').removeClass('overflow');
            $osMenu.removeClass('open');
        }
        else
        {
            $('body,html').addClass('overflow');
            $osMenu.addClass('open');
            $osMenu.find('.svg-close').removeClass('bounceOut bounceIn animated').addClass('bounceIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                $(this).removeClass('bounceIn animated');
            });
        }
    });

    $("body").on('click',".search-trigger",function(){
        var $this = $(this);
        var $searchBox = $('.mobile-search');
        if($searchBox.parents('header.mobile').hasClass('search-open'))
        {
            $searchBox.parents('header.mobile').removeClass('search-open');
            $('.mobile-nav').removeClass('fadeInLeft fadeOutLeft animated').addClass('fadeInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
            $('.logo-box').removeClass('fadeInRight fadeOutRight animated').addClass('fadeInRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
            $searchBox.find('.svg-close').removeClass('bounceIn bounceOut animated').addClass('bounceOut animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                $(this).removeClass('bounceOut animated');
            });
        }else
        {
            $searchBox.parents('header.mobile').addClass('search-open');
            $('.mobile-nav').removeClass('fadeInLeft fadeOutLeft animated').addClass('fadeOutLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
            $('.logo-box').removeClass('fadeInRight fadeOutRight animated').addClass('fadeOutRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
            $searchBox.find('.svg-close').removeClass('bounceOut bounceIn animated').addClass('bounceIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                $(this).removeClass('bounceIn animated');
            });
        }
    });

    $("body").on('click',".navbar-trigger",function(){
        var $this = $(this);
        var $searchBox = $('.mobsile-search');
        if($searchBox.parents('header.mobile').hasClass('search-open'))
        {
            $searchBox.parents('header.mobile').removeClass('search-open');
            $('.mobile-nav').removeClass('fadeInLeft fadeOutLeft animated').addClass('fadeInLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
            $('.logo-box').removeClass('fadeInRight fadeOutRight animated').addClass('fadeInRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
            $searchBox.find('.svg-close').removeClass('bounceIn bounceOut animated').addClass('bounceOut animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                $(this).removeClass('bounceOut animated');
            });
        }else
        {
            $searchBox.parents('header.mobile').addClass('search-open');
            $('.mobile-nav').removeClass('fadeInLeft fadeOutLeft animated').addClass('fadeOutLeft animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
            $('.logo-box').removeClass('fadeInRight fadeOutRight animated').addClass('fadeOutRight animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend');
            $searchBox.find('.svg-close').removeClass('bounceOut bounceIn animated').addClass('bounceIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                $(this).removeClass('bounceIn animated');
            });
        }
    });
});