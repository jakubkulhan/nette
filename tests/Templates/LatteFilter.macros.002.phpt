<?php

/**
 * Test: Nette\Templates\LatteFilter and macros test.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Templates
 * @subpackage UnitTests
 * @keepTrailingSpaces
 */

use Nette\Environment,
	Nette\Templates\Template,
	Nette\Templates\LatteFilter;



require __DIR__ . '/../initialize.php';

require __DIR__ . '/Template.inc';



// temporary directory
define('TEMP_DIR', __DIR__ . '/tmp');
T::purge(TEMP_DIR);
Template::setCacheStorage(new MockCacheStorage(TEMP_DIR));
Environment::setVariable('tempDir', TEMP_DIR);



$template = new Template;
$template->setFile(__DIR__ . '/templates/latte.cache.phtml');
$template->registerFilter(new LatteFilter);
$template->registerHelperLoader('Nette\Templates\TemplateHelpers::loader');

$template->title = 'Hello';
$template->id = 456;

$template->render();



__halt_compiler() ?>
