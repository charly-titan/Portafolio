<?php

class participantsController extends registeredController {

    //------------------  Total de Usuarios Participants ---------------------//
                
    protected $qSocialRegistered  = ["sn.social_network","count(*) as socialNetwork","social_network AS sn", "sn.id","phrase.user_id","phrase.contest_id","social_network"];  
    protected $qTotalRegistered   = ["sn.social_network","count(*) as socialNetworkTotal","social_network AS sn","sn.id","phrase.user_id","phrase.contest_id"];
    protected $promocion = 'participants';
        
    //------------------  Usuarios Registrados por Genero  --------------------//
    protected $qGenderRegistered  = ["sn.social_network","COUNT(IF(gender ='male',1,null)) as 'ageMale'","COUNT(IF(gender ='female',1,null)) as 'ageFemale'","count(*) as ageTotal","social_network AS sn","users.id","sn.user_id","phrase AS p","users.id","p.user_id","p.contest_id","social_network"];
    protected $qMaleRegistered    = ["sn.social_network","COUNT(IF(gender ='male',1,null)) as 'ageMale'","social_network AS sn", "users.id","sn.user_id","phrase AS p","users.id","p.user_id","p.contest_id"]; 
    protected $qFemaleRegistered  = ["sn.social_network","COUNT(IF(gender ='female',1,null)) as 'ageFemale'","social_network AS sn","users.id","sn.user_id", "phrase AS p","users.id","p.user_id","p.contest_id"];     

   //--------------------- Usuarios Registrados por Edad ----------------------// 
    
    protected $qAgeRegistered       = ["age","COUNT(IF(gender ='male',1,null)) as 'ageMale'","COUNT(IF(gender ='female',1,null)) as 'ageFemale'","count(*) as ageTotal","phrase AS p","users.id","p.user_id","users.age","p.contest_id","users.age"];
    protected $qAgeTotalRegistered  = ["age","count(*) as ageTotal","phrase AS p","users.id","p.user_id","users.age","p.contest_id"];     
    protected $qAgeMaleRegistered   = ["age","COUNT(IF(gender ='male',1,null)) as 'ageMale'","phrase AS p","users.id","p.user_id","age","p.contest_id"];  
    protected $qAgeFemaleRegistered = ["age","COUNT(IF(gender ='female',1,null)) as 'ageFemale'","phrase AS p","users.id","p.user_id","age","p.contest_id"]; 
    
    //---------------------- Total de Registros por País ----------------------//
 
    protected $qCountryRegistered       = ["country","COUNT(IF(gender ='male',1,null)) as 'countryMale'","COUNT(IF(gender ='female',1,null)) as 'countryFemale'","count(*) as countryTotal","phrase AS p","users.id","p.user_id","country","p.contest_id","country"];
    protected $qCountryTotalRegistered  = ["country","count(*) as countryTotal","phrase AS p","users.id","p.user_id","country","p.contest_id"]; 
    protected $qCountryMaleRegistered   = ["country,COUNT(IF(gender ='male',1,null)) as 'countryMale'","phrase AS p","users.id","p.user_id","country","p.contest_id"];
    protected $qCountryFemaleRegistered = ["country,COUNT(IF(gender ='female',1,null)) as 'countryFemale'","phrase AS p","users.id","p.user_id","country","p.contest_id"];
    
//------------------- Usuarios Registrados por Día -----------------------//
 
    protected $qDayRegistered       = ["date(users.created_at) as 'dia'","COUNT(IF(gender ='male',1,null)) as 'dayMale'","COUNT(IF(gender ='female',1,null)) as 'dayFemale'","count(*) as dayTotal","phrase As p","users.id","p.user_id","p.created_at","p.contest_id","dia"]; 
    protected $qDayTotalRegistered  = ["date(users.created_at)","count(*) as dayTotal","phrase As p","users.id","p.user_id","p.created_at","p.contest_id"]; 
    protected $qDayMaleRegistered   = ["date(users.created_at)","COUNT(IF(gender ='male',1,null)) as 'dayMale'","phrase As p","users.id","p.user_id","p.created_at","p.contest_id"];     
    protected $qDayFemaleRegistered = ["date(users.created_at)","COUNT(IF(gender ='female',1,null)) as 'dayFemale'","phrase As p","users.id","p.user_id","p.created_at","p.contest_id"];

//--------------------- Total de Registros por Estado  -----------------------//
    
    protected $qStateRegistered       = ["state","COUNT(IF(gender ='male',1,null)) as 'stateMale'","COUNT(IF(gender ='female',1,null)) as 'stateFemale'","count(*) as stateTotal","phrase AS p","users.id","p.user_id","state","p.contest_id","state"];
    protected $qStateTotalRegistered  = ["state","count(*) as stateTotal","phrase As p","users.id","p.user_id","p.created_at","p.contest_id"];
    protected $qStateMaleRegistered   = ["state","COUNT(IF(gender ='male',1,null)) as 'stateMale'","phrase As p","users.id","p.user_id","p.created_at","p.contest_id"];
    protected $qStateFemaleRegistered = ["state","COUNT(IF(gender ='female',1,null)) as 'stateFemale'","phrase As p","users.id","p.user_id","p.created_at","p.contest_id"]; 
    
   //---------------------- Total de Participantes por Hora  ----------------//
    
    protected $qdRegistereda = ["date_format(u.created_at,'%H') as 'hours'","COUNT(IF(gender ='male',1,null)) as 'hoursMale'","COUNT(IF(gender ='female',1,null)) as 'hoursFemale'", "count(*) as hoursTotal","phrase As p","users.id","phrase.user_id","users.created_at","p.phrase","p.contest_id","hours"];
      
}







