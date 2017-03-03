<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomlavi <info@joomlavi.com> - http://www.joomlavi.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 */
class CPAManagerViewFrontend extends JViewLegacy
{
	protected $state;
    protected $item;
    protected $form;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		 $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
                    throw new Exception(implode("\n", $errors));
		}
                //CPAManagerHelper::addAsset();
                //CPAManagerHelper::addPathWay();
		parent::display($tpl);
	}
}
