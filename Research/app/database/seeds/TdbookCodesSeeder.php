<?php

class TdbookCodesSeeder extends Seeder
{

    public function run()
    {

        for ($i = 0; $i < 50; $i++) {
            $random_code = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
            $tdbook_code = new TdbookCodes;
            $tdbook_code->codes = $random_code;
            $tdbook_code->patrocinador = "Tdbook";
            $tdbook_code->save();
        }
    }
}
