<?php
define('TimeOfWarsTPL_DISPLAY_ERROR_TEMPLATE_DEFINED',       201);
define('TimeOfWarsTPL_DISPLAY_ERROR_TEMPLATE_NOT_DEFINED',   202);
define('TimeOfWarsTPL_DISPLAY_ERROR_TEMPLATE_NOT_EXIST',     203);

include_once('TimeOfWarsTPLDisplay.class.php');

class TimeOfWarsTPL {

public  $_options  = array();
public  $_vars     = array();

private $_displays = array();
private $_errors;


function __construct($aOptions){
$this->_options = $aOptions;
}

function _TimeOfWarsTPL(){}



function setError($aError, $aMessage = "")
{
}


function isError()
{
	{
	}
	else
	{
	}
}


function &getDisplay($aName, $aSeparate = false)
{
	{
		return $TimeOfWarsTPLDisplay;
	}
	else
	{
		{
		}
		else
		{
			return $this->_displays[$aName];
		}
	}
}



function assignGlobal($aName, $aValue)
{
}



function clearGlobal($aName)
{
	{
	}
}



function clearAllGlobal($aName)
{
}



function display($aDisplay = null)
{
	{
		{
		}
		else
		{
		}
	}
	else
	{
		{
		}
	}
}


function __destruct(){}


}
?>