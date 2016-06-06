@extends('vcms.main')

<style type="text/css">

  #colCreateSite,#colCreateRol,#colCreateSection,#colCreatePermission,#errorDominio,#errorName{display: none;}

  i {padding-right: .5em;}

</style>

@section('content')
{{App::setLocale(Session::get('locale'))}}
<div class="row">

        @section('titulo')
          {{Lang::get('roles.title_Rol')}}
        @stop

        <section class="widget">
                    <ol class="breadcrumb">
                        <li><a href="/roles"><i class="fa fa-sitemap"></i>{{Lang::get('roles.title_home')}}</a></li>
                        <li><i class="active"></i> {{$name}}</li>
                    </ol>
        </section>


        <!-- ROL --> 
          <div id='dvRol'>
            <div id='col_mdRol' class='col-md-9 col-md-offset-1'>
              <section class='widget'>
                  <header>
                      <h4><i class="fa fa-list fa-lg"></i>{{Lang::get('roles.title_homeRol')}}
                          <button class="btn btn-warning btn-sm" id='creaRol' data-toggle="button" style='float: right'>
                              <i class="fa fa-list-ul"><i class="fa fa-plus"></i></i><span class='hidden-xs dropdown'>{{Lang::get('roles.add_rol')}}</span>
                          </button>
                      </h4>
                  </header>
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


                  <div class='body'>
                      <table class="table table-striped" id='formRol'>
                          <thead>
                            <tr>
                              <th>{{Lang::get('roles.name')}}</th>

                            </tr>
                          </thead>
                          <tbody id='tbRol'></tbody>       
                      </table>
                  </div>
                  <section >
                      <a class='btn btn-primary' id='saveRol'>{{Lang::get('roles.btn_Save')}}</a>
                  </section>
              </section>
            </div>
          </div>


          <!-- CreateRol -->
          <div class="col-md-4" id='colCreateRol'>
            <section class="widget">
              <div class="body">
                <header>
                    <h4><i class="eicon-plus"></i>{{Lang::get('roles.create_rol')}}</h4>
                </header>


                {{ Form::open(array('url' => 'roles/crearol','id'=>'crearRol')) }}

                            <div class="control-group">
                               {{ Form::label('name', Lang::get('roles.name')) }}
                                    <div class="controls form-group">
                                    <div class="input-group col-sm-10">
                                      {{ Form::text('name', Input::old('name'), array('class' => 'form-control','id' => 'InpNameRol','placeholder' => Lang::get('roles.name')) ) }}
                                    </div>
                                    <div class="controls form-group" style='padding: .5em;' id='errorName'>
                                      <span class="badge badge-danger">{{Lang::get('roles.errorFieldEmpty')}}</span>
                                    </div>
                                </div>
                            </div>

                    <div class="form-actions" style='text-align: center'>
                      {{ Form::button(Lang::get('roles.btn_Saverol'), array('class' => 'btn btn-success btn-sm','onclick'=>'valInput()')) }}
                      <a class='btn btn-primary btn-sm' id='cancelRol'>{{Lang::get('roles.btn_Cancel')}}</a>
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
          
          var name = $('#InpNameRol').val();

          (name == '') ? $('#errorName').show() : $("#crearRol").submit();
      }
      
</script>  


@stop
  
    
