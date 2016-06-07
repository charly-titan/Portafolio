@extends(Config::get( 'app.main_template' ).'.main')


@section('content')
<style type="text/css">
.iu-texto div{font-family: Arial;}




@media screen and (min-width: 648px) and (max-width: 1009px){
.bases{  margin: 0 40px;}	

}

@media all and (max-width: 647px){
	.bases{  margin: 0 10px;}


}
.bases{margin-bottom: 40px;}
</style>

    <article class="left-container">
       	<div class="iu-texto">
           	<div>
               	 <h2 class="title">Bases del concurso</h2>
                <div class="bases">{{$contentBasesConcurso}}</div>
           	</div>
       	</div>
   	</article>
   	
@stop