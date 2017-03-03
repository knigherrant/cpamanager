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
JHTML::_('script','system/multiselect.js',false,true);

$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>
<?php echo jSont::menuSiderbar(); ?>
<div class="cpamanager">
    <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&view=links'); ?>" method="post" name="adminForm" id="adminForm">
        <?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
    <?php else : ?>
        <div id="j-main-container">
    <?php endif;?>
        <div id="filter-bar" class="btn-toolbar">
                <div class="filter-search btn-group pull-left">
                        <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('Search'); ?>" />
                </div>
                <div class="btn-group pull-left">
                        <button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>"><span class="icon-search"></span></button>
                        <button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.getElementById('filter_search').value='';this.form.submit();"><span class="icon-remove"></span></button>
                </div>
     
                <div class="btn-group pull-right hidden-phone">
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true);?>
			</select>
		</div>
        </div>
        <div class="clr"> </div>

    <table class="table table-striped">
            <thead>
            <tr>
                <th width="1%" class="hidden-phone">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
                </th>
                <th width="5%">
                    <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
                </th>
                <th class='left'>
                    <?php echo JHtml::_('grid.sort',  'Title', 'a.title', $listDirn, $listOrder); ?>
                </th>
    
                <th class='left'>
                    <?php echo JHtml::_('grid.sort',  'URL', 'a.link', $listDirn, $listOrder); ?>
                </th>

                <th width="1%" class="nowrap center hidden-phone">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
              

            </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="11">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
              </tr>
            </tfoot>
            <tbody>
            <?php foreach ($this->items as $i => $item) :
                $ordering	= ($listOrder == 'a.ordering');
                $canCreate	= $user->authorise('core.create',		'com_jvsocial_publish');
                $canEdit	= $user->authorise('core.edit',			'com_jvsocial_publish');
                $canCheckin	= $user->authorise('core.manage',		'com_jvsocial_publish');
                $canChange	= $user->authorise('core.edit.state',	'com_jvsocial_publish');
                ?>
                <tr class="row<?php echo $i % 2; ?>">
                    <td class="center" data-field="  <?php echo JText::_('Select');?>"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
                    <td class="center" data-field="<?php echo JText::_('JPUBLISHED');?>">
                        <?php echo JHtml::_('jgrid.published', $item->state, $i, 'links.', $canChange, 'cb'); ?>
                    </td>
                    <td data-field="<?php echo JText::_('Title');?>">
                        <?php
                       
                        if ($canEdit) : ?>
                           
                            <div>
                                <a href="<?php echo JRoute::_('index.php?option=com_cpamanager&task=link.edit&id='.(int) $item->id); ?>">
                                    <?php echo $this->escape($item->title); ?></a>
                            </div>
                        <?php else : ?>
                            <?php echo $this->escape($item->title); ?>
                        <?php endif; ?>
                    </td>
                    
                    <td data-field="<?php echo JText::_('URL');?>">
                        
                        <a target="_blank" href="<?php echo $item->link; ?>" ><?php echo $item->link; ?></a>
                        
                    </td>
                   
                    <td class="center" data-field="<?php echo JText::_('JGRID_HEADING_ID');?>"><?php echo (int) $item->id; ?></td>
                    
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
</div>