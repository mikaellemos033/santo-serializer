<?php 

namespace SantoSerializer\Examples;

use SantoSerializer\ActiveBase;
use \stdClass;

class SimpleSerializer extends ActiveBase
{
	public function __construct(stdClass $object)
	{		
		parent::__construct($object);
	}

	public function modify()
	{
		return [
			'name' => 'new_name'
		];
	}

	public function remove()
	{
		return ['odin'];
	}

	public function adapter()
	{
		return [ 
			'go' => true
		];
	}
}