<?php

namespace yii2mod\helpers;

use Closure;
use yii\helpers\ArrayHelper as BaseArrayHelper;

/**
 * ArrayHelper provides additional array functionality that you can use in your application.
 */
class ArrayHelper extends BaseArrayHelper
{

    /**
     * Return the first element in an array passing a given truth test.
     * ~~~
     *   $array = [100, 200, 300];
     *   $value = ArrayHelper::first($array, function($key, $value) {
     *        return $value >= 150; // Will be return 200;
     *   });
     * ~~~
     * @param  array $array
     * @param  \Closure $callback
     * @param  mixed $default
     * @return mixed
     */
    public static function first($array, $callback, $default = null)
    {
        foreach ($array as $key => $value) {
            if (call_user_func($callback, $key, $value)) return $value;
        }
        return static::value($default);
    }

    /**
     * Return the last element in an array passing a given truth test.
     * ~~~
     *   $array = [100, 200, 300];
     *   $value = ArrayHelper::last($array, function($key, $value) {
     *        return $value; // Will be return 300;
     *   });
     * ~~~
     * @param $array
     * @param $callback
     * @param null $default
     * @return mixed
     */
    public static function last($array, $callback, $default = null)
    {
        $array = array_reverse($array);

        foreach ($array as $key => $value) {
            if (call_user_func($callback, $key, $value)) {
                return $value;
            }
        }

        return static::value($default);
    }

    /**
     * Filter the array using the given Closure.
     *
     * ~~~
     *   $array = ["100", 200, "300"];
     *   $value = ArrayHelper::where($array, function($key, $value) {
     *        return is_string($value);
     *   });
     *   // Will be return Array ( [0] => 100 [2] => 300 );
     * ~~~
     * @param  array $array
     * @param  \Closure $callback
     * @return array
     */
    public static function where($array, \Closure $callback)
    {
        $filtered = [];
        foreach ($array as $key => $value) {
            if (call_user_func($callback, $key, $value)) $filtered[$key] = $value;
        }
        return $filtered;
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function value($value)
    {
        if ($value instanceof \Closure) {
            call_user_func($value);
        }
        return $value;
    }

    /**
     * Get array value by key recursive
     *
     * @param $needle
     * @param array $haystack
     * @return array|mixed
     */
    public static function getArrayValueRecursive($needle, array $haystack)
    {
        $result = [];
        array_walk_recursive($haystack, function ($value, $key) use ($needle, &$result) {
            if ($key === $needle) array_push($result, $value);
        });
        return count($result) > 1 ? $result : array_pop($result);
    }

    /**
     * @param $xmlString
     * @param bool $tagName
     * @param bool $elementCount
     * @return array
     */
    public static function xmlStrToArray($xmlString, $tagName = false, $elementCount = false)
    {
        $doc = new \DOMDocument();
        try {
            $doc->loadXML($xmlString);
        } catch (\Exception $exc) {
            return false;
        }
        $result = [];

        if (is_string($tagName)) {
            $nodes = $doc->documentElement->getElementsByTagName($tagName);
            if (false == $elementCount) {
                $elementCount = $nodes->length;
            }
            for ($i = 0; $i < $elementCount; $i++) {
                $result[] = self::domNodeToArray($nodes->item($i));
            }
        } else {
            $result = self::domNodeToArray($doc->documentElement);
        }
        return $result;
    }

    /**
     * @param \DOMNode $node
     * @return array|string
     */
    protected static function domNodeToArray(\DOMNode $node)
    {
        $output = array();
        if (!isset($node->nodeType)) return $output;
        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;
            case XML_ELEMENT_NODE:
                for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v = self::domNodeToArray($child);
                    if (isset($child->tagName)) {
                        $t = $child->tagName;
                        $tExploded = explode(':', $t);
                        $t = isset($tExploded[1]) ? $tExploded[1] : $t;
                        if (!isset($output[$t])) {
                            $output[$t] = array();
                        }
                        $output[$t][] = $v;
                    } elseif (false !== $v && "" !== $v) {
                        $output = (string)$v;
                    }
                }
                if (is_array($output)) {
                    if ($node->attributes->length) {
                        $a = array();
                        foreach ($node->attributes as $attrName => $attrNode) {
                            $a[$attrName] = (string)$attrNode->value;
                        }
                        $output['@attributes'] = $a;
                    }
                    foreach ($output as $t => $v) {
                        if (is_array($v) && count($v) == 1 && $t != '@attributes') {
                            $output[$t] = $v[0];
                        }
                    }
                }
                break;
        }
        return $output;
    }

    /**
     * Implements `array_sort` from laravel framework
     * Usage
     * $array = array(
     *       array('totalMatchPercent' => 10),
     *       array('totalMatchPercent' => 45),
     * );
     * ~~~
     *    $array = ArrayHelper::sort($result, function ($value) {
     *           return $value['totalMatchPercent'];
     *    });
     * ~~~
     * @param $items
     * @param Closure $callback
     * @param int $options
     * @param bool|true $descending
     * @return array
     */
    public static function sort($items, Closure $callback, $descending = true, $options = SORT_REGULAR)
    {
        $results = [];
        /**
         * First we will loop through the items and get the comparator from a callback
         * function which we were given. Then, we will sort the returned values
         * and grab the corresponding values for the sorted keys from this array.
         */
        foreach ($items as $key => $value) {
            $results[$key] = $callback($value);
        }
        $descending ? arsort($results, $options) : asort($results, $options);
        /**
         * Once we have sorted all of the keys in the array, we will loop through them
         * and grab the corresponding model so we can set the underlying items list
         * to the sorted version. Then we'll just return the collection instance.
         */
        foreach (array_keys($results) as $key) {
            $results[$key] = $items[$key];
        }

        return $results;
    }

    /**
     * Return AVERAGE of the values in your array
     * @param $array
     * @return float
     */
    public static function average($array)
    {
        return round(array_sum($array) / count($array));
    }

}