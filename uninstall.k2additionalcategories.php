<?php
/**
 * @version 1.0.1
 * @package Additional Categories for K2
 * @author Thodoris Bgenopoulos <teobgeno@netpin.gr>
 * @link http://www.netpin.gr
 * @copyright Copyright (c) 2012 netpin.gr
 * @license GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.installer.installer');


$status = new JObject();
$status->plugins = array ();

if (version_compare(JVERSION, '1.6.0', '<'))
{


	$plugins = & $this->manifest->getElementByPath('plugins');

	if (is_a($plugins, 'JSimpleXMLElement') && count($plugins->children())) {

		foreach ($plugins->children() as $plugin) {

			$pname = $plugin->attributes('plugin');
			$pgroup = $plugin->attributes('group');
			
			$db = & JFactory::getDBO();
			$query = 'SELECT `id` FROM #__plugins WHERE element = '.$db->Quote($pname).' AND folder = '.$db->Quote($pgroup);
			$db->setQuery($query);
			$plugins = $db->loadResultArray();
			if (count($plugins)) {
				foreach ($plugins as $plugin) {
					$installer = new JInstaller;
					$result = $installer->uninstall('plugin', $plugin, 0);
				}
			}
			$status->plugins[] = array ('name'=>$pname, 'group'=>$pgroup, 'result'=>$result);
		}
	}

}
?>
