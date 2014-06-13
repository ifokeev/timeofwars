/*


*/

var timeout = null;
var objToUpdate = null;
var feedBackType = null;
var sendParams = null;

function printUserNames( res ){
	
	if( res == null || res == '' ){
		return;
	}
	
	out = '';
	helper = document.getElementById('divHelper');
	len = res.length;
	
	if( len < 1 ){
		return;
	}
	
	for( i=0; i<len; i++ ){
		
		out += "<a href=\"#\" onClick=\"insertUsername('"+res[i]+"');\">"+res[i]+"</a><br>";
	}
	
	helper.innerHTML = out;
	
	showHelper();
}

function showHelper(){
	
	helper = document.getElementById('divHelper');
	
	helper.style.left	= getValue( objToUpdate, "offsetLeft" ) + "px";
	
	helper.style.top	= getValue( objToUpdate,"offsetTop") + objToUpdate.offsetHeight - 1 + "px";
//	helper.style.width	= Ta() + "px";
	
	helper.style.backgroundColor = "white";
	helper.style.visibility = 'visible';
}

function hideHelper(){
	
	helper = document.getElementById('divHelper');
	helper.style.visibility = 'hidden';
}
/////////////////////////////
function getValue( obj, attribName ){
	var i = 0;
	while( obj ){
		i += obj[attribName];
		obj=obj.offsetParent;
	}
	return i;
}
//function Ta( ){
//	if( navigator && navigator.userAgent.toLowerCase().indexOf("msie")==-1 ){
//		
//		return a.offsetWidth-ea*2;
//		
//	}else{
//		
//		return a.offsetWidth;
//	}
//}
/////////////////////////////




function insertUsername( newValue ){
	
	objToUpdate.value = newValue;
	
	helper = document.getElementById('divHelper');
	helper.innerHTML = '';
	helper.style.visibility = 'hidden';
}

// Вызывается по тайм-ауту или при щелчке на кнопке.
function doLoad(force) {

	var req = new JSHttpRequest();	// Создаем новый объект JSHttpRequest.
	

	// Код, АВТОМАТИЧЕСКИ вызываемый при окончании загрузки. Записываем в <div> результат работы.
	req.onreadystatechange = function( ){

		if( req.readyState == 4 ){
			
//			alert(req.responseJS.out );
			
			if( feedBackType == 'findUsers' ){
				
				if( req.responseJS.out == null ){
					return;
				}
				
				printUserNames( req.responseJS.out );
			}
		}
	}

	req.caching = true; // Разрешаем кэширование (чтобы при одинаковых запросах  не обращаться к серверу несколько раз).
	
	req.open('GET', '/adm/load.php', true); // Подготваливаем объект.
	
	req.send({
		callFunc: feedBackType,
		attribs: sendParams
	}); // Посылаем данные запроса (задаются в виде хэша).
	
	sendParams = null;
	
}
// Поддержка загрузки данных по тайм-ауту (1 секунда после
// последнего отпускания клавиши в текстовом поле).

function findUsers( e ){
	
	if(!e) e = window.event;
	
	var eventObj = getEventCreatorObject(e);
	
	if( eventObj.value == '' ) return;
	
	sendParams = eventObj.value;
	
	feedBackType = 'findUsers';
	
	doLoadUp( eventObj );
}


function getEventCreatorObject( e ){
	
	if( window.event ) geco = window.event.srcElement;
	else if(e.currentTarget) geco = e.currentTarget;
	else geco = new Object();
	
	return geco;
}


function doLoadUp( eventObj ){
	
	objToUpdate = eventObj;
	
	if( timeout ) clearTimeout(timeout);
	
	timeout = setTimeout(doLoad, 1000);
	
}



// End of loader
////////////////////////////////////////////////////////////////////////////////////////////////////////////