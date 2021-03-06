<?php

/**
 * Test: Nette\Forms and Html.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Forms
 * @subpackage UnitTests
 */

use Nette\Forms\Form,
	Nette\Web\Html;



require __DIR__ . '/../initialize.php';



$form = new Form;
$form->addText('input', Html::el('b')->setText('Strong text.'));
echo $form;


__halt_compiler() ?>

------EXPECT------
%A%
	<th><label for="frm-input"><b>Strong text.</b></label></th>
%A%
