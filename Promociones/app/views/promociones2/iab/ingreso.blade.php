@extends(Config::get( 'app.main_template' ).'.iab.main')

@section('content')

<style>
#txt-code{
    width: 250px;
    height: 55px;
    font-size: 28px;
}
.lbl-txt{
    font-size: 25px;
    font-weight: normal;
    margin-bottom: 15px;
    text-transform: uppercase;
}
.error{
    font-size: 18px;
    color: red;
    margin-top: 10px;
    max-width: 250px;
    padding: 5px;
    border-radius: 5px;
    -moz-border-radius: 5px;
    -o-border-radius: 5px;
    -webkit-border-radius: 5px;
    border: 2px solid #FFFFFF;
}
</style>

<!-- content -->
<section id="home" data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-sm-6">
                <div class="flexslider" id="flexHome">
                    <ul class="slides">
                        <li>
                            <h1>Lorem ipsum dolor</h1>
                            <h2>consectetur adipisicing elit. Asperiores ipsum</h2>
                        </li>
                        <li>
                            <h1>Lorem ipsum dolor</h1>
                            <h2>consectetur adipisicing elit. Asperiores ipsum</h2>
                        </li>
                        <li>
                            <h1>Lorem ipsum dolor</h1>
                            <h2>consectetur adipisicing elit. Asperiores ipsum</h2>
                        </li>
                    </ul>
                </div> 
            </div>
            <div class="col-lg-5 col-sm-6 hidden-xs">
                <img src="/aib/files/images/theme-pics/home-girl.png" alt="Ashley, Bootstrap website template" class="img-responsive"/>
            </div>
        </div>
    </div>
</section>
<!-- call to action -->
<section class="color4 slice">  
    <div class="ctaBox ctaBoxFullwidth">
        <div class="container">
            <div class="row">
                {{Form::open(array('url'=>'/ventas/code','id'=>'contact-form-confirm','method' => 'post'))}}
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="codigo" class="lbl-txt">Ingresa tu codigo</label>
                        <input type="text" id="txt-code" name="codigo" class="form-control" required placeholder="c&oacute;digo" autocomplete="off" maxlength="5">
                        @if (Session::get('error'))
                            <div class="error">{{Session::get('error')}}</div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-lg"><i class="icon-flash"></i>Confirmar</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</section>
@stop