var Fields = new Array('login', 'password', 'password2', 'email', 'u_name', 'sex');
for (i = 0; i < Fields.length; i++) {
	eval ("var "+Fields[i]+"=0;");
}

function validate () {
	ok = 1;
	for (i = 0; i < Fields.length; i++) {
		tmp = document.all[Fields[i]+"_i"].src;
		tmp2 = tmp.split('markfalse');
		if (tmp2.length == 2) {
			ok=0
		}
	}
	if (!document.reg.law.checked) ok=0;
	if (ok) {return true} else {return false};
}

function check_correct(name, check_length){
    var freg=document.reg;
	var value = freg[name].value;
	var name2='';
	if (name == 'day' || name == 'month' || name == 'year') {name2=name; name='d_ro'}
	document.all[name+"_err"].innerHTML = "";
	if (name!='city') document.all[name+"_i"].src='i/markfalse.gif';
	if (!value) return ;
	var err_text = '';
	if (name == 'login' && value != 's!.') {
		if ( value.match(/[^А-Яа-яЁёa-zA-Z0-9_ ]/) ) {
			err_text = "<b>Имя персонажа</b> содержит запрещенные<br /> символы. <br />Разрешены рус. или англ.<br /> буквы обоих регистров, цифры, символы:<br /> пробел, _ \n";
		} else {
			if ((value.length < 3 || value.length > 12)) {
			if (check_length==1)
				err_text += "Длина <b>Имени персонажа</b> должна быть<br /> от 3-х до 12-и символов<br>\n";
			else err_text+= " ";
			}
			if (value.match(/[a-zA-Z]/) && value.match(/[А-Яа-яЁё]/)) {
				err_text += "<b>Имя персонажа</b> должно<br />состоять из букв одного алфавита<br>\n";
			}
			if (value.match(/(.)\1\1/)) {
				err_text += "<b>Имя персонажа</b> не может содержать 3 одинаковых символа подряд<br>\n";
			}
			if (value.match(/^(\s|_|!|~|-|\.|@)|(\s|_|!|~|-|\.|@)$/)) {
				err_text += "<b>Имя персонажа</b> не может содержать<br /> по краям символы: пробел, _, !, ~, -, .,@<br>\n";
			}
			if (value.match(/^[0-9]+$/)){
				err_text += "<b>Имя персонажа</b> не может состоять только из цифр!<br>";}
		}
	}
	if (name == 'password') {
		err_text = '';
		if (value.match(/^[А-Яа-яЁёa-zA-Z0-9]+$/)) {
			if (value.match(/(.)\1\1/)) {
				err_text += "Пароль не может содержать 3<br /> одинаковых символа подряд<br>\n";
			}
			if ((value.length < 6 || value.length > 25))
				if (check_length==1) err_text += "Длина пароля должна быть от 6 до<br /> 25 символов<br>\n"; else err_text += " ";

		} else {
			err_text = 'Пароль содержит запрещенный символ.<br /> Разрешены русские и английские<br /> буквы обоих регистров и цифры<br>';
		}
	}
	if (name == 'password2') {
		if (freg.password.value != value && freg.password.value) {
			err_text = 'Пароль и копия пароля не совпадают';
		}
	}
	if (name == 'email') {
		if (!value.match(/^[_\.0-9a-zA-Z-]{1,}@[_\.0-9a-zA-Z-]{1,}\.[_\.0-9a-zA-Z-]{2,}$/)) {
			if (check_length==1) err_text = "Введите, пожалуйста,<br /> корректный почтовый адрес<br>\n";  else err_text = " ";
		}
		if ((value.length < 8 || value.length > 40)) {
			if (check_length==1) err_text = "Длина почтового адреса должна быть от<br /> 8 до 40 знаков<br>\n"; else err_text = " ";
		}
	}
	if (name == 'u_name') {
		if (value.match(/[^А-Яа-яЁёa-zA-Z]/)) {
			err_text = "<b>Реальное имя</b> содержит запрещенные<br /> символы. Разрешены рус. или англ.<br /> буквы обоих регистров.<br>\n";
		} else {
			if ((value.length < 2 || value.length > 15)) {
			if (check_length==1)
				err_text += "Длина <b>Реального имя</b> должна быть от 2 до 15 символов<br>\n";
			else err_text+= " ";
			}
			if (value.match(/[a-zA-Z]/) && value.match(/[А-Яа-яЁё]/)) {
				err_text += "<b>Реальное имя</b> должно состоять из букв одного алфавита<br>\n";
			}
			if (value.match(/(.)\1\1/)) {
				err_text += "<b>Реальное имя</b> не может содержать 3<br /> одинаковых символа подряд<br>\n";
			}
		}
	}
	if (name == 'sex') {
		if (value != '1' && value != '2') {
			err_text = "Выберите ваш пол";
		}
	}

	if (name2 == 'day' || name2 == 'month' || name2 == 'year') {
		value2 = freg['day'].value;
	   	value3 = freg['month'].value;
	   	value4 = freg['year'].value;

	   if (value2 == '0' || value3 == '0' || value4 == '0') err_text=" ";

		if ((value < 1 || value > 31) && name2 == 'day')
	   		err_text = "Выберите День рождения<br>";
	   	if ((value < 1 || value > 12) && name2 == 'month')
	   		err_text = "Выберите Месяц рождения<br>";
	   	if ((value < 1950 || value > 2000) && name2 == 'year')
	   		err_text = "Выберите Год рождения<br>";
	}

	if (err_text)
		document.all[name+"_err"].innerHTML = "<font color=#dd3333>"+err_text+"</font>";
	if (name!='city')
		document.all[name+"_i"].src='i/mark'+((err_text)?'false':'ok')+'.gif';
}

function genpass() {
  var r1 = new RegExp("[a-z]");
  var r2 = new RegExp("[A-Z]");
  var r3 = new RegExp("[0-9]");
  var symbols = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  var slen = symbols.length;
  var f=0;
  while (f==0) {
    var pass='';
    var len=6+Math.floor(Math.random()*8);
    for (var i=0;i<len;i++) {
      pass += symbols.substr((Math.floor(Math.random()*slen)-1),1);
    }
    var s=3;
    if (pass.match(r1)) { s--;}
    if (pass.match(r2)) { s--;}
    if (pass.match(r3)) { s--;}
    if (s==0) { f=1; }
  }
  if (prompt ('Установить пароль?', pass)) {
    document.reg.password.value=pass;
    document.reg.password2.value=pass;
    document.all.password_i.src='i/markok.gif';
    document.all.password2_i.src='i/markok.gif';
    document.all.password_err.innerHTML = '';
    document.all.password2_err.innerHTML = '';

  }
}
