



$(".testi-carousel").owlCarousel({
    autoPlay: 3000,
    stopOnHover: true,
    navigation: false,
    paginationSpeed: 1000,
    goToFirstSpeed: 2000,
    singleItem: true,
    autoHeight: true,
});




// typed
$(".element").each(function(){
    var $this = $(this);
    $this.typed({
        strings: $this.attr('data-elements').split(','),
        typeSpeed: 100, // typing speed
        backDelay: 3000 // pause before backspacing
    });
});

// video
$(".player").mb_YTPlayer();


