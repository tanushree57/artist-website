var fusion={fusionResizeWidth:0,fusionResizeHeight:0,currentPostID:null,toBool:function(t){return 1===t||"1"===t||!0===t||"true"===t||"on"===t},restArguments:function(t,e){return e=null==e?t.length-1:+e,function(){for(var n,i=Math.max(arguments.length-e,0),o=Array(i),r=0;r<i;r++)o[r]=arguments[r+e];switch(e){case 0:return t.call(this,o);case 1:return t.call(this,arguments[0],o);case 2:return t.call(this,arguments[0],arguments[1],o)}for(n=Array(e+1),r=0;r<e;r++)n[r]=arguments[r];return n[e]=o,t.apply(this,n)}},debounce:function(t,e,n){var i,o,r,s,u,a=this;return r=function(e,n){i=null,n&&(o=t.apply(e,n))},(s=this.restArguments(function(s){return i&&clearTimeout(i),n?(u=!i,i=setTimeout(r,e),u&&(o=t.apply(this,s))):i=a.delay(r,e,this,s),o})).cancel=function(){clearTimeout(i),i=null},s},isSmall:function(){return Modernizr.mq("only screen and (max-width:"+fusionJSVars.visibility_small+"px)")},isMedium:function(){return Modernizr.mq("only screen and (min-width:"+(parseInt(fusionJSVars.visibility_small)+1)+"px) and (max-width:"+parseInt(fusionJSVars.visibility_medium)+"px)")},isLarge:function(){return Modernizr.mq("only screen and (min-width:"+(parseFloat(fusionJSVars.visibility_medium)+1)+"px)")},getHeight:function(t,e){var n=0;return"number"==typeof t?n=t:"string"==typeof t&&(t.includes(".")||t.includes("#"))?(e=void 0!==e&&e,jQuery(t).each(function(){n+=jQuery(this).outerHeight(e)})):n=parseFloat(t),n},getAdminbarHeight:function(){var t=jQuery("#wpadminbar").length?parseInt(jQuery("#wpadminbar").height()):0;return t+=jQuery(".fusion-fixed-top").length?parseInt(jQuery(".fusion-fixed-top").height()):0},isWindow:function(t){return null!=t&&t===t.window},getObserverSegmentation:function(t){var e={};return t.each(function(){jQuery(this).data("animationoffset")||jQuery(this).attr("data-animationoffset","top-into-view")}),e={"top-into-view":t.filter('[data-animationoffset="top-into-view"]'),"top-mid-of-view":t.filter('[data-animationoffset="top-mid-of-view"]'),"bottom-in-view":t.filter('[data-animationoffset="bottom-in-view"]')},jQuery.each(e,function(t,n){n.length||delete e[t]}),0===Object.keys(e).length&&(e["top-into-view"]=t),e},getAnimationIntersectionData:function(t){var e="",n=0,i="0px 0px 0px 0px";return"string"==typeof t?e=t:void 0!==t.data("animationoffset")&&(e=t.data("animationoffset")),"top-mid-of-view"===e?i="0px 0px -50% 0px":"bottom-in-view"===e&&(n=[0,.2,.4,.6,.7,.8,.9,1]),{root:null,rootMargin:i,threshold:n}},shouldObserverEntryAnimate:function(t,e){var n=!1,i=1;return 1<e.thresholds.length?t.boundingClientRect.height>t.rootBounds.height?(i=t.rootBounds.height/t.boundingClientRect.height,e.thresholds.filter(function(e){return e>=t.intersectionRatio&&e<=i}).length||(n=!0)):t.isIntersecting&&1===t.intersectionRatio&&(n=!0):t.isIntersecting&&(n=!0),n},getCurrentPostID:function(){return null===this.currentPostID&&(this.currentPostID=void 0!==jQuery("body").data("awb-post-id")?jQuery("body").data("awb-post-id"):0),this.currentPostID}};fusion.delay=fusion.restArguments(function(t,e,n){return setTimeout(function(){return t.apply(null,n)},e)}),fusion.ready=function(t){if("function"==typeof t)return"complete"===document.readyState?t():void document.addEventListener("DOMContentLoaded",t,!1)},fusion.passiveSupported=function(){var t,e;if(void 0===fusion.supportsPassive){try{e={get passive(){t=!0}},window.addEventListener("test",e,e),window.removeEventListener("test",e,e)}catch(e){t=!1}fusion.supportsPassive=!!t&&{passive:!0}}return fusion.supportsPassive},fusion.getElements=function(t){var e=[];return t?("object"==typeof t?Object.keys(t).forEach(function(n){Element.prototype.isPrototypeOf(t[n])&&e.push(t[n])}):"string"==typeof t&&(e=document.querySelectorAll(t),e=Array.prototype.slice.call(e)),e):[]},Element.prototype.matches||(Element.prototype.matches=Element.prototype.msMatchesSelector||Element.prototype.webkitMatchesSelector),Element.prototype.closest||(Element.prototype.closest=function(t){var e=this;do{if(e.matches(t))return e;e=e.parentElement||e.parentNode}while(null!==e&&1===e.nodeType);return null}),jQuery(document).ready(function(){var t;void 0===jQuery.migrateVersion&&2<parseInt(jQuery.fn.jquery)&&jQuery(window.document).triggerHandler("ready"),t=fusion.debounce(function(){fusion.fusionResizeWidth!==jQuery(window).width()&&(window.dispatchEvent(new Event("fusion-resize-horizontal",{bubbles:!0,cancelable:!0})),fusion.fusionResizeWidth=jQuery(window).width()),fusion.fusionResizeHeight!==jQuery(window).height()&&(jQuery(window).trigger("fusion-resize-vertical"),fusion.fusionResizeHeight=jQuery(window).height())},250),fusion.fusionResizeWidth=jQuery(window).width(),fusion.fusionResizeHeight=jQuery(window).height(),jQuery(window).on("resize",t)});