@extends(Config::get( 'app.main_template' ).'.main')


@section('content')
<style type="text/css">
.iu-texto div{font-family: Arial;}
</style>

    <article class="left-container">
       	<div class="iu-texto">
           	<div>
               	 <h2 class="title">Bases del concurso</h2>
                <div >{{isset($contentBasesConcurso)?$contentBasesConcurso:''}}</div>
           	</div>
       	</div>
   	</article>
   	
@stop