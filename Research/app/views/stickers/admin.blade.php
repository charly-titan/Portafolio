@extends(Config::get( 'app.main_template' ).'.main')
@section('heads')
<!--
/*******************************************************************/
*                                css                                *
/*******************************************************************/
-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="https://jqueryui.com/jquery-wp-content/themes/jqueryui.com/style.css">
<style type='text/css'>
    /*
    #even_1{
        background-size: 100% 100%;
        background-repeat: no-repeat;
    }
    #even_2{
        background-size: 100% 100%;
        background-repeat: no-repeat;
    }
    .ui-state-highlight{
        background: gray !important;
        border: dotted 2px black;
    }
    */
</style>
<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/fuelux/3.4.0/css/fuelux.min.css'/>
<link rel='stylesheet' href='{{asset('/css/stickers-admin.css')}}'/>
@endsection
@section('content')
<div id='main' role='main'>
    <div id='content'>
        <section id='widget-grid' class=''>
            <div class='row'>
                <article class='col-sm-12 col-md-12 col-lg-10'>
                    <div class='jarviswidget' id='wid-id-2' data-widget-editbutton='false' data-widget-deletebutton='false'>
                        <header>
                            <h2>
                                Admin Stickers
                            </h2>
                        </header>
                        <div class='fuelux'>
                            <div class='wizard' id='orderWizard'>
                                <ul class='steps'>
                                    <li data-step='1' class='active'>
                                        <span class='badge'>
                                            1
                                        </span>
                                        Paso 1
                                        <span class='chevron'>
                                        </span>
                                    </li>
                                    <li data-step='2'>
                                        <span class='badge'>
                                            2
                                        </span>
                                        Paso 2
                                        <span class='chevron'>
                                        </span>
                                    </li>
                                    <li data-step='3'>
                                        <span class='badge'>
                                            3
                                        </span>
                                        Paso 3
                                        <span class='chevron'>
                                        </span>
                                    </li>
                                </ul>
                                <div class='actions'>
                                    <button type='button' class='btn btn-primary btn-prev'>
                                        <span class='glyphicon glyphicon-arrow-odd'>
                                        </span>
                                        Ant.
                                    </button>
                                    <button type='button' class='btn btn-success btn-next' data-last='Fin'>
                                        Sig.
                                        <span class='glyphicon glyphicon-arrow-even'>
                                        </span>
                                    </button>
                                </div>
                                <form id='orderForm' method='post' class='form-horizontal'>
                                    <div class='step-content'>
                                        <!-- The first panel -->
                                        <div class='step-pane active' data-step='1'>
                                            <h3>
                                                <strong>
                                                    Paso 1
                                                </strong>
                                                - Titulo y Portada
                                            </h3>
                                            <div class='row form-group'>
                                                <div class='col-md-6 col-xs-6'>
                                                    <input type='text' class='form-control' name='title' id='title' placeholder='Titulo'/>
                                                </div>
                                                <div class='col-md-6 col-xs-6'>
                                                    <input type='text' class='form-control' name='color' id='color' placeholder='Color'
                                                    disabled='disabled' value='#354a4a' />
                                                </div>
                                            </div>
                                            <div class='row form-group'>
                                                <div class='col-md-6 col-xs-6'>
                                                    <div class='page' >
                                                        <div id='dropzoneFrontCover' class='dropzone'>
                                                            <span class='text-center'>
                                                                <span class='font-lg visible-xs-block visible-sm-block visible-lg-block'>
                                                                    <span class='font-lg'>
                                                                        <i class='fa fa-caret-right text-danger'></i>
                                                                        Drop Zone
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-md-6 col-xs-6'>
                                                    <div class='page' >
                                                        <a href='#' id='rgbpicker-1' data-color='#354a4a'>
                                                            <div id='choiceFrontCover'>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- The second panel -->
                                        <div class='step-pane' data-step='2'>
                                            <h3>
                                                <strong>
                                                    Paso 2
                                                </strong>
                                                - Arrastra los Stickers
                                            </h3>
                                            <div class='row form-group'>
                                                <div class='col-md-12 col-xs-12'>
                                                    <div class='page' >
                                                        <div id='dropzoneStickers' class='dropzone'>
                                                            <span class='text-center'>
                                                                <span class='font-lg visible-xs-block visible-sm-block visible-lg-block'>
                                                                    <span class='font-lg'>
                                                                        <i class='fa fa-caret-right text-danger'></i>
                                                                        Drop Zone
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- The third panel -->
                                        <div class='step-pane' data-step='3'>
                                            <h3>
                                                <strong>
                                                    Paso 3
                                                </strong>
                                                - Selecciona el tipo de hoja
                                            </h3>
                                            <div class='toclone' id='original_1'>
                                                <div class='col-md-12 col-xs-12'>
                                                    <div class='form-group'>
                                                        <a href='javascript:void(0);' class='btn btn-success btn-circle pull-right clon' id='clon_1' disabled='disabled'>
                                                            <i class='glyphicon glyphicon-plus'>
                                                            </i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class='row form-group'>
                                                    <div class='col-md-6 col-xs-6'>
                                                        <select class='form-control SelTypePage_1' id='SelTypePage_odd_1'>
                                                            <option selected='selected' disabled=''>Tipo de hoja</option>
                                                            <option value='STP_odd_1'>1</option>
                                                            <option value='STP_odd_2'>1 y 1</option>
                                                            <option value='STP_odd_3'>1 y 2</option>
                                                            <option value='STP_odd_4'>2 y 1</option>
                                                            <option value='STP_odd_5'>2x2</option>
                                                            <option value='STP_odd_6'>3x2</option>
                                                        </select>
                                                    </div>
                                                    <div class='col-md-6 col-xs-6'>
                                                        <select class='form-control SelTypePage_2' id='SelTypePage_even_1'>
                                                            <option selected='selected' disabled=''>Tipo de hoja</option>
                                                            <option value='STP_even_1'>1</option>
                                                            <option value='STP_even_2'>1 y 1</option>
                                                            <option value='STP_even_3'>1 y 2</option>
                                                            <option value='STP_even_4'>2 y 1</option>
                                                            <option value='STP_even_5'>2x2</option>
                                                            <option value='STP_even_6'>3x2</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='row form-group'>
                                                    <div class='col-md-6 col-xs-6'>
                                                        <select class='form-control SelTypeBack_1' id='SelTypeBack_odd_1'>
                                                            <option selected='selected' disabled=''>
                                                                Tipo de fondo
                                                            </option>
                                                            <option value='STB_odd_1'>
                                                                Color
                                                            </option>
                                                            <option value='STB_odd_2'>
                                                                Color Doble
                                                            </option>
                                                            <option value='STB_odd_3'>
                                                                Img Simple
                                                            </option>
                                                            <option value='STB_odd_4'>
                                                                Img Doble
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class='col-md-6 col-xs-6'>
                                                        <select class='form-control SelTypeBack_2' id='SelTypeBack_even_1'>
                                                            <option selected='selected' disabled=''>
                                                                Tipo de fondo
                                                            </option>
                                                            <option value='STB_even_1'>
                                                                Color
                                                            </option>
                                                            <option value='STB_even_2'>
                                                                Img Simple
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='row form-group'>
                                                    <div class='col-md-6 col-xs-6'>
                                                        <div class='smart-form' id="myOption_odd_1"></div>
                                                    </div>
                                                    <div class='col-md-6 col-xs-6'>
                                                        <div class='smart-form' id="myOption_even_1"></div>
                                                    </div>
                                                </div>
                                                <div class="bothpages">
                                                    <div class='col-md-6 col-xs-6'>
                                                        <div class='page odd odd_1' id='odd_1' data-dato="null" data-type="null">
                                                            <div class='pageBody_1' id='pageBody_odd_1'>
                                                            </div>
                                                        </div>
                                                        <div class='pull-left number_1'>p_1</div>
                                                    </div>
                                                    <div class='col-md-6 col-xs-6'>
                                                        <div class='page even even_1' id='even_1' data-dato="null" data-type="null">
                                                            <div class='pageBody_2' id='pageBody_even_1'></div>
                                                        </div>
                                                        <div class='pull-right number_2'>p_2</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
<div class='modal fade' id='thankModal' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>
                        &times;
                    </span>
                </button>
                <h4 class='modal-title' id='myModalLabel'>
                    Información completada
                </h4>
            </div>
            <div class='modal-body'>
                <p class='text-center'>
                    El nuevo album se ha guardado, que desea realizar?
                </p>
            </div>
            <div class='modal-footer'>
                <button type='button' id='reRoute' class='btn btn-primary' title="Save & view"><i class="fa fa-save"></i> & <i class="fa fa-eye"></i></button>
                <button type='button' id='order' class='btn btn-primary' title="Re Order"><i class="fa fa fa-random"></i></button>
                <button type='button' id='topClose' class='btn btn-primary' title="Save & exit"><i class="fa fa-save"></i> & <i class="fa fa-power-off"></i></button>
            </div>
        </div>
    </div>
</div>
<div class='modal fade' id='imagesModal' tabindex='-1' role='dialog'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>
                        &times;
                    </span>
                </button>
                <h4 class='modal-title' id='myModalLabel'>
                    Stickers
                </h4>
            </div>
            <div class='modal-body'>
                <div class='row'>
                    <!-- SuperBox -->
                    <div class='superbox col-sm-12' id='gallery'></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<!--
/******************************************************************/
*                           scripts.js                             *
/******************************************************************/
-->
<script src='//cdnjs.cloudflare.com/ajax/libs/fuelux/3.4.0/js/fuelux.min.js'>              </script>
<script src='//formvalidation.io/vendor/formvalidation/js/formValidation.min.js'>          </script>
<script src='//formvalidation.io/vendor/formvalidation/js/framework/bootstrap.min.js'>     </script>
<script src='{{asset('/js/plugin/dropzone/dropzone.min.js')}}'>                            </script>
<script src='{{asset('/js/plugin/colorpicker/bootstrap-colorpicker.min.js')}}'>            </script>
<script src='{{asset('/js/stickers-admin.js')}}'>                                         </script>
@endsection
