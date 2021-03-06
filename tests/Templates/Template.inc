<?php

/**
 * Common code for Template test cases.
 */

use Nette\Loaders\LimitedScope,
	Nette\Templates\BaseTemplate,
	Nette\Templates\Template,
	Nette\Templates\TemplateCacheStorage;



// Setup caching storage

class MockCacheStorage extends TemplateCacheStorage
{

	public function write($key, $data, array $dp)
	{
		file_put_contents(__DIR__ . '/compiled/' . preg_replace('#^.*[a-f0-9]{32}\.#', '', $key) . '.php', $data);
		return parent::write($key, $data, $dp);
	}

}



class MockTemplate extends BaseTemplate
{
	public $compiled;

	public function render($content = NULL)
	{
		$this->__set('template', $this);
		$this->compiled = $this->compile($content);
		LimitedScope::evaluate($this->compiled, $this->getParams());
	}

}

