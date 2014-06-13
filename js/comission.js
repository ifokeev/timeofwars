function sell(unid) {
if ((unid != null) && (unid != '')) {
var price = prompt('За сколько хотите продать ?', '');
if ((price != null) && (price != '')) {
window.location.href='?sale_thing='+unid+'&price='+price+'';
}}}

function smenit(unid) {
if ((unid != null) && (unid != '')) {
var price = prompt('На какую цену хотите изменить ? (Смена цены предмета - 1 кр.)  ', '');
if ((price != null) && (price != '')) {
window.location.href='?smenit_thing='+unid+'&price='+price+'';
}}}