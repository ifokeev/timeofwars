function usegovor(unid,enemy) {
	if ((unid != null) && (unid != '')) {
		var target = prompt('Что крикнем ?', '');
		if ((target != null) && (target != '')) {
			window.location.href='battle.php'+'?use='+unid+'&target='+target+'&enemy='+enemy+'';
		}
	}
}
function usefire(unid,enemy) {
	if ((unid != null) && (unid != '')) {
		var target = prompt('В кого кидаем ?', '');
		if ((target != null) && (target != '')) {
			window.location.href='battle.php'+'?use='+unid+'&target='+target+'&enemy='+enemy+'';
		}
	}
}
function usepodch(unid,enemy) {
	if ((unid != null) && (unid != '')) {
		var target = prompt('На кого кастуем?', '');
		if ((target != null) && (target != '')) {
			window.location.href='battle.php'+'?use='+unid+'&target='+target+'&enemy='+enemy+'';
		}
	}
}


function useMagicItem( magicName, magicItem ){
	
	if( magicName=='' || magicItem=='' ){
		
		return false;
	}

    var targetName;
    var params ='';

    // 'HEAL','HP_RESTORE','BATTLE','WAR_DAMAGE','BATTLE_JOIN'
	switch( magicName ){
		case 'HEAL':
            targetName = getTargetName( "Лечение травмы." );
            if( targetName === false){
                return;
            }else if( targetName != "" ){
                params = 'uname=' + targetName;
            }
        break;

        case 'HP_RESTORE':
            targetName = getTargetName( "Востанавливаем HP." );
            if( targetName === false){
                return;
            }else if( targetName != "" ){
                params = 'uname=' + targetName;
            }
        break;

        case 'BATTLE':
            targetName = getTargetName( "Нападаем." );
            if( targetName === false){
                return;
            }
            params = 'uname=' + targetName;
        break;

        case 'BATTLE_JOIN':
            targetName = getTargetName( "Вмешиваемся в бой на защиту." );
            if( targetName === false || targetName == "" ){
                return;
            }
            params = 'uname=' + targetName;
        break;

        case 'WAR_DAMAGE':
            targetName = getTargetName( "Аттакуем." );
            if( targetName === false || targetName == "" ){
                return;
            }
            params = 'uname=' + targetName;
        break;

        default:
            return;
        break;
    }

    callCastMagic( magicItem, params );

    return true;
}


function getTargetName( promTitle ){
	if( promTitle == '' ){
        promTitle = promTitle + " Введите имя персонажа:";
    }

    var targetName = prompt( promTitle, "" );

	//alert( '' + targetName + ' ' + typeof(targetName) );

    if( targetName == null ){
        targetName = false;
    }

    return targetName;
}

function callCastMagic( id_item, params ){
	
	var addStr = ( params != '' )? ('&' + params) : '' ;

	window.location.href='/magic.php?action=cast&id_item='+ id_item +''+ addStr;
	// 'use='+unid+'&target='+target+'&enemy='+enemy+'';
}
