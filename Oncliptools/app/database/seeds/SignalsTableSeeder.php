<?php


class SignalsTableSeeder extends Seeder {

    public function run()
    {

        $data = [
			            [ 'url_signal'        =>     'http://tvsawpdvr-lh.akamaihd.net/z/stch02wp_1@119660/manifest.f4m',
			              'url_signal_hds'    =>     'http://tvsawpdvr-lh.akamaihd.net/i/stch02wp_1@119660/master.m3u8',
			              'name'              =>     'Canal 2',
			              'short_name'        =>     '2',
			              'quality_range'     =>     '150-970',
			              'created_at'        =>     new DateTime,
			              'updated_at'        =>     new DateTime
			            ],
			            [ 'url_signal'        =>     'http://tvsawpdvr-lh.akamaihd.net/z/stch04wp_1@119661/manifest.f4m',
			              'url_signal_hds'    =>     'http://tvsawpdvr-lh.akamaihd.net/i/stch04wp_1@119661/master.m3u8',
			              'name'              =>     'Foro TV',
			              'short_name'        =>     'ForoTV',
			              'quality_range'     =>     '150-970',
			              'created_at'        =>     new DateTime,
			              'updated_at'        =>     new DateTime
			            ],
			            [ 'url_signal'        =>     'http://tvsawpdvr-lh.akamaihd.net/z/stch05wp_1@119663/manifest.f4m',
			              'url_signal_hds'    =>     'http://tvsawpdvr-lh.akamaihd.net/i/stch05wp_1@119663/master.m3u8',
			              'name'              =>     'Canal 5',
			              'short_name'        =>     '5',
			              'quality_range'     =>     '150-970',
			              'created_at'        =>     new DateTime,
			              'updated_at'        =>     new DateTime
			            ],
			            [ 'url_signal'        =>     'http://tvsawpdvr-lh.akamaihd.net/z/stch09wp_1@119664/manifest.f4m',
			              'url_signal_hds'    =>     'http://tvsawpdvr-lh.akamaihd.net/i/stch09wp_1@119664/master.m3u8',
			              'name'              =>     'Canal 9',
			              'short_name'        =>     '9',
			              'quality_range'     =>     '150-970',
			              'created_at'        =>     new DateTime,
			              'updated_at'        =>     new DateTime
			            ],
			            [ 'url_signal'        =>     'http://tvsawpdvr-lh.akamaihd.net/z/1dvrqu4nt3l_1@197427/manifest.f4m',
			              'url_signal_hds'    =>     'http://tvsawpdvr-lh.akamaihd.net/i/1dvrqu4nt3l_1@197427/master.m3u8',
			              'name'              =>     'Quantel',
			              'short_name'        =>     'Quantel',
			              'quality_range'     =>     '150-970',
			              'created_at'        =>     new DateTime,
			              'updated_at'        =>     new DateTime
			            ],
			            [ 'url_signal'        =>     'http://3v3ntmex-lh.akamaihd.net/z/test01_1@138939/manifest.f4m',
			              'url_signal_hds'    =>     'http://3v3ntmex-lh.akamaihd.net/i/test01_1@138939/master.m3u8',
			              'name'              =>     'Tricaster',
			              'short_name'        =>     'tricaster',
			              'quality_range'     =>     '150-970',
			              'created_at'        =>     new DateTime,
			              'updated_at'        =>     new DateTime
			            ],
			            [ 'url_signal'        =>     'http://tvsawpdvr-lh.akamaihd.net/z/cl1ptool01_1@127342/manifest.f4m',
			              'url_signal_hds'    =>     'http://tvsawpdvr-lh.akamaihd.net/i/cl1ptool01_1@127342/master.m3u8',
			              'name'              =>     'Prueba',
			              'short_name'        =>     'prueba',
			              'quality_range'     =>     '150-970',
			              'created_at'        =>     new DateTime,
			              'updated_at'        =>     new DateTime
			            ]
			          
                ];

                foreach ($data as $signal) {
                	$count = Signals::where('url_signal', $signal["url_signal"])->count();
                	if ($count==0) {
                		$signalNew= new Signals;
                		$signalNew->url_signal=$signal["url_signal"];
                		$signalNew->url_signal_hds=$signal["url_signal_hds"];
                		$signalNew->name=$signal["name"];
                		$signalNew->short_name=$signal["short_name"];
                		$signalNew->quality_range=$signal["quality_range"];
                		$signalNew->save();
                	}
                }
				      

        
    }


}

?>

