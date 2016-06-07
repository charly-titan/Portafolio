<?php
class AdminStickersController extends BaseController
{
    public function getIndex()
    {
        $getAlbums = [];
        $getAlbums = $album = Albums::select()->get();
        return View::make('stickers.index')->with('albums', $getAlbums);
    }
    public function getPreviewAlbum($site)
    {
        return View::make('stickers.preview');
    }
    public function getCreateAlbum()
    {
        return View::make('stickers.admin');
    }
    public function postSaveAlbum()
    {
        $array_pages1    = [];
        $array_pages2    = [];
        $path            = storage_path() . '/albums/';
        $color           = "";
        $backgrounds     = [];
        $data            = Input::all();
        $portada         = $data['imgFrontCover'];
        $color           = $data['colorFrontCover'];
        $myResult        = $data['data'];
        $title           = $data['title'];
        $site            = str_replace(' ', '-', $title);
        $site            = strtolower($site);
        $album           = Albums::select('id', 'data', 'carrusel')->where('sitio', $site)->first();
        $destinationPath = "/albums/" . App::environment() . "/";
        if (!is_dir($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        if (isset($myResult['backgrounds'])) {
            foreach ($myResult['backgrounds'] as $back) {
                $exp_backgrounds = explode("_", $back);
                $array_pages1[]  = ($exp_backgrounds[0]);
                $backgrounds[]   = $exp_backgrounds;
            }
        }
        if (isset($myResult['stickers'])) {
            foreach ($myResult['stickers'] as $sticker) {
                $exp_stickers   = explode("_", $sticker);
                $array_pages2[] = ($exp_stickers[0]);
                $stickers[]     = $exp_stickers;
            }
        }
        if (isset($myResult['dataStickers'])) {
            foreach ($myResult['dataStickers'] as $dataSticker) {
                $exp_dataStickers = explode("_", $dataSticker);
                $carrusel[]       = [$exp_dataStickers[0] => [$exp_dataStickers[1], $exp_dataStickers[3], $exp_dataStickers[2]]];
            }
        } else {
            $carrusel = [];
        };
        $allPages = array_merge($array_pages2, $array_pages1);
        $allPages = array_unique($allPages);
        asort($allPages);
        $numPages = end($allPages);
        foreach ($allPages as $page) {
            foreach ($stickers as $sticker) {
                if (in_array($sticker[0], $allPages, true)) {
                    if ($page == $sticker[0]) {
                        $placePage     = $sticker[0];
                        $placeId       = $sticker[1];
                        $cardName      = $sticker[2];
                        $placeClass    = $sticker[3];
                        $placeType     = $sticker[4];
                        $imgOrig       = $sticker[5];
                        $stk           = "pag" . $placePage . "_" . $placeId . "_" . $cardName . "_" . $placeClass . "_" . $placeType . "_" . $imgOrig;
                        $nstk[$page][] = $stk;
                    }
                }
            }
            foreach ($backgrounds as $background) {
                if (in_array($background[0], $allPages, true)) {
                    if ($page == $background[0]) {
                        $bkg           = "pag" . $background[0] . "_" . $background[1] . "_" . $background[2];
                        $nbkg[$page][] = $bkg;
                    }
                }
            }
            if (isset($nstk[$page])) {
                $nstk[$page] = $nstk[$page];
            } else {
                $nstk[$page] = "";
            }
            if (isset($nbkg[$page])) {
                $nbkg[$page] = $nbkg[$page];
            } else {
                $nbkg[$page] = "";
            }
            $array[] = ["page" => $page, "stickers" => $nstk[$page], "background" => $nbkg[$page]];
        }
        $pages       = json_encode($array);
        $encCarrusel = json_encode($carrusel);
        $cadena      = 'getAlbum({"album":"' . $site . '", "color":"' . $color . '", "portada":"' . $portada . '", "pages": "' . $numPages . '", "data": ' . $pages . '})';
        $myfile      = fopen($path . $site, "w");
        fwrite($myfile, $cadena);
        fclose($myfile);
        $s3         = AWS::get('s3');
        $keyRequest = $destinationPath . $site;
        $result2    = $s3->putObject([
            'Bucket'      => 'communities-dev',
            'Key'         => $keyRequest,
            'ACL'         => 'public-read',
            'ContentType' => 'text/plain',
            'SourceFile'  => $path . "/" . $site,
        ]);
        $routeAlbum        = $result2['ObjectURL'];
        $album             = Albums::find($album['id']);
        $album->color      = $color;
        $album->portada    = $portada;
        $album->stickers   = '[]';
        $album->orden      = $cadena;
        $album->carrusel   = $encCarrusel;
        $album->data       = $pages;
        $album->referencia = $routeAlbum;
        $album->save();
        return $album['data'];
    }
    public function getEditAlbum()
    {
        return View::make('stickers.admin');
    }
    public function postDeleteAlbum()
    {
        $data           = Input::all();
        $solicitudID    = $data['id'];
        $expSolicitudID = explode("_", $solicitudID);
        $id             = $expSolicitudID[1];
        $album          = Albums::find($id);
        $album->delete();
        return ["id" => $id];
    }
    public function getEditStickers()
    {
        return View::make('stickers.adminStick');
    }
    public function postEditStickers()
    {
        $data            = Input::all();
        $site            = $data['site'];
        $encode          = json_encode([$data['data']]);
        $albumid         = Albums::select("id")->where("sitio", $site)->first();
        $album           = Albums::find($albumid["id"]);
        $album->carrusel = $encode;
        $album->save();
        return;
    }
    public function postSiteExist()
    {
        $data = Input::all();
        if (isset($data['id'])) {
            $solicitudID    = $data['id'];
            $expSolicitudID = explode("_", $solicitudID);
            $id             = $expSolicitudID[1];
            $album          = Albums::select()->where('id', $id)->first();
        }
        if (isset($data['title'])) {
            $title = $data['title'];
            $album = Albums::select()->where('sitio', $title)->first();
        }
        if (isset($album)) {
            return ["title" => $album['sitio']];
        } else {
            return ["status" => "404"];
        }
    }
    public function postRecoverData()
    {
        $data   = Input::all();
        $title  = $data['title'];
        $select = $data['select'];
        $site   = str_replace(' ', '-', $title);
        $site   = strtolower($site);
        if ($select == '*') {
            $getData = Albums::select()->where('sitio', $site)->first();
            return $getData;
        } else {
            $getData = Albums::select($select)->where('sitio', $site)->first();
            $decData = json_decode($getData[$select]);
            return $decData;
        }
    }
    public function postUploadSingle()
    {
        $path = storage_path() . '/albums/';
        if (!is_dir($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $fecha          = new DateTime();
        $data           = Input::all();
        $file           = $data['file'];
        $title          = $data['title'];
        $site           = str_replace(' ', '-', $title);
        $site           = strtolower($site);
        $filemd5        = md5($fecha->getTimestamp() . $file->getClientOriginalName());
        $fileExt        = $file->getClientOriginalExtension();
        $fileBackground = $filemd5 . "." . $fileExt;
        $fileName       = $file->getClientOriginalName();
        $file->move($path, $fileName);
        $s3               = AWS::get('s3');
        $destinationPath  = "/albums/" . App::environment() . "/" . $site;
        $keyBackground    = $destinationPath . '/' . $fileBackground;
        $SourceBackground = $path . $fileName;
        $result           = $s3->putObject([
            'Bucket'      => 'communities-dev',
            'Key'         => $keyBackground,
            'ACL'         => 'public-read',
            'ContentType' => 'image/jpeg',
            'SourceFile'  => $SourceBackground,
        ]);
        $routeBackground = $result['ObjectURL'];
        return $routeBackground;
    }
    public function postUploadStickers()
    {
        $path = storage_path() . '/albums/';
        if (!is_dir($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $fecha = new DateTime();
        $data  = Input::all();
        $files = $data['stickers'];
        $title = $data['title'];
        $site  = str_replace(' ', '-', $title);
        $site  = strtolower($site);
        foreach ($files as $file) {
            $filemd5     = md5($fecha->getTimestamp() . $file->getClientOriginalName());
            $fileExt     = $file->getClientOriginalExtension();
            $fileSticker = $filemd5 . "." . $fileExt;
            $fileName    = $file->getClientOriginalName();
            $file->move($path, $fileName);
            $s3                = AWS::get('s3');
            $destinationPath   = "/albums/" . App::environment() . "/" . $site;
            $keyStickers       = $destinationPath . '/' . $fileSticker;
            $SourceFileSticker = $path . $fileName;
            $result            = $s3->putObject([
                'Bucket'      => 'communities-dev',
                'Key'         => $keyStickers,
                'ACL'         => 'public-read',
                'ContentType' => 'image/jpeg',
                'SourceFile'  => $SourceFileSticker,
            ]);
            $routeStickers[] = $result['ObjectURL'];
        }
        $album = Albums::select('id')->where('sitio', $site)->first();
        if ($album) {
            $id               = $album['id'];
            $albumStickers    = Albums::select('stickers')->where('id', $id)->first();
            $decRouteStickers = json_decode($albumStickers['stickers']);
            $resultado        = array_merge($routeStickers, $decRouteStickers);
            $encRouteStickers = json_encode($resultado);
            $album            = Albums::find($id);
            $album->stickers  = $encRouteStickers;
            $album->save();
        } else {
            $encRouteStickers = json_encode($routeStickers);
            $album            = new Albums;
            $album->album     = $title;
            $album->sitio     = $site;
            $album->stickers  = $encRouteStickers;
            $album->save();
        }
        return;
    }
}
