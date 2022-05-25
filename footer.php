<div class="dmtop dmtop-show cd-fade-out"><a href="#"><i class="fa fa-angle-up"></i></a></div>
<footer>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="ftr-img logo">
            <img src="images/LOGO.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="ftr-txt text-end">
            <ul class="d-flex justify-content-end">
              <li class="me-4"><a href="#"><i class="fab fa-instagram"></i></a></li>
              <li class="me-4"><a href="#"><i class="fab fa-facebook-square"></i></a></li>
              <li class="me-4"><a href="#"><i class="fab fa-twitter"></i></a></li>
              <li class="me-0"><a href="#"><i class="fab fa-youtube"></i></a></li>
            </ul>
            <p>Copyright @ 2021-22 Rights Reserved</p>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/1.1.1/typed.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
      $('.owl-carousel').owlCarousel({
          loop:true,
          margin:10,
          nav:true,
          responsive:{
              0:{
                  items:1
              },
              600:{
                  items:3
              },
              1000:{
                  items:5
              }
          }
      })
    </script>
    <script>
      $(window).scroll(function() {    
	var scroll = $(window).scrollTop();
	if (scroll >= 50) {
		$(".main_header").addClass("header_bg");
	} else {
		$(".main_header").removeClass("header_bg");
	}
 });
    </script>
    <script>
      jQuery(document).ready($ => {
  $(".quantity").on("click", ".plus", function (e) {
    let $input = $(this).prev("input.qty");
    let val = parseInt($input.val());
    $input.val(val + 1).change();
  });

  $(".quantity").on("click", ".minus", function (e) {
    let $input = $(this).next("input.qty");
    var val = parseInt($input.val());
    if (val > 0) {
      $input.val(val - 1).change();
    }
  });
});
    </script>
    <script>
      !function ($) {

"use strict"; // jshint ;_;


/* MAGNIFY PUBLIC CLASS DEFINITION
 * =============================== */

var Magnify = function (element, options) {
    this.init('magnify', element, options)
}

Magnify.prototype = {

    constructor: Magnify

    , init: function (type, element, options) {
        var event = 'mousemove'
            , eventOut = 'mouseleave';

        this.type = type
        this.$element = $(element)
        this.options = this.getOptions(options)
        this.nativeWidth = 0
        this.nativeHeight = 0

        this.$element.wrap('<div class="magnify" \>');
        this.$element.parent('.magnify').append('<div class="magnify-large" \>');
        this.$element.siblings(".magnify-large").css("background","url('" + this.$element.attr("src") + "') no-repeat");

        this.$element.parent('.magnify').on(event + '.' + this.type, $.proxy(this.check, this));
        this.$element.parent('.magnify').on(eventOut + '.' + this.type, $.proxy(this.check, this));
    }

    , getOptions: function (options) {
        options = $.extend({}, $.fn[this.type].defaults, options, this.$element.data())

        if (options.delay && typeof options.delay == 'number') {
            options.delay = {
                show: options.delay
                , hide: options.delay
            }
        }

        return options
    }

    , check: function (e) {
        var container = $(e.currentTarget);
        var self = container.children('img');
        var mag = container.children(".magnify-large");

        // Get the native dimensions of the image
        if(!this.nativeWidth && !this.nativeHeight) {
            var image = new Image();
            image.src = self.attr("src");

            this.nativeWidth = image.width;
            this.nativeHeight = image.height;

        } else {

            var magnifyOffset = container.offset();
            var mx = e.pageX - magnifyOffset.left;
            var my = e.pageY - magnifyOffset.top;

            if (mx < container.width() && my < container.height() && mx > 0 && my > 0) {
                mag.fadeIn(100);
            } else {
                mag.fadeOut(100);
            }

            if(mag.is(":visible"))
            {
                var rx = Math.round(mx/container.width()*this.nativeWidth - mag.width()/2)*-1;
                var ry = Math.round(my/container.height()*this.nativeHeight - mag.height()/2)*-1;
                var bgp = rx + "px " + ry + "px";

                var px = mx - mag.width()/2;
                var py = my - mag.height()/2;

                mag.css({left: px, top: py, backgroundPosition: bgp});
            }
        }

    }
}


/* MAGNIFY PLUGIN DEFINITION
 * ========================= */

$.fn.magnify = function ( option ) {
    return this.each(function () {
        var $this = $(this)
            , data = $this.data('magnify')
            , options = typeof option == 'object' && option
        if (!data) $this.data('tooltip', (data = new Magnify(this, options)))
        if (typeof option == 'string') data[option]()
    })
}

$.fn.magnify.Constructor = Magnify

$.fn.magnify.defaults = {
    delay: 0
}


/* MAGNIFY DATA-API
 * ================ */

$(window).on('load', function () {
    $('[data-toggle="magnify"]').each(function () {
        var $mag = $(this);
        $mag.magnify()
    })
})

} ( window.jQuery );
    </script>
    <script>
              (function() {
        
        window.inputNumber = function(el) {

          var min = el.attr('min') || false;
          var max = el.attr('max') || false;

          var els = {};

          els.dec = el.prev();
          els.inc = el.next();

          el.each(function() {
            init($(this));
          });

          function init(el) {

            els.dec.on('click', decrement);
            els.inc.on('click', increment);

            function decrement() {
              var value = el[0].value;
              value--;
              if(!min || value >= min) {
                el[0].value = value;
              }
            }

            function increment() {
              var value = el[0].value;
              value++;
              if(!max || value <= max) {
                el[0].value = value++;
              }
            }
          }
        }
        })();

        inputNumber($('.input-number'));
    </script>
  </body>
</html>