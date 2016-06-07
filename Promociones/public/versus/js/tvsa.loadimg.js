(function($,window,document,undefined){var tvsaloadimg='tvsaloadimg',dataLazied='televized',load_error='load error',classLoadimgHidden='tvsaimg-hidden',docElement=document.documentElement||document.body,forceLoad=(window.onscroll===undefined||!!window.operamini||!docElement.getBoundingClientRect),options={autoInit:true,selector:'img[data-src]',blankImage:'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQIW2N88eLFfwAJMQO5lUaUgQAAAABJRU5ErkJggg==',throttle:50,forceLoad:false,loadEvent:'pageshow',updateEvent:'load orientationchange resize scroll owl-didmove',forceEvent:'',oninit:{removeClass:'tvsaimg'},onshow:{addClass:"classLoadimgHidden"},onload:{removeClass:"classLoadimgHidden tvsaimg-hidden",addClass:'tvsaimg-loaded'},onerror:{removeeClass:"classLoadimgHidden"},checkDuplicates:true},elementOptions={srcAttr:'data-src',edgeX:1400,edgeY:400,visibleOnly:false},$window=$(window),$isFunction=$.isFunction,$extend=$.extend,$data=$.data||function(el,name){return $(el).data(name);},$contains=$.contains||function(parent,el){while(el=el.parentNode){if(el===parent){return true;}}
return false;},elements=[],topLoadimg=0,waitingMode=0;$[tvsaloadimg]=$extend(options,elementOptions,$[tvsaloadimg]);function getOrDef(obj,prop){return obj[prop]===undefined?options[prop]:obj[prop];}
function scrollTop(){var scroll=window.pageYOffset;return(scroll===undefined)?docElement.scrollTop:scroll;}
$.fn[tvsaloadimg]=function(overrides){overrides=overrides||{};var blankImage=getOrDef(overrides,'blankImage'),checkDuplicates=getOrDef(overrides,'checkDuplicates'),scrollContainer=getOrDef(overrides,'scrollContainer'),elementOptionsOverrides={},prop;$(scrollContainer).on('scroll',queueCheckLoadimgElements);for(prop in elementOptions){elementOptionsOverrides[prop]=getOrDef(overrides,prop);}
return this.each(function(index,el){if(el===window){$(options.selector).tvsaloadimg(overrides);}else{if(checkDuplicates&&$data(el,dataLazied)){return;}
var $el=$(el).data(dataLazied,1);if(blankImage&&el.tagName==='IMG'&&!el.src){el.src=blankImage;}
$el[tvsaloadimg]=$extend({},elementOptionsOverrides);triggerEvent('init',$el);elements.push($el);}});};function triggerEvent(event,$el){var handler=options['on'+event];if(handler){if($isFunction(handler)){handler.call($el[0]);}else{if(handler.addClass){$el.addClass(handler.addClass);}
if(handler.removeClass){$el.removeClass(handler.removeClass);}}}
$el.trigger('tvsaimg'+event,[$el]);queueCheckLoadimgElements();}
function triggerLoadOrError(e){triggerEvent(e.type,$(this).off(load_error,triggerLoadOrError));}
function checkLoadimgElements(force){if(!elements.length){return;}
force=force||options.forceLoad;topLoadimg=Infinity;var viewportTop=scrollTop(),viewportHeight=window.innerHeight||docElement.clientHeight,viewportWidth=window.innerWidth||docElement.clientWidth,i,length;for(i=0,length=elements.length;i<length;i++){var $el=elements[i],el=$el[0],objData=$el[tvsaloadimg],removeNode=false,visible=force,topEdge;if(!$contains(docElement,el)){removeNode=true;}else if(force||!objData.visibleOnly||el.offsetWidth||el.offsetHeight){if(!visible){var elPos=el.getBoundingClientRect(),edgeX=objData.edgeX,edgeY=objData.edgeY;topEdge=(elPos.top+viewportTop-edgeY)-viewportHeight;visible=(topEdge<=viewportTop&&elPos.bottom>-edgeY&&elPos.left<=viewportWidth+edgeX&&elPos.right>-edgeX);}
if(visible){triggerEvent('show',$el);var srcAttr=objData.srcAttr,src=$isFunction(srcAttr)?srcAttr($el):el.getAttribute(srcAttr);if(src){$el.on(load_error,triggerLoadOrError);el.src=src;}
removeNode=true;}else{if(topEdge<topLoadimg){topLoadimg=topEdge;}}}
if(removeNode){elements.splice(i--,1);length--;}}
if(!length){triggerEvent('complete',$(docElement));}}
function timeoutLoadimgElements(){if(waitingMode>1){waitingMode=1;checkLoadimgElements();setTimeout(timeoutLoadimgElements,options.throttle);}else{waitingMode=0;}}
function queueCheckLoadimgElements(e){if(!elements.length){return;}
if(e&&e.type==='scroll'&&e.currentTarget===window){if(topLoadimg>=scrollTop()){return;}}
if(!waitingMode){setTimeout(timeoutLoadimgElements,0);}
waitingMode=2;}
function initLoadimgElements(){$window.tvsaloadimg();}
function forceLoadAll(){checkLoadimgElements(true);}
$(document).ready(function(){triggerEvent('start',$window);$window.on(options.loadEvent,initLoadimgElements).on(options.updateEvent,queueCheckLoadimgElements).on(options.forceEvent,forceLoadAll);$(document).on(options.updateEvent,queueCheckLoadimgElements);if(options.autoInit){initLoadimgElements();}});})(window.jQuery||window.Zepto||window.$,window,document);