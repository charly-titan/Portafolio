/******************************************************************/
/* Detecta click en los recuadros rojos, de ser asi, abre ventana */
/* modal con los stickers subIDos en el 'paso 3'. */
/******************************************************************/
$(document).on('click', '.clk', function(event) {
    bothPlace = ($(this).parents()[1].id.split('_')[1]);
    placeName = this.id;
    $('#imagesModal').modal({
        backdrop: 'static',
        keyboard: false
    });
});
/******************************************************************/
/* Detecta click en las imagenes dentro del modal y la fija en la */
/* vista previa de la pagina del album. */
/******************************************************************/
$(document).on('click', '.centerCropped', function(event) {
    cardName = this.id.split('_')[1];
    $('#imagesModal').modal('hide');
    $('#' + placeName).html('<div class=thumbnailContainer id=c_' + this.id + '></div>').css('border', 'transparent').removeClass('clk');
    $('#c_' + this.id).append(this);
    $(this).removeClass('centerCropped').addClass('thumbnailImg');
    var countOddImages = $('#odd_' + bothPlace).find('img').length;
    var countEvenImages = $('#even_' + bothPlace).find('img').length;
    var countOddEvenImages = countOddImages + countEvenImages;
    if (countOddImages >= 1) {
        $('#SelTypePage_odd_' + bothPlace).attr('disabled', true);
    } else {
        $('#SelTypePage_odd_' + bothPlace).attr('disabled', false);
    };
    if (countEvenImages >= 1) {
        $('#SelTypePage_even_' + bothPlace).attr('disabled', true);
    } else {
        $('#SelTypePage_even_' + bothPlace).attr('disabled', false);
    };
    if (countOddEvenImages >= 1) {
        $('#clon_' + bothPlace).attr('disabled', false);
        $('#remove_' + bothPlace).attr('disabled', true);
        $('li[data-step=1]').removeAttr('class')
        $('li[data-step=2]').removeAttr('class');
    } else {
        $('#clon_' + bothPlace).attr('disabled', true);
        $('#remove_' + bothPlace).attr('disabled', false);
    };
    var countImagesModal = $('#imagesModal').find('img').length;
    if (countImagesModal == 0) {
        $('#clon_' + bothPlace).attr('disabled', true);
    } else {
        $('#clon_' + bothPlace).attr('disabled', false);
    };
});
/******************************************************************/
/* Se quita el div que contenia la imagen dentro del modal. */
/******************************************************************/
$('#imagesModal').on('hidden.bs.modal', function(event) {
    if (cardName != 0) {
        $('#div_sb_' + cardName).remove();
    };
});
/******************************************************************/
/* Detecta click en la imagen fijada en la(s) vista previa de la */
/* pagina del album. */
/******************************************************************/
$(document).on('dblclick', '.thumbnailImg', function(event) {
    $(this).removeClass('thumbnailImg').addClass('centerCropped');
    var imgParents = $(this).parents();
    var bothPlace = imgParents[3].id.split('_')[1];
    var cardName = (this.id).split('_')[1];
    imgParents[0].remove();
    $('#gallery').append('<div class=superbox-list id=div_sb_' + cardName + '>');
    $('#div_sb_' + cardName).append(this);
    $(imgParents[1]).removeAttr('style').addClass('clk');
    var countOddImages = $('#odd_' + bothPlace).find('img').length;
    var countEvenImages = $('#even_' + bothPlace).find('img').length;
    var countOddEvenImages = countOddImages + countEvenImages;
    if (countOddImages >= 1) {
        $('#SelTypePage_odd_' + bothPlace).attr('disabled', true);
    } else {
        $('#SelTypePage_odd_' + bothPlace).attr('disabled', false);
    };
    if (countEvenImages >= 1) {
        $('#SelTypePage_even_' + bothPlace).attr('disabled', true);
    } else {
        $('#SelTypePage_even_' + bothPlace).attr('disabled', false);
    };
    if (countOddEvenImages >= 1) {
        $('#clon_' + bothPlace).attr('disabled', false);
        $('#remove_' + bothPlace).attr('disabled', true);
        $('li[data-step=1]').removeClass()
        $('li[data-step=2]').removeClass();
    } else {
        $('#clon_' + bothPlace).attr('disabled', true);
        $('#remove_' + bothPlace).attr('disabled', false);
    };
});
/******************************************************************/
/* Detecta click en el boton de clonar, al realizar la accion crea*/
/* un nuevo paso y muestra el siguente par de hojas. */
/******************************************************************/
$(document).on('click', '.clon', function(event) {
    var currentStep = $('#orderWizard').wizard('selectedItem').step;
    var indexStep = Number(currentStep) + 1;
    $('#orderWizard').wizard('addSteps', indexStep, [{
        label: 'Paso' + indexStep,
        pane: '<h3 id=after_' + currentStep + '><strong>Paso ' + indexStep + '</strong> - Selecciona el tipo de hojas</h3>'
    }]);
    var goToIndex = Number(($(document).find('.step-pane').length));
    $('#orderWizard').wizard('selectedItem', {
        step: goToIndex
    });
    var currentPage = ($(this).attr('id').split('_')[1]);
    var nextPage = (Number(currentPage) + 1);
    var oldOdd = $('#original_' + currentPage).find('.number_1').text().split('_')[1];
    var oldEven = $('#original_' + currentPage).find('.number_2').text().split('_')[1];
    var oddPage = (Number(oldOdd) + 2);
    var evenPage = (Number(oldEven) + 2);
    newElem = $('#original_' + currentPage).clone().attr('id', 'original_' + nextPage);
    newElem.find('.toclone').removeAttr('style').attr('id', 'original_' + nextPage);
    newElem.find('.number_1').html('p_' + oddPage);
    newElem.find('.number_2').html('p_' + evenPage);
    newElem.find('.clon').attr('id', 'clon_' + nextPage);
    newElem.find('.odd_1').removeAttr('style').attr({
        'data-dato': 'null',
        'data-type': 'null',
        'id': 'odd_' + nextPage
    });
    newElem.find('.even_1').removeAttr('style').attr({
        'data-dato': 'null',
        'data-type': 'null',
        'id': 'even_' + nextPage
    });
    newElem.find('#remove_' + currentPage).remove();
    newElem.find('#clon_' + nextPage).after('<a href=javascript:void(0); class="btn btn-danger btn-circle pull-right remove" id=remove_' + nextPage + '>' + '<i class="glyphicon glyphicon-minus"></i></a>');
    newElem.find('.SelTypePage_1').attr({
        'id': 'SelTypePage_odd_' + nextPage,
        'disabled': false
    });
    newElem.find('.SelTypePage_2').attr({
        'id': 'SelTypePage_even_' + nextPage,
        'disabled': false
    });
    newElem.find('.pageBody_1').attr('id', 'pageBody_odd_' + nextPage).empty();
    newElem.find('.pageBody_2').attr('id', 'pageBody_even_' + nextPage).empty();
    newElem.find('.SelTypeBack_1').attr({
        'id': 'SelTypeBack_odd_' + nextPage,
        'disabled': false
    });
    newElem.find('.SelTypeBack_2').attr({
        'id': 'SelTypeBack_even_' + nextPage,
        'disabled': false
    });
    newElem.find('#myOption_odd_' + currentPage).attr('id', 'myOption_odd_' + nextPage).empty();
    newElem.find('#myOption_even_' + currentPage).attr('id', 'myOption_even_' + nextPage).empty();
    $('li.complete').removeClass();
    $(document).find('.toclone').removeAttr('style');
    $('#after_' + currentStep).after(newElem);
});
/******************************************************************/
/* Detecta click en el boton de remover, quita la pestaña del paso*/
/* completamente. */
/******************************************************************/
$(document).on('click', '.remove', function(event) {
    if (confirm('Estas seguro???.')) {
        var currentPage = ($(this).parents()[2].id.split('_')[1]);
        var previousPage = currentPage - 1;
        var currentStep = $('#orderWizard').wizard('selectedItem').step;
        var indexStep = currentStep - 1;
        $('#orderWizard').wizard('selectedItem', {
            step: indexStep
        });
        $('#orderWizard').wizard('removeSteps', currentStep, 1);
        $('#remove_' + previousPage).attr('disabled', false);
        $('li.complete').removeClass();
        var countOddImages = $('#odd_' + previousPage).find('img').length;
        var countEvenImages = $('#even_' + previousPage).find('img').length;
        var countOddEvenImages = countOddImages + countEvenImages;
        if (countOddImages >= 1) {
            $('#SelTypePage_odd_' + previousPage).attr('disabled', true);
        } else {
            $('#SelTypePage_odd_' + previousPage).attr('disabled', false);
        };
        if (countEvenImages >= 1) {
            $('#SelTypePage_even_' + previousPage).attr('disabled', true);
        } else {
            $('#SelTypePage_even_' + previousPage).attr('disabled', false);
        };
        if (countOddEvenImages >= 1) {
            $('#clon_' + previousPage).attr('disabled', false);
            $('#remove_' + previousPage).attr('disabled', true);
            $('li[data-step=1]').removeAttr('class');
            $('li[data-step=2]').removeAttr('class');
        } else {
            $('#clon_' + previousPage).attr('disabled', true);
            $('#remove_' + previousPage).attr('disabled', false);
        };
    };
});
/******************************************************************/
/* Detecta el cambio en cualquier select y asigna los recuadros a */
/* la pagina segun la seleccion. */
/******************************************************************/
$(document).on('change', 'select', function() {
    var mySelect = ($(this).val());
    var placeType = mySelect.split('_')[2];
    var bothPlace = (this.id).split('_')[2];
    var placeSide = (this.id).split('_')[1];
    if (placeSide == 'odd') {
        var mySearch = $('#original_' + bothPlace).find('.number_1');
        var placePage = $.trim(mySearch.text().split('_')[1]);
    } else {
        var mySearch = $('#original_' + bothPlace).find('.number_2');
        var placePage = $.trim(mySearch.text().split('_')[1]);
    };
    var pageVal = placePage + '-' + placeType;
    var _pageBody = $('#pageBody_' + placeSide + '_' + bothPlace);
    if (mySelect == 'STP_odd_1' || mySelect == 'STP_even_1') {
        _pageBody.html('<div id=' + pageVal + '-l1 class="clk s1"></div>');
    };
    if (mySelect == 'STP_odd_2') {
        _pageBody.html('<div id=' + pageVal + '-l1 class="clk sBase"></div><div id=' + pageVal + '-l2 class=sHide></div><div id=' + pageVal + '-l3 class=sHide></div><div id=' + pageVal + '-l4 class="clk sBase"></div>');
    };
    if (mySelect == 'STP_even_2') {
        _pageBody.html('<div id=' + pageVal + '-l1 class=sHide ></div><div id=' + pageVal + '-l2 class="clk sBase"></div><div id=' + pageVal + '-l3 class="clk sBase"></div><div id=' + pageVal + '-l4 class=sHide></div>');
    };
    if (mySelect == 'STP_odd_3' || mySelect == 'STP_even_3') {
        _pageBody.html('<div id=' + pageVal + '-l1 class="clk sCenter"></div><div id=' + pageVal + '-l2 class="clk sBase"></div><div id=' + pageVal + '-l3 class="clk sBase"></div>');
    };
    if (mySelect == 'STP_odd_4' || mySelect == 'STP_even_4') {
        _pageBody.html('<div id=' + pageVal + '-l1 class="clk sBase"></div><div id=' + pageVal + '-l2 class="clk sBase"></div><div id=' + pageVal + '-l3 class="clk sCenter"></div>');
    };
    if (mySelect == 'STP_odd_5' || mySelect == 'STP_even_5') {
        _pageBody.html('<div id=' + pageVal + '-l1 class="clk sBase"></div><div id=' + pageVal + '-l2 class="clk sBase"></div><div id=' + pageVal + '-l3 class="clk sBase"></div><div id=' + pageVal + '-l4 class="clk sBase"></div>');
    };
    if (mySelect == 'STP_odd_6' || mySelect == 'STP_even_6') {
        _pageBody.html('<div id=' + pageVal + '-l1 class="clk sHeight"></div><div id=' + pageVal + '-l2 class="clk sHeight"></div><div id=' + pageVal + '-l3 class="clk sHeight"></div><div id=' + pageVal + '-l4 class="clk sHeight"></div><div id=' + pageVal + '-l5 class="clk sHeight"></div><div id=' + pageVal + '-l6 class="clk sHeight"></div>');
    };
});
/******************************************************************************/
/* Insertada una imagen en el dropzone de portadas, esta funcion  */
/* automaticamente previsualizara la imagen en portada.           */
/******************************************************************************/
var getFrontCover = function(frontCover) {
    var filePath = frontCover;
    var fileName = filePath.split('/').pop();
    var coverName = fileName.split('.')[0];
    $('#choiceFrontCover').html('<div><img src=' + filePath + ' alt=' + coverName + ' data-dato=' + filePath + '></div>');
};
/******************************************************************************/
/* Funcion la cual nos permitira cambiar el color de fondo a la   */
/* portada.                                                       */
/******************************************************************************/
var choiceFrontCover = $('#choiceFrontCover');
var currentColor = $('#color').val();
$('#rgbpicker-1').colorpicker().on('changeColor', function(event) {
    var myColor = event.color.toHex();
    choiceFrontCover.css('background', myColor);
    $('#color').val(myColor);
});
/******************************************************************************/
/* Funcion que cuando detecta un cambio en el titulo              */
/* borra la carpeta con conteIDo en el servIDor y crea una nueva.*/
/******************************************************************************/
$('#title').change(function() {
    dropPort.removeAllFiles();
    dropPrev.removeAllFiles();
    $('.pageBody_1').empty();
    $('.pageBody_2').empty();
    $('select').prop('selectedIndex', 0);
    $('#gallery').empty();
    if ($('#title').val().length >= 3) {
        dropPort.enable();
        $('#dropzoneFrontCover').addClass('dropzone');
    } else {
        dropPort.disable();
        $('#dropzoneFrontCover').removeClass('dropzone');
    };
});
/******************************************************************************/
/* Funcion que recupera la informacion a partir del titulo.       */
/******************************************************************************/
var getDataAlbum = function(titleObj) {
    title = $.trim(titleObj.title);
    $.ajax({
        url: '/admin-stickers/recover-data',
        type: 'POST',
        data: {
            'title': title,
            'select': "*"
        },
        success: function(albumObj) {
            var albumStickersObj = $.parseJSON(albumObj.stickers);
            if (albumStickersObj != 0) {
                getModal(albumStickersObj);
            };
            if (albumObj.status != 404) {
                var albumDataObj = jQuery.parseJSON(albumObj.data);
                allPages = []
                $.each(albumDataObj, function(key, album) {
                    page = (album.page);
                    allPages.push(page);
                });
                allPages = $.unique(allPages);
                sortPages = allPages.sort((a,b)=>a-b);
                lastPage = allPages.pop();
                if ((lastPage % 2) != 0) {
                    lastPage = Number(lastPage) + 1;
                };
                allPages = Number(lastPage) / 2;
                goToIndex = Number(($(document).find('.step-pane').length));
                $('#orderWizard').wizard('selectedItem', {
                    step: goToIndex
                });
                for (var i = 1; i <= allPages; i++) {
                    $(document).find('#clon_' + i).click();
                };
            };
            $('#choiceFrontCover').css('background', albumObj.color);
            $('#color').val(albumObj.color);
            if (albumObj.portada != '') {
                var cardName = (albumObj.portada).split('/').pop().split('.')[0];
                $('#choiceFrontCover').html('<img src=' + albumObj.portada + ' class="img-responsive center" alt=' + cardName + '>');
                var filePath = albumObj.portada;
                var fileName = (filePath.split('/')[6]);
                var mockFile = {
                    name: fileName,
                };
                dropPort.emit('addedfile', mockFile);
                dropPort.emit('thumbnail', mockFile, filePath);
                dropPort.files.push(mockFile);
                $('#dropzoneFrontCover').find('.dz-size').remove();
                $('#dropzoneFrontCover').find('.dz-default').remove();
                $('#dropzoneFrontCover').find('.dz-filename').remove();
                dropPort.options.maxFiles = dropPort.options.maxFiles - dropPort.files.length;
            };
            var albumDataObj = jQuery.parseJSON(albumObj.data);
            $.each(albumDataObj, function(primaryKey, album) {
                $.each(album.stickers, function(key, sticker) {
                    var filePath = (sticker.split('_')[5]);
                    var fileName = (filePath.split('/')[6]);
                    cardName = (sticker.split('_')[2]);
                    var mockFile2 = {
                        name: fileName
                    };
                    dropPrev.emit('addedfile', mockFile2);
                    dropPrev.emit('thumbnail', mockFile2, filePath);
                    dropPrev.files.push(mockFile2);
                    $('#dropzoneStickers').find('.dz-remove').remove();
                    $('#dropzoneStickers').find('.dz-progress').remove();
                    $('#dropzoneStickers').find('.dz-success-mark').remove();
                    $('#dropzoneStickers').find('.dz-error-mark').remove();
                    $('#dropzoneStickers').find('.dz-error-message').remove();
                    $('#dropzoneStickers').find('.dz-filename').remove();
                    $('#dropzoneStickers').find('.dz-size').remove();
                    $('#dropzoneStickers').find('.dz-default').remove();
                    $('.dz-details').find('img').addClass('recoverThumbnailImg');
                    $('.dz-details').find('img').attr('alt', cardName);
                });
                if ((album.stickers).length > 0) {
                    $.each(album.stickers, function(key, sticker) {
                        var placePage = (sticker.split('_')[0]).replace(/\D/g, '');
                        var placeID = (sticker.split('_')[1]);
                        var cardName = (sticker.split('_')[2]);
                        var placeClass = (sticker.split('_')[3]);
                        var placeType = (sticker.split('_')[4]);
                        var filePath = (sticker.split('_')[5]);
                        var iseven = (Number(placePage)) % 2;
                        if (iseven == 0) {
                            bothPlace = (Number(placePage)) / 2;
                            placeSide = 'even';
                        } else {
                            bothPlace = (Number(placePage) + 1) / 2;
                            placeSide = 'odd';
                        };
                        var placeID = (placePage + '-' + placeType);
                        var ID = placeSide + '_' + bothPlace;
                        var _pageBody = $('#pageBody_' + ID);
                        if (placeType == '1' || placeType == '1') {
                            _pageBody.html('<div class=s1 id=' + placeID + '-l1 style="border: none"></div>');
                        };
                        if (placeType == '2' && placeSide == 'odd') {
                            _pageBody.html('<div class=sBase id=' + placeID + '-l1 style= "border: none"></div><div class=sHide id=' + placeID + '-l2 style= "border: none"></div><div class=sHide id=' + placeID + '-l3 style= "border: none"></div><div class=sBase id=' + placeID + '-l4 style= "border: none"></div>');
                        };
                        if (placeType == '3' || placeType == '3') {
                            _pageBody.html('<div class=sCenter id=' + placeID + '-l1 style= "border: none"></div><div class=sBase id=' + placeID + '-l2 style= "border: none"></div><div class=sBase id=' + placeID + '-l3 style= "border: none"></div>');
                        };
                        if (placeType == '4' || placeType == '4') {
                            _pageBody.html('<div class=sBase id=' + placeID + '-l1 style= "border: none"></div><div class=sBase id=' + placeID + '-l2 style= "border: none"></div><div class=sCenter id=' + placeID + '-l3 style= "border: none"></div>');
                        };
                        if (placeType == '5' || placeType == '5') {
                            _pageBody.html('<div class=sBase id=' + placeID + '-l1 style= "border: none"></div><div class=sBase id=' + placeID + '-l2 style= "border: none"></div><div class=sBase id=' + placeID + '-l3 style= "border: none"></div><div class=sBase id=' + placeID + '-l4 style= "border: none"></div>');
                        };
                        if (placeType == '6' || placeType == '6') {
                            _pageBody.html('<div class=sHeight id=' + placeID + '-l1 style= "border: none"></div><div class=sHeight id=' + placeID + '-l2 style= "border: none"></div><div class=sHeight id=' + placeID + '-l3 style= "border: none"></div><div class=sHeight id=' + placeID + '-l4 style= "border: none"></div><div class=sHeight id=' + placeID + '-l5 style= "border: none"></div><div class=sHeight id=' + placeID + '-l6 style= "border: none"></div>');
                        };
                        if (placeType == '2' && placeSide == 'even') {
                            _pageBody.html('<div class=sHide id=' + placeID + '-l1 style= "border: none"></div><div class=sBase id=' + placeID + '-l2 style= "border: none"></div><div class=sBase id=' + placeID + '-l3 style= "border: none"></div><div class=sHide id=' + placeID + '-l4 style= "border: none"></div>');
                        };
                    });
                    $.each(album.stickers, function(key, sticker) {
                        var placePage = (sticker.split('_')[0]).replace(/\D/g, '');
                        var placeID = (sticker.split('_')[1]);
                        var cardName = (sticker.split('_')[2]);
                        var placeClass = (sticker.split('_')[3]);
                        var placeType = (sticker.split('_')[4]);
                        var filePath = (sticker.split('_')[5]);
                        place = sticker.split('_')[1];
                        iseven = (Number(placePage)) % 2;
                        if (iseven == 0) {
                            bothPlace = (Number(placePage)) / 2;
                            placeSide = 'even';
                        } else {
                            bothPlace = (Number(placePage) + 1) / 2;
                            placeSide = 'odd';
                        };
                        $('#' + placePage + '-' + placeType + '-' + placeID).html('<div class=thumbnailContainer id=c_modal_' + cardName + '><img src=' + filePath + ' class=dontRemove alt=' + cardName + ' data-dato=' + filePath + ' data-position=' + placeSide + ' data-title=null data-description=null></div>');
                        $('#SelTypePage_' + placeSide + '_' + bothPlace).attr('disabled', true).prop('selectedIndex', placeType);
                        $('#remove_' + bothPlace).remove();
                        //$('#clon_' + bothPlace).remove();
                    });
                };
                $.each(album.background, function(primaryKey, background) {
                    var placePage = (background.split('_')[0]).replace(/\D/g, '');
                    var backgroundType = (background).split('_')[1];
                    var backgroundData = (background).split('_')[2];
                    var backgroundName = backgroundData.split('/')[6];
                    iseven = (Number(placePage)) % 2;
                    if (iseven == 0) {
                        bothPlace = (Number(placePage)) / 2;
                        placeSide = 'even';
                    } else {
                        bothPlace = (Number(placePage) + 1) / 2;
                        placeSide = 'odd';
                    };
                    var concSidePlace = placeSide + '_' + bothPlace
                    if (backgroundType == 'color') {
                        $('#' + concSidePlace).attr({
                            'style': 'background:' + backgroundData,
                            'data-position': placeSide,
                            'data-type': 'color',
                            'data-dato': backgroundData
                        }).addClass('simple');
                        $('#myOption_' + concSidePlace).html('<section><input id=color_' + concSidePlace + ' value=#00000 type=text class="form-control color_' + placeSide + '_1"></section>');
                        $('#color_' + concSidePlace).val(backgroundData).attr('disabled', true);
                        $('#SelTypeBack_' + concSidePlace).prop('selectedIndex', 1).attr('disabled', true);
                    };
                    if (backgroundType == 'simple' || backgroundType == 'doble') {
                        $('#' + concSidePlace).attr({
                            'style': 'background:url(' + backgroundData + ')',
                            'data-position': placeSide,
                            'data-type': backgroundType,
                            'data-dato': backgroundData
                        }).addClass(backgroundType);
                        if (backgroundType == 'simple') {
                            $('#myOption_' + concSidePlace).html('<section><label class="input input-file"><div class=button><input type=file name=f_S_' + placeSide + ' id=f_S_' + concSidePlace + ' class=file><i class="fa fa-lock" id="btnLoad_S_"' + concSidePlace + '></i></div><input type=text placeholder="add a simple image"   id=S_' + concSidePlace + '></label></section>');
                            $('#S_' + concSidePlace).attr({
                                'alt': backgroundData,
                                'disabled': true
                            }).val(backgroundName);
                            $('#f_S_' + concSidePlace).attr('disabled', true);
                            if (placeSide == 'odd') {
                                $('#SelTypeBack_' + concSidePlace).prop('selectedIndex', 3).attr('disabled', true);
                            }
                            if (placeSide == 'even') {
                                $('#SelTypeBack_' + concSidePlace).prop('selectedIndex', 2).attr('disabled', true);
                            }
                        };
                        if (backgroundType == 'doble') {
                            $('#SelTypeBack_' + concSidePlace).prop('selectedIndex', 4).attr('disabled', true);
                            $('#myOption_odd_' + bothPlace).html('<section><label class="input input-file"><div class=button><input type=file name=f_D_' + placeSide + ' id=f_D_' + concSidePlace + ' class=file><i class="fa fa-lock" id="btnLoad_D_"' + concSidePlace + '></i></div><input type=text  id=D_' + concSidePlace + ' placeholder="add a doble image"  ></label></section>');
                            $('#D_' + concSidePlace).attr({
                                'alt': backgroundData,
                                'disabled': true
                            }).val(backgroundName);
                            $('#f_D_' + concSidePlace).attr('disabled', true);
                            $('#SelTypeBack_even_' + bothPlace).prop('selectedIndex', 0);
                        };
                        //$('#clon_' + bothPlace).remove();
                    };
                });
});
getDataStickers({
    title: title
});
},
error: function(xhr, status, error) {
    console.log(status);
}
});
};
/******************************************************************************/
var getDataStickers = function(titleObj) {
    title = $.trim(titleObj.title);
    $.ajax({
        url: '/admin-stickers/recover-data',
        type: 'POST',
        data: {
            'title': title,
            'select': 'carrusel'
        },
        success: function(response) {
            $.each(response, function(primaryKey, stickers) {
                $.each(stickers, function(index, sticker) {
                    var filePath = (sticker[0]);
                    var description = (sticker[1]);
                    if (description) {
                        var description = description;
                    } else {
                        var description = "null";
                    };
                    title = (sticker[2]);
                    if (title) {
                        var title = title;
                    } else {
                        var title = "null";
                    };
                    obj = $(document).find("[alt='" + index + "']");
                    obj.attr({
                        'data-title': title,
                        'data-description': description
                    });
                })
            });
        },
        error: function(xhr, status, error) {
            console.log(status);
        }
    });
};
/******************************************************************************/
/* Funcion que se lanza cuando se inserta una imagen en el drop_ */
/* zone de stickers, mandando la informacion ala f. getModal(). */
/******************************************************************************/
var getRecoverStickers = function() {
    title = $.trim($('#title').val());
    site = title.toLowerCase().split(' ').join('-');
    $.ajax({
        url: '/admin-stickers/recover-data',
        type: 'POST',
        data: {
            'title': site,
            'select': 'stickers'
        },
        success: function(recoverStickers) {
            getModal(recoverStickers);
        },
        error: function(xhr, status, error) {
            console.log(status);
        }
    })
};
/******************************************************************************/
/* Funcion que muestra las imagenes del servIDor en previas */
/* dentro del modal. */
/******************************************************************************/
var getModal = function(stickers) {
    var html_c = '';
    $.each(stickers, function(key, sticker) {
        var filePath = sticker;
        var fileName = sticker.split('/').pop();
        var cardName = fileName.split('.')[0];
        html_c += '<div class=superbox-list id=div_sb_' + cardName + '><img src=' + filePath + ' class=centerCropped id=modal_' + cardName + ' alt=' + cardName + ' data-dato=' + sticker + ' data-position=x data-id=' + cardName + ' data-title=null data-description=null> </div>';
    });
    $('#gallery').html(html_c);
};
/******************************************************************/
/* Al cargar la pagina inicializa la valIDacion de campos y asi */
/* evitar falta de informacion necesaria en nuestro formulario. */
/******************************************************************/
$(document).ready(function() {
    cardName = 0;
    $('#orderForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        excluded: ':disabled',
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: 'El titulo es requerido'
                    },
                    stringLength: {
                        message: 'Debe contener al menos 3 caracteres',
                        min: 3
                    }
                }
            },
            'color': {
                validators: {
                    notEmpty: {
                        message: 'El color es requerido'
                    }
                }
            }
        }
    });
    /**************************************************************************/
    /* Inicializa el wizard el cual nos llevara durante la creacion */
    /* del nuevo album. */
    /**************************************************************************/
    $('#orderWizard').wizard().on('actionclicked.fu.wizard', function(e, data) {
        var fv = $('#orderForm').data('formValidation'),
        step = data.step,
        $container = $('#orderForm').find('.step-pane[data-step=' + step + ']');
        fv.validateContainer($container);
        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === false || isValidStep === null) {
            e.preventDefault();
        };
    }).on('finished.fu.wizard', function(e) {
        var fv = $('#orderForm').data('formValidation'),
        step = $('#orderWizard').wizard('selectedItem').step,
        $container = $('#orderForm').find('.step-pane[data-step=' + step + ']');
        fv.validateContainer($container);
        var isValidStep = fv.isValidContainer($container);
        if (isValidStep === true) {
            if ($('.btn-next').attr('id') != 'reorder') {
                $('#thankModal').modal();
            };
        };
    });
});
var saveAlbum = function(saveType) {
    allDiv = $('.bothpages').children();
    arrBackgrounds = [];
    $.each(allDiv, function(key, div) {
        var existOdd = $(div).find('.odd_1').attr('data-dato');
        if (existOdd) {
            if (existOdd != 'null') {
                var odID = $(div).find('.odd_1').attr('id').split('_')[1];
                var placePage = (Number(odID) * 2) - 1;
                var backgroundData = existOdd;
                var backgroundType = $(div).find('.odd_1').attr('data-type');
                var itemOdd = placePage + '_' + backgroundType + '_' + backgroundData;
                arrBackgrounds.push(itemOdd);
            };
        };
        var existEven = $(div).find('.even_1').attr('data-dato');
        if (existEven) {
            if (existEven != 'null') {
                var eveID = $(div).find('.even_1').attr('id').split('_')[1];
                var placePage = Number(eveID) * 2;
                var backgroundData = existEven;
                var backgroundType = $(div).find('.even_1').attr('data-type');
                var itemEven = placePage + '_' + backgroundType + '_' + backgroundData;
                arrBackgrounds.push(itemEven);
            };
        };
    });
    arrStickers = [];
    $.each(allDiv, function(primaryKey, div) {
        var allImages = $(div).find('img');
        if (allImages.length >= 1) {
            $.each(allImages, function(key, sticker) {
                iGeneral = $(sticker).parents()[1];
                placePage = ($(iGeneral).attr('id').split('-')[0]);
                placeClass = ($(iGeneral).attr('class'));
                placeID = ($(iGeneral).attr('id').split('-')[2]);
                placeType = ($(iGeneral).attr('id').split('-')[1]);
                filePath = $(sticker).attr('src');
                cardName = $(sticker).attr('alt');
                if ((placePage % 2) != 0) {
                    placeSide = 'odd';
                    itemSticker = placePage + '_' + placeID + '_' + cardName + '_' + placeClass + '_' + placeType + '_' + filePath;
                    arrStickers.push(itemSticker);
                } else {
                    placeSide = 'even';
                    itemSticker = placePage + '_' + placeID + '_' + cardName + '_' + placeClass + '_' + placeType + '_' + filePath;
                    arrStickers.push(itemSticker);
                };
                var url = $(sticker).attr('data-dato');
                name = url.split('/')[6].split('.')[0];
                var cardName = $(sticker).attr('alt');
            });
        };
    });
    arrDataStickers = [];
    $.each(allDiv, function(primaryKey, dataSticker) {
        var allDataStickers = $(dataSticker).find('img');
        if (allDataStickers.length >= 1) {
            $.each(allDataStickers, function(key, sticker) {
                var dataTitle = $(sticker).attr("data-title");
                var dataDescription = $(sticker).attr("data-description");
                var index = $(sticker).attr("alt");
                var filePath = $(sticker).attr("data-dato");
                itemDataSticker = index + '_' + filePath + '_' + dataTitle + '_' + dataDescription;
                arrDataStickers.push(itemDataSticker);
            });
        };
    });
    title = $.trim($('#title').val());
    site = title.toLowerCase().split(' ').join('-');
    colorFrontCover = $('#color').val();
    imgFrontCover = $('#choiceFrontCover').find('img');
    if (imgFrontCover.length > 0) {
        imgFrontCover = imgFrontCover[0].currentSrc;
    } else {
        imgFrontCover = '';
    };
    var params = {
        'title': title,
        'imgFrontCover': imgFrontCover,
        'colorFrontCover': colorFrontCover,
        'data': {
            stickers: arrStickers,
            backgrounds: arrBackgrounds,
            dataStickers: arrDataStickers
        }
    };
    $.ajax({
        url: '/admin-stickers/save-album',
        type: 'POST',
        data: params,
        beforeSend: function() {},
        success: function(data) {
            console.log(data);
            if (saveType == 'saveClose') {
                window.top.close();
            };
            if (saveType == 'savePreview') {
                window.location.replace(url);
            }
        },
        error: function(xhr, status, error) {
            console.log(status);
        },
    });
}
$(document).on('click', '#reRoute', function(event) {
    saveAlbum('savePreview');
    host = $(location).attr('hostname');
    research = 'research.sinpk2.com';
    if (host == 'research.televisa.com.mx') {
        research = 'research.televisa.com.mx';
    } else {
        research = 'research.sinpk2.com';
    };
    var url = 'http://' + research + '/admin-stickers/';
    var urlPreview = url + 'preview-album/' + site;
    window.open(urlPreview, '_blank');
});
Dropzone.autoDiscover = false;
/******************************************************************************/
/*    Inicializa el modulo dropzone perteneciente a la pestaña de portadas    */
/******************************************************************************/
$('#dropzoneFrontCover').dropzone({
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    dictCancelUpload: 'Cancelar',
    dictDefaultMessage: '',
    dictRemoveFile: 'Quitar',
    dictResponseError: 'Ha ocurrido un error en el server',
    maxFileSize: 1000,
    maxFiles: 1,
    method: 'post',
    url: '/admin-stickers/upload-single',
    init: function() {
        dropPort = this;
        dropPort.disable();
        $('#dropzoneFrontCover').removeClass('dropzone');
    },
    sending: function(file, xhr, formData) {
        title = $.trim($('#title').val());
        formData.append('title', title);
    },
    accept: function(file, done) {
        done();
    },
    success: function(file, response) {
        getFrontCover(response);
        $('#dropzoneFrontCover').find('.dz-preview').addClass('dz-success');
    },
    error: function(xhr, status, error) {
        console.log(status);
        $('#dropzoneFrontCover').find('.dz-preview').addClass('dz-error');
    },
    removedfile: function(file, response) {
        dropPort.options.maxFiles = 1;
        $(document).find(file.previewElement).remove();
        $('#choiceFrontCover').empty();
    },
    maxfilesexceeded: function(file, response) {
        console.log('has exedido el numero de archivos');
        $(document).find(file.previewElement).remove();
    }
});
/******************************************************************************/
/* Inicializa el modulo dropzone perteneciente a la pestaña de */
/* stickers. */
/******************************************************************************/
$('#dropzoneStickers').dropzone({
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    paramName: 'stickers',
    dictCancelUpload: 'Cancelar',
    dictDefaultMessage: '',
    dictRemoveFile: 'Quitar',
    dictResponseError: 'Ha ocurrido un error en el server',
    maxFileSize: 1000,
    maxFiles: 32,
    method: 'post',
    parallelUploads: 4,
    uploadMultiple: true,
    url: '/admin-stickers/upload-stickers',
    init: function() {
        dropPrev = this;
    },
    accept: function(file, done) {
        var myFiles = [];
        for (var i = 0; i < dropPrev.files.length; i++) {
            myFiles.push(dropPrev.files[i].name);
        };
        var newArr = myFiles.slice(0, -1);
        newArr = $.unique(newArr);
        if ($.inArray(file.name, newArr) >= 0) {
            $(document).find(file.previewElement).remove();
        } else {
            done();
        };
    },
    sending: function(file, xhr, formData) {
        title = $.trim($('#title').val());
        formData.append('title', title);
    },
    successmultiple: function(file, response) {
        $('#dropzoneStickers').find('.dz-remove').remove();
        getRecoverStickers();
    },
    error: function(xhr, status, error) {
        console.log(status);
        dropPrev.files = dropPrev.files.slice(0, -1);
        $('#dropzoneStickers').find('.dz-preview').addClass('dz-error');
    },
    removedfile: function(file, response) {},
    maxfilesexceeded: function(file, response) {
        console.log('has exedido el numero de archivos');
        $(document).find(file.previewElement).remove();
    }
});
url = $(location).attr('href');
accion = (url.split('/')[4]);
if (accion != 'create-album') {
    title = accion.split("=").pop();
    $.ajax({
        url: '/admin-stickers/site-exist',
        type: 'POST',
        data: {
            'title': title
        },
        beforeSend: function() {},
        success: function(album) {
            if (album.status != 404) {
                getDataAlbum(album);
                $('#title').val(album.title).attr('disabled', true);
                dropPort.enable();
                $('#dropzoneFrontCover').addClass('dropzone');
            } else {
                window.location.href = '/admin-stickers/create-album';
            };
        },
        error: function(xhr, status, error) {
            console.log(status);
        }
    });
};
/******************************************************************************/
$(document).on('click', '.color_odd_1', function(event) {
    bothPlace = (this.id.split('_')[2]);
    var bodyStyleEven = $(document).find('#even_' + bothPlace);
    var bodyStyleOdd = $(document).find('#odd_' + bothPlace);
    $(this).colorpicker().on('changeColor', function(event) {
        SelTypeBack = ($('#SelTypeBack_odd_' + bothPlace).val());
        myColor = event.color.toHex();
        if (SelTypeBack == 'STB_odd_1') {
            bodyStyleOdd.css('background', myColor);
            $('#odd_' + bothPlace).attr({
                'data-dato': myColor,
                'data-type': 'color'
            });
        };
        if (SelTypeBack == 'STB_odd_2') {
            bodyStyleEven.css('background', myColor);
            bodyStyleOdd.css('background', myColor);
            $('#odd_' + bothPlace).attr({
                'data-dato': myColor,
                'data-type': 'color'
            });
            $('#even_' + bothPlace).attr({
                'data-dato': myColor,
                'data-type': 'color'
            });
        };
        $(this).val(myColor);
    });
});
/******************************************************************************/
$(document).on('click', '.color_even_1', function(event) {
    bothPlace = (this.id.split('_')[2]);
    var bodyStyleEven = $(document).find('#even_' + bothPlace);
    $(this).colorpicker().on('changeColor', function(event) {
        SelTypeBack = ($('#SelTypeBack_even_' + bothPlace).val());
        myColor = event.color.toHex();
        if (SelTypeBack == 'STB_even_1') {
            bodyStyleEven.css('background', myColor);
        };
        $(this).val(myColor);
        $('#even_' + bothPlace).attr({
            'data-dato': myColor,
            'data-type': 'color'
        });
    });
});
/******************************************************************************/
$(document).on('change', 'select', function() {
    var mySelect = ($(this).val());
    var bothPlace = ((this.id).split('_')[2]);
    var placeSide = (mySelect.split('_')[1]);
    var _myOption = $('#myOption_' + placeSide + '_' + bothPlace);
    if (mySelect == 'STB_odd_1' || mySelect == 'STB_even_1') {
        _myOption.html('<section><input id=color_' + placeSide + '_' + bothPlace + ' value=#000000 type=text class="form-control color_' + placeSide + '_1"></section>');
        $('#color_' + placeSide + '_' + bothPlace).colorpicker();
        $('#SelTypeBack_even_' + bothPlace).attr('disabled', false);
    };
    if (mySelect == 'STB_odd_2') {
        _myOption.html('<section><input id=color_' + placeSide + '_' + bothPlace + ' value=#000000 type=text class="form-control color_' + placeSide + '_1"></section>');
        $('#color_' + placeSide + '_' + bothPlace).colorpicker();
        $('#myOption_even_' + bothPlace).empty();
        $('#SelTypeBack_even_' + bothPlace).attr('disabled', true).prop('selectedIndex', 0);
        $('#even_' + bothPlace).removeAttr('style');
        $('#odd_' + bothPlace).removeAttr('style');
    };
    if (mySelect == 'STB_odd_3' || mySelect == 'STB_even_2') {
        _myOption.html('<section><label class="input input-file"><div class=button><input type=file name=f_S_' + placeSide + ' id=f_S_' + placeSide + '_' + bothPlace + ' class=file><i class="fa fa-upload" id=btnLoad_S_' + placeSide + '_' + bothPlace + '></i></div><input type=text placeholder="add a simple image"   id=S_' + placeSide + '_' + bothPlace + '></label></section>');
        $('#SelTypeBack_even_' + bothPlace).attr('disabled', false);
    };
    if (mySelect == 'STB_odd_4') {
        _myOption.html('<section><label class="input input-file"><div class=button><input type=file name=f_D_odd id=f_D_odd_' + bothPlace + ' class=file><i class="fa fa-upload" id=btnLoad_D_odd_' + bothPlace + '></i></div><input type=text placeholder="add a simple image"   id=D_odd_' + bothPlace + '></label></section>');
        $('#myOption_even_' + bothPlace).empty();
        $('#SelTypeBack_even_' + bothPlace).attr('disabled', true).prop('selectedIndex', 0);
        $('#even_' + bothPlace).removeAttr('style');
        $('#odd_' + bothPlace).removeAttr('style');
    };
});
/******************************************************************************/
$(document).on('change', '.file', function() {
    var bothPlace = ((this.id).split('_')[3]);
    var placeSide = ((this.id).split('_')[2]);
    var backgroundPage = ((this.id).split('_')[1]);
    if (backgroundPage == 'S') {
        simple(this, placeSide);
    };
    if (backgroundPage == 'D') {
        doble(this);
    };
});
function simple(inputFile, placeSide) {
    var inputID = ($(inputFile).attr('id'));
    var inputName = inputID.split("_")[1] + "_" + inputID.split("_")[2] + "_" + inputID.split("_")[3];
    var bothPlace = inputID.split('_')[3];
    var _submit = $(inputFile)[0];
    filearr = (_submit.files[0]);
    var title = $.trim($('#title').val());
    var formData = new FormData();
    formData.append('file', filearr);
    formData.append('title', title);
    $.ajax({
        url: '/admin-stickers/upload-single',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            btnFa = ($(document).find('#btnLoad_S_' + placeSide + '_' + bothPlace));
            btnFa.removeClass('fa-upload').addClass('fa-refresh fa-spin');
        },
        success: function(filePath) {
            var filePath = $.trim(filePath);
            var fileName = filePath.split("/")[6]
            var coverName = fileName.split(".")[0];
            $("#" + inputName).val(fileName);
            if (inputFile.files && inputFile.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    if (placeSide == 'even') {
                        $('#even_' + bothPlace).attr({
                            'style': 'background-image:url(' + filePath + ')',
                            'data-dato': filePath,
                            'data-type': 'simple'
                        }).removeClass('doble').addClass('simple');
                        $('#S_even_' + bothPlace).attr('alt', filePath);
                    }
                    if (placeSide == 'odd') {
                        $('#odd_' + bothPlace).attr({
                            'style': 'background-image:url(' + filePath + ')',
                            'data-dato': filePath,
                            'data-type': 'simple'
                        }).removeClass('doble').addClass('simple');
                        $('#S_odd_' + bothPlace).attr('alt', filePath);
                    };
                };
                reader.readAsDataURL(inputFile.files[0]);
                btnFa.removeClass('fa-refresh fa-spin').addClass('fa-check');
            }
        },
        error: function(xhr, status, error) {
            console.log(status);
            btnFa.removeAttr('class').attr('class', 'fa fa-upload');
        }
    });
};
function doble(inputFile) {
    inputID = ($(inputFile).attr('id'));
    var inputName = inputID.split("_")[1] + "_" + inputID.split("_")[2] + "_" + inputID.split("_")[3];
    bothPlace = inputID.split('_')[3];
    var _submit = $(inputFile)[0];
    filearr = (_submit.files[0]);
    var title = $.trim($('#title').val());
    var formData = new FormData();
    formData.append('file', filearr);
    formData.append('title', title);
    $.ajax({
        url: '/admin-stickers/upload-single',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            btnFa = ($(document).find('#btnLoad_D_odd_' + bothPlace));
            btnFa.removeClass('fa-upload').addClass('fa-refresh fa-spin');
        },
        success: function(filePath) {
            var filePath = $.trim(filePath);
            var fileName = filePath.split("/")[6]
            var coverName = fileName.split(".")[0];
            $("#" + inputName).val(fileName);
            if (inputFile.files && inputFile.files[0]) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#even_' + bothPlace).attr({
                        'style': 'background-image:url(' + filePath + ')',
                        'data-dato': filePath,
                        'data-type': 'doble'
                    }).removeClass('simple').addClass('doble');
                    $('#odd_' + bothPlace).attr({
                        'style': 'background-image:url(' + filePath + ')',
                        'data-dato': filePath,
                        'data-type': 'doble'
                    }).removeClass('simple').addClass('doble');
                    $('#D_odd_' + bothPlace).attr('alt', filePath);
                }
                reader.readAsDataURL(inputFile.files[0]);
                btnFa.removeClass('fa-refresh fa-spin').addClass('fa-check');
            };
        },
        error: function(xhr, status, error) {
            console.log(status);
            btnFa.removeAttr('class').attr('class', 'fa fa-upload');
        }
    });
};
/******************************************************************************/
$(document).on('click', '#reorder', function(event) {
    allLi = $('#sortable').children();
    arrBackgroundsdReorder = [];
    $.each(allLi, function(key, li) {
        var bothPlace = (key + 1);
        var existOdd = $(li).find('.odd_1').attr('data-dato');
        if (existOdd) {
            if (existOdd != 'null') {
                var placePage = (bothPlace * 2) - 1;
                var backgroundData = $(li).find('.odd_1').attr('data-dato');
                var backgroundType = $(li).find('.odd_1').attr('data-type');
                var itemOdd = placePage + '_' + backgroundType + '_' + backgroundData;
                arrBackgroundsdReorder.push(itemOdd);
            };
        };
        var existEven = $(li).find('.even_1').attr('data-dato');
        if (existEven) {
            if (existEven != 'null') {
                var placePage = (bothPlace * 2);
                var backgroundData = $(li).find('.even_1').attr('data-dato');
                var backgroundType = $(li).find('.even_1').attr('data-type');
                var itemEven = placePage + '_' + backgroundType + '_' + backgroundData;
                arrBackgroundsdReorder.push(itemEven);
            };
        };
    });
    arrStickerssReorder = [];
    $.each(allLi, function(primaryKey, li) {
        var bothPlace = (primaryKey + 1);
        var oddPage = (bothPlace * 2) - 1;
        var evenPage = (bothPlace * 2);
        var allImages = $(li).find('img');
        if (allImages.length >= 1) {
            $.each(allImages, function(key, sticker) {
                iGeneral = $(sticker).parents()[1];
                oldPage = ($(iGeneral).attr('id').split('-')[0]);
                placeClass = ($(iGeneral).attr('class'));
                placeID = ($(iGeneral).attr('id').split('-')[2]);
                placeType = ($(iGeneral).attr('id').split('-')[1]);
                filePath = $(sticker).attr('src');
                cardName = $(sticker).attr('alt');
                if ((oldPage % 2) != 0) {
                    var placePage = oddPage;
                    placeSide = 'odd';
                    itemSticker = placePage + '_' + placeID + '_' + cardName + '_' + placeClass + '_' + placeType + '_' + filePath;
                    arrStickerssReorder.push(itemSticker);
                } else {
                    var placePage = evenPage;
                    placeSide = 'even';
                    itemSticker = placePage + '_' + placeID + '_' + cardName + '_' + placeClass + '_' + placeType + '_' + filePath;
                    arrStickerssReorder.push(itemSticker);
                };
                var filePath = $(sticker).attr('data-dato');
                name = filePath.split('/')[6].split('.')[0];
                var cardName = $(sticker).attr('alt');
            });
        };
    });
    arrDataStickers = [];
    $.each(allLi, function(primaryKey, dataSticker) {
        var allDataStickers = $(dataSticker).find('img');
        if (allDataStickers.length >= 1) {
            $.each(allDataStickers, function(key, sticker) {
                var dataTitle = $(sticker).attr("data-title");
                var dataDescription = $(sticker).attr("data-description");
                var index = $(sticker).attr("alt");
                var filePath = $(sticker).attr("data-dato");
                itemDataSticker = index + '_' + filePath + '_' + dataTitle + '_' + dataDescription;
                arrDataStickers.push(itemDataSticker);
            });
        };
    });
    colorFrontCover = $('#color').val();
    imgFrontCover = $('#choiceFrontCover').find('img');
    if (imgFrontCover.length > 0) {
        imgFrontCover = imgFrontCover[0].currentSrc;
    } else {
        imgFrontCover = '';
    };
    title = $.trim($('#title').val());
    var params = {
        'title': title,
        'imgFrontCover': imgFrontCover,
        'colorFrontCover': colorFrontCover,
        'data': {
            stickers: arrStickerssReorder,
            backgrounds: arrBackgroundsdReorder,
            dataStickers: arrDataStickers
        }
    };
    $.ajax({
        url: '/admin-stickers/save-album',
        type: 'POST',
        data: params,
        beforeSend: function() {},
        success: function(data) {
            window.top.close();
        },
        error: function(xhr, status, error) {
            console.log(status);
        }
    });
});
/******************************************************************************/
$(document).on('click', '#order', function(event) {
    $('.btn-next').attr('id', 'reorder');
    existReorder = $(document).find('.pageOrder').length;
    if (existReorder >= 1) {
        currentStep = $('#orderWizard').wizard('selectedItem').step;
        indexStep = currentStep - 1;
        $('#orderWizard').wizard('selectedItem', {
            step: indexStep
        });
        $('#orderWizard').wizard('removeSteps', currentStep, 1);
    };
    var allDiv = $(document).find('.bothpages');
    var currentStep = $('#orderWizard').wizard('selectedItem').step;
    var indexStep = Number(currentStep) + 1;
    $('#thankModal').modal('hide');
    $('#orderWizard').wizard('addSteps', indexStep, [{
        label: 'Paso' + indexStep,
        pane: '<h3 id=last_' + currentStep + ' class=pageOrder><strong>Paso ' + indexStep + '</strong> - Selecciona el tipo de hoja</h3>'
    }]);
    var goToIndex = Number(($(document).find('.step-pane').length));
    $('#orderWizard').wizard('selectedItem', {
        step: goToIndex
    });
    $('#last_' + currentStep).after('<ul id=sortable></ul>');
    $.each(allDiv, function(primaryKey, div) {
        var bothPlace = (primaryKey + 1);
        countPages = ($(div).find('.thumbnailContainer').length);
        countDivs = ($(div).find('.page'));
        plus = [];
        $.each(countDivs, function(key, div) {
            data = ($(div).attr('data-dato'));
            if (data == 'null') {
                exist = 1;
            } else {
                exist = 0;
            };
            plus = Number(plus) + Number(exist);
        })
        if (plus <= 1 || countPages >= 1) {
            $('#sortable').append('<li class=ui-state-default data-id=' + bothPlace + ' id=sortable_' + bothPlace + '>');
            $(div).clone().appendTo('#sortable_' + bothPlace);
        };
    });
    $('#sortable div').remove('.number_1').remove('.number_2');
    $('#sortable div').remove('.clk');
    $('#sortable').sortable({
        placeholder: 'ui-state-highlight'
    });
    $('#sortable').disableSelection();
});
/******************************************************************************/
$(document).on('click', '#topClose', function(event) {
    saveAlbum('saveClose');
});
$(document).on('click', '.btn-prev', function(event) {
    $('.btn-next').removeAttr('id');
});
$(document).on('click', '.complete', function(event) {
    $('.btn-next').removeAttr('id');
});
