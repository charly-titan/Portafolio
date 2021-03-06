﻿
/*! head.load - v1.0.3 */
(function(win,undefined){"use strict";var doc=win.document,domWaiters=[],handlers={},assets={},isAsync="async"in doc.createElement("script")||"MozAppearance"in doc.documentElement.style||win.opera,isDomReady,headVar=win.head_conf&&win.head_conf.head||"head",api=win[headVar]=(win[headVar]||function(){api.ready.apply(null,arguments);}),PRELOADING=1,PRELOADED=2,LOADING=3,LOADED=4;function noop(){}
function each(arr,callback){if(!arr){return;}
if(typeof arr==="object"){arr=[].slice.call(arr);}
for(var i=0,l=arr.length;i<l;i++){callback.call(arr,arr[i],i);}}
function insertAfter(e,i){if(e.nextSibling){e.parentNode.insertBefore(i,e.nextSibling);}else{e.parentNode.appendChild(i);}}
function is(type,obj){var clas=Object.prototype.toString.call(obj).slice(8,-1);return obj!==undefined&&obj!==null&&clas===type;}
function isFunction(item){return is("Function",item);}
function isArray(item){return is("Array",item);}
function toLabel(url){var items=url.split("/"),name=items[items.length-1],i=name.indexOf("?");return i!==-1?name.substring(0,i):name;}
function one(callback){callback=callback||noop;if(callback._done){return;}
callback();callback._done=1;}
function conditional(test,success,failure,callback){var obj=(typeof test==="object")?test:{test:test,success:!!success?isArray(success)?success:[success]:false,failure:!!failure?isArray(failure)?failure:[failure]:false,callback:callback||noop};var passed=!!obj.test;if(passed&&!!obj.success){obj.success.push(obj.callback);api.load.apply(null,obj.success);}
else if(!passed&&!!obj.failure){obj.failure.push(obj.callback);api.load.apply(null,obj.failure);}
else{callback();}
return api;}
function getAsset(item){var asset={};if(typeof item==="object"){for(var label in item){if(!!item[label]){asset={name:label,url:item[label]};}}}
else{asset={name:toLabel(item),url:item};}
var existing=assets[asset.name];if(existing&&existing.url===asset.url){return existing;}
assets[asset.name]=asset;return asset;}
function allLoaded(items){items=items||assets;for(var name in items){if(items.hasOwnProperty(name)&&items[name].state!==LOADED){return false;}}
return true;}
function onPreload(asset){asset.state=PRELOADED;each(asset.onpreload,function(afterPreload){afterPreload.call();});}
function preLoad(asset,callback){if(asset.state===undefined){asset.state=PRELOADING;asset.onpreload=[];loadAsset({url:asset.url,type:"cache"},function(){onPreload(asset);});}}
function apiLoadHack(){var args=arguments,callback=args[args.length-1],rest=[].slice.call(args,1),next=rest[0];if(!isFunction(callback)){callback=null;}
if(isArray(args[0])){args[0].push(callback);api.load.apply(null,args[0]);return api;}
if(!!next){each(rest,function(item){if(!isFunction(item)&&!!item){preLoad(getAsset(item));}});load(getAsset(args[0]),isFunction(next)?next:function(){api.load.apply(null,rest);});}
else{load(getAsset(args[0]));}
return api;}
function apiLoadAsync(){var args=arguments,callback=args[args.length-1],items={};if(!isFunction(callback)){callback=null;}
if(isArray(args[0])){args[0].push(callback);api.load.apply(null,args[0]);return api;}
each(args,function(item,i){if(item!==callback){item=getAsset(item);items[item.name]=item;}});each(args,function(item,i){if(item!==callback){item=getAsset(item);load(item,function(){if(allLoaded(items)){one(callback);}});}});return api;}
function load(asset,callback){callback=callback||noop;if(asset.state===LOADED){callback();return;}
if(asset.state===LOADING){api.ready(asset.name,callback);return;}
if(asset.state===PRELOADING){asset.onpreload.push(function(){load(asset,callback);});return;}
asset.state=LOADING;loadAsset(asset,function(){asset.state=LOADED;callback();each(handlers[asset.name],function(fn){one(fn);});if(isDomReady&&allLoaded()){each(handlers.ALL,function(fn){one(fn);});}});}
function getExtension(url){url=url||"";var items=url.split("?")[0].split(".");return items[items.length-1].toLowerCase();}
function loadAsset(asset,callback){callback=callback||noop;function error(event){event=event||win.event;ele.onload=ele.onreadystatechange=ele.onerror=null;callback();}
function process(event){event=event||win.event;if(event.type==="load"||(/loaded|complete/.test(ele.readyState)&&(!doc.documentMode||doc.documentMode<9))){win.clearTimeout(asset.errorTimeout);win.clearTimeout(asset.cssTimeout);ele.onload=ele.onreadystatechange=ele.onerror=null;callback();}}
function isCssLoaded(){if(asset.state!==LOADED&&asset.cssRetries<=20){for(var i=0,l=doc.styleSheets.length;i<l;i++){if(doc.styleSheets[i].href===ele.href){process({"type":"load"});return;}}
asset.cssRetries++;asset.cssTimeout=win.setTimeout(isCssLoaded,250);}}
var ele;var ext=getExtension(asset.url);if(ext==="css"){ele=doc.createElement("link");ele.type="text/"+(asset.type||"css");ele.rel="stylesheet";ele.href=asset.url;asset.cssRetries=0;asset.cssTimeout=win.setTimeout(isCssLoaded,500);}
else{ele=doc.createElement("script");ele.type="text/"+(asset.type||"javascript");ele.src=asset.url;}
ele.onload=ele.onreadystatechange=process;ele.onerror=error;ele.async=false;ele.defer=false;asset.errorTimeout=win.setTimeout(function(){error({type:"timeout"});},7e3);var head=doc.getElementById("libs");insertAfter(head,ele);head.setAttribute('id','');ele.setAttribute('id','libs');}
function init(){var items=doc.getElementsByTagName("script");for(var i=0,l=items.length;i<l;i++){var dataMain=items[i].getAttribute("data-headjs-load");if(!!dataMain){api.load(dataMain);return;}}}
function ready(key,callback){if(key===doc){if(isDomReady){one(callback);}
else{domWaiters.push(callback);}
return api;}
if(isFunction(key)){callback=key;key="ALL";}
if(isArray(key)){var items={};each(key,function(item){items[item]=assets[item];api.ready(item,function(){if(allLoaded(items)){one(callback);}});});return api;}
if(typeof key!=="string"||!isFunction(callback)){return api;}
var asset=assets[key];if(asset&&asset.state===LOADED||key==="ALL"&&allLoaded()&&isDomReady){one(callback);return api;}
var arr=handlers[key];if(!arr){arr=handlers[key]=[callback];}
else{arr.push(callback);}
return api;}
function domReady(){if(!doc.body){win.clearTimeout(api.readyTimeout);api.readyTimeout=win.setTimeout(domReady,50);return;}
if(!isDomReady){isDomReady=true;init();each(domWaiters,function(fn){one(fn);});}}
function domContentLoaded(){if(doc.addEventListener){doc.removeEventListener("DOMContentLoaded",domContentLoaded,false);domReady();}
else if(doc.readyState==="complete"){doc.detachEvent("onreadystatechange",domContentLoaded);domReady();}}
if(doc.readyState==="complete"){domReady();}
else if(doc.addEventListener){doc.addEventListener("DOMContentLoaded",domContentLoaded,false);win.addEventListener("load",domReady,false);}
else{doc.attachEvent("onreadystatechange",domContentLoaded);win.attachEvent("onload",domReady);var top=false;try{top=!win.frameElement&&doc.documentElement;}catch(e){}
if(top&&top.doScroll){(function doScrollCheck(){if(!isDomReady){try{top.doScroll("left");}catch(error){win.clearTimeout(api.readyTimeout);api.readyTimeout=win.setTimeout(doScrollCheck,50);return;}
domReady();}}());}}
api.load=api.js=isAsync?apiLoadAsync:apiLoadHack;api.test=conditional;api.ready=ready;api.ready(doc,function(){if(allLoaded()){each(handlers.ALL,function(callback){one(callback);});}
if(api.feature){api.feature("domloaded",true);}});}(window));