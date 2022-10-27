(function ($) {

    /**
     * initializeBlock
     *
     * Adds custom JavaScript to the block HTML.
     *
     * @date    15/4/19
     * @since   1.0.0
     *
     * @param   object $block The block jQuery element.
     * @param   object attributes The block attributes (only available when editing).
     * @return  void
     */
    var initializeBlock = function ($block) {
        $block.find('.slides').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            centerMode: false,
            variableWidth: false,
            adaptiveHeight: true,
            focusOnSelect: true,
            arrows: true,
            prevArrow:"<button  class='gutenberg-slider__arrow gutenberg-slider__arrow--left'><img src='https://img.icons8.com/external-inkubators-blue-inkubators/50/000000/external-right-chevron-arrow-lite-inkubators-blue-inkubators.png'/></button>",
            nextArrow:"<button class='gutenberg-slider__arrow gutenberg-slider__arrow--right' ><img src='https://img.icons8.com/external-inkubators-blue-inkubators/50/000000/external-right-chevron-arrow-lite-inkubators-blue-inkubators.png                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  '/></button>",
            responsive: [
                {
                  breakpoint: 992,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,

                  }
                },
                {
                  breakpoint: 768,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                },
             
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
              ]
        });
    }


    // Initialize each block on page load (front end).
    $(document).ready(function () {
        $('.gutenberg-slider').each(function () {
            initializeBlock($(this));
        });
    });

    // Initialize dynamic block preview (editor).
    if (window.acf) {
        window.acf.addAction('render_block_preview/type=slider', initializeBlock);
    }

})(jQuery);
