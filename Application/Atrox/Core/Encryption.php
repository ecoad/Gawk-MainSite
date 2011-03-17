<?php
/**
 * @package Core
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 */

/**
 * Encrypts/Decrypts data 
 * @author Paul Serby {@link mailto:paul.serby@clock.co.uk paul.serby@clock.co.uk }
 * @copyright Clock Limited 2010
 * @version 3.2 - $Revision: 1329 $ - $Date: 2010-02-24 22:41:33 +0000 (Wed, 24 Feb 2010) $
 * @package Core
 */
class EncryptionControl {
	
	
	function encrypt($key, $input) {
		$td = mcrypt_module_open("tripledes", "", "ecb", "");
		$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$encrypted_data = mdecrypt_generic($td, $input);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);	
		return $encrypted_data;	
	}

	function decrypt($key, $input) {
		$td = mcrypt_module_open("tripledes", "", "ecb", "");
		$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$decrypted_data = mdecrypt_generic($td, $input);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return $decrypted_data;
	}		
}