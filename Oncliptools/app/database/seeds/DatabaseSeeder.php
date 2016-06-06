<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        //insertamos los sitios
        $this->call('SiteSeeder');
        $this->command->info('Site table seeded!');
		//insertamos los usuarios
        $this->call('UserSeeder');
        $this->command->info('User table seeded!');
        
        //insertamos en tabla de signals
        $this->call('SignalsTableSeeder');
        //muestra mensaje de guardao con exito
        $this->command->info('Signals table seeded!');

        $this->call('ChannelsSeeder');
        //muestra mensaje de guardao con exito
        $this->command->info('Channels table seeded!');


        $this->call('FeedsProgramSeeder');
        //muestra mensaje de guardao con exito
        $this->command->info('Channels table seeded!');


        $this->call('FeedsSeeder');
        //muestra mensaje de guardao con exito
        $this->command->info('Feeds table seeded!');

        //insertamos los calidades
        $this->call('QualitiesSeeder');
        $this->command->info('Qualities table seeded!');

        //insertamos los equipos
        $this->call('EquiposSeeder');
        $this->command->info('Equipos table seeded!');

        //insertamos los pasos para la creación de clips
        $this->call('StepsTableSeeder');
        $this->command->info('Steps table seeded!');

	}

}

