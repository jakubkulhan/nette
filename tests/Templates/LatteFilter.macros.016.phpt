<?php

/**
 * Test: Nette\Templates\LatteFilter and macros test.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Templates
 * @subpackage UnitTests
 */

use Nette\Templates\Template,
	Nette\Templates\LatteFilter;



require __DIR__ . '/../initialize.php';

require __DIR__ . '/Template.inc';



$template = new MockTemplate;
$template->registerFilter(new LatteFilter);
$template->render(T::getSection(__FILE__, 'template'));
echo $template->compiled;



__halt_compiler() ?>

-----template-----
{* k�d  *}

@{if TRUE}
		{* k�d  *}
@{else}
		{* k�d  *}
@{/if}

{* k�d  *}

------EXPECT------

<?php
%A%

if (%ns%SnippetHelper::$outputAllowed) {
} if (TRUE): if (%ns%SnippetHelper::$outputAllowed) { ?>
		<?php } ;else: if (%ns%SnippetHelper::$outputAllowed) { ?>
		<?php } endif ;if (%ns%SnippetHelper::$outputAllowed) { ?>

<?php
}
