if(!self.define){const e=e=>{"require"!==e&&(e+=".js");let r=Promise.resolve();return s[e]||(r=new Promise((async r=>{if("document"in self){const s=document.createElement("script");s.src=e,document.head.appendChild(s),s.onload=r}else importScripts(e),r()}))),r.then((()=>{if(!s[e])throw new Error(`Module ${e} didn’t register its module`);return s[e]}))},r=(r,s)=>{Promise.all(r.map(e)).then((e=>s(1===e.length?e[0]:e)))},s={require:Promise.resolve(r)};self.define=(r,t,i)=>{s[r]||(s[r]=Promise.resolve().then((()=>{let s={};const o={uri:location.origin+r.slice(1)};return Promise.all(t.map((r=>{switch(r){case"exports":return s;case"module":return o;default:return e(r)}}))).then((e=>{const r=i(...e);return s.default||(s.default=r),s}))})))}}define("./service-worker.js",["./workbox-ea368087"],(function(e){"use strict";self.skipWaiting(),e.clientsClaim(),e.precacheAndRoute([{url:"/js/app.js",revision:"60f22182ffbc7b7b1eb7f3e5a11414a8"},{url:"/js/app.js.LICENSE.txt",revision:"3873bf309aba658c6c3f88e010102e94"},{url:"css/app.css",revision:"442e4269e4f504bbbfafff7040ecfbb7"}],{}),e.cleanupOutdatedCaches()}));
