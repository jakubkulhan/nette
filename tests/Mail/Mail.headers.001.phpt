<?php

/**
 * Test: Nette\Mail\Mail invalid headers.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Application
 * @subpackage UnitTests
 */

use Nette\Mail\Mail;



require __DIR__ . '/../initialize.php';

require __DIR__ . '/Mail.inc';



$mail = new Mail();

try {
	T::note();
	$mail->setHeader('', 'value');
} catch (Exception $e) {
	T::dump( $e );
}

try {
	T::note();
	$mail->setHeader(' name', 'value');
} catch (Exception $e) {
	T::dump( $e );
}

try {
	T::note();
	$mail->setHeader('n*ame', 'value');
} catch (Exception $e) {
	T::dump( $e );
}



__halt_compiler() ?>

------EXPECT------
===

Exception InvalidArgumentException: Header name must be non-empty alphanumeric string, '' given.

===

Exception InvalidArgumentException: Header name must be non-empty alphanumeric string, ' name' given.

===

Exception InvalidArgumentException: Header name must be non-empty alphanumeric string, 'n*ame' given.
