<?php

/**
 * Test: Nette\Debug notices and warnings in production mode.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette
 * @subpackage UnitTests
 */

use Nette\Debug;



require __DIR__ . '/../initialize.php';



Debug::$consoleMode = FALSE;
Debug::$productionMode = TRUE;

Debug::enable();

mktime(); // E_STRICT
mktime(0, 0, 0, 1, 23, 1978, 1); // E_DEPRECATED
$x++; // E_NOTICE
rename('..', '..'); // E_WARNING
require 'E_COMPILE_WARNING.inc'; // E_COMPILE_WARNING



__halt_compiler() ?>

------EXPECT------
