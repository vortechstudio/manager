import{c as i}from"./core-js-cc17fa8d.js";var e={exports:{}};(function(){var r,t,o,p,s,a;typeof performance<"u"&&performance!==null&&performance.now?e.exports=function(){return performance.now()}:typeof process<"u"&&process!==null&&process.hrtime?(e.exports=function(){return(r()-s)/1e6},t=process.hrtime,r=function(){var n;return n=t(),n[0]*1e9+n[1]},p=r(),a=process.uptime()*1e9,s=p-a):Date.now?(e.exports=function(){return Date.now()-o},o=Date.now()):(e.exports=function(){return new Date().getTime()-o},o=new Date().getTime())}).call(i);var m=e.exports;export{m as p};
