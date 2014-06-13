<?php
define("TimeOfWarsTPL_DISPLAY_MAIN",  "TimeOfWarsTPL_MAIN");

class TimeOfWarsTPLDisplay {

private $_TimeOfWarsTPL;
private $_name;
private $_caching          = false;
private $_caching_lifetime = 3600;
private $_caching_id       = null;
private $_options          = array();
private $_templates        = array();
private $_vars             = array();



function __construct(&$aTimeOfWarsTPL, $aName)
{
	$this->_name          = $aName;
}



function _TimeOfWarsTPLDisplay(){}



function addTemplate($aTemplateName, $aTemplateFile, $aTemplatePath = null)
{
	{
	}

	if (isset($this->_templates[$aTemplateName]))
	{
		return false;
	}
	elseif (!file_exists($aTemplatePath . $aTemplateFile))
	{
		return false;
	}
	else
	{

		if (!isset($this->_vars[$aTemplateName]))
		{
		}

		return true;
	}
}



function setCache($aId, $aTime = 3600)
{
	$this->_caching_lifetime = $aTime;
	$this->setCacheId($aId);

	if ($this->_caching)
	{
		{
			{
			}
		}
		else
		{
			{
			}
		}
	}

return true;
}



function setCacheId($aId)
{
	{
	}
	else
	{
	}

	return true;
}


function isCached()
{
	{
	}

	$aFileName = $this->_getCacheFile();

	if (!file_exists($aFileName))
	{
	}
	else
	{
		{
		}
		else
		{
		}
	}
}



function _createCache($aContent = '')
{

	@unlink($aFileName);

	$fp = fopen($aFileName, "at") or die(trigger_error('TimeOfWarsTPL Error: Cannot create file "'. $aFileName . '"', E_USER_ERROR));
	flock ($fp, LOCK_EX);
	rewind($fp);
	fwrite($fp, $aContent);
	flock ($fp, LOCK_UN);
	fclose($fp);
}



function _getCacheFile()
{
	$this->_name . DIRECTORY_SEPARATOR .
	md5($this->_name . '#' . $this->_caching_id) . '.html';
}



function assign($aName, $aValue, $aTemplate = TimeOfWarsTPL_DISPLAY_MAIN)
{
}


function clear($aName, $aTemplate = TimeOfWarsTPL_DISPLAY_MAIN)
{
	{
	}
}


function clearAll($aName)
{
}



function display($aTemplate = null)
{
}



function fetch($aTemplate = null, $aDisplay = false)
{

	if ($this->_TimeOfWarsTPL->_options['debug'])
	{
	}
	else
	{
	}

	if ($this->_caching && $this->isCached())
	{
		{
		}

		include_once($this->_getCacheFile());

		if (!$aDisplay)
		{
			ob_end_clean();
		}
	}
	elseif ($this->_caching && !$this->isCached())
	{
		$this->_fetch($aTemplate);
		$cache = ob_get_contents();
		ob_end_clean();

		$this->_createCache($cache);

		if (!$aDisplay)
		{
		}
		else
		{
		}
	}
	elseif (!$this->_caching)
	{
		{
		}

		$this->_fetch($aTemplate);

		if (!$aDisplay)
		{
			ob_end_clean();
		}
	}

	error_reporting($oldErrorReporting);

}



function _fetch($aTemplate = null)
{
	{
		{
			return false;
		}

		$this->_display($aTemplate);
	}
	else
	{
		{
			return false;
		}

		foreach ($this->_templates as $aTemplateName => $aTemplateFile)
		{
		}
	}
}



function _display($aTemplate)
{
	{
	}

	if (sizeof($this->_vars[TimeOfWarsTPL_DISPLAY_MAIN]) > 0)
	{
	}

	if (sizeof($this->_vars[$aTemplate]) > 0)
	{
	}

	include_once($this->_templates[$aTemplate]);

	if (sizeof($this->_vars[TimeOfWarsTPL_DISPLAY_MAIN]) > 0)
	foreach ($this->_vars[TimeOfWarsTPL_DISPLAY_MAIN] as $aKey => $aValue)
	{
	}

	if (sizeof($this->_vars[$aTemplate]) > 0)
	foreach ($this->_vars[$aTemplate] as $aKey => $aValue)
	{
	}
}



function __destruct(){}


}
?>