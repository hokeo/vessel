<?php namespace Hokeo\Vessel\Facades;

use Illuminate\Support\Facades\Facade;

class Translator extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'Hokeo\\Vessel\\Translator';
	}
}