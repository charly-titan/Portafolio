<?php
class StickersController extends BaseController
{
    public function getAlbum()
    {
        $data   = Input::all();
        $site   = $data['site'];
        $toRead = 'https://s3-us-west-1.amazonaws.com/communities-dev/albums/' . App::environment() . '/' . $site;
        try {
            $album = file_get_contents($toRead);
        } catch (Exception $e) {
            if ($site == "demo-album") {
                $toRead = 'https://s3-us-west-1.amazonaws.com/communities-dev/albums/aws/demo-album';
                $album  = file_get_contents($toRead);
            } else {
                $album = 'getAlbum({"status":"404"})';
            }
        }
        return $album;
    }
    public function getUserStickers()
    {
        $data  = Input::all();
        $_UID  = $data["_UID"];
        $site  = $_GET["site"];
        $mivar            = [];
        if (!isset($site) or !strlen($site)) {
            echo 'userStickers({"status": "need site"})';
            return;
        }
        $albumExist = Albums::select()->where('sitio', $site)->first();
        if (isset($albumExist)) {
            $myQuery = Stickers::select()->where("uid", "=", $_UID)->where("album", "=", $site)->first();
            if (isset($myQuery)) {
                /**************************************************************/
                $sueltas = json_decode($myQuery['sueltas']);
                $pegadas = json_decode($myQuery['pegadas']);
                $carrusel = json_decode($albumExist['carrusel'], true);
                $total_stick = array_count_values($sueltas);
                $subQueryUniqe = array_unique($sueltas);
                sort($subQueryUniqe);
                foreach ($subQueryUniqe as $unica) {
                    if (in_array($unica, $pegadas)) {
                        $nueva = 0;
                    } else {
                        $nueva = 1;
                    }
                    foreach ($carrusel as $sticker) {
                        if (array_key_exists($unica, $sticker)) {
                            $src = ($sticker[$unica][0]);
                        }
                    }
                    $mivar[] = ["src" => $src, "id" => $unica, "cantidad" => $total_stick[$unica], "nueva" => $nueva];
                }
                echo 'userStickers({sueltas:' . json_encode($mivar) . ', pegadas:'.$myQuery['pegadas'].'})';
                return;
            } else {
                echo 'userStickers({"status": "4004"})';
                return;
            }
        } else {
            echo 'userStickers({"status": "404"})';
            return;
        }
    }
    public function getDemo()
    {
        $data             = Input::all();
        $mivar            = [];
        $site             = [];
        $carousel_sueltas = [];
        $carousel_pegadas = [];
        $_UID             = $data["_UID"];
        $site             = $_GET["site"];
        if (!isset($site) or !strlen($site)) {
            echo 'getCarousel({"status": "need site"})';
            return;
        }
        if ($site == "demo-album") {
            $carousel         = "demo-album";
            $carousel_sueltas = ["01", "02", "03", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15"];
            $carousel_pegadas = ["01", "02", "05", "07", "11", "15"];
        } else {
            $albumExist = Albums::select()->where('sitio', $site)->first();
            if (isset($albumExist)) {
                $carousel = Stickers::select("sueltas", "pegadas")->where("uid", "=", $_UID)->where("album", "=", $site)->first();
            } else {
                echo 'getCarousel({"status": "404"})';
                return;
            }
            if ($carousel) {
                $carousel_sueltas = json_decode($carousel["sueltas"]);
                $carousel_pegadas = json_decode($carousel["pegadas"]);
            } else {
                echo 'getCarousel({"status": "carousel not found"})';
                return;
            }
        }
        if ($carousel_sueltas) {
            $album = Albums::select('carrusel')->where('sitio', $site)->first();
            if (isset($album)) {
                $decAlbum = (json_decode($album['carrusel'], true));
            } else {
                if ($site == "demo-album") {
                    $album    = '[{"965988cce5cfcf62e0b3e924e9eeb065":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/965988cce5cfcf62e0b3e924e9eeb065.jpg"]},{"3451aaab7b87c84d2359abacf68ae598":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/3451aaab7b87c84d2359abacf68ae598.jpg"]},{"899f98cc806a2e75fdfec0df00aab268":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/899f98cc806a2e75fdfec0df00aab268.jpg"]},{"cafa209d4e8f5006c1c1953e6cad188e":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/cafa209d4e8f5006c1c1953e6cad188e.jpg"]},{"7dfe12a6d0116abbee8ae3340a47907c":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/7dfe12a6d0116abbee8ae3340a47907c.jpg"]},{"estampa06":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/0a04c77499bac0441fdd6b1374ecad7f.jpg"]},{"estampa07":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/fbc40b9bf0c04527844ab6ff604eae99.jpg"]},{"estampa08":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/bc4bfc947afa61c38f935053124d9d3e.jpg"]},{"estampa09":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/a920df209209e7df4b6175b39e750a83.jpg"]},{"estampa10":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/d75f2394b0d829ffc430c57af8acc938.jpg"]},{"estampa11":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/6affeefc75cdbae4a47fd4305a6fa769.jpg"]},{"estampa12":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/0759b8d116ad1dbe1dea8f159623f96e.jpg"]},{"estampa13":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/aeba290248cbe2392f772163657fe27e.jpg"]},{"estampa14":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/8d4d886332c5e4e6570450867a96e30b.jpg"]},{"estampa15":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/9222b497dc24da34ba1a2e006a7bb63f.jpg"]},{"estampa16":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/5948b1d1e9b0140e34ca3da8951673df.jpg"]},{"estampa17":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/a9ec89d03750e9ca6d1cf31d59d81284.jpg"]},{"estampa18":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/aee22bd365b995f921e4d8fd99f0b9d5.jpg"]},{"estampa19":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/e878e6b914e6384008337eb390865ced.jpg"]},{"estampa20":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/a717bf324f5c0e1bc16ea0e55eeb5fc2.jpg"]},{"estampa21":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/ad2a136ff35d18a2b1f22f0a700e3c6d.jpg"]},{"estampa22":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/683a018dd537e9c580c3286a3525a1a7.jpg"]},{"estampa23":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/aa301ef50239dabcfbc60abc552c8418.jpg"]},{"estampa24":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/c53f6b9e457a6d0898ba1184daaa12ba.jpg"]},{"estampa25":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/97fb6b21fb5b61a2876c7deabef0f429.jpg"]},{"estampa26":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/08164610d3154bcd6fba8abd7b0d3afc.jpg"]},{"estampa27":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/fe8ddf8bb5d2e2b1b19521337e784cba.jpg"]},{"estampa28":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/33cff3950c4e22abd8390d64e1f30018.jpg"]},{"estampa29":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/b276ba0fa973df5b7e2575f9771ee816.jpg"]},{"estampa30":["https:\/\/communities-dev.s3.amazonaws.com\/albums\/aws\/demo-album\/4667f740ec42eedecfb1fcf70844f13e.jpg"]}]';
                    $decAlbum = (json_decode($album, true));
                } else {
                    echo 'getCarousel({"status": "carousel demo not found"})';
                    return;
                }
            }
            $total_stick = array_count_values($carousel_sueltas);
            $array_unico = array_unique($carousel_sueltas);
            sort($array_unico);
            $nuevas = $array_unico;
            if ($carousel_pegadas) {
                $nuevas = array_diff($nuevas, $carousel_pegadas);
            } else {
                $nuevas = $array_unico;
            }
            foreach ($array_unico as $value) {
                if (in_array($value, $nuevas)) {
                    $nueva = 1;
                } else {
                    $nueva = 0;
                }
                foreach ($decAlbum as $sticker) {
                    if (array_key_exists($value, $sticker)) {
                        $src = ($sticker[$value]);
                    }
                }
                $mivar[] = ["src" => $src, "id" => $value, "cantidad" => $total_stick[$value], "nueva" => $nueva];
            }
        }
        if ($carousel) {
            $carousel = ["sueltas" => $mivar, "pegadas" => $carousel_pegadas];
        }
        echo 'getCarousel({"carousel": ' . json_encode($carousel) . '})';
        return;
    }
    public function getPaste()
    {
        $data         = Input::all();
        $site         = [];
        $site         = $data["site"];
        $cardID       = $data["card"];
        $_UID         = $data["_UID"];
        $stickersUser = Stickers::where("uid", $_UID)->where("album", $site)->first();
        if ($stickersUser) {
            $pegados = json_decode($stickersUser["pegadas"]);
            $sueltos = json_decode($stickersUser["sueltas"]);
            if ($pegados == null) {
                $pegados = [$cardID];
            } else {
                if (in_array($cardID, $pegados)) {
                    echo 'actionPaste({"status": "404"})';
                    return;
                } else {
                    if (in_array($cardID, $sueltos)) {
                        array_push($pegados, $cardID);
                    } else {
                        echo 'actionPaste({"status": "200"})';
                        return;
                    }
                }
            }
            $clave = array_search($cardID, $sueltos);
            unset($sueltos[$clave]);
            $out                 = array_values($sueltos);
            $encode_sueltos      = json_encode($out);
            $encode_pegados      = json_encode($pegados);
            $updateCard          = Stickers::find($stickersUser["id"]);
            $updateCard->pegadas = $encode_pegados;
            $updateCard->sueltas = $encode_sueltos;
            $updateCard->save();
            echo 'actionPaste({"cardID": "' . $cardID . '"})';
            return;
        } else {
            echo 'actionPaste({"status": "404"})';
            return;
        }
    }
    public function getRegistrar()
    {
        $data        = Input::all();
        $_UID        = $data['_UID'];
        $album       = $data['site'];
        $allStickers = Albums::select('carrusel')->where('sitio', $album)->first();
        $count       = Stickers::where('album', $album)->where('uid', $_UID)->count();
        if ($count > 0) {
            echo 'getRegistro({"status":"1062"})';
            return;
        } else {
            $decode_allStickers = json_decode($allStickers['carrusel'], true);
            foreach ($decode_allStickers as $value) {
                $keys[] = (array_keys($value));
                foreach ($keys as $key) {
                    $onlykeys[] = $key[0];
                }
            }
            $resultado             = array_unique($onlykeys);
            $stickers              = count($resultado);
            $random_keys           = array_rand($onlykeys, 3);
            $first_stickers        = [$onlykeys[$random_keys[0]], $onlykeys[$random_keys[1]], $onlykeys[$random_keys[2]]];
            $encode_first_stickers = json_encode($first_stickers);
            $registro              = new Stickers;
            $registro->uid         = $_UID;
            $registro->album       = $album;
            $registro->stickers    = $stickers;
            $registro->sueltas     = $encode_first_stickers;
            $registro->pegadas     = '[]';
            $registro->save();
            echo 'getRegistro({"status":"201"})';
            return;
        }
    }
    public function getFlipCard()
    {
        $data        = Input::all();
        $site        = $data['site'];
        $allStickers = Albums::select('carrusel')->where('sitio', $site)->first();
        if (isset($allStickers)) {
            $decode_allStickers   = json_decode($allStickers['carrusel'], true);
            $reencode_allStickers = json_encode($decode_allStickers);
            echo 'getFlipCard({"allStickers":' . $reencode_allStickers . '})';
            return;
        } else {
            echo 'getFlipCard({"status":"404"})';
            return;
        }
    }
    public function getEnv()
    {
        return App::environment();
    }
}
