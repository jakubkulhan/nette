<?php

/**
 * Test: Nette\Caching\FileStorage constant dependency test (continue...).
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


$cache = new Cache(new Nette\Caching\FileStorage(TEMP_DIR));


// Deleting dependent const

Assert::false( isset($cache[$key]), 'Is cached?' );
