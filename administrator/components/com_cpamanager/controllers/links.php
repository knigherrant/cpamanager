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

jimport('joomla.application.component.controlleradmin');

/**
 * Links list controller class.
 */
class CPAManagerControllerLinks extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'link', $prefix = 'CPAManagerModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
        
        function export(){
            $model = $this->getModel('links');
            $model->setState('list.limit',5000);
            $items = $model->getItems();
            $data = array();
            $i=0;
            foreach ($items as $item){
               $row = array();
               $row['ID'] = $item->id;
               $row['TITLE'] = $item->title;
               $row['CATEGORY'] = $item->cat_title;
               $row['FILE'] = $item->storage_path_file;
               $row['DATE START'] = $item->publish_on;
               $row['DATE END'] = $item->unpublish_on;
               $row['CLIENT'] = $item->client_name;
               $row['PROCESS'] = $item->progress;
               $data[] = implode(',',$row);
            }
            $csv = 'ID,"TITLE","CATEGORY","FILE","DATE START","DATE END","CLIENT",PROCESS';
            $csv .="\n";
            $csv .= implode ("\n",$data);
            $filename = "proofs.csv";
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename='.$filename);
            echo $csv;
            exit;
        }
        
    
	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}
}