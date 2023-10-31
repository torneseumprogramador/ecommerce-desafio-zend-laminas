<?php

namespace Api\Servico;

class ObjetoParaArray
{
    public static function convertObjectToArray($object)
    {
        $reflectionClass = new \ReflectionObject($object);
        $array = [];
        
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
        }
        
        return $array;
    }
}
