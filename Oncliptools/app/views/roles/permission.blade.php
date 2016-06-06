@extends('vcms.main')

<style type="text/css">

  #colCreateSite,#colCreateRol,#colCreateSection,#colCreatePermission,#errorDominio,#errorName{display: none;}

  i {padding-right: .5em;}

</style>

@section('content')
{{App::setLocale(Session::get('locale'))}}
<div class="row">
  
            @section('titulo')
              {{Lang::get('roles.title_Permission')}}
            @stop


              <section class="widget">
                    <ol class="breadcrumb">
                        <li><a href="/roles"><i class="fa fa-sitemap"></i>{{Lang::get('roles.title_home')}}</a></li>
                        <li><a href=""><i class="fa fa-folder-open-o"></i>{{HTML::link('roles/rolnew/'.$name.'/'.$id_site,$name)}}</a></li>
                        <li><a href=""><i class="fa fa-folder-open-o"></i>{{HTML::link('roles/sectionnew/'.$name.'/'.$id_site.'/'.$id_group.'/'.$nameRol.'/',$nameRol)}}</a></li>
                        <li><i class="active"></i> {{$nameSection}}</li>
                    </ol>
              </section>

              <div id='dvRol'>
                <div id='col_mdPermission' class='col-md-9 col-md-offset-1'>
                  <section class='widget'>
                    <header>
                          <h4><i class="fa fa-list fa-lg"></i>{{Lang::get('roles.title_homePermission')}}
                          <button class="btn btn-warning btn-sm" id='creaPermission' data-toggle="button" style='float: right'>
                              <i class="fa fa-list-ul"><i class="fa fa-plus"></i></i><span class='hidden-xs dropdown'>{{Lang::get('roles.add_permission')}}</span>
                          </button>
                    </h4>
                    </header>

                    <div class='body'>
                             {{ Form::hidden('site', $name.'/'.$id_site.'/'.$nameRol , array('id' => 'rute')) }}
                             {{ Form::hidden('site', $site->groups->permissions, array('id' => 'permission')) }}
                             {{ Form::hidden('nameSection', $nameSection, array('id' => 'nameSection')) }}
                             {{ Form::hidden('id', $id_group, array('id' => 'id')) }}
                             {{ Form::hidden('nameRol', $nameRol, array('id' => 'nameRol')) }}
                             {{ Form::hidden('nameSection', $nameSection, array('id' => 'nameSection')) }}
                             {{ Form::hidden('id_site', $id_site, array('id' => 'id_site')) }}
                             {{ Form::hidden('name', $name, array('id' => 'name')) }}
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>{{Lang::get('roles.name')}}</th>
                            </tr>
                          </thead>
                          <tbody id='tbPermission'>  
                          </tbody>
                        </table>
                    </div>

                  </section>
                </div>
              </div>


          <!-- CreatePermission -->
                <div class="col-md-4" id='colCreatePermission'>
                    <section class="widget">
                        <div class="body">
                            <header>
                              <h4><i class="eicon-plus"></i>{{Lang::get('roles.create_permission')}}</h4>
                            </header>

                            {{ Form::open(array('url' => 'roles/crearpermissions/'.$id_group.'/'.$nameSection,'id'=>'crearPermissions')) }}


                                 <div class="control-group">
                                    {{ Form::label('name', Lang::get('roles.name')) }}
                                    <div class="controls form-group">
                                        <div class="input-group col-sm-10">
                                          {{ Form::text('name', Input::old('name'), array('class' => 'form-control','id' => 'InpNamePermission','placeholder' => Lang::get('roles.name')) ) }}
                                        </div>
                                        <div class="controls form-group" style='padding: .5em;' id='errorName'>
                                          <span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions" style='text-align: center'>
                                {{ Form::button(Lang::get('roles.btn_Savepermission'), array('class' => 'btn btn-success btn-sm','onclick'=>'valInput()')) }}
                                <a class='btn btn-primary btn-sm' id='cancelPermission'>{{Lang::get('roles.btn_Cancel')}}</a>
                                
                                </div>

                            {{ Form::close() }}

                        </div>
                    </section>
                </div>
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
  