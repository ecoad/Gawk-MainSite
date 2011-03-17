<?php
require_once("Application/Bootstrap.php");
$application->doNotStorePage();

$captcha = CoreFactory::getCaptcha();
$captchaImage = $captcha->generateCaptchaImage(200, 50);