<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_CPAManager
 * @author     Joomlavi <info@joomlavi.com>
 * @copyright  2016 Joomlavi
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;
// Include dependancies
jimport('joomla.application.component.controller');
$view = JFactory::getApplication()->input->getString('view');
$task = JFactory::getApplication()->input->getString('task');
if(JFactory::getUser()->guest && $view != 'register' && $task != 'register.save'){
    JFactory::getApplication()->redirect(JRoute::_('index.php?option=com_users&view=login&return='.base64_encode(JURI::getInstance()), false), JText::_('Please login first'), 'notice');
}
//JLoader::registerPrefix('CPAManager', JPATH_COMPONENT);
require_once JPATH_COMPONENT.'/helpers/cpamanager.php';
// Execute the task.

$controller = JControllerLegacy::getInstance('CPAManager');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

$dispatcher = JDispatcher::getInstance(); 
$dispatcher->register('onBeforeCompileHead','triggerScriptjQuery'); 
function triggerScriptjQuery(){ 
    JSont::loadFrontEndCss();
} 



