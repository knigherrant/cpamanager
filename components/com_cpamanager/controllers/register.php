<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com /su{s>Src93%
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Register controller class.
 */
class CPAManagerControllerRegister extends JControllerForm
{

    function __construct() {
        $this->view_list = 'frontend';
        parent::__construct();
    }
    
    function save($key = null, $urlVar = null) {
        $app   = JFactory::getApplication();
       
        $model = $this->getModel();
        $table = $model->getTable();
        $data  = $this->input->post->get('jform', array(), 'array');
        $save = $model->save($data);
        if($save) $this->setRedirect(JRoute::_('index.php?option=com_cpamanager&view=frontend'), JText::_('Register successfull, please login to use app'));
        else $this->setRedirect(JRoute::_('index.php?option=com_cpamanager&view=register'), JText::_('Register error, Please try agian to use app') ,'error');
    }
    
  
}