<?php

class participantController extends registeredController {


// Start Funciont getquiz
    protected function getregistered($contest_id){
        
    //------------------  Total de Usuarios Registrados  ---------------------//
        
        $qSocial_network = DB::connection('mysql2')->select("SELECT sn.social_network,count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) where u.contest_id=? GROUP BY social_network",array($contest_id));
                
        $socialTotal = DB::connection('mysql2')->table('social_network')->count();
        
        
    //------------------  Usuarios Registrados Hombres  ----------------------//
        
        $qSocialGender = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) where u.contest_id=? GROUP BY social_network",array($contest_id));
        
        $socialMaleTotal = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale'from users u INNER JOIN social_network sn on(u.id=sn.user_id) where u.contest_id=?",array($contest_id)); 
        
        $socialFemaleTotal = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='female',1,null)) as 'ageFemale'from users u INNER JOIN social_network sn on(u.id=sn.user_id) where u.contest_id=?",array($contest_id)); 

    //---------------------- Usuarios Registrados por Edad ------------------------// 
        
        $qUsersAge = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users where age!='' and contest_id=? GROUP BY age",array($contest_id));
       
        $dataAge = json_encode($qUsersAge);
        
        $dataAgeTotal = DB::connection('mysql2')->select("SELECT age, count(*) as ageTotal from users where age!='' and contest_id=?",array($contest_id));
        
        $dataAgeMale = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale' from users where age!='' and contest_id=?",array($contest_id));

        $dataAgeFemale = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='female',1,null)) as 'ageFemale' from users where age!='' and contest_id=?",array($contest_id));
    //---------------------- Total de Registros por País ------------------------//

        $qUsersCountry = DB::connection('mysql2')->select("SELECT country, COUNT(IF(gender ='male',1,null)) as 'countryMale',COUNT(IF(gender ='female',1,null)) as 'countryFemale', count(*) as countryTotal from users where country!='' and contest_id=? GROUP BY country",array($contest_id));
       
        $dataCountry = json_encode($qUsersCountry);
        
        $dataCountryTotal = DB::connection('mysql2')->select("SELECT country, count(*) as countryTotal from users where country!='' and contest_id=?",array($contest_id));
        
        $dataCountryMale = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='male',1,null)) as 'countryMale' from users where country!='' and contest_id=?",array($contest_id));

        $dataCountryFemale = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='female',1,null)) as 'countryFemale' from users where country!='' and contest_id=?",array($contest_id));

    //------------------- Usuarios Registrados por Día -----------------------//
        
        $qUsersDay = DB::connection('mysql2')->select("SELECT date(created_at) as 'dia', COUNT(IF(gender ='male',1,null)) as 'dayMale',COUNT(IF(gender ='female',1,null)) as 'dayFemale', count(*) as dayTotal from users where created_at!='' and contest_id=? GROUP BY dia",array($contest_id));
       
        $dataDay = json_encode($qUsersDay); 
        
        $dataDayTotal = DB::connection('mysql2')->select("SELECT date(created_at), count(*) as dayTotal from users where created_at!='' and contest_id=?",array($contest_id));
        
        $dataDayMale   = DB::connection('mysql2')->select("SELECT date(created_at),COUNT(IF(gender ='male',1,null)) as 'dayMale' from users where created_at!='' and contest_id=?",array($contest_id));

        $dataDayFemale = DB::connection('mysql2')->select("SELECT date(created_at),COUNT(IF(gender ='female',1,null)) as 'dayFemale' from users where created_at!='' and contest_id=?",array($contest_id)); 

//--------------------- Total de Registros por Estado  -----------------------//        
        
        $qUserState = DB::connection('mysql2')->select("SELECT state, COUNT(IF(gender ='male',1,null)) as 'stateMale',COUNT(IF(gender ='female',1,null)) as 'stateFemale', count(*) as stateTotal from users where state!='' and contest_id=? GROUP BY state",array($contest_id));
       
        $dataState = json_encode($qUserState);  
        
        $dataStateTotal  = DB::connection('mysql2')->select("SELECT state,count(*) as stateTotal from users where created_at!='' and contest_id=?",array($contest_id));
        
        $dataStateMale   = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='male',1,null)) as 'stateMale' from users where created_at!='' and contest_id=?",array($contest_id));

        $dataStateFemale = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='female',1,null)) as 'stateFemale' from users where created_at!='' and contest_id=?",array($contest_id));  

        $dataHours=0;
//------------------ Total de Participantes por Hora  -------------------// 
        if (Request::ajax()){
            
            $dataPicker = Input::get("datepicker");
            
            $datetime = str_replace('/', '-', $dataPicker);
            
            $dataInput = date('Y-m-d', strtotime($datetime)).' 00:00:00';

            $dataDelta = date('Y-m-d', strtotime($datetime)).' 24:00:00';

            $qPartsHours = DB::connection('mysql2')->select("SELECT date_format(created_at,'%H') as 'hours', COUNT(IF(gender ='male',1,null)) as 'hoursMale',COUNT(IF(gender ='female',1,null)) as 'hoursFemale', count(*) as hoursTotal from users where created_at >'".$dataInput."' and created_at <'".$dataDelta."' and contest_id=? GROUP BY hours",array($contest_id));

            $dataHours = json_encode($qPartsHours);

            $qHoursTotal = DB::connection('mysql2')->select("SELECT date_format(created_at,'%H:%i:%s') as 'hours', COUNT(IF(gender ='male',1,null)) as 'hoursMale',COUNT(IF(gender ='female',1,null)) as 'hoursFemale', count(*) as hoursTotal from users where created_at!='' and contest_id=?",array($contest_id));

            $dataHoursMale   = json_encode(DB::select("SELECT date(created_at),COUNT(IF(gender ='male',1,null)) as 'hoursMale' from users where created_at!='' and contest_id=?",array($contest_id)));

            $dataHoursFemale = json_encode(DB::select("SELECT date(created_at),COUNT(IF(gender ='female',1,null)) as 'hoursFemale' from users where created_at!='' and contest_id=?",array($contest_id))); 

            return array('dataHours' => $dataHours,'dataInput' => $dataInput,'qHoursTotal'=>$qHoursTotal,'dataHoursMale'=>$dataHoursMale,'dataHoursFemale'=>$dataHoursFemale);
            
        }

        return View::make(Config::get( 'app.main_template' ).'.graph.registered',array('qSocial_network'   => $qSocial_network,
                                      'socialTotal'       => $socialTotal,
                                      'qSocialGender'     => $qSocialGender,
                                      'socialMaleTotal'   => $socialMaleTotal,
                                      'socialFemaleTotal' => $socialFemaleTotal,
                                      'dataAge'           => $dataAge,
                                      'dataAgeTotal'      => $dataAgeTotal,
                                      'dataAgeMale'       => $dataAgeMale,
                                      'dataAgeFemale'     => $dataAgeFemale,
                                      'dataCountry'       => $dataCountry,
                                      'dataCountryTotal'  => $dataCountryTotal,
                                      'dataCountryMale'   => $dataCountryMale,
                                      'dataCountryFemale' => $dataCountryFemale,
                                      'dataDay'           => $dataDay,
                                      'dataDayTotal'      => $dataDayTotal,
                                      'dataDayMale'       => $dataDayMale,
                                      'dataDayFemale'     => $dataDayFemale,
                                      'dataState'         => $dataState,
                                      'dataStateTotal'    => $dataStateTotal,
                                      'dataStateMale'     => $dataStateMale,
                                      'dataStateFemale'   => $dataStateFemale));


    }//End
    
    
        
    public function getParticipants($contest_id){

        $contest = Contest::find($contest_id);
        
        if (strtolower($contest->contest_type)=='frase')
            return $this->participantsPhrase($contest_id);
        else
            return $this->participantsQuiz($contest_id);
        
    
    }
 


    protected function participantsPhrase($contest_id){

        $contest = Contest::find($contest_id);



    //------------------  Total de Usuarios Participantes  ---------------------//
        
        $qSocial_network = DB::connection('mysql2')->select("SELECT sn.social_network,count(*) as ageTotal from phrase p INNER JOIN social_network sn on(sn.id=p.user_id) where p.contest_id=? GROUP BY social_network, p.user_id",array($contest_id));

        $socialTotal = DB::connection('mysql2')->select("SELECT sn.social_network,count(*) as ageTotal from phrase p INNER JOIN social_network sn on(sn.id=p.user_id) where p.contest_id=? GROUP BY p.user_id",array($contest_id)); 
        
    //------------------  Usuarios Participantes Hombres  ----------------------//    
        $qSocialGender = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN phrase p on(u.id=p.user_id) where p.contest_id=? GROUP BY social_network, p.user_id",array($contest_id));
        
        $socialMaleTotal = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale' from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN phrase p on(u.id=p.user_id) where p.contest_id=? GROUP BY p.user_id",array($contest_id)); 
        
        $socialFemaleTotal = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='female',1,null)) as 'ageFemale' from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN phrase p on(u.id=p.user_id) where p.contest_id=? GROUP BY p.user_id",array($contest_id)); 
    //---------------------- Usuarios Participantes por Edad ------------------------// 
        
        $qUsersAge = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where age!='' and p.contest_id=? GROUP BY age, p.user_id",array($contest_id));
        
        $dataAge = json_encode($qUsersAge);
        
        $dataAgeTotal = DB::connection('mysql2')->select("SELECT age, count(*) as ageTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where age!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));
        
        $dataAgeMale = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale' from users u INNER JOIN phrase p on(u.id=p.user_id) where age!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));

        $dataAgeFemale = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='female',1,null)) as 'ageFemale' from users u INNER JOIN phrase p on(u.id=p.user_id) where age!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));        
        
    //---------------------- Total de Participantes por País ------------------------//

        $qPartsCountry = DB::connection('mysql2')->select("SELECT country, COUNT(IF(gender ='male',1,null)) as 'countryMale',COUNT(IF(gender ='female',1,null)) as 'countryFemale', count(*) as countryTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where country!='' and p.contest_id=? GROUP BY country, p.user_id",array($contest_id));
       
        $dataCountry = json_encode($qPartsCountry);
        
        $dataCountryTotal = DB::connection('mysql2')->select("SELECT country, count(*) as countryTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where age!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));
        
        $dataCountryMale = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='male',1,null)) as 'countryMale' from users u INNER JOIN phrase p on(u.id=p.user_id) where country!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));

        $dataCountryFemale = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='female',1,null)) as 'countryFemale' from users u INNER JOIN phrase p on(u.id=p.user_id) where country!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));
    //------------------- Usuarios Participantes por Día -----------------------//

        $qPartsDay = DB::connection('mysql2')->select("SELECT date(u.created_at) as 'dia', COUNT(IF(gender ='male',1,null)) as 'dayMale',COUNT(IF(gender ='female',1,null)) as 'dayFemale', count(*) as dayTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at!='' and p.contest_id=? GROUP BY dia, p.user_id",array($contest_id));

        $dataDay = json_encode($qPartsDay); 
        
        $dataDayTotal = DB::connection('mysql2')->select("SELECT date(u.created_at), count(*) as dayTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));
        
        $dataDayMale   = DB::connection('mysql2')->select("SELECT date(u.created_at),COUNT(IF(gender ='male',1,null)) as 'dayMale' from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));

        $dataDayFemale = DB::connection('mysql2')->select("SELECT date(u.created_at),COUNT(IF(gender ='female',1,null)) as 'dayFemale' from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));        

        //------------------ Total de Participantes por Estado  -------------------//        
        
        $qPartState = DB::connection('mysql2')->select("SELECT state, COUNT(IF(gender ='male',1,null)) as 'stateMale',COUNT(IF(gender ='female',1,null)) as 'stateFemale', count(*) as stateTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where state!='' and p.contest_id=? GROUP BY state, p.user_id",array($contest_id));
       
        $dataState = json_encode($qPartState); 
        
        $dataStateTotal  = DB::connection('mysql2')->select("SELECT state,count(*) as stateTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));
        
        $dataStateMale   = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='male',1,null)) as 'stateMale' from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));

        $dataStateFemale = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='female',1,null)) as 'stateFemale' from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at!='' and p.contest_id=? GROUP BY p.user_id",array($contest_id));          
    
//------------------ Total de Participantes por Hora  -------------------// 
        
//        $qPartsHours = DB::select("SELECT date_format(u.created_at,'%H:%i:%s') as 'hours', COUNT(IF(gender ='male',1,null)) as 'hoursMale',COUNT(IF(gender ='female',1,null)) as 'hoursFemale', count(*) as hoursTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at!='' and u.contest_id=? GROUP BY hours",array($contest_id));
//
//        $dataHours = json_encode($qPartsHours); 
        
        $dataHours=0;
//------------------ Total de Participantes por Hora  -------------------// 
        if (Request::ajax()){
            
            $dataPicker = Input::get("datepicker");
            
            $datetime = str_replace('/', '-', $dataPicker);
            
            $dataInput = date('Y-m-d', strtotime($datetime)).' 00:00:00';

            $dataDelta = date('Y-m-d', strtotime($datetime)).' 24:00:00';

            $qPartsHours = DB::connection('mysql2')->select("SELECT date_format(u.created_at,'%H') as 'hours', COUNT(IF(gender ='male',1,null)) as 'hoursMale',COUNT(IF(gender ='female',1,null)) as 'hoursFemale', count(*) as hoursTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at >='".$dataInput."' and p.created_at <='".$dataDelta."' and p.contest_id=? GROUP BY hours, p.user_id",array($contest_id));

            $dataHours = json_encode($qPartsHours);

            $qHoursTotal = DB::connection('mysql2')->select("SELECT date_format(created_at,'%H:%i:%s') as 'hours', COUNT(IF(gender ='male',1,null)) as 'hoursMale',COUNT(IF(gender ='female',1,null)) as 'hoursFemale', count(*) as hoursTotal from users where created_at!='' and contest_id=?",array($contest_id));

            $dataHoursMale   = json_encode(DB::connection('mysql2')->select("SELECT date(u.created_at),COUNT(IF(gender ='male',1,null)) as 'hoursMale' from users u INNER JOIN phrase p on(u.id=p.user_id)  where p.created_at >'".$dataInput."' and p.created_at <'".$dataDelta."' and p.contest_id=? GROUP BY p.user_id",array($contest_id)));

            $dataHoursFemale = json_encode(DB::connection('mysql2')->select("SELECT date(u.created_at),COUNT(IF(gender ='female',1,null)) as 'hoursFemale' from users u INNER JOIN phrase p on(u.id=p.user_id)  where p.created_at >'".$dataInput."' and p.created_at <'".$dataDelta."' and p.contest_id=? GROUP BY p.user_id",array($contest_id))); 

            return array('dataHours' => $dataHours,'dataInput' => $dataInput,'qHoursTotal'=>$qHoursTotal,'dataHoursMale'=>$dataHoursMale,'dataHoursFemale'=>$dataHoursFemale);
            
        }        
        
        //return $qSocial_network;
        return View::make(Config::get( 'app.main_template' ).'.graph.participants',array('contest_id'  => $contest_id,
                                                    'qSocial_network'  => $qSocial_network,
                                                    'socialTotal'     => $socialTotal,
                                                    'qSocialGender'     => $qSocialGender,
                                                    'socialMaleTotal'   => $socialMaleTotal,
                                                    'socialFemaleTotal' => $socialFemaleTotal,
                                                    'dataAge'           => $dataAge,
                                                    'dataAgeTotal'      => $dataAgeTotal,
                                                    'dataAgeMale'       => $dataAgeMale,
                                                    'dataAgeFemale'     => $dataAgeFemale,
                                                    'dataCountry'       => $dataCountry,
                                                    'dataCountryTotal'  => $dataCountryTotal,
                                                    'dataCountryMale'   => $dataCountryMale,
                                                    'dataCountryFemale' => $dataCountryFemale,
                                                    'dataDay'           => $dataDay,
                                                    'dataDayTotal'      => $dataDayTotal,
                                                    'dataDayMale'       => $dataDayMale,
                                                    'dataDayFemale'     => $dataDayFemale,
                                                    'dataState'         => $dataState,
                                                    'dataStateTotal'    => $dataStateTotal,
                                                    'dataStateMale'     => $dataStateMale,
                                                    'dataStateFemale'   => $dataStateFemale));
    }

    
    protected function participantsQuiz($contest_id){

        $contest = Contest::find($contest_id);

    //------------------  Total de Usuarios Participantes  ---------------------//
        
        $qSocial_network = DB::connection('mysql2')->select("SELECT sn.social_network,count(*) as ageTotal from social_network sn INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(sn.user_id=p.user_id) where sn.contest_id=? GROUP BY social_network",array($contest_id));

        $socialTotal = DB::connection('mysql2')->select("SELECT count(*) as ageTotal from social_network sn INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(sn.user_id=p.user_id) where sn.contest_id=?",array($contest_id)); 
        
    //------------------  Usuarios Participantes Hombres  ----------------------//    
        $qSocialGender = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.contest_id=? GROUP BY social_network",array($contest_id));
        
        $socialMaleTotal = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='male',1,null)) as 'ageMale' from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.contest_id=?",array($contest_id)); 
        
        $socialFemaleTotal = DB::connection('mysql2')->select("SELECT sn.social_network,COUNT(IF(gender ='female',1,null)) as 'ageFemale' from users u INNER JOIN social_network sn on(u.id=sn.user_id) INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.contest_id=?",array($contest_id)); 
    //---------------------- Usuarios Participantes por Edad ------------------------// 
        
        $qUsersAge = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale',COUNT(IF(gender ='female',1,null)) as 'ageFemale',count(*) as ageTotal from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where age!='' and u.contest_id=? GROUP BY age",array($contest_id));
        
        $dataAge = json_encode($qUsersAge);
        
        $dataAgeTotal = DB::connection('mysql2')->select("SELECT age, count(*) as ageTotal from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where age!='' and u.contest_id=?",array($contest_id));
        
        $dataAgeMale = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='male',1,null)) as 'ageMale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where age!='' and u.contest_id=?",array($contest_id));

        $dataAgeFemale = DB::connection('mysql2')->select("SELECT age,COUNT(IF(gender ='female',1,null)) as 'ageFemale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where age!='' and u.contest_id=?",array($contest_id));        
        
    //---------------------- Total de Participantes por País ------------------------//

        $qPartsCountry = DB::connection('mysql2')->select("SELECT country, COUNT(IF(gender ='male',1,null)) as 'countryMale',COUNT(IF(gender ='female',1,null)) as 'countryFemale', count(*) as countryTotal from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where country!='' and u.contest_id=? GROUP BY country",array($contest_id));
       
        $dataCountry = json_encode($qPartsCountry);
        
        $dataCountryTotal = DB::connection('mysql2')->select("SELECT country, count(*) as countryTotal from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where age!='' and u.contest_id=?",array($contest_id));
        
        $dataCountryMale = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='male',1,null)) as 'countryMale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where country!='' and u.contest_id=?",array($contest_id));

        $dataCountryFemale = DB::connection('mysql2')->select("SELECT country,COUNT(IF(gender ='female',1,null)) as 'countryFemale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where country!='' and u.contest_id=?",array($contest_id));
    //------------------- Usuarios Participantes por Día -----------------------//

        $qPartsDay = DB::connection('mysql2')->select("SELECT date(u.created_at) as 'dia', COUNT(IF(gender ='male',1,null)) as 'dayMale',COUNT(IF(gender ='female',1,null)) as 'dayFemale', count(*) as dayTotal from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.created_at!='' and u.contest_id=? GROUP BY dia",array($contest_id));

        $dataDay = json_encode($qPartsDay); 
        
        $dataDayTotal = DB::connection('mysql2')->select("SELECT date(u.created_at), count(*) as dayTotal from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.created_at!='' and u.contest_id=?",array($contest_id));
        
        $dataDayMale   = DB::connection('mysql2')->select("SELECT date(u.created_at),COUNT(IF(gender ='male',1,null)) as 'dayMale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.created_at!='' and u.contest_id=?",array($contest_id));

        $dataDayFemale = DB::connection('mysql2')->select("SELECT date(u.created_at),COUNT(IF(gender ='female',1,null)) as 'dayFemale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.created_at!='' and u.contest_id=?",array($contest_id));        

        //------------------ Total de Participantes por Estado  -------------------//        
        
        $qPartState = DB::connection('mysql2')->select("SELECT state, COUNT(IF(gender ='male',1,null)) as 'stateMale',COUNT(IF(gender ='female',1,null)) as 'stateFemale', count(*) as stateTotal from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where state!='' and u.contest_id=? GROUP BY state",array($contest_id));
       
        $dataState = json_encode($qPartState); 
        
        $dataStateTotal  = DB::connection('mysql2')->select("SELECT state,count(*) as stateTotal from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.created_at!='' and u.contest_id=?",array($contest_id));
        
        $dataStateMale   = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='male',1,null)) as 'stateMale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.created_at!='' and u.contest_id=?",array($contest_id));

        $dataStateFemale = DB::connection('mysql2')->select("SELECT state,COUNT(IF(gender ='female',1,null)) as 'stateFemale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.created_at!='' and u.contest_id=?",array($contest_id));          
    
//------------------ Total de Participantes por Hora  -------------------// 
        
//        $qPartsHours = DB::select("SELECT date_format(u.created_at,'%H:%i:%s') as 'hours', COUNT(IF(gender ='male',1,null)) as 'hoursMale',COUNT(IF(gender ='female',1,null)) as 'hoursFemale', count(*) as hoursTotal from users u INNER JOIN phrase p on(u.id=p.user_id) where p.created_at!='' and u.contest_id=? GROUP BY hours",array($contest_id));
//
//        $dataHours = json_encode($qPartsHours); 
        
        $dataHours=0;
//------------------ Total de Participantes por Hora  -------------------// 
        if (Request::ajax()){
            
            $dataPicker = Input::get("datepicker");
            
            $datetime = str_replace('/', '-', $dataPicker);
            
            $dataInput = date('Y-m-d', strtotime($datetime)).' 00:00:00';

            $dataDelta = date('Y-m-d', strtotime($datetime)).' 24:00:00';

            $qPartsHours = DB::connection('mysql2')->select("SELECT date_format(u.created_at,'%H') as 'hours', COUNT(IF(gender ='male',1,null)) as 'hoursMale',COUNT(IF(gender ='female',1,null)) as 'hoursFemale', count(*) as hoursTotal from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id) where u.created_at >='".$dataInput."' and u.created_at <='".$dataDelta."' and u.contest_id=? GROUP BY hours",array($contest_id));

            $dataHours = json_encode($qPartsHours);

            $qHoursTotal = DB::connection('mysql2')->select("SELECT date_format(created_at,'%H:%i:%s') as 'hours', COUNT(IF(gender ='male',1,null)) as 'hoursMale',COUNT(IF(gender ='female',1,null)) as 'hoursFemale', count(*) as hoursTotal from users where created_at!='' and contest_id=?",array($contest_id));

            $dataHoursMale   = json_encode(DB::connection('mysql2')->select("SELECT date(u.created_at),COUNT(IF(gender ='male',1,null)) as 'hoursMale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id)  where u.created_at >'".$dataInput."' and u.created_at <'".$dataDelta."' and u.contest_id=?",array($contest_id)));

            $dataHoursFemale = json_encode(DB::connection('mysql2')->select("SELECT date(u.created_at),COUNT(IF(gender ='female',1,null)) as 'hoursFemale' from users u INNER JOIN (Select qa.user_id from questions_answers qa group by qa.user_id) as p on(u.id=p.user_id)  where u.created_at >'".$dataInput."' and u.created_at <'".$dataDelta."' and u.contest_id=?",array($contest_id))); 

            return array('dataHours' => $dataHours,'dataInput' => $dataInput,'qHoursTotal'=>$qHoursTotal,'dataHoursMale'=>$dataHoursMale,'dataHoursFemale'=>$dataHoursFemale);
            
        }        
        
        //return $qSocial_network;
        return View::make(Config::get( 'app.main_template' ).'.graph.participants',array('contest_id'  => $contest_id,
                                                    'qSocial_network'  => $qSocial_network,
                                                    'socialTotal'     => $socialTotal,
                                                    'qSocialGender'     => $qSocialGender,
                                                    'socialMaleTotal'   => $socialMaleTotal,
                                                    'socialFemaleTotal' => $socialFemaleTotal,
                                                    'dataAge'           => $dataAge,
                                                    'dataAgeTotal'      => $dataAgeTotal,
                                                    'dataAgeMale'       => $dataAgeMale,
                                                    'dataAgeFemale'     => $dataAgeFemale,
                                                    'dataCountry'       => $dataCountry,
                                                    'dataCountryTotal'  => $dataCountryTotal,
                                                    'dataCountryMale'   => $dataCountryMale,
                                                    'dataCountryFemale' => $dataCountryFemale,
                                                    'dataDay'           => $dataDay,
                                                    'dataDayTotal'      => $dataDayTotal,
                                                    'dataDayMale'       => $dataDayMale,
                                                    'dataDayFemale'     => $dataDayFemale,
                                                    'dataState'         => $dataState,
                                                    'dataStateTotal'    => $dataStateTotal,
                                                    'dataStateMale'     => $dataStateMale,
                                                    'dataStateFemale'   => $dataStateFemale));
    }
    
}