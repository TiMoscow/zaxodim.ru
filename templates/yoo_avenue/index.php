<?php
/**
* @package   yoo_avenue
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// NOT = Joomla! - Open Source Content Management
$this->setGenerator('Titanium');

// get warp
$warp = require(__DIR__.'/warp.php');

// load main theme file, located in /layouts/theme.php
echo $warp['template']->render('theme');