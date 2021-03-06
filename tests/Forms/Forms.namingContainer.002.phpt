<?php

/**
 * Test: Nette\Forms naming container.
 *
 * @author     David Grudl
 * @category   Nette
 * @package    Nette\Forms
 * @subpackage UnitTests
 */

use Nette\ComponentContainer,
	Nette\Forms\Form,
	Nette\Forms\TextInput,
	Nette\Forms\FormContainer;



require __DIR__ . '/../initialize.php';



$form = new Form();
$form->addText('name', 'Your name:', 35);

$sub = new ComponentContainer($form, 'container');
$sub->addComponent(new TextInput('First line'), 'text1');
$sub->addComponent(new TextInput('Second line'), 'text2');
$sub->addComponent($sub2 = new FormContainer, 'formCont');
	$sub2->addText('name', 'Your name:', 35);
	$sub2->addText('age', 'Your age:', 5);

$sub = $form->addContainer('firstperson');
$sub->addText('name', 'Your name:', 35);
$sub->addText('age', 'Your age:', 5);

$sub = $form->addContainer('secondperson');
$sub->addText('name', 'Your name:', 35);
$sub->addText('age', 'Your age:', 5);
$sub->addFile('avatar', 'Picture:');

$form->addText('age', 'Your age:', 5);

$form->addSubmit('submit1', 'Send');

$form->setDefaults(array(
	'name' => 'jim',
	'text1' => 'hello',
	'text2' => 'world',
	'formCont' =>
	array(
		'name' => 'jack',
		'age' => '23',
	),
	'firstperson' =>
	array(
		'name' => 'david',
		'age' => '30',
	),
	'secondperson' =>
	array(
		'name' => 'jim',
		'age' => '40',
	),
	'age' => '50',
));

T::dump( $form->getValues() );



__halt_compiler() ?>

------EXPECT------
array(
	"name" => "jim"
	"text1" => "hello"
	"text2" => "world"
	"formCont" => array(
		"name" => "jack"
		"age" => "23"
	)
	"firstperson" => array(
		"name" => "david"
		"age" => "30"
	)
	"secondperson" => array(
		"name" => "jim"
		"age" => "40"
		"avatar" => NULL
	)
	"age" => "50"
)
