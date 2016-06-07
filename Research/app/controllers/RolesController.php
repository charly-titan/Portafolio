<?php

class RolesController extends \BaseController {

	public function __construct()
    {
       $this->beforeFilter('hasAccess:roles.create');
    }

	public function getIndex(){

		$sites = Sites::all();

		return View::make('roles.index')->with('sites',$sites);
	}



	public function getRolnew($name,$id_site){

		$groups = Groups::all();

		$id_group = DB::table('groups_sites_relationships')->select('id_group')->where('id_site', '=', $id_site)->get();


		$groupSites = DB::table('groups')->get(array('name','id'));
    
		return View::make('roles.rol')->with(array('name' => $name,
													'id_site'=> $id_site,
													'id_group'=> json_encode($id_group),
													'groups' => $groups,
													'groupSites'=> json_encode($groupSites)));
	}



	public function postCrearsite(){


		$inputs = Input::all();


		// validate

		$rules = array(
			'name'       => 'required',
			'domain'      => 'required',
		);

		

		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// store Sites
			$site = new Sites;
			$site->name       = Input::get('name');
			$site->domain      = Input::get('domain');
			$site->save();

			return Redirect::back();
		}

	}


	public function getDeletesite($id)
		{
			// delete
			$site = Sites::find($id);
			$site->delete();

			DB::table('groups_sites_relationships')
            ->where('id_site', $id)
            ->delete();

            DB::table('groups_sites_profile_relationships')
            ->where('id_site', $id)
            ->update(array('id_site' => "",'id_group' => ""));
		
			// redirect
			Session::flash('message', 'Successfully deleted the site!');
			return Redirect::to('roles');
		}



	public function postCrearol(){

	 		$site = new Groups;

			$site->name       = Str::title(Input::get('name'));
			$site->save();
	
        return Redirect::back();
	}


	public function getDeleterol($id,$name,$id_site)
	{
		$idGroupSites = GroupSitesRelation::where('id_group','=',$id)->get();


		if(count($idGroupSites) == 0){

			$idGroup = Groups::find($id)->delete();

			return Redirect::back();

		}else{

				$idGroupSitesProf = GroupsSitesProfileRelationships::where('id_group',$id)->where('id_site',$id_site)->get();

				if(count($idGroupSitesProf) != 0){

					return Redirect::back()->with('message','No se puede eliminar esta asignado a un usuario');

					return Redirect::back()->with('message','No se puede eliminar ya esta asignado a un usuario');

				}else{

					$groupSite=  DB::table('groups_sites_relationships')->where('id_group', '=', $id)->where('id_site', '=', $id_site)->get();

					if(count($groupSite) == 0){


						return Redirect::back()->with('message','No se puede eliminar esta asignado a un sitio');
					}else{

						DB::table('groups_sites_relationships')->where('id_group', '=', $id)->where('id_site', '=', $id_site)->delete();
						return Redirect::back();
					}				    
				}
		}

		
	}




	public function postSaverol($id_site){

		if (Request::ajax()) {

				$id_group = Input::get('id_group');

				if($id_group){
					foreach ($id_group as $key) {

						$groupSites = new GroupSitesRelation;

						$groupSites->id_group = $key;
						$groupSites->id_site = $id_site;
						$groupSites->save();
					}
				
					return Response::json("guardado");
				}
				
				
		}

    }



	public function getSectionnew($name,$id_site,$id_group,$rol){

	$group = Groups::find($id_group);
    $site = Sites::find($id_site);

	$site->groups()->associate($group);

		return View::make('roles.section')->with(array('name' => $name,
												   		'id_site'=>$id_site,
												  		'id_group'=>$id_group,
												  		'nameRol'=>$rol,
												  		'site' => $site));
	}


	public function getDeletesection($id,$nameRol,$countSection){


			if($countSection <= 1){
					
					DB::update('UPDATE groups set permissions = "" where id ='.$id);

					return Redirect::back();
			}else{

				$group = Groups::find($id);

				$h = $group->permissions;

					foreach (json_decode($h) as $key => $value) {
						list($section,$permission) = explode(".",$key);

							if($section != $nameRol){
									$data[$key] = $value;	
							}	
					}

						DB::update('UPDATE groups set permissions = "" where id ='.$id);
						
						$group = Sentry::findGroupById($id);				
							$group->permissions = $data;
							$group->save();

						return Redirect::back();
			}					
	}



	


	public function getPermissonnew($name,$id_site,$id_group,$rol,$section){

	$group = Groups::find($id_group);
    $site = Sites::find($id_site);

	$site->groups()->associate($group);


	return View::make('roles.permission')->with(array('name' => $name,'id_site'=>$id_site,'id_group'=>$id_group,'nameRol'=>$rol,'nameSection'=>$section,'site' => $site));

	}



	public function postCrearpermissions($id,$nameSection){


		$id_group = Input::get('name');

				$group = Sentry::findGroupById($id);

			    // Update the group details
			    $group->permissions = array(
				        $nameSection.'.'.strtolower($id_group) => 1,
				     );

			     $group->save();

			     return Redirect::back();

	}






	public function getDeletepermission($id,$namePermission,$countPermission){
	

		if($countPermission <= 1){
				DB::update('UPDATE groups set permissions = "" where id ='.$id);
				return Redirect::back();
		}else{

			$group = Groups::find($id);

			$perm = $group->permissions;



						foreach (json_decode($perm) as $key => $value) {
							if($key != $namePermission){
									$data[$key] = $value;							
							}
						}

						DB::update('UPDATE groups set permissions = "" where id ='.$id);
			
							$group = Sentry::findGroupById($id);
							
								// Update the group details
								$group->permissions = $data;
								$group->save();

					return Redirect::back();
		}
	}



}


