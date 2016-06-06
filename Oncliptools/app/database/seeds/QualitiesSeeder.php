<?php


class QualitiesSeeder extends Seeder {

    public function run()
    {     

        $data = [
			            [ 'id'          =>     '1',
			              'quality'     =>     '150',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '2',
			              'quality'     =>     '235',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '3',
			              'quality'     =>     '480',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '4',
			              'quality'     =>     '600',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ],
			            [ 'id'          =>     '5',
			              'quality'     =>     '970',
			              'created_at'  =>     new DateTime,
					      'updated_at'  =>     new DateTime
			            ]          
                ];

        
       		 	$countQ = DB::table('qualities')->count(); 

                if( $countQ == 0 ){
                	DB::table('qualities')->insert($data); 
                }  
        
      }

}

?>