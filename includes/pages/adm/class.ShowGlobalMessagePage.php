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

class ShowGlobalMessagePage {

	public function __construct()
	{
		global $lang;

		if ( ! ADM_TOOLS) die(message($lang['404_page']));

			$parse 	= $lang;

			if ($_POST && $_GET['mode'] == "change")
			{
				if (AUTHLEVEL == 3)
				{
					$kolor = 'red';
					$ranga = $lang['user_level'][3];
				}

				elseif (AUTHLEVEL == 2)
				{
					$kolor = 'skyblue';
					$ranga = $lang['user_level'][2];
				}

				elseif (AUTHLEVEL == 1)
				{
					$kolor = 'yellow';
					$ranga = $lang['user_level'][1];
				}
				if ((isset($_POST["tresc"]) && $_POST["tresc"] != '') && (isset($_POST["temat"]) && $_POST["temat"] != ''))
				{
					$sq      	= doquery("SELECT `id`,`username` FROM {{table}}", "users");
					$Time    	= time();
					$From    	= "<font color=\"".$kolor."\">".$ranga." ".$user['username']."</font>";
					$Subject 	= "<font color=\"".$kolor."\">".$_POST['temat']."</font>";
					$Message 	= "<font color=\"".$kolor."\"><b>".$_POST['tresc']."</b></font>";
					$summery	= 0;

					while ($u = $sq->fetch_array())
					{
						SendSimpleMessage($u['id'], $user['id'], $Time, 1, $From, $Subject, $Message);
						$_POST['tresc'] = str_replace(":name:", $u['username'], $_POST['tresc']);
					}


					$Log	.=	"\n".$lang['log_circular_message']."\n";
					$Log	.=	$lang['log_the_user'].$user['username'].$lang['log_message_specify'].":\n";
					$Log	.=	$lang['log_mes_subject'].": ".$_POST["temat"]."\n";
					$Log	.=	$lang['log_mes_text'].": ".$_POST["tresc"]."\n";

					LogFunction($Log, "general");

					$parse['display']	=	"<tr><th colspan=5><font color=lime>".$lang['ma_message_sended']."</font></th></tr>";
				}
				else
				{
					$parse['display']	=	"<tr><th colspan=5><font color=red>".$lang['ma_subject_needed']."</font></th></tr>";
				}
			}


		display(parsetemplate(gettemplate('adm/GlobalMessageBody'), $parse), TRUE, '', TRUE);
	}
}


/* End of file class.ShowGlobalMessagePage.php */
/* Location: ./includes/pages/adm/class.ShowLogsPage.php */