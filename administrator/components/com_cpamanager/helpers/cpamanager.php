<?php

/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */
// No direct access
defined('_JEXEC') or die;
 if(!function_exists('k')){
	 function k($str){
		 //if($_SERVER['REMOTE_ADDR'] == '14.161.35.175' || $_SERVER['REMOTE_ADDR'] == '::1' || $_SERVER['SERVER_NAME'] == 'localhost'){
			if($str){
				echo "<pre>";
				print_R($str);
				echo "</pre>";
			}else{
				echo "<pre>";
				var_dump($str);
				echo "</pre>";
			}
		//}
	 }
 }
class jSont extends CPAManagerHelper{
    
    public static $file_ext =  array(
        'archive' => array('7z', 'ace', 'bz2', 'dmg', 'gz', 'rar', 'tgz', 'zip'),
        'document' => array('csv', 'doc', 'docx', 'html', 'key', 'keynote', 'odp', 'ods', 'odt', 'pages', 'pdf', 'pps', 'ppt', 'pptx', 'rtf', 'tex', 'txt', 'xls', 'xlsx', 'xml'),
        'image' => array('bmp', 'exif', 'gif', 'ico', 'jpeg', 'jpg', 'png', 'psd', 'tif', 'tiff'),
        'audio' => array('aac', 'aif', 'aiff', 'alac', 'amr', 'au', 'cdda', 'flac', 'm3u', 'm3u', 'm4a', 'm4a', 'm4p', 'mid', 'mp3', 'mp4', 'mpa', 'ogg', 'pac', 'ra', 'wav', 'wma'),
        'video' => array('3gp', 'asf', 'avi', 'flv', 'm4v', 'mkv', 'mov', 'mp4', 'mpeg', 'mpg', 'ogg', 'rm', 'swf', 'vob', 'wmv')
    );
	public static function getFileType($file){
        $pathinfo = pathinfo($file);
        $extension = strtolower(@$pathinfo['extension']);
        $imageTypes = array('bmp','exif','gif','ico','jpeg','jpg','png','psd','tif','tiff');
        $icon = JURI::root().'administrator/components/com_cpamanager/assets/images/file-icons/'.$extension.'.png';
        if(!is_file(JPATH_SITE.'/administrator/components/com_cpamanager/assets/images/file-icons/'.$extension.'.png'))
            $icon = JURI::root().'administrator/components/com_cpamanager/assets/images/file-icons/_blank.png';
        if(in_array($extension,$imageTypes)){
            return array('type'=>'image', 'extension'=>$extension, 'icon'=>$icon);
        }else{
            return array('type'=>$extension, 'extension'=>$extension, 'icon'=>$icon);
        }
    }
	
	public static function formatFileSize($bytes){
        if ($bytes >= 1073741824){
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }elseif ($bytes >= 1048576){
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }elseif ($bytes >= 1024){
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }elseif ($bytes > 1){
            $bytes = $bytes . ' bytes';
        }elseif ($bytes == 1){
            $bytes = $bytes . ' byte';
        }else{
            $bytes = '0 bytes';
        }
        return $bytes;
    }

	public static function checkFileUpload($file, $type){
        if($file['error']>0 && $file['error']<4){
            switch ($file['error'])
            {
                case 1:
                    return JText::_('File uplad large than php.ini').' '.ini_get( 'upload_max_filesize' );
                    break;
                case 2:
                    return JText::_('File uplad large than HTML');
                    break;
                case 3:
                    return JText::_('File uplad error');
                    break;
            }
        }
        if(!self::checkFileType($file['name'], $type)){
            return JText::_('Invalid Type');
        }
        return true;
    }
	
	public static function downloadFile($file){
        $file = str_replace(JUri::root(), JPATH_SITE.'/', $file);
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }

	
	public static function checkFileType($file, $type){
		return true;
        //$configs = self::getConfigs();
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if($type == 'file'){
            $fileTypes = explode(',', $configs->get('allowed_extensions'));
        }elseif($type == 'import'){
            $fileTypes = array('csv');
        }else{
            $fileTypes = self::$file_ext['image'];
        }
        if(!in_array($extension, $fileTypes)) return false;
        return true;
    }
	
	
	
	
	public static function sanitizeFileName($dangerous_filename){
        // our list of "dangerous characters", add/remove characters if necessary
        $dangerous_characters = array(" ", '"', "'", "&", "/", "\\", "?", "#");
        // every forbidden character is replace by an underscore
        return str_replace($dangerous_characters, '_', $dangerous_filename);
    }
	
	  public static function getMaximumUploadSize(){
        $max_upload = self::convertToBytes(ini_get('upload_max_filesize'));
        $max_post   = self::convertToBytes(ini_get('post_max_size'));
        return min($max_post, $max_upload);
    }

    public static function convertToBytes($value){
        $keys = array('k', 'm', 'g');
        $last_char = strtolower(substr($value, -1));
        $value = (int) $value;
        if (in_array($last_char, $keys)) {
            $value *= pow(1024, array_search($last_char, $keys)+1);
        }
        return $value;
    }
	
	public static function addMedia(){
    
        $document = JFactory::getDocument();
        
        JHtml::_('behavior.framework');
		JHtml::_('Jquery.framework');
		JHtml::_('bootstrap.framework');
        
        $document->addScript(JUri::root().'administrator/components/com_cpamanager/assets/libs/knockout.js');
        $document->addScript(JUri::root().'administrator/components/com_cpamanager/assets/libs/underscore-min.js');
        $document->addScript(JUri::root().'administrator/components/com_cpamanager/assets/libs/knockout.simpleGrid.js');
        $document->addScript(JUri::root().'administrator/components/com_cpamanager/assets/js/jquery.noconflict.js');
        $document->addStyleSheet(JUri::root().'administrator/components/com_cpamanager/assets/libs/font-awesome/css/font-awesome.css');
       
		$document->addStyleSheet(JUri::root().'administrator/components/com_cpamanager/assets/libs/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css');
		$document->addScript(JUri::root().'administrator/components/com_cpamanager/assets/libs/plupload/js/plupload.full.min.js');
		$document->addScript(JUri::root().'administrator/components/com_cpamanager/assets/libs/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js');
		$document->addScript(JUri::root().'administrator/components/com_cpamanager/assets/js/files.js');
		$document->addStyleSheet(JUri::root().'administrator/components/com_cpamanager/assets/css/files.css');
                   
    }
	
	
    
    
    public static  function loadAdminCss(){
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::root() . 'components/com_cpamanager/assets/css/cpamanager-frontend.css');
        $document->addStyleSheet(JURI::root() . 'administrator/components/com_cpamanager/assets/css/cpamanager.css');
        $document->addScript(JUri::root().'administrator/components/com_cpamanager/assets/js/jquery.noconflict.js');
        $document->addScript(JURI::root() . 'components/com_cpamanager/assets/js/cpamanager.js');
        //self::upgradePermission();
		
    }
    
	
    public static  function loadFrontEndCss(){
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::root() . 'components/com_cpamanager/assets/css/cpamanager-frontend.css');
        $document->addScript(JURI::root() . 'components/com_cpamanager/assets/js/cpamanager.js');
    }
    
    public static function upgradePermission(){
        $db = JFactory::getDbo();
        $db->setQuery('UPDATE #__assets SET rules=' . $db->quote('{"core.create":{"2":1},"core.edit":{"2":1},"core.edit.state":{"2":1},"core.edit.own":{"2":1}}') . ' WHERE name=' . $db->quote('com_cpamanager'))->execute(); 
    }
    
    public static function getTable($table){
        JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_cpamanager/tables');
        return JTable::getInstance(ucwords($table),'CPAManagerTable');
    }
    
    public static function getModel($model){
        JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_cpamanager/models', 'CPAManagerModel');
        return JModelLegacy::getInstance(ucwords($model), 'CPAManagerModel', array('ignore_request' => true));
    }
   
    public static function getLocation($id = 0){
        if(!$id) return false;
        $db = JFactory::getDbo();
        $location = $db->setQuery('SELECT * FROM #__cpamanager_locations WHERE id=' . (int) $id)->loadObject();
        return $location;
    }
    
    public static function getOptionCpa(){
        $db = JFactory::getDbo();
        $lists = $db->setQuery('SELECT CONCAT(firstname," ",midname," ",lastname) as name, id   FROM #__cpamanager_cpas ')->loadObjectList();
        $options[] = JHTML::_('select.option','', '- Select CPA -');
        foreach ($lists as $l){
            $options[] = JHTML::_('select.option',$l->id, $l->name);
        }
	return $options;
    }
    
    public static function getOptionMileage(){
        $db = JFactory::getDbo();
        $lists = $db->setQuery('SELECT company as name, id   FROM #__cpamanager_mileages ')->loadObjectList();
        $options[] = JHTML::_('select.option','', '- Select Mileage -');
        foreach ($lists as $l){
            $options[] = JHTML::_('select.option',$l->id, $l->name);
        }
	return $options;
    }
    
    public static function getDirPath($type){
        if($type == 'files'){
            return 'images/cpamanage/files';
        }elseif($type == 'import'){
            return 'images/cpamanage/files/mobile';
        }else{
            return 'images/cpamanage/'.$type;
        }
    }
    
    
    public static function getIcon($fileName, $isCustom = 0){
        if($fileName && $isCustom){
            return JUri::root().self::getDirPath('icons').'/'.$fileName;
        }elseif($fileName){
            return JUri::root().'administrator/components/com_cpamanager/assets/images/file-icons/'.$fileName;
        }
        return JUri::root().'administrator/components/com_cpamanager/assets/images/file-icons/_blank.png';
    }

    
	public static function footer(){
		?>
			<form id="jkLogout" action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post">
				<input type="hidden" name="return" value="<?php echo base64_encode(JURI::root()); ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</form>
			<a class="jk-logout" href="">[Logout]</a>
			<script>
                jQuery(function($){
                        $('a.jk-logout').click(function(){
                            $('#jkLogout').submit();
                        });
                })
            </script>
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
        
        
	public static function playAudio($audio){
		if(file_exists(JPATH_SITE . '/' . $audio)){
			?>
			<audio controls>
			  <source src="<?php echo JURI::root() . $audio ;?>" type="audio/mpeg">
			Your browser does not support the audio element.
			</audio>
			<p><a target="_blank" href="<?php echo JURI::root() . $audio ;?>">Link</a></p>
			<?php
			
		}else echo JText::_('File not found');
	}
	
    public static  function getComments($item_id = 0, $type = ''){
        if(!$item_id || !$type) return array();
        $db = JFactory::getDbo();
        $lists = $db->setQuery('select a.*,u.name from #__cpamanager_comments as a '
                . 'left join #__users as u ON u.id=a.userid '
                . 'where type="' . $type . '" AND item_id=' . (int) $item_id)->loadObjectList();
        return $lists;
    }
    
    public static  function format($date){
        return JHtml::_('date', $date, JText::_('DATE_FORMAT_LC3'), false);
    }
    
    
    public static  function getPrayerRequest($userid = 0, $limit = 1){
        if(!$userid) $userid = JFactory::getUser ()->id;
        $db = JFactory::getDbo();
        $where = '';
        //if($userid) $where = ' WHERE userid= ' . $userid;
        $prayer = $db->setQuery('SELECT a.*,u.name as userRequest FROM #__cpamanager_requests as a '
                . 'LEFT JOIN #__users as u ON u.id=a.userid ' . $where . ' ORDER BY a.id DESC LIMIT 0,' . $limit)->loadObjectList();
        if($limit == 1) return @$prayer[0];
        return $prayer;
    } 
    
    public static  function getPrayingFor($userid = 0, $limit = 1){
        if(!$userid) $userid = JFactory::getUser ()->id;
        $db = JFactory::getDbo();
        $where = '';
        //if($userid) $where = ' WHERE userid= ' . $userid;
        $prayer = $db->setQuery('SELECT w.*,u.name as prayforUser FROM #__cpamanager_warriors as w '
                . 'LEFT JOIN #__users as u ON u.id=w.prayfor ORDER BY w.id DESC LIMIT 0,' . $limit)->loadObjectList();
        if($limit == 1) return @$prayer[0];
        return $prayer;
    } 
    
    
    public static  function getBibleStudy($userid = 0, $limit = 1){
        if(!$userid) $userid = JFactory::getUser ()->id;
        $db = JFactory::getDbo();
        $where = '';
        //if($userid) $where = ' WHERE created_by= ' . $userid;
        $wa = $db->setQuery('SELECT * FROM #__cpamanager_bibles ' . $where . ' ORDER BY id DESC LIMIT 0,' . $limit)->loadObjectList();
        if($limit == 1) return @$wa[0];
        return $wa;
    } 
    
    
    public static  function getUser($userid = 0){
        if(!$userid) $userid = JFactory::getUser ()->id;
        static $uProfile;
        if(!isset($uProfile[$userid])){
            $db = JFactory::getDbo();
            $user = JFactory::getUser($userid);
            $profile = $db->setQuery('SELECT * FROM #__cpamanager_profiles WHERE userid=' . $userid)->loadObject();
            if(!$profile){
                JFactory::getApplication()->enqueueMessage('Please Create profile cpamanager first.', 'error');
                $profile = new stdClass();
            }
            $profile->user = $user;
                    if(isset($profile->avatar) && $profile->avatar) $profile->avatar = JURI::root() . $profile->avatar;
                    else $profile->avatar = JURI::root() . 'administrator/components/com_cpamanager/assets/images/avatar.jpg';
            $uProfile[$userid] =  $profile;
        }
        return $uProfile[$userid];
    }
    
    public static  function getAvatar($avatar = ''){
        if($avatar){
			$pos = strpos($avatar, 'http');
			if ($pos === false)return JURI::root() . $avatar;
			else return $avatar;
		}
		return JURI::root() . 'administrator/components/com_cpamanager/assets/images/avatar.jpg';
    }
	
    public static  function getCategory($type = 'category_expenses'){
        $category = jSont::getConfig()->$type;
        $lists = json_decode($category);
        return $lists;
                
    }
    
    public static  function getOptionCategory($type = 'category_expenses'){
        $lists = self::getCategory($type);
        $options[] = JHTML::_('select.option','', '- Select Category -');
        foreach ($lists as $l){
            $options[] = JHTML::_('select.option',$l->name, $l->name);
        }
	return $options;
    }
    
    
     public static  function getMonths(){
        $options[] = JHTML::_('select.option','', '- Month -');
        for ($i=1; $i < 13; $i++){
            $options[] = JHTML::_('select.option',$i, $i);
        }
	return $options;
    }
    
    public static  function getDays(){
        $options[] = JHTML::_('select.option','', '- Day -');
        for ($i=1; $i < 32; $i++){
            $options[] = JHTML::_('select.option',$i, $i);
        }
	return $options;
    }
    
    
    public static  function showProfileHtml($userid = 0, $edit = false){
        if(!$userid) $userid = JFactory::getUser ()->id;
        $item = self::getUser($userid);
        ob_start();
        ?>
        <div id="userProfile" class="profile">
            <div class="img span3 userAvatar big-avatar">
                <?php if($edit){ ?>
                    <img class="avatarProfile canEdit" alt="Click to change your avatar" src="<?php echo $item->avatar; ?>" />
                <?php }else{ ?>
                    <img class="avatarProfile" alt="" src="<?php echo $item->avatar; ?>" />
                <?php } ?>
            </div>
            <div class="info span6">
                <div class="span3">
                    <p><?php echo $item->user->name; ?></p>
                    <p><?php echo $item->user->username; ?></p>
                    <p><?php echo $item->user->email; ?></p>
                    <p><?php echo @$item->church; ?></p>
                    <p><?php echo @$item->pastor; ?></p>
                </div>
                <div class="span3">
                    <p>Account Type: <?php echo (@$item->account == '1')? 'VIP' : 'Free'; ?></p>
                    <p><?php echo @$item->phone; ?></p>
                    <p><?php echo @$item->location; ?></p>
					<?php if($edit){ ?><p><a href="<?php echo JRoute::_('index.php?option=com_cpamanager&view=frontend&layout=edit&Itemid=' . JFactory::getApplication()->input->getInt('Itemid')); ?>">[Edit Profile]</a></p><?php } ?>
                </div>
            </div>
            <?php if($edit){ ?>
                <input style="display: none" id="cAvatar" type="file" name="avatar" />
                <script>
                    jQuery(function($){
                        $('#userProfile .userAvatar').click(function(){$('#cAvatar').click()});
                        $('#cAvatar').change(function(){
                            jSont.uploadImage();
                        })
                    })
                </script>
            <?php } ?>
            <div class="clearfix clear"></div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    
    public static  function googleMap($cfg = array()){
	
		$html  = '';
		$config = (object) array(
                    'apikey' => 'AIzaSyD7KJAbPjbKDmQxCVsiTlVOmQihmbOoFdY',
                    'long' => ($cfg['lng'])? $cfg['lng'] : '',
                    'lat' => ($cfg['lat'])? $cfg['lat'] : '',
                    'address' => ($cfg['address'])? $cfg['address'] : '',
                    'infotext' => $cfg['address'],
                    'zoom' => 17,
                    'marker' => '',
                    'icon' => ''
                );
                if(!$cfg['id'] || !$config->address){
                    $config->address = '';
                    $config->lat = '48.87146';
                    $config->long = '2.35500';      
                }
                $width = isset($cfg['width'])?$cfg['width']:'600px';
                $height = isset($cfg['height'])?$cfg['height']:'300px';
		$mapid = 'jsmap';
		if(!$config->apikey) return $html;
		$doc = JFactory::getDocument();
		$doc->addScript('http://maps.googleapis.com/maps/api/js?key='.$config->apikey.'&sensor=false');
		$doc->addScript(JURI::root().'administrator/components/com_cpamanager/assets/js/jsmap.js');
                
                if($config->address != '' && !$config->lat){
                    $script = '
                                var geocoder = new google.maps.Geocoder();
                                geocoder.geocode( { "address": "'.$config->address.'"}, function(results, status) {
                                    if (status == "OK") {
                                        jQuery("#jform_latitude").val(results[0].geometry.location.lat());
                                        jQuery("#jform_longitude").val(results[0].geometry.location.lng());
                                    } else {

                                    }
                                });
                                
                                jQuery(function($){
                                var timex = setInterval(function(){
                                    if(jQuery("#jform_latitude").val() && jQuery("#jform_longitude").val()){
                                        jSont.initialize({
                                            jsmapid		:"'.$mapid.'",
                                            lat			:jQuery("#jform_latitude").val(),
                                            lng			:jQuery("#jform_longitude").val(),
                                            address		:"'.$config->address.'",
                                            zoom		:'.$config->zoom.',
                                            iconmarker	:"'.$config->icon.'",
                                            infotext	:"'.$config->infotext.'",
                                            draggable	:"true",
                                            addevent        : "true"
                                        });
                                        clearInterval(timex);
                                    }
                                }, 100);

                                    
                                });
                            ';
                }else{
                    $script = '
			jQuery(function($){
                            jSont.initialize({
                                jsmapid		:"'.$mapid.'",
                                lat			:"'.$config->lat.'",
                                lng			:"'.$config->long.'",
                                address		:"'.$config->address.'",
                                zoom		:'.$config->zoom.',
                                iconmarker	:"'.$config->icon.'",
                                infotext	:"'.$config->infotext.'",
                                draggable	:"true",
                                addevent        : "true"
                            });
                        });
			';
                }
		$doc->addScriptDeclaration($script);
		$html = '<div style="width:'.$width.'; height: '.$height.';" id="'.$mapid.'"></div>';
		return $html;
	}
	
    public static function getConfig(){
        static $cfg;
        if(isset($cfg)) return $cfg;
        $db = JFactory::getDbo();
        $cfg = $db->setQuery('SELECT * FROM #__cpamanager_config WHERE id=1')->loadObject();
        $cfg->params = json_decode($cfg->params);
        return $cfg;
    }
    
    
  
    public static function menuSiderbar(){
        $config = self::getConfig();
        $menus = array(
            'cpas' => JText::_('COM_CPAMANAGER_TITLE_CPAS'),
            'customers' => JText::_('COM_CPAMANAGER_TITLE_CUSTOMERS'),
            'invoices' => JText::_('COM_CPAMANAGER_TITLE_INVOICES'),
            'expenses' => JText::_('COM_CPAMANAGER_TITLE_EXPENSES'),
            'receipts' => JText::_('COM_CPAMANAGER_TITLE_RECEIPTS'),
            'mileages' => JText::_('COM_CPAMANAGER_TITLE_MILEAGES'),
            'taxreturns' => JText::_('COM_CPAMANAGER_TITLE_TAXRETURNS'),
            'links' => JText::_('COM_CPAMANAGER_TITLE_LINKS'),
            'configs' => JText::_('COM_CPAMANAGER_TITLE_CONFIG'),
            'reports' => JText::_('COM_CPAMANAGER_TITLE_REPORTS'),
        );
        ob_start();
        ?><div id="CPAManagerMenu">
            <div class="jMenu-cpamanager">
                <ul class="jsont-menu">
                    <?php foreach ($menus as $view=>$text){ ?>
                        <?php
                        $page = JFactory::getApplication()->input->getString('view');
                        $selected = '';
                        if($page == $view || $page . 's' == $view) $selected = 'active';
                        ?>
                        <li class="frontend <?php echo $selected; ?>">
                            <a class="<?php echo $selected; ?>" href="index.php?option=com_cpamanager&view=<?php echo $view; ?>" title="<?php echo $text; ?>">
                                <img src="<?php echo JURI::root(); ?>components/com_cpamanager/assets/images/items/<?php echo $view; ?>.png" />
                                <span><?php echo $text; ?></span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
   
    
   public static function accountType($type = null){
        $account = array(
            0 => JText::_('Free'),
            1 => JText::_('VIP'),
        );
        if(isset($account[$type])) return $account[$type];
        return $account;
    }
    
   
    
   public static function repairDb(){
        $db = JFactory::getDbo();
        //$location = "ALTER TABLE `#__mobile_staff` ADD `location` text NOT NULL";
        //if(!self::hasField('#__mobile_staff', 'location')) $db->setQuery($location)->query();
    }
    
    public static function hasField($jtable, $col){
        $db = JFactory::getDbo();
        $column = $db->getTableColumns($jtable); 
        foreach ($column as $c=>$t){
            if($col == $c) return true;
        }
        return false; 
    }
    
    
    
    
}
/**
 * CPAManager helper.
 */
class CPAManagerHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
                JSubMenuHelper::addEntry(
			JText::_('COM_CPAMANAGER_TITLE_PROFILES'),
			'index.php?option=com_cpamanager&view=profiles',
			$vName == 'profiles'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_CPAMANAGER_TITLE_REQUESTS'),
			'index.php?option=com_cpamanager&view=requests',
			$vName == 'requests'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_CPAMANAGER_TITLE_WARRIORS'),
			'index.php?option=com_cpamanager&view=warriors',
			$vName == 'warriors'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_CPAMANAGER_TITLE_LINKS'),
			'index.php?option=com_cpamanager&view=links',
			$vName == 'links'
		);
		JSubMenuHelper::addEntry(
			JText::_('COM_CPAMANAGER_TITLE_EVENTS'),
			'index.php?option=com_cpamanager&view=events',
			$vName == 'events'
		);
		

    }


    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_cpamanager';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
