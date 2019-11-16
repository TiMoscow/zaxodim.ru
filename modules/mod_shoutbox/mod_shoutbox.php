<?php 
/**
* @package    JJ_Shoutbox
* @copyright  Copyright (C) 2011 - 2018 JoomJunk. All rights reserved.
* @license    GPL v3.0 or later http://www.gnu.org/licenses/gpl-3.0.html
*/

defined('_JEXEC') or die('Restricted access');

JLoader::register('JFolder', JPATH_LIBRARIES . '/joomla/filesystem/folder.php');

require_once dirname(__FILE__) . '/helper.php';

$title    = $module->title;
$uniqueId = $module->id;
$helper   = new ModShoutboxHelper($title);
$params   = $helper->getParams();
$count    = $helper->countShouts();

$displayName     = $params->get('loginname', 'user');
$swearcounter    = $params->get('swearingcounter', 1);
$swearnumber     = $params->get('swearingnumber');
$number          = $params->get('maximum');
$profile         = $params->get('profile');
$avatar          = $params->get('avatar', 'none');
$date            = $params->get('date');
$securitytype    = $params->get('securitytype', 0);
$siteKey         = $params->get('recaptcha-public');
$secretKey       = $params->get('recaptcha-private');
$recaptchaTheme  = $params->get('recaptcha-theme', 'light');
$securityHide    = $params->get('security-hide', 0);
$mass_delete     = $params->get('mass_delete', 0);
$permissions     = $params->get('guestpost');
$outputboxcolor  = $params->get('outputboxcolor', '#FFFFFF');
$deletecolor     = $params->get('deletecolor', '#FF0000');
$editcolor       = $params->get('editcolor', '#444444');
$bordercolour    = $params->get('bordercolor', '#FF3C16');
$borderwidth     = $params->get('borderwidth', 1);
$headercolor     = $params->get('headercolor', '#D0D0D0');
$headertextcolor = $params->get('headertextcolor', '#000000');
$textcolor       = $params->get('textcolor', '#000000');
$outputheight    = $params->get('outputheight', 200);
$textareaheight  = $params->get('textareaheight', 120);
$bbcode          = $params->get('bbcode', 1);
$entersubmit     = $params->get('entersubmit', 0);
$sound           = $params->get('sound', 1);
$notifications   = $params->get('notifications', 0);
$framework       = $params->get('framework', 'bootstrap');
$genericName     = $params->get('genericname', 'Anonymous');
$nameRequired    = $params->get('namerequired', 0);
$alertLength     = $params->get('alertlength', 50);
$warnLength      = $params->get('warnlength', 10);
$enablelimit     = $params->get('enablelimit', 1);
$messageLength   = $params->get('messagelength', 200);
$refresh         = $params->get('refresh', 10) * 1000;
$deleteown       = $params->get('deleteown', 0);
$editown         = $params->get('editown', 1);
$editowntime     = $params->get('editown-time', 5);
$history         = $params->get('history', 1);
$remainingLength = JText::_('SHOUT_REMAINING');
$rtl             = JFactory::getLanguage()->isRTL();

// Assemble the factory variables needed
$doc  = JFactory::getDocument();
$user = JFactory::getUser();
$app  = JFactory::getApplication();
$activeMenuItem = $app->getMenu()->getActive();
$Itemid = is_null($activeMenuItem) ? null : $activeMenuItem->id;

// Apply UI framework styling
switch ($framework)
{
	case 'uikit':
		$form          = ' uk-form';
		$button_group  = ' uk-button-group';
		$button        = ' uk-button';
		$button_small  = ' uk-button-small';
		$button_danger = ' uk-button-danger';
		$button_prim   = ' uk-button-primary';
		$input_txtarea = null;
		$form_row      = ' uk-margin-small-top';
		$clearfix      = ' uk-clearfix';
		$modal         = ' uk-modal';
		$modal_img     = null;
		$jj_class      = null;
		$input_small   = 'uk-form-width-small';
		$dropdown_menu = 'uk-dropdown';
		break;

	case 'bootstrap':
		$form          = null;
		$button_group  = ' btn-group';
		$button        = ' btn';
		$button_small  = ' btn-small';
		$button_danger = ' btn-danger';
		$button_prim   = ' btn-primary';
		$input_txtarea = null;
		$form_row      = ' form-group';
		$clearfix      = ' clearfix';
		$modal         = ' modal hide fade';
		$modal_img     = null;
		$jj_class      = null;
		$input_small   = 'input-small';
		$dropdown_menu = 'dropdown-menu unstyled';
		break;

	case 'bootstrap3':
		$form          = null;
		$button_group  = ' btn-group';
		$button        = ' btn btn-default';
		$button_small  = ' btn-sm';
		$button_danger = ' btn-danger';
		$button_prim   = ' btn-primary';
		$input_txtarea = ' form-control';
		$form_row      = ' form-group';
		$clearfix      = ' clearfix';
		$modal         = ' modal fade';
		$modal_img     = ' img-responsive';
		$jj_class      = null;
		$input_small   = 'input-sm';
		$dropdown_menu = 'dropdown-menu list-unstyled';
		break;

	default:
		$form          = null;
		$button_group  = ' btn-group';
		$button        = ' btn';
		$button_small  = ' btn-small';
		$button_danger = ' btn-danger';
		$button_prim   = ' btn-primary';
		$input_txtarea = null;
		$form_row      = ' form-group';
		$clearfix      = ' clearfix';
		$modal         = ' modal hide fade';
		$modal_img     = null;
		$jj_class      = 'jj_fallback';
		$input_small   = 'input-small';
		$dropdown_menu = 'dropdown-menu unstyled';
		break;
}

JHtml::_('jquery.framework');
if ($securitytype == 1)
{
	if ($securityHide == 0 || ($user->guest && $securityHide == 1))
	{
		JHtml::_('script', 'https://www.google.com/recaptcha/api.js');
	}
}
JHtml::_('script', 'mod_shoutbox/mod_shoutbox.js', false, true);

$dataerror = JText::_('SHOUT_DATABASEERRORSHOUT');

// Load JLog class
JLoader::register('JLog', JPATH_LIBRARIES . '/joomla/log/log.php');

// Log mod_shoutbox errors to specific file.
JLog::addLogger(
	array(
		'text_file' => 'mod_shoutbox.errors.php'
	),
	JLog::ALL,
	'mod_shoutbox'
);

if (isset($_POST))
{
	$post = $app->input->post->get('jjshout', array(), 'array');

	if (isset($post['shout']))
	{
		$helper->submitPhp($post);
	}

	if (isset($post['delete']))
	{
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		$deletepostnumber = $post['idvalue'];
		$postidvalue      = $post['useridvalue'];

		if ($user->authorise('core.delete') || ($postidvalue == $user->id && $deleteown == 1))
		{
			$helper->deletepost($deletepostnumber);
		}
	}

	if ($mass_delete == 1 && isset($post['deleteall']))
	{
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		$delete = $post['valueall'];
		$dir    = $post['order'];

		if (isset($delete))
		{
			if (is_numeric($delete) && (int) $delete == $delete)
			{
				if ($delete > 0)
				{
					if ($delete > $post['max'])
					{
						$delete = $post['max'];
					}
					if ($user->authorise('core.delete'))
					{
						$helper->deleteall($delete, $dir);
					}
				}
				else
				{
					JLog::add(JText::_('SHOUT_GREATER_THAN_ZERO'), JLog::WARNING, 'mod_shoutbox');
					$app->enqueueMessage(JText::_('SHOUT_GREATER_THAN_ZERO'), 'error');
				}
			}
			else
			{
				JLog::add(JText::_('SHOUT_NOT_INT'), JLog::WARNING, 'mod_shoutbox');
				$app->enqueueMessage(JText::_('SHOUT_NOT_INT'), 'error');
			}
		}
	}
}

// Retrieves the shouts from the database
$shouts = $helper->getShouts(0, $number, $dataerror);

// Counts the number of shouts retrieved from the database
$actualnumber = count($shouts);

require JModuleHelper::getLayoutPath('mod_shoutbox');
