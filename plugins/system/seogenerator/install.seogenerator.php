<?php
######################################################################
# SEO-Generator    	          	                                     #
# Copyright (C) 2017 by MCTrading - All rights reserved. 	   	   	   #
# Homepage   : http://www.suchmaschinen-optimierung-seo.org  		   	 #
# Author     : MCTrading          		   	   	   	   	   	   	   	   #
# Version    : 4.9.0                       	   	    	   	    	   	 #
# License    : GNU/GPL                                               #
######################################################################




// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
//the name of the class must be the name of your component + InstallerScript
//for example: com_contentInstallerScript for com_content.
class plgSystemSEOGeneratorInstallerScript
{
	/*
	 * $parent is the class calling this method.
	 * $type is the type of change (install, update or discover_install, not uninstall).
	 * preflight runs before anything else and while the extracted files are in the uploaded temp folder.
	 * If preflight returns false, Joomla will abort the update and undo everything already done.
	 */
	function preflight( $type, $parent ) {
		$jversion = new JVersion();

			// this component does not work with Joomla releases prior to 3.0, The possible operators are: <, lt, <=, le, >, gt, >=, ge, ==, =, eq, !=, <>, ne
			if( version_compare( $jversion->getShortVersion(), '3.0', 'lt' ) ) {
	 			JFactory::getApplication()->enqueueMessage(JText::_('Cannot install this version of SEO-Generator in a Joomla release prior to 3.0. You can find an new Version on the <a href="http://www.suchmaschinen-optimierung-seo.org/seo-nachrichten/seo-generator" target="blank">official SEO-Generator website</a>'), 'error');
 			
 			return false;
 			
 			}

		  // this component does not work with PHP releases prior to 5.0, The possible operators are: <, lt, <=, le, >, gt, >=, ge, ==, =, eq, !=, <>, ne
			if (version_compare(PHP_VERSION, '5', 'lt' )) {
	 			JFactory::getApplication()->enqueueMessage(JText::_('Cannot install this version of SEO-Generator in a PHP release prior to 5.0. Your server currently uses ' . PHP_VERSION . '. Please update PHP on your server or contact the developer of SEO-Generator with the <a href="http://www.suchmaschinen-optimierung-seo.org" target="blank">official SEO-Generator contact form</a>'), 'error');

 			
 			return false;
 			
 			}
 
		
	}
}
