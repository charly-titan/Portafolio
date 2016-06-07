@extends(Config::get( 'app.main_template' ).'.iab.main')

@section('content')

<style>

.body-div{ background-color: #2095CB; }
.container{
  width: 100%;
  margin: 0px;
}
.error-template{
  min-height: 400px;
}
.error-div{ 
  color: #FFF;
  width: 90%;
  margin: 0px auto;
  text-align: center;
}
.back{
  padding-bottom: 25px;
  background-image: url('/aib/files/images/theme-pics/paralax-blue-2.jpg')  
}
img.center{ margin: 0 auto; }
.title{ 
  font-size: 150px;
  color: #FFFFFF;
  padding-bottom: 10px;
  }
  .text-white{ color: #FFFFFF; font-weight: inherit;}
.logo{ height: auto; overflow: hidden;}
.logo h1{ color: #FFFFFF; padding-top: 15px;}
.text-muted{ color: #FFFFFF;}
.navbar-brand{ position: relative;}
.navbar-brand img{ position: absolute; top: 15px; }
</style>

<div class="back">
  <div class="container ">
    <div class="row ">
      <div class="col-lg-10 col-lg-offset-1 text-center">
        <div class="inner-section">
            <!--  logo section  -->
            <div class="logo">
                <!--<a href=""><img src="images/" alt=""></a>-->
                <h1 class="text-white">Oops!</h1>
                <img class="img-responsive center" src="/aib/files/images/404-1.png" alt="page not found" >
            </div>
            <!--clear fix-->
            <div class="clearfix"></div>
            <br /><br />
            <h1 class="text-white">Página no encontrada.</h1>
            <br /><br />
            <!--clear fix-->
            <div class="clearfix"></div>
            <br />
            <div class="col-lg-6  col-lg-offset-3 ">
                <div class="btn-group btn-group-justified">
                    <a href="" class="btn btn-primary">Regresar</a>
                    <a href="" class="btn btn-success">Inicio</a>
                </div>
            </div>
        </div><!--end inner-section-->
      </div>
    </div><!--end row-->
  </div>    <!--end container-->
</div><!--end body section-->

@stop
