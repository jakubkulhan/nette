<?php

/**
 * Test: Nette\Object extension method.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette
 * @subpackage UnitTests
 */

use Nette\Object;



require __DIR__ . '/../initialize.php';

require __DIR__ . '/Object.inc';



function TestClass_join(TestClass $that, $separator)
{
	return $that->foo . $separator . $that->bar;
}

TestClass::extensionMethod('TestClass::join', 'TestClass_join');

$obj = new TestClass('Hello', 'World');
T::dump( $obj->join('*') );



__halt_compiler() ?>

------EXPECT------
"Hello*World"