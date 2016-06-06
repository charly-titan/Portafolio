<?php


class ChannelsSeeder extends Seeder {

    public function run()
    {     
        DB::table('channels')->truncate();

        $data = [
			            [ 'clave'       =>     '1311',
			              'programa'    =>     'Primero Noticias'
			            ],
			            [ 'clave'       =>     '1321',
			              'programa'    =>     'El Noticiero con Lolita Ayala'
			            ],
			            [ 'clave'       =>     '1795',
			              'programa'    =>     'Las Noticias por Adela'
			            ],
			            [ 'clave'       =>     '1713',
			              'programa'    =>     'El Noticiero con Joaquín López Dóriga'
			            ],
			            [ 'clave'       =>     '2699',
			              'programa'    =>     'El Mañanero y Debatitlan'
			            ],
 			            [ 'clave'       =>     '1734',
			              'programa'    =>     'Matutino Express'
			            ],
 			            [ 'clave'       =>     '1808',
			              'programa'    =>     'A las 3'
			            ],
  			            [ 'clave'       =>     '2917',
			              'programa'    =>     'Economía de Mercado'
			            ]          
                ];

        DB::table('channels')->insert($data); 
        
      }

}

?>