<?php
class StickersController extends BaseController
{
    public function getIndex()
    {
        return View::make('stickers.index');
    }

    public function postIndex()
    {
        if (Request::ajax()) {
            $data = Input::all();
            //recupera valores enviados por ajax
            $tarjeta_id    = $data['tarjeta'];
            $user_id       = $data['user_id'];
            $user_stickers = Tdbook::where('user_id', $user_id)->first();

            //recupera la informacion del usuario de la DB
            $pegados = json_decode($user_stickers['pegados']);
            //convierte en array las etiquetas pegadas
            if ($pegados == null) {
                $pegados = [$tarjeta_id];
            } else {
                array_push($pegados, $tarjeta_id);
            }
            $sueltos = json_decode($user_stickers['sueltos']);
            //convierte en array las etiquetas sueltas
            $clave = array_search($tarjeta_id, $sueltos);
            unset($sueltos[$clave]);
            $out                     = array_values($sueltos);
            $encode_sueltos          = json_encode($out);
            $encode_pegados          = json_encode($pegados);
            $update_tarjeta          = Tdbook::find($user_stickers['id']);
            $update_tarjeta->pegados = $encode_pegados;
            $update_tarjeta->sueltos = $encode_sueltos;
            $update_tarjeta->save();

            return $encode_sueltos;
        } else {
            $data    = Input::all();
            $user_id = $data['user_id'];
            for ($i = 0; $i < 5; ++$i) {
                $rand             = rand(1, 30);
                $all              = '00' . $rand;
                $first_stickers[] = substr($all, -2);
            }
            $encode_rand             = json_encode($first_stickers);
            $update_tarjeta          = new Tdbook();
            $update_tarjeta->user_id = $user_id;
            $update_tarjeta->sueltos = $encode_rand;
            $update_tarjeta->save();

            return Redirect::back();
        }
    }

    public function postJson()
    {

        $items = '';
        $data  = Input::all();
        //recupera valores enviados por ajax

        $mijson        = [];
        $user_id       = $data['user_id'];
        $user_stickers = Tdbook::where('user_id', $user_id)->first();
        //recupera la informacion del usuario de la DB

        $sueltos = json_decode($user_stickers['sueltos']);
        //convierte en array las etiquetas sueltas
        $pegados = json_decode($user_stickers['pegados']);
        //convierte en array las etiquetas pegados

        if ($sueltos) {
            $total_stick = array_count_values($sueltos);
            //devuelve array con id y cantidad de sticker
            $array_unico = array_unique($sueltos);
            //Elimina valores repetidos en el array
            sort($array_unico);
            $nuevas = $array_unico;
            if ($pegados) {
                $nuevas = array_diff($nuevas, $pegados);
            } else {
                $nuevas = $array_unico;
            }
            foreach ($array_unico as $value) {
                if (in_array($value, $nuevas)) {
                    $nueva = 'N';
                } else {
                    $nueva = '';
                }
                $mijson[] = array('src' => '//promociones.sinpk2.com/img/albums/tdbook/sticker' . $value . '.jpg', 'title' => $value, 'cantidad' => $total_stick[$value], 'nueva' => $nueva);
            }
        }
        $items     = ['items' => $mijson];
        $enc_items = json_encode($items);

        return $enc_items;
    }

    public function postSobre()
    {
        $data        = Input::all();
        $user_id     = $data['user_id'];
        $codigo      = $data['sobre_codigo'];
        $exist_codes = TdbookCodes::where('codes', $codigo)->first();
        //valida si el codigo existe
        for ($i = 0; $i < 5; ++$i) {
            $rand             = rand(1, 30);
            $all              = '00' . $rand;
            $first_stickers[] = substr($all, -2);
        }
        $user_codes = Tdbook::where('user_id', $user_id)->first();
        if ($exist_codes) {
            if ($user_codes['codigos']) {
                $dec_sueltos = json_decode($user_codes['sueltos']);
                //convierte en array las etiquetas sueltas
                $dec_codigos = json_decode($user_codes['codigos']);
                //convierte en array las etiquetas sueltas
                if (in_array($codigo, $dec_codigos)) {

                    /*
                    codigo utilizado
                     */
                    $new_stickers = $dec_sueltos;
                    $encode_codes = $user_codes['codigos'];
                } else {

                    /*
                    codigo nuevo
                     */
                    if ($dec_sueltos) {
                        $new_stickers = array_merge($dec_sueltos, $first_stickers);
                    } else {
                        $new_stickers = $first_stickers;
                    }
                    $new_codigo = $dec_codigos;
                    array_push($new_codigo, $codigo);
                    $encode_codes = json_encode($new_codigo);
                }
            } else {

                /*primer codigo */
                $dec_sueltos = json_decode($user_codes['sueltos']);
                /*convierte en array las etiquetas sueltas*/
                if ($dec_sueltos) {
                    $new_stickers = array_merge($dec_sueltos, $first_stickers);
                    $encode_codes = json_encode([$codigo]);
                } else {
                    $new_stickers = $first_stickers;
                    $encode_codes = json_encode([$codigo]);
                }
            }
            $encode_rand             = json_encode($new_stickers);
            $update_tarjeta          = Tdbook::find($user_codes['id']);
            $update_tarjeta->sueltos = $encode_rand;
            $update_tarjeta->codigos = $encode_codes;
            $update_tarjeta->save();
        }

        return Redirect::back();
    }

    public function getChange()
    {
        $nuevas_one = [];
        $faltan_one = [];
        $nuevas_two = [];
        $faltan_two = [];

        $all = [];
        for ($i = 1; $i <= 30; ++$i) {
            $all           = '00' . $i;
            $allstickers[] = substr($all, -2);
            /* devuelve ultimos 2 digitos*/

        }
        $user_one        = (Session::get('user.id'));
        $user_two        = 2;
        $user_one_codes  = Tdbook::where('user_id', $user_one)->first();
        $user_two_codes  = Tdbook::where('user_id', $user_two)->first();
        $dec_sueltos_one = json_decode($user_one_codes['sueltos']);
        //convierte en array las etiquetas sueltas
        if ($dec_sueltos_one) {
            $total_stick_one = array_count_values($dec_sueltos_one);
            /*devuelve array con id y cantidad de sticker*/
            $array_unico_one = array_unique($dec_sueltos_one);
            /*Elimina valores repetidos en el array*/
            sort($array_unico_one);
            $nuevas_one = $array_unico_one;
        }

        $faltan_one      = [];
        $dec_pegados_one = json_decode($user_one_codes['pegados']);
        /*convierte en array las etiquetas sueltas */
        if ($dec_pegados_one) {
            $faltan_one = array_diff($allstickers, $dec_pegados_one);
        }

        $get_amigos = Tdbook::select('amigos')->where('user_id', $user_one)->first();

        $amigos = json_decode($get_amigos['amigos']);
        /*convierte en array las etiquetas sueltas*/

        return View::make('stickers.change')->with('one', $nuevas_one)->with('faltan_one', $faltan_one)->with('amigos', $amigos)->with('two', $nuevas_two)->with('faltan_two', $faltan_two);
    }

    public function postChange()
    {
        $all = [];
        for ($i = 1; $i <= 30; ++$i) {
            $all           = '00' . $i;
            $allstickers[] = substr($all, -2);
            /* devuelve ultimos 2 digitos*/

        }

        if (Request::ajax()) {
            $data         = Input::all();
            $select_amigo = $data['selected'];

            $get_stickers = Tdbook::where('user_id', $select_amigo)->first();
            if ($get_stickers) {
                $get_sueltos   = $get_stickers['sueltos'];
                $get_pegados   = $get_stickers['pegados'];
                $array_sueltos = json_decode($get_sueltos);
                $array_pegados = json_decode($get_pegados);
                $array_faltan  = array_diff($allstickers, $array_pegados);
                $array_data    = ['sueltos' => $array_sueltos, 'faltan' => $array_faltan];
            } else {
                $array_data = 0;
            }
            return $array_data;
        } else {
            $data        = Input::all();
            $sticker_two = $data['sticker_two'];
            $sticker_one = $data['sticker_one'];
            /*dd('sticker_one', $sticker_one);*/

            return View::make('stickers.autorizar')->with('sticker_one', $sticker_one)->with('sticker_two', $sticker_two);

        }
    }
}
