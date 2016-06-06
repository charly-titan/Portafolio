/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


    $(function() {
        $('#btnValidate').click(function() {


            if ($("#startTime").val().length == '') {
                $("#error2").html("<div class='icon pull-left'> <i class='fa   fa-times-circle color-red'></i> Requerido</div>");
                return false;
            }

            if ($("#endTime").val().length == '') {
                $("#error3").html("<div class='icon pull-left'> <i class='fa   fa-times-circle color-red'></i> Requerido</div>");
                return false;
            }


            var txt = $('#url').val();
            var re = /(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/
            if (re.test(txt)) {
                $("#error").html("<div class='icon pull-left'> <i class='fa  fa-thumbs-up color-blue'></i>Valid URL </div>");
            }
            else {
                $("#error").html("<div class='icon pull-left'> <i class='fa  fa-thumbs-down color-red'></i>Please enter valid URL </div>");

                return false;
            }
        })
    })




    function ValidaURL(url) {
        var regex = /^(ht|f)tps?:\/\/\w+([\.\-\w]+)?\.([a-z]{2,4}|travel)(:\d{2,5})?(\/.*)?$/i
        return regex.test(url);

    }
    function validar(f) {
        if (!ValidaURL(f.url.value)) {
            $("#error").html("<div class='icon pull-left'> <i class='fa  fa-thumbs-down color-red'></i> Please enter valid URL  </div>");
            f.url.focus();
            return (false);
        }
        else {
            $("#error").html("<div class='icon pull-left'> <i class='fa  fa-thumbs-up color-blue'></i>Valid URL </div>");
        }


    }
