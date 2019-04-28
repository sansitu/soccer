<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\PlayerModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Validator;
use Library\Utilities;
use Config;

class PlayerController extends Controller
{
    private $request;

    private $url;
    
    public function __construct(Request $request, UrlGenerator $url) {
        $this->request = $request;
        $this->url = $url;
    }
	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('player');
    }

     /**
     * Used to get all the player info
     *
     * @return array
     */
	public function getPlayerContent()
    {
        $content = PlayerModel::getPlayerContent();
        return Utilities::sendResponse($content, '200');
    }

    /**
     * Search to get the player info
     *
     * @param string $search
     * @return array
     */
    public function getSearchedPlayer($search)
    {
    	$content = PlayerModel::getSearchedPlayer($search);
        return Utilities::sendResponse($content, '200');
    }

    /**
     * Used to insert or update the team info
     *
     * @return array
     */
	public function savePlayer()
	{
		$playerId = $this->request->input('playerId');
		$firstName = $this->request->input('firstName');
        $lastName = $this->request->input('lastName');
		$photo = $this->request->file('photo');
        $team = $this->request->input('team');
		$photoPath = '';
		$message = '';
        $photoName = '';

		$hasError = Utilities::validateText($firstName, $message);

		if ($hasError) {
            $output = ["status" => "Failed", "message" => $message];
			return Utilities::sendResponse($output, '422');
		}

		$hasError = Utilities::validateText($lastName, $message);

		if ($hasError) {
            $output = ["status" => "Failed", "message" => $message];
			return Utilities::sendResponse($output, '422');
		}

        $hasError = Utilities::checkArrayValuesAsNumeric($team, $message);
        if ($hasError) {
            $output = ["status" => "Failed", "message" => $message];
            return Utilities::sendResponse($output, '422');
        }

		if (isset($photo)) {

			$hasError = Utilities::validateFile($photo, $message);

			if ($hasError) {
                $output = ["status" => "Failed", "message" => $message];
				return Utilities::sendResponse($output, '422');
			}
		
			$photoOriginalName = $photo->getClientOriginalName();
			$photoOriginalExtension = $photo->getClientOriginalExtension();

			$photoName = Utilities::generateFileName('Player', $photoOriginalExtension);

			$photo->move(Config::get('constants.PLAYER_PHOTO_UPLOAD_PATH'), $photoName);

			$photoPath = $this->url->to('/') . Config::get('constants.PLAYER_PHOTO_PATH') . $photoName;
		}
		
		$content = PlayerModel::saveInfo($firstName, $lastName, $team, $photoName, $photoPath, $playerId);
        
        if (json_decode($content)->status == "Success") {
            return Utilities::sendResponse($content, '200');
        } else {
            return Utilities::sendResponse($content, '404');
        }
	}
	
	/**
     * Used to fetch the player info for edit purpose
     *
     * @param int $playerId
     * @return array
     */
	public function editPlayer($playerId)
	{
		$content = PlayerModel::editInfo($playerId);
		
		if (json_decode($content)->status == "Success") {
            return Utilities::sendResponse($content, '200');
        } else {
            return Utilities::sendResponse($content, '404');
        }
	}
	
	/**
     * Used to delete the player info
     *
     * @param int $playerId
     * @return array
     */
	public function deletePlayer($playerId)
	{
		$content = PlayerModel::deleteInfo($playerId);
        
        if (json_decode($content)->status == "Success") {
            return Utilities::sendResponse($content, '200');
        } else {
            return Utilities::sendResponse($content, '404');
        }
	}

    /**
     * Used to get the player detail info including the teams info
     *
     * @param int $playerId
     * @return array
     */
    public function getPlayerDetail($playerId)
    {
        $content = PlayerModel::getPlayerDetail($playerId);
        
        return Utilities::sendResponse($content, '200');
    }
}
