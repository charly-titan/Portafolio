<?php


class UserSeeder extends Seeder {

	public function run()
	{    

		

			$users_info  = array(
				array(
							'email'      => 'gabriel.mancera@televisatim.com',
							'password'   => substr(md5(sha1("prueba")),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Gabriel'),
							'last_name'  => Crypt::encrypt('Mancera') 
					  ),
				array(
							'email'      => 'mario.rosas@televisatim.com',
							'password'   => substr(md5(sha1("prueba")),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Mario'),
							'last_name'  => Crypt::encrypt('Rosas') 
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
							'email'      => 'alan.martinez@televisatim.com',
							'password'   => substr(md5(sha1("prueba")),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Alan'),
							'last_name'  => Crypt::encrypt('Martinez') 
					  ),
				array(
							'email'      => 'Aldo.huerta@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Aldo'),
							'last_name'  => Crypt::encrypt('Huerta') 
					  ),
				array(
							'email'      => 'beatriz.fernandez@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Beatriz'),
							'last_name'  => Crypt::encrypt('Fernandez') 
					  ),
				array(
							'email'      => 'bernardo.gonzalez@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Bernardo'),
							'last_name'  => Crypt::encrypt('Gonzalez') 
					  ),
				array(
							'email'      => 'cynthia.torres@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Cynthia'),
							'last_name'  => Crypt::encrypt('Torres')
					  ),
				array(
							'email'      => 'emmanuel.delrio@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Emmanuel'),
							'last_name'  => Crypt::encrypt('Del rio')
					  ),
				array(
							'email'      => 'erika.caballero@televisatim.com ',
							'password'   => substr(md5(sha1("prueba")),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Erika'),
							'last_name'  => Crypt::encrypt('Caballero') 
					  ),
				array(
							'email'      => 'estephania.ortiz@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Estephania'),
							'last_name'  => Crypt::encrypt('Ortiz') 
					  ),
				array(
							'email'      => 'evidaurriso@televisa.com.mx',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Evidaurriso'),
							'last_name'  => Crypt::encrypt('') 
					  ),
				array(
							'email'      => 'francisco.briones@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Francisco'),
							'last_name'  => Crypt::encrypt('Briones') 
					  ),
				array(
							'email'      => 'gerardo.moreno@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Gerardo'),
							'last_name'  => Crypt::encrypt('Moreno')
					  ),
				array(
							'email'      => 'german.perez@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('German'),
							'last_name'  => Crypt::encrypt('Perez')
					  ),
				array(
							'email'      => 'jesus.limon@televisatim.com',
							'password'   => substr(md5(sha1("prueba")),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Jesus'),
							'last_name'  => Crypt::encrypt('Limon') 
					  ),
				array(
							'email'      => 'jesus.oliva@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Jesus'),
							'last_name'  => Crypt::encrypt('Oliva') 
					  ),
				array(
							'email'      => 'manuel.orozco@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Manuel'),
							'last_name'  => Crypt::encrypt('Orozco') 
					  ),
				array(
							'email'      => 'marco.tellez@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Marco'),
							'last_name'  => Crypt::encrypt('Tellez') 
					  ),
				array(
							'email'      => 'omar.sierra@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Omar'),
							'last_name'  => Crypt::encrypt('Sierra')
					  ),
				array(
							'email'      => 'romina.gonzalez@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Romina'),
							'last_name'  => Crypt::encrypt('Gonzalez')
					  ),
				array(
							'email'      => 'sandra.calvo@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Sandra'),
							'last_name'  => Crypt::encrypt('Calvo')
					  ),
				array(
							'email'      => 'willebaldo.segura@televisatim.com',
							'password'   => substr(md5(sha1(rand())),0,20),
							'activated'  => true,
							'first_name' => Crypt::encrypt('Willebaldo'),
							'last_name'  => Crypt::encrypt('Segura')
					  )

			);

			foreach ($users_info as $user_info) {
				$count = User::where('email', $user_info["email"])->count();
				if($count==0){
				  $user = Sentry::createUser($user_info);
				  $user = Sentry::findUserByLogin($user_info["email"]);

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
				  $address->city      = 'Mexico';
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
					$groups = Groups::all();
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