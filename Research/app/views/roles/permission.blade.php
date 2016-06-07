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
    <li><a href=""><i class="fa fa-folder-open-o"></i>{{HTML::link('roles/rolnew/'.$name.'/'.$id_site,$name)}}</a></li>
    <li><a href=""><i class="fa fa-folder-open-o"></i>{{HTML::link('roles/sectionnew/'.$name.'/'.$id_site.'/'.$id_group.'/'.$nameRol.'/',$nameRol)}}</a></li>
    <li><i class="active"></i> {{$nameSection}}</li>
  </ol>
</div>
<!-- END RIBBON -->


<div id="content">

  <article class="col-sm-6 col-md-12 col-lg-12 sortable-grid ui-sortable" id='col_mdPermission'>

    <div class="well well-sm well-light" >
        <p class="alert alert-info">
          <i class="fa fa-list"></i><strong>{{Lang::get('roles.title_homePermission')}}</strong>
          <button class="btn btn-labeled btn-warning pull-right" id='creaPermission' data-toggle="button">
           <span class="btn-label">
            <i class="fa fa-plus"></i>
           </span>{{Lang::get('roles.add_permission')}}
          </button>
        </p>

         <div role="content">
            {{ Form::hidden('site', $name.'/'.$id_site.'/'.$nameRol , array('id' => 'rute')) }}
            {{ Form::hidden('site', $site->groups->permissions, array('id' => 'permission')) }}
            {{ Form::hidden('nameSection', $nameSection, array('id' => 'nameSection')) }}
            {{ Form::hidden('id', $id_group, array('id' => 'id')) }}
            {{ Form::hidden('nameRol', $nameRol, array('id' => 'nameRol')) }}
            {{ Form::hidden('nameSection', $nameSection, array('id' => 'nameSection')) }}
            {{ Form::hidden('id_site', $id_site, array('id' => 'id_site')) }}
            {{ Form::hidden('name', $name, array('id' => 'name')) }}

            <div class="widget-body">

            <div class="table-responsive">
                      
              <table class="table table-hover smart-form" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th>{{Lang::get('roles.name')}}</th>
                  </tr>
                </thead>
                <tbody id='tbPermission'></tbody>

              </table>          
            </div>

          </div>


         </div>
    </div>
  </article>
  <article class="col-sm-12 col-md-12 col-lg-4 sortable-grid ui-sortable" id='colCreatePermission'>
    
    <div class="well well-sm well-light">
      <p class="alert alert-info">
        <i class="fa fa-plus"></i></i><strong>{{Lang::get('roles.create_permission')}}</strong> 
      </p>

      <section class="widget">
            <div class="body">

              {{ Form::open(array('url' => 'roles/crearpermissions/'.$id_group.'/'.$nameSection,'id'=>'crearPermissions')) }}


                <div class="control-group">
                  {{ Form::label('name', Lang::get('roles.name')) }}
                  <div class="controls form-group">
                      {{ Form::text('name', Input::old('name'), array('class' => 'form-control input-xs','id' => 'InpNamePermission','placeholder' => Lang::get('roles.name')) ) }}
                    <div class="controls form-group" style='padding: .5em;' id='errorName'>
                      <span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                    </div>
                  </div>
                </div>

                <div class="form-actions" style='text-align: center'>
                  
                   <button  type='button'class="btn btn-labeled btn-success" onclick='valInput()'> <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>{{Lang::get('roles.btn_Savepermission')}}</button>
                      <a href="javascript:void(0);" class="btn btn-labeled btn-danger" id='cancelPermission'> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>{{Lang::get('roles.btn_Cancel')}}</a>
                                
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
          
          var name = $('#InpNamePermission').val();

          (name == '') ? $('#errorName').show() : $("#crearPermissions").submit();
      }
      
</script>  


@stop
  