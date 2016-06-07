<?php

Route::get('flickr/auth', function () {
    Flickering::handshake();
    return Flickering::getOpauth();
});

Route::any('flickr/oauth_callback', function () {
    Flickering::handshake();
    if (Request::getMethod() == 'POST') {
        Flickering::getOpauthCallback();
        return 'Authenticated!';
    } else {
        Flickering::getOpauth();
        return 'Being redirected..';
    }
});

class PDF extends FPDF
{
// Cargar los datos
    public function LoadData($file)
    {
        // Leer las líneas del fichero
        $lines = file($file);
        $data = array();
        foreach ($lines as $line) {
            $data[] = explode(';', trim($line));
        }

        return $data;
    }

// Tabla simple
    public function BasicTable($header, $data)
    {
        // Cabecera
        foreach ($header as $col) {
            $this->Cell(40, 7, $col, 1);
        }

        $this->Ln();
        // Datos
        foreach ($data as $row) {
            foreach ($row as $col) {
                $this->Cell(40, 6, $col, 1);
            }

            $this->Ln();
        }
    }

// Una tabla más completa
    public function ImprovedTable($header, $data)
    {
        // Anchuras de las columnas
        $w = array(40, 35, 45, 40);
        // Cabeceras
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        }

        $this->Ln();
        // Datos
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
            $this->Ln();
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }

// Tabla coloreada
    public function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Cabecera
        $w = array(40, 35, 45, 40);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }

        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

class FPDF_Protection extends PDF
{
    public $encrypted; //whether document is protected
    public $Uvalue; //U entry in pdf document
    public $Ovalue; //O entry in pdf document
    public $Pvalue; //P entry in pdf document
    public $enc_obj_id; //encryption object id
    public $last_rc4_key; //last RC4 key encrypted (cached for optimisation)
    public $last_rc4_key_c; //last RC4 computed key

    public function FPDF_Protection($orientation = 'P', $unit = 'mm', $format = 'A4')
    {
        parent::FPDF($orientation, $unit, $format);

        $this->encrypted = false;
        $this->last_rc4_key = '';
        $this->padding = "\x28\xBF\x4E\x5E\x4E\x75\x8A\x41\x64\x00\x4E\x56\xFF\xFA\x01\x08" .
            "\x2E\x2E\x00\xB6\xD0\x68\x3E\x80\x2F\x0C\xA9\xFE\x64\x53\x69\x7A";
    }

    public function SetProtection($permissions = array(), $user_pass = '', $owner_pass = null)
    {
        $options = array('print' => 4, 'modify' => 8, 'copy' => 16, 'annot-forms' => 32);
        $protection = 192;
        foreach ($permissions as $permission) {
            if (!isset($options[$permission])) {
                $this->Error('Incorrect permission: ' . $permission);
            }

            $protection += $options[$permission];
        }
        if ($owner_pass === null) {
            $owner_pass = uniqid(rand());
        }

        $this->encrypted = true;
        $this->_generateencryptionkey($user_pass, $owner_pass, $protection);
    }

/****************************************************************************
 *                                                                           *
 *                              Private methods                              *
 *                                                                           *
 ****************************************************************************/

    public function _putstream($s)
    {
        if ($this->encrypted) {
            $s = $this->_RC4($this->_objectkey($this->n), $s);
        }
        parent::_putstream($s);
    }

    public function _textstring($s)
    {
        if ($this->encrypted) {
            $s = $this->_RC4($this->_objectkey($this->n), $s);
        }
        return parent::_textstring($s);
    }

    /**
     * Compute key depending on object number where the encrypted data is stored
     */
    public function _objectkey($n)
    {
        return substr($this->_md5_16($this->encryption_key . pack('VXxx', $n)), 0, 10);
    }

    /**
     * Escape special characters
     */
    public function _escape($s)
    {
        $s = str_replace('\\', '\\\\', $s);
        $s = str_replace(')', '\\)', $s);
        $s = str_replace('(', '\\(', $s);
        $s = str_replace("\r", '\\r', $s);
        return $s;
    }

    public function _putresources()
    {
        parent::_putresources();
        if ($this->encrypted) {
            $this->_newobj();
            $this->enc_obj_id = $this->n;
            $this->_out('<<');
            $this->_putencryption();
            $this->_out('>>');
            $this->_out('endobj');
        }
    }

    public function _putencryption()
    {
        $this->_out('/Filter /Standard');
        $this->_out('/V 1');
        $this->_out('/R 2');
        $this->_out('/O (' . $this->_escape($this->Ovalue) . ')');
        $this->_out('/U (' . $this->_escape($this->Uvalue) . ')');
        $this->_out('/P ' . $this->Pvalue);
    }

    public function _puttrailer()
    {
        parent::_puttrailer();
        if ($this->encrypted) {
            $this->_out('/Encrypt ' . $this->enc_obj_id . ' 0 R');
            $this->_out('/ID [()()]');
        }
    }

    /**
     * RC4 is the standard encryption algorithm used in PDF format
     */
    public function _RC4($key, $text)
    {
        if ($this->last_rc4_key != $key) {
            $k = str_repeat($key, 256 / strlen($key) + 1);
            $rc4 = range(0, 255);
            $j = 0;
            for ($i = 0; $i < 256; $i++) {
                $t = $rc4[$i];
                $j = ($j + $t + ord($k{$i})) % 256;
                $rc4[$i] = $rc4[$j];
                $rc4[$j] = $t;
            }
            $this->last_rc4_key = $key;
            $this->last_rc4_key_c = $rc4;
        } else {
            $rc4 = $this->last_rc4_key_c;
        }

        $len = strlen($text);
        $a = 0;
        $b = 0;
        $out = '';
        for ($i = 0; $i < $len; $i++) {
            $a = ($a + 1) % 256;
            $t = $rc4[$a];
            $b = ($b + $t) % 256;
            $rc4[$a] = $rc4[$b];
            $rc4[$b] = $t;
            $k = $rc4[($rc4[$a] + $rc4[$b]) % 256];
            $out .= chr(ord($text{$i}) ^ $k);
        }

        return $out;
    }

    /**
     * Get MD5 as binary string
     */
    public function _md5_16($string)
    {
        return pack('H*', md5($string));
    }

    /**
     * Compute O value
     */
    public function _Ovalue($user_pass, $owner_pass)
    {
        $tmp = $this->_md5_16($owner_pass);
        $owner_RC4_key = substr($tmp, 0, 5);
        return $this->_RC4($owner_RC4_key, $user_pass);
    }

    /**
     * Compute U value
     */
    public function _Uvalue()
    {
        return $this->_RC4($this->encryption_key, $this->padding);
    }

    /**
     * Compute encryption key
     */
    public function _generateencryptionkey($user_pass, $owner_pass, $protection)
    {
        // Pad passwords
        $user_pass = substr($user_pass . $this->padding, 0, 32);
        $owner_pass = substr($owner_pass . $this->padding, 0, 32);
        // Compute O value
        $this->Ovalue = $this->_Ovalue($user_pass, $owner_pass);
        // Compute encyption key
        $tmp = $this->_md5_16($user_pass . $this->Ovalue . chr($protection) . "\xFF\xFF\xFF");
        $this->encryption_key = substr($tmp, 0, 5);
        // Compute U value
        $this->Uvalue = $this->_Uvalue();
        // Compute P value
        $this->Pvalue = -(($protection ^ 255) + 1);
    }
}

// Controller to set Language
Route::get('/locale/{locale}', 'BaseController@setLocale');

// Controller for users and roles
Route::controller('user', 'UsersController');
Route::controller('escaleta/{program_id?}', 'escaletaController');

/* Login Oauth Google configuration */
Route::get('social/{action?}', array('as' => 'hybridauth', 'uses' => 'UsersController@loginGoogle'));

Route::get('social2/{action?}', array('as' => 'hybridauth', 'uses' => 'ShareController@loginFacebook'));

Route::get('social3/{action?}', array('as' => 'hybridauth', 'uses' => 'UsersController@loginInstagram'));

Route::get('/', array('before' => array('auth'), function () {
    $user = Sentry::getUser();
    echo "<!-- " . gethostname() . " -->";

    return View::make(Config::get('app.main_template') . '.home.welcome');
}));

Route::controller('roles', 'RolesController');
Route::controller('contest', 'ContestController');
Route::controller('question', 'QuestionController');
Route::controller('rewards', 'RewardsController');
Route::controller('admin', 'AdminController');
Route::controller('comments', 'CommentsController');

Route::controller('/report-registered/{contest_id}', 'registeredController');
Route::get('/report-participant/{contest_id}', 'participantController@getParticipants');
Route::controller('report','ReportsController');
Route::controller('/bitly/', 'BitlyController');

Route::controller('landing', 'LandingController');
Route::controller('links-share', 'SharedController');
Route::controller('qrcode', 'QrController');
Route::controller('photos', 'PhotosController');
Route::controller('fotos', 'FotosController');
Route::controller('videos', 'VideosController');
Route::controller('ultima-hora', 'UltimaHoraController'); //Joel Soto
Route::controller('social-hub', 'SocialHubController');
Route::controller('demo-album', 'StickersController'); //Joel Soto
Route::controller('admin-stickers', 'AdminStickersController'); //Joel Soto
Route::controller('firebase-vl', 'FirebaseVlController'); //Joel Soto
Route::controller('ccanje', 'CentroDeCanjeController');
Route::controller('notifications', 'NotificationController');
Route::controller('timeline', 'TimelineController');

Route::controller('premios', 'PremiosController');

Route::get('graficas', function () {

    $id = 11;
    $query = DB::connection('mysql2')->select("SELECT count(*) as 'totalUsers',COUNT(IF(gender ='male',1,null)) as 'usersMale',COUNT(IF(gender ='female',1,null)) as 'usersFemale' from users where contest_id=?", array($id));
    $label = array('Total Usuarios', 'Hombre', 'Mujer');
    $value = array('totalUsers', 'usersMale', 'usersFemale');
    $total = count((array) $query[0]);
    $data = [];
    for ($i = 0; $i < $total; $i++) {
        $data[$i]['label'] = $label[$i];
        $data[$i]['value'] = $query[0]->$value[$i];
    }

    $querySocial = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'socialMale',COUNT(IF(gender ='female',1,null)) as 'socialFemale' from users u INNER JOIN social_network sn on(u.id=sn.user_id) where u.contest_id=? GROUP BY social_network", array($id));
    $label = array('Hombre', 'Mujer');
    $value = array('socialMale', 'socialFemale');
    $totalSocial = count((array) $querySocial[0]);
    $dataSocial = [];

    /*echo "<pre>";
    print_r($totalSocial);
    echo "</pre>";*/

    //return "hola";
    return View::make('graficas')->with(array('data' => json_encode($data), 'dataSocial' => $dataSocial, 'dataEdad' => $dataSocial, 'Edad' => $dataSocial));

});

Route::get('fbmltim', function () {
    return View::make('fbmltim');
});


Route::get('/test', function (){
       TG::sendMsg('Gabriel_Mancera', 'Hello there!');
});


Route::get('instagram/{process?}',
    array('as' => 'hybridauth', 'before' => 'guest', function($process = null)
    {

        require_once(base_path()."/vendor/php-rql/rdb/rdb.php");

        try {

            $conn  =  r\connect( Config::get('rethinkdb.server_db_ip') );
            $db = r\db( Config::get('rethinkdb.name_db') );

            $name_table = 'instagrams';

            $existTable = $db->tableList()->contains($name_table)->run($conn);

            if(!$existTable){
                $db->tableCreate($name_table)->run( $conn);
            }

        } catch (Exception $e) {
            echo $e;
        }

        if ($process == "auth") { // check URL segment
            try { // process authentication
                Hybrid_Endpoint::process();
            }catch (Exception $e) {
                return Redirect::to('instagram');
            }
            return;
        }

        try
        {
            if (App::environment('local')){
                $hybridauth = new Hybrid_Auth(app_path() . '/config/local/hybridauth_inst.php');
            }elseif (App::environment('staging')) {
                $hybridauth = new Hybrid_Auth(app_path() . '/config/staging/hybridauth_inst.php');
            }elseif (App::environment('aws')) {
                $hybridauth = new Hybrid_Auth(app_path() . '/config/aws/hybridauth_inst.php');
            }else{
                $hybridauth = new Hybrid_Auth(app_path() . '/config/hybridauth_inst.php');
            }

            $provider = $hybridauth->authenticate('Instagram');
            $user_profile = $provider->getUserProfile();

            try {

                $token =  $provider->adapter->api->access_token;

                $exist_token = $db->table( Config::get('rethinkdb.table_instagram') )->filter(array('token'=>$token))->count()->run($conn);

                if($exist_token == 0){

                    $db->table($name_table)->insert(array('id_user'=>$user_profile->identifier,'name'=>$user_profile->displayName,'photo'=>$user_profile->photoURL,'screen_name'=>$user_profile->username, 'token' => $provider->adapter->api->access_token,'tweets'=>array()))->run($conn);

                    try {

                        $url = "https://api.instagram.com/v1/subscriptions/";
                        $callback_url = "http://promociones.televisa.com/instagram_callback";

                        $client_id = "*";
                        $client_secret = "*";

                        $data = array(
                                    'client_id' => $client_id,
                                    'client_secret' => $client_secret,
                                    'object' => 'user',
                                    'aspect' => 'media',
                                    'verify_token' => $token,
                                    'client_id' => $client_id,
                                    'callback_url' => $callback_url
                                    );
                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        curl_close ($ch);
                        #print_r($result);
                    } catch (Exception $e) {
                        echo 'Message: ' .$e->getMessage();
                    }

                    echo "Gracias por subscribirte <br>";
                }else{

                    echo "Ya estas subscrito. <br>";
                }

            } catch (Exception $e) {
                echo $e;
            }

        }
        catch (Exception $e)
        {
            Log::notice($e);
            return 'Authentication Failed.';
        }
    })
);
