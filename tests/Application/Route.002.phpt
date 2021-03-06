<?php

/**
 * Test: Nette\Application\Route default usage.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Application
 * @subpackage UnitTests
 */

use Nette\Application\Route;



require __DIR__ . '/../initialize.php';

require __DIR__ . '/Route.inc';



$route = new Route('index.php', array(
	'action' => 'default',
));

testRouteIn($route, '/index.php');

testRouteIn($route, '/');



__halt_compiler() ?>

------EXPECT------
==> /index.php

"querypresenter"

array(
	"action" => "default"
	"test" => "testvalue"
)

"/index.php?test=testvalue&presenter=querypresenter"

==> /

not matched
