<?php

/**
 * Test: Nette\Debug errors and shut-up operator.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette
 * @subpackage UnitTests
 */

use Nette\Debug;



require __DIR__ . '/../initialize.php';



Debug::$consoleMode = TRUE;
Debug::$productionMode = FALSE;

Debug::enable();

@missing_funcion();



__halt_compiler() ?>

------EXPECT------

Fatal error: Call to undefined function missing_funcion() in %a%
exception 'PhpException' with message 'Call to undefined function missing_funcion()' in %a%
Stack trace:
#0 [internal function]: %ns%Debug::_shutdownHandler()
#1 {main}
