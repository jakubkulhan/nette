<?php

/**
 * Test: Nette\Debug::dump() and recursive arrays.
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


$arr = array(1, 2, 3);
$arr[] = & $arr;
Debug::dump($arr);

$arr = array('x' => 1, 'y' => 2);
$arr[] = & $arr;
Debug::dump($arr);



__halt_compiler() ?>

------EXPECT------
array(4) [
   0 => 1
   1 => 2
   2 => 3
   3 => array(4) [
      0 => 1
      1 => 2
      2 => 3
      3 => array(5) [ *RECURSION* ]
   ]
]

array(3) {
   "x" => 1
   "y" => 2
   0 => array(3) {
      "x" => 1
      "y" => 2
      0 => array(4) { *RECURSION* }
   }
}
