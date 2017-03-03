<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomlavi <info@joomlavi.com> - http://www.joomlavi.com
 */

defined('_JEXEC') or die;
$items = $this->items;
$itemid = JFactory::getApplication()->input->getInt('Itemid');
JHtml::_('behavior.modal', 'a.modal');

?>
<div id="CPAManagerContent">
    <div id="links-content">
        <?php echo jSont::showProfileHtml(); ?>
        <div class='links'>
            <legend><?php echo JText::_('Links'); ?></legend>
            <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&view=links&Itemid='.$itemid); ?>" method="post" name="adminForm" id="adminForm">
                <div id="j-main-container">
                    <div id="filter-bar" class="btn-toolbar">
                            <div class="filter-search btn-group pull-left">
                                    <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('Search'); ?>" />
                            </div>
                            <div class="btn-group pull-left">
                                    <button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><span class="icon-search"></span></button>
                                    <button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><span class="icon-remove"></span></button>
                            </div>
                    </div>
                    <div class="clr clear clearfix"> </div>
                    <div class="listLinks">
                        <?php foreach ($this->items as $item){ ?>
                            <div class="item-link lineButtom">
								<h4><?php echo $item->title; ?></h4>
                                <p class="lInfo">
                                    <?php if($item->image){ ?>
                                        <span class="lImage"><a class="modal" href="<?php echo  $item->image; ?>"  rel="{handler: 'iframe', size: {x:600, y:600}}"><?php echo 'Image'; ?></a></span>
                                    <?php } ?>
                                    <?php if($item->link){ ?>
                                        <span class="lLink"><a target="_blank" href="<?php echo $item->link; ?>"><?php echo 'Link'; ?></a></span>
                                    <?php } ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                    
                </div>
                <div>
                    <input type="hidden" name="task" value="" />
                    <input type="hidden" name="boxchecked" value="0" />
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php echo jSont::footer(); ?>