"use strict";window.addEventListener("load",(e=>{let t,o,l,n,i,r,d,c,u,s,a,y=!1,g=!1,p=0,m=ongridlayout.width,v=ongridlayout.color,h=ongridlayout.zindex,E=ongridlayout.gap,x=4;c="0"===h?-1:0;let f=`<div id="grid-layout-ui-buttons"><div class="grid-layout-ui-column">\n  <div id="grid-layout-ui-box-1"class="grid-layout-ui-box">\n  <input id="ogl-ui-color" style="background-color: ${v}" type="color" value="${v}">\n  </div><div class="grid-layout-ui-long">\n  <input id="ogl-input-width" onfocus="this.value=''" type="number" value="${m}"/>\n  </div></div><div class="grid-layout-ui-column"><div class="grid-layout-ui-box">\n  <select id="ogl-input-z"><option value="${c}">${c}</option>\n  <option value="${h}">${h}</option></select></div><div class="grid-layout-ui-box">\n  <input id="ogl-layout-gap" onfocus="this.value=''" type="number" value="${E}">\n  </div><div id="gridOK" class="grid-layout-ui-box" onclick="$scope.setGridLayout()">${x}\n  </div></div></div>`;document.querySelector(".oxygen-toolbar-panels").insertAdjacentHTML("beforeend",f),y||(t=document.getElementById("ct-artificial-viewport"),o=t.contentWindow||t.contentDocument,l=o.document.querySelectorAll(".ogl_column"),n=o.document.getElementsByClassName("ogl_grid")[0],document.querySelector("#ogl-ui-color").addEventListener("change",(function(){v=this.value,document.getElementById("ogl-ui-color").style.setProperty("background-color",v),l.forEach((e=>{e.style.setProperty("background-color",v)}))})),document.querySelector("#ogl-input-z").addEventListener("change",(function(){d=this.value,r=o.document.getElementsByClassName("ogl_container")[0],r.style.setProperty("z-index",d)})),document.querySelector("#ogl-layout-gap").addEventListener("change",(function(){E=this.value,u=`0 ${E/2}px`,s=`0 -${E/2}px`,n.style.setProperty("margin",s),l.forEach((e=>{e.style.setProperty("margin",u)}))})),document.querySelector("#ogl-input-width").addEventListener("change",(function(){m=this.value,"100"===m||"1"===m?(m="100%",a=`calc(${m} + ${E}px)`):a=`calc(${m}px + ${E}px)`,n.style.setProperty("width",a)}))),$scope.setGridLayout=()=>{E=document.getElementById("ogl-layout-gap").value,u=`0 ${E/2}px`,s=`0 -${E/2}px`,v=document.getElementById("ogl-ui-color").value,d=document.getElementById("ogl-input-z").value,m=document.getElementById("ogl-input-width").value,"100"===m||"1"===m?(m="100%",a=`calc(${m} + ${E}px)`):a=`calc(${m}px + ${E}px)`,function(){t=document.getElementById("ct-artificial-viewport"),o=t.contentWindow||t.contentDocument;let e=o.document.getElementById("ct-builder"),c=document.createElement("div");if(y){if(y){const e=o.document.getElementsByClassName("ogl_container");for(;e.length>0;)e[0].remove();y=!1,p=0,x=4,document.getElementById("gridOK").textContent=x}}else if(g||(c.className="ogl_container",e.appendChild(c),r=o.document.getElementsByClassName("ogl_container")[0],r.style.setProperty("display","flex"),r.style.setProperty("justify-content","center"),r.style.setProperty("width","100%"),r.style.setProperty("position","fixed"),r.style.setProperty("height","100vh"),r.style.setProperty("pointer-events","none"),r.style.setProperty("z-index",d),r.style.setProperty("top","0"),i=o.document.querySelector(".ogl_container"),c=document.createElement("div"),c.className="ogl_grid",i.appendChild(c),n=o.document.getElementsByClassName("ogl_grid")[0],n.style.setProperty("display","flex"),n.style.setProperty("justify-content","space-between"),n.style.setProperty("width",a),n.style.setProperty("margin",s),g=!0),g){for(var m=0;m<4;m++){let e=o.document.querySelector(".ogl_grid");c=document.createElement("div"),c.className="ogl_column",e.appendChild(c),x+=1,2===p&&(x=0),document.getElementById("gridOK").textContent=x}l=o.document.querySelectorAll(".ogl_column"),l.forEach((e=>{e.style.setProperty("width","100%"),e.style.setProperty("background-color",v),e.style.setProperty("opacity","35%"),e.style.setProperty("margin",u),e.style.setProperty("hight","100vh")})),2===p&&(y=!0,g=!1),p++}}()}}));