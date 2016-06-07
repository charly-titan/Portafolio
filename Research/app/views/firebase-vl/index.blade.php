@extends(Config::get( 'app.main_template' ).'.main')
@section('heads')
<!--
/*******************************************************************/
*                                                                   *
*                                css                                *
*                                                                   *
/*******************************************************************/
-->
<style>
    * :disabled{
        background: #eee !important;
        cursor: not-allowed !important;
        border-color: rgb(169, 169, 169);
        color: rgb(84, 84, 84);
    }
</style>
<!--
/*******************************************************************/
*                                                                   *
*                                js                                 *
*                                                                   *
/*******************************************************************/
-->
<script src='https://cdn.firebase.com/js/client/2.2.1/firebase.js'></script>
<script type="text/javascript" src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
@endsection
@section('content')
<div id="content" style="opacity: 1;">
    <div class="row">
        <div class="col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-edit fa-fw ">
                </i>
                Title
            </h1>
        </div>
    </div>
</div>
<!--
<div class="row">
    <div class="col-sm-12">
        <div class="well">
            <button class="close" data-dismiss="alert">
                ×
            </button>
            <h1 class="semi-bold">
                Instrucciones
            </h1>
            <p>
                SmartAdmin comes with a fully customized grid system catered specifically for building form layouts. Its not technically "better" than the bootstrap 3 built in grid system,
                but rather more simplified for rapid form layout and faster development. Idealy you would use either the
                <strong>
                    bootstrap
                </strong>
                grid or the
                <strong>
                    smart-form
                </strong>
                grid,
                when building your form layouts. It is important not to mix elements from two seperate classes as it can cause conflict.
            </p>
        </div>
    </div>
</div>
-->
<section id="widget-grid" class="">
    <!-- START ROW -->
    <div class="row">
        <!-- NEW COL START -->
        <article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <!-- Widget ID (each widget will need unique ID) -->
            <div class="jarviswidget" id="wid-id-1" role="widget">
                <header role="heading">
                    <span class="widget-icon">
                        <i class="fa fa-edit">
                        </i>
                    </span>
                    <h2>
                        Agrega un nuevo campo
                    </h2>
                    <span class="jarviswidget-loader">
                        <i class="fa fa-refresh fa-spin">
                        </i>
                    </span>
                </header>
                <!-- widget div -->
                <div role="content">
                    <!-- widget content -->
                    <div class="widget-body no-padding">
                        <div class="smart-form">
                            <header>
                                Categorias
                            </header>
                            <fieldset>
                                <section>
                                    <label class="label">
                                        Input with autocomplete
                                    </label>
                                    <label class="input col-sm-10 col-md-10 col-lg-10">
                                        <input type="text" list="list" id="inputList"/>
                                        <datalist id="list">
                                        </datalist>
                                    </label>
                                    <div class="note col-sm-10 col-md-10 col-lg-10">
                                        <strong>
                                            Note:
                                        </strong>
                                        works in Chrome, Firefox, Opera and IE10.
                                    </div>
                                </section>
                            </fieldset>
                            <fieldset>
                                <section>
                                    <label class="label col-sm-10 col-md-10 col-lg-10">
                                        Default text input with maxlength 20 chars
                                    </label>
                                    <label class="input col-sm-10 col-md-10 col-lg-10">
                                        <input type="text" maxlength="20" id="newField"/>
                                    </label>
                                    <div class="col-md-1">
                                        <a href="javascript:void(0);" class="btn btn-success btn-circle pull-right" id="addField">
                                            <i class="glyphicon glyphicon-plus">
                                            </i>
                                        </a>
                                    </div>
                                </section>
                            </fieldset>
                            <footer>
                            </footer>
                        </div>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- END COL -->
        <!-- NEW COL START -->
        <article class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <!-- Widget ID (each widget will need unique ID) -->
            <div class="jarviswidget" id="wid-id-2" role="widget">
                <header role="heading">
                    <span class="widget-icon">
                        <i class="fa fa-edit">
                        </i>
                    </span>
                    <h2 >
                        Agrega un nuevo elemento
                    </h2>
                    <span class="jarviswidget-loader">
                        <i class="fa fa-refresh fa-spin">
                        </i>
                    </span>
                </header>
                <!-- widget div -->
                <div role="content">
                    <div class="widget-body no-padding">
                        <form id="formTow" class="smart-form" data-toggle="validator" role="form">
                            <header id="catID">
                                Default
                            </header>
                            <fieldset id="fieldsCat">
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn btn-primary" id="addElement">
                                    Add!
                                </button>
                                <button type="button" class="btn btn-default" id="clearInputs">
                                    clear!
                                </button>
                            </footer>
                        </form>
                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- END COL -->
    </div>
    <!-- END ROW -->
</section>
<!-- end widget grid -->
</div>
@endsection
@section("scripts")
@parent
<!--
/**********************************************************/
*                          script                          *
/**********************************************************/
-->
<script>
    inputLength = ($("#inputList").val().length);
    if (inputLength === 0) {
        $("#addField").attr("disabled", true);
        $("#newField").attr("disabled", true);
    } else {
        $("#addField").attr("disabled", false);
        $("#newField").attr("disabled", false);
    }
//$("#addElement").attr("disabled", true);
$("#inputList").click(function(event){
    event.preventDefault();
    $("#inputList").val("");
});
fbRef = new Firebase("https://burning-heat-9194.firebaseio.com");
catalogRef = fbRef.child('catalog');
$('#inputList').keypress(function (e) {
    if (e.keyCode == 13) {
        newField = $('#inputList').val().trim().toLowerCase().replace(/\s+/g,"-");
        holder = $('#inputList').val().trim().toLowerCase().replace(/\s+/g," ");
        fieldID = CryptoJS.MD5(newField).toString();
        catalogRef.child(fieldID).child('general').set({name: newField, activate: true, holder: holder});
        catalogRef.child(fieldID).child('fields').set({name: 'required'});
        $('#inputList').val('');
    }
});
catalogRef.orderByPriority().on("child_added", function(snapshot) {
    objCat = snapshot.val();
    objCat.key = (snapshot.key());
    diplayInput(objCat.key, objCat.general.name, objCat.general.activate, objCat.general.holder);
}, function (errorObject) {
    console.log("The read failed: " + errorObject.code);
});
function diplayInput(key, name, activate, holder) {
    myobject='<option id="'+key+'" value="'+holder+'">'+activate+'</option>';
    $('#list').append(myobject);
};
$("#inputList").change(function() {
    myValue = $('#inputList').val().trim().toLowerCase().replace(/\s+/g,"-");
    holder = $('#inputList').val().trim().toLowerCase().replace(/\s+/g," ");
    myValueID = CryptoJS.MD5(myValue).toString();
    if (holder.length > 0) {
        $("#addField").attr("disabled", false);
        $("#newField").attr("disabled", false);
        catalogRef.once("value", function(snapshot) {
            b = snapshot.child(myValueID).exists();
        });
        if (b === true) {
            catalogRef.child(myValueID).orderByPriority().on("value", function(snapshot) {
                myChild= snapshot.val();
                myChild.key= snapshot.key();
                $("#addField").attr("disabled", false);
                $("#newField").attr("disabled", false);
                $("#catID").text(myChild.general.holder);
                if (myChild.fields) {
                    diplayInputCat(myChild.key, myChild.fields, myChild.general);
                }
            }, function (errorObject) {
                console.log("My error: " + errorObject.code);
            });
            catalogRef.child(myValueID).orderByPriority().on("child_changed", function(snapshot) {
                objCat = snapshot.val();
                objCat.key = (snapshot.key());
                if (objCat.fields) {
                    diplayInputCat(objCat.key, objCat.fields, objCat.general);
                }
            }, function (errorObject) {
                console.log("My error: " + errorObject.code);
            });
            subCatalogRef = catalogRef.child(myValueID);
            $("#addField").click(function(event){
                var timeInMs = Date.now();
                event.preventDefault();
                newField = $('#newField').val().trim().toLowerCase().replace(/\s+/g,"-");
                holder = $('#newField').val().trim().toLowerCase().replace(/\s+/g," ");
                fieldID = CryptoJS.MD5(newField).toString();
                subCatalogRef.child('fields').child(holder).set(true);
                subCatalogRef.child('fields').child(holder).setPriority(timeInMs);
                $('#newField').val('');
            });
        }
    } else {
        $("#addField").attr("disabled", true);
        $("#newField").attr("disabled", true);
        $("#catID").text("Default");
        $("#fieldsCat").empty();
    }
});
function diplayInputCat(key, fields, general) {
    myobject ="";
    $.each(fields, function(j, k){
        id= j.replace(" ", "_");
        myobject+='<section class="col-sm-10 col-md-10 col-lg-10"><label class="input">'+
        '<input type="text" class="input-sm" id="'+id+'" placeholder="'+j+'" name="'+j+'" '+k+'></label></section>';
    })
    $('#fieldsCat').html(myobject);
};
$("#clearInputs").click(function(event){
    event.preventDefault();
    $('#wid-id-2 :input').val('');
});
$("#addElement").click(function(event){
    myValue = $('#inputList').val().trim().toLowerCase().replace(/\s+/g,"-");
    holder = $('#inputList').val().trim().toLowerCase().replace(/\s+/g," ");
    myValueID = CryptoJS.MD5(myValue).toString();
    categoryRef = fbRef.child(myValue);
    event.preventDefault();
    var $inputs = $('#wid-id-2 :input.input-sm');
    var values = {};

    $("#name").change(function() {
            $padres =$('#wid-id-2').find("#name").parent();
            $padres.removeAttr("class").addClass("input");
    })
    $inputs.each(function(event) {
        attrName = $(this).attr("name");
        val=$(this).val();
        if (attrName === "name") {
            fieldName= $(this).val().toUpperCase();
            fieldNameID = CryptoJS.MD5(fieldName).toString();
        }
        if (fieldName.length > 0) {
            name = val.toUpperCase();
            holder = $(this).attr("placeholder");
            nameID = CryptoJS.MD5(name).toString();
            categoryRef.child(fieldNameID).child(holder).set(name);
        } else {
            $padres =$('#wid-id-2').find("#name").parent();
            $padres.addClass("state-error");
        }
    });
});
</script>
@endsection
