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
 * View class for a list of CPAManager.
 */
class CPAManagerViewInvoices extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
		
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		$state	= $this->get('State');
		$canDo	= CPAManagerHelper::getActions($state->get('filter.category_id'));

       
		    JToolBarHelper::title(JText::_('Invoices'), 'file');
        
            //Check if the form exists before showing the add/edit buttons
            $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/invoice';
            if (file_exists($formPath)) {
                if ($canDo->get('core.create')) {
                                JToolBarHelper::addNew('invoice.add','JTOOLBAR_NEW');
                        }
                        if ($canDo->get('core.edit') && isset($this->items[0])) {
                                JToolBarHelper::editList('invoice.edit','JTOOLBAR_EDIT');
                        }
            }

            if ($canDo->get('core.edit.state')) {
                if (isset($this->items[0]->state)) {
                                JToolBarHelper::divider();
                                JToolBarHelper::custom('invoices.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
                                JToolBarHelper::custom('invoices.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
                }
                if (isset($this->items[0])) {
                    JToolBarHelper::deleteList('', 'invoices.delete','JTOOLBAR_DELETE');
                }
 
            }

          /*
            JHtmlSidebar::addFilter(
                JText::_('JOPTION_SELECT_PUBLISHED'),
                'filter_published',
                JHtml::_('select.options', CPAManagerHelper::getPublishedOptions(), "value", "text", $this->state->get('filter.state'), true)
            );

            if(CPAManagerHelper::isUseCat()) JHtmlSidebar::addFilter(
                JText::_('JOPTION_SELECT_CATEGORY'),
                'filter_category',
                JHtml::_('select.options', CPAManagerHelper::getCategoryOptions(), "value", "text", $this->state->get('filter.category'), true)
            );

            JHtmlSidebar::addFilter(
                JText::sprintf('COM_CPAMANAGER_FILTER_SELECT_LABEL', JText::_('COM_CPAMANAGER_OWNER')),
                'filter_owner',
                JHtml::_('select.options', CPAManagerHelper::getUserOptions(), "value", "text", $this->state->get('filter.owner'), true)
            );
            */
	}
    
	protected function getSortFields()
	{
		$field =  array(
            'a.state' => JText::_('JSTATUS'),
            'a.title' => JText::_('Title'),
            'a.compnay' => JText::_('Compnay'),
            'a.created' => JText::_('Created'),
            'a.id' => JText::_('JGRID_HEADING_ID'),
            );
            
            return $field;
	}

    
}
