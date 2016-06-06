<?php

include 'bitly.php';

class bitlyController extends Controller {
    
    /* returns the shortened url */
    
    protected function getbitlyshorturl(){

        $reglas = array(
            
            'url'=>array('required'),
//            'bitly'=>array(''),
        );

        $validator = Validator::make(Input::all(), $reglas);

        if ($validator->fails()){
            
            return Redirect::to('')
                ->withErrors($validator)
                ->withInput();
            
        }else{
            
            $url = Input::get('url');
            
            $USERS_ACCESS_TOKEN = 'f07bc49f01a5b9d2a748716625ab4ac19f9b4cec';
            
//            $shorten = Bitly::setAccessToken('f07bc49f01a5b9d2a748716625ab4ac19f9b4cec')
//                         ->setFormat('json')
//                         ->setVariableOutput('array')
//                         ->setConnectionOptions(array(CURLOPT_PORT => 443, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0))
//                         ->shorten($url)
//                         ->getResponseData();
            
            $shorten = bitly_v3_shorten($url, $USERS_ACCESS_TOKEN, 'j.mp');
            
            //$json = gettype($shorten);
            
            //$object = (object) $shorten;
            
            $array = json_encode($shorten);
            
            //$json = $object->data['url'];
            
            //$json = $shorten;
            
            $json = $array;
            
            return View::make('bitly.bitly_shorten',array('json'=>$json));
            
        }

    }
}
