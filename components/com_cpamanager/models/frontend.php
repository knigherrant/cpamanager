<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_CPAManager
 * @author     Joomlavi <info@joomlavi.com>
 * @copyright  2016 Joomlavi
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Methods supporting a list of CPAManager records.
 *
 * @since  1.6
 *
 */
class CPAManagerModelFrontend extends JModelAdmin
{
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Profile', $prefix = 'CPAManagerTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Initialise variables.
		$app	= JFactory::getApplication();
                JForm::addFormPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/forms');
		JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/fields');
		// Get the form.
		$form = $this->loadForm('com_cpamanager.register', 'profile', array('control' => 'jform', 'load_data' => $loadData));
        
        
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_cpamanager.edit.profile.data', array());

		if (empty($data)) {
			$data = $this->getItem();
            
		}

		return $data;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed An array of data items on success. False on failure.
	 */
	public function getItem($pk = null)
	{
		$db	= $this->getDbo();
		$query	= $db->getQuery(true);
		$userid = JFactory::getUser()->id;
		$query->select('a.*,u.name, u.email, u.username')->from('#__cpamanager_profiles as a 
			LEFT JOIN #__users as u ON u.id=a.userid where a.userid=' . $userid);
		
		
		
		$item = $db->setQuery($query)->loadObject();
		$item->bible = jSont::getBibleStudy($item->userid);
		$item->prayerRequest =  jSont::getPrayerRequest($item->userid);
		$item->prayingFor = jSont::getPrayingFor($item->userid, 10);	
		if(empty($item)){
			JFactory::getApplication()->enqueueMessage('Please Create profile cpamanager first.', 'error');
			return array();
		}
		return $item;
	}

	
	function save($data){
		$userid = JFactory::getUser()->id; 
		if(!$userid) return false;
		$uData = array(
			'name' => $_POST['jform']['name'],
			'email' => $_POST['jform']['email']
		);
		$user = new JUser($userid);
		if($user->bind($uData)){
			$saveUser = $user->save();
		}
		
		if(isset($saveUser)){
			if($_FILES['jform']['tmp_name']['avatar']){
				jimport('joomla.filesystem.folder');
				jimport('joomla.filesystem.file');
				$path = JPATH_SITE . '/images/avatars/';
				if(!JFolder::exists($path)) JFolder::create ($path);
				$file = time() . '_' . $_FILES['jform']['name']['avatar'];
				if(JFile::upload($_FILES['jform']['tmp_name']['avatar'], $path . $file)) $data['avatar'] = 'images/avatars/' . $file;
			}
			if(!$data['id']) $data['id'] = $_POST['jform']['id'];
			return parent::save($data);
		}
		
	}
	
}
