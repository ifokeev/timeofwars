function sell(unid) {
if ((unid != null) && (unid != '')) {
var price = prompt('�� ������� ������ ������� ?', '');
if ((price != null) && (price != '')) {
window.location.href='?sale_thing='+unid+'&price='+price+'';
}}}

function smenit(unid) {
if ((unid != null) && (unid != '')) {
var price = prompt('�� ����� ���� ������ �������� ? (����� ���� �������� - 1 ��.)  ', '');
if ((price != null) && (price != '')) {
window.location.href='?smenit_thing='+unid+'&price='+price+'';
}}}