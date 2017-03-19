<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldJKFile extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'jkfile';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
            $html = '';
            $html .= '<span>'.$this->description.'</span>  <input type="file" name="'.$this->name.'" id="'.$this->id.'">';
            if($this->value) {
                JHTML::_('behavior.modal'); 
                $image = JUri::root() . $this->value;
                $html .= '<span><a href="'.$image.'" class="modal" rel="{size: {x: 700, y: 300}}"><img width="40px" src="'.$image.'" alt="" /></a></span>';
            }
            return $html;
	}
}