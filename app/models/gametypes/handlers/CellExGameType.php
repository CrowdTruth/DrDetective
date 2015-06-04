<?php
/**
 * GameTypeHandler for CellEx extraction GameType. 
 */
class CellExGameType extends GameTypeHandler {

	/**
	 * See GameTypeHandler
	 */
	public function getName() {
		return 'CellEx';
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function getDescription() {
		return 'Extracting cells from microscopic images';
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function getExtrasDiv($extraInfo) {
		$extraInfo = unserialize($extraInfo);
		$label = $extraInfo['label'];
		$divHTML = "";
		$divHTML .= "<label for='data' class='col-sm-2 control-label'>Label:</label>";
		$divHTML .= "<input class='form-control' name='cellExLabel' type='text' value='".$label."' id='cellExLabel'>";
		$divHTML .= "";
		return $divHTML;
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function parseExtraInfo($inputs) {
		serialize([ 'label' => $inputs['cellExLabel'] ]);
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function getThumbnail() {
		return 'img/factor_validation1.png';
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function getView($game) {
		$tasks = $game->tasks;
		$userId = Auth::user()->get()->id;
		// Which image to use ?
		// Select image with minimum number of judgements from current user
		$image = null;
		$taskId = null;
		$minJudgementCounts = -1;
		foreach ($tasks as $task) {
			$nJudgements = Judgement::where('task_id','=',$task->id)
									->where('user_id','=',$userId)->count();
			if($nJudgements<$minJudgementCounts || $image==null) {
				$minJudgementCounts = $nJudgements;
				$image = $task->data;
				$taskId = $task->id;
			}
		}
		$extraInfo = unserialize($game['extraInfo']);
		$responseLabel[0] = $extraInfo['label'];
		$responseLabel[1] = $extraInfo['label1'];
		$responseLabel[2] = $extraInfo['label2'];
		$responseLabel[3] = $extraInfo['label3'];
		$responseLabel[4] = $extraInfo['label4'];
		$responseLabel[5] = $extraInfo['label5'];
		
		return View::make('cellex')
			->with('gameId', $game->id)
			->with('taskId', $taskId)
			->with('instructions', $game->instructions)
			->with('image', $image)
			->with('responseLabel', $responseLabel);
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function processResponse($game,$campaignId) {	
		//Put the post data into php variables
		$userId = Auth::user()->get()->id;
		$taskId = Input::get('taskId');
		$markingDescription = Input::get('markingDescription');
		$otherExpand = Input::get('otherExpand');
		$totalCells = Input::get('totalCells');
		$qualityDescription = Input::get('qualityDescription');
		$comments = Input::get('comments');
		$comment = Input::get('comment');
		
		$responseArray["markingDescription"] = $markingDescription;
		$responseArray["otherExpand"] = $otherExpand;
		$responseArray["totalCells"] = $totalCells;
		$responseArray["qualityDescription"] = $qualityDescription;
		$responseArray["comments"] = $comments;
		$responseArray["comment"] = $comment;
		
		$tempCoords = json_decode(Input::get('response'));
		$responseArray["Coordinates"] = $tempCoords;
		$response = $this->encodeJudgement($responseArray);
		
		//Create and Submit the judgement model
		$judgement = new Judgement();
		$judgement->user_id = $userId;
		$judgement->task_id = $taskId;
		$judgement->game_id = $game->id;
		$judgement->campaign_id = $campaignId;
		$judgement->response = $response;
		$judgement->save();
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function addUserGameScore($game) {
		//first, add the score to this user's score column in the database
		$user = User::find(Auth::user()->get()->id);
		$oldUserScore = $user->score;
		$user->score = ($game->score + $oldUserScore);
		$user->save();
		
		//then, create a new entry in the "scores" table in the database
		$score = new Score();
		$score->user_id = $user->id;
		$score->game_id = $game->id;
		$score->campaign_id = null;
		$score->score_gained = $game->score;
		$score->save();
		
		//check the level of the user and see if it needs to be higher
		//what is the max score for the level of this user
		$maxScoreForThisLevel = Level::where('level',$user->level)->first(['max_score'])['max_score'];
		if($user->score > $maxScoreForThisLevel){
			//if it does need to be higher, up the user's level
			$user->level = $user->level+1;
			$user->save();
		}
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function encodeJudgement($judgement) {
		return serialize($judgement);
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function decodeJudgement($judgementStr) {
		return unserialize($judgementStr);
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function renderGame($game) {
		return $game->data;
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function validateData($data) {
		return true;
	}
}
