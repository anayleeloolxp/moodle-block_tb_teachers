require(["jquery"],function($) {
    
    $(document).ready(function() {

        $('.tb_teachers').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            autoplay: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                    dots: false
                },
                600: {
                    items: 2,
                    nav: true,
                    dots: false
                },
                1000: {
                    items: 2,
                    nav: true,
                    dots: false
                }
            }
        });
    });    
});