<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_CPAManager
 * @author     Joomlavi <info@joomlavi.com>
 * @copyright  2016 Joomlavi
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of CPAManager records.
 *
 * @since  1.6
 *
 */
class CPAManagerModelLinks extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see        JController
	 * @since      1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				
			);
		}

		parent::__construct($config);
	}


	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return    JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		$db	= $this->getDbo();
		$query	= $db->getQuery(true);
                $query->select('a.*')->from('#__cpamanager_links as a WHERE a.state =1');
		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed An array of data items on success. False on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();foreach($items as $item){
	

}

		return $items;
	}

	
}
