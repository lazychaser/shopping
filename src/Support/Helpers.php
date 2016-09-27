<?php

namespace Kalnoy\Shopping\Support;

use Illuminate\Support\Str;

class Helpers
{
    /**
     * Set properties on object using array of properties.
     *
     * It checks whether an object has a property setter and uses it first.
     *
     * @param object $object
     * @param array $properties
     */
    public static function configure($object, array $properties)
    {
        foreach ($properties as $property => $value) {
            $property = Str::camel($property);

            $method = 'set'.ucfirst($property);

            if (method_exists($object, $method)) {
                $object->$method($value);
            } else {
                $object->$property = $value;
            }
        }
    }
}