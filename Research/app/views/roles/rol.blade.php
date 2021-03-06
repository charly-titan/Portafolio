@extends(Config::get( 'app.main_template' ).'.main')


<style type="text/css">

  #colCreateSite,#colCreateRol,#colCreateSection,#colCreatePermission,#errorDominio,#errorName{display: none;}

  i {padding-right: .5em;}

</style>
<input type="hidden" value="{{Config::get('app.locale')}}" id='language-combo'>
@section('content')

<!-- RIBBON -->
<div id="ribbon">
  <ol class="breadcrumb">
    <li><a href="/roles"><i class="fa fa-sitemap"></i>{{Lang::get('roles.title_home')}}</a></li>
    <li><i class="active"></i> {{$name}}</li>
  </ol>
</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">

  <article class="col-sm-6 col-md-12 col-lg-12 sortable-grid ui-sortable" id='col_mdRol'>

    <div class="well well-sm well-light" >
        <p class="alert alert-info">
          <i class="fa fa-list"></i><strong>{{Lang::get('roles.title_homeRol')}}</strong>
          <button class="btn btn-labeled btn-warning pull-right" id='creaRol' data-toggle="button">
           <span class="btn-label">
            <i class="fa fa-plus"></i>
           </span>{{Lang::get('roles.add_rol')}}
          </button>
        </p>

        <div role="content">
        
          @if(Session::has('message')) 
            <div class="alert alert-info" style="text-align: center">
                <p>{{Session::get('message')}}</p>
            </div>       
          @endif

          {{ Form::hidden('name', $name, array('id' => 'name')) }}
          {{ Form::hidden('nameRol', $name, array('id' => 'nameRol')) }}
          {{ Form::hidden('id_site', $id_site, array('id' => 'id_site')) }}
          {{ Form::hidden('id_group', $id_group, array('id' => 'id_group')) }}
          {{ Form::hidden('groupSites', $groupSites, array('id' => 'groupSites')) }}

          <div class="widget-body">

            <div class="table-responsive">
                      
              <table class="table table-hover smart-form" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th colspan="2">
                      <button class="btn btn-labeled btn-primary btn-xs pull-right" id='saveRol' data-toggle="button">
                       <span class="btn-label">
                        <i class="fa fa-save"></i>
                       </span>{{Lang::get('roles.btn_Save')}}
                      </button>
                    </th>
                  </tr>
                </thead>
                <tbody id='tbRol'></tbody>

              </table>          
            </div>

          </div>
      
      </div>
    </div>
</article>

  <article class="col-sm-12 col-md-12 col-lg-4 sortable-grid ui-sortable" id='colCreateRol'>
    
    <div class="well well-sm well-light">
      <p class="alert alert-info">
        <i class="fa fa-plus"></i></i><strong>{{Lang::get('roles.create_rol')}}</strong> 
      </p>

       <section class="widget">
                <div class="body">

                  {{ Form::open(array('url' => 'roles/crearol','id'=>'crearRol')) }}

                              <div class="control-group">
                                 {{ Form::label('name', Lang::get('roles.name')) }}
                                      <div class="controls form-group">

                                        {{ Form::text('name', Input::old('name'), array('class' => 'form-control input-xs','id' => 'InpNameRol','placeholder' => Lang::get('roles.name')) ) }}

                                      <div class="controls form-group" style='padding: .5em;' id='errorName'>
                                        <span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                                      </div>
                                  </div>
                              </div>

                      <div style='text-align: center'>
                        <button  type='button'class="btn btn-labeled btn-success" onclick='valInput()'> <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>{{Lang::get('roles.btn_Saverol')}}</button>
                        <a href="javascript:void(0);" class="btn btn-labeled btn-danger" id='cancelRol'> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>{{Lang::get('roles.btn_Cancel')}}</a>
                      </div>


                  {{ Form::close() }}

                </div>
              </section>
    </div>

  </article>

</div>

@stop


@section('scripts')
 @parent

  {{ HTML::script('js/roles.js') }}
  
   <script type="text/javascript" >

      function valInput(){
          
          var name = $('#InpNameRol').val();

          (name == '') ? $('#errorName').show() : $("#crearRol").submit();
      }
      
</script>  


@stop
  
    
