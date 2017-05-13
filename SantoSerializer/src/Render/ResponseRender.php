<?php 

namespace SantoSerializer\Render;
use SantoSerializer\ActiveBase;
use SantoSerializer\Serializer\Base;

class ResponseRender
{
	public static function get(ActiveBase $base)
	{		
		return (new Base($base))->run();
	}

	public static function json(ActiveBase $base)
	{
		$serializer = new Base($base);
		return json_encode($serializer->run());
	}
}