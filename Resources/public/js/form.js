!function(e){var t={};function n(r){if(t[r])return t[r].exports;var i=t[r]={i:r,l:!1,exports:{}};return e[r].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var i in e)n.d(r,i,function(t){return e[t]}.bind(null,i));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=0)}([function(e,t,n){"use strict";function r(e){e.addEventListener("change",function(){!function(e){var t=/(\d\d\d\d\d\d\d\d\d)(\d\d)/gm,n=e.match(/\d+/g);if(null===n)return!1;var r,i,o=n.map(String).join("");for(;null!==(r=t.exec(o));){r.index===t.lastIndex&&t.lastIndex++;var a=r[1],u=r[2];(i=parseInt(u)===97-a%97)||(i=parseInt(u)===97-"2".concat(a)%97)}return i}(this.value)?this.setCustomValidity("NISS-INSZ format error"):this.setCustomValidity("")})}function i(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}n.r(t);var o={iframe:"ems-form-iframe",form:"ems-form"};var a=function(){function e(t){var n=this;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e);var r=Object.assign({},o,t);if(this.iframe=document.getElementById(r.iframe),this.form=document.getElementById(r.form),null!==this.iframe){var i=new URL(this.iframe.getAttribute("src"));this.origin=i.origin,window.addEventListener("message",function(e){return n.onMessage(e)})}}var t,n,a;return t=e,(n=[{key:"isValid",value:function(){return null!==this.iframe&&null!==this.form}},{key:"init",value:function(){this.isValid()&&this.postMessage({instruction:"form"})}},{key:"insertForm",value:function(e){var t=this;if(null!==this.form){var n=(new DOMParser).parseFromString("<!doctype html><body>"+e.trim(),"text/html");this.form.innerHTML=n.body.textContent,this.form.querySelector("form").addEventListener("submit",function(e){return t.onSubmitForm(e)}),Array.from(document.getElementsByClassName("niss-insz")).forEach(function(e){r(e)})}}},{key:"onMessage",value:function(e){if(e.origin===this.origin){var t=JSON.parse(e.data);switch(t.instruction){case"form":case"validation-error":this.insertForm(t.response);break;case"submitted":this.form.innerHTML=t.response;break;default:return}}}},{key:"onSubmitForm",value:function(e){e.preventDefault();var t=new FormData(e.target),n={};t.forEach(function(e,t){n[t]=e}),this.postMessage({instruction:"submit",form:n})}},{key:"postMessage",value:function(e){this.iframe.contentWindow.postMessage(JSON.stringify(e),this.origin)}}])&&i(t.prototype,n),a&&i(t,a),e}();function u(){if(function(){var e=document.getElementById(o.iframe),t=document.getElementById(o.form);return null!==e&&null!==t}()){var e=new a;e.iframe.onload=function(){e.init()}}}n.d(t,"defaultLoad",function(){return u}),window.emsForm=a,document.addEventListener("DOMContentLoaded",u)}]);