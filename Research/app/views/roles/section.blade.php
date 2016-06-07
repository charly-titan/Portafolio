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
    <li><i class="active"></i> {{$nameRol}}</li>
  </ol>
</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">

  <article class="col-sm-6 col-md-12 col-lg-12 sortable-grid ui-sortable" id='col_mdSection'>

    <div class="well well-sm well-light" >
        <p class="alert alert-info">
          <i class="fa fa-list"></i><strong>{{Lang::get('roles.title_homeSection')}}</strong>
          <button class="btn btn-labeled btn-warning pull-right" id='creaSection' data-toggle="button">
           <span class="btn-label">
            <i class="fa fa-plus"></i>
           </span>{{Lang::get('roles.add_section')}}
          </button>
        </p>

         <div role="content">

          {{ Form::hidden('name', $name, array('id' => 'name')) }}
          {{ Form::hidden('id_site', $id_site, array('id' => 'id_site')) }}
          {{ Form::hidden('site', $name.'/'.$id_site.'/'.$id_group.'/'.$nameRol , array('id' => 'rute')) }}
          {{ Form::hidden('site', $site->groups->permissions, array('id' => 'permission')) }}
          {{ Form::hidden('nameRol', $nameRol, array('id' => 'nameRol')) }}
          {{ Form::hidden('id', $site->groups->id, array('id' => 'id')) }}

          <div class="widget-body">

            <div class="table-responsive">
                      
              <table class="table table-hover smart-form" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th>{{Lang::get('roles.name')}}</th>
                  </tr>
                </thead>
                <tbody id='tbSection'></tbody>

              </table>          
            </div>

          </div>

         </div>

    </div>
  </article>


  <article class="col-sm-12 col-md-12 col-lg-4 sortable-grid ui-sortable" id='colCreateSection'>
    
    <div class="well well-sm well-light">
      <p class="alert alert-info">
        <i class="fa fa-plus"></i></i><strong>{{Lang::get('roles.create_section')}}</strong> 
      </p>

      <section class="widget">
            <div class="body">

              {{ Form::open()}}
                  
                  <div class="control-group">
                      {{ Form::label('nameSection', Lang::get('roles.name')) }}
                      <div class="controls form-group">
                            {{ Form::text('nameSection', Input::old('name'), array('class' => 'form-control input-xs','placeholder' => Lang::get('roles.name')) ) }}
                           <div class="controls form-group" style='padding: .5em;' id='errorName'>
                                <span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                           </div>
                      </div>
                  </div>
                  
                  <div  style='text-align: center'>
                      <a class="btn btn-labeled btn-success" id='saveSection'> <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>{{Lang::get('roles.btn_Savesection')}}</a>
                      <a href="javascript:void(0);" class="btn btn-labeled btn-danger" id='cancelSection'> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>{{Lang::get('roles.btn_Cancel')}}</a>
                  </div>   
              {{ Form::close() }}
            </div>
          </section>

    </div>
  </article>

</div>


<script type="text/javascript">
$(document).ready(function() {
    $('input[type=checkbox]').live('click', function(){
        var parent = $(this).parent().attr('id');
        $('#'+parent+' input[type=checkbox]').removeAttr('checked');
        $(this).attr('checked', 'checked');
    });
});
</script>
@stop

@section('scripts')
 @parent
 
  {{ HTML::style('css/roles.css')}}
  {{ HTML::script('js/roles.js') }}
  
@stop