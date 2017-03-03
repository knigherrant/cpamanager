<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_cpamanager')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}
require_once JPATH_COMPONENT . '/helpers/cpamanager.php';
// Include dependancies
jSont::loadAdminCss();
jimport('joomla.application.component.controller');
$controller	= JControllerLegacy::getInstance('CPAManager');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();