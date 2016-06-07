function mydropzone() {
    Dropzone.options.dropzone = {
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        autoProcessQueue: false,
        autoDiscover: false,
        clickable: '#dropzonePreview',
        dictCancelUpload: 'Cancelar',
        dictDefaultMessage: '',
        dictRemoveFile: 'Quitar',
        dictResponseError: 'Ha ocurrido un error en el server',
        maxFileSize: 1000,
        maxFiles: 12,
        method: 'post',
        parallelUploads: 12,
        paramName: myParamName,
        previewsContainer: '#dropzonePreview',
        uploadMultiple: true,
        url: 'http://node-write.sinpk2.com:9000/api/upload',
        init: function() {
            myDropzone = this;
            $("#clear-dropzone").click(function() {
                limpiarUh();
            });
        },
        successmultiple: function(file, response) {
            message_ok($("#uploaden").val());
        },
        error: function() {
            message_server();
        },
    };
};

function myParamName() {
    return 'mxm_files';
};

function validacion() {
    $('#dropzone').validate({
        rules: {
            sitio: {
                required: true
            },
            title: {
                required: true,
            },
            text: {
                required: true,
            },
            url: {
                url: true,
            }
        },
        messages: {
            sitio: {
                required: 'El campo de la categoria es requerido',
            },
            title: {
                required: 'El campo de titulo es requerido',
            },
            text: {
                required: 'El campo de texto es requerido',
            },
            url: {
                url: 'Ingrese un URL valida (ej. http://dominio.com/nota)'
            }
        },
        submitHandler: function(form) {
            if (myDropzone.getQueuedFiles().length > 0) {
                myDropzone.processQueue();
            } else {
                myDropzone.uploadFile([]);
            };
        },
        invalidHandler: function(event, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                var message = errors == 1
                message_validate();
            } else {}
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },
    });
};

function message_ok(tipo) {
    if (tipo == 'Actualizar') {
        tipo = 'actualizo';
    } else {
        tipo = 'guardo';
    };
    $("#uploaden").prop('disabled', true);
    $("#mxm_cat").prop('disabled', true);
    $("#mxm_titulo").prop('disabled', true);
    $("#mxm_texto").prop('disabled', true);
    $("#mxm_url").prop('disabled', true);
    $("#clear-dropzone").prop('disabled', true);
    $.SmartMessageBox({
        title: 'Información!',
        content: 'tu nota se ' + tipo + ' correctamente',
        buttons: '[Cerrar]'
    }, function(ButtonPressed) {
        if (ButtonPressed === 'Cerrar') {
            limpiarUh();
            if (tipo == 'actualizo') {
                $('#myModal').modal('toggle');
            };
            $("#uploaden").prop('disabled', false);
            $("#mxm_cat").prop('disabled', false);
            $("#mxm_titulo").prop('disabled', false);
            $("#mxm_texto").prop('disabled', false);
            $("#mxm_url").prop('disabled', false);
            $("#clear-dropzone").prop('disabled', false);
        }
    });
};

function message_validate() {
    $.SmartMessageBox({
        title: 'Alerta!',
        content: 'Tienes campos obligatorios sin llenar o contienen información incorrecta',
        buttons: '[Cerrar]'
    }, function(ButtonPressed) {});
};

function message_server() {
    $.SmartMessageBox({
        title: 'Alerta!',
        content: 'Error en el servidor de publicación',
        buttons: '[Cerrar]'
    }, function(ButtonPressed) {});
};

function message_borrado() {
    $.SmartMessageBox({
        title: 'Información!',
        content: 'Tu nota se ha eliminado correctamente',
        buttons: '[Cerrar]'
    }, function(ButtonPressed) {});
};

function message_borrado_user() {
    $.SmartMessageBox({
        title: 'Información!',
        content: 'Se han retirado los permisos a este usuario',
        buttons: '[Cerrar]'
    }, function(ButtonPressed) {});
};

function message_site() {
    $.SmartMessageBox({
        title: "Alerta!",
        content: "Debes seleccionar al menos un sitio",
        buttons: '[Cerrar]'
    }, function(ButtonPressed) {

    });
};

function message_user() {
    $.SmartMessageBox({
        title: "Alerta!",
        content: "Debes seleccionar un usuario",
        buttons: '[Cerrar]'
    }, function(ButtonPressed) {
        $('#user_id').val('');
    });
};

function message_site_user() {
    $.SmartMessageBox({
        title: "Alerta!",
        content: "Debes seleccionar un usuario y al menos un sitio",
        buttons: '[Cerrar]'
    }, function(ButtonPressed) {});
};

function autocompletar() {
    (function($) {
        $.widget("custom.combobox", {
            _create: function() {
                this.wrapper = $("<span>")
                    .insertAfter(this.element);
                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },
            _createAutocomplete: function() {
                var selected = this.element.children(":selected"),
                    value = selected.val() ? selected.text() : "";
                this.input = $("<input id='email' class='form-control' onblur='getUsers(this.value)'>")
                    .appendTo(this.wrapper)
                    .val(value)
                    .attr("title", "")
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: $.proxy(this, "_source")
                    })
                    .tooltip({
                        tooltipClass: "ui-state-highlight"
                    });
                this._on(this.input, {
                    autocompleteselect: function(event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },
                    autocompletechange: "_removeIfInvalid"
                });
            },
            _createShowAllButton: function() {
                var input = this.input,
                    wasOpen = false;
                $("<a>")
                    .attr("tabIndex", -1)
                    .tooltip()
                    .appendTo(this.wrapper)
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass("ui-corner-all")
                    .addClass("custom-combobox-toggle ui-corner-right")
                    .mousedown(function() {
                        wasOpen = input.autocomplete("widget").is(":visible");
                    })
                    .click(function() {
                        input.focus();
                        if (wasOpen) {
                            return;
                        }
                        input.autocomplete("search", "");
                    });
            },
            _source: function(request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function() {
                    var text = $(this).text();
                    if (this.value && (!request.term || matcher.test(text)))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },
            _removeIfInvalid: function(event, ui) {
                if (ui.item) {
                    return;
                }
                var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                this.element.children("option").each(function() {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });
                if (valid) {
                    return;
                }
                this.input
                    .val("")
                    .attr("title", value + " - sin coincidencia")
                    .tooltip("open");
                this.element.val("");
                this._delay(function() {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },
            _destroy: function() {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);

    $(function() {
        $("#combobox").combobox();
        $("#toggle").click(function() {
            $("#combobox").toggle();
        });
    });
}

function pingClick() {
    $('#selecctall').click(function(event) {
        if (this.checked) {
            $('.checkbox1').each(function() {
                this.checked = true;
            });
        } else {
            $('.checkbox1').each(function() {
                this.checked = false;
            });
        }
    });
    $('.checkbox1').click(function(event) {
        var checkbox_act = ($("input[class=checkbox1]:checked").length);
        var checkbox_all = ($("input[class=checkbox1]").length);
        if (checkbox_act < checkbox_all) {
            $("#selecctall").prop("checked", false);
        } else {
            $("#selecctall").prop("checked", true);
        }
    });
};

function limpiarUh() {
    $('#uploaden').val('Guardar');
    $('#clear-dropzone').val('Borrar');
    $("#dropzone").attr('name', 'Guardar');
    $("#eliminar").attr('type', 'hidden');
    $('#dropzone').trigger("reset");
    if ($('#mxm_id')) {
        $('#mxm_id').remove();
    };
    if ($('#mxm_old')) {
        $('#mxm_old').remove();
    };
    myDropzone.removeAllFiles();
    if (($("[class=valid]")) || ($("[class=invalid]"))) {
        $('#dropzone').validate().resetForm();
        $('.state-success').removeClass('state-success');
        $('.state-error').removeClass('state-error');
    };
    var mxm_cat = $('#mxm_cat').val();
    $('#mxm_categoria').val(mxm_cat);
};

function mxm_getElement(id) {
    $.ajax({
        url: 'http://node-write.sinpk2.com:9000/api/' + id + '/show',
        type: 'post',
        success: function(nota) {
            limpiarUh();
                $('#myModal').modal();
                $("#dropzone").attr('name', 'Actualizar');
                $('#uploaden').val('Actualizar');
                $("#eliminar").attr('name', nota.id);
                $('#clear-dropzone').val('Cancelar');
                $('#mxm_url').val(nota.url);
                $('#mxm_texto').val(nota.text);
                $('#mxm_titulo').val(nota.title);
                $('#mxm_categoria').val(nota.sitio);
                $('#eliminar').attr('type', 'button');
                $('#dropzone').append("<input type='hidden' name='mxm_id' value=" + nota.id + " id='mxm_id'>");
                if (nota.img) {
                    var imgs = JSON.stringify(nota.img, null);
                    $('#dropzone').append("<input type='hidden' name='mxm_old' value=" + imgs + " id='mxm_old'>");
                    for (var x in nota.img) {
                        var url_img = nota.img[x].url;
                        var mockFile = {
                            size: [],
                        };
                        myDropzone.emit('addedfile', mockFile);
                        myDropzone.emit('thumbnail', mockFile, url_img);
                        myDropzone.emit('complete', mockFile);
                        myDropzone.files.push(mockFile);
                        $('.dz-remove').remove();
                    };
                };
        },
        error: function() {
            message_server();
        }
    });
};

function mxm_delete(id) {
    $.SmartMessageBox({
        title: 'Alerta!',
        content: 'Estas seguro de borrar esta nota?',
        buttons: '[Cerrar],[Aceptar]'
    }, function(ButtonPressed) {
        if (ButtonPressed === 'Aceptar') {
            $.ajax({
                url: 'http://node-write.sinpk2.com:9000/api/' + id + '/delete',
                type: 'post',
                success: function(response) {
                    limpiarUh();
                    $('#myModal').modal('toggle');
                }
            });
            message_borrado();
        }
    });
};

function limpiarUsers() {
    $('#user_id').val('');
    $('#myform').trigger("reset");
};

function getUsers(email) {
    var parametros = {
        "email": email,
    };
    if (parametros.email != "") {
        $.ajax({
            url: 'users',
            type: 'post',
            data: parametros,
            success: function(data) {
                $("#first_name").prop('disabled', true);
                $("#last_name").prop('disabled', true);
                $('#email').val(parametros.email);
                $('#user_id').val(data.user_id);
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('input[type=checkbox]').each(function() {
                    this.checked = false;
                });
                var sitios = data.sites;
                if (sitios) {
                    sitios.forEach(function(sitio) {
                        $("#" + sitio.abrev).prop("checked", true);
                    });
                };
                var checkbox_act = ($("[class=checkbox1]:checked").length);
                var checkbox_all = ($("[class=checkbox1]").length);
                if (checkbox_act < checkbox_all) {
                    $("#selecctall").prop("checked", false);
                } else {
                    $("#selecctall").prop("checked", true);
                }
            }
        });
    };
};

function postUserEdit(email) {
    $('#myModal').modal();
    getUsers(email);
};

function postUserDelete(user_id) {
    $.SmartMessageBox({
        title: "Alerta!",
        content: "Estas seguro de retirar los permisos a este usuario?",
        buttons: '[Cerrar],[Aceptar]'
    }, function(ButtonPressed) {
        if (ButtonPressed === "Aceptar") {
            var parametros = {
                "user_id": user_id,
            };
            $.ajax({
                url: 'user-delete',
                type: 'post',
                data: parametros,
                success: function(response) {
                    window.location.reload(true);
                }
            });
        }
    });
};

function limpiarSites(argument) {
    $('#site_id').val('');
    $('#myform').trigger("reset");
}

function getSite(site_id) {
    var parametros = {
        "site_id": site_id,
    };
    $.ajax({
        url: 'sites',
        type: 'post',
        data: parametros,
        success: function(sitio) {
            $('#site_id').val(sitio.site_id);
            $('#abrev').val(sitio.abrev);
            $('#site').val(sitio.site);
        }
    });
};

function postSiteEdit(site_id) {
    $('#myModal').modal();
    getSite(site_id);
}

function postSiteDelete(site_id) {
    $.SmartMessageBox({
        title: "Alerta!",
        content: "Estas seguro de borrar este sitio?",
        buttons: '[Cerrar],[Aceptar]'
    }, function(ButtonPressed) {
        if (ButtonPressed === "Aceptar") {
            var parametros = {
                "site_id": site_id,
            };
            $.ajax({
                url: 'site-delete',
                type: 'post',
                data: parametros,
                success: function(response) {
                    window.location.reload(true);
                }
            });
        }
    });
};
