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

JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('bootstrap.tooltip');

$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>

<script type="text/javascript">
    Joomla.orderTable = function()
    {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>')
        {
            dirn = 'asc';
        }
        else
        {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');
    }
</script>
<?php echo JST::header(); ?>
<?php echo JST::toolbar('invoice', true); ?>
    <form action="<?php echo JRoute::_('index.php?option=com_cpamanager&view=invoices'); ?>" method="post" name="adminForm" id="adminForm">
         <div class="jsContents form-horizontal row-fluid jscustom12">  
            <div id="j-main-container">
               <legend><?php echo JText::_('Invoices');?></legend>
                <?php JST::tabsMenu(); ?>
                <div id="filter-bar" class="btn-toolbar">
                    <div class="filter-search btn-group pull-left">
                        <label for="filter_search" class="element-invisible"><?php echo JText::_('JSEARCH_FILTER');?></label>
                        <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER'); ?>" />
                    </div>
                    <div class="btn-group pull-left">
                        <button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
                        <button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
                    </div>
                    <div class="btn-group pull-right hidden-phone">
                        <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
                        <?php echo $this->pagination->getLimitBox(); ?>
                    </div>
                    <div class="btn-group pull-right hidden-phone">
                        <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
                        <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
                            <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
                            <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
                            <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
                        </select>
                    </div>
                    
                </div>
                <div class="clearfix"> </div>
                <table class="table table-striped" id="invoiceList">
                    <thead>
                    <tr>
                        <th width="1%" class="hidden-phone">
                            <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                        </th>
                        <th width="1%" class="nowrap center">
                            <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
                        </th>
                        <th class='left'>
                            <?php echo JHtml::_('grid.sort',  'Company', 'a.company', $listDirn, $listOrder); ?>
                        </th>
                        <th class='left'>
                            <?php echo JHtml::_('grid.sort',  'Title', 'a.title', $listDirn, $listOrder); ?>
                        </th>
                        <th class='left'>
                            <?php echo JHtml::_('grid.sort',  'CPA', 'cpa', $listDirn, $listOrder); ?>
                        </th>
                       
                        <th class='left'>
                            <?php echo JHtml::_('grid.sort',  'Date', 'a.created', $listDirn, $listOrder); ?>
                        </th>
                        <th width="1%" class="nowrap center hidden-phone">
                            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                        </th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td colspan="10">
                            <?php echo $this->pagination->getListFooter(); ?>
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($this->items as $i => $item) :
                        $ordering   = ($listOrder == 'a.ordering');
                        $canCreate	= $user->authorise('core.create',		'com_cpamanager');
                        $canEdit	= $user->authorise('core.edit',			'com_cpamanager');
                        $canCheckin	= $user->authorise('core.manage',		'com_cpamanager');
                        $canChange	= $user->authorise('core.edit.state',	'com_cpamanager');
                        ?>
                        <tr class="row<?php echo $i % 2; ?>">
                            <td class="center hidden-phone">
                                <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                            </td>
                            <td class="center">
                                <?php echo JHtml::_('jgrid.published', $item->state, $i, 'invoices.', $canChange, 'cb'); ?>
                            </td>
                            <td>
                                <?php if (isset($item->checked_out) && $item->checked_out) : ?>
                                    <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'invoices.', $canCheckin); ?>
                                <?php endif; ?>
                                <?php if ($canEdit) : ?>
                                    <div style="float: left; margin-right: 5px">
                                        <img src="<?php echo jSont::getIcon($item->icon, $item->icon_custom);?>" alt="" style="height: 35px"/>
                                    </div>
                                    <div>
                                        <a href="<?php echo JRoute::_('index.php?option=com_cpamanager&task=invoice.edit&id='.(int) $item->id); ?>">
                                            <?php echo $this->escape($item->company); ?></a>
                                        <br/>
                                        <small>
                                            <?php
                                            if($item->storage_type == 'file'){
                                                if(is_file(JPATH_SITE.'/'.jSont::getDirPath('files').'/'.$item->storage_path_file))
                                                    echo '<a href="index.php?option=com_cpamanager&task=invoice.download&id='.$item->id.'">'.$item->storage_path_file.'</a> - '.jSont::formatFileSize($item->filesize);
                                                else echo JText::_('COM_CPAMANAGE_MSG_FILE_NOT_FOUND');
                                            }else echo $item->storage_path_remote;
                                            ?>
                                        </small>
                                    </div>
                                <?php else : ?>
                                    <?php echo $this->escape($item->company); ?>
                                    <br/>
                                    <small>
                                        <?php
                                        if($item->storage_type == 'file'){
                                            if(is_file(JPATH_SITE.'/'.jSont::getDirPath('files').'/'.$item->storage_path_file)) echo $item->storage_path_file;
                                            else echo JText::_('COM_CPAMANAGE_MSG_FILE_NOT_FOUND');
                                        }else echo $item->storage_path_remote;
                                        ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $item->title;?></td>
                            <td><?php echo $item->cpa ; ?></td>
                            <td><?php echo jSont::format($item->created); ?></td>
                            <td class="center hidden-phone"><?php echo (int) $item->id; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <input type="hidden" name="task" value="" />
                <input type="hidden" name="boxchecked" value="0" />
                <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
                <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
                <?php echo JHtml::_('form.token'); ?>
            </div>
         </div>
    </form>
<?php echo JST::footer(); ?>