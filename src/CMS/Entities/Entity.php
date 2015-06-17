<?php

namespace CMS\Entities;

use CMS\Structures\DataStructure;
use ReflectionClass;

class Entity
{
    public function setInfos(DataStructure $dataStructure)
    {
        $properties = get_object_vars($dataStructure);
        foreach ($properties as $property => $value) {

            $method = ucfirst(str_replace('_', '', $property));
            $getter = 'get' . $method;
            $setter = 'set' . $method;

            if (
                isset($dataStructure->$property) &&
                $dataStructure->$property !== null &&
                $dataStructure->$property != call_user_func_array(array($this, $getter), array())
            ) {
                call_user_func_array(array($this, $setter), array($value));
            }
        }

        return $this;
    }

    public function toStructure() {
        $ref = new ReflectionClass(get_class($this));
        $properties = $ref->getProperties();

        $structure = new DataStructure();
        foreach ($properties as $property) {
            $property = $property->name;

            $getter = 'get' . ucfirst(str_replace('_', '', $property));
            $structure->$property = call_user_func(array($this, $getter));
        }

        return $structure;
    }
}
