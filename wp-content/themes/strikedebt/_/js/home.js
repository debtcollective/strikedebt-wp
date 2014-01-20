// non-jQuery

  $(document).ready(function() {
    function filterPath(string) {
    return string
      .replace(/^\//,'')
      .replace(/(index|default).[a-zA-Z]{3,4}$/,'')
      .replace(/\/$/,'');
    }
    var locationPath = filterPath(location.pathname);
    var scrollElem = scrollableElement('html', 'body');
    var scrollTargets = [];
   
    $('a[href*=#]').each(function() {
      var thisPath = filterPath(this.pathname) || locationPath;
      if (  locationPath == thisPath
      && (location.hostname == this.hostname || !this.hostname)
      && this.hash.replace(/#/,'') ) {
        var $target = $(this.hash), target = this.hash;
        if (target) {
          var targetOffset = $target.offset().top;
          scrollTargets.push([target, targetOffset]);
          $(this).click(function(event) {
            event.preventDefault();
            $(scrollElem).animate({scrollTop: targetOffset}, 400, function() {
              location.hash = target;
            });
          });
        }
      }
    });
    
    if (scrollTargets) {
        $(window).scroll(function() {
            var scrollTop = document.documentElement.scrollTop ?
                            document.documentElement.scrollTop : document.body.scrollTop;
            var active = scrollTargets[0][0];
            if (window.innerHeight + scrollTop >= document.body.scrollHeight) {
                active = scrollTargets[scrollTargets.length-1][0];
            } else {
                for (var i=scrollTargets.length-1; i>0; i--) {
                    if (scrollTop > scrollTargets[i][1] - 10) {
                        active = scrollTargets[i][0];
                        break;
                    }
                }
            }
            var activea = $(active + '_nav');
            if (!activea.hasClass('active')) {
                $('nav a.active').removeClass('active');
                activea.addClass('active');
            }
        });
    }

   
    // use the first element that is "scrollable"
    function scrollableElement(els) {
      for (var i = 0, argLength = arguments.length; i <argLength; i++) {
        var el = arguments[i],
            $scrollElement = $(el);
        if ($scrollElement.scrollTop()> 0) {
          return el;
        } else {
          $scrollElement.scrollTop(1);
          var isScrollable = $scrollElement.scrollTop()> 0;
          $scrollElement.scrollTop(0);
          if (isScrollable) {
            return el;
          }
        }
      }
      return [];
    }
   
    
    function preload(arrayOfImages) {
      $(arrayOfImages).each(function(){
          $('<img/>')[0].src = this;
          // Alternatively you could use:
          // (new Image()).src = this;
      });
    }
  
    // Usage:
    
    preload([
        '/wp-content/themes/strikedebt/_/rj_bg_color.jpg',
        '/wp-content/themes/strikedebt/_/kit_bg_hover.jpg',
        '/wp-content/themes/strikedebt/_/drom2_bg_color.jpg'
    ]);
  
  
  });