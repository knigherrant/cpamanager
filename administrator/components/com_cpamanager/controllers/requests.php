<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Requests list controller class.
 */
class CPAManagerControllerRequests extends JControllerAdmin
{
    
    public function __construct($config = array()) {
		parent::__construct($config);
		$this->registerTask('unfeatured', 'featured');
                $this->registerTask('unmain', 'main');
	}
	 public function featured()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
                $this->input = JFactory::getApplication()->input;
		$user   = JFactory::getUser();
		$ids    = $this->input->get('cid', array(), 'array');
		$values = array('featured' => 1, 'unfeatured' => 0);
		$task   = $this->getTask();
		$value  = JArrayHelper::getValue($values, $task, 0, 'int');
		if (empty($ids))
		{
			JError::raiseWarning(500, JText::_('JERROR_NO_ITEMS_SELECTED'));
		}
		else
		{
			$db = JFactory::getDbo();
                        if(!$db->setQuery("UPDATE #__cpamanager_requests SET `featured` ='$value' WHERE id IN (" . implode(',', $ids) . ")")->execute()){
                            JError::raiseWarning(500, $model->getError());
                        }
			if ($value == 1)
			{
				$message = JText::_(count($ids) . ' Item Featured');
			}
			else
			{
				$message = JText::_(count($ids) . ' Item Unfeatured');
			}
		}
                $this->setRedirect(JRoute::_('index.php?option=com_cpamanager&view=requests', false), $message);
		
	}
        public function main()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
                $this->input = JFactory::getApplication()->input;
		$user   = JFactory::getUser();
		$ids    = $this->input->get('cid', array(), 'array');
		$values = array('main' => 1, 'unmain' => 0);
		$task   = $this->getTask();
		$value  = JArrayHelper::getValue($values, $task, 0, 'int');
		if (empty($ids))
		{
			JError::raiseWarning(500, JText::_('JERROR_NO_ITEMS_SELECTED'));
		}
		else
		{
			$db = JFactory::getDbo();
                        if(!$db->setQuery("UPDATE #__cpamanager_requests SET `main` ='$value' WHERE id IN (" . implode(',', $ids) . ")")->execute()){
                            JError::raiseWarning(500, $model->getError());
                        }
			if ($value == 1)
			{
				$message = JText::_(count($ids) . ' Item Main');
			}
			else
			{
				$message = JText::_(count($ids) . ' Item UnMain');
			}
		}
                $this->setRedirect(JRoute::_('index.php?option=com_cpamanager&view=requests', false), $message);
		
	}
    
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'request', $prefix = 'CPAManagerModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
    
	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
    
    
    
}