<?php


class FeedsProgramSeeder extends Seeder {

    public function run()
    {     

        $data = [
                    [ 'programKey'  => '1311',      
                      'secuency'    => '163276',
                      'title'       => 'avances de noticias. nuevo ciclo escolar. por seguridad. extranjeros cometen delitos. varias delegaciones afectadas',
                      'img'         => '{"thumb1":http://s3.amazonaws.com/bdtr-rec/20140818/b37fd0b0.jpg}',
                      'startDate'   => '2014-08-18',
                      'startTime'   => '05:52:27',
                      'duration'    => '00:29',
                      'status'      => '1',
                      'modified_by' => '',
                      'extra'       => '{"temas":Recomendados}'
                    ],
                    [ 'programKey'  => '1311',      
                      'secuency'    => '163305',
                      'title'       => 'lluvia, granizo y tormenta electrica en varias delegaciones de la ciudad (reporte desde las calles)',
                      'img'         => '{"thumb1":http://s3.amazonaws.com/bdtr-rec/20140818/8b3976e1.jpg}',
                      'startDate'   => '2014-08-18',
                      'startTime'   => '05:52:56',
                      'duration'    => '01:15',
                      'status'      => '1',
                      'modified_by' => '',
                      'extra'       => '{"temas":Recomendados}'
                    ],   
                    [ 'programKey'  => '1311',      
                      'secuency'    => '163380',
                      'title'       => 'internacionales. continua la tregua en el medio oriente',
                      'img'         => '{"thumb1":http://s3.amazonaws.com/bdtr-rec/20140818/75bc5af4.jpg}',
                      'startDate'   => '2014-08-18',
                      'startTime'   => '05:54:11',
                      'duration'    => '00:43',
                      'status'      => '1',
                      'modified_by' => '',
                      'extra'       => '{"temas":Recomendados}'
                    ]                        
            
                ];

    
                $countFp = FeedsProgram::all()->count();
                
                if( $countFp == 0 ){
                    DB::table('FeedsProgram')->insert($data); 
                }
        
      }

}

?>