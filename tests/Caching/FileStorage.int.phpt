<?php

/**
 * Test: Nette\Caching\FileStorage int keys.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Caching
 * @subpackage UnitTests
 */

use Nette\Caching\Cache;



require __DIR__ . '/../initialize.php';



// key and data with special chars
$key = 0;
$value = range("\x00", "\xFF");

// temporary directory
define('TEMP_DIR', __DIR__ . '/' . rtrim(substr(basename(__FILE__), 0, -5), '0..9.') . '.tmp');
Nette\Environment::setVariable('tempDir', TEMP_DIR);
TestHelpers::purge(TEMP_DIR);



$cache = new Cache(new Nette\Caching\FileStorage(TEMP_DIR));

Assert::false( isset($cache[$key]), 'Is cached?' );

Assert::null( $cache[$key], 'Cache content' );


// Writing cache...
$cache[$key] = $value;
$cache->release();

Assert::true( isset($cache[$key]), 'Is cached?' );

Assert::true( $cache[$key] === $value, 'Is cache ok?' );


// Removing from cache using unset()...
unset($cache[$key]);
$cache->release();

Assert::false( isset($cache[$key]), 'Is cached?' );


// Removing from cache using set NULL...
$cache[$key] = $value;
$cache[$key] = NULL;
$cache->release();

Assert::false( isset($cache[$key]), 'Is cached?' );
