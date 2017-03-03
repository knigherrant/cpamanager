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
?>
<div id="CPAManagerContent">
    <div id="requests-content">
        <?php echo jSont::showProfileHtml(); ?>
        <div class='requests bodyContents'>
            <legend><?php echo JText::_('Pray For'); ?></legend>
            <p class="addnew bntTopRight"><a class="btn btn-xs" href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=request&layout=edit&Itemid='.$itemid); ?>"><?php echo JText::_('Prayer Request'); ?></a></p>
            <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&view=requests&Itemid='.$itemid); ?>" method="post" name="adminForm" id="adminForm">
                <div id="j-main-container">
                    <div id="filter-bar" class="btn-toolbar">
                            <div class="filter-search btn-group pull-left">
                                    <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('Search'); ?>" />
                            </div>
                            <div class="filter-search btn-group pull-left">
                                <?php echo JHTML::_('select.genericlist', jSont::getOptionCategory('categories_prayer'),'category', 'class="inputbox" ', 'value', 'text'); ?>
                            </div>
                            
                            <div class="btn-group pull-left">
                                    <button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><span class="icon-search"></span></button>
                                    <button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><span class="icon-remove"></span></button>
                            </div>
                    </div>
                    <div class="clr clear clearfix"> </div>

                    <div class="listPrayfor">
                        <?php foreach ($this->items as $i => $item) : ?>
                           <div class="item">
                               <div class="avatar">
                                   <div class="small-avatar"><img src="<?php echo jSont::getAvatar($item->avatar); ?>" alt="avatar"/></div>
                               </div>
                               <div class="info">
                                    <div class="head">
                                        <span class="user"><?php echo $item->name; ?></span>
                                        <span class="subject"><?php echo $item->prayer_request; ?></span>
                                        <span class="category"><?php echo $item->category; ?></span>
                                    </div>
                                    <div class="prayInfo">
                                        <?php echo $item->prayer_description; ?>
                                    </div>
                                    <div class="more">
                                        <span class="prayfor">
                                            <a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=warrior&layout=edit&id='.$item->id.'&Itemid=' . $itemid); ?>" class="btn btn-xs">
                                                    Pray For
                                            </a>
                                        </span>
                                        <span class="readmore">
                                            <a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=request&layout=view&id='.$item->id.'&Itemid=' . $itemid); ?>" class="btn btn-xs">
                                                    Read More
                                            </a>
                                        </span>
                                    </div>
                               </div>
                               <div class="clear clearfix clr"></div>
                           </div>
                        <?php endforeach; ?>
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