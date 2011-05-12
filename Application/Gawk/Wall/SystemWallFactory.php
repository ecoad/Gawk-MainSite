<?php
class SystemWallFactory {
	/**
	 * @return Wall
	 */
	public function getMainWall() {
		$wall = Factory::getWall();
		$wall->description = <<<DESCR
This is the main wall, where highly rated Gawks appear from other walls. Visit another wall or create your own.
DESCR;
		$wall->url = "/";
		$wall->name = "Main Wall";
		$wall->secureId = "main-wall";
		return $wall;
	}

	/**
	 * @return Wall
	 */
	public function getFriendsWall() {
		$wall = Factory::getWall();
		$wall->description = <<<DESCR
This is the wall of your friends. Their Gawks from other walls will appear on here.
DESCR;
		$wall->url = "/friends";
		$wall->name = "Your friends";
		$wall->secureId = "friends";
		return $wall;
	}

	/**
	 * @return Wall
	 */
	public function getFavouriteGawksWall() {
		$wall = Factory::getWall();
		$wall->description = <<<DESCR
This is the wall of your favourite Gawks
DESCR;
		$wall->url = "/favourite-gawks";
		$wall->name = "Favourite Gawks";
		$wall->secureId = "favourite-gawks";
		return $wall;
	}

	/**
	 * @return Wall
	 */
	public function getProfileRecentWall() {
		$wall = Factory::getWall();
		$wall->secureId = "profile-recent";
		return $wall;
	}

	/**
	 * @return Wall
	 */
	public function getProfileGawkWall() {
		$wall = Factory::getWall();
		$wall->secureId = "profile-gawk";
		return $wall;
	}
}