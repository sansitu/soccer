<?php

namespace App\Http\Controllers\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\TeamModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Validator;
use Library\Utilities;
use Config;

class TeamController extends Controller
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
        return view('team');
    }

    /**
     * Used to get all the team info
     *
     * @return array
     */
    public function getTeamContent()
    {
        $content = TeamModel::getTeamContent();
        return Utilities::sendResponse($content, '200');
    }

    /**
     * Search to get the team info
     *
     * @param string $search
     * @return array
     */
    public function getSearchedTeam($search)
    {
        $content = TeamModel::getSearchedTeam($search);
        return Utilities::sendResponse($content, '200');
    }

    /**
     * Used to insert or update the team info
     *
     * @return array
     */
	public function saveTeam()
	{
		$teamId = $this->request->input('teamId');
        $teamName = $this->request->input('teamName');
		$teamLogo = $this->request->file('teamLogo');
		$logoPath = '';
		$message = '';
        $teamLogoName = '';

        $hasError = Utilities::validateText($teamName, $message);

		if ($hasError) {
			return Utilities::sendResponse($message, '422');
		}

		if (isset($teamLogo)) {

			$hasError = Utilities::validateFile($teamLogo, $message);

			if ($hasError) {
				return Utilities::sendResponse($message, '422');
			}

			$teamLogoOriginalName = $teamLogo->getClientOriginalName();
			$teamLogoOriginalExtension = $teamLogo->getClientOriginalExtension();

            $teamLogoName = Utilities::generateFileName('Team', $teamLogoOriginalExtension);

			$teamLogo->move(Config::get('constants.TEAM_LOGO_UPLOAD_PATH'), $teamLogoName);

			$logoPath = $this->url->to('/') . Config::get('constants.TEAM_LOGO_PATH') . $teamLogoName;
		}
		
		$content = TeamModel::saveInfo($teamName, $teamLogoName, $logoPath, $teamId);
        
        if (json_decode($content)->status == "Success") {
            return Utilities::sendResponse($content, '200');
        } else {
            return Utilities::sendResponse($content, '404');
        }
	}
	
	/**
     * Used to fetch the team info for edit purpose
     *
     * @param int $teamId
     * @return array
     */
	public function editTeam($teamId)
	{
		$content = TeamModel::editInfo($teamId);
		
		if (json_decode($content)->status == "Success") {
            return Utilities::sendResponse($content, '200');
        } else {
            return Utilities::sendResponse($content, '404');
        }
	}
	
	/**
     * Used to delete the team info
     *
     * @param int $teamId
     * @return array
     */
	public function deleteTeam($teamId)
	{
		$content = TeamModel::deleteInfo($teamId);
        
        if (json_decode($content)->status == "Success") {
            return Utilities::sendResponse($content, '200');
        } else {
            return Utilities::sendResponse($content, '404');
        }
	}

    /**
     * Used to get the team detail info including the players info
     *
     * @param int $teamId
     * @return array
     */
    public function getTeamDetail($teamId)
    {
        $content = TeamModel::getTeamDetail($teamId);
        
        return Utilities::sendResponse($content, '200');
    }
}
