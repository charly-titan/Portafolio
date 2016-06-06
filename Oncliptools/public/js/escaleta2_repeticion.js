var isModoVideo = false;

(function($) {
    $.fn.modoVideo = function(options) {
         if (!this.length && isModoVideo) {
             return this;
         }
         isModoVideo = true;
         var $this = this;
         var cubo = $this.parents('.escaleta-main').find('.cubo-ads');
         var vista = $this.parent().find('.modo-vista');
         var cuadroVista = $this.parent().find('.cuadro');
         var defaults = {
             anchoVideo: $this.width(),
             altoVideo: $this.height()
         };
         var id = '';
         var dispositivo = navigator.userAgent.toLowerCase();
         var opts = $.extend(true, {}, defaults, options);
         //return this;
         var vnt = {
             _videoInit: function() {
                  if (dispositivo.search(/iphone|ipod|ipad|android/) > -1) {
                      $('html').addClass('mobile');
                  }

                  $(document).on('iScroll', function(event, link) {
                        $(link).click();
                  });

                  vnt._videoModoVista();
                  vnt._videoResize(cubo, vista, cuadroVista);
                  vnt._shareMobile();
             },

             _videoModoVista: function() {
                  var modo = $this.parent().find('.vista-video');
                  modo.on('click', function() {
                      vnt._videoPantalla(cubo, vista, cuadroVista);
                  });
             },
             _videoParameters: function($el, ancho, alto, videoSpeed, msj, vista, vistaTXT, cuadroVista, cuadroWidth, cuadroBorder,cuadroSpeed, shareWidth, shareSpeed, widthVista) {
                  $el.animate({
                      'width': ancho,
                      'height': alto
                  }, videoSpeed, function() {
                      console.log(msj);
                  });
                  vista.text(vistaTXT);
                  vista.parent().animate({
                      maxWidth: widthVista
                  }, 50);

                  $el.parent().find('.escaleta-modo-redes').animate({
                      width: shareWidth
                  }, shareSpeed, function() {});

                  cuadroVista.animate({
                           width: cuadroWidth
                      }, cuadroSpeed,
                      function() {
                           cuadroVista.css('border-color', cuadroBorder);
                      });
             },
             _videoPantalla: function($cubo, vista, cuadroVista) {
                  if ($(window).width() >= 959) {
                      if (vista.text() == 'VISTA TEATRO') {
                           $cubo.hide();
                           vnt._videoParameters($this, 948, 534, 500,'pantalla teatro', vista, 'VISTA PREDETERMINADA',cuadroVista, '28px', '#ffffff', 600, 948,600, '240px');
                           vista.addClass('vista-predeterminada');
                           vnt._scrollPlayer($this);
                      } else {
                           $cubo.show(600);
                           vnt._videoParameters($this, 624, 351, 500,'pantalla predeterminada', vista,'VISTA TEATRO', cuadroVista, '35px', '#909090', 600, 624, 600, '180px'); vista.removeClass('vista-predeterminada');
                           vnt._scrollPlayer($this);
                      }
                  } else if ($(window).width() >= 768) {
                      if (vista.text() == 'VISTA TEATRO') {
                           $cubo.hide();
                           vnt._videoParameters($this, '100vw', '56.205vw',500,'pantalla teatro', vista, 'VISTA PREDETERMINADA', cuadroVista, '28px', '#ffffff', 600, '95vw', 600,'240px');
                           vnt._scrollPlayer($this);
                      } else {
                           $cubo.hide();
                           vnt._videoParameters($this, '92.188vw','51.823vw', 500,'pantalla predeterminada', vista, 'VISTA TEATRO', cuadroVista, '35px', '#909090', 600, '92.188vw', 500,'180px');
                           vnt._scrollPlayer($this);
                      }
                  } else if ($(window).width() >= 624) {
                      if (vista.text() == 'VISTA TEATRO') {
                           $cubo.hide();
                           vnt._videoParameters($this, '100vw', '56.25vw',500,'pantalla teatro', vista, 'VISTA PREDETERMINADA', cuadroVista, '28px', '#ffffff', 600, '96vw', 600,'240px');
                           vnt._scrollPlayer($this);
                      } else {
                           $cubo.hide();
                           vnt._videoParameters($this, '92.188vw','51.823vw', 500,'pantalla predeterminada', vista, 'VISTA TEATRO', cuadroVista, '35px', '#909090', 600, '92.188vw', 500, '180px');
                           vnt._scrollPlayer($this);
                      }
                  } else if ($(window).width() > 480) {
                      if (vista.text() == 'VISTA TEATRO') {
                           $cubo.hide();
                           vnt._videoParameters($this, '100vw', '56.25vw',500,'pantalla teatro', vista, 'VISTA PREDETERMINADA', cuadroVista, '28px', '#ffffff', 600, '96vw', 600, '180px');
                           vnt._scrollPlayer($this);
                      } else {
                           $cubo.hide();
                           vnt._videoParameters($this, '92.188vw','51.823vw', 500,'pantalla predeterminada', vista, 'VISTA TEATRO', cuadroVista, '35px', '#909090', 600, '92.188vw', 500, '120px');
                           vnt._scrollPlayer($this);
                      }
                  } else if ($(window).width() >= 320) {
                      if (vista.text() == 'VISTA TEATRO') {
                           $cubo.hide();
                           vnt._videoParameters($this, '100vw', '56.25vw',500,'pantalla predeterminada', vista, 'VISTA PREDETERMINADA', cuadroVista, '28px', '#fff', 600, '98vw', 600, '180px');
                           vnt._scrollPlayer($this);
                      } else {
                           $cubo.hide();
                           vnt._videoParameters($this, '100vw', '56.25vw',500,'pantalla predeterminada', vista, 'VISTA TEATRO', cuadroVista, '35px', '#909090', 600, '98vw', 500, '120px');
                           vnt._scrollPlayer($this);
                      }
                  }
             },
             _videoResize: function($cubo, vista, cuadroVista) {
                  $(window).on('resize', function() {
                      if ($(window).width() >= 959) {
                           if (vista.text() == 'VISTA TEATRO' || vista.text() =='VISTA PREDETERMINADA') {
                               vnt._videoParameters($this, 624, 351, 500,'pantalla predeterminada', vista,'VISTA TEATRO',cuadroVista, '35px', '#909090',600, 624, 600,'180px');
                               $cubo.show(600);
                               $cubo.css('display', 'inline-block');
                               $('video-nt').css({
                                    'width': '624px',
                                    'height': '351px'
                               });
                               vista.removeClass('vista-predeterminada');
                           }
                      } else if ($(window).width() >= 768) {
                                 $cubo.hide();
                                 vnt._videoParameters($this, '92.188vw','51.823vw', 500,'pantalla predeterminada', vista, 'VISTA TEATRO', cuadroVista, '35px', '#909090', 600, '92.188vw', 500,'180px');
                        } else if ($(window).width() >= 624) {
                                 $cubo.hide();
                                 vnt._videoParameters($this, '92.188vw','51.823vw', 500,'pantalla predeterminada', vista, 'VISTA TEATRO', cuadroVista, '35px', '#909090', 600, '92.188vw', 500, '180px');
                        } else if ($(window).width() > 480) {
                                 $cubo.hide();
                                 vnt._videoParameters($this, '92.188vw','51.823vw', 500,'pantalla predeterminada', vista, 'VISTA TEATRO', cuadroVista, '35px', '#909090', 600, '92.188vw', 500, '120px');
                        } else if ($(window).width() >= 320) {                      
                              $cubo.hide();
                              vnt._videoParameters($this, '100vw', '56.25vw',500,'pantalla predeterminada', vista, 'VISTA TEATRO', cuadroVista, '35px', '#909090', 600, '98vw', 500, '120px');
                        }
                  });
             },
             _scrollPlayer: function($el) {
                  var windowScroll = $(window).scrollTop();
                  var playerOffset = $el.parents('.escaleta-main').offset();
                  if (windowScroll > playerOffset.top) {
                      $('body, html').animate({
                           scrollTop: playerOffset.top
                      }, 500);
                  }
             },
             _shareMobile: function() {
               var mmShare = $this.parent().find('.mm-social-icons');
                  //if ($(window).width() <= 768) {
               $(document).on('touchstart mousedown', '.redes', function(event) {
                   event.preventDefault();
                   if (!mmShare.hasClass('mobile')) {
                               mmShare.addClass('mobile');
                   } else {
                        mmShare.removeClass('mobile');
                   }
               });
             }
         }
         vnt._videoInit();
       };
})(jQuery);



var iscarruselEscaleta = false;
var load = $('.escaleta-main').find('.escaleta-thumbnail');

if(load.attr('data-load')!=='true'){
  load.attr('data-load','false');
}

(function($) {
    return $.fn.carruselEscaleta = function(options) {

         if (!this.length && iscarruselEscaleta) {
             return this;
         }
         iscarruselEscaleta = true;
         var $el = this;
         var select = $($el).find('.escaleta-input');
         var videos = $($el).find('.escaleta-thumbnail');
         //var picker;
         var scrollInterval;
         var escaletaWidth;
         var opts = $.extend(true, {}, defaults, options);
         var defaults;
         defaults = {
             item_wrapper: 0,
             itemW: 0,
             //time_search: $($el).data('time-search'),
             left_pos: 0,
             top_pos:0
         }
         var carousel = {
             _init: function() {
                  carousel._updateWidth($el, videos, defaults);
                  carousel._updateWrapper($el, defaults);
                  carousel._reloadComponents();
                  carousel._loadFirstShare();

                  $(document).on({
                     'returnShare': carousel._buildShareData
                  });

                  $(window).on('resize', function(event) {
                      carousel._updateWidth($el, videos, defaults);
                      carousel._updateWrapper($el, defaults);
                      carousel._reloadComponents();
                  });


                  carousel._validateDevice();
                  carousel._swipeInit();

                  var outer = ($('html').hasClass('mobile') ? "touchstart" :"click");

                  $(document).on(outer, '*', function(event) {
                      if ($(event.target).closest(select.find('.select-hour')).length === 0) {
                           $('.select-hour .lista-main').removeClass('open');
                      }

                      if($(event.target).closest($('.escaleta-modo-redes').find('.redes')).length === 0 && $(event.target).closest($('.escaleta-modo-redes').find('.mm-social')).length === 0){
                            $('.mm-social-icons').removeClass('mobile');
                      }
                  });
             },

             _loadFirstShare: function(){
               var contentShare = $('.content-main').find('.mm-social-icons');
                contentShare.attr({
                    'data-comm-img': 'http://i.televisa.com/televisa/generics/clientlibs/commons/img/icons/ICONO_APP_NOTICIEROS_c_180.png',
                    'data-comm-url': 'http://noticieros.televisa.com/',
                    'data-comm-title': 'Noticieros Televisa, toda la información de México y el mundo en un solo lugar',
                    'data-comm-whatsapp': 'Noticieros Televisa, toda la información de México y el mundo en un solo lugar'
                });
             
              //socialShare.indexNotesExpanded();

               if ($(window).width() <= 624 && $('html').is('.mobile')) {
                     var contentShare = $($el).find('.mm-social-icons');
                     var whatsFirst = setInterval(function(){
                        if(contentShare.find('.art-sociales').length === 1){
                           if(contentShare.find('.art-sociales').children().length == 5){
                              clearInterval(whatsFirst);
                              carousel._loadWhatsapp();
                              carousel._shareWhatsapp();
                           }
                        }
                  },300);
               }
             },
             _validateDevice: function() {
                  if ($('html').hasClass('mobile')) {
                      //carousel._setPikaValue();

                      select.find('.lista-valor').css({
                              'z-index': -1,
                              'max-width' : '34.5vw',
                              'left' : '3px'
                      });
                      
                      select.find('.value-mobile').on('click',carousel._arrowMobile);
                      //select Hora
                      if(videos.attr('data-load') === 'false'){  
                        select.find('.select-hour .arrow').on('click', carousel._selectHour);
                        select.find('.select-month .arrow').on('click',carousel._arrowMobile);
                        videos.attr('data-load', 'true');
                      }
                      
                      select.find('#month').on('change', carousel._selectValueMonth);
                      $(document).on('click', '.lista-horario', carousel._selectValueMobile);
                      select.find('#hour').on('change', carousel._selectValueMobile);
                      $('.thumbs > a').swipe({
                           tap: function(events, target) {
                               videos.find('.thumbs').removeClass('active');
                               videos.find('.content-carrusel').removeClass('selected pulse');
                               $(document).trigger('iScroll', [this]);
                               carousel._pulseVideos(this, true);
                               carousel._buildShareData(this);
                           },
                           threshold: 50
                      });
                      carousel._pikaMobile();
                  } else {

                  if(videos.attr('data-load') === 'false'){  
                    var value = carousel._setPikaValue();
                           picker = new Pikaday({
                               field: document.getElementById('month'),
                               firstDay: 1,
                               format: 'YYYY/MM/DD',
                               position: 'bottom rigth',
                               reposition: false,
                               defaultDate: new Date(),
                               minDate: new Date(value.data('min')),
                               maxDate: new Date(value.data('max')),
                               yearRange: [2015, 2015],
                               disableDayFn: function(date){
                                    // Disable Monday
                                    if(date.getDay() === 0 ){
                                      return date.getDay()===0;
                                    }
                                    if(date.getDay() === 6){
                                        return date.getDay()===6;
                                    }
                               },
                           });
                  //}
                      $(document).on('mouseenter', '.next', function(event) {
                           event.preventDefault();
                           carousel._videosNext($el, videos);
                      });
                      $(document).on('mouseleave', '.next', function(event) {
                           event.preventDefault();
                           carousel._videoStopCarrusel($el);
                      });
                      $(document).on('mouseenter', '.back', function(event) {
                           event.preventDefault();
                           carousel._videosBack($el, videos);
                      });
                      $(document).on('mouseleave', '.back', function(event) {
                           event.preventDefault();
                           carousel._videoStopCarrusel($el);
                      });

                      //if(videos.attr('data-load') === 'false'){  
                        $(document).on('click', '.select-month > .arrow', carousel._pikaMonth);
                        $(document).on('click', '.select-hour', carousel._selectHour);
                        videos.attr('data-load', true);
                      }
                      $(document).on('click', '.lista-horario', carousel._selectValue);
                      $(document).on('change', '#month', carousel._changePikaValue);
                      videos.find('.thumbs > a').on('mousedown', function(event) {
                           event.preventDefault();
                           videos.find('.thumbs').removeClass('active');
                           videos.find('.content-carrusel').removeClass('selected pulse');
                           $(document).trigger('iScroll', [this]);
                           carousel._pulseVideos(this, false);
                           carousel._buildShareData(this);
                      });
                  }
             },
             _reloadComponents: function(event) {
               var left = parseInt(videos.find('.escaleta-thumbs-content').css('left'),10);
               var top = parseInt(videos.find('.escaleta-thumbs-content').css('top'),10);
                  if(!videos.find('.content-carrusel').length){
                     videos.css('height', 0);
                     select.find('.select-hour').css({'opacity' : 0.2,});
                     select.find('.select-hour').children().css({'cursor': 'none'})
                  }else if( videos.find('.content-carrusel').length  === 1 ){
                        select.find('.select-hour').css({'opacity' : 1,});
                        select.find('.select-hour').children().css({'cursor': 'pointer'})
                     if($(window).width() <= 480 && $('html').is('.mobile') ){
                        videos.css('height', '220px');
                        videos.find('.escaleta-thumbs-content .content-carrusel').first().addClass('selected pulse')
                     }else{
                        videos.css('height', 'auto');
                        videos.find('.escaleta-thumbs-content .content-carrusel').first().addClass('selected pulse')
                     }
                  }

                  if(event !== undefined){
                        carousel._swipeInit(videos);
                        if($(window).width() <= 480 && $('html').is('.mobile')){
                              videos.find('.escaleta-thumbs-content').height(defaults.itemW);
                              carousel._reloadPosition();
                              videos.find('.escaleta-thumbs-content').css({'width': '100%', top: defaults.top_pos, left :defaults.left_pos});
                        }else if($(window).width() > 480 && $(window).width() <= 624 && $('html').is('.mobile')){
                              videos.find('.escaleta-thumbs-content').width(defaults.itemW);
                              carousel._reloadPosition();
                              videos.find('.escaleta-thumbs-content').css({'height': '208px', top: defaults.top_pos, left :defaults.left_pos});
                        }
                     }


                  if ($(window).width() <= 480 && $('html').is('.mobile')) {
                      console.log('no width');
                      videos.find('.escaleta-thumbs-content').height(defaults.itemW);
                      videos.find('.escaleta-thumbs-content').css({'width': '100%', left: 0, top : 0});
                  } else {
                      videos.find('.escaleta-thumbs-content').width(defaults.itemW);
                      if ($(window).width() > 480 && $('html').is('.mobile')){
                              videos.find('.escaleta-thumbs-content').css({'height': '208px', top: 0, left : 0});
                              select.find('#hour').css({'z-index': 0,height: 35});
                        }else if($(window).width() > 480 ){
                              select.find('#hour').css('z-index',-1);
                              videos.find('.escaleta-thumbs-content').css({'height': '208px'});
                        }
                  }
             },
             _reloadPosition: function(){
                  var nueva_pos = videos.find('.escaleta-thumbs-content .content-carrusel'); 
                  var left = 0
                  var top = 0;
                  for (var i=0; i<$(nueva_pos).length; i++){
                        if(!$(nueva_pos[i]).hasClass('selected pulse')){
                              if($(window).width()<=480 && $('html').is('.mobile')){
                                    top -= $(nueva_pos[i]).outerHeight(true);
                              }else{
                                    left -= $(nueva_pos[i]).outerWidth(true);
                              }
                        }else{
                              break;
                        }
                  }

                  defaults.top_pos = top;
                  defaults.left_pos = left;
             },
             _buildShareData: function(_this) {
                  var contentShare = $($el).find('.mm-social-icons');
                  if($($el).find('.senal').is('.repeticion')){
                     var share = {
                         img: $(_this).find('img').attr('src'),
                         url: window.location.href,
                         title: $(_this).find('p').text()
                     }

                     contentShare.attr({
                         'data-comm-img': share.img,
                         'data-comm-url': share.url,
                         'data-comm-title': share.title,
                         'data-comm-whatsapp': share.title
                     });

                  }else{ 
                     contentShare.attr({
                      'data-comm-img': 'http://i.televisa.com/televisa/generics/clientlibs/commons/img/icons/ICONO_APP_NOTICIEROS_c_180.png',
                      'data-comm-url': 'http://noticieros.televisa.com/',
                      'data-comm-title': 'Noticieros Televisa, toda la información de México y el mundo en un sólo lugar',
                      'data-comm-whatsapp': 'Noticieros Televisa, toda la información de México y el mundo en un sólo lugar'
                     });
                  }

                  //socialShare.indexNotesExpanded();

                  if ($(window).width() <= 624 && $('html').is('.mobile')) {
                        var contador = 0
                        var appendWhats = setInterval(function(){
                              if(contentShare.find('.art-sociales').children().size() == 5 || contentShare.find('.art-sociales').children('.whatsapp').length == 1){
                                    clearInterval(appendWhats);
                                    carousel._loadWhatsapp();
                                    carousel._shareWhatsapp(share);
                              }
                        },300);
                  }
             },
            _loadWhatsapp: function() {
                      var content = $($el).find('.mm-social-icons .art-sociales');
                      content.append('<a class="whatsapp" href="whatsapp://send?text=" data-text=""><i class="noti-whatsapp"></i></a>');
             },
             _shareWhatsapp: function() {
               if($($el).find('.senal').is('.repeticion') && $($el).find('.senal-vivo').is('.activo')){
                  var url = window.location.href;
                  var title = $($el).find('.escaleta-player-content .title').text();
                  var encode = encodeURIComponent(title + ''+ url);
                  $($el).find('.mm-social-icons').attr('data-comm-whatsapp', '');
                  var hrefWA = $('.whatsapp').attr('href');
                  $('.whatsapp').attr({
                      'href': hrefWA + encode,
                      'data-action': 'share/whatsapp/share'
                  });
                  $($el).find('.mm-social-icons').attr('data-comm-whatsapp', title);
               }else{
                  var mm = $($el).find('.mm-social-icons').data('comm-whatsapp');
                  var data_whats = {
                     url : 'http://noticieros.televisa.com/',
                     title : mm,
                  }
                  var encode = encodeURIComponent(data_whats.title);
                  var hrefWA = $('.whatsapp').attr('href');
                  $('.whatsapp').attr({
                      'href': hrefWA + encode,
                      'data-action': 'share/whatsapp/share'
                  });
               }
             },
             _pulseVideos: function(_this, mobile) {
                  var thumbSelect = videos.find('.thumbs');
                  var position = 0;
                  var data = $(_this).parents('.content-carrusel').data('horario');
                  for (var item = 0; item<thumbSelect.length; item++) {
                      if (!$(thumbSelect[item]).is('.active')) {
                           if (mobile && $(window).width() <= 480) {
                               position -= $(_this).outerHeight(true);
                           } else {
                               position -= $(_this).outerWidth(true);
                           }
                        }else if ($(thumbSelect[item]).is('.active')){
                           if(mobile && $(window).width() <= 480){
                              direction = {top: position};
                           }else{
                               direction = {left: position};
                           }
                           break;
                        }
                     }

                  if ($('html').is('.mobile')) {
                     if (position === 0){
                        videos.find('.escaleta-thumbs-content').animate(direction,300,function() {});
                     }
                     else if (position > defaults.item_wrapper && position != 0) {
                           videos.find('.escaleta-thumbs-content').animate(direction,300,function() {});
                     }
                     if (!$(_this).parents('.content-carrusel').is('.selected') && !$(_this).parents('.content-carrusel').is('.pulse')) {
                           $(_this).parents('.content-carrusel').addClass('selected pulse');
                           select.find('#hour').val(data);
                     }
                  } else {
                     if (position == 0 ){
                           videos.find('.next').removeClass('disable');
                           videos.find('.back').addClass('disable'); 
                      } else if (position < defaults.item_wrapper) {
                           videos.find('.next').removeClass('disable');
                           videos.find('.back').removeClass('disable');
                           direction = {left : defaults.item_wrapper};
                      } else if (position > defaults.item_wrapper && position != 0) {
                           videos.find('.next').removeClass('disable');
                           videos.find('.back').removeClass('disable');
                     }
                     videos.find('.escaleta-thumbs-content').animate(direction, 300, function() {});

                      if (!$(_this).parents('.content-carrusel').is('.selected')) {
                           $(_this).parents('.content-carrusel').addClass('selected pulse');
                           select.find('.lista-valor span').text(data);
                           select.find('#hour').val(data);
                      }
                  }
             },
             _swipeInit: function() {
               if(videos.find('.thumbs').length){
                  videos.find('.thumbs').swipe({
                      swipeStatus: function(event, phase, direction,
                           distance,
                           duration, fingers) {
                           var el = this;
                           if ($(window).width() <= 480 && $('html').hasClass('mobile')) {
                               var limit_top = parseInt($(el).parents('.escaleta-thumbnail').css('top'), 10);
                               carousel._swipeCarrusel(el, phase,direction,distance, 'start', 'end', 'up','down', 'top',limit_top, /*limit_bottom,*/true);
                           } else if ($(window).width() > 480 && $('html').hasClass('mobile')) {
                               console.log('direction' + direction);
                               var limit_left = parseInt($(el).parents('.escaleta-thumbnail').css('left'), 10);
                               carousel._swipeCarrusel(el, phase,direction,distance, 'start', 'end','left', 'right','left', limit_left, /*limit_right,*/false);
                           }
                      },
                      threshold: 200,
                      maxTimeThreshold: 5000,
                      fingers: 'all'
                  });
               }
             },
             _swipeCarrusel: function(_this, phase, direction, distance, touchInit, touchEnd, touch_move, touch_retry, cssDirection,limitInit, mobile) { //limitEnd, mobile
                  var pos = 0;
                  var cssDir = {};
                  var cssDir_ = {};
                  if (cssDirection == "left") {
                      cssDir = {
                           'left': 0
                      };
                      cssDir_ = {
                           'left': defaults.item_wrapper
                      };
                  } else {
                      cssDir = {
                           'top': 0
                      };
                      cssDir_ = {
                           'top': defaults.item_wrapper
                      };
                  }

                  if (phase == touchInit) {
                      position = parseInt($(_this).parents('.escaleta-thumbs-content').css(cssDirection), 10);
                  }

                  if (direction == touch_move) {
                      pos = position - distance;
                  } else if (direction == touch_retry) {
                      pos = position + distance;
                  }

                  if (direction == touch_move) {
                      $(_this).parents('.escaleta-thumbs-content').css(cssDirection,pos);
                      if (mobile) {
                           carousel._carruselCheckNext(pos, true);
                      } else {
                           carousel._carruselCheckNext(pos, false);
                      }

                      if (phase == touchEnd) {
                           if ((pos >= limitInit)  || (defaults.item_wrapper > 0)) {
                               $(_this).parents('.escaleta-thumbs-content').animate(cssDir,300,function() {});
                           } else if (pos < defaults.item_wrapper && pos !==0) {
                               $(_this).parents('.escaleta-thumbs-content').animate(cssDir_,300,function() {});
                           }
                      }
                  } else if (direction == touch_retry) {
                      $(_this).parents('.escaleta-thumbs-content').css(cssDirection,pos);
                      if (mobile) {
                           carousel._carruselCheckBack(pos, true);
                      } else {
                           carousel._carruselCheckBack(pos, false);
                      }

                      if (phase == touchEnd) {
                           if ((pos >= limitInit)) {
                               $(_this).parents('.escaleta-thumbs-content').animate(cssDir,300,function() {});
                           } else if (pos < defaults.item_wrapper && pos !==0) {
                               $(_this).parents('.escaleta-thumbs-content').animate(cssDir_, 300,function() {});
                           }
                      }
                  }
             },
             _setPikaValue: function() {
                  var hoy = new Date();
                      hoy.setDate(hoy.getDate() + 1);
                  var date = select.find('#month');
                      date.attr('data-date', hoy);
                  var value_mobile = '';
                  mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo","Junio",
                      "Julio", "Agosto", "Septiembre", "Octubre",
                      "Noviembre",
                      "Diciembre"
                  ];

                  var dateDefault = hoy.toISOString().slice(0,10);
                        date.attr('data-max', dateDefault);

                        var parse = Date.parse(dateDefault)
                        var dateUpload = new Date(parse);
                        var fechaUpload = {
                           dia: dateUpload.getDate() + 1,
                           mes: dateUpload.getMonth(),
                           year: dateUpload.getFullYear()
                      };

                  if ($(window).width() >= 320 && $('html').is('.mobile')) {
                      $('#month').prop('type', 'date');
                      $('.select-month').prepend('<div class="value-mobile"><span class="value-mobile-txt"></span></div>');
                      $('.value-mobile').text(date.data('max'));
                      /*var min = date.data('min');
                      var f = new Date(min);
                      var newVal = f.toISOString().slice(0,10);*/      
                      date.prop({
                           'min': date.data('min'),
                           'max': date.data('max')
                      });
                      //$('#month').attr('value', date.data('max'));
                      /*document.getElementById('month').value = date.data('min');
                      console.log('fecha');*/
                  } else {
                      //var parse = Date.parse(dateDefault);
                      //var dateUpload = new Date(parse);

                      /*if(fechaUpload.mes == 0 || fechaUpload.mes == 2 || fechaUpload.mes == 4 || fechaUpload.mes == 6 || fechaUpload.mes == 7 || fechaUpload.mes == 9 || fechaUpload.mes == 11){
                              if(fechaUpload.dia == 31){
                                    date.val(1 + ' ' + mes[fechaUpload.mes]);
                              }else{
                                    date.val((fechaUpload.dia) + ' ' + mes[fechaUpload.mes]);
                              }
                      }else if(fechaUpload.mes == 3 || fechaUpload.mes == 5 || fechaUpload.mes == 8 || fechaUpload.mes == 10 ){
                              date.val(1 + ' ' + mes[fechaUpload.mes]);
                      }else if (fechaUpload.mes == 1 ){
                              if(fechaUpload.dia == 28 || 29 ){
                                    date.val(1  + ' ' + mes[fechaUpload.mes]);
                              }else{
                                    date.val((fechaUpload.dia) + ' ' + mes[fechaUpload.mes]);
                              }
                      }*/
                      return date;
                  }
             },
             _changePikaValue: function() {
                  var count = 0;
                  
                  var value_actual = $(this).val();
                  var newDate = new Date(value_actual);
                  var value_change = {
                      dia: newDate.getDate(),
                        mes: newDate.getMonth()
                       };
                  $(this).val(value_change.dia + ' ' + mes[value_change.mes]); 
                  $(this).attr('data-date', newDate);                
             },

             _pikaMonth: function(event) {
                  event.preventDefault();
                  if ($('.pika-single').hasClass('is-hidden')) {
                      picker.show();
                  } else {
                      picker.hide();
                  }
             },
             _pikaMobile: function(event) {
                  var minDay = $('#month').data('min');
                  var maxDay = $('#month').data('max');
                  var today = $('#month').data('today');
                  $('#month').prop({
                      'type': 'date',
                      'min': minDay,
                      'max': maxDay
                  });
                  $('#month').val(today);
             },
             _arrowMobile: function(){
                  $(this).siblings('#month').trigger('click').focus();
             },
             _selectHour: function(event) {
                  event.preventDefault();
                  var combo = $(this).parents('.content-main').find('.lista-main');
                  if (!combo.is('.open')) {
                      combo.addClass('open');
                  } else {
                      combo.removeClass('open');
                  }
             },
             _selectValue: function(event) {
                  event.preventDefault();
                  _this = this;
                  videos.find('.content-carrusel').removeClass('selected pulse');
                  select.find('.lista-horario').removeClass('selected');
                  $(_this).addClass('selected');
                  var position = parseInt($(_this).parents('.content-main').find('.escaleta-thumbs-content').css('left'), 10);
                  contentScroll = $(_this).parents('.content-main').find('.escaleta-thumbs-content').outerWidth(true);
                  contentParent = $(_this).parents('.content-main').find('.escaleta-thumbnail').width();
                  contentTotal = contentScroll - contentParent;
                  var value = $(_this).data('value');
                  var valueHour = $(_this).parents('.select-hour').find('.lista-valor span');
                  valueHour.text(value);
                  changeValSelect = $(_this).parents('.select-hour').find('#hour');
                  changeValSelect.val(value);

                  var carruselSelected = $(_this).parents('.content-main').find('.content-carrusel');
                  carruselSelected.removeClass('selected pulse');
                  var position = 0;

                  var listaWidth = 0;
                  for (var i = 0; i < carruselSelected.length; i++) {

                      el = this;
                      numSelect = $(_this).index();

                      if(numSelect === 0 && defaults.item_wrapper < 0){
                           position = 0
                           $(carruselSelected).parents('.content-main').find('.next').removeClass('disable');
                           $(carruselSelected).parents('.content-main').find('.back').addClass('disable');
                           $(carruselSelected[i]).addClass('selected pulse');
                           break;
                      } else if (numSelect === 0 && defaults.item_wrapper > 0) {
                           position = 0;
                           $(carruselSelected).parents('.content-main').find('.next').addClass('disable');
                           $(carruselSelected).parents('.content-main').find('.back').addClass('disable');
                           $(carruselSelected[i]).addClass('selected pulse');
                           break;
                      } else if (numSelect != $(carruselSelected[i]).index()) {
                           listaWidth -= $(carruselSelected[i]).outerWidth(true);
                           $(carruselSelected).parents('.content-main').find('.next').removeClass('disable');
                           $(carruselSelected).parents('.content-main').find('.back').removeClass('disable');
                      } else if (numSelect == $(carruselSelected[i]).index()) {
                           $(carruselSelected[i]).addClass('selected pulse');
                           position = listaWidth;
                           break;
                      }
                  }

                  if(position === 0){
                     position = 0;
                  }else if (position < defaults.item_wrapper) {
                      position = defaults.item_wrapper;
                      videos.find('.next').addClass('disable');
                      videos.find('.back').removeClass('disable');
                   }

                  $(this).parents('.content-main').find('.escaleta-thumbs-content').animate({left: position},300,function() {});
             },
             _selectValueMonth: function(){
                  var val = $(this).val();
                  var date = new Date(val);
                  $('.value-mobile').text(val);
                  $('#month').attr('data-date',date);
             },
             _selectValueMobile: function() {
                  event.preventDefault();
                  var _this = this;
                  var carrusel = $(_this).parents('.content-main').find('.content-carrusel');
                  var lista = $($el).find('.lista-horario');
                  lista.removeClass('selected');
                  carrusel.removeClass('selected pulse');

                  if ($(window).width() <= 480) {
                      carousel._recorridoCarrusel(_this, carrusel, 'top',true);

                  } else if ($(window).width() > 480 && $('html').hasClass('mobile')) {
                      carousel._recorridoCarrusel(_this, carrusel, 'left',false);
                  }
             },
             _recorridoCarrusel: function(_this, carrusel, direction, isMobile) {
                  var position = 0;
                  var mover = {};

                  carrusel.each(function(i, el) {
                      el = this;
                      numLista = $(el).data('horario');
                        initList = $(el).index();
                      if(_this.className == 'lista-horario'){
                              numSelect = $(_this).index();//$(_this).data('value');

                            if (numSelect !== initList) {
                                 if (isMobile) {
                                     position -= $(el).outerHeight(true);
                                 } else {
                                     position -= $(el).outerWidth(true);
                                 }
                            } else if (numSelect === initList && numSelect !== 0) {
                                    $(el).addClass('selected pulse');
                                    $(_this).addClass('selected');
                                    $(_this).parents('.content-main').find('#hour').val($(_this).data('value'));
                                    return false;
                            }else if ( numSelect == initList && numSelect === 0){
                                    position = 0
                                    $(el).addClass('selected pulse');
                                    $(_this).addClass('selected');
                                    $(_this).parents('.content-main').find('#hour').val($(_this).data('value'));
                                    return false;
                            }

                      }else{
                              numSelect = $(_this).val();
                              if (numSelect !== numLista) {
                                 if (isMobile) {
                                     position -= $(el).outerHeight(true);
                                 } else {
                                     position -= $(el).outerWidth(true);
                                 }
                            } else if (numSelect === numLista) {
                                 $(el).addClass('selected pulse');
                                 return false;
                            }
                      }
                  });
                  if(position === 0){
                     position = 0;
                  }else if (position < defaults.item_wrapper) {
                      position = defaults.item_wrapper;
                  }

                  if (direction == 'left') {
                      mover = {
                           'left': position
                      };
                  } else if (direction == 'top') {
                      mover = {
                           'top': position
                      };
                  }

                  $(_this).parents('.content-main').find('.lista-main').removeClass('open');
                  $(_this).parents('.content-main').find('.escaleta-thumbs-content').animate(mover,300,function() {});

             },
             _updateWrapper: function(_this) {
                  var ml = 0,mr = 0,mask = 0,wrapper = 0;
                  if ($(window).width() <= 480 && $('html').is('.mobile')) {
                      var position = parseInt($(_this).find(".escaleta-thumbs-content").css('top'), 10);
                      ml = parseInt($(_this).find(".escaleta-thumbnail").css('margin-left'));
                      mr = parseInt($(_this).find(".escaleta-thumbnail").css('margin-right'));
                      mask = parseInt($(_this).find(".escaleta-thumbnail").height() -defaults.itemW, 10);
                      wrapper = mask - ml - mr;
                      defaults.item_wrapper = wrapper;
                      if ((wrapper < 0 && position === 0) || defaults.item_wrapper > 0) {
                               $(_this).find('.escaleta-thumbs-content').css('top', 0);
                        } else if (position < wrapper - 12) {
                              $(_this).find('.escaleta-thumbs-content').css('top',parseInt(wrapper, 10));
                        }
                        videos.find('.back').addClass('disable');
                        videos.find('.next').addClass('disable');
                  } else {
                      var position = parseInt($(_this).find(".escaleta-thumbs-content").css('left'), 10);
                      if ($(window).width() > 480 && $('html').is('.mobile')) {
                           ml = parseInt($(_this).find(".escaleta-thumbnail").css('margin-left'));
                           mr = parseInt($(_this).find(".escaleta-thumbnail").css('margin-right'));
                           mask = parseInt($(_this).find(".escaleta-thumbnail").width() -defaults.itemW, 10);
                           wrapper = mask - ml - mr;
                           defaults.item_wrapper = wrapper;
                           if ((wrapper < 0 && position === 0) || defaults.item_wrapper > 0) {
                               $(_this).find('.escaleta-thumbs-content').css('left', 0);
                           } else if (position < wrapper - 12) {
                              $(_this).find('.escaleta-thumbs-content').css('left',parseInt(wrapper, 10));
                           }
                              videos.find('.back').addClass('disable');
                              videos.find('.next').addClass('disable');
                      } else {
                           ml = parseInt($(_this).find(".escaleta-thumbnail").css('margin-left'));
                           mr = parseInt($(_this).find(".escaleta-thumbnail").css('margin-right'));
                           mask = parseInt($(_this).find(".escaleta-thumbnail").width() -defaults.itemW, 10);
                           wrapper = mask - ml - mr;
                           defaults.item_wrapper = wrapper;
                           if (wrapper > 0) {
                               $(_this).find('.next').addClass('disable');
                               $(_this).find('.back').addClass('disable');
                           } else if (position > 0) {
                               $(_this).find('.back').removeClass('disable');
                           } else if (position < wrapper - 12) {
                               $(_this).find('.escaleta-thumbs-content').css('left',parseInt(wrapper, 10));
                               $(_this).find('.next').removeClass('disable');
                           } else if (wrapper < 0 && position === 0) {
                               $(_this).find('.escaleta-thumbs-content').css('left', 0);
                               $(_this).find('.back').addClass('disable');
                               $(_this).find('.next').removeClass('disable');
                           } else if (wrapper < 0 && position === wrapper) {
                               $(_this).find('.next').addClass('disable');
                               $(_this).find('.back').removeClass('disable');
                           }
                      }
                      return wrapper;
                  }
             },
             _updateWidth: function(_this, videos, defaults) {
                  var itemWidth = 0;
                  var thumbsWidth = $(videos).find('.thumbs');
                  for (var i = 0; i < thumbsWidth.length; i++){
                      if ($(window).width() <= 480 && $('html').is('.mobile')) {
                           itemWidth += $(thumbsWidth[i]).outerHeight(true);
                      } else {
                           itemWidth += $(thumbsWidth[i]).outerWidth(true);
                      }
                  }
                  defaults.itemW = itemWidth;
             },
             _videosNext: function(_this, videos) {
                  var position = parseInt($(videos).find('.escaleta-thumbs-content').css('left'), 10);
                  escaletaWidth = $(videos).width() - defaults.itemW;
                  scrollInterval = setInterval(function() {
                      if (position > escaletaWidth) {
                           position -= 12
                           if ((position - 12) < escaletaWidth) {
                               $(_this).find('.escaleta-thumbs-content').css('left',escaletaWidth);
                               $(_this).find('.next').addClass('disable');
                               if (position < escaletaWidth) position =escaletaWidth;
                               $(_this).find('.escaleta-thumbs-content').css('left',position);
                           } else {
                               $(_this).find('.escaleta-thumbs-content').css('left',position);
                           }
                      } else {
                           carousel._videoStopCarrusel(_this);
                      }

                      if (position == escaletaWidth) {
                           $(_this).find('.next').addClass('disable');
                      } else if (position < 0) {
                           $(_this).find('.back').removeClass('disable');
                      }

                      carousel._carruselCheckNext(position);

                  }, 20);

             },
             _videosBack: function(_this, videos, defaults) {
                  var position = parseInt($('.escaleta-thumbnail').find('.escaleta-thumbs-content').css('left'), 10);
                  scrollInterval = setInterval(function() {
                      if (position < 0) {
                           position += 12;
                           if (position > 0) position = 0;
                           $(_this).find('.back').parent().find('.escaleta-thumbs-content').css('left', position);
                      } else {
                           carousel._videoStopCarrusel(_this);
                      }

                      if (position > escaletaWidth && position !== 0) {
                           $(_this).find('.next').removeClass('disable');
                      } else if (position === 0) {
                           $(_this).find('.back').addClass('disable');
                      }

                      carousel._carruselCheckBack(position);

                  }, 20);
             },
             _carruselCheckNext: function(pos) {
                  var horario = select.find('.lista-horario');
                  var thumb = videos.find('.content-carrusel');
                  var lista_horario = select.find('.lista-valor span');
                  var videoWidth = 0;

                  for (i = 0; i < horario.length; i++) {
                      if (horario.eq(i).data('value') === videos.find('.content-carrusel.selected.pulse').data('horario')) {
                           if ($(window).width() <= 480 && $('html').is('.mobile')) {
                               videoWidth -= thumb.eq(i).outerHeight(true);
                           } else {
                               videoWidth -= thumb.eq(i).outerWidth(true);
                           }
                           break;
                      } else if (horario.eq(i).data('value') !== videos.find('.content-carrusel.selected.pulse').data('horario')) {
                           if ($(window).width() <= 480 && $('html').is('.mobile')) { 
                               videoWidth -= thumb.eq(i).outerHeight(true);
                           } else {
                               videoWidth -= thumb.eq(i).outerWidth(true);
                           }
                      }
                  }

                  if (pos < videoWidth || defaults.item_wrapper >= pos){
                      var horario = select.find('.lista-horario.selected');
                      var thumbnail = videos.find('.content-carrusel.selected.pulse');
                      if (horario.next().length) {
                           horario.removeClass('selected').next().addClass('selected');
                           thumbnail.removeClass('selected pulse').next().addClass('selected pulse');
                           var value = horario.next().data('value');
                           var lista_horario = select.find('.lista-valor span');
                           lista_horario.text(value);
                           var optionVal = select.find('#hour');
                           optionVal.val(value);
                      }
                  }
             },
             _carruselCheckBack: function(pos) {
                  var horario = select.find('.lista-horario');
                  var thumb = videos.find('.content-carrusel');
                  var lista_horario = select.find('.lista-valor span');
                  var videoWidth = 0;

                  for (i = 0; i < horario.length; i++) {
                      if (horario.eq(i).data('value') === videos.find('.content-carrusel.selected.pulse').data('horario')) {
                        break;
                      } else if (horario.eq(i).data('value') !== videos.find('.content-carrusel.selected.pulse').data('horario')) {
                           if ($(window).width() <= 480 && $('html').is('.mobile')) { 
                               videoWidth -= thumb.eq(i).outerHeight(true);
                           } else {
                               videoWidth -= thumb.eq(i).outerWidth(true);
                           }
                      }
                  }

                  if (pos > videoWidth || pos === 0) {
                      var hour = select.find('.lista-horario.selected');
                      var thumbnail = videos.find('.content-carrusel.selected.pulse');
                      if (hour.prev().length !== 0) {
                           hour.removeClass('selected').prev().addClass('selected');
                           thumbnail.removeClass('selected pulse').prev().addClass('selected pulse');
                           var value = hour.prev().data('value');
                           var lista_horario = select.find('.lista-valor span');
                           lista_horario.text(value);
                           var optionVal = select.find('#hour');
                           optionVal.val(value);
                      }else if (hour.prev().length === 0){
                        hour.removeClass('selected');
                        select.find('.lista-horario').first().addClass('selected');
                        thumbnail.removeClass('selected pulse');
                        videos.find('.content-carrusel').first().addClass('selected pulse');
                        var value = hour.data('value');
                        lista_horario.text(value);
                        var optionVal = select.find('#hour');
                         optionVal.val(value);
                      }
                  }
             },
             _videoStopCarrusel: function(_this) {
                  if (!scrollInterval) return;
                  clearInterval(scrollInterval);
             }
         }
     carousel._init();
    };
})(jQuery);

function noticieros(video, carrusel) {
  try{
    jQuery(video).modoVideo();
    jQuery(carrusel).carruselEscaleta();
  }catch(e){} 
};

function loadCarrusel(carrusel) {
    jQuery(carrusel).carruselEscaleta();
    console.warn('refresh escaleta');
};
