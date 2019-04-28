<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlayerTeamModel extends Model
{
	protected $table = 'player_team';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id', 'team_id'
    ];

	public static function saveInfo($playerId, $team)
    {
    	$teamIds = explode(",",$team);

    	self::deleteInfo('player_id', $playerId);

    	foreach ($teamIds as $teamId) {
			$playerTeam[] = [
				'player_id' => $playerId,
				'team_id' => $teamId
			];
		}

		self::insert($playerTeam);
    }

    public static function deleteInfo($column, $id)
    {
    	self::where($column, '=', $id)->delete();
    }
}