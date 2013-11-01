<?php

/**
 * @package	xNova
 * @version	1.0.x
 * @since	1.0.0
 * @license	http://creativecommons.org/licenses/by-sa/3.0/ CC-BY-SA
 * @link	http://www.razican.com
 * @author	Razican <admin@razican.com>
 */

if ( ! defined('INSIDE')) die(header("Location: ./../../"));
if ( ! ADM_CONFIGURATION) die(message($lang['not_enough_permissions']));

class ShowSettingsPage {

	public function __construct($CurrentUser)
	{
		global $lang;

		$game_config	= 	read_config('', TRUE);

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$Log	= "\n".$lang['log_the_user'].$CurrentUser['username'].$lang['log_sett_no1'].":\n";


			if (isset($_POST['enabled']) && $_POST['enabled'] === 'on')
			{
				$game_config['game_enabled']	= 1;
				$game_config['close_reason']	= addslashes($_POST['close_reason']);
				$Log	.=	$lang['log_sett_enabled'].": ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['game_enabled']	= 0;
				$game_config['close_reason']	= addslashes($_POST['close_reason']);
				$Log	.=	$lang['log_sett_enabled'].": ".$lang['log_viewmod'][0]."\n";
				$Log	.=	$lang['log_sett_close_rea'].": ".$_POST['close_reason']."\n";
			}

			if (isset($_POST['debug']) && $_POST['debug'] === 'on')
			{
				$game_config['debug'] = 1;
				$Log	.= $lang['log_sett_debug'].": ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['debug'] = 0;
				$Log	.= $lang['log_sett_debug'].": ".$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['game_name']) && ! empty($_POST['game_name']))
			{
				$game_config['game_name'] = $_POST['game_name'];
				$Log	.=	$lang['log_sett_name_game'].": ".$_POST['game_name']."\n";
			}

			if (isset($_POST['forum_url']) && ! empty($_POST['forum_url']))
			{
				$game_config['forum_url'] = $_POST['forum_url'];
				$Log	.=	$lang['log_sett_forum_url'].": ".$_POST['forum_url']."\n";
			}

			if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed']))
			{
				$game_config['game_speed'] = (2500 * $_POST['game_speed']);
				$Log	.= $lang['log_sett_velo_game'].": x".$_POST['game_speed']."\n";
			}

			if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed']))
			{
				$game_config['fleet_speed'] = (2500 * $_POST['fleet_speed']);
				$Log	.= $lang['log_sett_velo_flottes'].": x".$_POST['fleet_speed']."\n";
			}

			if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier']))
			{
				$game_config['resource_multiplier'] = $_POST['resource_multiplier'];
				$Log	.= $lang['log_sett_velo_prod'].": x".$_POST['resource_multiplier']."\n";
			}

			if (isset($_POST['initial_fields']) && is_numeric($_POST['initial_fields']))
			{
				$game_config['initial_fields'] = $_POST['initial_fields'];
				$Log	.= $lang['log_sett_fields'].": ".$_POST['initial_fields']."\n";
			}

			if (isset($_POST['metal_basic_income']) && is_numeric($_POST['metal_basic_income']))
			{
				$game_config['metal_basic_income'] = $_POST['metal_basic_income'];
				$Log	.= $lang['log_sett_basic_m'].": ".$_POST['metal_basic_income']."\n";
			}

			if (isset($_POST['crystal_basic_income']) && is_numeric($_POST['crystal_basic_income']))
			{
				$game_config['crystal_basic_income'] = $_POST['crystal_basic_income'];
				$Log	.= $lang['log_sett_basic_c'].": ".$_POST['crystal_basic_income']."\n";
			}

			if (isset($_POST['deuterium_basic_income']) && is_numeric($_POST['deuterium_basic_income']))
			{
				$game_config['deuterium_basic_income'] = $_POST['deuterium_basic_income'];
				$Log	.= $lang['log_sett_basic_d'].": ".$_POST['deuterium_basic_income']."\n";
			}

			if (isset($_POST['adm_attack']) && $_POST['adm_attack'] === 'on')
			{
				$game_config['adm_attack'] = 1;
				$Log	.=	$lang['log_sett_adm_protection'].": ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['adm_attack'] = 0;
				$Log	.=	$lang['log_sett_adm_protection'].": ".$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['language']))
			{
				$game_config['lang'] = $_POST['language'];
				$Log	.=	$lang['log_sett_language'].": ".$_POST['language']."\n";
			}
			else
			{
				$game_config['lang'];
			}

			if (isset($_POST['cookie_name']) && ! empty($_POST['cookie_name']))
			{
				$game_config['cookie_name'] = $_POST['cookie_name'];
				$Log	.=	$lang['log_sett_name_cookie'].": ".$_POST['cookie_name']."\n";
			}

			if (isset($_POST['Defs_Cdr']) && is_numeric($_POST['Defs_Cdr']))
			{
				if ($_POST['Defs_Cdr'] < 0)
				{
					$game_config['defs_cdr'] = 0;
					$Number	= 0;
				}
				elseif ($_POST['Defs_Cdr'] > 100)
				{
					$game_config['defs_cdr'] = 100;
					$Number	= 100;
				}
				else
				{
					$game_config['defs_cdr'] = $_POST['Defs_Cdr'];
					$Number	= $_POST['Defs_Cdr'];
				}

				$Log	.=	$lang['log_sett_debris_def'].": ".$Number."%\n";
			}

			if (isset($_POST['Fleet_Cdr']) && is_numeric($_POST['Fleet_Cdr']))
			{
				if ($_POST['Fleet_Cdr'] < 0)
				{
					$game_config['fleet_cdr'] = 0;
					$Number2	= 0;
				}
				elseif ($_POST['Fleet_Cdr'] > 100)
				{
					$game_config['fleet_cdr'] = 100;
					$Number2	= 100;
				}
				else
				{
					$game_config['fleet_cdr'] = $_POST['Fleet_Cdr'];
					$Number2	= $_POST['Fleet_Cdr'];
				}

				$Log	.=	$lang['log_sett_debris_flot'].": ".$Number2."%\n";
			}

			if (isset($_POST['noobprotection']) && $_POST['noobprotection'] === 'on')
			{
				$game_config['noobprotection'] = 1;
				$Log	.=	$lang['log_sett_act_noobs'].": ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['noobprotection'] = 0;
				$Log	.=	$lang['log_sett_act_noobs'].": ".$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['noobprotectiontime']) && is_numeric($_POST['noobprotectiontime']))
			{
				$game_config['noobprotectiontime'] = $_POST['noobprotectiontime'];
				$Log	.=	$lang['log_sett_noob_time'].": ".$_POST['noobprotectiontime']."\n";
			}

			if (isset($_POST['noobprotectionmulti']) && is_numeric($_POST['noobprotectionmulti']))
			{
				$game_config['noobprotectionmulti'] = $_POST['noobprotectionmulti'];
				$Log	.=	$lang['log_sett_noob_multi'].": ".$_POST['noobprotectionmulti']."\n";
			}

			if (isset($_POST['errors_2']) && $_POST['errors_2'] === 'on')
			{
				$game_config['errors_2'] = 1;
				$Log	.=	$lang['log_sett_errors']." E_WARNING: ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['errors_2'] = 0;
				$Log	.=	$lang['log_sett_errors']." E_WARNING: ".$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['errors_8']) && $_POST['errors_8'] === 'on')
			{
				$game_config['errors_8'] = 1;
				$Log	.=	$lang['log_sett_errors']." E_NOTICE: ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['errors_8'] = 0;
				$Log	.=	$lang['log_sett_errors']." E_NOTICE: ".$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['errors_2048']) && $_POST['errors_2048'] === 'on')
			{
				$game_config['errors_2048'] = 1;
				$Log	.=	$lang['log_sett_errors']." E_STRICT: ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['errors_2048'] = 0;
				$Log	.=	$lang['log_sett_errors']." E_STRICT: ".$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['errors_4096']) && $_POST['errors_4096'] === 'on')
			{
				$game_config['errors_4096'] = 1;
				$Log	.=	$lang['log_sett_errors']." E_RECOVERABLE_ERROR: ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['errors_4096'] = 0;
				$Log	.=	$lang['log_sett_errors']." E_RECOVERABLE_ERROR: ".$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['errors_8192']) && $_POST['errors_8192'] === 'on')
			{
				$game_config['errors_8192'] = 1;
				$Log	.=	$lang['log_sett_errors']." E_DEPRECATED: ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['errors_8192'] = 0;
				$Log	.=	$lang['log_sett_errors']." E_DEPRECATED: ".$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['errors_32767']) && $_POST['errors_32767'] === 'on')
			{
				$game_config['errors_32767'] = 1;
				$Log	.=	$lang['log_sett_errors']." E_ALL: ".$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['errors_32767'] = 0;
				$Log	.=	$lang['log_sett_errors']." E_ALL: ".$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['max_users']) && is_numeric($_POST['max_users']))
			{
				$game_config['max_users'] = $_POST['max_users'];
				$Log	.=	$lang['log_sett_max_users']." ".$_POST['max_users']."\n";
			}

			if (isset($_POST['log_bots']) && $_POST['log_bots'] === 'on')
			{
				$game_config['log_bots'] = 1;
				$Log	.=	$lang['log_sett_bots_log'].': '.$lang['log_viewmod'][1]."\n";
			}
			else
			{
				$game_config['log_bots'] = 0;
				$Log	.=	$lang['log_sett_bots_log'].': '.$lang['log_viewmod'][0]."\n";
			}

			if (isset($_POST['date_format']) && ! empty($_POST['date_format']))
			{
				$game_config['date_format'] = $_POST['date_format'];
				$Log	.=	$lang['log_sett_date_format'].": ".$_POST['date_format']."\n";
			}


			LogFunction($Log, "config");

			if ($lang_changed = (read_config('lang') != $game_config['lang']))
			{
				update_config('lang' 				, $game_config['lang'] 						);

				require_once(XN_ROOT.'language/'.$game_config['lang'].'/INGAME.php');

				doquery('ALTER TABLE  `{{table}}` CHANGE  `name`  `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT  \''.$lang['homeworld'].'\'', 'planets');
			}

			update_config('game_enabled'			, $game_config['game_enabled']				);
			update_config('close_reason'			, $game_config['close_reason']				);
			update_config('game_name'				, $game_config['game_name']					);
			update_config('forum_url'				, $game_config['forum_url']					);
			update_config('game_speed'				, $game_config['game_speed']				);
			update_config('fleet_speed'				, $game_config['fleet_speed']				);
			update_config('resource_multiplier'		, $game_config['resource_multiplier']		);
			update_config('initial_fields'			, $game_config['initial_fields']			);
			update_config('metal_basic_income'		, $game_config['metal_basic_income']		);
			update_config('crystal_basic_income'	, $game_config['crystal_basic_income']		);
			update_config('deuterium_basic_income'	, $game_config['deuterium_basic_income']	);
			update_config('debug'					, $game_config['debug']						);
			update_config('adm_attack'				, $game_config['adm_attack']				);
			update_config('cookie_name'				, $game_config['cookie_name']				);
			update_config('noobprotection'			, $game_config['noobprotection']			);
			update_config('defs_cdr'				, $game_config['defs_cdr']					);
			update_config('fleet_cdr'				, $game_config['fleet_cdr']					);
			update_config('noobprotectiontime'		, $game_config['noobprotectiontime']		);
			update_config('noobprotectionmulti'		, $game_config['noobprotectionmulti']		);
			update_config('errors_2'				, $game_config['errors_2']					);
			update_config('errors_8'				, $game_config['errors_8']					);
			update_config('errors_2048'				, $game_config['errors_2048']				);
			update_config('errors_4096'				, $game_config['errors_4096']				);
			update_config('errors_8192'				, $game_config['errors_8192']				);
			update_config('errors_32767'			, $game_config['errors_32767']				);
			update_config('max_users'				, $game_config['max_users']					);
			update_config('log_bots'				, $game_config['log_bots']					);
			update_config('date_format'				, $game_config['date_format']				);

			if ($lang_changed) die(header('Location: admin.php?page=settings'));
		}

		$parse								= $lang;
		$parse['game_name']					= $game_config['game_name'];
		$parse['game_speed']				= ($game_config['game_speed'] / 2500);
		$parse['fleet_speed']				= ($game_config['fleet_speed'] / 2500);
		$parse['resource_multiplier']		= $game_config['resource_multiplier'];
		$parse['forum_url']					= $game_config['forum_url'];
		$parse['initial_fields']			= $game_config['initial_fields'];
		$parse['metal_basic_income']		= $game_config['metal_basic_income'];
		$parse['crystal_basic_income']		= $game_config['crystal_basic_income'];
		$parse['deuterium_basic_income']	= $game_config['deuterium_basic_income'];
		$parse['max_users_sett']			= $game_config['max_users'];
		$parse['closed']					= ($game_config['game_disable'] == 1) ? ' checked':'';
		$parse['close_reason']				= stripslashes($game_config['close_reason']);
		$parse['debug']						= ($game_config['debug'] == 1) ? ' checked' : '';
		$parse['adm_attack']				= ($game_config['adm_attack'] == 1) ? ' checked' : '';
		$parse['cookie']					= $game_config['cookie_name'];
		$parse['defenses']					= $game_config['defs_cdr'];
		$parse['ships']						= $game_config['fleet_cdr'];
		$parse['noobprot']					= ($game_config['noobprotection'] == 1) ? ' checked' : '';
		$parse['noobprot2']					= $game_config['noobprotectiontime'];
		$parse['noobprot3']					= $game_config['noobprotectionmulti'];
		$parse['errors_2']					= $game_config['errors_2'] ? ' checked' : '';
		$parse['errors_8']					= $game_config['errors_8'] ? ' checked' : '';
		$parse['errors_2048']				= $game_config['errors_2048'] ? ' checked' : '';
		$parse['errors_4096']				= $game_config['errors_4096'] ? ' checked' : '';
		$parse['errors_8192']				= $game_config['errors_8192'] ? ' checked' : '';
		$parse['errors_32767']				= $game_config['errors_32767'] ? ' checked' : '';
		$parse['log_bots']					= $game_config['log_bots'] ? ' checked' : '';
		$parse['date_format']				= $game_config['date_format'];
		$parse['language_settings']			= '';

		foreach (scandir(XN_ROOT.'language') as $lang_folder)
		{
			if (is_dir(XN_ROOT.'language/'.$lang_folder) && $lang_folder != '.' && $lang_folder != '..')
			{
				$parse['language_settings'] .= '<option value="'.$lang_folder.'"';

				if ($game_config['lang'] == $lang_folder)
					$parse['language_settings'] .= ' selected';

				$parse['language_settings'] .= '>'.ucfirst($lang_folder).'</option>';
			}
		}

		display(parsetemplate(gettemplate('adm/SettingsBody'), $parse), TRUE, '', TRUE);
	}
}


/* End of file class.ShowSettingsPage.php */
/* Location: ./includes/pages/adm/class.ShowSettingsPage.php */