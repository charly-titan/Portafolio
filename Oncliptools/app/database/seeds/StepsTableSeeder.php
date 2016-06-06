<?php


class StepsTableSeeder extends Seeder {

    public function run()
    {

        $data = [
			            [ 'num_step'        =>	0,
			              'description'  	=>  'Starting process',
			              'time_estimated'  =>  0
			            ],
			            [ 'num_step'        =>	1,
			              'description'  	=>  'Downloading signals',
			              'time_estimated'  =>  10
			            ],
			            [ 'num_step'        =>	2,
			              'description'  	=>  'Generating quality 150',
			              'time_estimated'  =>  20
			            ],
			            [ 'num_step'        =>	2.1,
			              'description'  	=>  'Uploading to Akamai quality 150',
			              'time_estimated'  =>  25
			            ],
			            [ 'num_step'        =>	3,
			              'description'  	=>  'Generating quality 235',
			              'time_estimated'  =>  30
			            ],
			            [ 'num_step'        =>	3.1,
			              'description'  	=>  'Uploading to Akamai quality 235',
			              'time_estimated'  =>  35
			            ],
			            [ 'num_step'        =>	4,
			              'description'  	=>  'Generating quality 400',
			              'time_estimated'  =>  40
			            ],
			            [ 'num_step'        =>	4.1,
			              'description'  	=>  'Uploading to Akamai quality 400',
			              'time_estimated'  =>  45
			            ],
			            [ 'num_step'        =>	5,
			              'description'  	=>  'Generating quality 600',
			              'time_estimated'  =>  50
			            ],
			            [ 'num_step'        =>	5.1,
			              'description'  	=>  'Uploading to Akamai quality 600',
			              'time_estimated'  =>  55
			            ],
			            [ 'num_step'        =>	6,
			              'description'  	=>  'Generating quality 970',
			              'time_estimated'  =>  60
			            ],
			            [ 'num_step'        =>	6.1,
			              'description'  	=>  'Uploading to Akamai quality 970',
			              'time_estimated'  =>  65
			            ],
			            [ 'num_step'        =>	7,
			              'description'  	=>  'Generating Master',
			              'time_estimated'  =>  70
			            ],
			            [ 'num_step'        =>	8,
			              'description'  	=>  'Generating Thumbnails',
			              'time_estimated'  =>  80
			            ],
			            [ 'num_step'        =>	9,
			              'description'  	=>  'Uploading to Galaxy',
			              'time_estimated'  =>  90
			            ],
			            [ 'num_step'        =>	10,
			              'description'  	=>  'Uploading to Brightcove',
			              'time_estimated'  =>  95
			            ],
			            [ 'num_step'        =>	11,
			              'description'  	=>  'Process finished',
			              'time_estimated'  =>  100
			            ]
                ];

                foreach ($data as $step) {
                	$count = Steps::where('num_step', $step["num_step"])->count();
                	if ($count==0) {
                		$stepNew= new Steps;
                		$stepNew->num_step=$step["num_step"];
                		$stepNew->description=$step["description"];
                		$stepNew->time_estimated=$step["time_estimated"];
                		$stepNew->save();
                	}
                }
				      

        
    }


}

?>

