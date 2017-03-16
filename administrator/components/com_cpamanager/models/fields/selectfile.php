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

class JFormFieldSelectFile extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'selectfile';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
        JHtml::_('behavior.modal');
        ob_start();
        ?>
        <div class="input-append">
            <input name="<?php echo $this->name;?>" id="<?php echo $this->id?>" value="<?php echo $this->value?>" type="text" readonly="true">
            <input type="hidden" id="<?php echo $this->id?>-type" value="<?php if($this->value){ $fileType = jSont::getFileType($this->value); echo $fileType['type'];}?>"/>
            <input type="hidden" id="<?php echo $this->id?>-extension" value="<?php if($this->value){ $fileType = jSont::getFileType($this->value); echo $fileType['extension'];}?>"/>
            <a class="modal btn" rel="{'handler': 'iframe', 'size': {'x': 690}}" href="index.php?option=com_cpamanager&view=files&layout=select&tmpl=component&ctn=files&ctn_type=file&field=<?php echo $this->id;?>"><?php echo JText::_('Select');?></a>
        </div>
        <?php
        return ob_get_clean();
	}
}