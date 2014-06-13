//<!--
function usesvitok1(unid){
	if ((unid != null) && (unid != '')) {
		var battleid = prompt('В какой бой вмешиваемся (ID) ?', '');
		if ((battleid != null) && (battleid != '')) {
			var side = prompt('За какую команду пойдем (1 или 2)?', '');
			if ((side != null) && (side != '')) {
				window.location.href=''+'?use='+unid+'&battleid='+battleid+'&side='+side+'&part=2';
			}
		}
	}
}

function usesvitok2(unid){
	if ((unid != null) && (unid != '')) {
		var target = prompt('На кого нападаем ?', '');
		if ((target != null) && (target != '')) {
			window.location.href=''+'?use='+unid+'&target='+target+'&part=2';
		}
	}
}

function uselech(unid){
	if ((unid != null) && (unid != '')) {
		var target = prompt('Кого лечим ?', '');
		if ((target != null) && (target != '')) {
			window.location.href=''+'?use='+unid+'&target='+target+'&part=2';
		}
	}
}

function usestats(unid){
	if ((unid != null) && (unid != '')) {
		var target = prompt('Кому сбрасываем ?', '');
		if ((target != null) && (target != '')) {
			window.location.href=''+'?use='+unid+'&target='+target+'&part=2';
		}
	}
}

function usestats2(unid){
	if ((unid != null) && (unid != '')) {
		window.location.href=''+'?use='+unid+'&part=2';
	}
}
function give(unid){
	if ((unid != null) && (unid != '')) {
		var battleid = prompt('Кому передать? (стоимость 0,5 кр)', '');
		if ((battleid != null) && (battleid != '')) {
			var surtext = prompt('Поясните основание передачи', '');
			if(surtext == "" || surtext != null){
			window.location.href=''+'?give='+unid+'&whom='+battleid+'&surtext='+surtext+'&part=1';
    }
    }
	}
}


function givetravu(unid){
	if ((unid != null) && (unid != '')) {
		var battleid = prompt('Кому передать? (стоимость 0,5 кр)', '');
		if ((battleid != null) && (battleid != '')) {
			var surtext = prompt('Кол-во передаваемого?', '');
			if(surtext != "0" && surtext != null && surtext != ""){
			window.location.href=''+'?givetravu='+unid+'&whom='+battleid+'&surtext='+surtext+'&part=3';
    }
    }
	}
}
//-->