<?php
class MemberWallBookmarkWebService {

	const SERVICE_NAME_SPACE = "MemberWallBookmark";

	const SERVICE_GET_WALL_BOOKMARKS = "GetWallBookmarks";
	const SERVICE_ADD_WALL_BOOKMARK = "AddWallBookmark";
	const SERVICE_REMOVE_WALL_BOOKMARK = "RemoveWallBookmark";
	const SERVICE_IS_BOOKMARKED = "IsWallBookmarked";
	const SERVICE_GET_RECENT_WALL_ACTIVITY = "GetRecentWallActivity";

	/**
	 * @var Application
	 */
	protected $application;

	/**
	 * @var MemberWallBookmarkControl
	 */
	protected $memberWallBookmarkControl;

	public function __construct() {
		$this->application = CoreFactory::getApplication();
		$this->memberWallBookmarkControl = Factory::getMemberWallBookmarkControl();
	}

	public function handleRequest($method, array $postData = null, array $getData = null) {
		$response = new stdClass();
		$response->success = false;
		$response->errors = array();

		$getData["Token"] = $this->application->defaultValue($getData["Token"], null);
		$postData["Token"] = $this->application->defaultValue($postData["Token"], null);
		if ($getData["Token"]) {
			$postData["Token"] = $getData["Token"];
		}

		if ($memberDataEntity = TokenCheck::validateToken($postData["Token"], true)) {
			$member = $memberDataEntity->toObject();
			switch($method) {
				case self::SERVICE_GET_WALL_BOOKMARKS:
					$walls = $this->memberWallBookmarkControl->getWallBookmarksArray($member);
					if (is_array($walls)) {
						$response->walls = $walls;
						$response->success = true;
					}
					break;
				case self::SERVICE_ADD_WALL_BOOKMARK:
					$response->success = $this->memberWallBookmarkControl->addWallBookmark($member, $postData["WallSecureId"]);
					break;
				case self::SERVICE_REMOVE_WALL_BOOKMARK:
					$response->success = $this->memberWallBookmarkControl->removeWallBookmark($member, $postData["WallSecureId"]);
					break;
				case self::SERVICE_IS_BOOKMARKED:
					$response->success = $this->memberWallBookmarkControl->isWallBookmarked($member, $getData["WallSecureId"]);
					break;
				case self::SERVICE_GET_RECENT_WALL_ACTIVITY:
					$recentActivity = $this->memberWallBookmarkControl->getRecentWallActivity($memberDataEntity);
					if (is_object($recentActivity)) {
						$response->success = true;
						$response->recentActivity = $recentActivity;
					}
					break;
				default;
					$this->application->errorControl->getErrors("Member method \"$method\" unknown");
					break;
			}
		}

		$response->errors = $this->application->errorControl->getErrors();

		return $response;
	}
}