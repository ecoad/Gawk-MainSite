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
		switch ($this->wall->secureId) {
			case "gawk":
				return "background: url('/resource/image/bespoke/fowd/background.jpg')";
			case "clock":
				return "background: url('/resource/image/bespoke/clock/background.jpg')";
		}

		return "";
	}

	public function getLogo() {
		switch ($this->wall->secureId) {
			case "gawk":
				return "<img src='/resource/image/bespoke/fowd/logo.png'/>";
			case "clock":
				return "<img src='/resource/image/bespoke/clock/logo.png'/>";
		}
		return "";
	}

	public function hasLogo() {
		switch ($this->wall->secureId) {
			case "gawk":
			case "clock":
				return true;
		}

		return false;
	}

	public function hasLink() {
		switch ($this->wall->secureId) {
			case "gawk":
			case "clock":
				return true;
		}

		return false;
	}

	public function getLink() {
		switch ($this->wall->secureId) {
			case "gawk":
				return "http://www.futureofwebdesign.com/";
			case "clock":
				return "http://www.clock.co.uk/";
		}

		return false;
	}
}