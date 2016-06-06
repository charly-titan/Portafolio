
							var mxm_urlDatosFecha='http://mxm.televisadeportes.esmas.com/deportes/home/timetvjsonp.js';
							var mxm_urlData='http://mxm.televisadeportes.esmas.com/deportes/home/Ticker_1_jsonp.js';
							var mxm_url2='http://mxm.televisadeportes.esmas.com/deportes/home/';
							var mxm_idMXMContent=0;
							var mxm_urlDataTime=0;
							var recarga=0;
							document.write('<div id="MXMHome"></div>');
							iniTickerHomeMXM();
							function iniTickerHomeMXM(){
								$.ajax({
									dataType: 'jsonp',
									url: mxm_urlDatosFecha,
									jsonpCallback:'timetv',
									success: function(data){
										var mxm_timeser=data.timetv;
										var mxm_dateser=data.fechatv;
										var mxm_vhdt=mxm_timeser.split(':');
										mxm_urlDataTime=mxm_vhdt[0]+mxm_vhdt[1];
										showJSONHomeMXM();	
									},
									error: function(jqXHR, textStatus, errorThrown){
										mxm_urlDataTime='00';
									}
								});
							};
							
							function timetv(data){
								var timeser=data.timetv;
								var dateser=data.fechatv;
								var vhdt=timeser.split(':');
								mxm_urlDataTime=vhdt[0]+vhdt[1];
								showJSONHomeMXM();								
							}
							
							function showJSONHomeMXM(){
								$.ajax({
									dataType: 'jsonp',
									jsonpCallback:'mainwtdata',
									url: mxm_urlData+'?v='+mxm_urlDataTime,
									success: function(data){
										mxm_idMXMContent=data.ticker.widgets.widgets[0].id;
										showGamesHomeMXM();
									}
								});
							};
							function mainwtdata(){
								
							}
						
							function showGamesHomeMXM(){
								var listMXMHome='';
								$.ajax({
									dataType: 'jsonp',
									jsonpCallback:'wtdata',
									url: mxm_url2+'TickerFutbol_'+mxm_idMXMContent+'jsonp.js?v='+mxm_urlDataTime,
									success: function(data){
										var refreshtimeesp=1;
										var refreshtimeespoff=15;
										var banderaRefresh=0;
										var elementGamesHome=(data.matches.match.lenght<=7)?data.matches.match.lenght:7;
										for(var i=0; i<=elementGamesHome;i++){
											if(data.matches.match[i]) {
												if(data.matches.match[i].periodabrev != '' && data.matches.match[i].periodabrev != 'FIN') {
													banderaRefresh=1;
												}
												fechaMXM=validaFechaMXM(data.matches.match[i]);
												matchUrl=data.matches.match[i].Website;
												elementVideoMXM=data.matches.match[i].MXvideo.split('@@@');
												typeClassMXM=validaFechaMXM(data.matches.match[i],1);
												videoMXM=(elementVideoMXM[0]!='')?'<a href="'+elementVideoMXM[0]+'" target="_blank"><span class="nav_header_01_sprite nav_header_01_video"></span></a>':'';
												listMXMHome=listMXMHome+'<li '+typeClassMXM+'><span class="time nav_header_01_sectcolor">'+fechaMXM+'</span><span class="nav_header_01_name"><a href="'+matchUrl+'" target="_blank">'+data.matches.match[i].equipos.local.name+' - '+data.matches.match[i].equipos.visit.name+''+videoMXM+'</a></span><span class="result nav_header_01_sectcolor">'+data.matches.match[i].equipos.local.goals+' &middot;&middot;&middot; '+data.matches.match[i].equipos.visit.goals+'</span></li>';
											}
										}
										clearInterval (recarga);
										$('#MXMHome').html('<p>Minuto x Minuto</p><ul>'+listMXMHome+'</ul>');
										if(banderaRefresh == 0) {
										recarga=setInterval ('showGamesHomeMXM()', refreshtimeespoff * 60000 );
										} else if(banderaRefresh == 1) {
										recarga=setInterval ('showGamesHomeMXM()', refreshtimeesp * 60000 );
										}
									}
								});
							};
							
							function wtdata(){
								
							}
							
							function validaFechaMXM(mxm_dataMatch,mxm_typeData){
								mxm_typeData=(mxm_typeData)?mxm_typeData:0;
								if(mxm_dataMatch.periodabrev==''){
									var todayMXM = new Date();
									todayMXM = new Date(todayMXM.getFullYear(),todayMXM.getMonth(),todayMXM.getDate());
									mxm_dateEvent=mxm_dataMatch.MatchDate.split('/');
									var dateEventMXM= new Date(mxm_dateEvent[2],(mxm_dateEvent[1]-1),mxm_dateEvent[0]);
									if (dateEventMXM==todayMXM){
										if(mxm_typeData==0)
											return mxm_dataMatch.MatchHour2;
										else
											return 'class="nav_header_01_soon"';
									}else{
										dataMatchDate=mxm_dataMatch.MatchDate.split('/');
										if(mxm_typeData==0)
											return dataMatchDate[0]+'/'+dataMatchDate[1];
										else
											return 'class="nav_header_01_soon"';
									}
								}else if(mxm_dataMatch.periodabrev=='FIN'){
									if(mxm_typeData==0)
										return mxm_dataMatch.periodabrev;
									else
										return '';
								}else{
									if(mxm_typeData==0)
										return mxm_dataMatch.periodabrev+'&rdquo;';
									else
										return '';
								}
							};
		