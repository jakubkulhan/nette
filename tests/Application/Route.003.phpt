<?php

/**
 * Test: Nette\Application\Route first optional parameter.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Application
 * @subpackage UnitTests
 */

use Nette\Application\Route;



require __DIR__ . '/../initialize.php';

require __DIR__ . '/Route.inc';



$route = new Route('<presenter>/<action>/<id \d{1,3}>', array(
	'presenter' => 'Default',
	'id' => NULL,
));

testRouteIn($route, '/presenter/action/12/any');

testRouteIn($route, '/presenter/action/12/');

testRouteIn($route, '/presenter/action/12');

testRouteIn($route, '/presenter/action/1234');

testRouteIn($route, '/presenter/action/');

testRouteIn($route, '/presenter/action');

testRouteIn($route, '/presenter/');

testRouteIn($route, '/presenter');

testRouteIn($route, '/');



__halt_compiler() ?>

------EXPECT------
==> /presenter/action/12/any

not matched

==> /presenter/action/12/

"Presenter"

array(
	"action" => "action"
	"id" => "12"
	"test" => "testvalue"
)

"/presenter/action/12?test=testvalue"

==> /presenter/action/12

"Presenter"

array(
	"action" => "action"
	"id" => "12"
	"test" => "testvalue"
)

"/presenter/action/12?test=testvalue"

==> /presenter/action/1234

not matched

==> /presenter/action/

"Presenter"

array(
	"action" => "action"
	"id" => NULL
	"test" => "testvalue"
)

"/presenter/action/?test=testvalue"

==> /presenter/action

"Presenter"

array(
	"action" => "action"
	"id" => NULL
	"test" => "testvalue"
)

"/presenter/action/?test=testvalue"

==> /presenter/

"Default"

array(
	"action" => "presenter"
	"id" => NULL
	"test" => "testvalue"
)

"/presenter/?test=testvalue"

==> /presenter

"Default"

array(
	"action" => "presenter"
	"id" => NULL
	"test" => "testvalue"
)

"/presenter/?test=testvalue"

==> /

not matched
