<?php

/**
 * Test: Nette\Application\Route with "required" optional sequences II.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Application
 * @subpackage UnitTests
 */

use Nette\Application\Route;



require __DIR__ . '/../initialize.php';

require __DIR__ . '/Route.inc';


$route = new Route('[<lang [a-z]{2}>[!-<sub>]/]<name>[/page-<page>]', array(
	'sub' => 'cz',
));

testRouteIn($route, '/cs-cz/name');

testRouteIn($route, '/cs-xx/name');

testRouteIn($route, '/name');



__halt_compiler() ?>

------EXPECT------
==> /cs-cz/name

"querypresenter"

array(
	"lang" => "cs"
	"sub" => "cz"
	"name" => "name"
	"page" => NULL
	"test" => "testvalue"
)

"/cs-cz/name?test=testvalue&presenter=querypresenter"

==> /cs-xx/name

"querypresenter"

array(
	"lang" => "cs"
	"sub" => "xx"
	"name" => "name"
	"page" => NULL
	"test" => "testvalue"
)

"/cs-xx/name?test=testvalue&presenter=querypresenter"

==> /name

"querypresenter"

array(
	"name" => "name"
	"sub" => "cz"
	"page" => NULL
	"lang" => NULL
	"test" => "testvalue"
)

"/name?test=testvalue&presenter=querypresenter"
