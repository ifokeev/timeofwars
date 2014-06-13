	var tipoffsetX=20;
	var tipoffsetY=10;
	function tipmove(id, ev)
	{
		if(!ev) ev = window.event;
		document.getElementById(id).style.visibility="visible";

		document.getElementById(id).style.left=ev.clientX + document.body.scrollLeft + tipoffsetX + 'px';
		document.getElementById(id).style.top=ev.clientY + document.body.scrollTop + tipoffsetY + 'px';
	};

    function hidetip(id)
    {
		document.getElementById(id).style.visibility = 'hidden';
	};