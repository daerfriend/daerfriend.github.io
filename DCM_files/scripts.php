(function(e,t){"use strict";var n=e.History=e.History||{},r=e.jQuery;if(typeof n.Adapter!="undefined")throw new Error("History.js Adapter has already been loaded...");n.Adapter={bind:function(e,t,n){r(e).bind(t,n)},trigger:function(e,t,n){r(e).trigger(t,n)},extractEventData:function(e,n,r){var i=n&&n.originalEvent&&n.originalEvent[e]||r&&r[e]||t;return i},onDomLoad:function(e){r(e)}},typeof n.init!="undefined"&&n.init()})(window),function(e,t){"use strict";var n=e.console||t,r=e.document,i=e.navigator,s=e.sessionStorage||!1,o=e.setTimeout,u=e.clearTimeout,a=e.setInterval,f=e.clearInterval,l=e.JSON,c=e.alert,h=e.History=e.History||{},p=e.history;try{s.setItem("TEST","1"),s.removeItem("TEST")}catch(d){s=!1}l.stringify=l.stringify||l.encode,l.parse=l.parse||l.decode;if(typeof h.init!="undefined")throw new Error("History.js Core has already been loaded...");h.init=function(e){return typeof h.Adapter=="undefined"?!1:(typeof h.initCore!="undefined"&&h.initCore(),typeof h.initHtml4!="undefined"&&h.initHtml4(),!0)},h.initCore=function(d){if(typeof h.initCore.initialized!="undefined")return!1;h.initCore.initialized=!0,h.options=h.options||{},h.options.hashChangeInterval=h.options.hashChangeInterval||100,h.options.safariPollInterval=h.options.safariPollInterval||500,h.options.doubleCheckInterval=h.options.doubleCheckInterval||500,h.options.disableSuid=h.options.disableSuid||!1,h.options.storeInterval=h.options.storeInterval||1e3,h.options.busyDelay=h.options.busyDelay||250,h.options.debug=h.options.debug||!1,h.options.initialTitle=h.options.initialTitle||r.title,h.options.html4Mode=h.options.html4Mode||!1,h.options.delayInit=h.options.delayInit||!1,h.intervalList=[],h.clearAllIntervals=function(){var e,t=h.intervalList;if(typeof t!="undefined"&&t!==null){for(e=0;e<t.length;e++)f(t[e]);h.intervalList=null}},h.debug=function(){(h.options.debug||!1)&&h.log.apply(h,arguments)},h.log=function(){var e=typeof n!="undefined"&&typeof n.log!="undefined"&&typeof n.log.apply!="undefined",t=r.getElementById("log"),i,s,o,u,a;e?(u=Array.prototype.slice.call(arguments),i=u.shift(),typeof n.debug!="undefined"?n.debug.apply(n,[i,u]):n.log.apply(n,[i,u])):i="\n"+arguments[0]+"\n";for(s=1,o=arguments.length;s<o;++s){a=arguments[s];if(typeof a=="object"&&typeof l!="undefined")try{a=l.stringify(a)}catch(f){}i+="\n"+a+"\n"}return t?(t.value+=i+"\n-----\n",t.scrollTop=t.scrollHeight-t.clientHeight):e||c(i),!0},h.getInternetExplorerMajorVersion=function(){var e=h.getInternetExplorerMajorVersion.cached=typeof h.getInternetExplorerMajorVersion.cached!="undefined"?h.getInternetExplorerMajorVersion.cached:function(){var e=3,t=r.createElement("div"),n=t.getElementsByTagName("i");while((t.innerHTML="<!--[if gt IE "+ ++e+"]><i></i><![endif]-->")&&n[0]);return e>4?e:!1}();return e},h.isInternetExplorer=function(){var e=h.isInternetExplorer.cached=typeof h.isInternetExplorer.cached!="undefined"?h.isInternetExplorer.cached:Boolean(h.getInternetExplorerMajorVersion());return e},h.options.html4Mode?h.emulated={pushState:!0,hashChange:!0}:h.emulated={pushState:!Boolean(e.history&&e.history.pushState&&e.history.replaceState&&!/ Mobile\/([1-7][a-z]|(8([abcde]|f(1[0-8]))))/i.test(i.userAgent)&&!/AppleWebKit\/5([0-2]|3[0-2])/i.test(i.userAgent)),hashChange:Boolean(!("onhashchange"in e||"onhashchange"in r)||h.isInternetExplorer()&&h.getInternetExplorerMajorVersion()<8)},h.enabled=!h.emulated.pushState,h.bugs={setHash:Boolean(!h.emulated.pushState&&i.vendor==="Apple Computer, Inc."&&/AppleWebKit\/5([0-2]|3[0-3])/.test(i.userAgent)),safariPoll:Boolean(!h.emulated.pushState&&i.vendor==="Apple Computer, Inc."&&/AppleWebKit\/5([0-2]|3[0-3])/.test(i.userAgent)),ieDoubleCheck:Boolean(h.isInternetExplorer()&&h.getInternetExplorerMajorVersion()<8),hashEscape:Boolean(h.isInternetExplorer()&&h.getInternetExplorerMajorVersion()<7)},h.isEmptyObject=function(e){for(var t in e)if(e.hasOwnProperty(t))return!1;return!0},h.cloneObject=function(e){var t,n;return e?(t=l.stringify(e),n=l.parse(t)):n={},n},h.getRootUrl=function(){var e=r.location.protocol+"//"+(r.location.hostname||r.location.host);if(r.location.port||!1)e+=":"+r.location.port;return e+="/",e},h.getBaseHref=function(){var e=r.getElementsByTagName("base"),t=null,n="";return e.length===1&&(t=e[0],n=t.href.replace(/[^\/]+$/,"")),n=n.replace(/\/+$/,""),n&&(n+="/"),n},h.getBaseUrl=function(){var e=h.getBaseHref()||h.getBasePageUrl()||h.getRootUrl();return e},h.getPageUrl=function(){var e=h.getState(!1,!1),t=(e||{}).url||h.getLocationHref(),n;return n=t.replace(/\/+$/,"").replace(/[^\/]+$/,function(e,t,n){return/\./.test(e)?e:e+"/"}),n},h.getBasePageUrl=function(){var e=h.getLocationHref().replace(/[#\?].*/,"").replace(/[^\/]+$/,function(e,t,n){return/[^\/]$/.test(e)?"":e}).replace(/\/+$/,"")+"/";return e},h.getFullUrl=function(e,t){var n=e,r=e.substring(0,1);return t=typeof t=="undefined"?!0:t,/[a-z]+\:\/\//.test(e)||(r==="/"?n=h.getRootUrl()+e.replace(/^\/+/,""):r==="#"?n=h.getPageUrl().replace(/#.*/,"")+e:r==="?"?n=h.getPageUrl().replace(/[\?#].*/,"")+e:t?n=h.getBaseUrl()+e.replace(/^(\.\/)+/,""):n=h.getBasePageUrl()+e.replace(/^(\.\/)+/,"")),n.replace(/\#$/,"")},h.getShortUrl=function(e){var t=e,n=h.getBaseUrl(),r=h.getRootUrl();return h.emulated.pushState&&(t=t.replace(n,"")),t=t.replace(r,"/"),h.isTraditionalAnchor(t)&&(t="./"+t),t=t.replace(/^(\.\/)+/g,"./").replace(/\#$/,""),t},h.getLocationHref=function(e){return e=e||r,e.URL===e.location.href?e.location.href:e.location.href===decodeURIComponent(e.URL)?e.URL:e.location.hash&&decodeURIComponent(e.location.href.replace(/^[^#]+/,""))===e.location.hash?e.location.href:e.URL.indexOf("#")==-1&&e.location.href.indexOf("#")!=-1?e.location.href:e.URL||e.location.href},h.store={},h.idToState=h.idToState||{},h.stateToId=h.stateToId||{},h.urlToId=h.urlToId||{},h.storedStates=h.storedStates||[],h.savedStates=h.savedStates||[],h.normalizeStore=function(){h.store.idToState=h.store.idToState||{},h.store.urlToId=h.store.urlToId||{},h.store.stateToId=h.store.stateToId||{}},h.getState=function(e,t){typeof e=="undefined"&&(e=!0),typeof t=="undefined"&&(t=!0);var n=h.getLastSavedState();return!n&&t&&(n=h.createStateObject()),e&&(n=h.cloneObject(n),n.url=n.cleanUrl||n.url),n},h.getIdByState=function(e){var t=h.extractId(e.url),n;if(!t){n=h.getStateString(e);if(typeof h.stateToId[n]!="undefined")t=h.stateToId[n];else if(typeof h.store.stateToId[n]!="undefined")t=h.store.stateToId[n];else{for(;;){t=(new Date).getTime()+String(Math.random()).replace(/\D/g,"");if(typeof h.idToState[t]=="undefined"&&typeof h.store.idToState[t]=="undefined")break}h.stateToId[n]=t,h.idToState[t]=e}}return t},h.normalizeState=function(e){var t,n;if(!e||typeof e!="object")e={};if(typeof e.normalized!="undefined")return e;if(!e.data||typeof e.data!="object")e.data={};return t={},t.normalized=!0,t.title=e.title||"",t.url=h.getFullUrl(e.url?e.url:h.getLocationHref()),t.hash=h.getShortUrl(t.url),t.data=h.cloneObject(e.data),t.id=h.getIdByState(t),t.cleanUrl=t.url.replace(/\??\&_suid.*/,""),t.url=t.cleanUrl,n=!h.isEmptyObject(t.data),(t.title||n)&&h.options.disableSuid!==!0&&(t.hash=h.getShortUrl(t.url).replace(/\??\&_suid.*/,""),/\?/.test(t.hash)||(t.hash+="?"),t.hash+="&_suid="+t.id),t.hashedUrl=h.getFullUrl(t.hash),(h.emulated.pushState||h.bugs.safariPoll)&&h.hasUrlDuplicate(t)&&(t.url=t.hashedUrl),t},h.createStateObject=function(e,t,n){var r={data:e,title:t,url:n};return r=h.normalizeState(r),r},h.getStateById=function(e){e=String(e);var n=h.idToState[e]||h.store.idToState[e]||t;return n},h.getStateString=function(e){var t,n,r;return t=h.normalizeState(e),n={data:t.data,title:e.title,url:e.url},r=l.stringify(n),r},h.getStateId=function(e){var t,n;return t=h.normalizeState(e),n=t.id,n},h.getHashByState=function(e){var t,n;return t=h.normalizeState(e),n=t.hash,n},h.extractId=function(e){var t,n,r,i;return e.indexOf("#")!=-1?i=e.split("#")[0]:i=e,n=/(.*)\&_suid=([0-9]+)$/.exec(i),r=n?n[1]||e:e,t=n?String(n[2]||""):"",t||!1},h.isTraditionalAnchor=function(e){var t=!/[\/\?\.]/.test(e);return t},h.extractState=function(e,t){var n=null,r,i;return t=t||!1,r=h.extractId(e),r&&(n=h.getStateById(r)),n||(i=h.getFullUrl(e),r=h.getIdByUrl(i)||!1,r&&(n=h.getStateById(r)),!n&&t&&!h.isTraditionalAnchor(e)&&(n=h.createStateObject(null,null,i))),n},h.getIdByUrl=function(e){var n=h.urlToId[e]||h.store.urlToId[e]||t;return n},h.getLastSavedState=function(){return h.savedStates[h.savedStates.length-1]||t},h.getLastStoredState=function(){return h.storedStates[h.storedStates.length-1]||t},h.hasUrlDuplicate=function(e){var t=!1,n;return n=h.extractState(e.url),t=n&&n.id!==e.id,t},h.storeState=function(e){return h.urlToId[e.url]=e.id,h.storedStates.push(h.cloneObject(e)),e},h.isLastSavedState=function(e){var t=!1,n,r,i;return h.savedStates.length&&(n=e.id,r=h.getLastSavedState(),i=r.id,t=n===i),t},h.saveState=function(e){return h.isLastSavedState(e)?!1:(h.savedStates.push(h.cloneObject(e)),!0)},h.getStateByIndex=function(e){var t=null;return typeof e=="undefined"?t=h.savedStates[h.savedStates.length-1]:e<0?t=h.savedStates[h.savedStates.length+e]:t=h.savedStates[e],t},h.getCurrentIndex=function(){var e=null;return h.savedStates.length<1?e=0:e=h.savedStates.length-1,e},h.getHash=function(e){var t=h.getLocationHref(e),n;return n=h.getHashByUrl(t),n},h.unescapeHash=function(e){var t=h.normalizeHash(e);return t=decodeURIComponent(t),t},h.normalizeHash=function(e){var t=e.replace(/[^#]*#/,"").replace(/#.*/,"");return t},h.setHash=function(e,t){var n,i;return t!==!1&&h.busy()?(h.pushQueue({scope:h,callback:h.setHash,args:arguments,queue:t}),!1):(h.busy(!0),n=h.extractState(e,!0),n&&!h.emulated.pushState?h.pushState(n.data,n.title,n.url,!1):h.getHash()!==e&&(h.bugs.setHash?(i=h.getPageUrl(),h.pushState(null,null,i+"#"+e,!1)):r.location.hash=e),h)},h.escapeHash=function(t){var n=h.normalizeHash(t);return n=e.encodeURIComponent(n),h.bugs.hashEscape||(n=n.replace(/\%21/g,"!").replace(/\%26/g,"&").replace(/\%3D/g,"=").replace(/\%3F/g,"?")),n},h.getHashByUrl=function(e){var t=String(e).replace(/([^#]*)#?([^#]*)#?(.*)/,"$2");return t=h.unescapeHash(t),t},h.setTitle=function(e){var t=e.title,n;t||(n=h.getStateByIndex(0),n&&n.url===e.url&&(t=n.title||h.options.initialTitle));try{r.getElementsByTagName("title")[0].innerHTML=t.replace("<","&lt;").replace(">","&gt;").replace(" & "," &amp; ")}catch(i){}return r.title=t,h},h.queues=[],h.busy=function(e){typeof e!="undefined"?h.busy.flag=e:typeof h.busy.flag=="undefined"&&(h.busy.flag=!1);if(!h.busy.flag){u(h.busy.timeout);var t=function(){var e,n,r;if(h.busy.flag)return;for(e=h.queues.length-1;e>=0;--e){n=h.queues[e];if(n.length===0)continue;r=n.shift(),h.fireQueueItem(r),h.busy.timeout=o(t,h.options.busyDelay)}};h.busy.timeout=o(t,h.options.busyDelay)}return h.busy.flag},h.busy.flag=!1,h.fireQueueItem=function(e){return e.callback.apply(e.scope||h,e.args||[])},h.pushQueue=function(e){return h.queues[e.queue||0]=h.queues[e.queue||0]||[],h.queues[e.queue||0].push(e),h},h.queue=function(e,t){return typeof e=="function"&&(e={callback:e}),typeof t!="undefined"&&(e.queue=t),h.busy()?h.pushQueue(e):h.fireQueueItem(e),h},h.clearQueue=function(){return h.busy.flag=!1,h.queues=[],h},h.stateChanged=!1,h.doubleChecker=!1,h.doubleCheckComplete=function(){return h.stateChanged=!0,h.doubleCheckClear(),h},h.doubleCheckClear=function(){return h.doubleChecker&&(u(h.doubleChecker),h.doubleChecker=!1),h},h.doubleCheck=function(e){return h.stateChanged=!1,h.doubleCheckClear(),h.bugs.ieDoubleCheck&&(h.doubleChecker=o(function(){return h.doubleCheckClear(),h.stateChanged||e(),!0},h.options.doubleCheckInterval)),h},h.safariStatePoll=function(){var t=h.extractState(h.getLocationHref()),n;if(!h.isLastSavedState(t))return n=t,n||(n=h.createStateObject()),h.Adapter.trigger(e,"popstate"),h;return},h.back=function(e){return e!==!1&&h.busy()?(h.pushQueue({scope:h,callback:h.back,args:arguments,queue:e}),!1):(h.busy(!0),h.doubleCheck(function(){h.back(!1)}),p.go(-1),!0)},h.forward=function(e){return e!==!1&&h.busy()?(h.pushQueue({scope:h,callback:h.forward,args:arguments,queue:e}),!1):(h.busy(!0),h.doubleCheck(function(){h.forward(!1)}),p.go(1),!0)},h.go=function(e,t){var n;if(e>0)for(n=1;n<=e;++n)h.forward(t);else{if(!(e<0))throw new Error("History.go: History.go requires a positive or negative integer passed.");for(n=-1;n>=e;--n)h.back(t)}return h};if(h.emulated.pushState){var v=function(){};h.pushState=h.pushState||v,h.replaceState=h.replaceState||v}else h.onPopState=function(t,n){var r=!1,i=!1,s,o;return h.doubleCheckComplete(),s=h.getHash(),s?(o=h.extractState(s||h.getLocationHref(),!0),o?h.replaceState(o.data,o.title,o.url,!1):(h.Adapter.trigger(e,"anchorchange"),h.busy(!1)),h.expectedStateId=!1,!1):(r=h.Adapter.extractEventData("state",t,n)||!1,r?i=h.getStateById(r):h.expectedStateId?i=h.getStateById(h.expectedStateId):i=h.extractState(h.getLocationHref()),i||(i=h.createStateObject(null,null,h.getLocationHref())),h.expectedStateId=!1,h.isLastSavedState(i)?(h.busy(!1),!1):(h.storeState(i),h.saveState(i),h.setTitle(i),h.Adapter.trigger(e,"statechange"),h.busy(!1),!0))},h.Adapter.bind(e,"popstate",h.onPopState),h.pushState=function(t,n,r,i){if(h.getHashByUrl(r)&&h.emulated.pushState)throw new Error("History.js does not support states with fragement-identifiers (hashes/anchors).");if(i!==!1&&h.busy())return h.pushQueue({scope:h,callback:h.pushState,args:arguments,queue:i}),!1;h.busy(!0);var s=h.createStateObject(t,n,r);return h.isLastSavedState(s)?h.busy(!1):(h.storeState(s),h.expectedStateId=s.id,p.pushState(s.id,s.title,s.url),h.Adapter.trigger(e,"popstate")),!0},h.replaceState=function(t,n,r,i){if(h.getHashByUrl(r)&&h.emulated.pushState)throw new Error("History.js does not support states with fragement-identifiers (hashes/anchors).");if(i!==!1&&h.busy())return h.pushQueue({scope:h,callback:h.replaceState,args:arguments,queue:i}),!1;h.busy(!0);var s=h.createStateObject(t,n,r);return h.isLastSavedState(s)?h.busy(!1):(h.storeState(s),h.expectedStateId=s.id,p.replaceState(s.id,s.title,s.url),h.Adapter.trigger(e,"popstate")),!0};if(s){try{h.store=l.parse(s.getItem("History.store"))||{}}catch(m){h.store={}}h.normalizeStore()}else h.store={},h.normalizeStore();h.Adapter.bind(e,"unload",h.clearAllIntervals),h.saveState(h.storeState(h.extractState(h.getLocationHref(),!0))),s&&(h.onUnload=function(){var e,t,n;try{e=l.parse(s.getItem("History.store"))||{}}catch(r){e={}}e.idToState=e.idToState||{},e.urlToId=e.urlToId||{},e.stateToId=e.stateToId||{};for(t in h.idToState){if(!h.idToState.hasOwnProperty(t))continue;e.idToState[t]=h.idToState[t]}for(t in h.urlToId){if(!h.urlToId.hasOwnProperty(t))continue;e.urlToId[t]=h.urlToId[t]}for(t in h.stateToId){if(!h.stateToId.hasOwnProperty(t))continue;e.stateToId[t]=h.stateToId[t]}h.store=e,h.normalizeStore(),n=l.stringify(e);try{s.setItem("History.store",n)}catch(i){if(i.code!==DOMException.QUOTA_EXCEEDED_ERR)throw i;s.length&&(s.removeItem("History.store"),s.setItem("History.store",n))}},h.intervalList.push(a(h.onUnload,h.options.storeInterval)),h.Adapter.bind(e,"beforeunload",h.onUnload),h.Adapter.bind(e,"unload",h.onUnload));if(!h.emulated.pushState){h.bugs.safariPoll&&h.intervalList.push(a(h.safariStatePoll,h.options.safariPollInterval));if(i.vendor==="Apple Computer, Inc."||(i.appCodeName||"")==="Mozilla")h.Adapter.bind(e,"hashchange",function(){h.Adapter.trigger(e,"popstate")}),h.getHash()&&h.Adapter.onDomLoad(function(){h.Adapter.trigger(e,"hashchange")})}},(!h.options||!h.options.delayInit)&&h.init()}(window)
// ======================================================================
// Feature Dection

var FeatureDetection = (function() {
  var results = {};
  var prefixes = ['', 'Webkit', 'Moz', 'O', 'ms', 'Khtml'];

  // Detect the android native browser
  var nua = navigator.userAgent;
  var is_android_native = (
    nua.indexOf('Mozilla/5.0') > -1 &&
    nua.indexOf('Android ') > -1 &&
    nua.indexOf('AppleWebKit') > -1 &&
    nua.indexOf('Chrome') === -1 );
    
  var is_icecream_sandwich = (
    nua.indexOf('Android 2') > -1 &&
    nua.indexOf('Chrome') === -1 );
  
  // Test for e.g. 'background-clip: text;' support.
  results['background-clip'] = checkForProperty('backgroundClip') && !is_android_native;

  // Test if device supports touch events
  results['touch'] = ('ontouchstart' in document);

  // Test if HTML5 history is enabled
  results['history'] = (window.history && window.history.pushState && !is_icecream_sandwich) ? true : false;

  // Apply classes to <html>
  var htmlElem = $('html');

  for (var key in results) {
    results['no-' + key] = !results[key];
  }

  for (key in results) {
    if (results[key] === true) {
      htmlElem.addClass(key);
    }
  }

  function checkForProperty(propName) {
    var div = document.createElement('div');
    if (propName in div.style) { return true; }

    var capitalized = propName.replace(/^([a-z])/, function(s) { return s.toUpperCase(); });
    for (var n = 0; n < prefixes.length; n++) {
      if ((prefixes[n] + capitalized) in div.style) { return true; }
    }

    return false;
  }

  return results;
})();



// ======================================================================
// Side navigation menu, Top (mobile) navigation menu 

var SideNav = (function() {
  var sideNav = $('.side-nav');
  var topNav = $('.top-nav');
  var navItems = $("li a", sideNav);
  var collapsableNav = (
    FeatureDetection['history'] &&
    !FeatureDetection['touch'] );

  init();
  function init() {
            
    if (!collapsableNav) {
      $('html').addClass('side-nav-always-open');
    }
    else {
      // wait till page has loaded, and then some
      $(function() { setTimeout(collapse, 1200); });
      
      sideNav
        .mouseenter(expand)
        .mouseleave(collapse);
      
      navItems.on('mouseenter', expand);
    }
    
    watchPageChanges();
		updateTopNav(getRelativeUrl());    

    navItems.click(navItemClicked);
    $('.top-nav a').click(navItemClicked);
    
  }
  
  function navItemClicked() {
    // speed up hiding and showing nav (useful on mobile)
    var homeClicked = ($(this).attr("href") === "/");
    // bubble so link handlers happen first
    setTimeout(function() {
      if (homeClicked) {
        $('body').addClass('home');
      }
      else {
        $('body').removeClass('home');
      }
    }, 0);
    // reduces flickering on mobile
    if (homeClicked) {
      sideNav.addClass("white-nav");
    }
  }
  
  function watchPageChanges() {
    $(window).on('url-changed', function() {
      var url = getRelativeUrl();
      if (url === Navigation.lastUrl) { return; }
      
      updateTopNav(url);
      updateSideNav(url);
      updateWhiteNav();
      
    });
  }
  
  function collapse() {
    if (isHome() || !collapsableNav) { return; }
    $('body').addClass('nav-collapsed');
  }
  
  function expand() {
    $('body').removeClass('nav-collapsed');
  }
  
  function isHome() {
    return '/' === location.pathname + location.search;
  }

  function updateWhiteNav() {
    if (isHome()) {
      sideNav.addClass("white-nav");
    }
    else {
      if (collapsableNav) {
        setTimeout(function() {
           sideNav.removeClass("white-nav");
        }, 250);
      }
      else {
        sideNav.removeClass("white-nav");
      }
    }
  }

  function updateSideNav(url) {
    
    // set collapse state on the nav
    if (collapsableNav) {
      if (url === "/") {
        $('body').removeClass('nav-collapsed');
      }
      else {
        $('body').addClass('nav-collapsed');
      }
    }
    
    // Rewrite new page URLs to just their base part
    var match = url.match(/^\/([\w\d-]+)\/?.*/);
    if (!match) {
      navItems.removeClass("selected");
      return;
    }
    var baseUrl = match[1];
    if (baseUrl === "lib") {
      baseUrl = "/library/";
    }
    else {
      baseUrl = "/" + baseUrl + "/";
    }
    
    // Find the matching nav element 
    var itemToSelect = null;
    navItems.each(function() {
      var link = $(this);
      if (link.attr("href") === baseUrl) {
        itemToSelect = link;
        return;
      }
    });
    
    // change selected classes
    navItems.removeClass("selected");
    if (itemToSelect) {
      itemToSelect.addClass("selected");
    }
    
  }

  function updateTopNav(url) {
    var backUrl = '/';
    var backLabel = 'GV';
    var bodyClass = 'home';

    if (/^\/design\/.+/.test(url)) {
      backUrl = '/design/';
      backLabel = 'Design';
      bodyClass = '';
    }
    else if (/^\/team\/.+$/.test(url)) {
      backUrl = '/team/';
      backLabel = 'Team';
      bodyClass = '';
    }
    else if (/^\/library\/.+$/.test(url)) {
      backUrl = '/library/';
      backLabel = 'Library';
      bodyClass = '';
    }
    else if (/^\/lib\/.+$/.test(url)) {
      backUrl = '/library/';
      backLabel = 'GV Library';
      bodyClass = '';
      // Detect if you visitited a category
      if (FeatureDetection['history']) {
        var lastUrl = History.getStateByIndex(History.getCurrentIndex()-1).url;
        var match = /\/library\/([\w\d-]+)\/?$/.exec(lastUrl);
        if (match) {
          backLabel = match[1].replace("-", " ");
          backLabel = backLabel.charAt(0).toUpperCase() + backLabel.slice(1);
          backUrl = '/library/' + match[1] + '/';
        }
      }
    }
    
    $('.btn.back', topNav)
      .attr('href', backUrl)
      .find('.label').text(backLabel)
      .unbind('click.bodyclass')
      .bind('click.bodyclass', function() {
        $('body').addClass(bodyClass);
      });
  }
  
})();



// ======================================================================
// Tooltips used on portfolio page, bio page

var Tooltip = (function() {
  var mouseX = 0;
  var mouseY = 0;

  init();

  function init() {
    if (FeatureDetection['no-touch']) {
      bindEvents();
      $(window).on('content-added', bindEvents);

      $(window).on('navigated', hideTooltip);

      $(window).on('mousemove', function(e) {
        mouseX = e.pageX;
        mouseY = e.pageY;
      });
    }
  }

  function bindEvents() {
    $('.has-tooltip').each(function() {
      var elem = $(this);
      elem.unbind('mouseenter.tooltip mouseleave.tooltip');
      elem.on('mouseleave.tooltip', hideTooltip);
      elem.on('mouseenter.tooltip', showTooltipForElement);
    });
  }

  function showTooltipForElement() {
    var elem = $(this);
    var contentElem = $('.tooltip-content', elem);
    var content = elem.attr('data-tooltip-content') || contentElem.html();
    var classes = elem.attr('data-tooltip-class') || (contentElem ? contentElem[0].className.replace(/tooltip-content/, '') : '');

    showTooltip(content, elem, classes);
  }

  function showTooltip(content, elem, classes) {
    hideTooltip();

    elem = $(elem);
    var x, y;

    if (elem.length) {
      var offset = elem.offset();
      x = offset.left;
      y = offset.top + elem.height() / 2;
    }
    else {
      x = mouseX;
      y = mouseY;
    }

    var tooltip = buildTooltip(content, classes);
    var tooltipBody = $('.tooltip-body', tooltip);
    tooltip.css('opacity', 0).appendTo('body');
    
    tooltip.css({
      opacity: 1,
      left: x,
      top: y
    });

    tooltipBody.css('margin-top', -tooltipBody.outerHeight() / 2);
  }

  function hideTooltip() {
    $('.tooltip-element').remove();
  }

  function buildTooltip(content, classes) {
    return $('' +
      '<div class="tooltip-element ' + (classes || '') + '">' +
        '<div class="tooltip-body">' +
          '<div class="tooltip-inner">' +
            (content || '') +
          '</div>' +
        '</div>' +
      '</div>'
    );
  }

  return {
    show: showTooltip,
    hide: hideTooltip
  };
})();


// ======================================================================
// Core page navitation - AJAX loading of content area

function getRelativeUrl() {
  return location.pathname + location.search + location.hash;
}

var Navigation = (function() {
  var self = {
    lastUrl: getRelativeUrl(),
    trueUrl: getRelativeUrl(),
    loading: false
  };

  var baseUrlSansProtocol = '//' + location.hostname + (location.port ? ':' + location.port : '');
  var baseUrl = location.protocol + baseUrlSansProtocol;

  var baseUrlPattern = new RegExp('^(?:' + baseUrl + '|' + baseUrlSansProtocol + ')');
  var anchorPattern = /^#/;
  var relativeUrlPattern = /^\//;

  init();

  function init() {
    if (FeatureDetection['history']) {
      watchClicks();
      watchStateChange();
      updateMobileTitle();
    }
  }

  function watchClicks() {
    $(document).delegate('a', 'click', linkClicked);
  }

  function watchStateChange() {
    History.Adapter.bind(window, 'statechange', stateChanged);
  }
  
  function stateChanged() {
    
    var state = History.getState() || {};
    var data = state.data || {};
        
    var visibleUrl = getRelativeUrl();
    var url = data.url || visibleUrl;

    $(window).trigger('url-changed', url);

    if (url !== self.trueUrl) {
      navigated(state);
      self.trueUrl = url;
    }
    else {
      $(".content-frame").show();
    }

    self.lastUrl = visibleUrl;
  }

  function linkClicked(e) {
    // ignore non-left-clicks on desktop
    if (!e.originalEvent.touches && e.which !== 1) { return; }
    // ignore clicks with a modifier key
    if (e.metaKey || e.altKey || e.ctrlKey || e.shiftKey) { return; }

    var url = relativizeUrl(this.href);
    var isInPage = anchorPattern.test(url.replace(location.pathname, ''));
    var isRelative = relativeUrlPattern.test(url);
    var isBlacklisted = checkIsBlacklistedUrl(url);

    // in these cases, do the default behavior
    if (isBlacklisted || isInPage || !isRelative) { return; }

    // detect top nav back button and go back in history
    if ( $(this).hasClass("nav-go-back") ) {
      if (isGoingBack(url)) {
        History.back();
        e.preventDefault();
        return;
      }
    }

    // else, do an ajax load
    e.preventDefault();
    showUrl(url);
  }

  function isGoingBack(url) {
    if (!FeatureDetection.history) { return false; }
    var i = History.getCurrentIndex();
    if (i === 0) { return false; }
    var lastUrl = relativizeUrl( History.getStateByIndex(i-1).url );
    return (lastUrl === url);    
  }

  function checkIsBlacklistedUrl(url) {
    var blacklist = [
      /^\/wp-admin\//, // WP Admin
      /^\/(2013|2014)\/?/, // Year in Reviews
      /^\/sprint\/?/, // Sprint page
      /^\/life-sciences\/?/, // Life Sciences page      
			/^\/lib\/the-product-design-sprint-a-five-day-recipe-for-startups\/?/, // Sprint page redirect
      /^\/workshops\/?/, // Old workshops page
      /^\/product\/?/, // Old product page
      /\.[a-z]{2,}$/ // Files
    ];

    for (var n = 0; n < blacklist.length; n++) {
      var pattern = (typeof blacklist[n] === 'string') ? new RegExp(blacklist[n]) : blacklist[n];
      if (pattern.test(url)) { return true; }
    }

    return false;
  }

  function showUrl(url) {
    // Remember current scroll position for when user goes back
    var currentState = History.getState();
    var data = currentState.data;
    
    data.scrollPos = $('body').scrollTop();
    History.replaceState(data, null, currentState.url);

    // Push new URL onto stack, triggering AJAX load
    $(".content-frame").hide();
    History.pushState({url: url}, document.title, url);
  }

  function navigated(state) {
    var contentFrame = $('.content-frame');
    var url = relativizeUrl(state.cleanUrl);

    contentFrame.hide();

    $('.top-nav .title').text('');

    self.loading = true;

    var ajaxUrl = url + (/\?/.test(url) ? '&' : '?') + 'format=content';

    $.ajax({
      type: 'get',
      url: ajaxUrl,
      success: function(data) {
        done(null, data);
      },
      error: function(res, status) {
        done(status, res.responseText || res.responseXML);
      }
    });

    function done(err, res) {
      self.loading = false;

      // If they've navigated elsewhere in the meantime, don't render this page
      var activeUrl = getRelativeUrl();
      if (url !== activeUrl) { return; }

      contentFrame.html(res);
      updateBodyClass();
      updateTitle();
      contentFrame.show();
      $('body').scrollTop(state.data.scrollPos || 0);
      
      
      $(window).trigger('navigated', state);
      _gaq.push(['_trackPageview', activeUrl]);

      $(window).trigger('content-added');
    }

  }

  function relativizeUrl(url) {
    return url.replace(baseUrlPattern, '');
  }

  function updateBodyClass() {
    var toKeep = ['nav-collapsed', 'fast-collapse'];
    var surrogate = $('#body-class-surrogate').remove();

    if (!surrogate.length) { return; }

    var oldClasses = document.body.className.split(/\s+/);
    var newClasses = surrogate[0].className.split(/\s+/);

    for (var n = 0; n < toKeep.length; n++) {
      var keeper = toKeep[n];
      var inOld = oldClasses.indexOf(keeper) !== -1;
      var inNew = newClasses.indexOf(keeper) !== -1;
      
      if (inOld && !inNew) { newClasses.push(keeper); }
    }

    document.body.className = newClasses.join(' ');
  }

  function updateTitle() {
    var surrogate = $('#title-surrogate').remove();
    var title = surrogate.text() || document.title;
    document.title = title;
    updateMobileTitle();
  }

  function updateMobileTitle() {
    var title = document.title.split(/\s*\|\s*/)[0];
    var url = getRelativeUrl();

    if (/^\/lib\//.test(url)) {
      title = '';
    }
    else if (/^\/workshops\/.*/.test(url)) {
      title = 'Workshops';
    }

    $('.top-nav .title').text(title);
  }

  self.showUrl = showUrl;

  return self;
})();



// ======================================================================
// Social sharing popups

var Social = (function() {
  init();

  function init() {
    if ( FeatureDetection['touch'] ) { return; }

    $(document).delegate('.social-button', 'click', function(e) {
      e.preventDefault();
      window.open(this.href, null, 'toolbar=no,menubar=no,width=540,height=380');
    });
  }

  return {};
})();



// ======================================================================
// Lightbox modal - Used on bio pages

var Modal = (function() {

  init();

  function init() {
    $(document)
      .delegate('[data-popup-image]', 'click', popupImageClick);

    $(window).on('url-changed', close);
  }

  function open(contents) {

    var modal = $('' +
      '<div class="modal">' +
        '<div class="modal-inner"></div>' +
        '<div class="close">&times;</div>' +
      '</div>'
    );

    $('.modal-inner', modal).append(contents);

    var backdrop = $('<div class="modal-backdrop"></div>');
    backdrop.append(modal);
    backdrop.appendTo('body');

    $(".close", modal).click(close);
    modal.click(function() {
      return false;
    });
    modal.bind("touchend", function() {
      close();
      return false;
    });
    backdrop.bind("click", function() {
      close();
      return false;
    });

    $("html").css({'overflow':'hidden'});

    return modal;
  }


  function close() {
    var modal = $('.modal');
    $('.modal, .modal-backdrop').remove();
    $("html").css({'overflow':'auto'});
    return modal;
  }

  function popupImageClick() {
    var url = $(this).attr('data-popup-image');
    Modal.open('<img src="' + url + '">');
  }

  return {
    open: open,
    close: close
  };
  
})();



// ======================================================================
// Handler to trigger page-specific scripts when the page loads
 
function subscribeToPageLoad(regex, loadCallback, destroyCallback) {
  destroyCallback = destroyCallback || function() {};
  var match = new RegExp(regex);
  var loaded = false;

  function trigger() {
    var url = getRelativeUrl();
    if (match.test(url)) {
      if (loaded) { destroyCallback(); }
      loadCallback();
      loaded = true;
    }
    else if (loaded) {
      destroyCallback();
      loaded = false;
    }
  }
  $(window).on('navigated', trigger);
  $(function(){ trigger(); });
}


// ======================================================================
// Pinning side nav on scroll - Used on portfolio and team page
// Becasue the main content area has a CSS transform,
// Pinned elements need to be dynamically moved out to an outer class
// when they are pinned.
 
var Pinning = (function() {

  var pinned = false;
  var element;
  var parent;
  var scrollPoint;

  subscribeToPageLoad(
    "^/(team|portfolio)/?",
    load, unload
  );
  
  function load() {
    element = $(".pin-element").first();
    if (element.length) {
      parent = element.parent();
      scrollPoint = element.offset().top;
      $(document).bind("scroll", onWindowScroll);
    }
  }

  function unload() {
    $(document).unbind("scroll", onWindowScroll);
    element.remove();
  }

  function onWindowScroll() {
    if ($(document).scrollTop() > scrollPoint) {
      if (!pinned) {
        element.addClass("pinned");
        $('.pin-content').prepend(element);
        pinned = true;
      }
    }
    else if (pinned) {
      element.removeClass("pinned");
      parent.prepend(element);
      pinned = false;
    }
  }

})();


// ======================================================================
// More buttons on the portfolio page

var PortfolioMore = (function() {

  subscribeToPageLoad(
    "^/portfolio/?",
    load, unload
  );
  
  function load() {
    $(".portfolio-content .more-toggle").click(moreClicked);
  }

  function unload() {}

  function moreClicked() {
    var investments = $(this).parent().parent();
    $(this).toggleClass("expanded");
    $(".more-investments", investments).toggle();
  }

})();



// ======================================================================
// Homepge slideshow/carousel

var HomepageCarousel = (function() {
  var self = {
    autoplay: false,
    playing: false,
    interval: 5000
  };

  var root;
  var nav;
  var timer;

  var slides;
  var numSlides;
  var slideIndex;

  subscribeToPageLoad(
    "^/?(?:#.*)?$",
    load, unload
  );

  function load() {
    root = $('.home-carousel');
    if (!root.length) { return; }

    nav = $('.nav', root);
    slides = $('.slide', root);
    numSlides = slides.length;
    slideIndex = 0;

    buildNav();
    positionSlides();
    showNavSelection();

    if (FeatureDetection['touch']) {
      enableSwiping();
    }

    if (self.autoplay) { play(); }
    
    slides.addClass('loaded');
  }

  function unload() {
    pause();
  }

  function buildNav() {
    slides.each(function(n) {
      nav.append('' +
        '<a href="#slide-' + n + '" data-slide="' + n + '">' +
          '<span class="icon"></span>' +
        '</a>'
      );
    });

    var clickEvent = FeatureDetection['touch'] ? 'touchstart' : 'mousedown';
    nav.delegate('a', clickEvent, navClicked);
    nav.delegate('a', 'click', function(e) {
      e.preventDefault();
    });
  }

  function positionSlides() {
    slides.removeClass('active stage-left stage-right animated');
    slides.first().addClass('active');
    slides.filter(':gt(0)').addClass('stage-left');
  }

  function enableSwiping() {
    var carousel = $('.home-carousel .slides');
    var slide;
    var dragging = false;
    var horizontal = false;
    var initialX = 0;
    var initialY = 0;
    var lastTime = 0;
    var velocity = 0;
    var width = 0;

    var minDistance = 90; /* px */
    var minSpeed = 2; /* px/ms */

    carousel.on('touchstart', down);
    $(document).on('touchmove', move);
    $(document).on('touchend', up);

    function down(e) {
      dragging = true;
      horizontal = false;

      var touch = getTouch(e);
      initialX = touch.pageX;
      initialY = touch.pageY;

      width = $('.home-carousel .slides').width();
      slide = $('.slide.active', carousel);
      lastTime = new Date().getTime();

      slide.removeClass('animated');
    }

    function move(e) {
      if (!dragging) { return; }

      var touch = getTouch(e);
      var x = touch.pageX;
      var y = touch.pageY;
      
      var diffX = x - initialX;
      var diffY = y - initialY;

      var now = new Date().getTime();
      velocity = diffX / (now - lastTime);
      lastTime = now;

      var travel = 10;
      var ratio = 1.2;
      // If they've dragged more than 10px vertically, and the overall
      // movement is more vertical than horizontal, abort
      if (Math.abs(diffY) > travel && Math.abs(diffY / diffX) > ratio) {
        dragging = false;
        return;
      }
      
      if (!horizontal && Math.abs(diffX) > travel && Math.abs(diffX / diffY) > ratio) {
        horizontal = true;
      }

      if (horizontal) {
        e.preventDefault();
        var percent = diffX / width * 100;
        slide.css('left', percent + '%');
      }
    }

    function up(e) {
      if (!dragging) { return; }
      dragging = false;
      
      var x = getTouch(e).pageX;
      var diff = x - initialX;

      slide.addClass('animated');
      slide.css('left', '');

      if (diff < -minDistance || velocity < -minSpeed) { next(); }
      else if (diff > minDistance || velocity > minSpeed) { previous(); }
    }

    function getTouch(e) {
      if (!e.originalEvent) { return e; }
      var changed = e.originalEvent.changedTouches || [];
      var touches = e.originalEvent.touches || [];
      var touch = changed[0] || touches[0] || e.originalEvent;
      return touch;
    }
  }


  function play() {
    if (self.playing) { return; }
    self.playing = true;
    timer = setTimeout(tick, self.interval);
  }

  function pause() {
    if (!self.playing) { return; }
    self.playing = false;
    clearTimeout(timer);
  }

  function tick() {
    if (!self.playing) { return; }
    timer = setTimeout(tick, self.interval);
    next();
  }

  function next() {
    var nextIndex = slideIndex + 1;
    if (nextIndex >= numSlides) { nextIndex = 0; }
    showSlide(nextIndex);
  }

  function previous() {
    var nextIndex = slideIndex - 1;
    if (nextIndex < 0) { nextIndex = numSlides - 1; }
    showSlide(nextIndex);
  }

  function showSlide(nextIndex) {
    var activeSlide = slides.filter(':eq(' + slideIndex + ')');
    var nextSlide = slides.filter(':eq(' + nextIndex + ')');
    
    var isAfter = nextIndex > slideIndex;
    var isWrapForward = (nextIndex === 0 && slideIndex === numSlides - 1);
    var isWrapBackward = (nextIndex === numSlides - 1 && slideIndex === 0);

    var fromDir, toDir;
    if ((isAfter || isWrapForward) && !isWrapBackward) {
      fromDir = 'stage-right';
      toDir = 'stage-left';
    }
    else {
      fromDir = 'stage-left';
      toDir = 'stage-right';
    }

    nextSlide
      .removeClass('animated stage-right stage-left')
      .addClass(fromDir);

    setTimeout(function(){
      activeSlide
        .removeClass('active stage-right stage-left')
        .addClass('animated ' + toDir);
      nextSlide.addClass('animated active');
    });

    slideIndex = nextIndex;
    showNavSelection();
  }

  function navClicked(e) {
    e.preventDefault();
    e.stopPropagation();
    var index = parseInt($(this).attr('data-slide') || 0, 10);
    showSlide(index);
  }

  function showNavSelection() {
    $('a', nav).removeClass('selected');
    $('a[data-slide="' + slideIndex + '"]').addClass('selected');
  }

  self.play = play;
  self.pause = pause;
  self.next = next;
  self.previous = previous;

  return self;
})();


// ======================================================================
// Library: Search link toggle 

var LibrarySearch = (function() {

  subscribeToPageLoad(
    "^/library/.*",
    load, unload
  );
  
  function load() {
		var search = $(".top-nav .search");
  	search.show();
		search.unbind().click(function () {
			$(".library-header form").toggle();
			$(".library-header input").focus();
		})
	}

  function unload() {
		$(".top-nav .search").unbind();
		$(".top-nav .search").hide();
  }

})();


// ======================================================================
// Library: Playing YouTube and Google Docs videos when image is clicked 

var LibraryVideoPlay = (function() {

  subscribeToPageLoad(
    "^/lib/.*",
    load, unload
  );
  
  function load() {
    $(".article-video.youtube").click(youtubeVideoClicked);
    $(".article-video.gdocs").click(gdocsVideoClicked);
  }

  function unload() {
  }

  function youtubeVideoClicked() {
    var url = $(this).attr("data-src");
    url += "?autohide=1&showinfo=0&autoplay=1";
    $(this).html("<iframe src='" + url + "' allowfullscreen></iframe>");
  }

  function gdocsVideoClicked() {
    $(".article-video-login-message").show();
    var url = $(this).attr("data-src");
    $(this).html("<iframe src='" + url + "'></iframe>");
  }

})();



