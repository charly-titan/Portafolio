<?php


class UserSeeder extends Seeder {

	public function run()
	{    

		

			$users_info  = array(
				array(
							'email'      => 'gabriel.mancera@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Gabriel'),
							'last_name'  => Crypt::encrypt('Mancera') 
					  ),
				array(
							'email'      => 'elsa.salinas@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Elsa'),
							'last_name'  => Crypt::encrypt('Salinas') 
					  ),
				array(
							'email'      => 'apps@esmas.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Apps'),
							'last_name'  => Crypt::encrypt('Televisatim') 
					  ),
				array(
							'email'      => 'roberto.bautista@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Roberto'),
							'last_name'  => Crypt::encrypt('Bautista') 
					  ),
				array(
							'email'      => 'edgar.martinez@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Edgar'),
							'last_name'  => Crypt::encrypt('Martinez')
					  ),
				array(
							'email'      => 'juan.dominguez@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Juan Carlos'),
							'last_name'  => Crypt::encrypt('Dominguez')
					  ),
				array(
							'email'      => 'mario.rosas@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Mario'),
							'last_name'  => Crypt::encrypt('Rosas')
					  ),
				array(
							'email'      => 'francisco.villegas@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Francisco'),
							'last_name'  => Crypt::encrypt('Villegas')
					  ),
				array(
							'email'      => 'zurisadai.ordonez@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Zuridadai'),
							'last_name'  => Crypt::encrypt('Ordoñez')
					  ),
				array(
							'email'      => 'yessenia.delossantos@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Yessenia'),
							'last_name'  => Crypt::encrypt('de los Santos')
					  ),
				array(
							'email'      => 'luis.renedo@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Luis'),
							'last_name'  => Crypt::encrypt('Renedo')
					  ),
				array(
							'email'      => 'omar.carpinteyro@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Omar'),
							'last_name'  => Crypt::encrypt('Carpinteyro')
					  ),
				array(
							'email'      => 'jose.viveros@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Jose'),
							'last_name'  => Crypt::encrypt('Viveros')
					  ),
				array(
							'email'      => 'tmoralesc@televisa.com.mx',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Tatiana'),
							'last_name'  => Crypt::encrypt('Morales')
					  ),
				array(
							'email'      => 'christian.pedraza@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Christian'),
							'last_name'  => Crypt::encrypt('Pedraza')
					  ),
				array(
							'email'      => 'christian.pedraza@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Christian'),
							'last_name'  => Crypt::encrypt('Pedraza')
					  ),
				array(
							'email'      => 'hector.merino@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Hector'),
							'last_name'  => Crypt::encrypt('Merino')
					  ),
				array(
							'email'      => 'oel.soto@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Joel'),
							'last_name'  => Crypt::encrypt('Soto')
					  )
				
			);

			//cambio

			foreach ($users_info as $user_info) {
				$count = User::where('email', $user_info["email"])->count();
				if($count==0){
				  $user = Sentry::createUser($user_info);
				  $user = Sentry::findUserByLogin($user_info["email"]);
    			  $user->google2fa_secret = Google2FA::generateSecretKey();
    			  $user->save();

				  $profile = new Profiles;
				  $profile->id_users = $user->id;
				  $profile->first_name = $user_info["first_name"];
				  $profile->last_name  = $user_info["last_name"];
				  $profile->birthdate  = '';
				  $profile->gender     = '';
				  $profile->phone      = Crypt::encrypt('52612000');
				  $profile->fax        = Crypt::encrypt('52612000');
				  $profile->save();
				  $profile_id = $profile->id_profile;

				  $address = new Address;
				  $address->address   = Crypt::encrypt('Av. Vasco de Quiroga 2000 Col. Santa Fe');
				  $address->city      = 'México';
				  $address->zip_code  = '01210';
				  $address->state     = 'Distrito Federal';
				  $address->country   = 'México';
				  $address->save();
				  $address_id = $address->id_address;
				  
				  $group_profile = new GroupsProfileAddressRelationships;
				  $group_profile->id_profile = $profile_id;
				  $group_profile->id_address = $address_id;
				  $group_profile->save();


				  $sites = Sites::all();
				  foreach ($sites as $site) {
					$groups = DB::table('groups')->take(1)->get();
						foreach ($groups as $group) {
							$group_site = new GroupsSitesProfileRelationships;
							$group_site->id_site    = $site->id_site;
							$group_site->id_group   = $group->id;
							$group_site->id_profile = $profile_id;
							$group_site->save();
						}
					}
				}/* count users == 0 */
			}
			
			   



		
	}

}

?>