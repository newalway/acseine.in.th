var appendFlg = false;
function bg(){
    var mainH = $('main').height()+100;
    $('.bgContents').css({height:mainH})
    var w = $(window).width();
    var h = $(window).height();
    var num = $('main section').length-1;

    $('main section').each( function(i){
        var top = (h*2) * i;

        if(appendFlg==false){
            $('<div class="line-bg line-bg' + i + '"></div>').css({top:top}).appendTo('.bgContents');
            if(i==num){
                appendFlg = true;
            }
        } else {
            $('.line-bg'+(i)).css({top:top})
        };
    })
}

function init(){
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin: 0,
        items:1,
        autoplay: true,
        smartSpeed: 1000,
        nav:true,
        navText: ['<span class="ti-angle-left"></span>','<span class="ti-angle-right"></span>']
    })

    $('body').scrollspy({
        target: '#navbar-top',
        offset: 150
    })

    $("a[href^='#'].link-click").click(function(e) {
    	e.preventDefault();

    	var position = $($(this).attr("href")).offset().top;

    	$("body, html").animate({
    		scrollTop: position - 75
    	}, 800 );
    });

    if ($('.scrollTop').length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('.scrollTop').addClass('show');
                } else {
                    $('.scrollTop').removeClass('show');
                }
            };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('.scrollTop').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }

    bg();

    $('.js_waveBtn').prepend('<div class="hoverContainer"><div class="hoverPoint"></div></div>');
	$('.js_waveBtn').hover(function(e){
		target = $(this);
		var areaOffset = target.offset();
		var offsetTop = ((e.pageY)-(areaOffset.top));
		var offsetLeft = ((e.pageX)-(areaOffset.left));

		if(!$('html.ie9').length){
			target.find('.hoverPoint').addClass('hovered').css({
				top: (offsetTop),
				left: (offsetLeft),
				display: 'block'
			});

		}else{
			target.find('.hoverPoint').animate({
				marginTop: '-250px',
				marginLeft: '-250px',
				width: '500px',
				height: '500px',
				opacity: 0
			}, 1500, 'easeOutQuad');
		}

	},function(e){
		if(!$('html.ie9').length){
			$(this).find('.hoverPoint').fadeOut('300', function(){
				$(this).removeClass('hovered');
			});

		}else{
			$(this).find('.hoverPoint').animate({
				marginTop: '0px',
				marginLeft: '0px',
				width: '0px',
				height: '0px',
				opacity: 1
			}, 1, 'easeOutQuad');
		}
	});
}

$(function () {
    init();
});
