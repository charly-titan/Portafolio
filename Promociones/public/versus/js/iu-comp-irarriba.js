$(document).ready(function(){var $root=$('html, body');$('.btgototx').click(function(){if($(this).attr('data-goto')){var destino=$($(this).data('goto')).offset().top}
else{var destino=$('body').offset().top}
$root.animate({scrollTop:destino},500);return false;});var uigoto=$(".iu-btn-irarriba");var scrollShow=uigoto.data("show");$(window).scroll(function(){if($(this).scrollTop()>scrollShow)
{$('.iu-btn-irarriba').fadeIn();}
else
{$('.iu-btn-irarriba').fadeOut();}});});