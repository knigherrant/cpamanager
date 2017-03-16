<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class CPAManagerViewInvoice extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
		}
        
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
       
		$canDo		= CPAManagerHelper::getActions();

       
            JToolBarHelper::title(JText::_('Invoice'), 'file');
        

		// If not checked out, can save the item.
		if (($canDo->get('core.edit')||($canDo->get('core.create'))))
		{

			JToolBarHelper::apply('invoice.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('invoice.save', 'JTOOLBAR_SAVE');
		}
		
		if (empty($this->item->id)) {
			JToolBarHelper::cancel('invoice.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('invoice.cancel', 'JTOOLBAR_CLOSE');
		}

	}
}