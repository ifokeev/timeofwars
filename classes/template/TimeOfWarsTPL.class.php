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
{	$this->_errors[$aError] = $aMessage;
}


function isError()
{	if (sizeof($this->_errors) > 0)
	{		return true;
	}
	else
	{		return false;
	}
}


function &getDisplay($aName, $aSeparate = false)
{	if ($aSeparate)
	{		$TimeOfWarsTPLDisplay =& new TimeOfWarsTPLDisplay(&$this, $aName);
		return $TimeOfWarsTPLDisplay;
	}
	else
	{		if (isset($this->_displays[$aName]))
		{			return $this->_displays[$aName];
		}
		else
		{			$this->_displays[$aName] =& new TimeOfWarsTPLDisplay(&$this, $aName);
			return $this->_displays[$aName];
		}
	}
}



function assignGlobal($aName, $aValue)
{	$this->_vars[$aName] = & $aValue;
}



function clearGlobal($aName)
{	if (isset($this->_vars[$aName]))
	{		unset($this->_vars[$aName]);
	}
}



function clearAllGlobal($aName)
{	$this->_vars = array();
}



function display($aDisplay = null)
{	if ($aDisplay)
	{		if (isset($this->_displays[$aDisplay]))
		{			$this->_displays[$aDisplay]->display;
		}
		else
		{			return false;
		}
	}
	else
	{		foreach ($this->_displays as $aDisplayName => $aDisplayObject)
		{			$aDisplayObject -> display();
		}
	}
}


function __destruct(){}


}
?>