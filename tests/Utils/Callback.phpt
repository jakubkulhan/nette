<?php

/**
 * Test: Nette\Callback tests.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette
 * @subpackage UnitTests
 */

use Nette\Callback;



require __DIR__ . '/../initialize.php';



class Test
{
	static function add($a, $b)
	{
		return $a + $b;
	}
}


T::dump( (string) new Callback(new Test, 'add') );

T::dump( (string) new Callback('Test', 'add') );

T::dump( (string) new Callback('Test::add') );

T::dump( (string) new Callback('undefined') );


$cb = new Callback(new Test, 'add');

T::dump( $cb/*5.2*->invoke*/(3, 5) );

T::dump( $cb->invokeArgs(array(3, 5)) );

T::dump( $cb->getNative() );

T::dump( $cb->isCallable() );

T::dump( callback($cb) );

try {
	callback('undefined')->invoke();
} catch (Exception $e) {
	T::dump( $e );
}

try {
	callback(NULL)->invoke();
} catch (Exception $e) {
	T::dump( $e );
}



__halt_compiler() ?>

------EXPECT------
"Test::add"

"Test::add"

"Test::add"

"undefined"

8

8

array(
	Test()
	"add"
)

TRUE

%ns%Callback(
	"cb" private => array(
		Test()
		"add"
	)
)

Exception InvalidStateException: Callback 'undefined' is not callable.

Exception InvalidArgumentException: Invalid callback.
