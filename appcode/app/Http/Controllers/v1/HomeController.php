<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlayerModel;
use App\Models\TeamModel;
use Library\Utilities;

class HomeController extends Controller
{
	/**
     * Used to get the info regarding player and team
     *
     * @return array
     */
    public function getSearchedInfo($slug)
    {
        $playerInfo = PlayerModel::getSearchedPlayer($slug);

        $teamInfo = TeamModel::getSearchedTeam($slug);

        $content = array_merge($playerInfo, $teamInfo);

        return Utilities::sendResponse(json_encode($content), '200');
    }
}
