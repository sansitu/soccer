<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\TeamModel;
use App\Models\PlayerModel;
use App\Models\UserModel;

class DashboardModel extends Model
{
    /**
     * Used to get the total count of team & player available in the site
     *
     * @return array
     */
    public static function getDashboardContent()
    {
        $total_team = TeamModel::getTeamContent();
        $total_player = PlayerModel::getPlayerContent();

        $output = ["total_team" => $total_team['total_record'], "total_player" => $total_player['total_record']];

        return $output;
    }
}