!function(e){function t(){var e="!@#$%^&*()+=[]\\';,/{}|\":<>?~`.-_";return e+=" "}function n(){var e="¬€£¦";return e}function r(t,n,r){t.each(function(){var t=e(this);t.bind("keyup change paste",function(e){var a="";e.originalEvent&&e.originalEvent.clipboardData&&e.originalEvent.clipboardData.getData&&(a=e.originalEvent.clipboardData.getData("text/plain")),setTimeout(function(){i(t,n,r,a)},0)}),t.bind("keypress",function(e){var a=e.charCode?e.charCode:e.which;if(!(l(a)||e.ctrlKey||e.metaKey)){var o=String.fromCharCode(a),i=t.selection(),u=i.start,c=i.end,s=t.val(),f=s.substring(0,u)+o+s.substring(c),p=n(f,r);p!=f&&e.preventDefault()}})})}function a(t,n){var r=parseFloat(e(t).val()),a=e(t);return isNaN(r)?void a.val(""):(o(n.min)&&r<n.min&&a.val(""),void(o(n.max)&&r>n.max&&a.val("")))}function o(e){return!isNaN(e)}function l(e){return e>=32?!1:10==e?!1:13==e?!1:!0}function i(e,t,n,r){var a=e.val();""==a&&r.length>0&&(a=r);var o=t(a,n);if(a!=o){var l=e.alphanum_caret();e.val(o),e.alphanum_caret(a.length==o.length+1?l-1:l)}}function u(t,n){"undefined"==typeof n&&(n=D);var r,a={};return r="string"==typeof t?O[t]:"undefined"==typeof t?{}:t,e.extend(a,n,r),"undefined"==typeof a.blacklist&&(a.blacklistSet=N(a.allow,a.disallow)),a}function c(t){var n,r={};return n="string"==typeof t?_[t]:"undefined"==typeof t?{}:t,e.extend(r,L,n),r}function s(e,t,n){return n.maxLength&&e.length>=n.maxLength?!1:n.allow.indexOf(t)>=0?!0:n.allowSpace&&" "==t?!0:n.blacklistSet.contains(t)?!1:!n.allowNumeric&&A[t]?!1:!n.allowUpper&&x(t)?!1:!n.allowLower&&T(t)?!1:!n.allowCaseless&&y(t)?!1:!n.allowLatin&&M.contains(t)?!1:n.allowOtherCharSets?!0:A[t]||M.contains(t)?!0:!1}function f(e,t,n){if(A[t])return v(e,n)?!1:h(e,n)?!1:d(e,n)?!1:m(e+t,n)?!1:g(e+t,n)?!1:!0;if(n.allowPlus&&"+"==t&&""==e)return!0;if(n.allowMinus&&"-"==t&&""==e)return!0;if(t==j&&n.allowThouSep&&R(e,t))return!0;if(t==k){if(e.indexOf(k)>=0)return!1;if(n.allowDecSep)return!0}return!1}function p(e){return e+="",e.replace(/[^0-9]/g,"").length}function v(e,t){var n=t.maxDigits;if(""==n||isNaN(n))return!1;var r=p(e);return r>=n?!0:!1}function d(e,t){var n=t.maxDecimalPlaces;if(""==n||isNaN(n))return!1;var r=e.indexOf(k);if(-1==r)return!1;var a=e.substring(r),o=p(a);return o>=n?!0:!1}function h(e,t){var n=t.maxPreDecimalPlaces;if(""==n||isNaN(n))return!1;var r=e.indexOf(k);if(r>=0)return!1;var a=p(e);return a>=n?!0:!1}function m(e,t){if(!t.max||t.max<0)return!1;var n=parseFloat(e);return n>t.max?!0:!1}function g(e,t){if(!t.min||t.min>0)return!1;var n=parseFloat(e);return n<t.min?!0:!1}function w(e,t){if("string"!=typeof e)return e;var n,r=e.split(""),a=[],o=0;for(o=0;o<r.length;o++){n=r[o];var l=a.join("");s(l,n,t)&&a.push(n)}var i=a.join("");return t.forceLower?i=i.toLowerCase():t.forceUpper&&(i=i.toUpperCase()),i}function S(e,t){if("string"!=typeof e)return e;var n,r=e.split(""),a=[],o=0;for(o=0;o<r.length;o++){n=r[o];var l=a.join("");f(l,n,t)&&a.push(n)}return a.join("")}function x(e){var t=e.toUpperCase(),n=e.toLowerCase();return e==t&&t!=n?!0:!1}function T(e){var t=e.toUpperCase(),n=e.toLowerCase();return e==n&&t!=n?!0:!1}function y(e){return e.toUpperCase()==e.toLowerCase()?!0:!1}function N(e,t){var n=new b(U+t),r=new b(e),a=n.subtract(r);return a}function C(){var e,t="0123456789".split(""),n={},r=0;for(r=0;r<t.length;r++)e=t[r],n[e]=!0;return n}function E(){var e="abcdefghijklmnopqrstuvwxyz",t=e.toUpperCase(),n=new b(e+t);return n}function R(e,t){if(0==e.length)return!1;var n=e.indexOf(k);if(n>=0)return!1;var r=e.indexOf(j);if(0>r)return!0;var a=e.lastIndexOf(j),o=e.length-a-1;if(3>o)return!1;var l=p(e.substring(r));return l%3>0?!1:!0}function b(e){this.map="string"==typeof e?P(e):{}}function P(e){var t,n={},r=e.split(""),a=0;for(a=0;a<r.length;a++)t=r[a],n[t]=!0;return n}e.fn.alphanum=function(e){var t=u(e),n=this;return r(n,w,t),this},e.fn.alpha=function(e){var t=u("alpha"),n=u(e,t),a=this;return r(a,w,n),this},e.fn.numeric=function(e){var t=c(e),n=this;return r(n,S,t),n.blur(function(){a(this,e)}),this};var D={allow:"",disallow:"",allowSpace:!0,allowNumeric:!0,allowUpper:!0,allowLower:!0,allowCaseless:!0,allowLatin:!0,allowOtherCharSets:!0,forceUpper:!1,forceLower:!1,maxLength:0/0},L={allowPlus:!1,allowMinus:!0,allowThouSep:!0,allowDecSep:!0,allowLeadingSpaces:!1,maxDigits:0/0,maxDecimalPlaces:0/0,maxPreDecimalPlaces:0/0,max:0/0,min:0/0},O={alpha:{allowNumeric:!1},upper:{allowNumeric:!1,allowUpper:!0,allowLower:!1,allowCaseless:!0},lower:{allowNumeric:!1,allowUpper:!1,allowLower:!0,allowCaseless:!0}},_={integer:{allowPlus:!1,allowMinus:!0,allowThouSep:!1,allowDecSep:!1},positiveInteger:{allowPlus:!1,allowMinus:!1,allowThouSep:!1,allowDecSep:!1}},U=t()+n(),j=",",k=".",A=C(),M=E();b.prototype.add=function(e){var t=this.clone();for(var n in e.map)t.map[n]=!0;return t},b.prototype.subtract=function(e){var t=this.clone();for(var n in e.map)delete t.map[n];return t},b.prototype.contains=function(e){return this.map[e]?!0:!1},b.prototype.clone=function(){var e=new b;for(var t in this.map)e.map[t]=!0;return e},e.fn.alphanum.backdoorAlphaNum=function(e,t){var n=u(t);return w(e,n)},e.fn.alphanum.backdoorNumeric=function(e,t){var n=c(t);return S(e,n)},e.fn.alphanum.setNumericSeparators=function(e){1==e.thousandsSeparator.length&&1==e.decimalSeparator.length&&(j=e.thousandsSeparator,k=e.decimalSeparator)}}(jQuery),function(e){function t(e,t){if(e.createTextRange){var n=e.createTextRange();n.move("character",t),n.select()}else null!=e.selectionStart&&(e.focus(),e.setSelectionRange(t,t))}function n(e){if("selection"in document){var t=e.createTextRange();try{t.setEndPoint("EndToStart",document.selection.createRange())}catch(n){return 0}return t.text.length}return null!=e.selectionStart?e.selectionStart:void 0}e.fn.alphanum_caret=function(r,a){return"undefined"==typeof r?n(this.get(0)):this.queue(function(n){if(isNaN(r)){var o=e(this).val().indexOf(r);a===!0?o+=r.length:"undefined"!=typeof a&&(o+=a),t(this,o)}else t(this,r);n()})}}(jQuery),function(e){var t=function(e){return e?e.ownerDocument.defaultView||e.ownerDocument.parentWindow:window},n=function(t,n){var r=e.Range.current(t).clone(),a=e.Range(t).select(t);return r.overlaps(a)?(r.compare("START_TO_START",a)<1?(startPos=0,r.move("START_TO_START",a)):(fromElementToCurrent=a.clone(),fromElementToCurrent.move("END_TO_START",r),startPos=fromElementToCurrent.toString().length),endPos=r.compare("END_TO_END",a)>=0?a.toString().length:startPos+r.toString().length,{start:startPos,end:endPos}):null},r=function(r){var a=t(r);if(void 0!==r.selectionStart)return document.activeElement&&document.activeElement!=r&&r.selectionStart==r.selectionEnd&&0==r.selectionStart?{start:r.value.length,end:r.value.length}:{start:r.selectionStart,end:r.selectionEnd};if(a.getSelection)return n(r,a);try{if("input"==r.nodeName.toLowerCase()){var o=t(r).document.selection.createRange(),l=r.createTextRange();l.setEndPoint("EndToStart",o);var i=l.text.length;return{start:i,end:i+o.text.length}}var u=n(r,a);if(!u)return u;var c=e.Range.current().clone(),s=c.clone().collapse().range,f=c.clone().collapse(!1).range;return s.moveStart("character",-1),f.moveStart("character",-1),0!=u.startPos&&""==s.text&&(u.startPos+=2),0!=u.endPos&&""==f.text&&(u.endPos+=2),u}catch(p){return{start:r.value.length,end:r.value.length}}},a=function(e,n,r){var a=t(e);if(e.setSelectionRange)void 0===r?(e.focus(),e.setSelectionRange(n,n)):(e.select(),e.selectionStart=n,e.selectionEnd=r);else if(e.createTextRange){var o=e.createTextRange();o.moveStart("character",n),r=r||n,o.moveEnd("character",r-e.value.length),o.select()}else if(a.getSelection){var i=a.document,u=a.getSelection(),c=i.createRange(),s=[n,void 0!==r?r:n];l([e],s),c.setStart(s[0].el,s[0].count),c.setEnd(s[1].el,s[1].count),u.removeAllRanges(),u.addRange(c)}else if(a.document.body.createTextRange){var c=document.body.createTextRange();c.moveToElementText(e),c.collapse(),c.moveStart("character",n),c.moveEnd("character",void 0!==r?r:n),c.select()}},o=function(e,t,n,r){"number"==typeof n[0]&&n[0]<t&&(n[0]={el:r,count:n[0]-e}),"number"==typeof n[1]&&n[1]<=t&&(n[1]={el:r,count:n[1]-e})},l=function(e,t,n){var r,a;n=n||0;for(var i=0;e[i];i++)r=e[i],3===r.nodeType||4===r.nodeType?(a=n,n+=r.nodeValue.length,o(a,n,t,r)):8!==r.nodeType&&(n=l(r.childNodes,t,n));return n};jQuery.fn.selection=function(e,t){return void 0!==e?this.each(function(){a(this,e,t)}):r(this[0])},e.fn.selection.getCharElement=l}(jQuery);
