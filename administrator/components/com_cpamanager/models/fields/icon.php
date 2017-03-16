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

class JFormFieldIcon extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'icon';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
        JHtml::_('behavior.modal');
        jimport('joomla.filesystem.folder');
        $icons = array();
        if($files = JFolder::files(JPATH_SITE.'/administrator/components/com_cpamanager/assets/images/file-icons/')) foreach($files as $file){
            $icons[] = array('path'=>'administrator/components/com_cpamanager/assets/images/file-icons/'.$file, 'name'=> $file);
        }
        ob_start();
        ?>
        <div class="btn-group dropdown-grid">
            <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
                <img id="<?php echo $this->id;?>-preview" src="<?php echo jSont::getIcon($this->value, $this->form->getField('icon_custom')->value)?>" style="height:32px;width:32px; padding: 2px">
                <span class="caret" style="margin-top: 18px;"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <ul>
                        <?php if($icons) foreach($icons as $icon){?>
                            <li class="icon">
                                <a href="javascript:void(0)" title="<?php echo basename($icon['name'], ".png");?>" data-value="<?php echo $icon['name'];?>" data-src="<?php echo JUri::root().$icon['path'];?>">
                                    <img src="<?php echo JUri::root().$icon['path'];?>">
                                </a>
                            </li>
                        <?php }?>
                    </ul>
                </li>
                <li class="spacer"></li>
                <li class="divider"></li>
                <li><a class="modal modal-button" rel="{'handler': 'iframe', 'size': {'x': 690}}" href="index.php?option=com_cpamanager&view=files&layout=select&tmpl=component&ctn=icons&ctn_type=image&field=<?php echo $this->id;?>"><?php echo JText::_('Custom')?></a></li>
            </ul>
            <input name="<?php echo $this->name;?>" id="<?php echo $this->id;?>" value="<?php echo $this->value;?>" type="hidden">
        </div>
        <?php
        return ob_get_clean();
	}
}