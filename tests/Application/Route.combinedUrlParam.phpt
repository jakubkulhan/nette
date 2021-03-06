<?php

/**
 * Test: Nette\Application\Route with CombinedUrlParam
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Application
 * @subpackage UnitTests
 */

use Nette\Application\Route;



require __DIR__ . '/../initialize.php';

require __DIR__ . '/Route.inc';



$route = new Route('extra<presenter>/<action>', array(
	'presenter' => 'Default',
	'action' => 'default',
));


testRouteIn($route, '/presenter/action/');

testRouteIn($route, '/extrapresenter/action/');

testRouteIn($route, '/extradefault/default/');

testRouteIn($route, '/extra');

testRouteIn($route, '/');



__halt_compiler() ?>

------EXPECT------
==> /presenter/action/

not matched

==> /extrapresenter/action/

"Presenter"

array(
	"action" => "action"
	"test" => "testvalue"
)

"/extrapresenter/action?test=testvalue"

==> /extradefault/default/

"Default"

array(
	"action" => "default"
	"test" => "testvalue"
)

"/extra?test=testvalue"

==> /extra

"Default"

array(
	"action" => "default"
	"test" => "testvalue"
)

"/extra?test=testvalue"

==> /

not matched
