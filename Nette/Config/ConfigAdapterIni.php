<?php

/**
 * Nette Framework
 *
 * @copyright  Copyright (c) 2004, 2010 David Grudl
 * @license    http://nette.org/license  Nette license
 * @link       http://nette.org
 * @category   Nette
 * @package    Nette\Config
 */

namespace Nette\Config;

use Nette;



/**
 * Reading and writing INI files.
 *
 * @copyright  Copyright (c) 2004, 2010 David Grudl
 * @package    Nette\Config
 */
final class ConfigAdapterIni implements IConfigAdapter
{

	/** @var string  key nesting separator (key1> key2> key3) */
	public static $keySeparator = '.';

	/** @var string  section inheriting separator (section < parent) */
	public static $sectionSeparator = ' < ';

	/** @var string  raw section marker */
	public static $rawSection = '!';



	/**
	 * Static class - cannot be instantiated.
	 */
	final public function __construct()
	{
		throw new \LogicException("Cannot instantiate static class " . get_class($this));
	}



	/**
	 * Reads configuration from INI file.
	 * @param  string  file name
	 * @param  string  section to load
	 * @return array
	 * @throws \InvalidStateException
	 */
	public static function load($file, $section = NULL)
	{
		if (!is_file($file) || !is_readable($file)) {
			throw new \FileNotFoundException("File '$file' is missing or is not readable.");
		}

		$ini = parse_ini_file($file, TRUE);

		$separator = trim(self::$sectionSeparator);
		$data = array();
		foreach ($ini as $secName => $secData) {
			// is section?
			if (is_array($secData)) {
				if (substr($secName, -1) === self::$rawSection) {
					$secName = substr($secName, 0, -1);

				} elseif (self::$keySeparator) {
					// process key separators (key1> key2> key3)
					$tmp = array();
					foreach ($secData as $key => $val) {
						$cursor = & $tmp;
						foreach (explode(self::$keySeparator, $key) as $part) {
							if (!isset($cursor[$part]) || is_array($cursor[$part])) {
								$cursor = & $cursor[$part];
							} else {
								throw new \InvalidStateException("Invalid key '$key' in section [$secName] in '$file'.");
							}
						}
						$cursor = $val;
					}
					$secData = $tmp;
				}

				// process extends sections like [staging < production] (with special support for separator ':')
				$parts = $separator ? explode($separator, strtr($secName, ':', $separator)) : array($secName);
				if (count($parts) > 1) {
					$parent = trim($parts[1]);
					$cursor = & $data;
					foreach (self::$keySeparator ? explode(self::$keySeparator, $parent) : array($parent) as $part) {
						if (isset($cursor[$part]) && is_array($cursor[$part])) {
							$cursor = & $cursor[$part];
						} else {
							throw new \InvalidStateException("Missing parent section [$parent] in '$file'.");
						}
					}
					$secData = Nette\ArrayTools::mergeTree($secData, $cursor);
				}

				$secName = trim($parts[0]);
				if ($secName === '') {
					throw new \InvalidStateException("Invalid empty section name in '$file'.");
				}
			}

			if (self::$keySeparator) {
				$cursor = & $data;
				foreach (explode(self::$keySeparator, $secName) as $part) {
					if (!isset($cursor[$part]) || is_array($cursor[$part])) {
						$cursor = & $cursor[$part];
					} else {
						throw new \InvalidStateException("Invalid section [$secName] in '$file'.");
					}
				}
			} else {
				$cursor = & $data[$secName];
			}

			if (is_array($secData) && is_array($cursor)) {
				$secData = Nette\ArrayTools::mergeTree($secData, $cursor);
			}

			$cursor = $secData;
		}

		if ($section === NULL) {
			return $data;

		} elseif (!isset($data[$section]) || !is_array($data[$section])) {
			throw new \InvalidStateException("There is not section [$section] in '$file'.");

		} else {
			return $data[$section];
		}
	}



	/**
	 * Write INI file.
	 * @param  Config to save
	 * @param  string  file
	 * @param  string  section name
	 * @return void
	 */
	public static function save($config, $file, $section = NULL)
	{
		$output = array();
		$output[] = '; generated by Nette';// at ' . @strftime('%c');
		$output[] = '';

		if ($section === NULL) {
			foreach ($config as $secName => $secData) {
				if (!(is_array($secData) || $secData instanceof \Traversable)) {
					throw new \InvalidStateException("Invalid section '$section'.");
				}

				$output[] = "[$secName]";
				self::build($secData, $output, '');
				$output[] = '';
			}

		} else {
			$output[] = "[$section]";
			self::build($config, $output, '');
			$output[] = '';
		}

		if (!file_put_contents($file, implode(PHP_EOL, $output))) {
			throw new \IOException("Cannot write file '$file'.");
		}
	}



	/**
	 * Recursive builds INI list.
	 * @param  array|\Traversable
	 * @param  array
	 * @param  string
	 * @return void
	 */
	private static function build($input, & $output, $prefix)
	{
		foreach ($input as $key => $val) {
			if (is_array($val) || $val instanceof \Traversable) {
				self::build($val, $output, $prefix . $key . self::$keySeparator);

			} elseif (is_bool($val)) {
				$output[] = "$prefix$key = " . ($val ? 'true' : 'false');

			} elseif (is_numeric($val)) {
				$output[] = "$prefix$key = $val";

			} elseif (is_string($val)) {
				$output[] = "$prefix$key = \"$val\"";

			} else {
				throw new \InvalidArgumentException("The '$prefix$key' item must be scalar or array, " . gettype($val) ." given.");
			}
		}
	}

}
