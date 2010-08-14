<?php

/**
 * Nette\Forms custom rendering example.
 */


require_once '../../Nette/loader.php';

use Nette\Forms\Form,
	Nette\Debug,
	Nette\Web\Html;

Debug::enable();


$countries = array(
	'Select your country',
	'Europe' => array(
		'CZ' => 'Czech Republic',
		'SK' => 'Slovakia',
		'GB' => 'United Kingdom',
	),
	'CA' => 'Canada',
	'US' => 'United States',
	'?'  => 'other',
);

$sex = array(
	'm' => Html::el('option', 'male')->style('color: #248bd3'),
	'f' => Html::el('option', 'female')->style('color: #e948d4'),
);



// Step 1: Define form with validation rules
$form = new Form;
// setup custom rendering
$renderer = $form->getRenderer();
$renderer->wrappers['form']['container'] = Html::el('div')->id('form');
$renderer->wrappers['form']['errors'] = FALSE;
$renderer->wrappers['group']['container'] = NULL;
$renderer->wrappers['group']['label'] = 'h3';
$renderer->wrappers['pair']['container'] = NULL;
$renderer->wrappers['controls']['container'] = 'dl';
$renderer->wrappers['control']['container'] = 'dd';
$renderer->wrappers['control']['.odd'] = 'odd';
$renderer->wrappers['control']['errors'] = TRUE;
$renderer->wrappers['label']['container'] = 'dt';
$renderer->wrappers['label']['suffix'] = ':';
$renderer->wrappers['control']['requiredsuffix'] = " \xE2\x80\xA2";


// group Personal data
$form->addGroup('Personal data');
$form->addText('name', 'Your name')
	->addRule(Form::FILLED, 'Enter your name');

$form->addText('age', 'Your age')
	->addRule(Form::FILLED, 'Enter your age')
	->addRule(Form::INTEGER, 'Age must be numeric value')
	->addRule(Form::RANGE, 'Age must be in range from %d to %d', array(10, 100));

$form->addSelect('gender', 'Your gender', $sex);

$form->addText('email', 'E-mail')
	->setEmptyValue('@')
	->addCondition(Form::FILLED) // conditional rule: if is email filled, ...
		->addRule(Form::EMAIL, 'Incorrect E-mail Address'); // ... then check email


// group Shipping address
$form->addGroup('Shipping address')
	->setOption('embedNext', TRUE);

$form->addCheckbox('send', 'Ship to address')
	->addCondition(Form::EQUAL, TRUE) // conditional rule: if is checkbox checked...
		->toggle('sendBox'); // toggle div #sendBox


// subgroup
$form->addGroup()
	->setOption('container', Html::el('div')->id('sendBox'));

$form->addText('street', 'Street');

$form->addText('city', 'City')
	->addConditionOn($form['send'], Form::EQUAL, TRUE)
		->addRule(Form::FILLED, 'Enter your shipping address');

$form->addSelect('country', 'Country', $countries)
	->skipFirst()
	->addConditionOn($form['send'], Form::EQUAL, TRUE)
		->addRule(Form::FILLED, 'Select your country');


// group Your account
$form->addGroup('Your account');

$form->addPassword('password', 'Choose password')
	->addRule(Form::FILLED, 'Choose your password')
	->addRule(Form::MIN_LENGTH, 'The password is too short: it must be at least %d characters', 3)
	->setOption('description', '(at least 3 characters)');

$form->addPassword('password2', 'Reenter password')
	->addConditionOn($form['password'], Form::VALID)
		->addRule(Form::FILLED, 'Reenter your password')
		->addRule(Form::EQUAL, 'Passwords do not match', $form['password']);

$form->addFile('avatar', 'Picture');

$form->addHidden('userid');

$form->addTextArea('note', 'Comment');


// group for buttons
$form->addGroup();

$form->addSubmit('submit', 'Send');



// Step 2: Check if form was submitted?
if ($form->isSubmitted()) {

	// Step 2c: Check if form is valid
	if ($form->isValid()) {
		echo '<h2>Form was submitted and successfully validated</h2>';

		$values = $form->getValues();
		Debug::dump($values);

		// this is the end, my friend :-)
		if (empty($disableExit)) exit;
	}

} else {
	// not submitted, define default values
	$defaults = array(
		'name'    => 'John Doe',
		'userid'  => 231,
		'country' => 'CZ', // Czech Republic
	);

	$form->setDefaults($defaults);
}



// Step 3: Render form
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">

	<title>Nette\Forms custom rendering example | Nette Framework</title>

	<style type="text/css">
	body {
		font-family: "Trebuchet MS", "Geneva CE", lucida, sans-serif;
	}

	.required {
		font-weight: bold;
	}

	.error {
		color: red;
	}

	input.text {
		border: 1px solid #78bd3f;
		padding: 3px;
		color: black;
		background: white;
	}

	input.button {
		font-size: 120%;
	}

	dt, dd {
		padding: .5em 1em;
	}

	#form {
		width: 550px;
	}

	#form h3 {
		background: #78bd3f;
		color: white;
		margin: 0;
		padding: .1em 1em;
		font-size: 100%;
		font-weight: normal;
		clear: both;
	}

	#form dl {
		background: #F8F8F8;
		margin: 0;
	}

	#form dt {
		text-align: right;
		font-weight: normal;
		float: left;
		width: 10em;
		clear: both;
	}

	#form dd {
		margin: 0;
		padding-left: 10em;
		display: block;
	}

	#form dd ul {
		list-style: none;
		font-size: 90%;
	}

	#form dd.odd {
		background: #EEE;
	}
	</style>

	<script src="netteForms.js"></script>
</head>

<body>
	<h1>Nette\Forms custom rendering example</h1>

	<?php echo $form ?>
</body>
</html>
