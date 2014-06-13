<!-- //
user = '';
toBuy = new Array();
Count = new Array();
bSumm = new Array();
function buy(item, price){
var tb = false;
for(i=0;i<toBuy.length;i++){
if(toBuy[i]==item){
tb = true;
break;
}}
if(!tb){
toBuy[toBuy.length] = item;
Count[Count.length] = 1;}
else{
Count[i]++;
}
if(!bSumm[item] && bSumm[item]!=0){
bSumm[item]=0;
document.getElementById("selected_items").innerHTML += "<table id=\"m"+item+"\"><col><col><col><col width=\"1%\"> <tr> <td width=35%><a href=\"#\" onClick=\"return false;\">"+document.getElementById(item).getAttribute("info")+"</a></td> <td width=30%>&nbsp;"+price+" кр.</td> <td id='s"+item+"' width=30%>"+bSumm[item]+" шт</td> <td width=30%><a style=\"cursor:pointer;\" onclick=\"unBuy('"+item+"', '"+price+"')\" title=\"Удалить товар из списка\"><img src=\"http://tow.msk.su/img/images/delit.jpg\" border=\"0\"></a></td> </tr></table>";
}
bSumm[item]++;
document.getElementById("selected_items").style.display = "";
document.getElementById("s"+item).innerHTML = document.getElementById(item)+bSumm[item];
document.getElementById("m"+item).style.display="";
}

function unBuy(item, price){
bSumm[item]--;
if(bSumm[item]==0){
document.getElementById("m"+item).style.display = "none";
 }else{
document.getElementById("s"+item).innerHTML = document.getElementById(item)+bSumm[item];
}
for(i=0;i<toBuy.length;i++){
if(toBuy[i]==item){
Count[i]--;
break;
}}}


function doBuy(){
if(Count.length>0){
for(i=0;i<toBuy.length;i++){
child = document.createElement("input");
child.type = "hidden";
child.name = "buyItem"+toBuy[i];
child.value = "buyItem_"+toBuy[i]+"_"+Count[i];
document.forms.dobuy.appendChild(child);
}
if(document.getElementById("user").value !=  ""){
document.forms.dobuy.submit();
}else{
alert("Введите имя адресата");
}
}else{
alert("Корзина пуста - нечего оплачивать :)");
}}

// -->