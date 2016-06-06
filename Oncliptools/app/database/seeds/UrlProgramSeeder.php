<?php

class ChannelsSeeder extends Seeder {

    public function run() {
        DB::table('programs_url')->truncate();

        $data = [
            [ 
                'id' => '1',
                'Monday' => '1',
                'Tuesday' => '1',
                'Wednesday' => '1',
                'Thursday' => '1',
                'Friday' => '1',
                'Saturday' => '1',
                'Sunday' => '1',
                'url' => 'www.televisacomplaints.esmas.com/home',
                'inactive_date' => '1416470400',
                'startTime' => '02:00:00',
                'endTime' => '15:00:00',
                'status' => '1'
            ]
        ];

        DB::table('programs_url')->insert($data);
    }

}

?>