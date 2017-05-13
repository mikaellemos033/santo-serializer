<?php 

namespace SantoSerializer\Serializer;
use SantoSerializer\ActiveBase;

class Base
{
	protected $activeSerializer;

	public function __construct(ActiveBase $activeSerializer)
	{
		$this->activeSerializer = $activeSerializer;
	}

	/**
	 * @return array
	 */
	public function parseAttributes()
	{
		return get_object_vars($this->activeSerializer->model);
	}

	/** 
	 * @return array
	 */
	public function serializerData()
	{
		$serializer 	= [];
		$listSerializer = $this->activeSerializer->adapter();
		
		if (empty($listSerializer)) return $serializer;

		foreach ( $listSerializer as $name => $content ) {

			if ( method_exists($this->activeSerializer, $content) ) {
				$serializer[$name] = call_user_func([$this->activeSerializer, $content]);
				continue;
			}

			$serializer[$name] = $content;
		}

		return $serializer;
	}

	/**
	 * @return array
	 */
	public function run()
	{
		$defaultProperties = $this->parseAttributes();		
		$secondaryData	   = $this->serializerData();

		return $this->modifyResponse(array_merge($defaultProperties, $secondaryData));
	}

	/** 
	 * @return array
	 */
	public function modifyResponse(array $properties)
	{
		$properties = $this->modifyFields($properties);
		return $this->removeFields($properties);
	}

	/** 
	 * @return array
	 */
	public function removeFields(array $properties)
	{
		foreach ( $this->activeSerializer->remove() as $field ){

			if (!isset($properties[$field])) continue;
			unset($properties[$field]);
		
		}

		return $properties;
	}

	/**
	 * @return array
	 */
	public function modifyFields(array $properties)
	{
		foreach ( $this->activeSerializer->modify() as $field => $otherField ) {

			$tempField = $this->makeField($field);
			eval(sprintf('$exists = isset($properties%s);', $tempField));

			if (!$exists) continue;

			eval(sprintf('$properties%s=$properties%s;', $this->makeField($otherField), $tempField));
			eval(sprintf('unset($properties%s);', $tempField));			
		}

		return $properties;
	}

	public function makeField($fields)
	{
		$fieldNew = '';
		foreach ( explode('.', $fields) as $field ) {
			$fieldNew = sprintf('%s["%s"]', $fieldNew, $field);
		}

		return $fieldNew;
	}
}