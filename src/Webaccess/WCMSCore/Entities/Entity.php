<?php

namespace Webaccess\WCMSCore\Entities;

use Webaccess\WCMSCore\DataStructure;
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
                is_callable(array($this, $getter), false, $callable_name) &&
                is_callable(array($this, $setter), false, $callable_name) &&
                $dataStructure->$property != call_user_func_array(array($this, $getter), array())
            ) {
                call_user_func_array(array($this, $setter), array($value));
            }
        }

        return $this;
    }

    public function toStructure() {
        $ref = new ReflectionClass(get_class($this));
        $structure = new DataStructure();

        if ($ref->getParentClass() && sizeof($ref->getParentClass()->getProperties()) > 0) {
            $this->transferPropertiesToStructure($ref->getParentClass()->getProperties(), $structure);
        }
        $this->transferPropertiesToStructure($ref->getProperties(), $structure);

        return $structure;
    }

    private function transferPropertiesToStructure($properties, $structure)
    {
        foreach ($properties as $property) {
            if ($property) {
                $property = $property->name;

                $getter = 'get' . ucfirst(str_replace('_', '', $property));
                if (is_callable(array($this, $getter), false, $callable_name)) {
                    $structure->$property = call_user_func(array($this, $getter));
                }
            }
        }
    }
}
