<?php
/**
 * @version     16.5.5
 * @package     com_cpamanager
 * @copyright   Copyright (C) 2016 METIK Marketing, LLC. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Freddy Flores <fflores@metikmarketing.com> - https://www.metikmarketing.com
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Documents list controller class.
 */
class CPAManagerControllerConfigs extends JControllerAdmin
{
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->registerTask('save',	'save');
        $this->registerTask('apply', 'save');
    }
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'configs', $prefix = 'CPAManagerModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

    public function getConfigs(){
        $options = $this->getModel()->getItems();
        $options->params = json_decode($options->params);
        exit(json_encode(array('options'=>$options, 'extensions'=>$extensions)));
    }

    public function save(){
        $model = $this->getModel();
        $post = JRequest::get('post');
        $model->save($post);
        if($this->getTask() == 'apply') $this->setRedirect('index.php?option=com_cpamanager&view=configs', 'Saved!');
        else $this->setRedirect('index.php?option=com_cpamanager&view=documents', 'Saved!');
    }
}