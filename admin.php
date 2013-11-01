<?php

/**
 * @package	xNova
 * @version	1.0.x
 * @since	1.0.0
 * @license	http://creativecommons.org/licenses/by-sa/3.0/ CC-BY-SA
 * @link	http://www.razican.com
 * @author	Razican <admin@razican.com>
 */

define('INSIDE', TRUE);
define('INSTALL', FALSE);
define('IN_ADMIN', TRUE);
define('XN_ROOT', realpath('./').'/');

require(XN_ROOT.'global.php');
if (AUTHLEVEL < 1) die(message($lang['not_enough_permissions']));

require_once(XN_ROOT.'includes/functions/adm/Autorization.php');

$page	= isset($_GET['page']) ? $_GET['page'] : NULL;

switch($page)
{
//====================================================================================================//
	case 'query':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowQueriesPage.php');
		new ShowQueriesPage();
	break;
//====================================================================================================//
	case 'reset':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowResetPage.php');
		new ShowResetPage();
	break;
//====================================================================================================//
	case 'moderate':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowModerationPage.php');
		new ShowModerationPage(isset($_GET['moderation']) ? (int) $_GET['moderation'] : NULL);
	break;
//====================================================================================================//
	case 'settings':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowSettingsPage.php');
		new ShowSettingsPage($user);
	break;
//====================================================================================================//
	case 'plugins':
		//PLUGINS
		header('Location: admin.php');
	break;
//====================================================================================================//
	case 'database':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowDatabasePage.php');
		new ShowDatabasePage();
	break;
//====================================================================================================//
	case 'errors':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowErrorsPage.php');
		new ShowErrorsPage();
	break;
//====================================================================================================//
	case 'logs':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowLogsPage.php');
		new ShowLogsPage();
	break;
//====================================================================================================//
	case 'bots':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowBotsPage.php');
		new ShowBotsPage();
	break;
//====================================================================================================//
	case 'stats':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowStatsConfigPage.php');
		new ShowStatsConfigPage();
	break;
//====================================================================================================//
//====================================================================================================//
//====================================================================================================//
	case 'global':
		require_once(XN_ROOT.'includes/pages/adm/class.ShowGlobalMessagePage.php');
		new ShowGlobalMessagePage();
	break;
//====================================================================================================//
	default:
		require_once(XN_ROOT.'includes/pages/adm/class.ShowOverviewPage.php');
		new ShowOverviewPage();
//====================================================================================================//
}


/* End of file admin.php */
/* Location: ./admin.php */