@extends('vcms.main')

@section('content')
{{App::setLocale(Session::get('locale'))}}

<div class="row">
    <div class='col-md-12'>

        <section class='widget'>
            <header>
                <h4>
                    <i class="fa fa-users"></i>
                    {{Lang::get('formUserPermission.title')}}
                </h4>
            </header>

            <div class="row">

                {{Form::open()}}

                <div class="col-md-3">
                    <div class="form-group body no-margin">
                        <header>
                            <h5>
                                <i class="fa fa-list-ol"></i>
                                <strong>{{Lang::get('formUserPermission.sites')}}</strong>  
                            </h5>
                        </header>

                        {{ Form::select('selectSite[]', $sites, null, ['id' => 'selectSite','class' => 'chzn-select select-block-level','multiple']) }}
                    </div>                            
                </div>

                <div class="col-md-3">
                    <div class="form-group body no-margin">
                        <header>
                            <h5>
                                <i class="fa fa-list-ol"></i>
                                <strong>Roles</strong>
                            </h5>
                        </header>
                        {{ Form::select('selectRol[]',$groups, null, ['id' => 'selectRol','class' => 'chzn-select select-block-level','multiple']) }}
                    </div> 
                </div>
                <br>

                <div class="col-md-5">
                    <div class="body text-align-center">
                        <div class="well">
                            <div class="row">

                                <button type='button' class='btn btn-sm btn-primary' id='btnSearch'>
                                    <i class='fa fa-search fa-lg'></i><span class='hidden-xs dropdown'> {{Lang::get('formUserPermission.search')}}</span>
                                </button>

                                {{Form::close()}}
                                <a href="userPermission" class='btn btn-sm btn-default'>
                                    <i class='fa fa-eraser fa-lg'></i><span class='hidden-xs dropdown'> {{Lang::get('formUserPermission.clear')}}</span>
                                </a>
                                <a href="userPermission/formaccount" class='btn btn-sm btn-warning'>
                                    <i class='fa eicon-user-add fa-lg'></i><span class='hidden-xs dropdown'> {{Lang::get('formUserPermission.add_user')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </section>

        @if (Session::has('message'))
        <div class="alert alert-info" style='text-align: center'>{{ Session::get('message') }}</div>
        @endif

        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-list-ol"></i>
                    {{Lang::get('formUserPermission.title_table')}}
                </h4>
            </header>

            <table class="table table-striped table-editable no-margin" id='tablePermissions'>
                <thead >
                    <tr>
                        <th>
                            <a>{{Lang::get('formUserPermission.first_name')}}<b class="sort-caret"></b></a>
                        </th>
                        
                        <th class='hidden-xs dropdown'>
                            <a>{{Lang::get('formUserPermission.gender')}}<b class="sort-caret"></b></a>
                        </th>
                        
                        <th class='hidden-xs dropdown'>
                            <a>{{Lang::get('formUserPermission.date_login')}}<b class="sort-caret"></b></a>
                        </th>
                        
                        <th><a>Roles<b class="sort-caret"></b></a></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody class="table table-striped table-editable no-margin" id='datosTable' >

                    @foreach ($profiles as $valProfile  => $value )
                        <tr>
                            <td class="string-cell">{{Crypt::decrypt($value->first_name) }}</td>
                            <td class="string-cell hidden-xs dropdown">{{$value->gender}}</td>
                            <td class="string-cell hidden-xs dropdown">{{$value->created_at}}</td>
                            <td class="string-cell">{{$value->name}}</td>
                            <td class="input-group-btn">
                                {{ HTML::link('userPermission/editprofile/'.$value->id_users,'',array('class' => 'btn btn-warning glyphicon glyphicon-edit')) }}
                                {{ HTML::link('userPermission/deleteprofile/'.$value->id_users,'',array('class' => 'btn btn-danger delete glyphicon glyphicon-remove','onclick' => "return message()")) }}
                            </td>
                        </tr> 
                    @endforeach    

                </tbody>
            </table>
        </section>               

    </div>
</div>

@stop

@section('scripts')
@parent

{{ HTML::style('css/formAccount.css')}}
{{ HTML::style('css/jquery.dataTables.css')}}   
{{ HTML::script('js/userPermissions.js') }}
{{ HTML::script('js/jquery.dataTables.js') }}


<script type="text/javascript">

    var lang = $("#language-combo").val();

    if (lang == 'es') {
        var msgSite = 'Selecciona uno o mas Sitios',
                msgRol = 'Selecciona uno o mas Roles';
    } else {
        var msgSite = 'Select one or more Sites',
                msgRol = 'Select one or more Roles';
    }

    $("#selectSite").select2({
        placeholder: msgSite,
        allowClear: true
    });
    $("#selectRol").select2({
        placeholder: msgRol,
        allowClear: true
    });

    function message() {

        var lang = $("#language-combo").val();

        if (lang == 'es') {
            var msg = '¿Está seguro de que lo desea eliminar?'
        }
        if (lang == 'en') {
            var msg = 'Are you sure you want to delete?'
        }

        var msgs = confirm(msg);

        if (msgs == false) {
            return false;
        }
    }

</script>

@stop