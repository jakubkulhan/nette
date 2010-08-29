<?php

/**
 * Test: Nette\Caching\FileStorage sliding expiration test.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Caching
 * @subpackage UnitTests
 */

use Nette\Caching\Cache;



require __DIR__ . '/../initialize.php';



$key = 'nette';
$value = 'rulez';

// temporary directory
define('TEMP_DIR', __DIR__ . '/' . rtrim(substr(basename(__FILE__), 0, -5), '0..9.') . '.tmp');
Nette\Environment::setVariable('tempDir', TEMP_DIR);
TestHelpers::purge(TEMP_DIR);


$cache = new Cache(new Nette\Caching\FileStorage(TEMP_DIR));


// Writing cache...
$cache->save($key, $value, array(
	Cache::EXPIRE => time() + 2,
	Cache::SLIDING => TRUE,
));


for($i = 0; $i < 3; $i++) {
	// Sleeping 1 second
	sleep(1);
	clearstatcache();
	$cache->release();
	Assert::true( isset($cache[$key]), 'Is cached?' );

}

// Sleeping few seconds...
sleep(3);
clearstatcache();
$cache->release();

Assert::false( isset($cache[$key]), 'Is cached?' );
