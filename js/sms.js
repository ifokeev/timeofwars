var mine = '<input type="text" name="username[]" size="42" maxlength="20" />&nbsp;<input type="button" name="drp" value=" x " onclick="drop(this.parentNode.parentNode.rowIndex);" /><input type="button" value=" + " onclick="add();" />';
function drop(i)
{
   document.getElementById('myTable').deleteRow(i)
   checkForLast()
}
function add()
{
   var x = document.getElementById('myTable').insertRow(0);
   var y = x.insertCell(0)
   y.innerHTML = mine
   checkForLast()
}
function checkForLast()
{
   btns = document.getElementsByName('drp');
   for (i = 0; i < btns.length; i++){
      btns[i].disabled = (btns.length == 1) ? true : false;
   }
}