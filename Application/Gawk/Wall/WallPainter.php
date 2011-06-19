<?php
class WallPainter {

	/**
	 * @var Wall
	 */
	protected $wall;

	public function __construct(Wall $wall) {

		$this->wall = $wall;
	}

	public function getBackgroundStyle() {
		if ($this->wall->secureId == "gawk") {
			return "background: url('/resource/image/fowd/background.jpg')";
		}

		return "";
	}

	public function getLogo() {
		if ($this->wall->secureId == "gawk") {
			return "<img src='/resource/image/fowd/logo.png'/>";
		}

		return "";
	}

	public function hasLogo() {
		if ($this->wall->secureId == "gawk") {
			return true;
		}

		return false;
	}
}