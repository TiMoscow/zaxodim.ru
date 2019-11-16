<?php
/**
 * @package     Joomla.site
 * @subpackage  Plugin.system.hwd_updateauthentication
 *
 * @copyright   Copyright (C) 2013 Highwood Design Limited. All rights reserved.
 * @license     GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @author      Dave Horsfall
 */

defined('_JEXEC') or die;

class PlgSystemHWD_UpdateAuthenticationInstallerScript
{
	/**
	 * Method to run before an install/update/uninstall method.
	 *
	 * @access  public
         * @param   string  $type    The type of change (install, update or discover_install).
         * @param   string  $parent  The class calling this method.
         * @return  void
	 */
	public function preflight($type, $parent)
	{
                // Initialise variables.
                $app = JFactory::getApplication();
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);
                $query->update($db->quoteName('#__update_sites'))
                      ->set(array(
                          $db->quoteName('name') . ' = ' . $db->quote('HWD Updates'), 
                          $db->quoteName('enabled') . ' = ' . $db->quote('1')))
                      ->where($db->quoteName('location') . ' = ' . $db->quote('https://bitbucket.org/hwdmediashare/updateserver/raw/master/update.xml'));

                try
                {
                        $db->setQuery($query);
                        $db->execute();
                }
                catch (Exception $e)
                {
                        return false;
                } 
        }  
}
