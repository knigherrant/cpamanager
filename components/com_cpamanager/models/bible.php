<?php
/**
 * @version     1.0.0
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * CPAManager model.
 */
class CPAManagerModelBible extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_CPAMANAGER';


        
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'Bible', $prefix = 'CPAManagerTable', $config = array())
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
		$form = $this->loadForm('com_cpamanager.bible', 'bible', array('control' => 'jform', 'load_data' => $loadData));
        
        
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
		$data = JFactory::getApplication()->getUserState('com_cpamanager.edit.bible.data', array());

		if (empty($data)) {
			$data = $this->getItem();
            
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param	integer	The id of the primary key.
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk)) {
                    if(!$item->created_by) $item->created_by = JFactory::getUser ()->id;
                    if(!$item->created) $item->created = JFactory::getDate ()->toSql ();
		}

		return $item;
	}


        
        function save($data) {
			if(isset($_FILES['jform']['tmp_name']['audio'])){
				jimport('joomla.filesystem.folder');
				jimport('joomla.filesystem.file');
				$path = JPATH_SITE . '/images/bible_studies/';
				if(!JFolder::exists($path)) JFolder::create ($path);
				$file = time() . '_' . $_FILES['jform']['name']['audio'];
				if(JFile::upload($_FILES['jform']['tmp_name']['audio'], $path . $file)) $data['audio'] = 'images/bible_studies/' . $file;
			}
            return parent::save($data);
        }

        
        function addComment($project_id = 0){
            $input = JFactory::getApplication()->input;
            $user = JFactory::getUser();
            $message = $_POST['comment'];
            if(!$message) return false;
            if($user->id){
                $data = array();
                $data['title'] = $input->getString('title', JText::_('Comment for Bible Study'));
                $data['userid'] = $user->id;
                $data['item_id'] = $input->getInt('item_id');
                $data['comment'] = $message;
                $data['type'] = 'bible';
                $data['created'] = JFactory::getDate()->toSql();
                $row = $this->getTable('comment');
                $row->bind($data);
                if(!$row->save($data)){
                    return false;
                }
                return true;
            }
            return false;
        }
        
}