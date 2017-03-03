<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select', null, array('disable_search_threshold' => 0 ));
$item = $this->item;
$itemid = JFactory::getApplication()->input->getInt('Itemid');
?>
<script type="text/javascript">
            Joomla.submitbutton = function(task)
            {
                if (task == 'warrior.cancel') {
                    Joomla.submitform(task, document.getElementById('warrior-form'));
                }
                else{
                    
                    if (task != 'warrior.cancel' && document.formvalidator.isValid(document.id('warrior-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('warrior-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>

<div id="CPAManagerContent">
    <div id="warrior-view" class="bodyContents">
        <h3><?php echo $item->title; ?></h3>
        <p>Category : <?php echo $item->category; ?></p>
        <div><?php echo $item->description; ?></div>
        <p>Document Link: <?php echo $item->link; ?></p>
        <p>Audio Link: <?php echo $item->audio; ?></p>
        
        <p>Comment</p>
        <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="warrior-form" class="form-validate">
            <div class="form-horizontal row-fluid">
                 <div><input name="title" placeholder="<?php echo JText::_('Title');?>" type="text" /></div>
                <div><textarea placeholder="<?php echo JText::_('Comment');?>" name="comment"></textarea></div>
            </div>
            
            <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('warrior.saveComment')">
                            <span class="icon-ok"></span><?php echo JText::_('JSAVE') ?>
                    </button>
            </div>
            
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="Itemid" value="<?php echo $itemid; ?>" />
            <input type="hidden" name="item_id" value="<?php echo $item->id; ?>" />
            <input type="hidden" name="option" value="com_cpamanager" />
            <?php echo JHtml::_('form.token'); ?>
            <div class="clr"></div>
        </form>
        
        <div class="listComments">
            <?php $lists = jSont::getComments($item->id, 'warrior'); ?>
            <?php if($lists){ ?>
                <h5 class="titleComment"><?php echo JText::_('Comments Submited'); ?></h5>
                <ul>
                <?php foreach ($lists as $l){ ?>
                    <li>
                        <p class="cTitle"><?php echo $l->title; ?></p>
                        <p class="author"><span class="uName"><?php echo $l->name; ?></span><span class="dateS"><?php echo jSont::format($l->created); ?></span></p>
                        <div class="cContent"><?php echo $l->comment; ?></div>
                    </li>
                <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>
<?php echo jSont::footer(); ?>



