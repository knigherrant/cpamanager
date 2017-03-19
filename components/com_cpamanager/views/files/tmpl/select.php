<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Joomlavi <info@joomlavi.com> - http://www.joomlavi.com
 */
// no direct access
defined('_JEXEC') or die;

//$configs = MetikaccmgrHelper::getConfigs();

$ctn = JFactory::getApplication()->input->get('ctn');
$ctn_type = JFactory::getApplication()->input->get('ctn_type');
$field = JFactory::getApplication()->input->get('field');
$prefix_url = 'index.php?option=com_cpamanager&ctn='.$ctn.'&ctn_type='.$ctn_type;
$all = array();
foreach (jSont::$file_ext as $eee)$all[] = implode( ',' ,$eee );


switch($ctn_type){
    case 'import': $allowed_extensions = 'csv'; break;
    case 'image': $allowed_extensions = implode(',',jSont::$file_ext['image']); break;
    default: $allowed_extensions = implode( ',' ,$all ); break;
}
?>
<div class="metikaccmgr">
    <div id="files-compact">
        <ul class="nav nav-tabs" id="files-tab">
            <li><a href="#insert-tab" data-toggle="tab"><?php echo JText::_('Insert');?></a></li>
            <li><a href="#upload-tab" data-toggle="tab"><?php echo JText::_('Upload');?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="insert-tab">
                <div id="files-tree-container">
                    <div id="files-tree" data-bind="template: { name: 'dirNoteTemplate', data: dirs }"></div>
					<?php /*if(JFactory::getApplication()->isAdmin()){ ?>
                    <div id="files-new-folder">
                        <div class="input-append">
                            <input type="text" placeholder="Enter a folder name" data-bind="value: newFolderName, valueUpdate: 'keyup'">
                            <button class="btn" data-bind="click: createFolder, attr:{disabled: !newFolderName()}"><?php echo JText::_('Create');?></button>
                        </div>
                    </div>
					<?php }*/ ?>
                </div>
                <div id="files-gird">
                    <div data-bind="visible: getFolderLoading" style="text-align: center; padding-top: 100px">
                        <img src="<?php echo JURI::root().'administrator/components/com_cpamanager/assets/images/loading.gif';?>" alt=""/>
                    </div>
                    <ul class="sidebar-nav" data-bind="foreach: folderSelected().files, visible: !getFolderLoading()">
                        <li class="files-node files-image" data-bind="css: {active: $root.fileSelected() == $data}" style="position: relative">
                            <a class="navigate" href="javascript:void(0)" data-bind="click: $root.getFile, text: $data.name, attr: {title: $data.name}"></a>
                            <span class="file-delete" title="<?php echo JText::_('Delete');?>" data-bind="click: $root.deleleFile"><i class="fa fa-times"></i></span>
                        </li>
                    </ul>
                </div>
                <div id="details">
                    <div data-bind="visible: getFileLoading" style="text-align: center; padding: 50px">
                        <img src="<?php echo JURI::root().'administrator/components/com_cpamanager/assets/images/loading.gif';?>" alt=""/>
                    </div>
                    <div id="files-preview" data-bind="if: fileSelected, visible: !getFileLoading()">
                        <div class="details" data-bind="if: fileDetail">
                            <div style="text-align: center">
                                <img class="preview" data-bind="attr: {alt: fileSelected().name, src:  fileDetail().type == 'image' ? fileDetail().url : fileDetail().icon}, css: {'preview-image': fileDetail().type == 'image', 'preview-icon': fileDetail().type != 'image'}">
                            </div>
                            <table class="table table-condensed parameters">
                                <tbody>
                                <tr>
                                    <td class="detail-label"><?php echo JText::_('Name');?></td>
                                    <td data-bind="text: fileSelected().name"></td>
                                </tr>
                                <tr data-bind="if: fileDetail().type == 'image'">
                                    <td class="detail-label"><?php echo JText::_('Dimensions');?></td>
                                    <td><span data-bind="text: fileDetail().width"></span> x <span data-bind="text: fileDetail().height"></span></td>
                                </tr>
                                <tr>
                                    <td class="detail-label"><?php echo JText::_('Size');?></td>
                                    <td data-bind="text: fileDetail().size"></td>
                                </tr>
                                <tr>
                                    <td class="detail-label"><i class="fa fa-download"></i></td>
                                    <td><a href="" data-bind="attr: {href: 'index.php?option=com_cpamanager&task=files.download&url='+fileDetail().url_encode}"><?php echo JText::_('Download');?></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div style="text-align: center" data-bind="visible: !getFileLoading()">
                        <button class="btn btn-primary" data-bind="attr: {disabled: !fileSelected()}, click: insertFile"><?php echo JText::_('Insert')?></button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="upload-tab">
                <div id="files-uploader" class="well well-small">
                    <div style="text-align: center"><h3><?php echo JText::_('Root');?><span data-bind="text: folderSelected().path() ? '/' + folderSelected().path() : folderSelected().path()"></span></h3></div>
                    <div id="files-uploader-controls">
                        <ul class="upload-buttons">
                            <li><?php echo JText::_('Upload Form');?></li>
                            <li><a class="upload-form-toggle target-computer active" href="#computer"><?php echo JText::_('Computer');?></a></li>
                            <!--<li><a class="upload-form-toggle target-web" href="#web"><?php echo JText::_('Web');?></a></li>-->
                            <li id="upload-max"><?php echo JTEXT::sprintf('Each file should be small than %s', '64B');?></li>
                        </ul>
                    </div>
                    <div id="files-uploader-computer" class="upload-form">
                        <div id="files-uploader-grid" data-bind="plupload: true, max_file_size: 64, file_types: '<?php echo $allowed_extensions?>'">
                            <p><?php echo JText::_('Can\'t ini upload');?></p>
                        </div>
                    </div>
                    <div id="files-uploader-web" class="upload-form" style="display: none">
                        <div id="files-uploader-web-form">
                            <div class="remote-wrap" style="margin-right: 97px;">
                                <input data-bind="value: remoteFile.url, valueUpdate: 'keyup'" type="text" placeholder="<?php echo JText::_('Remote Link')?>" title="Remote Link" id="remote-url" name="file" size="50">
                                <input type="text" placeholder="File name" id="remote-name" name="name" data-bind="value: remoteFile.name">
                            </div>
                            <button type="button" class="remote-submit btn" data-bind="click: uploadFromUrl, attr: {disabled: !remoteFile.size() || !remoteFile.name()}, css: {'btn-primary': remoteFile.size() && remoteFile.name()}"><?php echo JText::_('Transfer File');?><span data-bind="if: remoteFile.size"> (<span data-bind="text: remoteFile.size"></span>)</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script id="dirNoteTemplate" type="text/html">
    <div class="mooTree_node" data-bind="css: {mooTree_selected: $data == $root.folderSelected()}">
        <div class="mooTree_padding" data-bind="foreach: new Array(level())">
            <div class="mooTree_img"></div>
        </div>
        <div class="mooTree_img" data-bind="click: $root.expand, css: {expand: childs().length && expand(), collapse: childs().length && !expand()}"></div>
        <div class="mooTree_img folder" data-bind="click: $root.getFolder"></div>
        <div class="mooTree_text" data-bind="text: name, click: $root.getFolder"></div>
        <div class="mooTree_delete" title="<?php echo JText::_('Delete');?>" data-bind="click: $root.deleteFolder, visible: $root.folderSelected().path()"><i class="fa fa-times"></i></div>
    </div>
    <div data-bind="visible: childs().length && expand()">
        <!-- ko template: { name: 'dirNoteTemplate', foreach: childs } -->
        <!-- /ko -->
    </div>
</script>

<script type="text/javascript">
    jQuery(function($){
        $.getJSON('<?php echo $prefix_url;?>&task=files.getFolder', function(data){
            window.FilesModel = new FilesModel(data, '<?php echo $prefix_url;?>', '<?php echo $ctn;?>', '<?php echo $ctn_type;?>', '<?php echo $field;?>');
            ko.applyBindings(FilesModel);
        });
    })
</script>