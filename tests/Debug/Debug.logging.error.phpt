<?php

/**
 * Test: Nette\Debug error logging.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette
 * @subpackage UnitTests
 */

use Nette\Debug;



require __DIR__ . '/../initialize.php';



// Setup environment
$_SERVER['HTTP_HOST'] = 'nette.org';

$errorLog = __DIR__ . '/log/error/php_error.log';
TestHelpers::purge(dirname($errorLog));

Debug::$consoleMode = FALSE;
Debug::$mailer = 'testMailer';

Debug::enable(Debug::PRODUCTION, $errorLog, 'admin@example.com');

function testMailer() {}

function shutdown() {
	global $errorLog;
	Assert::match('%a%PHP Fatal error: Uncaught exception FatalErrorException with message \'Call to undefined function missing_funcion()\' in %a%', file_get_contents(dirname($errorLog) . '/php_error.log'));
	Assert::true(is_file(dirname($errorLog) . '/php_error.log.email-sent'));
	die(0);
}
Assert::handler('shutdown');



missing_funcion();
