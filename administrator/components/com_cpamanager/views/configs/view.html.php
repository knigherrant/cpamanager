<?php
/**
 * @version     16.5.5
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
class CPAManagerViewConfigs extends JViewLegacy
{
	protected $items;

	/**
	 * Display the view
	 */
	public function display($tpl = null){
		$this->item		= $this->get('Item');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
                $this->form = $this->get('Form');
                //CPAManagerHelper::addSubmenu('configs');

		$this->addToolbar();
        
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
    protected function addToolbar(){
        $canDo		= CPAManagerHelper::getActions();
       
        JToolBarHelper::title(JText::_('Configs'), 'file');

        // If not checked out, can save the item.
        if (($canDo->get('core.create'))){
            JToolBarHelper::apply('configs.apply', 'JTOOLBAR_APPLY');
        }
    }
}
