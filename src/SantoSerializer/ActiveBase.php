<?php 

namespace SantoSerializer;

abstract class ActiveBase
{
	/**
     * Objeto do tipo Model
     *
     */
    public $model;

    /**
     * metodo obrigatorio para todos o serializadores
     * @return Array
     */
    abstract public function adapter();

    /**
     * retorna um array com as keys que deverão ser
     * removidas no output de dados
     * @return Array
     */
    abstract public function remove();

     /**
      * modifica o array que será serializado
      * modificando vetores de lugar
      *
      * @return Array
      */
    abstract public function modify();

    /**
     * @param model Model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
}