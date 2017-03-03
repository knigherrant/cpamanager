<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_CPAManager
 * @author     Joomlavi <info@joomlavi.com>
 * @copyright  2016 Joomlavi
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
jimport('joomla.application.component.controllerform');
/**
 * Frontends list controller class.
 *
 * @since  1.6
 */
class CPAManagerControllerFrontend extends JControllerForm
{
	
	function __construct() {
        $this->view_list = 'frontend';
        parent::__construct();
    }
	
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional
	 * @param   array   $config  Configuration array for model. Optional
	 *
	 * @return object	The model
	 *
	 * @since	1.6
	 */
	public function &getModel($name = 'Frontend', $prefix = 'CPAManagerModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}
        
        function savedata(){
            $model = $this->getModel('Register');
            $input = JFactory::getApplication()->input;
            $result = $model->savedata();
            if($result) $msg = JText::_('Update Testimonials Success');
            else $msg = JText::_('Update Testimonials Error');
            $this->setRedirect(JRoute::_('index.php?option=com_cpamanager&view=frontend&id='.$input->getInt('item_id').'&Itemid='.$input->getInt('Itemid')), $msg);
            return;
        }
        
        function uploadAvatar(){
            if(isset($_FILES['avatar']['tmp_name'])){
                jimport('joomla.filesystem.folder');
                jimport('joomla.filesystem.file');
                $path = JPATH_SITE . '/images/avatars/';
                if(!JFolder::exists($path)) JFolder::create ($path);
                $file = time() . '_' . $_FILES['avatar']['name'];
                if(JFile::upload($_FILES['avatar']['tmp_name'], $path . $file)){
                    $db = JFactory::getDbo();
                    $avatar = 'images/avatars/' . $file;
                    $db->setQuery('UPDATE #__cpamanager_profiles SET avatar=' . $db->Quote($avatar) . ' WHERE userid=' . JFactory::getUser()->id)->execute();
                    echo JURI::root() . $avatar;
                    die;
                }
            }
            die;
        }
}
