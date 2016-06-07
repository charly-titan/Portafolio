/************************************************************
 * JSON - public domain reference implementation by Douglas Crockford
 * @version 2012-10-08
 * @link http://www.JSON.org/js.html
 ************************************************************/
/*jslint evil: true, regexp: false, bitwise: true, white: true */
/*global JSON2:true */
/*global window:true */
/*property JSON:true */
/*members "", "\b", "\t", "\n", "\f", "\r", "\"", "\\", apply,
	call, charCodeAt, getUTCDate, getUTCFullYear, getUTCHours,
	getUTCMinutes, getUTCMonth, getUTCSeconds, hasOwnProperty, join,
	lastIndex, length, parse, prototype, push, replace, sort, slice, stringify,
	test, toJSON, toString, valueOf,
	objectToJSON
*/

// Create a JSON object only if one does not already exist. We create the
// methods in a closure to avoid creating global variables.

if (typeof JSON2 !== 'object') {
	JSON2 = window.JSON || {};
}

(function () {
	'use strict';

	function f(n) {
		// Format integers to have at least two digits.
		return n < 10 ? '0' + n : n;
	}

	function objectToJSON(value, key) {
		var objectType = Object.prototype.toString.apply(value);

		if (objectType === '[object Date]') {
			return isFinite(value.valueOf())
				?  value.getUTCFullYear()     + '-' +
					f(value.getUTCMonth() + 1) + '-' +
					f(value.getUTCDate())      + 'T' +
					f(value.getUTCHours())     + ':' +
					f(value.getUTCMinutes())   + ':' +
					f(value.getUTCSeconds())   + 'Z'
				: null;
		}

		if (objectType === '[object String]' ||
				objectType === '[object Number]' ||
				objectType === '[object Boolean]') {
			return value.valueOf();
		}

		if (objectType !== '[object Array]' &&
				typeof value.toJSON === 'function') {
			return value.toJSON(key);
		}

		return value;
	}

	var cx = new RegExp('[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]', 'g'),
	// hack: workaround Snort false positive (sid 8443)
		pattern = '\\\\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]',
		escapable = new RegExp('[' + pattern, 'g'),
		gap,
		indent,
		meta = {    // table of character substitutions
			'\b': '\\b',
			'\t': '\\t',
			'\n': '\\n',
			'\f': '\\f',
			'\r': '\\r',
			'"' : '\\"',
			'\\': '\\\\'
		},
		rep;

	function quote(string) {

// If the string contains no control characters, no quote characters, and no
// backslash characters, then we can safely slap some quotes around it.
// Otherwise we must also replace the offending characters with safe escape
// sequences.

		escapable.lastIndex = 0;

		return escapable.test(string) ? '"' + string.replace(escapable, function (a) {
			var c = meta[a];

			return typeof c === 'string'
				? c
				: '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
		}) + '"' : '"' + string + '"';
	}

	function str(key, holder) {

// Produce a string from holder[key].

		var i,          // The loop counter.
			k,          // The member key.
			v,          // The member value.
			length,
			mind = gap,
			partial,
			value = holder[key];

// If the value has a toJSON method, call it to obtain a replacement value.

		if (value && typeof value === 'object') {
			value = objectToJSON(value, key);
		}

// If we were called with a replacer function, then call the replacer to
// obtain a replacement value.

		if (typeof rep === 'function') {
			value = rep.call(holder, key, value);
		}

// What happens next depends on the value's type.

		switch (typeof value) {
		case 'string':
			return quote(value);

		case 'number':

// JSON numbers must be finite. Encode non-finite numbers as null.

			return isFinite(value) ? String(value) : 'null';

		case 'boolean':
		case 'null':

// If the value is a boolean or null, convert it to a string. Note:
// typeof null does not produce 'null'. The case is included here in
// the remote chance that this gets fixed someday.

			return String(value);

// If the type is 'object', we might be dealing with an object or an array or
// null.

		case 'object':

// Due to a specification blunder in ECMAScript, typeof null is 'object',
// so watch out for that case.

			if (!value) {
				return 'null';
			}

// Make an array to hold the partial results of stringifying this object value.

			gap += indent;
			partial = [];

// Is the value an array?

			if (Object.prototype.toString.apply(value) === '[object Array]') {

// The value is an array. Stringify every element. Use null as a placeholder
// for non-JSON values.

				length = value.length;
				for (i = 0; i < length; i += 1) {
					partial[i] = str(i, value) || 'null';
				}

// Join all of the elements together, separated with commas, and wrap them in
// brackets.

				v = partial.length === 0
					? '[]'
					: gap
					?  '[\n' + gap + partial.join(',\n' + gap) + '\n' + mind + ']'
					: '[' + partial.join(',') + ']';
				gap = mind;

				return v;
			}

// If the replacer is an array, use it to select the members to be stringified.

			if (rep && typeof rep === 'object') {
				length = rep.length;
				for (i = 0; i < length; i += 1) {
					if (typeof rep[i] === 'string') {
						k = rep[i];
						v = str(k, value);

						if (v) {
							partial.push(quote(k) + (gap ? ': ' : ':') + v);
						}
					}
				}
			} else {

// Otherwise, iterate through all of the keys in the object.

				for (k in value) {
					if (Object.prototype.hasOwnProperty.call(value, k)) {
						v = str(k, value);

						if (v) {
							partial.push(quote(k) + (gap ? ': ' : ':') + v);
						}
					}
				}
			}

// Join all of the member texts together, separated with commas,
// and wrap them in braces.

			v = partial.length === 0
				? '{}'
				: gap
				?  '{\n' + gap + partial.join(',\n' + gap) + '\n' + mind + '}'
				: '{' + partial.join(',') + '}';
			gap = mind;

			return v;
		}
	}

// If the JSON object does not yet have a stringify method, give it one.

	if (typeof JSON2.stringify !== 'function') {
		JSON2.stringify = function (value, replacer, space) {

// The stringify method takes a value and an optional replacer, and an optional
// space parameter, and returns a JSON text. The replacer can be a function
// that can replace values, or an array of strings that will select the keys.
// A default replacer method can be provided. Use of the space parameter can
// produce text that is more easily readable.

			var i;
			gap = '';
			indent = '';

// If the space parameter is a number, make an indent string containing that
// many spaces.

			if (typeof space === 'number') {
				for (i = 0; i < space; i += 1) {
					indent += ' ';
				}

// If the space parameter is a string, it will be used as the indent string.

			} else if (typeof space === 'string') {
				indent = space;
			}

// If there is a replacer, it must be a function or an array.
// Otherwise, throw an error.

			rep = replacer;

			if (replacer && typeof replacer !== 'function' &&
					(typeof replacer !== 'object' ||
					typeof replacer.length !== 'number')) {
				throw new Error('JSON2.stringify');
			}

// Make a fake root object containing our value under the key of ''.
// Return the result of stringifying the value.

			return str('', {'': value});
		};
	}

// If the JSON object does not yet have a parse method, give it one.

	if (typeof JSON2.parse !== 'function') {
		JSON2.parse = function (text, reviver) {

// The parse method takes a text and an optional reviver function, and returns
// a JavaScript value if the text is a valid JSON text.

			var j;

			function walk(holder, key) {

// The walk method is used to recursively walk the resulting structure so
// that modifications can be made.

				var k, v, value = holder[key];

				if (value && typeof value === 'object') {
					for (k in value) {
						if (Object.prototype.hasOwnProperty.call(value, k)) {
							v = walk(value, k);

							if (v !== undefined) {
								value[k] = v;
							} else {
								delete value[k];
							}
						}
					}
				}

				return reviver.call(holder, key, value);
			}

// Parsing happens in four stages. In the first stage, we replace certain
// Unicode characters with escape sequences. JavaScript handles many characters
// incorrectly, either silently deleting them, or treating them as line endings.

			text = String(text);
			cx.lastIndex = 0;

			if (cx.test(text)) {
				text = text.replace(cx, function (a) {
					return '\\u' +
						('0000' + a.charCodeAt(0).toString(16)).slice(-4);
				});
			}

// In the second stage, we run the text against regular expressions that look
// for non-JSON patterns. We are especially concerned with '()' and 'new'
// because they can cause invocation, and '=' because it can cause mutation.
// But just to be safe, we want to reject all unexpected forms.

// We split the second stage into 4 regexp operations in order to work around
// crippling inefficiencies in IE's and Safari's regexp engines. First we
// replace the JSON backslash pairs with '@' (a non-JSON character). Second, we
// replace all simple value tokens with ']' characters. Third, we delete all
// open brackets that follow a colon or comma or that begin the text. Finally,
// we look to see that the remaining characters are only whitespace or ']' or
// ',' or ':' or '{' or '}'. If that is so, then the text is safe for eval.

			if ((new RegExp('^[\\],:{}\\s]*$'))
					.test(text.replace(new RegExp('\\\\(?:["\\\\/bfnrt]|u[0-9a-fA-F]{4})', 'g'), '@')
						.replace(new RegExp('"[^"\\\\\n\r]*"|true|false|null|-?\\d+(?:\\.\\d*)?(?:[eE][+\\-]?\\d+)?', 'g'), ']')
						.replace(new RegExp('(?:^|:|,)(?:\\s*\\[)+', 'g'), ''))) {

// In the third stage we use the eval function to compile the text into a
// JavaScript structure. The '{' operator is subject to a syntactic ambiguity
// in JavaScript: it can begin a block or an object literal. We wrap the text
// in parens to eliminate the ambiguity.

				j = eval('(' + text + ')');

// In the optional fourth stage, we recursively walk the new structure, passing
// each name/value pair to a reviver function for possible transformation.

				return typeof reviver === 'function'
					?  walk({'': j}, '')
					: j;
			}

// If the text is not JSON parseable, then a SyntaxError is thrown.

			throw new SyntaxError('JSON2.parse');
		};
	}
}());
/************************************************************
 * end JSON
 ************************************************************/




 var tim_big_data = {
 	browserFeatures : {},
 	configCookiePath:"",
 	configCookiesDisabled:false,
 	expireDateTime:"",
 	domainHash:"",
 	domainAlias:"",
	locationHrefAlias:"",
	configReferrerUrl:"",
	/* plugins */
	plugins : {},
	/* alias frequently used globals for added minification */
	documentAlias : document,
	navigatorAlias : navigator,
	screenAlias : screen,
	windowAlias: window,
	/* performance timing */
	performanceAlias : "",// this.windowAlias.performance || this.windowAlias.mozPerformance || this.windowAlias.msPerformance || this.windowAlias.webkitPerformance,
	/* DOM Ready */
	hasLoaded : false,
	registeredOnLoadHandlers : [],
	/* encode */
	encodeWrapper:"",
	decodeWrapper:"",
	/* decode */
	
	/* urldecode */
	urldecode : unescape,
	/* asynchronous tracker */
	asyncTracker:"",
	/* iterator */
	iterator:"",
	// Hash function
				hash : "",

				// Domain hash value
				domainHash:"",
	/*
	* Is property defined?
	*/
	isDefined   : function(property) {
		// workaround https://github.com/douglascrockford/JSLint/commit/24f63ada2f9d7ad65afc90e6d949f631935c2480
		var propertyType = typeof property;
		return propertyType !== 'undefined';
	},
	/*
	 * Is property a function?
	 */
	isFunction  : function(property) {
		return typeof property === 'function';
	},
	/*
	 * Is property an object?
	 *
	 * @return bool Returns true if property is null, an Object, or subclass of Object (i.e., an instanceof String, Date, etc.)
	 */
	isObject    : function(property) {
		return typeof property === 'object';
	},
	/*
	 * Is property a string?
	 */
	isString    : function(property) {
		return typeof property === 'string' || property instanceof String;
	},
	 /*
	 * Extract hostname from URL
	 */
	getHostName 	: function(url) {
		// scheme : // [username [: password] @] hostame [: port] [/ [path] [? query] [# fragment]]
		var e = new RegExp('^(?:(?:https?|ftp):)/*(?:[^@]+@)?([^:/#]+)'),
			matches = e.exec(url);
		return matches ? matches[1] : url;
	},
	/*
	 * Extract parameter from URL
	 */
	getParameter	: function(url, name) {
		var regexSearch = "[\\?&#]" + name + "=([^&#]*)";
		var regex = new RegExp(regexSearch);
		var results = regex.exec(url);
		return results ? this.decodeWrapper(results[1]) : '';
	},
	/*
	 * UTF-8 encoding
	 */
	utf8_encode		: function(argString) {
		return this.urldecode(this.encodeWrapper(argString));
	},
	/************************************************************
	 * sha1
	 * - based on sha1 from http://phpjs.org/functions/sha1:512 (MIT / GPL v2)
	 ************************************************************/
	sha1 			: function(str) {
		// +   original by: Webtoolkit.info (http://www.webtoolkit.info/)
		// + namespaced by: Michael White (http://getsprink.com)
		// +      input by: Brett Zamir (http://brett-zamir.me)
		// +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		// +   jslinted by: Anthon Pang (http://piwik.org)
		var
			rotate_left = function (n, s) {
				return (n << s) | (n >>> (32 - s));
			},
			cvt_hex = function (val) {
				var strout = '',
					i,
					v;
				for (i = 7; i >= 0; i--) {
					v = (val >>> (i * 4)) & 0x0f;
					strout += v.toString(16);
				}
				return strout;
			},
			blockstart,
			i,
			j,
			W = [],
			H0 = 0x67452301,
			H1 = 0xEFCDAB89,
			H2 = 0x98BADCFE,
			H3 = 0x10325476,
			H4 = 0xC3D2E1F0,
			A,
			B,
			C,
			D,
			E,
			temp,
			str_len,
			word_array = [];
		str = this.utf8_encode(str);
		str_len = str.length;
		for (i = 0; i < str_len - 3; i += 4) {
			j = str.charCodeAt(i) << 24 | str.charCodeAt(i + 1) << 16 |
				str.charCodeAt(i + 2) << 8 | str.charCodeAt(i + 3);
			word_array.push(j);
		}
		switch (str_len & 3) {
		case 0:
			i = 0x080000000;
			break;
		case 1:
			i = str.charCodeAt(str_len - 1) << 24 | 0x0800000;
			break;
		case 2:
			i = str.charCodeAt(str_len - 2) << 24 | str.charCodeAt(str_len - 1) << 16 | 0x08000;
			break;
		case 3:
			i = str.charCodeAt(str_len - 3) << 24 | str.charCodeAt(str_len - 2) << 16 | str.charCodeAt(str_len - 1) << 8 | 0x80;
			break;
		}
		word_array.push(i);
		while ((word_array.length & 15) !== 14) {
			word_array.push(0);
		}
		word_array.push(str_len >>> 29);
		word_array.push((str_len << 3) & 0x0ffffffff);
		for (blockstart = 0; blockstart < word_array.length; blockstart += 16) {
			for (i = 0; i < 16; i++) {
				W[i] = word_array[blockstart + i];
			}
			for (i = 16; i <= 79; i++) {
				W[i] = rotate_left(W[i - 3] ^ W[i - 8] ^ W[i - 14] ^ W[i - 16], 1);
			}
			A = H0;
			B = H1;
			C = H2;
			D = H3;
			E = H4;
			for (i = 0; i <= 19; i++) {
				temp = (rotate_left(A, 5) + ((B & C) | (~B & D)) + E + W[i] + 0x5A827999) & 0x0ffffffff;
				E = D;
				D = C;
				C = rotate_left(B, 30);
				B = A;
				A = temp;
			}
			for (i = 20; i <= 39; i++) {
				temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0x6ED9EBA1) & 0x0ffffffff;
				E = D;
				D = C;
				C = rotate_left(B, 30);
				B = A;
				A = temp;
			}
			for (i = 40; i <= 59; i++) {
				temp = (rotate_left(A, 5) + ((B & C) | (B & D) | (C & D)) + E + W[i] + 0x8F1BBCDC) & 0x0ffffffff;
				E = D;
				D = C;
				C = rotate_left(B, 30);
				B = A;
				A = temp;
			}
			for (i = 60; i <= 79; i++) {
				temp = (rotate_left(A, 5) + (B ^ C ^ D) + E + W[i] + 0xCA62C1D6) & 0x0ffffffff;
				E = D;
				D = C;
				C = rotate_left(B, 30);
				B = A;
				A = temp;
			}
			H0 = (H0 + A) & 0x0ffffffff;
			H1 = (H1 + B) & 0x0ffffffff;
			H2 = (H2 + C) & 0x0ffffffff;
			H3 = (H3 + D) & 0x0ffffffff;
			H4 = (H4 + E) & 0x0ffffffff;
		}
		temp = cvt_hex(H0) + cvt_hex(H1) + cvt_hex(H2) + cvt_hex(H3) + cvt_hex(H4);
		return temp.toLowerCase();
	},
	/************************************************************
	 * end sha1
	 ************************************************************/
	/*
	 * Fix-up URL when page rendered from search engine cache or translated page
	 */
	urlFixup 		: function(hostName, href, referrer) {
		if (hostName === 'translate.googleusercontent.com') {       // Google
			if (referrer === '') {
				referrer = href;
			}
			href = this.getParameter(href, 'u');
			hostName = this.getHostName(href);
		} else if (hostName === 'cc.bingj.com' ||                   // Bing
				hostName === 'webcache.googleusercontent.com' ||    // Google
				hostName.slice(0, 5) === '74.6.') {                 // Yahoo (via Inktomi 74.6.0.0/16)
			href = this.documentAlias.links[0].href;
			hostName = this.getHostName(href);
		}
		return [hostName, href, referrer];
	},
	/*
	 * Fix-up domain
	 */
	domainFixup 	: function(domain) {
		var dl = domain.length;
		// remove trailing '.'
		if (domain.charAt(--dl) === '.') {
			domain = domain.slice(0, dl);
		}
		// remove leading '*'
		if (domain.slice(0, 2) === '*.') {
			domain = domain.slice(1);
		}
		return domain;
	},
	/*
	 * Title fixup
	 */
	titleFixup			: function(title) {
		title = title && title.text ? title.text : title;
		if (!isString(title)) {
			var tmp = documentAlias.getElementsByTagName('title');
			if (tmp && isDefined(tmp[0])) {
				title = tmp[0].text;
			}
		}
		return title;
	},
	trim 				: function (text){
		if (text && String(text) === text) {
			return text.replace(/^\s+|\s+$/g, '');
		}
		return text;
	},
	getLocation 		: function (){
		var locationAlias = this.location || this.windowAlias.location;
		if (!locationAlias.origin) {
			locationAlias.origin = locationAlias.protocol + "//" + locationAlias.hostname + (locationAlias.port ? ':' + locationAlias.port: '');
		}
		return locationAlias;
	},
	/*
	 * Set cookie value
	 */
	setCookie 	: function(cookieName, value, msToExpire, path, domain, secure) {
		if (this.configCookiesDisabled) {
			return;
		}
		var expiryDate;
		// relative time to expire in milliseconds
		if (msToExpire) {
			expiryDate = new Date();
			expiryDate.setTime(expiryDate.getTime() + msToExpire);
		}
		documentAlias.cookie = cookieName + '=' + this.encodeWrapper(value) +
			(msToExpire ? ';expires=' + expiryDate.toGMTString() : '') +
			';path=' + (path || '/') +
			(domain ? ';domain=' + domain : '') +
			(secure ? ';secure' : '');
	},
	/*
	 * Get cookie value
	 */
	getCookie 		: function(cookieName) {
		if (this.configCookiesDisabled) {
			return 0;
		}
		var cookiePattern = new RegExp('(^|;)[ ]*' + cookieName + '=([^;]*)'),
			cookieMatch = cookiePattern.exec(this.documentAlias.cookie);
		return cookieMatch ? this.decodeWrapper(cookieMatch[2]) : 0;
	},
	/*
	 * Removes hash tag from the URL
	 *
	 * URLs are purified before being recorded in the cookie,
	 * or before being sent as GET parameters
	 */
	purify 				: function(url) {
		var targetPattern;
		if (this.configDiscardHashTag) {
			targetPattern = new RegExp('#.*');
			return url.replace(targetPattern, '');
		}
		return url;
	},
	/*
	 * Get cookie name with prefix and domain hash
	 */
	getCookieName 			: function(baseName) {
		// NOTE: If the cookie name is changed, we must also update the PiwikTracker.php which
		// will attempt to discover first party cookies. eg. See the PHP Client method getVisitorId()
		return this.configCookieNamePrefix + baseName + '.' + this.configTrackerSiteId + '.' + this.domainHash;
	},
	/*
	 * Does browser have cookies enabled (for this site)?
	 */
	hasCookies 				: function() {
		if (this.configCookiesDisabled) {
			return '0';
		}
		if (!this.isDefined(this.navigatorAlias.cookieEnabled)) {
			var testCookieName = this.getCookieName('testcookie');
			this.setCookie(testCookieName, '1');
			return this.getCookie(testCookieName) === '1' ? '1' : '0';
		}
		return this.navigatorAlias.cookieEnabled ? '1' : '0';
	},
	/**
				 * Set first-party cookie path
				 *
				 * @param string domain
				 */
				setCookiePath: function (path) {
					this.configCookiePath = path;
					updateDomainHash();
				},
	/**
				 * Set first-party cookie domain
				 *
				 * @param string domain
				 */
				setCookieDomain: function (domain) {
					var domainFixed = domainFixup(domain);

					if (isPossibleToSetCookieOnDomain(domainFixed)) {
						configCookieDomain = domainFixed;
						updateDomainHash();
					}
				},
	/*
	 * Update domain hash
	 */
	updateDomainHash 		: function() {
		this.domainHash = this.hash((this.configCookieDomain || this.domainAlias) + (this.configCookiePath || '/')).slice(0, 4); // 4 hexits = 16 bits
	},
	/*
	 * Generate a pseudo-unique ID to fingerprint this user
	 * 16 hexits = 64 bits
	 * note: this isn't a RFC4122-compliant UUID
	 */
	generateRandomUuid 		: function() {
		return hash(
			(this.navigatorAlias.userAgent || '') +
			(this.navigatorAlias.platform || '') +
			JSON2.stringify(this.browserFeatures) +
			(new Date()).getTime() +
			Math.random()
		).slice(0, 16);
	},
	setUserId: function (userId) {
					if(!this.isDefined(this.userId) || !this.userId.length) {
						return;
					}
					this.configUserId = this.userId;
					this.visitorUUID = this.hash(this.configUserId).substr(0, 16);
				},
	/*
	 * Load visitor ID cookie
	 */
	loadVisitorIdCookie 	: function() {
		var now = new Date(),
			nowTs = Math.round(now.getTime() / 1000),
			visitorIdCookieName = this.getCookieName('id'),
			id = this.getCookie(visitorIdCookieName),
			cookieValue,
			uuid;
		// Visitor ID cookie found
		if (id) {
			cookieValue = id.split('.');
			// returning visitor flag
			cookieValue.unshift('0');
			if(this.visitorUUID.length) {
				cookieValue[1] = this.visitorUUID;
			}
			return cookieValue;
		}
		if(this.visitorUUID.length) {
			uuid = this.visitorUUID;
		} else if ('0' === this.loadVisitorIdCookie.hasCookies()){
			uuid = '';
		} else {
			uuid = this.loadVisitorIdCookie.generateRandomUuid();
		}
		// No visitor ID cookie, let's create a new one
		cookieValue = [
			// new visitor
			'1',
			// uuid
			uuid,
			// creation timestamp - seconds since Unix epoch
			nowTs,
			// visitCount - 0 = no previous visit
			0,
			// current visit timestamp
			nowTs,
			// last visit timestamp - blank = no previous visit
			'',
			// last ecommerce order timestamp
			''
		];
		return cookieValue;
	},
	/**
	 * Loads the Visitor ID cookie and returns a named array of values
	 */
	getValuesFromVisitorIdCookie 	: function() {
		var cookieVisitorIdValue = this.loadVisitorIdCookie(),
			newVisitor = cookieVisitorIdValue[0],
			uuid = cookieVisitorIdValue[1],
			createTs = cookieVisitorIdValue[2],
			visitCount = cookieVisitorIdValue[3],
			currentVisitTs = cookieVisitorIdValue[4],
			lastVisitTs = cookieVisitorIdValue[5];
		// case migrating from pre-1.5 cookies
		if (!isDefined(cookieVisitorIdValue[6])) {
			cookieVisitorIdValue[6] = "";
		}
		var lastEcommerceOrderTs = cookieVisitorIdValue[6];
		return {
			newVisitor: newVisitor,
			uuid: uuid,
			createTs: createTs,
			visitCount: visitCount,
			currentVisitTs: currentVisitTs,
			lastVisitTs: lastVisitTs,
			lastEcommerceOrderTs: lastEcommerceOrderTs
		};
	},
	getRemainingVisitorCookieTimeout : function() {
		var now = new Date(),
			nowTs = now.getTime(),
			cookieCreatedTs = getValuesFromVisitorIdCookie().createTs;
		var createTs = parseInt(cookieCreatedTs, 10);
		var originalTimeout = (createTs * 1000) + configVisitorCookieTimeout - nowTs;
		return originalTimeout;
	},
	/*
	 * Sets the Visitor ID cookie
	 */
	setVisitorIdCookie 			: function(visitorIdCookieValues) {
		// if(!this.configTrackerSiteId) {
		// 	// when called before Site ID was set
		// 	return;
		// }
		var now = new Date(),
			nowTs = Math.round(now.getTime() / 1000);
		if(!this.isDefined(this.visitorIdCookieValues)) {
			visitorIdCookieValues = this.getValuesFromVisitorIdCookie();
		}
		var cookieValue = this.visitorIdCookieValues.uuid + '.' +
			this.visitorIdCookieValues.createTs + '.' +
			this.visitorIdCookieValues.visitCount + '.' +
			nowTs + '.' +
			this.visitorIdCookieValues.lastVisitTs + '.' +
			this.visitorIdCookieValues.lastEcommerceOrderTs;
		this.setCookie(this.getCookieName('id'), this.cookieValue, this.getRemainingVisitorCookieTimeout(), this.configCookiePath, this.configCookieDomain);
	},
	getRequest 			: function(){
		
		var now     = new Date();

		this.currentUrl = this.configCustomUrl || this.locationHrefAlias;
		// send charset if document charset is not utf-8. sometimes encoding
				// of urls will be the same as this and not utf-8, which will cause problems
				// do not send charset if it is utf8 since it's assumed by default in Piwik
				var charSet = this.documentAlias.characterSet || this.documentAlias.charset;

				if (!charSet || charSet.toLowerCase() === 'utf-8') {
					charSet = null;
				}
		// build out the rest of the request
		var request = 'version=1&idsite=' + this.configTrackerSiteId +
		'&rec=1' +
		'&r=' + String(Math.random()).slice(2, 8) + // keep the string to a minimum
		'&h=' + now.getHours() + '&m=' + now.getMinutes() + '&s=' + now.getSeconds() +
		'&url=' + this.encodeWrapper(this.purify(this.currentUrl)) +
		(this.configReferrerUrl.length ? '&urlref=' + this.encodeWrapper(this.purify(this.configReferrerUrl)) : '') +
		((this.configUserId && this.configUserId.length) ? '&uid=' + this.encodeWrapper(this.configUserId) : '') +
		 '&_id=' + this.cookieVisitorIdValues.uuid + '&_idts=' + this.cookieVisitorIdValues.createTs + '&_idvc=' + this.cookieVisitorIdValues.visitCount +
		 '&_idn=' + this.cookieVisitorIdValues.newVisitor + // currently unused
		// (campaignNameDetected.length ? '&_rcn=' + this.encodeWrapper(campaignNameDetected) : '') +
		// (campaignKeywordDetected.length ? '&_rck=' + this.encodeWrapper(campaignKeywordDetected) : '') +
		// '&_refts=' + referralTs +
		// '&_viewts=' + cookieVisitorIdValues.lastVisitTs +
		// (String(cookieVisitorIdValues.lastEcommerceOrderTs).length ? '&_ects=' + cookieVisitorIdValues.lastEcommerceOrderTs : '') +
		// (String(referralUrl).length ? '&_ref=' + this.encodeWrapper(purify(referralUrl.slice(0, referralUrlMaxLength))) : '') +
		 '&domain='+this.documentAlias.domain +
		 (charSet ? '&cs=' + this.encodeWrapper(charSet) : '') +
		 '&send_image=0';
		// browser features
		for (i in this.browserFeatures) {
			if (Object.prototype.hasOwnProperty.call(this.browserFeatures, i)) {
				request += '&' + i + '=' + this.browserFeatures[i];
			}
		}
		console.info(request);
	},
	detectBrowserFeatures 		: function() {
		var i,
			mimeType,
			pluginMap = {
				// document types
				pdf: 'application/pdf',
				// media players
				qt: 'video/quicktime',
				realp: 'audio/x-pn-realaudio-plugin',
				wma: 'application/x-mplayer2',
				// interactive multimedia
				dir: 'application/x-director',
				fla: 'application/x-shockwave-flash',
				// RIA
				java: 'application/x-java-vm',
				gears: 'application/x-googlegears',
				ag: 'application/x-silverlight'
			},
			devicePixelRatio = (new RegExp('Mac OS X.*Safari/')).test(this.navigatorAlias.userAgent) ? this.windowAlias.devicePixelRatio || 1 : 1;
		// detect browser features except IE < 11 (IE 11 user agent is no longer MSIE)
		if (!((new RegExp('MSIE')).test(this.navigatorAlias.userAgent))) {
			// general plugin detection
			if (this.navigatorAlias.mimeTypes && this.navigatorAlias.mimeTypes.length) {
				for (i in pluginMap) {
					if (Object.prototype.hasOwnProperty.call(pluginMap, i)) {
						mimeType = this.navigatorAlias.mimeTypes[pluginMap[i]];
						this.browserFeatures[i] = (mimeType && mimeType.enabledPlugin) ? '1' : '0';
					}
				}
			}
			// Safari and Opera
			// IE6/IE7 navigator.javaEnabled can't be aliased, so test directly
			if (typeof navigator.javaEnabled !== 'unknown' &&
					this.isDefined(this.navigatorAlias.javaEnabled) &&
					this.navigatorAlias.javaEnabled()) {
				this.browserFeatures.java = '1';
			}
			// Firefox
			if (this.isFunction(this.windowAlias.GearsFactory)) {
				this.browserFeatures.gears = '1';
			}
			// other browser features
			this.browserFeatures.cookie = this.hasCookies();
		}
		// screen resolution
		// - only Apple reports screen.* in device-independent-pixels (dips)
		// - devicePixelRatio is always 2 on MacOSX+Retina regardless of resolution set in Display Preferences
		this.browserFeatures.res = this.screenAlias.width * devicePixelRatio + 'x' + this.screenAlias.height * devicePixelRatio;
	},
	getVisitorId 	: function () {
		return this.getValuesFromVisitorIdCookie().uuid;
	},
	/**
	 * Get the visitor information (from first party cookie)
	 *
	 * @return array
	 */
	getVisitorInfo: function () {
		// Note: in a new method, we could return also return getValuesFromVisitorIdCookie()
		//       which returns named parameters rather than returning integer indexed array
		return this.loadVisitorIdCookie();
	},
	/*
	 * Get page referrer
	 */
	getReferrer 		: function() {
		var referrer = '';
		try {
			referrer = this.windowAlias.top.document.referrer;
		} catch (e) {
			if (this.windowAlias.parent) {
				try {
					referrer = this.windowAlias.parent.document.referrer;
				} catch (e2) {
					referrer = '';
				}
			}
		}
		if (referrer === '') {
			referrer = this.documentAlias.referrer;
		}
		return referrer;
	},

	init 			:	function(){

		performanceAlias = this.windowAlias.performance || this.windowAlias.mozPerformance || this.windowAlias.msPerformance || this.windowAlias.webkitPerformance;
		this.encodeWrapper = this.windowAlias.encodeURIComponent;
		this.decodeWrapper = this.windowAlias.decodeURIComponent;
		this.hash=tim_big_data.sha1;
		// Current URL and Referrer URL
		locationArray = this.urlFixup(this.documentAlias.domain, this.windowAlias.location.href, this.getReferrer());
		this.domainAlias = this.domainFixup(locationArray[0]);
		this.locationHrefAlias = this.decodeWrapper(locationArray[1]);
		this.configReferrerUrl = this.decodeWrapper(locationArray[2]);
		// Site ID
		this.configTrackerSiteId =  '';
		
		this.detectBrowserFeatures();
		this.updateDomainHash();
		
		this.setVisitorIdCookie();
		//this.getRequest();
	}


 }
tim_big_data.init();
