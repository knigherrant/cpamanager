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
 * Event controller class.
 */
class CPAManagerControllerEvent extends JControllerForm
{

    function __construct() {
        $this->view_list = 'events';
        parent::__construct();
    }
    
    function saveComment(){
        $model = $this->getModel();
        $input = JFactory::getApplication()->input;
        $result = $model->addComment();
        if($result) $msg = JText::_('Add Comment Success');
        else $msg = JText::_('Add Comment Error');
        $this->setRedirect(JRoute::_('index.php?option=com_cpamanager&view=event&layout=view&id='.$input->getInt('item_id').'&Itemid='.$input->getInt('Itemid')), $msg);
        return;
    }
    
  
}