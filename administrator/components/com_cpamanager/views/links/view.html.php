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
class CPAManagerViewLinks extends JViewLegacy
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
        
		//CPAManagerHelper::addSubmenu('links');
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

            JToolBarHelper::title(JText::_('Links'), 'link');

        //JToolBarHelper::custom('links.export', 'export.png', 'export.png', 'Export', false);
        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/link';
        if (file_exists($formPath)) {
            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('link.add','JTOOLBAR_NEW');
		    }
		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('link.edit','JTOOLBAR_EDIT');
		    }
        }

		if ($canDo->get('core.edit.state')) {
            if (isset($this->items[0]->state)) {
                            
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('links.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('links.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            }
            if (isset($this->items[0])) {
                JToolBarHelper::deleteList('', 'links.delete','JTOOLBAR_DELETE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('links.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}


       
        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_cpamanager');
        }
	}
    
	protected function getSortFields()
	{
		return array(
            'a.state' => JText::_('JSTATUS'),
            'a.title' => JText::_('COM_METIKACCMGR_TITLE'),
            'access_title' => JText::_('COM_METIKACCMGR_ACCESS'),
            'cat_title' => JText::_('COM_METIKACCMGR_CATEGORY'),
            'created_by_name' => JText::_('COM_METIKACCMGR_OWNER'),
            'a.created' => JText::_('COM_METIKACCMGR_CREATED'),
            'a.id' => JText::_('JGRID_HEADING_ID'),
        );
	}

    
}
