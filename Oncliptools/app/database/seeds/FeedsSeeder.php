<?php

	class FeedsSeeder extends Seeder{


		public function Run(){


		        $data = [
					            [ 'id_feed'        	=>     1,
					              'nameFeed'    	=>     'Primero Noticias',
					              'urlFeed'         =>     'http://d2.bdtr.net/newscast/getDetailData2.php?cl=1311&key=k87Ynf3H&t=1400796612219&date=2014-09-05',
					              'cl'         		=>     1311,
					              'created_at'      =>     new DateTime,
					              'updated_at'      =>     new DateTime
					            ],
					            [ 'id_feed'        	=>     2,
					              'nameFeed'    	=>     'El Noticiero con Lolita Ayala',
					              'urlFeed'         =>     'http://d2.bdtr.net/newscast/getDetailData2.php?cl=1321&key=k87Ynf3H&t=1400796612219&date=2014-09-05',
					              'cl'         		=>     1321,
					              'created_at'      =>     new DateTime,
					              'updated_at'      =>     new DateTime
					            ],
					            [ 'id_feed'        	=>     3,
					              'nameFeed'    	=>     'Las Noticias por Adela',
					              'urlFeed'         =>     'http://d2.bdtr.net/newscast/getDetailData2.php?cl=1795&key=k87Ynf3H&t=1400796612219&date=2014-09-05',
					              'cl'         		=>     1795,
					              'created_at'      =>     new DateTime,
					              'updated_at'      =>     new DateTime
					            ],
					            [ 'id_feed'        	=>     4,
					              'nameFeed'    	=>     'El Noticiero con Joaquin Lopez Doriga',
					              'urlFeed'         =>      'http://d2.bdtr.net/newscast/getDetailData2.php?cl=1713&key=k87Ynf3H&t=1400796612219&date=2014-09-05',
					              'cl'         		=>     1713,
					              'created_at'      =>     new DateTime,
					              'updated_at'      =>     new DateTime
					            ],
					            [ 'id_feed'        	=>     5,
					              'nameFeed'    	=>     'El Mananero y Debatitlan',
					              'urlFeed'         =>     'http://d2.bdtr.net/newscast/getDetailData2.php?cl=2699&key=k87Ynf3H&t=1400796612219&date=2014-09-05',
					              'cl'         		=>     2699,
					              'created_at'      =>     new DateTime,
					              'updated_at'      =>     new DateTime
					            ],
					            [ 'id_feed'        	=>     6,
					              'nameFeed'    	=>     'Matutino Express',
					              'urlFeed'         =>     'http://d2.bdtr.net/newscast/getDetailData2.php?cl=1734&key=k87Ynf3H&t=1400796612219&date=2014-09-05',
					              'cl'         		=>     1734,
					              'created_at'      =>     new DateTime,
					              'updated_at'      =>     new DateTime
					            ],
					            [ 'id_feed'        	=>     7,
					              'nameFeed'    	=>     'A las 3',
					              'urlFeed'         =>      'http://d2.bdtr.net/newscast/getDetailData2.php?cl=1808&key=k87Ynf3H&t=1400796612219&date=2014-09-05',
					              'cl'         		=>     1808,
					              'created_at'      =>     new DateTime,
					              'updated_at'      =>     new DateTime
					            ],
					            [ 'id_feed'        	=>     8,
					              'nameFeed'    	=>     'Hora 21',
					              'urlFeed'         =>     'http://d2.bdtr.net/newscast/getDetailData2.php?cl=2917&key=k87Ynf3H&t=1400796612219&date=2014-09-05',
					              'cl'         		=>     2925,
					              'created_at'      =>     new DateTime,
					              'updated_at'      =>     new DateTime
					            ],
					          
		                ];

		        	$data1 = [
					            [ 'id_feed'        		=>     1,
					              'nameDays'    		=>     'Monday,Tuesday,Wednesday,Thursday,Friday',
					              'timeConsultation'  	=>     1,
					              'hourOminute'         =>     'Min',
					              'initiationTime'      =>     "05:50:00",
					              'endTime'         	=>     "11:00:00",
					              'dateInitiation'      =>     "2014-09-05",
					              'dateEnd'         	=>     "2015-09-05",
					              'created_at'      	=>     new DateTime,
					              'updated_at'      	=>     new DateTime
					            ],
					            [ 'id_feed'        		=>     2,
					              'nameDays'    		=>     'Monday,Tuesday,Wednesday,Thursday,Friday',
					              'timeConsultation'  	=>     1,
					              'hourOminute'         =>     'Min',
					              'initiationTime'      =>     "14:20:00",
					              'endTime'         	=>     "17:00:00",
					              'dateInitiation'      =>     "2014-09-05",
					              'dateEnd'         	=>     "2015-09-05",
					              'created_at'      	=>     new DateTime,
					              'updated_at'      	=>     new DateTime
					            ],
					            [ 'id_feed'        		=>     3,
					              'nameDays'    		=>     'Monday,Tuesday,Wednesday,Thursday,Friday',
					              'timeConsultation'  	=>     1,
					              'hourOminute'         =>     'Min',
					              'initiationTime'      =>     "19:50:00",
					              'endTime'         	=>     "23:00:00",
					              'dateInitiation'      =>     "2014-09-05",
					              'dateEnd'         	=>     "2015-09-05",
					              'created_at'      	=>     new DateTime,
					              'updated_at'      	=>     new DateTime
					            ],
					            [ 'id_feed'        		=>     4,
					              'nameDays'    		=>     'Monday,Tuesday,Wednesday,Thursday,Friday',
					              'timeConsultation'  	=>     1,
					              'hourOminute'         =>     'Min',
					              'initiationTime'      =>     "22:20:00",
					              'endTime'         	=>     "24:00:00",
					              'dateInitiation'      =>     "2014-09-05",
					              'dateEnd'         	=>     "2015-09-05",
					              'created_at'      	=>     new DateTime,
					              'updated_at'      	=>     new DateTime
					            ],
					            [ 'id_feed'        		=>     5,
					              'nameDays'    		=>     'Monday,Tuesday,Wednesday,Thursday,Friday',
					              'timeConsultation'  	=>     1,
					              'hourOminute'         =>     'Min',
					              'initiationTime'      =>     "06:20:00",
					              'endTime'         	=>     "12:00:00",
					              'dateInitiation'      =>     "2014-09-05",
					              'dateEnd'         	=>     "2015-09-05",
					              'created_at'      	=>     new DateTime,
					              'updated_at'      	=>     new DateTime
					            ],
					            [ 'id_feed'        		=>     6,
					              'nameDays'    		=>     'Monday,Tuesday,Wednesday,Thursday,Friday',
					              'timeConsultation'  	=>     1,
					              'hourOminute'         =>     'Min',
					              'initiationTime'      =>     "08:20:00",
					              'endTime'         	=>     "13:30:00",
					              'dateInitiation'      =>     "2014-09-05",
					              'dateEnd'         	=>     "2015-09-05",
					              'created_at'      	=>     new DateTime,
					              'updated_at'      	=>     new DateTime
					            ],
					            [ 'id_feed'        		=>     7,
					              'nameDays'    		=>     'Monday,Tuesday,Wednesday,Thursday,Friday',
					              'timeConsultation'  	=>     1,
					              'hourOminute'         =>     'Min',
					              'initiationTime'      =>     "14:50:00",
					              'endTime'         	=>     "18:00:00",
					              'dateInitiation'      =>     "2014-09-05",
					              'dateEnd'         	=>     "2015-09-05",
					              'created_at'      	=>     new DateTime,
					              'updated_at'      	=>     new DateTime
					            ],
					            [ 'id_feed'        		=>     8,
					              'nameDays'    		=>     'Monday,Tuesday,Wednesday,Thursday,Friday',
					              'timeConsultation'  	=>     1,
					              'hourOminute'         =>     'Min',
					              'initiationTime'      =>     "12:50:00",
					              'endTime'         	=>     "15:30:00",
					              'dateInitiation'      =>     "2014-09-05",
					              'dateEnd'         	=>     "2015-09-05",
					              'created_at'      	=>     new DateTime,
					              'updated_at'      	=>     new DateTime
					            ],
					          
		                ];

		        $countF = Feeds::all()->count();
                $countFp = FeedProgrammed::all()->count();
                
                if( $countF == 0 ){
                    DB::table('feeds')->insert($data);
                }
                if( $countFp == 0 ){
                    DB::table('feeds_programmed')->insert($data1);
                }
		    }
	}
	

?>