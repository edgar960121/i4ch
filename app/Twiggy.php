<?php namespace App;
 
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;
 
class Twiggy extends Twig_Extension {
 
	public function getName() {
		// 
	}
 
	/**
	 * Functions
	 * @return void
	 */
	public function getFunctions() {
		return [
			new Twig_SimpleFunction('current_url', [$this, 'current_url']),
			new Twig_SimpleFunction('getEnvVariable', [$this, 'getEnvVariable']),
			new Twig_SimpleFunction('env', [$this, 'env']),
		];
	}
 
	/**
	 * Filters
	 * @return void
	 */
	public function getFilters() {
		return [
			new Twig_SimpleFilter('toInteger', [$this, 'toInteger']),
			new Twig_SimpleFilter('ucwords', [$this, 'ucwords']),
		];
	}

	public function toInteger($string) {
	    return (int)$string;
	}

	public function env($var){
		return env($var);
	}

	public function current_url($string) {
	    return url(\URL::current().$string);
	}

	public function ucwords($array){
		return ucwords(mb_strtolower(implode(' ',$array)));
	}

	public function getEnvVariable($variable){
		return env($variable);
	}
 
}