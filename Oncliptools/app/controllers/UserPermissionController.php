<?php

class UserPermissionController extends \BaseController {

	public function __construct()
    {
       $this->beforeFilter('hasAccess:users.create');
    }

	public function getIndex()
	{
		 

		$sites = Sites::lists('name','id_site');
		$groups = Groups::lists('name','id');

		$users = DB::select('SELECT id as id_users, first_name,"" as gender,created_at,"" as name from users where id not in (select id_users from profiles)');
		//$users = DB::select('SELECT id as id_profile, first_name,"" as gender,created_at,"" as name from users');

        $profiles = DB::table('groups_sites_profile_relationships AS gsp')
				        ->leftJoin('groups AS g', 'gsp.id_group', '=', 'g.id')
				        ->leftJoin('profiles AS p','gsp.id_profile','=','p.id_profile')
				        ->groupBy('p.id_profile')
				        ->get(array('p.id_users','p.first_name','p.gender','p.created_at',DB::Raw('group_concat(distinct g.name) as name')));

        		$arrayUser = array();

				foreach ($users as $key) {
					
					$data = new stdClass();
					
					$data->id_users = $key->id_users;
					$data->first_name = Crypt::encrypt($key->first_name);
					$data->gender = $key->gender;
					$data->created_at = $key->created_at;
					$data->name = $key->name;
					
					$arrayUser[] = $data;
				}



				$allProfiles = array_merge($profiles,$arrayUser);


		return View::make('userPermission.index')->with(array('sites'=>$sites,'groups'=>$groups,'profiles'=>$allProfiles));
	
	}



	
	public function postFiltsite(){

		if (Request::ajax()) {

			$selSite = Input::get('selSite');
			$selRol = Input::get('selRol');

			$roles = DB::table('groups_sites_profile_relationships')->whereIn('id_site', $selSite)->groupBy('id_profile')->lists('id_profile');

			$gr = Profiles::whereIn('id_profile', $roles)->get(array('id_profile','first_name','gender'));

			$datos = [];

				foreach ($gr as $key) {
					$datos['id_profile'] = $key->id_profile;
					$datos['first_name'] = Crypt::decrypt($key->first_name);
					$datos['gender'] = $key->gender;
				}

				return Response::json($datos);	
		}
	}



	public function getFormaccount(){
		
		$sites = Sites::all();
		


		$site = ['.......'];


		foreach ($sites as $key) {
			 $site[$key->id_site] = $key->name;
		}

		return View::make('userPermission.formAccount')->with(array('sites'=>$site));

	}




	public function postFormaccount(){

		$inputs = Input::all();

		$accountPermission = Input::get('accountPerm');
		
		$rules = array(
			'first_name' => 'required|min:3|max:20',
			'last_name' => 'required|min:3|max:20',
			'gender'   => 'required|in:male,female',
			'password' => 'required|min:5|max:20',
			'password_repeat' => 'required|same:password',
			'birthdate' => 'required|date',
			'email' => 'required|email|min:5|max:100|unique:users,email',
			'phone' => 'required|numeric|regex:/[0-9]{10,11}/',
			'address' => 'required|max:100',
			'city' => 'required',
			'zip_code' => 'required|numeric|regex:/[0-9]{4,5}/',
			'state' => 'required',
			'country' => 'required',
			);


			$validate = Validator::make($inputs, $rules);

			if($validate->fails()){
				
					return Redirect::back()->withInput()->withErrors($validate)->with(array('msg'=>'You need to assign permit..','inputCheck'=>Input::get('gender')));
				
			}else if($accountPermission==''){

				return Redirect::back()->withInput()->withErrors($validate)->with(array('msg'=>'You need to assign permit..','inputCheck'=>Input::get('gender')));
			}
			else{

				$user = Sentry::createUser(array(
				        'email'      => Input::get('email'),
				        'password'   => Input::get('password'),
				        'activated'  => true,
				        'first_name' => Crypt::encrypt(Input::get('first_name')),
				        'last_name'  => Crypt::encrypt(Input::get('last_name')), 
				    	));

				$profile = new Profiles;

						$day_old = Input::get('birthdate');
						$new_day = date("Y-m-d", strtotime($day_old));	

						$profile->id_users      = $user->id;
						$profile->first_name    = Crypt::encrypt(Input::get('first_name'));
						$profile->last_name     = Crypt::encrypt(Input::get('last_name'));
						$profile->birthdate     = $new_day;
						$profile->gender      	= Input::get('gender');
						$profile->phone      	= Crypt::encrypt(Input::get('phone'));
						$profile->fax      		= Crypt::encrypt(Input::get('fax'));
						$profile->save();

				
				$address = new Address;
				
				$prof = Profiles::all()->last();
				$idProfile = $prof->id_profile;
				

							$address->address 	=  Crypt::encrypt(Input::get('address'));
							$address->city 		=  Input::get('city');
							$address->zip_code 	=  Input::get('zip_code');
							$address->state 	=  Input::get('state');
							$address->country 	=  Input::get('country');
							$address->save();

				$GroupsProfileAddressRelationships = new GroupsProfileAddressRelationships;

							$GroupsProfileAddressRelationships->id_profile = $idProfile;
							$GroupsProfileAddressRelationships->id_address = $address->id_address;
							$GroupsProfileAddressRelationships->save();


				foreach ($accountPermission as $accountSite => $value) {
					foreach ($value as $accountPermission) {

						$GroupsSitesProfileRelationships = new GroupsSitesProfileRelationships;

							$GroupsSitesProfileRelationships->id_site = $accountSite;
							$GroupsSitesProfileRelationships->id_group = $accountPermission;
							$GroupsSitesProfileRelationships->id_profile = $idProfile;
							$GroupsSitesProfileRelationships->save();
					}
				}

				return Redirect::to('userPermission');
	        }
	}


	


	public function postSelectsite(){

		if (Request::ajax()) {

			$idSite = Input::get('selectSite');

			$idGroups = GroupSitesRelation::where('id_site',$idSite)->get();

	
			$ids = array();

			foreach($idGroups as $idGroup)
			{
				array_push($ids, $idGroup->id_group);
			}

            if(count($ids)!=0){

            	$groups = DB::table('groups')
                    ->whereIn('id', $ids)->get();

				return Response::json($groups);
			}else{
				return Response::json("null");
			}
		}

	}

	public function getDeleteprofile($id){

	$affected = DB::delete('DELETE p,u,gsa,a,gsp from `profiles` p LEFT JOIN users u on (p.id_users=u.id) 
	LEFT JOIN groups_profile_address_relationships gsa on p.id_profile = gsa.id_profile
	LEFT JOIN address a on a.id_address = gsa.id_address
	LEFT JOIN groups_sites_profile_relationships gsp on gsp.id_profile = gsa.id_profile where p.id_users = ?', array($id));

	return Redirect::to('userPermission');

	}





	public function getDeletepermission($idPermission,$idUser,$idSite){


		$idgsp = DB::table('groups_sites_profile_relationships as gsp')
					->leftJoin('profiles AS p', 'gsp.id_profile', '=', 'p.id_profile')
					->where('id_users','=',$idUser)
					->where('id_group','=',$idPermission)
					->where('id_site','=',$idSite)
					->lists('id_group_site_profile_relationship');

					DB::table('groups_sites_profile_relationships')
            			->whereIN('id_group_site_profile_relationship', $idgsp)
            			->update(array('id_group' => '','id_site' => ''));

        try{
		    // Find the user using the user id
		    $user = Sentry::findUserById($idUser);
		    // Find the group using the group id
		    $adminGroup = Sentry::findGroupById($idPermission);
		    //  remove the group to the user
		    if ($user->removeGroup($adminGroup)){
		        // Group removed successfully
		        return Redirect::to('userPermission/editprofile/'.$idUser);
		    }
		    
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e){
		    echo 'User was not found.';
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e){
		    echo 'Group was not found.';
		}

		

	}



	public function getEditprofile($id){


		$countProfile = Profiles::find($id);

		if($countProfile == null){

			$user = DB::select("SELECT id as id_users,first_name,last_name,'' as gender,'' as birthdate, email,'' as phone, '' as fax, '' as address, '' as city, '' as zip_code, '' as state,'' as country
				                from users where id = ".$id); 

			$perfil = array();

				foreach ($user as $key) {
					
					$data = new stdClass();
					
					$data->id_users = $key->id_users;
					$data->first_name = Crypt::encrypt($key->first_name);
					$data->last_name = Crypt::encrypt($key->last_name);
					$data->gender = $key->gender;
					$data->birthdate = $key->birthdate;
					$data->email = $key->email;
					$data->phone = Crypt::encrypt($key->phone);
					$data->fax = Crypt::encrypt($key->fax);
					$data->address = Crypt::encrypt($key->address);
					$data->city = $key->city;
					$data->zip_code = $key->zip_code;
					$data->state = $key->state;
					$data->country = $key->country;
					$perfil[] = $data;
				}

				$perfilPermission = [];

			
		}else{
			
				$perfil = DB::table('groups_sites_profile_relationships AS gsp')
					        ->leftJoin('groups AS g', 'gsp.id_group', '=', 'g.id')
					        ->leftJoin('profiles AS p','gsp.id_profile','=','p.id_profile')
					        ->leftJoin('users AS u','u.id','=','p.id_users')
					        ->leftJoin('groups_profile_address_relationships AS gpa','gpa.id_profile','=','p.id_profile')
					        ->leftJoin('address AS a','a.id_address','=','gpa.id_address')
					        ->where('p.id_users','=',$id)
					        ->get(array('p.id_users','p.first_name','p.last_name','p.gender','p.birthdate','u.email','p.phone','p.fax','a.address','a.city','a.zip_code','a.state','a.country'));

					  
			$perfilPermission = DB::table('groups_sites_profile_relationships AS gsp')
					        ->leftJoin('sites AS s', 'gsp.id_site', '=', 's.id_site')
					        ->leftJoin('groups AS g','gsp.id_group','=','g.id')
					        ->leftJoin('profiles AS p','p.id_profile','=','gsp.id_profile')
					        ->where('p.id_users','=',$id)
					        ->groupBy('id_site')
					        ->get(array('s.id_site',DB::Raw('group_concat(distinct s.name) as nameSite'),DB::Raw('group_concat(distinct g.id) as id'),DB::Raw('group_concat(distinct g.name) as nameGroup')));
  
 			}

		$sites = Sites::all();
		$groups = Groups::all();


		$site = array(0 => 'Selecciona un sitio') + $sites->lists('name','id_site');

		$site = array('' => '') + $sites->lists('name','id_site');

		$group = $groups->lists('name','id');

 		return View::make('userPermission.formAccountUpdate')->with(array('profiles'=>$perfil,'perfilPermission'=>json_encode($perfilPermission),'sites'=>$site,'groups'=>$group));

	}


	public function postEditprofile($id){

		$numPerm = DB::select('SELECT * from groups_sites_profile_relationships where id_profile = '.$id.' and (id_group!="" or id_site!="")');

		$inputs = Input::all();
		$accountPermission = Input::get('accountPerm');


		$day_old = Input::get('birthdate');
		$new_day = date("Y-m-d", strtotime($day_old));	

		$rules = array(
			'first_name' => 'required|min:3|max:20',
			'last_name'  => 'required|min:3|max:20',
			'gender'        => 'required|in:male,female',
			'birthdate'  => 'required|date',
			'email'      => 'required|email|min:5|max:100',
			'phone'      => 'required|numeric|regex:/[0-9]{10,11}/',
			'address'    => 'required|max:100',
			'city'       => 'required',
			'zip_code'   => 'required|numeric|regex:/[0-9]{4,5}/',
			'state'      => 'required',
			'country'    => 'required',
		);

		$validate = Validator::make($inputs, $rules);

			if($validate->fails()){
				return Redirect::back()->withInput()->withErrors($validate)->with(array('msg'=>'You need to assign permit..','inputCheck'=>Input::get('gender')));

			}else if($accountPermission == null && count($numPerm) == 0){

				return Redirect::back()->withInput()->withErrors($validate)->with(array('msg'=>'You need to assign permit..','inputCheck'=>Input::get('gender')));
			}
			else{

				$countProfile = Profiles::find($id);

				if($countProfile == null){

					$profile = new Profiles;

						$profile->id_users  = $id;
						$profile->save();

						$prof = Profiles::all()->last();
						$idProfile = $prof->id_profile;

					$address = new Address;

						$address->save();

					$GroupsProfileAddressRelationships = new GroupsProfileAddressRelationships;

								$GroupsProfileAddressRelationships->id_profile = $idProfile;
								$GroupsProfileAddressRelationships->id_address = $address->id_address;
								$GroupsProfileAddressRelationships->save();

				}else{
						$idProfile = DB::table('profiles')->where('id_users','=',$id)->lists('id_profile');
	  					$idProfile = (string) array_shift($idProfile);		
				}


					$profile = Profiles::find($idProfile);


							$profile->first_name    = Crypt::encrypt(Input::get('first_name'));
							$profile->last_name     = Crypt::encrypt(Input::get('last_name'));
							$profile->birthdate     = $new_day;
							$profile->gender      	= Input::get('gender');
							$profile->phone      	= Crypt::encrypt(Input::get('phone'));
							$profile->fax      		= Crypt::encrypt(Input::get('fax'));
							$profile->save();

				


					$user = Sentry::findUserById($id);

							$user->first_name    =  Crypt::encrypt(Input::get('first_name'));
							$user->last_name     =  Crypt::encrypt(Input::get('last_name'));
							$user->email     	 = Input::get('email');
							$user->save();

					$idAddress = DB::table('groups_profile_address_relationships')
					        ->distinct()
					        ->where('id_profile',$idProfile)
					        ->lists('id_address');


							$idAddress = array_shift($idAddress);

					$address = Address::find($idAddress);

							$address->address 	=  Crypt::encrypt(Input::get('address'));
							$address->city 		=  Input::get('city');
							$address->zip_code 	=  Input::get('zip_code');
							$address->state 	=  Input::get('state');
							$address->country 	=  Input::get('country');
							$address->save();



							if($accountPermission){


							$numProfile = DB::table('groups_sites_profile_relationships')
											->where('id_profile','=',$idProfile)
											->where('id_site','=',0)
											->where('id_group','=',0)
											->delete();

								foreach ($accountPermission as $accountSite => $value) {
									foreach ($value as $accountPermission) {

										$GroupsSitesProfileRelationships = new GroupsSitesProfileRelationships;

											$GroupsSitesProfileRelationships->id_site = $accountSite;
											$GroupsSitesProfileRelationships->id_group = $accountPermission;
											$GroupsSitesProfileRelationships->id_profile = $idProfile;
											$GroupsSitesProfileRelationships->save();
									}
								}
							


							}						


				return Redirect::to('userPermission');
								

			}
	}




	public function postSelectsiterol(){

		if (Request::ajax()) {

			$idSite = Input::get('selectSite');

			$groups = DB::table('groups_sites_relationships AS gs')
				        ->leftJoin('groups AS g', 'gs.id_group', '=', 'g.id')
				        ->whereIn('gs.id_site',$idSite)
				        ->groupBy('g.name')
				        ->get(array('gs.id_group','g.name'));

			return Response::json($groups);

		}

	}

	public function postSearchsitegroup(){

		if (Request::ajax()) {

			$idSite = Input::get('site');
			$idgroup = Input::get('group');

		if($idSite && $idgroup==''){
			$result = GroupsSitesProfileRelationships::distinct()->whereIn('id_site',$idSite)->lists('id_profile');
		}
		if($idgroup && $idSite==''){
			$result = GroupsSitesProfileRelationships::distinct()->whereIn('id_group',$idgroup)->lists('id_profile');
		}
		if($idgroup && $idSite){
			$result = GroupsSitesProfileRelationships::distinct()->whereIn('id_site',$idSite)->whereIn('id_group',$idgroup)->lists('id_profile');
		}
		if($idgroup=='' && $idSite==''){
			$result = 'Debes seleccionar al menos un filtro';
		}

		if(count($result) == 0){
			$result = [''];
		}


		$profiles = DB::table('groups_sites_profile_relationships AS gsp')
				        ->leftJoin('groups AS g', 'gsp.id_group', '=', 'g.id')
				        ->leftJoin('profiles AS p','gsp.id_profile','=','p.id_profile')
				        ->whereIn('p.id_profile',$result)
				        ->groupBy('p.id_profile')
				        ->get(array('p.id_profile','p.first_name','p.gender','p.birthdate','p.created_at',DB::Raw('group_concat(distinct g.name) as name')));

				        if($profiles){

				        	$i=0;
						       	foreach ($profiles as $key) {

						       			 $data[$i]['id_profile'] = $key->id_profile;
						       			 $data[$i]['first_name'] = Crypt::decrypt($key->first_name);
						       			 $data[$i]['gender'] = $key->gender;
						       			 $data[$i]['created_at'] = $key->created_at;
						       			 $data[$i]['name'] = $key->name;
						       	$i++;	
						       	}
						       	return Response::json($data);
				        }else{
				        		return Response::json(null);
				        }
						
			
		}

	}

}
