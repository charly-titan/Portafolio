;(function($){$.fn.autogrow=function(opts){var that=$(this).css({overflow:'hidden',resize:'none'}),selector=that.selector,defaults={context:$(document),animate:true,speed:200,fixMinHeight:true,cloneClass:'autogrowclone'};opts=$.isPlainObject(opts)?opts:{context:opts?opts:$(document)};opts=$.extend({},defaults,opts);that.each(function(i,elem){var min,clone;elem=$(elem);if(elem.is(':visible')||parseInt(elem.css('height'),10)>0){min=parseInt(elem.css('height'),10)||elem.innerHeight();}else{clone=elem.clone().addClass(opts.cloneClass).val(elem.val()).css({position:'absolute',visibility:'hidden',display:'block'});$('body').append(clone);min=clone.innerHeight();clone.remove();}
if(opts.fixMinHeight){elem.data('autogrow-start-height',min);}
elem.css('height',min);});opts.context.on('keyup paste',selector,resize);function resize(e){var box=$(this),oldHeight=box.innerHeight(),newHeight=this.scrollHeight,minHeight=box.data('autogrow-start-height')||0,clone;if(oldHeight<newHeight){this.scrollTop=0;opts.animate?box.stop().animate({height:newHeight},opts.speed):box.innerHeight(newHeight);}else if(e.which==8||e.which==46||(e.ctrlKey&&e.which==88)){if(oldHeight>minHeight){clone=box.clone().addClass(opts.cloneClass).css({position:'absolute',zIndex:-10}).val(box.val());box.after(clone);do{newHeight=clone[0].scrollHeight-1;clone.innerHeight(newHeight);}while(newHeight===clone[0].scrollHeight);newHeight++;clone.remove();newHeight<minHeight&&(newHeight=minHeight);oldHeight>newHeight&&opts.animate?box.stop().animate({height:newHeight},opts.speed):box.innerHeight(newHeight);}else{box.innerHeight(minHeight);}}}}})(jQuery);$(document).ready(function(){$('.autogrow').autogrow();});