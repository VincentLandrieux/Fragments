(()=>{var R=5,k=document.querySelector(".header_nav_order_nb_text"),g=document.querySelector(".order-menu"),_=g.querySelector(".order-menu_container"),O=document.querySelector(".header_nav_order"),b=document.querySelector(".order-menu_close"),L=document.querySelector(".products_grid"),a=[{id:1,title:"Titre 1",price:200,stock:3,img_url:"/images/icon.svg"},{id:2,title:"Titre 2",price:99.99,stock:2,img_url:"/images/icon.svg"},{id:3,title:"Titre 3",price:99.99,stock:5,img_url:"/images/icon.svg"}],d=[];function h(){let e=0;return d.forEach(t=>{e+=t.amount}),e}function m(){k.innerText=h()}function v(e){if(d.length>0)if(h()<R){let t=d.findIndex(n=>n.id===e);if(t>=0){let n=a.findIndex(r=>r.id===e);d[t].amount<a[n].stock?(d[t].amount++,m(),u()):T(`Pas assez d'article en stock (${a[n].stock} en stock)`)}else d.push({id:e,amount:1}),m(),u()}else T("Il y a trop d'articles dans votre panier (5 max)");else d.push({id:e,amount:1}),m(),u()}function D(e){let t=d.findIndex(n=>n.id===e);t>=0&&(d[t].amount>1?(d[t].amount--,m(),u()):f(e))}function f(e){let t=d.findIndex(n=>n.id===e);d.splice(t,1),m(),u()}function T(e){let t=i("div","alert"),n=i("div","alert_message");n.innerHTML=e,t.appendChild(n);let r=setTimeout(()=>{t.remove()},2e3);t.addEventListener("click",o=>{o.stopPropagation(),clearTimeout(r),t.remove()}),document.body.appendChild(t)}function i(e,...t){let n=document.createElement(e);return t.forEach(r=>{n.classList.add(r)}),n}function u(){if(_.innerHTML="",d.length>0)d.forEach((e,t)=>{let n=i("div","order-menu_item"),r=i("div","order-menu_item_del-btn");r.addEventListener("click",()=>{f(e.id)}),n.appendChild(r);let o=a.find(x=>x.id===e.id),s=i("p","order-menu_item_title");s.innerText=o.title,n.appendChild(s);let c=i("div","order-menu_item_nb"),l=i("div","order-menu_item_minus-btn");l.addEventListener("click",()=>{D(e.id)}),c.appendChild(l);let p=i("p","order-menu_item_nb_text");p.innerText=`x${e.amount}`,c.appendChild(p);let E=i("div","order-menu_item_plus-btn");E.addEventListener("click",()=>{v(e.id)}),c.appendChild(E),n.appendChild(c),_.appendChild(n)});else{let e=i("div","order-menu_item"),t=i("p","order-menu_item_title");t.innerText="Aucun article",e.appendChild(t),_.appendChild(e)}}function C(){g.classList.toggle("closed")}function S(){a.forEach(e=>{let t=i("div","products_grid_item"),n=i("div","products_grid_item_img");n.setAttribute("style",`--img-url: url(${e.img_url})`);let r=i("div","products_grid_item_content_add");r.addEventListener("click",()=>{v(e.id)}),n.appendChild(r),t.appendChild(n);let o=i("div","products_grid_item_content"),s=i("p","products_grid_item_content_title");s.innerText=e.title,o.appendChild(s);let c=i("p","products_grid_item_content_price");c.innerText=`${e.price} \u20AC`,o.appendChild(c);let l=i("p","products_grid_item_content_stock");l.innerText=`(${e.stock} en stock)`,o.appendChild(l),t.appendChild(o),L.appendChild(t)})}O.addEventListener("click",()=>{C()});b.addEventListener("click",()=>{C()});S();})();
//# sourceMappingURL=script.js.map
