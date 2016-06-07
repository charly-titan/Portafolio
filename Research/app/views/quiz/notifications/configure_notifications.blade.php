@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<section id="widget-grid" class="">
		
		<div class="row">

		<h2 class="row-seperator-header"><i class="fa fa-comments"></i> Notificaciones</h2>
						
			<article class="col-xs-6 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable">
							
				<div class="jarviswidget" role="widget">

					<header role="heading">
						<span class="widget-icon"> <i class="fa fa-group"></i> </span>
						<h2>Grupos</h2>	
					</header>

					<div role="content">
						<div class="widget-body">

							<fieldset>
								<div class="form-group">
									<label class="col-md-2 control-label" for="select-1">Grupos</label>
									<div class="col-md-7">
					
										<select class="form-control" id="sel_groups"></select> 
					
									</div>
									<div class="col-md-3">
					
										<button class='btn btn-primary pull-right' type="button" data-toggle='modal' data-target="#myModal"><i class="fa fa-plus"></i> <i class="fa fa-group"></i></button>	
					
									</div>

								</div>

							</fieldset>							
						</div>
					</div>

				</div>

			</article>




			<article class="col-xs-6 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable">
							
				<div class="jarviswidget" role="widget">

					<header role="heading">
						<span class="widget-icon"> <i class="fa fa-user"></i> </span>
						<h2>Usuarios </h2>				
						
					</header>
				
					<div role="content">
						<div class="widget-body">

						<fieldset>
							<div class="form-horizontal form-group">
								<label class="col-md-2 control-label">Usuarios</label>
								<div class="col-md-10">
									@foreach($users as $user)
											
										<div class="checkbox">
											<label>
												<input type="checkbox" class="checkbox style-0 optUser" value='{{Crypt::decrypt($user->first_name)}} {{Crypt::decrypt($user->last_name)}}'>
												<span>{{Crypt::decrypt($user->first_name)}} {{Crypt::decrypt($user->last_name)}}</span>
											</label>
										</div>
											
									@endforeach 
								</div>
							</div>

						</fieldset>
							
						</div>
					</div>

				</div>

			</article>

			<article class="col-xs-6 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable">
							
				<div class="jarviswidget" role="widget">

					<header role="heading">
						<span class="widget-icon"> <i class="fa fa-group"></i> </span>
						<h2>Configuración</h2>				
						
					</header>
				
					<div role="content">
						<div class="widget-body">

							<fieldset>
								<div class="form-group">
								<div class="alert alert-block alert-success">
									<p >Nombre del grupo:  <strong><span id='confNameGroup'></span></strong></p>
								</div>
									<label class="col-md-2 control-label" for="select-1" id='confNameGroup'>Usuarios: </label>
									<div class="col-md-10" id='confUsers'>
					
					
									</div>
								</div>

							</fieldset>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-12" id='btnConfigGroup'></div>
								</div>
							</div>

						</div>
					</div>

				</div>

			</article>




		</div>		
	
	</section>

	<!--******************************************* MODAL  *************************************************-->


	<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" >Nombre del grupo</h4>
	      </div>
	      <div class="modal-body">
	        <form>
	          <div class="form-group">
	            <label for="code-beca" class="control-label">Grupo:</label>
	            <input type="text" class="form-control" id="name-group">
	          </div>
	        </form>
	      </div>
	      <div class="modal-footer">
	        <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" id='saveGroup'>Guardar</button>
	      </div>
	    </div>
	  </div>
	</div>



@stop

@section('scripts')
    @parent
	<script src="https://cdn.firebase.com/js/client/2.4.0/firebase.js"></script>
    
    <script>

    	var myDataRef = new Firebase("https://notificaciones-tim.firebaseio.com/");	
    	var id = "<?php isset($id)? $ids = $id : $ids = ''; print($ids)?>";

    	myDataRef.on("value",function(snapshot){

    		data = snapshot.val();
    		groups = data.groups

    		$("#sel_groups").empty();
    		$("#sel_groups").append($("<option>",{text:"Selecciona un grupo ..."}));

    		


    		if(id){
	    		myDataRef.child('configure_groups').child(id).on('value',function(snapshot){
	    			var data = snapshot.val();
	    			$('#sel_groups option[value="'+data.name_group+'"]').attr('selected','selected');

					$("#confNameGroup").html(data.name_group);
	    			
	    			for (var i = 0; i < data.name_users.length; i++) {
	    				$("input[type='checkbox'][value='"+data.name_users[i]+"']").attr('checked',true);
	    				$("#confUsers").append($("<p>",{text:data.name_users[i]}));
	    			};
	    			
	    			
	    		});
    		}



    	});


    	

    	$("#sel_groups").on("change",function(){
    		$("#confNameGroup").html($(this).val());
    	});


    	users = [];



    	$(".optUser").on("change",function(){


    		$('.optUser:checkbox:checked').each(function() {
				if( $.inArray($(this).val(),users) == -1){
					users.push($(this).val())
				}
			});


    		userName = $(this).val();

    		if($(this).is(":checked")){

    			if( $.inArray(userName,users) == -1){
    				users.push(userName)
    			}
    			
    		}else{
    			users.splice($.inArray(userName, users), 1);
    		}

    		$("#confUsers").empty();

    		for (var i = 0; i < users.length; i++) {	
    			$("#confUsers").append($("<p>",{text:users[i]}));
    		};

    		if($("#confNameGroup").text()){
    			if(users.length>=0){
    				if(!$("#btnConfigGroup").find('button').length){
    					$("#btnConfigGroup").append($("<button>",{id:'saveConfigGroup'}).addClass('btn btn-primary').append($("<i>").addClass('fa fa-save').html(' Guardar configuración')));


		    			$("#saveConfigGroup").on('click',function(){
		    				alert("Guardar")
		    				console.log($("#confNameGroup").text())
		    				console.log(users)
		    				console.log(id)
		    				
		    				if(id){

		    					var userNews = myDataRef.child("configure_groups").child(id);

							  	userNews.update({
								   name_users: users
								});

		    				}else{

		    					var postsRef = myDataRef.child("configure_groups");

			    				var newPostRef = postsRef.push();
				  
								newPostRef.set({
									name_group: $("#confNameGroup").text(),
									name_users: users
								});
		    				}

		    				document.location.href="/notifications";

		    			});

    				}										
    			}
    		}
    		
    	});




		$("#saveGroup").on('click',function(){

			var postsRef = myDataRef.child("groups");
	  
			var newPostRef = postsRef.push();
			  
			newPostRef.set({
				name: $("#name-group").val(),
			});
			

			$('#myModal').modal('hide');
		});

	</script>

@stop