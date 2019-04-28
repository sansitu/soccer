<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Config;
use App\Models\PlayerTeamModel;
use Illuminate\Support\Carbon;

class PlayerModel extends Model
{
	protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'photo', 'photo_url'
    ];

    /**
     * Used to get all the player info
     *
     * @return array
     */
    public static function getPlayerContent()
    {
        $result = self::all(Config::get('constants.PLAYERS_FETCHABLE_COLUMNS'));

        $output = ["status" => "Success", "player" => $result, "total_record" => count($result)];
        
        return $output;
    }

    /**
     * Search to get the player info
     *
     * @param string $search
     * @return array
     */
    public static function getSearchedPlayer($search)
    {
        $result = self::where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orderBy('first_name', 'desc')->get(Config::get('constants.PLAYERS_FETCHABLE_COLUMNS'));

        $output = ["status" => "Success", "player" => $result, "total_player" => count($result)];
        
        return $output;
    }

    /**
     * Used to insert or update the player info
     *
     * @param string $firstName
     * @param string $lastName
     * @param string $photoPath
     * @param int $playerId
     * @return array
     */
    public static function saveInfo($firstName, $lastName, $team, $photoName, $photoPath, $playerId = '')
    {
        if ($photoPath == '') {
            $data = ['first_name' => $firstName, 'last_name' => $lastName, 'updated_at' => now()];
        } else {
            $data = ['first_name' => $firstName, 'last_name' => $lastName, 'photo' => $photoName, 'photo_url' => $photoPath, 'created_at' => now(), 'updated_at' => now()];
        }

    	if ($playerId == '') {
    		
            $playerId = DB::table('players')->insertGetId($data);

            if (isset($team)) {
                PlayerTeamModel::saveInfo($playerId, $team);
            }

            $output = ["status" => "Success", "message" => 'Data has been saved'];
    	} else {
            DB::table('players')->where('id', '=', $playerId)
                              ->update($data);

            if (isset($team)) {
                PlayerTeamModel::saveInfo($playerId, $team);
            }
            
            $output = ["status" => "Success", "message" => 'Data has been updated'];
        }

        return json_encode($output);
    }

    /**
     * Used to delete the player info
     *
     * @param int $playerId
     * @return array
     */
    public static function deleteInfo($playerId)
    {
        $player = self::find($playerId);

        if (isset($player)) {

            $getFileName = $player->toArray();

            if (isset($getFileName['photo'])) {
                
                $file = Config::get('constants.PLAYER_PHOTO_UPLOAD_PATH').DIRECTORY_SEPARATOR.$getFileName['photo'];

                if (file_exists($file)) {
                    unlink($file);
                }
            }

            $player->delete();

            PlayerTeamModel::deleteInfo('player_id', $playerId);

            $output = ["status" => "Success", "message" => 'Data has been deleted'];
        } else {
            $output = ["status" => "Failed", "message" => 'Data not found for delete'];
        }

        return json_encode($output); 
    }

    /**
     * Used to fetch the player info for edit purpose
     *
     * @param int $playerId
     * @return array
     */
    public static function editInfo($playerId)
    {
        $player = self::find($playerId, Config::get('constants.PLAYERS_FETCHABLE_COLUMNS'));
       
        if (isset($player)) {
            $output = ["status" => "Success", "data" => $player];
        } else {
            $output = ["status" => "Fail", "message" => 'Data not found'];
        }

        return json_encode($output); 
    }

    /**
     * Used to get the player detail info including the team info
     *
     * @param int $playerId
     * @return array
     */
    public static function getPlayerDetail($playerId)
    {
        $player = DB::table('players')->where('id', $playerId)->get(Config::get('constants.PLAYERS_FETCHABLE_COLUMNS'));

        if (isset($player)) {

            $team = DB::table('player_team')
                ->rightJoin('players', 'players.id', '=', 'player_team.player_id')
                ->rightJoin('teams', 'teams.id', '=', 'player_team.team_id')                
                ->select('teams.*')
                ->where('player_team.player_id', '=', $playerId)
                ->get()->toArray();
        }

        $output = ["status" => "Success", "player" => $player, "total_player" => count($player), "team" => $team, "total_team" => count($team)];

        return $output;
    }
}