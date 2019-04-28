<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Carbon;

class TeamModel extends Model
{
	protected $table = 'teams';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'logo', 'logo_url'
    ];

    /**
     * Used to get all the team info
     *
     * @return array
     */
    public static function getTeamContent()
    {
        $result = self::all(Config::get('constants.TEAMS_FETCHABLE_COLUMNS'));

        $output = ["status" => "Success", "team" => $result, "total_record" => count($result)];
        
        return $output;
    }

    /**
     * Search to get the team info
     *
     * @param string $search
     * @return array
     */
    public static function getSearchedTeam($search)
    {
        $result = self::where('name', 'like', '%'.$search.'%')->orderBy('name', 'desc')->get(Config::get('constants.TEAMS_FETCHABLE_COLUMNS'));

        $output = ["status" => "Success", "team" => $result, "total_team" => count($result)];
        
        return $output;
    }

    /**
     * Used to insert or update the team info
     *
     * @param string $teamName
     * @param string $logoPath
     * @param int $teamId
     * @return array
     */
    public static function saveInfo($teamName, $teamLogoName = '', $logoPath = '', $teamId = '')
    {
        if ($logoPath == '') {
            $data = ['name' => $teamName, 'updated_at' => now()];
        } else {
    	   $data = ['name' => $teamName, 'logo' => $teamLogoName, 'logo_url' => $logoPath, 'created_at' => now(),
                'updated_at' => now()];
        }

    	if ($teamId == '') {
    		
            $teamId = DB::table('teams')->insertGetId($data);

            $output = ["status" => "Success", "message" => 'Data has been saved'];
    	} else {
            DB::table('teams')->where('id', '=', $teamId)
                              ->update($data);
            
            $output = ["status" => "Success", "message" => 'Data has been updated'];
        }

        return json_encode($output);
    }

    /**
     * Used to delete the team info
     *
     * @param int $teamId
     * @return array
     */
    public static function deleteInfo($teamId)
    {
        $team = self::find($teamId);

        if (isset($team)) {

            $getFileName = $team->toArray();
            
            if (isset($getFileName['logo'])) {

                $file = Config::get('constants.TEAM_LOGO_UPLOAD_PATH').DIRECTORY_SEPARATOR.$getFileName['logo'];

                if (file_exists($file)) {
                    unlink($file);
                }
            }

            $team->delete();

            PlayerTeamModel::deleteInfo('team_id', $teamId);

            $output = ["status" => "Success", "message" => 'Data has been deleted'];
        } else {
            $output = ["status" => "Failed", "message" => 'Data not found for delete'];
        }

        return json_encode($output); 
    }

    /**
     * Used to fetch the team info for edit purpose
     *
     * @param int $teamId
     * @return array
     */
    public static function editInfo($teamId)
    {
        $team = self::find($teamId, Config::get('constants.TEAMS_FETCHABLE_COLUMNS'));

        if (isset($team)) {
            $output = ["status" => "Success", "data" => $team];
        } else {
            $output = ["status" => "Fail", "message" => 'Data not found'];
        }

        return json_encode($output); 
    }

    /**
     * Used to get the team detail info including the players info
     *
     * @param int $teamId
     * @return array
     */
    public static function getTeamDetail($teamId)
    {
        $team = DB::table('teams')->where('id', $teamId)->get(Config::get('constants.TEAMS_FETCHABLE_COLUMNS'));

        if (isset($team)) {

            $player = DB::table('player_team')
                ->rightJoin('teams', 'teams.id', '=', 'player_team.team_id')
                ->rightJoin('players', 'players.id', '=', 'player_team.player_id')
                ->select('players.*')
                ->where('player_team.team_id', '=', $teamId)
                ->get()->toArray();

        }

        $output = ["status" => "Success", "team" => $team, "total_team" => count($team), "player" => $player, "total_player" => count($player)];

        return $output;
    }
}