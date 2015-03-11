<?php
/**
 * This GameTypeHandler does nothing -- this class is mean as an example to illustrate 				DUE FOR DELETION
 * how to develop your own GameTypeHandler.
 */
class DummyGameType extends GameTypeHandler {
	
	/**
	 * See GameTypeHandler
	 */
	public function getName() {
		return 'Dummy';
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function getDescription() {
		return 'Not a real task, just for devel debugging and stuff...';
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function getExtrasDiv($extraInfo) {
		return 'No DIV here, sorry :-P';
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function parseExtraInfo($inputs) {
		return 'Should return data ;-)';
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
		return View::make('dummygame')
			->with('instructions', $game->instructions)
			->with('gameId', $game->id);
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function processResponse($game) {
		return 'We should do something with your answer...<a href="/gameMenu">home</a>';
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function renderTask($task) {
		return $task->data;
	}
	
	/**
	 * See GameTypeHandler
	 */
	public function validateData($data) {
		return true;
	}
}
