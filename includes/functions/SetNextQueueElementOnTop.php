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

	function SetNextQueueElementOnTop(&$CurrentPlanet, $CurrentUser)
	{
		global $lang, $resource;

		if ($CurrentPlanet['b_building'] == 0)
		{
			$CurrentQueue  = $CurrentPlanet['b_building_id'];
			if ($CurrentQueue)
			{
				$QueueArray = explode(";", $CurrentQueue);
				$Loop       = TRUE;
				while ($Loop)
				{
					$ListIDArray         = explode(",", $QueueArray[0]);
					$Element             = $ListIDArray[0];
					$Level               = $ListIDArray[1];
					$BuildTime           = $ListIDArray[2];
					$BuildEndTime        = $ListIDArray[3];
					$BuildMode           = $ListIDArray[4];
					$HaveNoMoreLevel     = FALSE;

					if ($BuildMode == 'destroy')
						$ForDestroy = TRUE;
					else
						$ForDestroy = FALSE;

					$HaveRessources = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, TRUE, $ForDestroy);
					if ($ForDestroy)
					{
						if ($CurrentPlanet[$resource[$Element]] == 0)
						{
							$HaveRessources  = FALSE;
							$HaveNoMoreLevel = TRUE;
						}
					}

					if ($HaveRessources)
					{
						$Needed                        = GetBuildingPrice($CurrentUser, $CurrentPlanet, $Element, TRUE, $ForDestroy);
						$CurrentPlanet['metal']       -= $Needed['metal'];
						$CurrentPlanet['crystal']     -= $Needed['crystal'];
						$CurrentPlanet['deuterium']   -= $Needed['deuterium'];
						$CurrentTime                   = time();
						$BuildEndTime                  = $BuildEndTime;
						$NewQueue                      = implode(";", $QueueArray);

						if ($NewQueue == "")
							$NewQueue                  = '0';

						$Loop                          = FALSE;
					}
					else
					{
						$ElementName = $lang['tech'][$Element];

						if ($HaveNoMoreLevel)
							$Message     = sprintf($lang['sys_nomore_level'], $ElementName);
						else
						{
							$Needed      = GetBuildingPrice($CurrentUser, $CurrentPlanet, $Element, TRUE, $ForDestroy);
							$Message     = sprintf($lang['sys_notenough_money'], $ElementName,
							Format::pretty_number($CurrentPlanet['metal']), $lang['Metal'],
							Format::pretty_number($CurrentPlanet['crystal']), $lang['Crystal'],
							Format::pretty_number($CurrentPlanet['deuterium']), $lang['Deuterium'],
							Format::pretty_number($Needed['metal']), $lang['Metal'],
							Format::pretty_number($Needed['crystal']), $lang['Crystal'],
							Format::pretty_number($Needed['deuterium']), $lang['Deuterium']);
						}

						SendSimpleMessage($CurrentUser['id'], '', '', 99, $lang['sys_buildlist'], $lang['sys_buildlist_fail'], $Message);

						array_shift($QueueArray);

						foreach ($QueueArray as $num => $info)
						{
							$fixEle				= explode(",", $info);
							$fixEle[3]			= $fixEle[3] - $BuildTime;
							$QueueArray[$num]	= implode(",", $fixEle);
						}

						$ActualCount         = count($QueueArray);
						if ($ActualCount === 0)
						{
							$BuildEndTime  = '0';
							$NewQueue      = '0';
							$Loop          = FALSE;
						}
					}
				}
			}
			else
			{
				$BuildEndTime  = '0';
				$NewQueue      = '0';
			}

			$CurrentPlanet['b_building']    = $BuildEndTime;
			$CurrentPlanet['b_building_id'] = $NewQueue;

			$QryUpdatePlanet  = "UPDATE `{{table}}` SET ";
			$QryUpdatePlanet .= "`metal` = '".        $CurrentPlanet['metal']        ."', ";
			$QryUpdatePlanet .= "`crystal` = '".      $CurrentPlanet['crystal']      ."', ";
			$QryUpdatePlanet .= "`deuterium` = '".    $CurrentPlanet['deuterium']    ."', ";
			$QryUpdatePlanet .= "`b_building` = '".   $CurrentPlanet['b_building']   ."', ";
			$QryUpdatePlanet .= "`b_building_id` = '".$CurrentPlanet['b_building_id']."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '".           $CurrentPlanet['id']          ."';";
			doquery($QryUpdatePlanet, 'planets');
		}
		return;
	}
?>