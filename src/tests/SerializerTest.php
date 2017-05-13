<?php 

use SantoSerializer\Examples\SimpleSerializer;
use SantoSerializer\Render\ResponseRender;

class SerializerTest extends PHPUnit_Framework_TestCase
{
	public function testInit()
	{
		$stdClass   = new stdClass;
		$stdClass->name = 'mikael';
		$stdClass->odin = 'teste';

		$serializer = new SimpleSerializer($stdClass);		
		$render 	= ResponseRender::get($serializer);

		$this->assertTrue(is_array($render));
		$this->assertTrue(!array_key_exists('name', $render));
		$this->assertTrue(!array_key_exists('odin', $render));
		$this->assertTrue(array_key_exists('new_name', $render));		
	}
}