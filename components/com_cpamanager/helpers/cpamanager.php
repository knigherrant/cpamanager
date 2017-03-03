<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_CPAManager
 * @author     Joomlavi <info@joomlavi.com>
 * @copyright  2016 Joomlavi
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * Class frontend
 *
 * @since  1.6
 */

require_once JPATH_ADMINISTRATOR.'/components/com_cpamanager/helpers/cpamanager.php';
class frontend extends jSont{
    
    public static function menus($view=''){
        $input = JFactory::getApplication()->input;
        $Itemid = $input->getInt('Itemid', 0);
        if(!$view) $view = $input->getString('view', 'frontend');
        ?>
		<div id="CPAManagerMenu">
            <div class="jMenu-cpamanager">
                <ul class="jsont-menu">
                        <li class="frontend <?php if($view=='frontend') echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=frontend&Itemid='.$Itemid); ?>" >Frontend</a></li>
                        <li class="bibles <?php if($view=='bibles') echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=bibles&Itemid='.$Itemid); ?>" >Bibles Study</a></li>
                        <li class="requests <?php if($view=='requests') echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=requests&Itemid='.$Itemid); ?>" >Prayer Request</a></li>
                        <li class="warriors <?php if($view=='warriors') echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=warriors&Itemid='.$Itemid); ?>" >Prayer Warrior</a></li>
                        <li class="links <?php if($view=='links') echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=links&Itemid='.$Itemid); ?>" >Links</a></li>
                        <li class="events <?php if($view=='events') echo 'active';?>"><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=events&Itemid='.$Itemid); ?>" >Events Calendar</a></li>
                </ul>
            </div>
		</div>
        <?php
    }
    
    public static function toolbar($task){
        ?>
        <div class="btn-toolbar">
            <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('<?php echo $task;?>.save')">
                            <span class="icon-ok"></span><?php echo JText::_('JSAVE') ?>
                    </button>
            </div>
            <div class="btn-group">
                    <button type="button" class="btn" onclick="Joomla.submitbutton('<?php echo $task;?>.cancel')">
                            <span class="icon-cancel"></span><?php echo JText::_('JCANCEL') ?>
                    </button>
            </div>
        </div>
        <?php
    }
    
        
}