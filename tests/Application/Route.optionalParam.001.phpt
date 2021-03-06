<?php

/**
 * Test: Nette\Application\Route with nested optional sequences.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Application
 * @subpackage UnitTests
 */

use Nette\Application\Route;



require __DIR__ . '/../initialize.php';

require __DIR__ . '/Route.inc';


$route = new Route('[<lang [a-z]{2}>[-<sub>]/]<name>[/page-<page>]', array(
	'sub' => 'cz',
));

testRouteIn($route, '/cs-cz/name');

testRouteIn($route, '/cs-xx/name');

testRouteIn($route, '/cs/name');

testRouteIn($route, '/name');

testRouteIn($route, '/name/page-0');

testRouteIn($route, '/name/page-');

testRouteIn($route, '/');



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

"/cs/name?test=testvalue&presenter=querypresenter"

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

==> /cs/name

"querypresenter"

array(
	"lang" => "cs"
	"name" => "name"
	"sub" => "cz"
	"page" => NULL
	"test" => "testvalue"
)

"/cs/name?test=testvalue&presenter=querypresenter"

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

==> /name/page-0

"querypresenter"

array(
	"name" => "name"
	"page" => "0"
	"sub" => "cz"
	"lang" => NULL
	"test" => "testvalue"
)

"/name/page-0?test=testvalue&presenter=querypresenter"

==> /name/page-

not matched

==> /

not matched
