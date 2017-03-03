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
                if (task == 'bible.cancel') {
                    Joomla.submitform(task, document.getElementById('bible-form'));
                }
                else{
                    
                    if (task != 'bible.cancel' && document.formvalidator.isValid(document.id('bible-form'))) {
                        
                        Joomla.submitform(task, document.getElementById('bible-form'));
                    }
                    else {
                        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
                    }
                }
            }

</script>
<?php echo jSont::menuSiderbar(); ?>
<div id="CPAManagerContent">
    <div id="bible-view">
        <h3><?php echo $item->title; ?></h3>
        <p>Category : <?php echo $item->category; ?></p>
        <div><?php echo $item->description; ?></div>
        <p>Document Link: <?php echo jSont::playAudio($item->link); ?></p>
        <p>Audio Link: <?php echo $item->audio; ?></p>
       
        <div class="listComments">
            <?php $lists = jSont::getComments($item->id, 'bible'); ?>
            <?php if($lists){ ?>
                <h5 class="titleComment"><?php echo JText::_('Comments Submited'); ?></h5>
                <ul>
                <?php foreach ($lists as $l){ ?>
                    <li class="lineButtom">
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




