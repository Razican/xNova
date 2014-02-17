<?php

/**
 * @package	xNova
 * @version	1.0.x
 * @since	1.0.0
 * @license	http://creativecommons.org/licenses/by-sa/3.0/ CC-BY-SA
 * @link	http://www.razican.com
 * @author	Razican <admin@razican.com>
 */

define('INSIDE' , TRUE);
define('INSTALL', FALSE);
define('IN_ADMIN', TRUE);
define('XN_ROOT', './../');

require(XN_ROOT.'global.php');
require_once(XN_ROOT.'adm/statfunctions.php');

if (AUTHLEVEL < 2) die(message($lang['not_enough_permissions']));

	$result			= MakeStats();
	$memory_p		= str_replace(array("%p", "%m"), $result['memory_peak'], $lang['sb_top_memory']);
	$memory_e		= str_replace(array("%e", "%m"), $result['end_memory'], $lang['sb_final_memory']);
	$memory_i		= str_replace(array("%i", "%m"), $result['initial_memory'], $lang['sb_start_memory']);
	$stats_end_time	= str_replace("%t", $result['totaltime'], $lang['sb_stats_update']);
	$stats_block	= str_replace("%n", $result['amount_per_block'], $lang['sb_users_per_block']);

	update_config('stat_last_update', $result['stats_time']);

	$using_flying 	= ((read_config('stat_flying') == 1) ? $lang['sb_using_fleet_array'] : $lang['sb_using_fleet_query']);

	message($lang['sb_stats_updated'].$stats_end_time.$memory_i.$memory_e.$memory_p.$stats_block.$using_flying);


?>