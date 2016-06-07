<?php

class registeredController extends Controller {
    
    protected $qSocialRegistered = ['sn.social_network','count(*) as socialNetwork','social_network AS sn','users.id','sn.user_id','users.contest_id','social_network'];
    protected $qTotalRegistered  = ['social_network','count(*) as socialNetworkTotal','contest_id'];
    protected $promocion = 'registered';
    
    protected $qGenderRegistered = ['sn.social_network',"COUNT(IF(gender ='male',1,null)) as 'ageMale'","COUNT(IF(gender ='female',1,null)) as 'ageFemale'","count(*) as ageTotal","social_network AS sn","users.id","sn.user_id", "users.contest_id","social_network"];
    protected $qMaleRegistered   = ['sn.social_network',"COUNT(IF(gender ='male',1,null)) as 'ageMale'",'social_network AS sn','users.id','sn.user_id', 'users.contest_id'];
    protected $qFemaleRegistered = ['sn.social_network',"COUNT(IF(gender ='female',1,null)) as 'ageFemale'",'social_network AS sn','users.id','sn.user_id','users.contest_id'];
    
    protected $qAgeRegistered       = ['age',"COUNT(IF(gender ='male',1,null)) as 'ageMale'","COUNT(IF(gender ='female',1,null)) as 'ageFemale'",'count(*) as ageTotal','age','contest_id','age'];
    protected $qAgeTotalRegistered  = ['age','count(*) as ageTotal','age','contest_id'];
    protected $qAgeMaleRegistered   = ['age',"COUNT(IF(gender ='male',1,null)) as 'ageMale'",'age','contest_id']; 
    protected $qAgeFemaleRegistered = ['age',"COUNT(IF(gender ='female',1,null)) as 'ageFemale'",'age','contest_id'];    
    
    protected $qCountryRegistered       = ['country',"COUNT(IF(gender ='male',1,null)) as 'countryMale'","COUNT(IF(gender ='female',1,null)) as 'countryFemale'", 'count(*) as countryTotal','country','contest_id','country'];
    protected $qCountryTotalRegistered  = ['country','count(*) as countryTotal','country','contest_id'];
    protected $qCountryMaleRegistered   = ['country',"COUNT(IF(gender ='male',1,null)) as 'countryMale'",'country','contest_id'];  
    protected $qCountryFemaleRegistered = ['country',"COUNT(IF(gender ='female',1,null)) as 'countryFemale'",'country','contest_id'];
    
    protected $qDayRegistered       = ["date(created_at) as 'dia'","COUNT(IF(gender ='male',1,null)) as 'dayMale'","COUNT(IF(gender ='female',1,null)) as 'dayFemale'", 'count(*) as dayTotal','created_at','contest_id','dia'];
    protected $qDayTotalRegistered  = ["date(created_at)","count(*) as dayTotal","created_at","contest_id"];
    protected $qDayMaleRegistered   = ["date(created_at)","COUNT(IF(gender ='male',1,null)) as 'dayMale'","created_at","contest_id"];
    protected $qDayFemaleRegistered = ["date(created_at)","COUNT(IF(gender ='female',1,null)) as 'dayFemale'","created_at","contest_id"];     
    
    protected $qStateRegistered = ['state', "COUNT(IF(gender ='male',1,null)) as 'stateMale'","COUNT(IF(gender ='female',1,null)) as 'stateFemale'", 'count(*) as stateTotal','state','contest_id','state'];
    protected $qStateTotalRegistered = ['state',"count(*) as stateTotal","created_at","contest_id"];
    protected $qStateMaleRegistered    = ['state',"COUNT(IF(gender ='male',1,null)) as 'stateMale'","created_at", "contest_id"];     
    protected $qStateFemaleRegistered = ['state',"COUNT(IF(gender ='female',1,null)) as 'stateFemale'",'created_at','contest_id'];

    protected $qdRegistered  = ["date_format(created_at,'%H') as 'hours'","COUNT(IF(gender ='male',1,null)) as 'hoursMale'","COUNT(IF(gender ='female',1,null)) as 'hoursFemale'","count(*) as hoursTotal","created_at","contest_id","hours"];
    protected $qHtRegistered = ["date_format(created_at,'%H:%i:%s') as 'hours'","COUNT(IF(gender ='male',1,null)) as 'hoursMale'","COUNT(IF(gender ='female',1,null)) as 'hoursFemale'", "count(*) as hoursTotal","created_at","contest_id"];
    protected $gHmRegistered = ["date(created_at)","COUNT(IF(gender ='male',1,null)) as 'hoursMale'","created_at","contest_id"];
    protected $gHfRegistered = ["date(created_at)","COUNT(IF(gender ='female',1,null)) as 'hoursFemale'","created_at","contest_id"];
    
    public function getIndex($contest_id){
        
        if(is_int(intval($contest_id))== TRUE && is_int(intval($contest_id))!= NULL){
            
            $socialRegistered = $this->getSocialRegistered($contest_id);
            //return $socialRegistered['socialTotal'][2]->socialNetwork;
            $socialGender     = $this->getSocialGender($contest_id);
            $socialAge        = $this->getSocialAge($contest_id);
            $socialCountry    = $this->getSocialCountry($contest_id);
            $socialDay        = $this->getSocialDay($contest_id);
            $socialState      = $this->getSocialState($contest_id);

            //return $socialGender['socialMaleTotal'][0]->ageMale+1;
            //return $contest_id;
            return View::make(Config::get( 'app.main_template' ).'.graph.registered',array('qSocial_network' => $socialRegistered['qSocial_network'],
                                                       'socialTotal'=>$socialRegistered['socialTotal'],
                                                       'qSocialGender'=>$socialGender['qSocialGender'],
                                                       'socialMaleTotal'=>$socialGender['socialMaleTotal'],
                                                       'socialFemaleTotal'=>$socialGender['socialFemaleTotal'],
                                                       'dataAge'=>$socialAge['dataAge'],
                                                       'dataAgeTotal'=>$socialAge['dataAgeTotal'],
                                                       'dataAgeMale'=>$socialAge['dataAgeMale'],
                                                       'dataAgeFemale'=>$socialAge['dataAgeFemale'],
                                                       'dataCountry'=>$socialCountry['dataCountry'],
                                                       'dataCountryTotal'=>$socialCountry['dataCountryTotal'],
                                                       'dataCountryMale'=>$socialCountry['dataCountryMale'],
                                                       'dataCountryFemale'=>$socialCountry['dataCountryFemale'],
                                                       'dataDay'=>$socialDay['dataDay'],
                                                       'dataDayTotal'=>$socialDay['dataDayTotal'],
                                                       'dataDayMale'=>$socialDay['dataDayMale'],
                                                       'dataDayFemale'=>$socialDay['dataDayFemale'],
                                                       'dataState'=>$socialState['dataState'],
                                                       'dataStateTotal'=>$socialState['dataStateTotal'],
                                                       'dataStateMale'=>$socialState['dataStateMale'],
                                                       'dataStateFemale'=>$socialState['dataStateFemale'],
                                                       'contest_id'=>$contest_id));
            
        }else{ var_dump(is_int(intval($contest_id))); 
        echo gettype(intval($contest_id));
        }
        
    }
    
  //--------------------  Total de Usuarios Registrados  ---------------------//

    public function getSocialRegistered($contest_id) {
        
        if(is_int(intval($contest_id))== TRUE ){
            
            if($this->promocion=='registered'){
                
                $qSocial_network = Users::join($this->qSocialRegistered[2],$this->qSocialRegistered[3],'=',$this->qSocialRegistered[4])
                                    ->where($this->qSocialRegistered[5],'=',$contest_id)
                                    ->groupBy($this->qSocialRegistered[6])
                                    ->get(array($this->qSocialRegistered[0],DB::raw($this->qSocialRegistered[1])));  
            
                $socialTotal = SocialNetwork::where($this->qTotalRegistered[2],'=',$contest_id)
                                            ->get(array($this->qTotalRegistered[0],DB::raw($this->qTotalRegistered[1])));
                

                
            }else if($this->promocion=='participants'){

                $contest = Contest::find($id);

                if (strtolower($contest->contest_type)=='frase') {
                
                    $qSocial_network = Phrase::join($this->qSocialRegistered[2],$this->qSocialRegistered[3],'=',$this->qSocialRegistered[4])
                                             ->where($this->qSocialRegistered[5],'=',$contest_id)
                                             ->groupBy($this->qSocialRegistered[6])
                                             ->get(array($this->qSocialRegistered[0],DB::raw($this->qSocialRegistered[1]))); 

                    $socialTotal = Phrase::join($this->qSocialRegistered[2],$this->qSocialRegistered[3],'=',$this->qSocialRegistered[4])
                                         ->where($this->qTotalRegistered[5],'=',$contest_id)
                                         ->get(array($this->qTotalRegistered[0],DB::raw($this->qTotalRegistered[1]))); 
                }elseif ($contest->contest_type=='quiz') {

                    $qSocial_network = QuestionAnswers::join($this->qSocialRegistered[2],$this->qSocialRegistered[3],'=',$this->qSocialRegistered[4])
                                             ->where($this->qSocialRegistered[5],'=',$contest_id)
                                             ->groupBy($this->qSocialRegistered[6])
                                             ->get(array($this->qSocialRegistered[0],DB::raw($this->qSocialRegistered[1]))); 

                    $socialTotal = QuestionAnswers::join($this->qSocialRegistered[2],$this->qSocialRegistered[3],'=',$this->qSocialRegistered[4])
                                         ->where($this->qTotalRegistered[5],'=',$contest_id)
                                         ->get(array($this->qTotalRegistered[0],DB::raw($this->qTotalRegistered[1]))); 
                }
            }

            if ((isset($qSocial_network) && $qSocial_network != NULL) && (isset($socialTotal) && $socialTotal != NULL) ) {

                return array('qSocial_network' => $qSocial_network, 'socialTotal'=>$socialTotal);

            }else{echo "Base de Datos sin Registros getUsers()".'<br>';}

            
        }else{ echo "Error"; }     
        
    }
    
    //------------------  Usuarios Registrados Genero  ----------------------//
           
    public function getSocialGender($contest_id) {
        
        if(is_int(intval($contest_id))== TRUE ){

            if($this->promocion=='registered'){
                
               $qSocialGender = Users::join($this->qGenderRegistered[4],$this->qGenderRegistered[5],'=',$this->qGenderRegistered[6])
                    ->where($this->qGenderRegistered[7],'=',$contest_id)
                    ->groupBy($this->qGenderRegistered[8])
                    ->get(array($this->qGenderRegistered[0],DB::raw($this->qGenderRegistered[1]),DB::raw($this->qGenderRegistered[2]),DB::raw($this->qGenderRegistered[3])));
    
                $socialMaleTotal = Users::join($this->qMaleRegistered[2],$this->qMaleRegistered[3],'=',$this->qMaleRegistered[4])
                        ->where($this->qMaleRegistered[5],'=',$contest_id)
                        ->get(array($this->qMaleRegistered[0],DB::raw($this->qMaleRegistered[1])));

                $socialFemaleTotal = Users::join($this->qFemaleRegistered[2],$this->qFemaleRegistered[3],'=',$this->qFemaleRegistered[4])
                        ->where($this->qFemaleRegistered[5],'=',$contest_id)
                        ->get(array($this->qFemaleRegistered[0],DB::raw($this->qFemaleRegistered[1])));
                
            }else if($this->promocion=='participants'){
                
                $qSocialGender = Users::join($this->qGenderRegistered[4],$this->qGenderRegistered[5],'=',$this->qGenderRegistered[6])
                      ->join($this->qGenderRegistered[7],$this->qGenderRegistered[8],'=',$this->qGenderRegistered[9])
                      ->where($this->qGenderRegistered[10],'=',$contest_id) 
                      ->groupBy($this->qGenderRegistered[11])
                      ->get(array($this->qGenderRegistered[0],DB::raw($this->qGenderRegistered[1]),DB::raw($this->qGenderRegistered[2]),DB::raw($this->qGenderRegistered[3]))); 
        
                $socialMaleTotal = Users::join($this->qMaleRegistered[2],$this->qMaleRegistered[3],'=',$this->qMaleRegistered[4])
                                        ->join($this->qMaleRegistered[5],$this->qMaleRegistered[6],'=',$this->qMaleRegistered[7])
                                        ->where($this->qMaleRegistered[8],'=',$contest_id)
                                        ->get(array($this->qMaleRegistered[0],DB::raw($this->qMaleRegistered[1])));

                $socialFemaleTotal = Users::join($this->qFemaleRegistered[2],$this->qFemaleRegistered[3],'=',$this->qFemaleRegistered[4])
                                           ->join($this->qFemaleRegistered[5],$this->qFemaleRegistered[6],'=',$this->qFemaleRegistered[7])
                                           ->where($this->qFemaleRegistered[8],'=',$contest_id)
                                           ->get(array($this->qFemaleRegistered[0],DB::raw($this->qFemaleRegistered[1])));   
            }

            
             if ((isset($qSocialGender) && $qSocialGender != NULL)&&(isset($socialMaleTotal) && $socialMaleTotal != NULL)&&(isset($socialFemaleTotal) && $socialFemaleTotal != NULL)){
                 
                 return  array('qSocialGender' => $qSocialGender,'socialMaleTotal'=>$socialMaleTotal,'socialFemaleTotal'=>$socialFemaleTotal);
                 
             }else{echo "Base de Datos sin Registros getGender()".'<br>';} 
             
        }else{ echo "Error";}
    }
    
    //-------------------- Usuarios Registrados por Edad ---------------------// 
    
    public  function getSocialAge($contest_id){
        
        if(is_int(intval($contest_id))== TRUE ){
            
            if($this->promocion=='registered'){
                
                $qUsersAge = Users::where($this->qAgeRegistered[4],'!=','')
                   ->where($this->qAgeRegistered[5],'=',$contest_id)
                   ->groupBy($this->qAgeRegistered[6])
                   ->get(array($this->qAgeRegistered[0],DB::raw($this->qAgeRegistered[1]),DB::raw($this->qAgeRegistered[2]),DB::raw($this->qAgeRegistered[3])));
                $dataAge = json_encode($qUsersAge);

                $dataAgeTotal = Users::where($this->qAgeTotalRegistered[2],'!=','')
                                     ->where($this->qAgeTotalRegistered[3],'=',$contest_id)
                                     ->get(array($this->qAgeTotalRegistered[0],DB::raw($this->qAgeTotalRegistered[1])));

                $dataAgeMale = Users::where($this->qAgeMaleRegistered[2],'!=','')
                                    ->where($this->qAgeMaleRegistered[3],'=',$contest_id)
                                    ->get(array($this->qAgeMaleRegistered[0],DB::raw($this->qAgeMaleRegistered[1])));

                $dataAgeFemale = Users::where($this->qAgeFemaleRegistered[2],'!=','')
                                    ->where($this->qAgeFemaleRegistered[3],'=',$contest_id)
                                    ->get(array($this->qAgeFemaleRegistered[0],DB::raw($this->qAgeFemaleRegistered[1])));
                
            }else if($this->promocion=='participants'){
                
                $qUsersAge = Users::join($this->qAgeRegistered [4],$this->qAgeRegistered [5],'=',$this->qAgeRegistered [6])
                                       ->where($this->qAgeRegistered[7],'!=','')
                                       ->where($this->qAgeRegistered[8],'=',$contest_id)
                                       ->groupBy($this->qAgeRegistered[9])
                                       ->get(array($this->qAgeRegistered[0],DB::raw($this->qAgeRegistered[1]),DB::raw($this->qAgeRegistered[2]),DB::raw($this->qAgeRegistered[3])));
                $dataAge = json_encode($qUsersAge);
                
                $dataAgeTotal = Users::join($this->qAgeTotalRegistered[2],$this->qAgeTotalRegistered[3],'=',$this->qAgeTotalRegistered[4])
                                         ->where($this->qAgeTotalRegistered[5],'!=','')
                                         ->where($this->qAgeTotalRegistered[6],'=',$contest_id)
                                         ->get(array($this->qAgeTotalRegistered[0],DB::raw($this->qAgeTotalRegistered[1])));

                $dataAgeMale = Users::join($this->qAgeMaleRegistered[2],$this->qAgeMaleRegistered[3],'=',$this->qAgeMaleRegistered[4])
                                    ->where($this->qAgeMaleRegistered[5],'!=','')
                                    ->where($this->qAgeMaleRegistered[6],'=',$contest_id)
                                    ->get(array($this->qAgeMaleRegistered[0],DB::raw($this->qAgeMaleRegistered[1])));

                $dataAgeFemale = Users::join($this->qAgeFemaleRegistered[2],$this->qAgeFemaleRegistered[3],'=',$this->qAgeFemaleRegistered[4])
                                      ->where($this->qAgeFemaleRegistered[5],'!=','')
                                      ->where($this->qAgeFemaleRegistered[6],'=',$contest_id)
                                      ->get(array($this->qAgeFemaleRegistered[0],DB::raw($this->qAgeFemaleRegistered[1])));                  
            }
            
            if ((isset($qUsersAge) && $qUsersAge != NULL) && (isset($dataAgeTotal) && $dataAgeTotal != NULL) && (isset($dataAgeMale) && $dataAgeMale != NULL) && (isset($dataAgeFemale) && $dataAgeFemale != NULL)){
                
                return array('dataAge'=>$dataAge,'dataAgeTotal'=>$dataAgeTotal,'dataAgeMale'=>$dataAgeMale,'dataAgeFemale'=>$dataAgeFemale); 
             
            } else{ echo "Base de Datos sin Registros getDataage()".'<br>';}
            
        }else{ echo"Error"; }
    }
    
    //---------------------- Total de Registros por País ----------------------//
    
    public function getSocialCountry($contest_id){
        
        if(is_int(intval($contest_id))== TRUE){
            
            if($this->promocion=='registered'){
                $qUsersCountry = Users::where($this->qCountryRegistered[4],'!=','')
                                       ->where($this->qCountryRegistered[5],'=',$contest_id)
                                       ->groupBy($this->qCountryRegistered[6])
                                       ->get(array($this->qCountryRegistered[0],DB::raw($this->qCountryRegistered[1]),DB::raw($this->qCountryRegistered[2]),DB::raw($this->qCountryRegistered[3])));
                $dataCountry = json_encode($qUsersCountry);

                $dataCountryTotal = Users::where($this->qCountryTotalRegistered[2],'!=','')
                                     ->where($this->qCountryTotalRegistered[3],'=',$contest_id)
                                     ->get(array($this->qCountryTotalRegistered[0],DB::raw($this->qCountryTotalRegistered[1])));

                $dataCountryMale = Users::where($this->qCountryMaleRegistered[2],'!=','')
                                    ->where($this->qCountryMaleRegistered[3],'=',$contest_id)
                                    ->get(array($this->qCountryMaleRegistered[0],DB::raw($this->qCountryMaleRegistered[1])));

                $dataCountryFemale = Users::where($this->qCountryFemaleRegistered[2],'!=','')
                                    ->where($this->qCountryFemaleRegistered[3],'=',$contest_id)
                                    ->get(array($this->qCountryFemaleRegistered[0],DB::raw($this->qCountryFemaleRegistered[1])));                
            }else if($this->promocion=='participants'){
                
                $qUsersCountry = Users::join($this->qCountryRegistered[4],$this->qCountryRegistered[5],'=',$this->qCountryRegistered[6])
                                      ->where($this->qCountryRegistered[7],'!=','')
                                      ->where($this->qCountryRegistered[8],'=',$contest_id)
                                      ->groupBy($this->qCountryRegistered[9])
                                      ->get(array($this->qCountryRegistered[0],DB::raw($this->qCountryRegistered[1]),DB::raw($this->qCountryRegistered[2]),DB::raw($this->qCountryRegistered[3])));
                $dataCountry = json_encode($qUsersCountry);
                
                $dataCountryTotal = Users::join($this->qCountryTotalRegistered[2],$this->qCountryTotalRegistered[3],'=',$this->qCountryTotalRegistered[4])
                                         ->where($this->qCountryTotalRegistered[5],'!=','')
                                         ->where($this->qCountryTotalRegistered[6],'=',$contest_id)
                                         ->get(array($this->qCountryTotalRegistered[0],DB::raw($this->qCountryTotalRegistered[1])));

                $dataCountryMale = Users::join($this->qCountryMaleRegistered[1],$this->qCountryMaleRegistered[2],'=',$this->qCountryMaleRegistered[3])
                                        ->where($this->qCountryMaleRegistered[4],'!=','')
                                        ->where($this->qCountryMaleRegistered[5],'=',$contest_id)
                                        ->get(array(DB::raw($this->qCountryMaleRegistered[0])));   

                $dataCountryFemale = Users::join($this->qCountryFemaleRegistered[1],$this->qCountryFemaleRegistered[2],'=',$this->qCountryFemaleRegistered[3])
                                          ->where($this->qCountryFemaleRegistered[4],'!=','')
                                          ->where($this->qCountryFemaleRegistered[5],'=',$contest_id)
                                          ->get(array(DB::raw($this->qCountryFemaleRegistered[0])));                 
            }
            

            
            if ((isset($qUsersCountry) && $qUsersCountry != NULL)&&(isset($dataCountryTotal) && $dataCountryTotal != NULL)&&(isset($dataCountryMale) && $dataCountryMale != NULL)&&(isset($dataCountryFemale) && $dataCountryFemale != NULL)){
                
                return array('dataCountry'=>$dataCountry,'dataCountryTotal'=>$dataCountryTotal,'dataCountryMale'=>$dataCountryMale,'dataCountryFemale'=>$dataCountryFemale);
                
            } else{echo "Base de Datos sin Registros getCountry()".'<br>';}
            
        } else{ echo "Error"; }
    }
    
    //------------------- Usuarios Registrados por Día -----------------------//   
    
    public function getSocialDay($contest_id){
        
        if(is_int(intval($contest_id))== TRUE){
            
            if($this->promocion=='registered'){
                
                $qUsersDay = Users::where($this->qDayRegistered[4],'!=','')
                                   ->where($this->qDayRegistered[5],'=',$contest_id)
                                   ->groupBy($this->qDayRegistered[6])
                                   ->get(array(DB::raw($this->qDayRegistered[0]),DB::raw($this->qDayRegistered[1]),DB::raw($this->qDayRegistered[2]),DB::raw($this->qDayRegistered[3])));
                $dataDay = json_encode($qUsersDay);

                $dataDayTotal = Users::where($this->qDayTotalRegistered[2],'!=','')
                                     ->where($this->qDayTotalRegistered[3],'=',$contest_id)
                                     ->get(array(DB::raw($this->qDayTotalRegistered[0]),DB::raw($this->qDayTotalRegistered[1])));

                $dataDayMale = Users::where($this->qDayMaleRegistered[2],'!=','')
                                    ->where($this->qDayMaleRegistered[3],'=',$contest_id)
                                    ->get(array(DB::raw($this->qDayMaleRegistered[0]),DB::raw($this->qDayMaleRegistered[1])));

                $dataDayFemale = Users::where($this->qDayFemaleRegistered[2],'!=','')
                                    ->where($this->qDayFemaleRegistered[3],'=',$contest_id)
                                    ->get(array(DB::raw($this->qDayFemaleRegistered[0]),DB::raw($this->qDayFemaleRegistered[1])));                 
            }else if($this->promocion=='participants'){
                
                $qUsersDay = Users::join($this->qDayRegistered[4],$this->qDayRegistered[5],'=',$this->qDayRegistered[6])
                                  ->where($this->qDayRegistered[7],'!=','')
                                  ->where($this->qDayRegistered[8],'=',$contest_id)
                                  ->groupBy($this->qDayRegistered[9])
                                  ->get(array(DB::raw($this->qDayRegistered[0]),DB::raw($this->qDayRegistered[1]),DB::raw($this->qDayRegistered[2]),DB::raw($this->qDayRegistered[3])));
                $dataDay = json_encode($qUsersDay);
                
                $dataDayTotal = Users::join($this->qDayTotalRegistered[2],$this->qDayTotalRegistered[3],'=',$this->qDayTotalRegistered[4])
                                     ->where($this->qDayTotalRegistered[5],'!=','')
                                     ->where($this->qDayTotalRegistered[6],'=',$contest_id)
                                     ->get(array(DB::raw($this->qDayTotalRegistered[0]),DB::raw($this->qDayTotalRegistered[1])));

                $dataDayMale = Users::join($this->qDayMaleRegistered[2],$this->qDayMaleRegistered[3],'=',$this->qDayMaleRegistered[4])
                                    ->where($this->qDayMaleRegistered[5],'!=','')
                                    ->where($this->qDayMaleRegistered[6],'=',$contest_id)
                                    ->get(array(DB::raw($this->qDayMaleRegistered[0]),DB::raw($this->qDayMaleRegistered[1])));  

                $dataDayFemale = Users::join($this->qDayFemaleRegistered[2],$this->qDayFemaleRegistered[3],'=',$this->qDayFemaleRegistered[4])
                                      ->where($this->qDayFemaleRegistered[5],'!=','')
                                      ->where($this->qDayFemaleRegistered[6],'=',$contest_id)
                                      ->get(array(DB::raw($this->qDayFemaleRegistered[0]),DB::raw($this->qDayFemaleRegistered[1])));                 
            }                       
            
            
            if ((isset($qUsersDay) && $qUsersDay != NULL)&&(isset($dataDayTotal) && $dataDayTotal != NULL)&&(isset($dataDayMale) && $dataDayMale != NULL)&&(isset($dataDayFemale) && $dataDayFemale != NULL)){
                
                return array('dataDay'=>$dataDay,'dataDayTotal'=>$dataDayTotal,'dataDayMale'=>$dataDayMale,'dataDayFemale'=>$dataDayFemale);    
              
            } else{echo "Base de Datos sin Registros getDay()".'<br>';}  
            
        } else{ echo "Error"; }
    }
    //--------------------- Total de Registros por Estado  -----------------------//  


    
    public function getSocialState($contest_id){
        
        if(is_int(intval($contest_id))== TRUE){
            
            if($this->promocion=='registered'){
                
                $qUserState = Users::where($this->qStateRegistered[4],'!=','')
                                   ->where($this->qStateRegistered[5],'=',$contest_id)
                                   ->groupBy($this->qStateRegistered[6])
                                   ->get(array($this->qStateRegistered[0],DB::raw($this->qStateRegistered[1]),DB::raw($this->qStateRegistered[2]),DB::raw($this->qStateRegistered[3])));
                $dataState = json_encode($qUserState);

                $dataStateTotal = Users::where($this->qStateTotalRegistered[2],'!=','')
                                         ->where($this->qStateTotalRegistered[3],'=',$contest_id)
                                         ->get(array($this->qStateTotalRegistered[0],DB::raw($this->qStateTotalRegistered[1])));            

                $dataStateMale = Users::where($this->qStateMaleRegistered[2],'!=','')
                                        ->where($this->qStateMaleRegistered[3],'=',$contest_id)
                                        ->get(array($this->qStateMaleRegistered[0],DB::raw($this->qStateMaleRegistered[1]))); 

                $dataStateFemale = Users::where($this->qStateFemaleRegistered[2],'!=','')
                                        ->where($this->qStateFemaleRegistered[3],'=',$contest_id)
                                        ->get(array($this->qStateFemaleRegistered[0],DB::raw($this->qStateFemaleRegistered[1])));                  
            }else if($this->promocion=='participants'){
                
                $qUserState = Users::join($this->qStateRegistered[4],$this->qStateRegistered[5],'=',$this->qStateRegistered[6])
                                   ->where($this->qStateRegistered[7],'!=','')
                                   ->where($this->qStateRegistered[8],'=',$contest_id)
                                   ->groupBy($this->qStateRegistered[9])
                                   ->get(array($this->qStateRegistered[0],DB::raw($this->qStateRegistered[1]),DB::raw($this->qStateRegistered[2]),DB::raw($this->qStateRegistered[3])));
                $dataState = json_encode($qUserState);
                
                $dataStateTotal = Users::join($this->qStateTotalRegistered[2],$this->qStateTotalRegistered[3],'=',$this->qStateTotalRegistered[4])
                                       ->where($this->qStateTotalRegistered[5],'!=','')
                                       ->where($this->qStateTotalRegistered[6],'=',$contest_id)
                                       ->get(array($this->qStateTotalRegistered[0],DB::raw($this->qStateTotalRegistered[1]))); 

                $dataStateMale = Users::join($this->qStateMaleRegistered[2],$this->qStateMaleRegistered[3],'=',$this->qStateMaleRegistered[4])
                                      ->where($this->qStateMaleRegistered[5],'!=','')
                                      ->where($this->qStateMaleRegistered[6],'=',$contest_id)
                                      ->get(array($this->qStateMaleRegistered[0],DB::raw($this->qStateMaleRegistered[1]))); 

                $dataStateFemale = Users::join($this->qStateFemaleRegistered[2],$this->qStateFemaleRegistered[3],'=',$this->qStateFemaleRegistered[4])
                                        ->where($this->qStateFemaleRegistered[5],'!=','')
                                        ->where($this->qStateFemaleRegistered[6],'=',$contest_id)
                                        ->get(array($this->qStateFemaleRegistered[0],DB::raw($this->qStateFemaleRegistered[1])));                 
            }            
            
            if ((isset($qUserState) && $qUserState != NULL)&&(isset($dataStateTotal) && $dataStateTotal != NULL)&&(isset($dataStateMale) && $dataStateMale != NULL)&&(isset($dataStateFemale) && $dataStateFemale != NULL)){
                
                return array('dataState'=>$dataState,'dataStateTotal'=>$dataStateTotal,'dataStateMale'=>$dataStateMale,'dataStateFemale'=>$dataStateFemale);
           
            } else{ echo "Base de Datos sin Registros getState()".'<br>';}
            
        } else{ echo "Error"; }
    }
    
    //---------------------- Total de Participantes por Hora  ----------------//    

    public function getData($contest_id){
        
        if(is_int(intval($contest_id))== TRUE){
            
            $dataHours=0;

            if(Request::ajax()){

                $dataPicker = Input::get("datepicker");
                $datetime = str_replace('/', '-', $dataPicker);
                
                //--------------------- UnixTime -----------------------------//
                //$dataInput = strtotime(date('Y-m-d', strtotime($datetime)).' 00:00:00');
                //$dataDelta = strtotime(date('Y-m-d', strtotime($datetime)).' 24:00:00');
                
                $dataInput = date('Y-m-d', strtotime($datetime)).' 00:00:00';
                $dataDelta = date('Y-m-d', strtotime($datetime)).' 24:00:00';
                
                if($this->promocion=='registered'){
                    
                    $qPartsHours = Users::where($this->qdRegistered[4],'>',$dataInput)
                                        ->where($this->qdRegistered[4],'<',$dataDelta)
                                        ->where($this->qdRegistered[5],'=',$contest_id)
                                        ->groupBy($this->qdRegistered[6])
                                        ->get(array(DB::raw($this->qdRegistered[0]),DB::raw($this->qdRegistered[1]),DB::raw($this->qdRegistered[2]),DB::raw($this->qdRegistered[3])));                
                    $dataHours = json_encode($qPartsHours);

                    $qHoursTotal = Users::where($this->qHtRegistered[4],'!=','')
                                        ->where($this->qHtRegistered[5],'=',$contest_id)
                                        ->get(array(DB::raw($this->qHtRegistered[0]),DB::raw($this->qHtRegistered[1]),DB::raw($this->qHtRegistered[2]),DB::raw($this->qHtRegistered[3])));                 

                    $dataHoursM = Users::where($this->gHmRegistered[2],'=','')
                                        ->where($this->gHmRegistered[3],'=',$contest_id)
                                        ->get(array(DB::raw($this->gHmRegistered[0]),DB::raw($this->gHmRegistered[1])));                   
                    $dataHoursMale  = json_encode($dataHoursM);

                    $qHoursF = Users::where($this->gHfRegistered[2],'=','')
                                        ->where($this->gHfRegistered[3],'=',$contest_id)
                                        ->get(array(DB::raw($this->gHfRegistered[0]),DB::raw($this->gHfRegistered[1])));                  
                    $dataHoursFemale = json_encode($qHoursF);
                    
                }else if($this->promocion=='participants'){
                    
                    $qPartsHours = Users::join($this->qdRegistered[4],$this->qdRegistered[5],'=',$this->qdRegistered[6])
                                        ->where($this->qdRegistered[7],'>',$dataInput)
                                        ->where($this->qdRegistered[8],'<',$dataDelta)
                                        ->where($this->qdRegistered[9],'=',$contest_id)
                                        ->groupBy($this->qdRegistered[10])
                                        ->get(array(DB::raw($this->qdRegistered[0]),DB::raw($this->qdRegistered[1]),DB::raw($this->qdRegistered[2]),DB::raw($this->qdRegistered[3])));                
                    $dataHours = json_encode($qPartsHours);                    
                }


                    
                return array('dataHours' => $dataHours,'dataInput' => $dataInput,'qHoursTotal'=>$qHoursTotal,'dataHoursMale'=>$dataHoursMale,'dataHoursFemale'=>$dataHoursFemale); 
                
            }else{ echo "Error"; }  
            
        }  else{ echo "Error"; }  
    }
    
}