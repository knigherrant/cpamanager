<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldPrayerRequest extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'prayerrequest';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		// Initialize variables.
		$html = array();
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                $query->select('a.*,u.name');
                $query->from('#__cpamanager_requests as a');
                $query->join('LEFT', '#__users as u ON u.id=a.userid');
                $lists = $db->setQuery($query)->loadObjectList();
                $options = array();
                foreach ($lists as $l){
                    $options[] = JHTML::_('select.option',$l->userid, $l->name . ' (' . $l->prayer_request . ')');
                }
		return JHTML::_('select.genericlist', $options, $this->name, 'class="inputbox"', 'value', 'text', $this->value);
	}
}