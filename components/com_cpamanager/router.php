<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_CPAManager
 * @author     Joomlavi <info@joomlavi.com>
 * @copyright  2016 Joomlavi
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

require_once JPATH_SITE.'/components/com_cpamanager/helpers/cpamanager.php';

/**
 * Route builder
 *
 * @param   array &$query A named array
 *
 * @return    array
 */
function CPAManagerBuildRoute(&$query)
{
	$segments = array();
	$view     = null;

	
	if (isset($query['view'])) {
		$segments[] = $query['view'];
		unset($query['view']);
	}

	if (isset($query['layout'])) {
		$segments[] = $query['layout'];
		unset($query['layout']);
	}
	
	
	if (isset($query['id'])) {
		$segments[] = $query['id'];
		unset($query['id']);
	}

	return $segments;
}

/**
 * Converts URL segments into query variables.
 *
 * @param   array  $segments  A named array
 *
 * Formats:
 *
 * index.php?/cpamanager/task/id/Itemid
 *
 * index.php?/cpamanager/id/Itemid
 *
 * @return array
 */
function CPAManagerParseRoute($segments)
{
	$vars = array();


	// View is always the first element of the array
	$vars['view'] = array_shift($segments);
	
	while (!empty($segments))
	{
		$segment = array_pop($segments);

		// If it's the ID, let's put on the request
		if (is_numeric($segment))
		{
			$vars['id'] = $segment;
		}
		else
		{
			$vars['layout'] = $segment;
		}
	}

	return $vars;
}
