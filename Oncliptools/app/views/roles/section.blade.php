@extends('vcms.main')

<style type="text/css">

    #colCreateSite,#colCreateRol,#colCreateSection,#colCreatePermission,#errorDominio,#errorName{display: none;}

    i {padding-right: .5em;}

</style>

@section('content')
{{App::setLocale(Session::get('locale'))}}
<div class="row">

        @section('titulo')
          {{Lang::get('roles.title_Section')}}
        @stop

        <section class="widget">
                    <ol class="breadcrumb">
                        <li><a href="/roles"><i class="fa fa-sitemap"></i>{{Lang::get('roles.title_home')}}</a></li>
                        <li><a href=""><i class="fa fa-folder-open-o"></i>{{HTML::link('roles/rolnew/'.$name.'/'.$id_site,$name)}}</a></li>
                         <li><i class="active"></i> {{$nameRol}}</li>
                    </ol>
        </section>

        <div id='dvSection'>
          <div id='col_mdSection' class='col-md-9 col-md-offset-1'>
            <section class='widget'>

              <header>
                    <h4><i class="fa fa-list fa-lg"></i>{{Lang::get('roles.title_homeSection')}}
                          <button class="btn btn-warning btn-sm" id='creaSection' data-toggle="button" style='float: right'>
                              <i class="fa fa-list-ul"><i class="fa fa-plus"></i></i><span class='hidden-xs dropdown'>{{Lang::get('roles.add_section')}}</span>
                          </button>
                    </h4>
              </header>
             
                    <div class='body'>
                          {{ Form::hidden('name', $name, array('id' => 'name')) }}
                          {{ Form::hidden('id_site', $id_site, array('id' => 'id_site')) }}
                          {{ Form::hidden('site', $name.'/'.$id_site.'/'.$id_group.'/'.$nameRol , array('id' => 'rute')) }}
                          {{ Form::hidden('site', $site->groups->permissions, array('id' => 'permission')) }}
                          {{ Form::hidden('nameRol', $nameRol, array('id' => 'nameRol')) }}
                          {{ Form::hidden('id', $site->groups->id, array('id' => 'id')) }}
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>{{Lang::get('roles.name')}}</th>
                          </tr>
                        </thead>

                        <tbody id='tbSection'>  
                        </tbody>
                      </table>
                    </div>
            </section>
          </div>
        </div>

      <!-- CreateSection -->
        <div class="col-md-4" id='colCreateSection'>
          <section class="widget">
            <div class="body">
              <header>
                  <h4><i class="eicon-plus"></i>{{Lang::get('roles.create_section')}}</h4>
              </header>

              {{ Form::open()}}
                  
                  <div class="control-group">
                      {{ Form::label('nameSection', Lang::get('roles.name')) }}
                      <div class="controls form-group">
                          <div class="input-group col-sm-10">
                            {{ Form::text('nameSection', Input::old('name'), array('class' => 'form-control','placeholder' => Lang::get('roles.name')) ) }}
                          </div>
                           <div class="controls form-group" style='padding: .5em;' id='errorName'>
                                <span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                           </div>
                      </div>
                  </div>
                  

                  <div class="form-actions" style='text-align: center'>
                      <a class='btn btn-success btn-sm' id='saveSection'>{{Lang::get('roles.btn_Savesection')}}</a>
                      <a class='btn btn-primary btn-sm' id='cancelSection'>{{Lang::get('roles.btn_Cancel')}}</a>
                  </div>   
              {{ Form::close() }}
            </div>
          </section> 
        </div>
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