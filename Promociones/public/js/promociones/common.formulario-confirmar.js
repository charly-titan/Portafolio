var picker,radio=!0,paises_validos={};validate={validate_input_text:function(e){var a=e.val();return a.length>0},validate_input_calendar:function(e){var a=e.val(),t="";return t=$("html").hasClass("no-mobile")?/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[0-9]{4}/:/^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/,t.test(a)},validate_input_tel:function(e){var a=e.val(),t=/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{1})/;return t.test(a)},data_requiere:function(e){return"undefined"==typeof e||e?!0:!1},init:function(element){var retorno=!0,el,isValid,isNull;return $(element+" input, "+element+" select").each(function(){var requiere=eval($(this).data("requiere")),format=$(this).data("format");if("undefined"!=typeof format)switch(format){case"text":el=$(this).parent().find(".span"),isValid=$(this).data("invalid"),isNull=$(this).data("null"),el.css({display:"",opacity:""}).html("").removeClass("error"),validate.data_requiere(requiere)&&(validate.validate_input_text($(this))||(el.html(isNull).addClass("error").animate({opacity:"1"},200),retorno=!1));break;case"date":el=$(this).parent().find(".span"),isValid=$(this).data("invalid"),isNull=$(this).data("null"),el.css({display:"",opacity:""}).html("").removeClass("error"),validate.data_requiere(requiere)&&(""===$(this).val()?(el.html(isNull).addClass("error").animate({opacity:1},200),retorno=!1):validate.validate_input_calendar($(this))||(el.html(isValid).addClass("error").animate({opacity:1},200),retorno=!1));break;case"tel":el=$(this).parent().find(".span"),isValid=$(this).data("invalid"),isNull=$(this).data("null"),el.css({display:"",opacity:""}).html("").removeClass("error"),validate.data_requiere(requiere)&&(""===$(this).val()?(el.html(isNull).addClass("error").animate({opacity:1},200),retorno=!1):validate.validate_input_tel($(this))||(el.html(isValid).addClass("error").animate({opacity:1},200),retorno=!1));break;case"masculino":case"femenino":if(radio){var rcont=0;el=$(this).parent().parent().find(".span"),isNull=$(this).data("null"),el.css({display:"",opacity:""}).html("").removeClass("error"),validate.data_requiere(requiere)&&($('input[name="genero"]').each(function(){$(this).is(":checked")&&rcont++}),0==rcont&&el.html(isNull).addClass("error").animate({opacity:1},200),radio=!1)}break;case"pais":el=$(this).parent().parent().find(".span"),isNull=$(this).data("null"),el.css({display:"",opacity:""}).html("").removeClass("error"),validate.data_requiere(requiere)&&""===$(this).val()&&(el.html(isNull).addClass("error").animate({opacity:1},200),retorno=!1);break;case"estado":el=$(this).parent().parent().find(".span"),isNull=$(this).data("null"),el.css({display:"",opacity:""}).html("").removeClass("error"),validate.data_requiere(requiere)&&(""===$(this).val()||null===$(this).val())&&(el.html(isNull).addClass("error").animate({opacity:1},200),retorno=!1);break;case"bases":el=$(this).parent().find(".span1"),isNull=$(this).data("null"),el.css({display:"",opacity:""}).html("").removeClass("error"),validate.data_requiere(requiere)&&($(this).is(":checked")||(el.html(isNull).addClass("error").animate({opacity:1},200),retorno=!1));break;case"privacidad":el=$(this).parent().find(".span2"),isNull=$(this).data("null"),el.css({display:"",opacity:""}).html("").removeClass("error"),validate.data_requiere(requiere)&&($(this).is(":checked")||(el.html(isNull).addClass("error").animate({opacity:1},200),retorno=!1))}}),retorno}},eventos={show_Dropdown:function(e){var a;a=document.createEvent("MouseEvents"),a.initMouseEvent("mousedown",!0,!0,window),e.dispatchEvent(a)},click_btn_date_mobile:function(e){e.preventDefault(),$("#date").trigger("click").trigger("focus")},click_btn_estados_mobile:function(e){e.preventDefault();var a=document.getElementById("estados");this.show_Dropdown(a)},click_btn_pais_mobile:function(e){e.preventDefault();var a=document.getElementById("pais");this.show_Dropdown(a)},click_btn_date:function(e){e.preventDefault(),$(".pika-single").hasClass("is-hidden")?picker.show():picker.hide()},onsubmite_form:function(e){radio=!0,validate.init("#contact-form-confirm")||e.preventDefault()},kd_input_date:function(e){return e.preventDefault(),!1},pais_change:function(argument){var paises=eval($(this).data("paises"));"undefined"!=typeof paises&&(-1===paises.indexOf($("option:selected",$(this)).data("text"))?$("#estados").data("requiere","false").prop("disabled","disabled").dropkick("disable"):$("#estados").data("requiere","true").prop("disabled",!1).dropkick("enable"))}},$(document).ready(function(){$("html").hasClass("mobile")?($("#date").attr("type","date"),$("#btn-date").on("click",eventos.click_btn_date_mobile),$("#btn-estado").on("click",eventos.click_btn_estados_mobile),$("#btn-pais").on("click",eventos.click_btn_pais_mobile)):($("#date").addClass("firstClick"),picker=new Pikaday({field:document.getElementById("date"),firstDay:1,format:"DD/MM/YYYY",defaultDate:new Date("1997-12-31"),setDefaultDate:!0,minDate:new Date("1930-01-01"),maxDate:new Date("1997-12-31"),yearRange:[1930,1997]}),$("#btn-date").on("click",eventos.click_btn_date)),$("#tel").mask("(999) 9999999"),$("#date").on("keydown",eventos.kd_input_date),$("#pais").dropkick({change:eventos.pais_change}),$("#estados").dropkick(),$("#contact-form-confirm").on("submit",eventos.onsubmite_form)});
