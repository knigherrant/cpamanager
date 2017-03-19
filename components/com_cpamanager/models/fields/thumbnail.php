<?php
/**
 * @version     1.5.8
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores | design@dmdagency.com | http://www.dmdagency.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldThumbnail extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Thumbnail';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
        JHtml::_('behavior.modal');
        $format = false;
        $remote = false;
        $general = false;
        if(!$this->value){
            if($this->form->getField('storage_type')->value == 'remote'){
                $remote = true;
            }else{
                if($this->form->getField('storage_path_file')->value){
                    $fileType = jSont::getFileType($this->form->getField('storage_path_file')->value);
                    if($fileType['type'] == 'image'){
                        $general = true;
                    }else{
                        $format = true;
                    }
                }else{
                    $format = true;
                }
            }
            $image = JUri::root().'administrator/components/com_cpamanager/assets/images/nothumbnail.png';
        }else{
            $image = JUri::root().  jSont::getDirPath('thumbs').'/'.$this->value;
        }
        ob_start();
        ?>
        <div class="image-picker thumbnail-picker" style="margin-top: 5px">
            <img id="<?php echo $this->id?>-preview" data-src="default.png" src="<?php echo $image;?>" style="max-height:128px; max-width:128px; background:#EEE; margin:0">
            <div id="choose-thumbnail" class="dropdown btn-group" style="float:left;margin-left:5px">
                <button class="btn choose-photo-button dropdown-toggle" id="profile_header_upload" type="button" data-toggle="dropdown" style="float:none">
                    <?php echo JText::_('Change Thumb')?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li id="thumbnail-choose-existing" class="dropdown-link">
                        <div id="image-selector" class="image-selector">
                            <input name="<?php echo $this->name;?>" id="<?php echo $this->id;?>" value="<?php echo $this->value;?>" type="text">
                            <a class="modal modal-button btn" rel="{'handler': 'iframe', 'size': {'x': 690}}" href="index.php?option=com_cpamanager&view=files&layout=select&tmpl=component&ctn=thumbs&ctn_type=image&field=<?php echo $this->id;?>"><?php echo JText::_('Choose Thumb')?></a>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li id="thumbnail-delete-image" class="pretty-link dropdown-link">
                        <a href="javascript:void(0)" class="dropdown-link btn" id="image-selector-clear"><?php echo JText::_('Clear')?></a>
                    </li>
                </ul>
                <p class="help-inline automatic-enabled" style="<?php if(!$general) echo 'display:none';?>"><?php echo JText::_('COM_SIGNATUREDOC_THUMBNAIL_AUTO_GENERATED')?></p>
                <p class="help-inline automatic-unsupported-format" style="<?php if(!$format) echo 'display:none';?>"><?php echo JText::_('COM_SIGNATUREDOC_AUTO_GENERATED_THUMBNAIL_ONLY_SUPPORT_IMAGE')?></p>
                <p class="help-inline automatic-unsupported-location"  style="<?php if(!$remote) echo 'display:none';?>"><?php echo JText::_('COM_SIGNATUREDOC_AUTO_GENERATED_THUMBNAIL_ONLY_SUPPORT_LOCAL')?></p>
            </div>
        </div>
        <?php
        return ob_get_clean();
	}
}