
$(document).ready(function() {
    /* Slick
    =========================================== */
    $('.slide ul').slick({
      dots: true,
      infinite: true,
      speed: 500,
      fade: true,
      autoplay: true,
      autoplaySpeed: 5000,
      cssEase: 'linear'

    });
    $('.title_table').click(function() {
        $(this).next().slideToggle("100");
    });

    /* Hover swap images
    -------------------------------------- */
    $('img.hoverSwap').hover(
        function() {
            $(this).attr('src', $(this).attr('src').replace('_off', '_on'));
        },
        function() {
            $(this).attr('src', $(this).attr('src').replace('_on', '_off'));
        }
    );
});
