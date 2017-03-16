<?php
/**
 * @version     1.0.0
 * @package     com_metikaccmgr
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomlavi <info@joomlavi.com> - http://www.joomlavi.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Metikaccmgr.
 */
class CPAManagerViewFiles extends JViewLegacy
{
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
	
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
		jSont::addMedia();
		parent::display($tpl);
	}
}
