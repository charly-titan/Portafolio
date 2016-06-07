/* *********************** valida sitio y orientacion *********************** */
$(document).ready(function() {
    mySite();
    validateOrientation();
});
/* ************ Se obtiene el nombre del site a partir de la url ************ */
var mySite = function() {
    url = $(location).attr('href');
    site = url.split('/').pop();
    host = $(location).attr('hostname');
    promociones = 'promociones.sinpk2.com';
    if (host == 'research.televisa.com.mx' || host == 'gigya.televisa.com') {
        promociones = 'promociones.televisa.com.mx';
    } else {
        promociones = 'promociones.sinpk2.com';
    };
    return;
};
/* ******* Valida la orientacion de la pantalla para mostrar/ocultar. ******* */
var validateOrientation = function() {
    if (screen.orientation.type == 'landscape-primary' || screen.orientation.type == 'landscape-secondary') {
        $('#contenedor_carousel').hide();
        $('#contenedor_flipbook').show();
        $('#orientacion').hide();
    };
    if (screen.orientation.type == 'portrait-primary' || screen.orientation.type == 'portrait-secondary') {
        $('#contenedor_carousel').hide();
        $('#contenedor_flipbook').hide();
        $('#orientacion').html('<img src="//' + promociones + '/img/rotate_t.png" alt=rotate>');
    };
};
/* ******* Detecta cambio en el tamaño de la pantalla y redimenciona. ******* */
var resizeId;
$(window).resize(function() {
    clearTimeout(resizeId);
    resizeId = setTimeout(doneResizing, 500);
});
function doneResizing() {
    if ((screen.orientation.type == 'portrait-primary') || (screen.orientation.type == 'portrait-secondary')) {
        $('#contenedor_carousel').hide();
        $('#contenedor_flipbook').hide();
        $('#orientacion').show();
        $('#orientacion').html('<img src="//' + promociones + '/img/rotate_t.png" alt=rotate>');
    } else {
        $('#contenedor_carousel').hide();
        $('#contenedor_flipbook').show();
        $('#orientacion').hide();
    };
    myheight=$('#contenedor_flipbook').height();
    mywidth=$('#contenedor_flipbook').width();
    $('#flipbook').turn('size', mywidth, myheight);
};
/* ********************* Trae la informacion del album. ********************* */
var downloadAlbum = function() {
    $.ajax({
        url: 'http://' + promociones + '/stickers/album',
        dataType: 'jsonp',
        data: {
            site: site
        },
        jsonpCallback: 'getAlbum',
        error: function(xhr, status, error) {
            console.log(status);
        }
    });
};
/* ************** Se crea el Album con la informacion obtenida ************** */
var getAlbum = function(allAlbum) {
    if (site == 'demo-album') {
        drop = 'demoEvdrop';
    } else {
        drop = 'evdrop';
    };
    if (allAlbum.status == 404) {
        alert('el site no contiene ningun album');
        window.location.href = 'demo-album';
    } else {
        if (allAlbum.portada != '') {
            portada = '<img src="' + allAlbum.portada + '" class="img-responsive center" draggable=false>';
        } else {
            portada = '';
        };
        var html_a = '<div id=flipbook><div class=hard id=portada>' + portada + '</div><div class="hard interna"><div class=pageBody></div></div><div class=page><div class=pageBody><a href="//television.televisa.com/programas-tv/hoy/horoscopos/" target=_blank><img src="//' + promociones + '/img/albums/mizada.jpg" alt=publicidad class="img-responsive center" draggable=false></a></div></div>';
        if (((allAlbum.pages) % 2) != 0) {
            pages = allAlbum.pages;
            pages = Number(pages) + Number(1);
        } else {
            pages = allAlbum.pages;
        };
        for (i = 1; i <= pages; i++) {
            html_a += '<div id=myStyle_' + i + '><div id=myPage_'+i+' class=pageBody></div></div>';
        };
        html_a += '<div class=page><div class=pageBody><a href="http://deportes.televisa.com/tdn/" target=_blank><img src="http://www.sinaloadeportes.com.mx/wp-content/uploads/2011/08/TDN.jpg" alt=publicidad class="img-responsive center" draggable=false></a></div></div><div class="hard interna"><div class=pageBody><a href="//television.televisa.com/programas-tv/hoy/horoscopos/" target=_blank><img src="//' + promociones + '/img/albums/mizada.jpg" alt=publicidad class="img-responsive center" draggable=false></a></div></div><div class=hard id=contraportada ><img src="//' + promociones + '/img/albums/televisa.jpg" class="img-responsive center" draggable=false></div></div>';
        $('#contenedor_flipbook').html(html_a);
        $.each(allAlbum.data, function(j, data0) {
            var numberPage = (data0.page);
            if ((data0.stickers).length > 0) {
                typePage = (data0.stickers[0].split('_')[4]);
                placeID = (numberPage + '-' + typePage);
                if (typePage == '1' || typePage == '1') {
                    $('#myPage_' + numberPage).html('<div class=s1 id=' + placeID + '-l1></div>');
                };
                if (typePage == '2') {
                    $('#myPage_' + numberPage).html('<div class=sBase id=' + placeID + '-l1></div><div class=sHide id=' + placeID + '-l2></div><div class=sHide id=' + placeID + '-l3></div><div class=sBase id=' + placeID + '-l4></div>');
                };
                if (typePage == '3' || typePage == '3') {
                    $('#myPage_' + numberPage).html('<div class=sCenter id=' + placeID + '-l1></div><div class=sBase id=' + placeID + '-l2></div><div class=sBase id=' + placeID + '-l3></div>');
                };
                if (typePage == '4' || typePage == '4') {
                    $('#myPage_' + numberPage).html('<div class=sBase id=' + placeID + '-l1></div><div class=sBase id=' + placeID + '-l2></div><div class=sCenter id=' + placeID + '-l3></div>');
                };
                if (typePage == '5' || typePage == '5') {
                    $('#myPage_' + numberPage).html('<div class=sBase id=' + placeID + '-l1></div><div class=sBase id=' + placeID + '-l2></div><div class=sBase id=' + placeID + '-l3></div><div class=sBase id=' + placeID + '-l4></div>');
                };
                if (typePage == '6' || typePage == '6') {
                    $('#myPage_' + numberPage).html('<div class=sHeight id=' + placeID + '-l1></div><div class=sHeight id=' + placeID + '-l2></div><div class=sHeight id=' + placeID + '-l3></div><div class=sHeight id=' + placeID + '-l4></div><div class=sHeight id=' + placeID + '-l5></div><div class=sHeight id=' + placeID + '-l6></div>');
                };
                if (typePage == 'R2') {
                    $('#myPage_' + numberPage).html('<div class=sHide id=' + placeID + '-l1></div><div class=sBase id=' + placeID + '-l2></div><div class=sBase id=' + placeID + '-l3></div><div class=sHide id=' + placeID + '-l4></div>');
                };
            };
        });
        if (allAlbum.data.length > 0) {
            $.each(allAlbum.data, function(primaryKey, page) {
                if (page.stickers.length > 0) {
                    $.each(page.stickers, function(key, stickers) {
                        var numberPage = page.page;
                        var placeId = (stickers.split('_')[1]);
                        var cardName = (stickers.split('_')[2]);
                        var placeClass = (stickers.split('_')[3]);
                        var placeType = (stickers.split('_')[4]);
                        var imgOrig = (stickers.split('_')[5]);
                        var place = $('#' + numberPage + '-' + placeType + '-' + placeId);
                        place.html('<div class=thumbnailContainer  draggable=false id=thumbnailContainer' + cardName + ' data-dato=' + imgOrig + '><div class="thumbnailFondo transparente" id=lugar' + cardName + ' data-id=' + cardName + ' style="background-image:url(' + imgOrig + ')" ondrop="' + drop + '(event, this)" ondragover="evdragover(event)" ondragenter="dragenter(event, id)" ondragleave="dragleave(event)" draggable=false ></div></div>');
                    });
                };
                if (page.background.length > 0) {
                    $.each(page.background, function(key, background) {
                        var numberPage = background.split('_')[0].replace(/\D/g, '');
                        var style = background.split('_')[1];
                        var bckgr = background.split('_')[2];
                        $('#myStyle_' + numberPage).addClass(style);
                        if (style == 'color') {
                            $('#myStyle_' + numberPage).attr('style', 'background:' + bckgr);
                        }
                        if (style == 'simple' || style == 'doble') {
                            $('#myStyle_' + numberPage).attr('style', 'background:url(' + bckgr + ')');
                        }
                    });
                };
            });
        };
        $('#portada').css('background', allAlbum.color);
        $('#contraportada').css('background', allAlbum.color);
        if (_UID == 'demo') {
            flipbook();
        };
        if (_UID == '') {
            flipbook();
        } else {
            downloadUserStickers();
        };
    };
};
/* ********************* Se inicializa el efecto hojear ********************* */
function flipbook() {
    myheight=$('#contenedor_flipbook').height();
    mywidth=$('#contenedor_flipbook').width();
    $('#flipbook').turn();
    $('#flipbook').bind('turn.turning', function(event, page, pageObject) {
        $(document).find('.doble').removeClass('page');
    });
    $('#flipbook').turn('size', mywidth, myheight);
};
/* ******************* Trae la informacion de los sticker ******************* */
var downloadUserStickers = function() {
    window.carrPegadas = '';
    $.ajax({
        url: '//' + promociones + '/stickers/user-stickers',
        dataType: 'jsonp',
        data: {
            site: site,
            _UID: _UID
        },
        jsonpCallback: 'userStickers',
        error: function(xhr, status, error) {
            console.log(status);
        },
    });
};
/* *********************** Coloca los stikers pegados *********************** */
var userStickers = function(userStickers) {
    if (userStickers.status != 4004) {
        if (userStickers.sueltas.length > 0) {
            html_c = '<div class=jcarousel-wrapper ><div class=jcarousel><ul>';
            $.each(userStickers.sueltas, function(i, suelta) {
                html_c += '<li class=thumbnailContainer id=container' + suelta.id + '><img src=' + suelta.src + ' class=thumbnailImg draggable=true id=card' + suelta.id + ' data-id=' + suelta.id + ' ondragstart="dragStart(event, id)" ondragend="dragEnd(event)" alt=' + suelta.id + '></li>';
                var getWidthAndHeight = function() {
                    if (this.height > this.width) {
                        $('#container' + suelta.id).attr('class', 'thumbnailContainer sancho');
                    }
                    if (this.height == this.width) {
                        $('#container' + suelta.id).attr('class', 'thumbnailContainer sequal');
                    }
                }
                var myImage = new Image();
                myImage.onload = getWidthAndHeight;
                myImage.src = suelta.src;
            });
            html_c += '</ul></div><a href="#" class=jcarousel-control-prev>&lsaquo;</a><a href="#" class="jcarousel-control-next">&rsaquo;</a></div>';
            $('#contenedor_carrusel').html(html_c);
            $.each(userStickers.sueltas, function(i, suelta) {
                if (suelta.nueva == 1) {
                    $('#container' + suelta.id).append('<img class=numero id=nuevo' + suelta.id + ' src=//' + promociones + '/img/albums/televisa_ico.png>');
                };
                if (suelta.cantidad >= 0) {
                    $('#container' + suelta.id).append('<p class=numero2 id=numero2' + suelta.id + '>' + suelta.cantidad + '</p>');
                };
            });
            carousel();
        } else {
            $('#contenedor_carrusel').html('<H2>Sin stickers</H2>');
        }
        if (userStickers.pegadas.length > 0) {
            html_d = '';
            $.each(userStickers.pegadas, function(key, pegada) {
                var buscar = $(document).find('#thumbnailContainer' + pegada);
                var src = (buscar.attr('data-dato'));
                $('#lugar' + pegada).remove();
                buscar.append('<img src=' + src + ' class=thumbnailImg id=colocada' + pegada + ' draggable=false>');
            });
        };
        flipbook();
    } else {
        $('#registerModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
};
/* ******************** Se inicializa el efecto carousel ******************** */
function carousel() {
    var jcarousel = $('.jcarousel').jcarousel();
    $('.jcarousel-control-prev').on('jcarouselcontrol:active', function() {
        $(this).removeClass('inactive');
    }).on('jcarouselcontrol:inactive', function() {
        $(this).addClass('inactive');
    }).jcarouselControl({
        target: '-=1'
    });
    $('.jcarousel-control-next').on('jcarouselcontrol:active', function() {
        $(this).removeClass('inactive');
    }).on('jcarouselcontrol:inactive', function() {
        $(this).addClass('inactive');
    }).jcarouselControl({
        target: '+=1'
    });
};
/* ************** Obtiene info al iniciar arrastre de sticker. ************** */
function dragStart(event, cardId) {
    var id = $('#' + cardId).attr('data-id');
    event.dataTransfer.setData('text', id);
    event.target.style.opacity = '0.5';
    window.card = id;
    event.dataTransfer.effectAllowed = 'all';
};
/* **************** Obtiene info al entrar en algun destino. **************** */
function dragenter(event, id) {
    event.target.style.opacity = '0.5';
};
/* ********** Remueve estilos aplicados al entrar en algun destino ********** */
function dragleave(event) {
    event.target.style.opacity = '';
    var lugar = (event.target.id);
    $('#' + lugar).css({
        '-webkit-filter': '',
        'filter': ''
    });
};
/* ****** Remueve estilos aplicados al iniciar el arrastre de sticker. ****** */
function dragEnd(event) {
    event.dataTransfer.clearData('text');
    event.target.style.opacity = '';
};
/* ******** Aplica estilos si el IDsticker y el IDdestino coinciden. ******** */
function evdragover(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = 'move';
    var lugar = (event.target.id);
    var cardID = card;
    var placeID = $('#' + lugar).attr('data-id');
    if (placeID == cardID) {
        event.target.style.opacity = '0.9';
        $('#' + lugar).css({
            '-webkit-filter': 'grayscale(0)',
            'filter': '0'
        });
        event.dataTransfer.dropEffect = 'copy';
    };
};
/* ******** Fija el stiker si el IDsticker y el IDdestino coinciden. ******** */
function demoEvdrop(event, element) {
    var lugar = (element.id);
    var card = event.dataTransfer.getData('text');
    var cardID = card;
    var placeID = $('#' + lugar).attr('data-id');
    if ((placeID == cardID)) {
        cardzo = document.getElementById(card);
        myElement = element.appendChild(cardzo);
        myElement.setAttribute('draggable', 'false');
        element.removeAttribute('class')
        element.removeAttribute('ondrop');
        element.removeAttribute('ondragover');
        element.removeAttribute('ondragenter');
        element.removeAttribute('ondragleave');
        element.appendChild(myElement);
        element.removeAttribute('style');
        $('#number' + cardID).remove();
        actionPaste({
            'cardID': cardID
        });
        $('.jcarousel').jcarousel('reload');
    };
    event.target.style.opacity = '';
    event.preventDefault();
};
/* ******** Fija el stiker si el IDsticker y el IDdestino coinciden. ******** */
function evdrop(event, element) {
    event.stopPropagation();
    event.preventDefault();
    var lugar = (element.id);
    var card = event.dataTransfer.getData('text');
    var cardID = card;
    var placeID = $('#' + lugar).attr('data-id');
    if ((placeID == cardID)) {
        $('#' + lugar).css({
            '-webkit-filter': '',
            'filter': ''
        });
        var data = {
            'card': cardID,
            '_UID': _UID,
            'site': site
        };
        $.ajax({
            url: 'https://' + promociones + '/stickers/paste',
            dataType: 'jsonp',
            jsonpCallback: 'actionPaste',
            data: data,
            error: function(xhr, status, error) {
                console.log(status);
                alert('ha ocurrido un error');
            },
        });
    };
    event.target.style.opacity = '';
};
/* **** Se realizan cambios en el carouse cuando un sticker es colocado ***** */
function actionPaste(data) {
    if (data.status != 404) {
        cardID = data.cardID;
placeCard= $('#lugar'+cardID)[0]; //element
myCard = $('#card' + cardID)[0]; //card
myPlaceCard = placeCard.appendChild(myCard);
myPlaceCard.setAttribute('draggable', 'false');
placeCard.removeAttribute('class')
placeCard.removeAttribute('ondrop');
placeCard.removeAttribute('ondragover');
placeCard.removeAttribute('ondragenter');
placeCard.removeAttribute('ondragleave');
placeCard.appendChild(myPlaceCard);
placeCard.removeAttribute('style');
quantity = $('#numero2' + cardID).text();
quantity2 = quantity - 1;
src = (this.myPlaceCard.src);
if (quantity2 == 0) {
    $('#container' + cardID).remove();
} else {
    $('#numero2' + cardID).text(quantity2);
    $('#nuevo' + cardID).remove();
    $('#container' + cardID).append('<img class=thumbnailImg id=carda' + cardID + ' draggable=true ondragend="dragEnd(event)" src=' + src + '>');
};
} else {
};
};
$(document).on('click', '#rechazar', function(event) {
    window.location.href = 'http://www.televisa.com/';
});
$(document).on('click', '#rechazar2', function(event) {
    window.location.href = 'http://www.televisa.com/';
});
$(document).on('click', '#comenzar', function(event) {
    $('#registerModal').modal('hide');
    csrf = $('input[name=_token]').val();
    var data = {
        '_UID': _UID,
        'site': site,
        '_token': csrf
    };
    $.ajax({
        url: '//' + promociones + '/stickers/registrar',
        dataType: 'jsonp',
        data: data,
        jsonpCallback: 'getRegistro',
        error: function(xhr, status, error) {
            console.log(status);
        },
    });
});
/* ****** Se crea carousel una vez completado el registro de usuario. ******* */
var getRegistro = function() {
    downloadUserStickers();
};
/* ************ Se obtiene la informacion de todos los sticker. ************* */
var downloadFlipCard = function() {
    $.ajax({
        url: '//' + promociones + '/stickers/flip-card',
        dataType: 'jsonp',
        data: {
            site: site
        },
        jsonpCallback: 'getFlipCard',
        error: function(xhr, status, error) {
            console.log(status);
        },
    });
};
/* ******** Se crea mosaico de Stickers y se les da un efecto flip. ********* */
var getFlipCard = function(data) {
    if (data.status == 404) {
        html_c = '<H1>Sin información del álbum</H1';
        $('#girdCard').html(html_c);
    } else {
        html_b = '';
        $.each(data.allStickers, function(i, x) {
            $.each(x, function(j, card) {
                var src = card[0];
                var title = card[2];
                var description = card[1];
                if (title == undefined || title == 'null') {
                    var title = '';
                };
                if (description == undefined || description == 'null') {
                    var description = '';
                };
                html_b += '<div class="col-xs-4 col-md-2"><div class=flip-container><div class=thumbnail-container><div class=flipper><div class="thumbnail-body front"><img class="img-responsive thumbnail-img" src=' + src + '/></div><div class="thumbnail-body back"><div class=textBack>' + description + '</div></div></div><div class=thumbnail-footer><h6 class=text-center>' + title + '</h6></div></div></div></div>';
            });
        });
        $('#girdCard').html(html_b);
    };
};
/******************************************************************************/
