<?php


class EquiposSeeder extends Seeder {

    public function run()
    {     

        $data = [
			            [ 'id'          =>     '1',
			              'nombre'      =>     'AMÉRICA',
			              'abreviatura' =>     'AME',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '2',
			              'nombre'      =>     'ATLAS',
			              'abreviatura' =>     'ATS',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '3',
			              'nombre'     =>      'TIGRES',
			              'abreviatura' =>     'TIG',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '4',
			              'nombre'     =>      'TOLUCA',
			              'abreviatura' =>     'TOL',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '5',
			              'nombre'     =>      'CHIAPAS FC',
			              'abreviatura' =>     'CHI',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '6',
			              'nombre'     =>      'MONTERREY',
			              'abreviatura' =>     'MTY',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '7',
			              'nombre'     =>      'PACHUCA',
			              'abreviatura' =>     'PAC',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '8',
			              'nombre'     =>      'PUMAS',
			              'abreviatura' =>     'PUM',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '9',
			              'nombre'     =>      'SANTOS',
			              'abreviatura' =>     'STS',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '10',
			              'nombre'     =>      'LEÓN',
			              'abreviatura' =>     'LEO',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '11',
			              'nombre'     =>      'TIJUANA',
			              'abreviatura' =>     'TIJ',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '12',
			              'nombre'     =>      'QUERÉTARO',
			              'abreviatura' =>     'QRO',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '13',
			              'nombre'     =>      'CRUZ AZUL',
			              'abreviatura' =>     'CAZ',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '14',
			              'nombre'     =>      'U DE G',
			              'abreviatura' =>     'UDG',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '15',
			              'nombre'     =>      'PUEBLA',
			              'abreviatura' =>     'PUE',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '16',
			              'nombre'     =>      'GUADALAJARA',
			              'abreviatura' =>     'GUA',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '17',
			              'nombre'     =>      'VERACRUZ',
			              'abreviatura' =>     'VER',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '18',
			              'nombre'     =>      'MORELIA',
			              'abreviatura' =>     'MOR',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ]                                         

                ];

        
       		 	$count = DB::table('equipos')->count(); 

                if( $count == 0 ){
                	DB::table('equipos')->insert($data); 
                }  
        
    }

}

?>