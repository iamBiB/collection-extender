<?php

/*
 * @Author: bib
 * @Date:   2023-12-16 09:31:40
 * @Last Modified by:   bib
 * @Last Modified time: 2023-12-16 09:45:34
 */

namespace iAmBiB\CollectionExtender\Helpers;

class Cast
{
    public static function castArray(array $properties, array $type)
    {
        $object = new $type['attributes'];
        foreach ($properties as $key => $property)
        {
            $object->setKey($key, $property);
            if (\in_array($key, array_keys($type)))
            {
                if (!\is_array($property))
                {
                    $object->setKey($key, $property);
                }
                else
                {
                    unset($type['attributes']);
                    $recursiveType = [];
                    $recursiveType['attributes'] = $type[$key];
                    unset($type[$key]);
                    $recursiveType = array_merge($recursiveType, $type);
                    $object->setKey($key, self::castArray($property, $recursiveType));
                }
            }
        }

        return $object;
    }
}
