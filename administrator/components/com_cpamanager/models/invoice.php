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
class CPAManagerModelInvoice extends JModelAdmin
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
	public function getTable($type = 'Invoice', $prefix = 'CPAManagerTable', $config = array())
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

		// Get the form.
		$form = $this->loadForm('com_cpamanager.invoice', 'invoice', array('control' => 'jform', 'load_data' => $loadData));
        
        
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
		$data = JFactory::getApplication()->getUserState('com_cpamanager.edit.invoice.data', array());

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

			//Do any procesing on fields here if needed

		}

		return $item;
	}

	public function save($data){
        $app = JFactory::getApplication();
        // Alter the name for save as copy
        if ($app->input->get('task') == 'save2copy'){
            list($title, $alias) = $this->generateNewTitle($data['alias'], $data['title']);
            $data['title']	= $title;
            $data['alias']	= $alias;
            $data['state']	= 0;
        }

        if($data['storage_type'] == 'file'){
            if(is_file(JPATH_SITE.'/'.  jSont::getDirPath('files').'/'.$data['storage_path_file'])){
                $data['storage_path_remote'] = '';
                $data['filesize'] = filesize(JPATH_SITE.'/'.jSont::getDirPath('files').'/'.$data['storage_path_file']);
                $fileType = jSont::getFileType($data['storage_path_file']);
                $data['ext'] = $fileType['extension'];
            }else{
                JFactory::getApplication()->enqueueMessage(JText::_('COM_CPAMANAGER_MSG_FILE_NOT_FOUND'), 'error');
                return false;
            }
        }else{
            $data['ext'] = '';
            $data['storage_path_file'] = '';
            $data['filesize'] = 0;
        }

        if (parent::save($data)){
            $db = JFactory::getDbo();
            if(!$data['id']) $data['id'] = $db->insertid();
            /*
            $signs = JFactory::getApplication()->input->getString('signs');
            if($signs){
                $signs = explode(',', $signs);
                $db->setQuery('SELECT userid FROM #__signaturedoc_user_signatures WHERE docid='.$data['id']);
                $userSigns = $db->loadColumn();
                foreach($signs as $user) if(!in_array($user, $userSigns)){
                    $query = $db->getQuery(true);
                    $query->insert('#__signaturedoc_user_signatures')->set('docid='.$data['id'])->set('userid='.$user);
                    $db->setQuery($query);
                    $db->execute();
                }

                foreach($userSigns as $user) if(!in_array($user, $signs)){
                    $db->setQuery('DELETE FROM #__signaturedoc_user_signatures WHERE docid='.$data['id'].' AND userid='.$user);
                    $db->execute();
                }
            }else{
                $db->setQuery('DELETE FROM #__signaturedoc_user_signatures WHERE docid='.$data['id']);
                $db->execute();
            }
             * 
             */
            return true;
        }

        return false;
    }

    protected function generateNewTitle($alias, $title)
    {
        // Alter the title & alias
        $table = $this->getTable();
        while ($table->load(array('alias' => $alias))){
            if ($title == $table->title){
                $title = JString::increment($title);
            }
            $alias = JString::increment($alias, 'dash');
        }
        return array($title, $alias);
    }
}