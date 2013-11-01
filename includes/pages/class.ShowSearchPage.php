<?php

/**
 * @package	xNova
 * @version	1.0.x
 * @since	1.0.0
 * @license	http://creativecommons.org/licenses/by-sa/3.0/ CC-BY-SA
 * @link	http://www.razican.com
 * @author	Razican <admin@razican.com>
 */

if ( ! defined('INSIDE')) die(header("Location:../../"));

class ShowSearchPage
{
	function __construct()
	{
		global $lang, $db;

		$parse 	= $lang;
		$type 	= $_POST['type'];

		$searchtext = $db->real_escape_string($_POST["searchtext"]);

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			switch ($type)
			{
				case "playername":
					$table 	= gettemplate('search/search_user_table');
					$row 	= gettemplate('search/search_user_row');
					$search	= doquery("SELECT u.*,s.total_rank as rank FROM {{table}}users as u, {{table}}statpoints as s WHERE u.id = s.id_owner && s.stat_type=1 && u.username LIKE '%".$searchtext."%' LIMIT 25 ; ","");
				break;
				case "planetname":
					$table 	= gettemplate('search/search_user_table');
					$row 	= gettemplate('search/search_user_row');
					$search	= doquery("SELECT p.*,s.total_rank as rank FROM {{table}}planets as p, {{table}}statpoints as s WHERE p.id_owner = s.id_owner && s.stat_type=1 && p.name LIKE '%".$searchtext."%' LIMIT 25 ; ","");
				break;
				case "allytag":
					$table 	= gettemplate('search/search_ally_table');
					$row 	= gettemplate('search/search_ally_row');
					$search	= doquery("SELECT a.* ,s.total_points as points FROM {{table}}alliance as a, {{table}}statpoints as s  WHERE a.id = s.id_owner && s.stat_type=2 && a.ally_tag LIKE '%".$searchtext."%' LIMIT 25 ; ","");
				break;
				case "allyname":
					$table 	= gettemplate('search/search_ally_table');
					$row 	= gettemplate('search/search_ally_row');
					$search = doquery("SELECT a.* ,s.total_points as points FROM {{table}}alliance as a, {{table}}statpoints as s  WHERE a.id = s.id_owner && s.stat_type=2 && a.ally_name LIKE '%".$searchtext."%' LIMIT 25 ; ","");
				break;
				default:
					$table 	= gettemplate('search/search_user_table');
					$row 	= gettemplate('search/search_user_row');
					$search = doquery("SELECT a.* ,s.total_rank as rank FROM {{table}}users as u, {{table}}statpoints as s  WHERE u.id = s.id_owner && s.stat_type=1 && u.username LIKE '%".$searchtext."%' LIMIT 25 ; ","");
				break;
			}
		}

		if (isset($searchtext) && isset($type))
		{
			while ($s = $search->fetch_array())
			{
				if ($type == 'playername' OR $type == 'planetname')
				{
					if ($s['ally_id']&& $s['ally_request'] == 0)
					{
						$aquery = doquery("SELECT id,ally_name FROM `{{table}}` WHERE id = ".intval($s['ally_id'])."","alliance",TRUE);
					}
					else
					{
						$aquery = array();
					}

					if ($type == "planetname")
					{
						$pquery 			= doquery("SELECT username,ally_id,ally_name FROM `{{table}}` WHERE id = ".intval($s['id_owner'])."","users",TRUE);
						$s['planet_name'] 	= $s['name'];
						$s['username'] 		= $pquery['username'];
						$s['ally_name'] 	= ($pquery['ally_name']!='') ?"<a href=\"game.php?page=alliance&mode=ainfo&a={$pquery['ally_id']}\">{$pquery['ally_name']}</a>":'';
					}
					else
					{
						$pquery 			= doquery("SELECT name FROM `{{table}}` WHERE id = ".intval($s['id_planet'])."","planets",TRUE);
						$s['planet_name']	= $pquery['name'];
						$s['ally_name'] 	= ($aquery['ally_name']!='') ?"<a href=\"game.php?page=alliance&mode=ainfo&a={$aquery['id']}\">{$aquery['ally_name']}</a>":'';
					}

					$s['position'] 		= "<a href=\"game.php?page=statistics&start=".$s['rank']."\">".$s['rank']."</a>";
					$s['dpath'] 		= DPATH;
					$s['coordinated'] 	= "{$s['galaxy']}:{$s['system']}:{$s['planet']}";
					$result_list 	   .= parsetemplate($row, $s);
				}
				elseif ($type=='allytag'OR$type=='allyname')
				{
					$s['ally_points'] = Format::pretty_number($s['ally_points']);

					$s['ally_tag'] = "<a href=\"game.php?page=alliance&mode=ainfo&a={$s['id']}\">{$s['ally_tag']}</a>";

					$result_list .= parsetemplate($row, $s);
				}
			}
			if ($result_list!='')
			{
				$parse['result_list'] = $result_list;
				$search_results = parsetemplate($table, $parse);
			}
		}

		$parse['type_playername'] 	= ($_POST["type"] == "playername") ? " SELECTED" : "";
		$parse['type_planetname'] 	= ($_POST["type"] == "planetname") ? " SELECTED" : "";
		$parse['type_allytag'] 		= ($_POST["type"] == "allytag") ? " SELECTED" : "";
		$parse['type_allyname'] 	= ($_POST["type"] == "allyname") ? " SELECTED" : "";
		$parse['searchtext'] 		= $searchtext;
		$parse['search_results'] 	= $search_results;

		display(parsetemplate(gettemplate('search/search_body'), $parse));
	}
}


/* End of file class.ShowSearchPage.php */
/* Location: ./includes/pages/class.ShowSearchPage.php */
