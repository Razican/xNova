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

function HandleElementBuildingQueue ($CurrentUser, &$CurrentPlanet, $ProductionTime)
{
	global $resource;

	if ($CurrentPlanet['b_hangar_id'])
	{
		$Builded                    = array();
		$CurrentPlanet['b_hangar'] += $ProductionTime;
		$BuildQueue                 = explode(';', $CurrentPlanet['b_hangar_id']);
		$BuildArray					= array();

		foreach ($BuildQueue as $Node => $Array)
		{
			if ($Array != '')
			{
				$Item              = explode(',', $Array);
				$AcumTime		   = GetBuildingtime($CurrentUser, $CurrentPlanet, $Item[0]);
				$BuildArray[$Node] = array($Item[0], $Item[1], $AcumTime);
			}
		}

		$CurrentPlanet['b_hangar_id'] 	= '';
		$UnFinished 					= FALSE;

		foreach ($BuildArray as $Node => $Item)
		{
			$Element   			= $Item[0];
			$Count     			= $Item[1];
			$BuildTime 			= $Item[2];
			$Builded[$Element] 	= 0;

			if ( ! $UnFinished and $BuildTime > 0)
			{
				$AllTime = $BuildTime * $Count;

				if ($CurrentPlanet['b_hangar'] >= $BuildTime)
				{
					$Done = min($Count, floor($CurrentPlanet['b_hangar'] / $BuildTime));

					if ($Count > $Done)
					{
						$CurrentPlanet['b_hangar'] -= $BuildTime * $Done;
						$UnFinished = TRUE;
						$Count -= $Done;
					}
					else
					{
						$CurrentPlanet['b_hangar'] -= $AllTime;
						$Count = 0;
					}

					$Builded[$Element] += $Done;
					$CurrentPlanet[$resource[$Element]] += $Done;

				}
				else
				{
					$UnFinished = TRUE;
				}
			}
			elseif ( ! $UnFinished)
			{
				$Builded[$Element] += $Count;
				$CurrentPlanet[$resource[$Element]] += $Count;
				$Count = 0;
			}

			if ($Count)
			{
				$CurrentPlanet['b_hangar_id'] .= $Element.",".$Count.";";
			}
		}
	}
	else
	{
		$Builded                   = '';
		$CurrentPlanet['b_hangar'] = 0;
	}

	return $Builded;
}
?>