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
{	$this->_TimeOfWarsTPL =& $aTimeOfWarsTPL;
	$this->_name          = $aName;
}



function _TimeOfWarsTPLDisplay(){}



function addTemplate($aTemplateName, $aTemplateFile, $aTemplatePath = null)
{	if (!$aTemplatePath)
	{		$aTemplatePath = $this->_TimeOfWarsTPL->_options['template_path'] . DIRECTORY_SEPARATOR . $this->_name . DIRECTORY_SEPARATOR;
	}

	if (isset($this->_templates[$aTemplateName]))
	{		$this->_TimeOfWarsTPL->setError(TimeOfWarsTPL_DISPLAY_ERROR_TEMPLATE_DEFINED, $aTemplateName);
		return false;
	}
	elseif (!file_exists($aTemplatePath . $aTemplateFile))
	{		$this->_TimeOfWarsTPL->setError(TimeOfWarsTPL_DISPLAY_ERROR_TEMPLATE_DEFINED, $aTemplatePath . $aTemplateFile);
		return false;
	}
	else
	{		$this->_templates[$aTemplateName] = $aTemplatePath . $aTemplateFile;

		if (!isset($this->_vars[$aTemplateName]))
		{			$this->_vars[$aTemplateName] = array();
		}

		return true;
	}
}



function setCache($aId, $aTime = 3600)
{	$this->_caching          = true;
	$this->_caching_lifetime = $aTime;
	$this->setCacheId($aId);

	if ($this->_caching)
	{		if (is_dir($this->_TimeOfWarsTPL->_options['cache_path'] . DIRECTORY_SEPARATOR . $this->_name))
		{			if (!is_writable($this->_TimeOfWarsTPL->_options['cache_path'] . DIRECTORY_SEPARATOR . $this->_name))
			{				trigger_error('TimeOfWarsTPL Error: Cannot write directory "' . $this->_TimeOfWarsTPL->_options['cache_path'] . DIRECTORY_SEPARATOR . $this->_name . '"', E_USER_ERROR);
			}
		}
		else
		{			if (!@mkdir($this->_TimeOfWarsTPL->_options['cache_path'] . DIRECTORY_SEPARATOR . $this->_name))
			{				trigger_error('TimeOfWarsTPL Error: Cannot create directory "' . $this->_TimeOfWarsTPL->_options['cache_path'] . DIRECTORY_SEPARATOR . $this->_name . '"', E_USER_ERROR);
			}
		}
	}

return true;
}



function setCacheId($aId)
{	if (is_array($aId))
	{		$this->_caching_id = implode("::", $aId);
	}
	else
	{		$this->_caching_id = $aId;
	}

	return true;
}


function isCached()
{	if ($this->_caching_id === null)
	{		return false;
	}

	$aFileName = $this->_getCacheFile();

	if (!file_exists($aFileName))
	{		return false;
	}
	else
	{		if ((filemtime($aFileName) + $this->_caching_lifetime) < time())
		{			return false;
		}
		else
		{			return true;
		}
	}
}



function _createCache($aContent = '')
{	$aFileName = $this->_getCacheFile();

	@unlink($aFileName);

	$fp = fopen($aFileName, "at") or die(trigger_error('TimeOfWarsTPL Error: Cannot create file "'. $aFileName . '"', E_USER_ERROR));
	flock ($fp, LOCK_EX);
	rewind($fp);
	fwrite($fp, $aContent);
	flock ($fp, LOCK_UN);
	fclose($fp);
}



function _getCacheFile()
{	return $this->_TimeOfWarsTPL->_options['cache_path'] . DIRECTORY_SEPARATOR .
	$this->_name . DIRECTORY_SEPARATOR .
	md5($this->_name . '#' . $this->_caching_id) . '.html';
}



function assign($aName, $aValue, $aTemplate = TimeOfWarsTPL_DISPLAY_MAIN)
{	$this->_vars[$aTemplate][$aName] = & $aValue;
}


function clear($aName, $aTemplate = TimeOfWarsTPL_DISPLAY_MAIN)
{	if (isset($this->_vars[$aTemplate][$aName]))
	{		unset($this->_vars[$aTemplate][$aName]);
	}
}


function clearAll($aName)
{	$this->_vars = array();
}



function display($aTemplate = null)
{	$this->fetch($aTemplate, true);
}



function fetch($aTemplate = null, $aDisplay = false)
{	$oldErrorReporting = error_reporting();

	if ($this->_TimeOfWarsTPL->_options['debug'])
	{		error_reporting(E_ALL);
	}
	else
	{		error_reporting(E_ALL ^ E_NOTICE);
	}

	if ($this->_caching && $this->isCached())
	{		if (!$aDisplay)
		{			ob_start();
		}

		include_once($this->_getCacheFile());

		if (!$aDisplay)
		{			$cache = ob_get_contents();
			ob_end_clean();
		}
	}
	elseif ($this->_caching && !$this->isCached())
	{		ob_start();
		$this->_fetch($aTemplate);
		$cache = ob_get_contents();
		ob_end_clean();

		$this->_createCache($cache);

		if (!$aDisplay)
		{			return $cache;
		}
		else
		{			echo $cache;
		}
	}
	elseif (!$this->_caching)
	{		if (!$aDisplay)
		{			ob_start();
		}

		$this->_fetch($aTemplate);

		if (!$aDisplay)
		{			$cache = ob_get_contents();
			ob_end_clean();
		}
	}

	error_reporting($oldErrorReporting);

}



function _fetch($aTemplate = null)
{	if ($aTemplate)
	{		if (!isset($this->_templates[$aTemplate]))
		{			$this->_TimeOfWarsTPL->setError(TimeOfWarsTPL_DISPLAY_ERROR_TEMPLATE_NOT_DEFINED, $aTemplate);
			return false;
		}

		$this->_display($aTemplate);
	}
	else
	{		if (sizeof($this->_templates) == 0)
		{			$this->_TimeOfWarsTPL->setError(TimeOfWarsTPL_DISPLAY_ERROR_TEMPLATE_NOT_DEFINED, $aTemplate);
			return false;
		}

		foreach ($this->_templates as $aTemplateName => $aTemplateFile)
		{			$this->_display($aTemplateName);
		}
	}
}



function _display($aTemplate)
{	if (sizeof($this->_TimeOfWarsTPL->_vars) > 0)
	{		extract($this->_TimeOfWarsTPL->_vars);
	}

	if (sizeof($this->_vars[TimeOfWarsTPL_DISPLAY_MAIN]) > 0)
	{		extract($this->_vars[TimeOfWarsTPL_DISPLAY_MAIN]);
	}

	if (sizeof($this->_vars[$aTemplate]) > 0)
	{		extract($this->_vars[$aTemplate]);
	}

	include_once($this->_templates[$aTemplate]);

	if (sizeof($this->_vars[TimeOfWarsTPL_DISPLAY_MAIN]) > 0)
	foreach ($this->_vars[TimeOfWarsTPL_DISPLAY_MAIN] as $aKey => $aValue)
	{		unset ($$aKey);
	}

	if (sizeof($this->_vars[$aTemplate]) > 0)
	foreach ($this->_vars[$aTemplate] as $aKey => $aValue)
	{		unset ($$aKey);
	}
}



function __destruct(){}


}
?>