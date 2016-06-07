angular.module('twitter', [])

  .controller('twitterController', ['$scope','$http','$sce', function($scope,$http,$sce) {

      $http.get('http://communities-dev.s3-website-us-west-1.amazonaws.com/settings_twitter/7e8a29f8-4636-44fa-9b09-294459904d93.json')
          .success(function (data) {


            function replaceTextMatch(typeReplace,data){

                switch(typeReplace){
                  case 'hashtag': 
                    pattern = /#[a-zA-Z 0-9 ñáéíóúÁÉÍÓÚ]*/g;
                    url = '<a target="_blank" href="https://twitter.com/hashtag/';
                    break;
                  case 'profile':
                    pattern = /(@)[a-zA-Z 0-9 &_+=?:.\[\]\\\/]*/g;
                    url = '<a target="_blank" href="https://twitter.com/';
                    break;
                  case 'link':
                    pattern = /http[s][a-zA-Z 0-9 &_+=?:.\[\]\\\/]*/g;
                    break;
                }

                var matchArray;
                  ListTextMod = [];

                  for (var i = 0; i < data.length; i++) {
                
                    text = data[i]['text'];

                    while((matchArray = pattern.exec(text) ) != null) {
                        TypeTextMod = matchArray[0];

                        if(typeReplace == 'link'){
                          LotTextMod = TypeTextMod.split(' ');
                        }else{
                          LotTextMod = TypeTextMod.split(' ').shift();
                        }

                        if( typeof ListTextMod[LotTextMod] == 'undefined'){
                          
                          if(typeReplace == 'hashtag'){
                              
                              ListTextMod[LotTextMod] = url + LotTextMod.replace('#','')+'">'+LotTextMod+'</a>';

                          }else if(typeReplace =='profile'){
  
                              ListTextMod[LotTextMod] = url + LotTextMod.replace('@','').replace(':','').replace('.','')+'">'+LotTextMod+'</a>';
                          
                          }else if(typeReplace == 'link'){

                            for (var j = 0; j < LotTextMod.length; j++) {

                              if(LotTextMod[j].indexOf('/t.co/') != -1){
                                if( typeof ListTextMod[LotTextMod[j]] == 'undefined'){

                                  ListTextMod[LotTextMod[j]] = '<a target="_blank" href="'+LotTextMod[j]+'">'+LotTextMod[j]+'</a>';

                                }
                              }

                            }

                          }
                        }
                    }
                  }

                  return ListTextMod;
            }
            
            function listReplace(TypeTextReplace){
              
              replaceList = [];

                for (var key in TypeTextReplace){
                  replaceList.push(key);  
                }
                return replaceList.join('|');

            }
            
            function textReplaced(lists,typeReplace,text){

              if(lists){

                  str = text.replace(new RegExp(lists, "gi"), function(matched){
                          return typeReplace[matched];
                  });
                  
              }else{ str = text; }

              return str;

            }

            hashtag = replaceTextMatch('hashtag',data);
            profile = replaceTextMatch('profile',data);
            link = replaceTextMatch('link',data); 

           


            html = [];
            j =0;

              /*for (var i = 0; i < data.length; i++) {

                  if(i %2 == 0){
                    contenHtmlTweet =  '<li id="showArrows_twitter_'+(j+1)+'" class="showArrows">';
                    j++;
                  }
                    contenHtmlTweet+='<div data-template="" class="wdg_twitt_02_block one" ng-repeat="(key, tweet) in datos" >'+   

                                      '<div class="wdg_twitt_02_img">'+                              
                                        '<a href="http://www.twitter.com/'+data[i]['screen_name']+'" target="_blank" class="ui-link">'+                               
                                          '<img src="'+data[i]['photo']+'">'+                              
                                        '</a>'+                            
                                      '</div>'+

                                      '<div class="wdg_twitt_02_txt">'+                         
                                              '<span class="title textcolor-title2">'+ data[i]['name'] +                              
                                                '<span class="cta_twitter textcolor-title4">'+
                                                  '<a target="_blank" href="http://www.twitter.com/'+data[i]['screen_name']+'"> @'+data[i]['screen_name']+'</a>'+
                                                '</span>'+
                                              '</span>'+                               
                                        '<p>'+ textReplaced( listReplace(link),link , textReplaced ( listReplace(profile),profile,textReplaced(listReplace(hashtag),hashtag,data[i]['text']) )) +'</p>'+                                                               
                                        '<span class="wdg_twitt_02_blue"><strong>'+msgTime(data[i]['created_at'])+'</strong>'+                               
                                          '<a href="https://twitter.com/intent/tweet?in_reply_to='+data[i]['id_tweet']+'"> - Reply&nbsp;</a>'+                               
                                          '<a href="https://twitter.com/intent/retweet?tweet_id='+data[i]['id_tweet']+'"> - Retweet&nbsp;</a>'+                              
                                          '<a href="https://twitter.com/intent/favorite?tweet_id='+data[i]['id_tweet']+'"> - Favorito</a>'+                            
                                        '</span>'+
                                      '</div>'+   
                                  '</div>';
                  
                    html[(j-1)] = $sce.trustAsHtml(contenHtmlTweet +'</li>');
              }*/

                   /*
    <div data-template="" class="twitts id_tw_[[_tempo.index]]">
        <div class="img">
            <img src="http://i2.esmas.com/spacer.gif" data-src="[[user.profile_image_url]]" width="50" height="50" alt="Image"/>
        </div>
        <div class="text">
            <span class="twitt-title">[[user.name]]</span><span class="twitt-user">@[[user.screen_name]]</span>
            <p class="comentario">[[text]]</p>
            <p class="time">[[created_at|date 'HH:mm']] &#8226;
                <a href="https://twitter.com/intent/tweet?in_reply_to=[[id_str]]" target="_blank">responder</a> &#8226;
                <a href="https://twitter.com/intent/retweet?tweet_id=[[id_str]]" target="_blank">retweet</a> &#8226;
                <a href="https://twitter.com/intent/favorite?tweet_id=[[id_str]]" target="_blank">favorito</a>
            </p>
        </div>
    </div>*/
            //contenHtmlTweet = '';
            for (var i = 0; i < data.length; i++) {


                    contenHtmlTweet ='<div data-template="" class="twitts id_tw_'+(i+1)+'" >'+
                                        '<div class="img">'+
                                            '<img src="'+data[i]['photo']+'">'+
                                        '</div>'+
                                        '<div class="text">'+
                                            '<span class="twitt-title">'+data[i]['name']+'</span><span class="twitt-user"><a target="_blank" href="https://twitter.com/'+data[i]['screen_name']+'">@'+data[i]['screen_name']+'</a></span>'+
                                            '<p class="comentario">'+textReplaced( listReplace(link),link , textReplaced ( listReplace(profile),profile,textReplaced(listReplace(hashtag),hashtag,data[i]['text']) ))+'</p>'+
                                            '<p class="time">'+hour(data[i]['created_at'])+' &#8226;'+
                                                '<a href="https://twitter.com/intent/tweet?in_reply_to='+data[i]['id_tweet']+'" target="_blank">responder</a> &#8226;'+
                                                '<a href="https://twitter.com/intent/retweet?tweet_id='+data[i]['id_tweet']+'" target="_blank">retweet</a> &#8226;'+
                                                '<a href="https://twitter.com/intent/favorite?tweet_id='+data[i]['id_tweet']+'" target="_blank">favorito</a>'+
                                            '</p>'+
                                        '</div>'+
                                    '</div>';
                  
                    html[i] = $sce.trustAsHtml(contenHtmlTweet);
            }

              $scope.contenHtml = html;
          });

    }])
  .directive('myTweets', function() {
      return {
        //templateUrl: "../templates/twitter.html"
        templateUrl: "../templates/telehit.html"
      };
  });


function msgTime(dateTime){

    var t = new Date(Date.parse(dateTime));
    time = Math.ceil(t/1000);
    var now = new Date();
    now = Math.ceil(now/1000);
    var diff = now - time;
    if (isNaN(diff))return 'Minutos atras';
    if(diff<60)return 'segundos atras';
    var mins = Math.floor(diff/60);
    if(mins<60)return mins+' minutos atras';
    var horas = Math.floor(mins/60);
    if(horas<24)return horas+' horas atras';
    var dias = Math.floor(horas/24);
    if(dias==1)return 'Publicado ayer';
    else return dias+' Dias atras';

}

function hour(dateTime){
  var t = new Date(Date.parse(dateTime));
    
    hours = ("0"+t.getHours()).slice(-2);
    minutes = ("0"+t.getMinutes()).slice(-2)

    return hours+":"+minutes;
}
