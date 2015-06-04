<?php

namespace CMS\Entities;

use CMS\Structures\DataStructure;

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
} 