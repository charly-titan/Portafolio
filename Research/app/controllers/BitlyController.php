<?php

//include 'bitly.php';

class BitlyController extends Controller {
    protected $bitly_key;

    public function __construct()
    {
       $this->bitly_key = Config::get( 'app.bitly_key' );
       $this->beforeFilter('auth');
    }
    


    public function getIndex(){

       //var_dump($this->existBitly("http://tvsa.mx/concursojurassicpark"));

       //var_dump($this->createBitly('http://www.televisa.com/#http://espectaculos.televisa.com/farandula/fotos/kendall-y-kylie-jenner-son-el-mejor-duo-dinamico/71303/'));
        $url = urldecode(Input::get('url'));
        if (Cache::has('url-'.md5($url)))
        {
            
            
        }else{
            $short=$this->createBitly($url);
            Cache::put('url-'.md5($url), $short["data"]["url"], 120);
        }
       
        return Cache::get('url-'.md5($url));
       //var_dump(Input::all());
       //echo urldecode($url);
       //var_dump($short);
       //return ;
   }
    
    /* returns the shortened url */

    protected function createBitly($longUrl){
        return Bitly::shorten($longUrl);
    }

    protected function existBitly(){
        echo $shortUrl;

      return Bitly::expand($shortUrl);

    }

    protected function createCustomBitly(){

    }
    
    protected function getbitlyshorturl(){

        $reglas = array(
            
            'url'=>array('required'),
            'customize'=>array('required'),
        );

        $validator = Validator::make(Input::all(), $reglas);

        if ($validator->fails()){
            
            return Redirect::to('')
                ->withErrors($validator)
                ->withInput();
            
        }else{
            
            $bitly_oauth_api = 'https://api-ssl.bitly.com';

            $ACCESS_TOKEN = 'R_17bb3cecaae34f709d1fe0caa97c388a';

            $url = Input::get('url');
            
            $customize = Input::get('customize');
                        
            $expand = Bitly::setAccessToken('R_17bb3cecaae34f709d1fe0caa97c388a')
                             ->setFormat('json')
                             ->setVariableOutput('array')
                             ->setConnectionOptions(array(CURLOPT_PORT => 443, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0))
                             ->expand($customize)
                             ->getResponseData();
            
            $object_expand = (object) $expand;
            
            
            if( isset( $object_expand->data['expand'][0]['long_url']) ){
                
                echo 'Existe : '.$object_expand->data['expand'][0]['long_url'];
                
            }else{
                
                echo 'No Existe : '.$url.'/'.$customize.'<br><br>';
                
                $shorten = Bitly::setAccessToken('9a5f9b7aef94d95f5ed6631bf17716b96c39729c')
                                 ->setFormat('json')
                                 ->setVariableOutput('array')
                                 ->setConnectionOptions(array(CURLOPT_PORT => 443, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0))
                                 ->shorten($url)
                                 ->getResponseData();
                
                $object_shorten = (object) $shorten;
                
                $shorten_url = $object_shorten->data['url'];
                
                $shorten_hash = $object_shorten->data['hash'];
                
                echo 'Shorten URL : '.$shorten_url;
                
                $true = TRUE;
                
                $keyword_link = 'http://bit.ly/'.$customize;
                
                $target_link = 'http://bit.ly/'.$shorten_hash;
                
                $url = $bitly_oauth_api . "/v3/user/save_custom_domain_keyword?keyword_link=" . $keyword_link . "&access_token=" . $ACCESS_TOKEN . "&target_link=" . $target_link . "&overwrite=".$true;

                $output = json_decode(bitly_get_curl($url));

                print_r($output);
                
                
                
            }

            
            
            //return View::make('bitly.bitly_shorten',array('json'=>$json));

        }

    }
}
