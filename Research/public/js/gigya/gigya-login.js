var gigyaHeader = {
    gigyaShowTime: 600,
    gigyaAnimationTime: 300,
    gigyaTooltipTime: 5000,
    gigyaInitTime: 500,
	gigyaLoginMessage: 'Inicia sesi&oacute;n',
	gigyaPlaceholder: 'http://i2.esmas.com/finalpage/npk3-gigya-header/img/user_placeholder.png' ,
	
	//Funciones vacías para extender callbacks.
	sessionStart: function(){},
	sessionLogout:function(){},
	sessionPrefs: function(){},
	
    show: function(){
        $('.gigya-header-login .gigya-tooltip').toggleClass('open');
        if($('.gigya-header-login .gigya-tooltip').hasClass('open')){
            $('span.gigya-header-login a.init i').attr('class', 'tvsaFH-caret-up');
        } else {
            $('span.gigya-header-login a.init i').attr('class', 'tvsaFH-caret-down');
        }
    },
   
    hover: function(){
        if(($(window).width() > 947)){
            $('.gigya-header-login .gigya-tooltip').addClass('open');
            $('span.gigya-header-login a.init i').attr('class', 'tvsaFH-caret-up');
        }
    },

    hideToolip: function(){
        $('.gigya-header-login .gigya-tooltip').removeClass('open');
        $('span.gigya-header-login a.init i').attr('class', 'tvsaFH-caret-down');
    },

	loginSession: function(){
		$('.gigya-header-login').removeClass('show');
		$('.gigya-header-login .gigya-tooltip').hide();
		setTimeout(function(){
			var sessionWidget = '<a href="#" class="ui-gy-login__content nosession">';
			sessionWidget += '<i class="ui-gy-icon--login"></i>';
			sessionWidget += '</a>';
			sessionWidget += '<div class="gigya-tooltip aviso">';
			sessionWidget += '<span class="info_usuario" id="saludo_usuario">';
			sessionWidget += '<strong>';
			sessionWidget += '<a href="#">'+gigyaHeader.gigyaLoginMessage+'</a>';
			sessionWidget += '</strong>';
			sessionWidget += '</span>';
			sessionWidget += '</div>';
			$('.gigya-header-login').empty().append(sessionWidget).removeClass('session').addClass('show');
			comp.bindEvents();
			setTimeout(function(){
				$('.gigya-header-login .aviso').addClass('open');
				setTimeout(function(){
					$('.gigya-header-login .aviso').removeClass('open');
				}, comp.gigyaTooltipTime);
			}, comp.gigyaAnimationTime);
		}, comp.gigyaShowTime);
	},
	
	loadSession: function(user, callbacks){
		var comp = this;
		var imageUrl = (user.image == '') ? comp.gigyaPlaceholder : user.image;
		if(typeof callbacks !== 'undefined'){
			$.extend(this, callbacks);
		}
		$('.gigya-header-login').removeClass('show');
		$('.gigya-tooltip.aviso').hide();
		setTimeout(function(){
			var sessionWidget = '<a href="#" class="ui-gy-login__content init">';
			sessionWidget += '<img class="ui-gy-login__avatar tvsaimg-loaded" src="'+imageUrl+'"/>';
			sessionWidget += '<i class="tvsaFH-caret-down"></i>';
			sessionWidget += '</a>';
			sessionWidget += '<div class="gigya-tooltip">';
			sessionWidget += '<div class="img_user_social" id="avatar_social">';
			sessionWidget += '<img id="avatar_usuario" src="'+imageUrl+'">';
			sessionWidget += '</div>';
			sessionWidget += '<span class="info_usuario" id="saludo">'+user.greeting+'</span>';
			sessionWidget += '<span class="info_usuario" id="saludo_usuario"><strong>'+user.name+'</strong></span><span class="login_social" id="pref_social"><a><i class=""></i><strong>Preferencias</strong></a></span>';
			sessionWidget += '<span class="login_social" id="cerrar_social"><i class=""></i><a>Cerrar sesi&oacute;n</a></span>';
			sessionWidget += '</div>';
			$('.gigya-header-login').addClass('session').addClass('show').empty().append(sessionWidget);
			comp.bindEvents();
		 }, comp.gigyaShowTime);
	},
	
    bindEvents: function(){
        $('.gigya-header-login:not(.session) a').click(function(e){
            e.preventDefault();
            gigyaHeader.sessionStart();
        });
		
		$('.gigya-header-login.session #pref_social a').click(function(e){
            e.preventDefault();
            gigyaHeader.sessionPrefs();
        });
		
		$('.gigya-header-login.session #cerrar_social a').click(function(e){
            e.preventDefault();
            gigyaHeader.sessionLogout();
        });

        $('.ui-gy-login__content').click(function(e){
            e.preventDefault();
            if(!$('.gigya-header-login').hasClass('no-click') || ($(window).width() <= 947)){
                gigyaHeader.show();
            }
        });

        $('.ui-gy-login__content, .ui-gy-login__content i').mouseenter(function(e){
            gigyaHeader.hover();
            $('.gigya-header-login').addClass('no-click');
        });

        $('.ui-gy-login__content, .ui-gy-login__content i').mouseout(function(e){
            $('.gigya-header-login').removeClass('no-click');
        });

        $(document).on('touchend mouseup', function (e){
            var container = $('.gigya-header-login .gigya-tooltip, .ui-gy-login__content');
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                gigyaHeader.hideToolip();
            }
        });
    },
	
    init: function(user, callbacks){
    	comp = this;
    	if(document.getElementById('nav_header_televisa')){
	    	// $("head").append('<link rel="stylesheet" href="http://i2.esmas.com/finalpage/npk3-gigya-header/css/gigyalogin.css">');
			//$("head").append('<link rel="stylesheet" href="https://s3-us-west-1.amazonaws.com/communities-dev/social_engage/gigyalogin.css">');
			$('#nav_header_televisa div.topnav span.date').hide();
			// $("<span>",{"class":"gigya-header-login","id" : "login_header_gigya"}).insertAfter('#nav_header_televisa span.date');
			$("<span>",{"class":"gigya-header-login","id" : "login_gigya"}).insertAfter('#nav_header_televisa span.date');
			user = typeof user !== 'undefined' ? user : false; 
			user = !$.isEmptyObject(user) ? user : false;
			if(user){
				comp.loadSession(user);
			} else {
				comp.loginSession();
			}
			$.extend(this, callbacks);
	        setTimeout(function(){
	            $('.gigya-header-login').addClass('show');
	            setTimeout(function(){
	                $('.gigya-header-login .aviso').addClass('open');
	                setTimeout(function(){
	                    $('.gigya-header-login .aviso').removeClass('open');
	                }, comp.gigyaTooltipTime);
	            }, comp.gigyaAnimationTime);
	        }, comp.gigyaShowTime);
	    } else {
			setTimeout(function(){
				comp.init(user, callbacks);
			}, comp.gigyaInitTime);
	    }
    }
};