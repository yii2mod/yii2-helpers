Yii2 Helpers
============
This extension is a collection of useful helper functions for Yii Framework 2.0. 

[![Latest Stable Version](https://poser.pugx.org/yii2mod/yii2-helpers/v/stable)](https://packagist.org/packages/yii2mod/yii2-helpers) [![Total Downloads](https://poser.pugx.org/yii2mod/yii2-helpers/downloads)](https://packagist.org/packages/yii2mod/yii2-helpers) [![License](https://poser.pugx.org/yii2mod/yii2-helpers/license)](https://packagist.org/packages/yii2mod/yii2-helpers) [![Build Status](https://travis-ci.org/yii2mod/yii2-helpers.svg?branch=master)](https://travis-ci.org/yii2mod/yii2-helpers)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yii2mod/yii2-helpers "*"
```

or add

```
"yii2mod/yii2-helpers": "*"
```

to the require section of your `composer.json` file.

Available Methods
-------------------
1. **[add()](#add)**
2. **[average()](#average)**
3. **[collapse()](#collapse)**
4. **[except()](#except)**
5. **[has()](#has)**
6. **[first()](#first)**
7. **[flatten()](#flatten)**
8. **[last()](#last)**
9. **[only()](#only)**
11. **[pluck()](#pluck)**
12. **[prepend()](#prepend)**
13. **[pull()](#pull)**
14. **[set()](#set)**
15. **[sort()](#sort)**
16. **[sortRecursive()](#sortrecursive)**
17. **[where()](#where)**
18. **[xmlStrToArray()](#xmlstrtoarray)**

Method Listing
-------------------
#####```add()```

Add a given key / value pair to the array if the given key doesn't already exist in the array:
```php
$array = ArrayHelper::add(['card' => 'Visa'], 'price', 200);
// ['card' => 'Visa', 'price' => 200]
```
------

#####```average()```

Get the average value of a given key:
```php
ArrayHelper::average([1, 2, 3, 4, 5]);
// 3
```

You may also pass a key to the average method:

```php
$array = [
   ['score' => 10],
   ['score' => 30],
   ['score' => 50],
];

ArrayHelper::average($array, 'score');

// 30
```
------


#####```collapse()```

Collapse an array of arrays into a single array:
```php
$array = ArrayHelper::collapse([[1, 2, 3], [4, 5, 6]]);

// [1, 2, 3, 4, 5, 6]
```
------

#####```except()```

Get all of the given array except for a specified array of items:
```php
$array = ['name' => 'Desk', 'price' => 100];

$array = ArrayHelper::except($array, ['price']);

// ['name' => 'Desk']
```
------

#####```has()```

Check if an item exists in an array using "dot" notation:
```php
$array = ['products' => ['desk' => ['price' => 100]]];

$hasDesk = ArrayHelper::has($array, 'products.desk');

// true
```
------

#####```first()```

Return the first element in an array passing a given truth test:
```php
$array = [100, 200, 300];
$value = ArrayHelper::first($array); // 100

// or apply custom callback

$value = ArrayHelper::first($array, function($key, $value) {
      return $value >= 150; // 200
});
```
------

#####```flatten()```

Flatten a multi-dimensional array into a single level:
```php
$array = ['name' => 'Bob', 'languages' => ['PHP', 'Python']];

$array = ArrayHelper::flatten($array);

// ['Bob', 'PHP', 'Python'];
```
------

#####```last()```

Return the last element in an array passing a given truth test:
```php
$array = [100, 200, 300];
$value = ArrayHelper::last($array); // 300

// or apply custom callback

$value = ArrayHelper::last($array, function($key, $value) {
      return $value; // 300
});
```
------

#####```only()```

Get a subset of the items from the given array:
```php
$array = ['name' => 'Desk', 'price' => 100, 'orders' => 10];

$array = ArrayHelper::only($array, ['name', 'price']);

// ['name' => 'Desk', 'price' => 100]
```
------

#####```prepend()```

Push an item onto the beginning of an array:
```php
$array = ['one', 'two', 'three', 'four'];

$array = ArrayHelper::prepend($array, 'zero');

// $array: ['zero', 'one', 'two', 'three', 'four']
```
------

#####```pluck()```

The function retrieves all of the collection values for a given key:
```php
$array = [
   ['product_id' => 'prod-100', 'name' => 'Desk'],
   ['product_id' => 'prod-200', 'name' => 'Chair'],
];


$plucked = ArrayHelper::pluck($array, 'name');

// ['Desk', 'Chair']
```
You may also specify how you wish the resulting collection to be keyed:
```php
$plucked = ArrayHelper::pluck($array, 'name', 'product_id');

// ['prod-100' => 'Desk', 'prod-200' => 'Chair']
```
------

#####```pull()```

Get a value from the array, and remove it:
```php
$array = ['name' => 'Desk', 'price' => 100];

$name = ArrayHelper::pull($array, 'name');

// $name: Desk

// $array: ['price' => 100]
```
------

#####```set()```

Set an array item to a given value using "dot" notation:
```php
$array = ['products' => ['desk' => ['price' => 100]]];

ArrayHelper::set($array, 'products.desk.price', 200);

// ['products' => ['desk' => ['price' => 200]]]
```
------

#####```sort()```

Sort the array using the given callback:
```php
$array = [
    ['name' => 'Desk'],
    ['name' => 'Chair'],
];

$array = ArrayHelper::sort($array, function ($value) {
    return $value['name'];
});

/*
    [
        ['name' => 'Chair'],
        ['name' => 'Desk'],
    ]
*/
```
------

#####```sortRecursive()```

Recursively sort an array by keys and values:
```php
$array = [
      [
          'Desc',
          'Chair',
      ],
      [
          'PHP',
          'Ruby',
          'JavaScript',
      ],
];

$array = ArrayHelper::sortRecursive($array);
        
/*
  [
      [
         'Chair',
         'Desc',
      ],
      [
         'JavaScript',
         'PHP',
         'Ruby',
      ]
  ];
*/
```
------

#####```where()```

Filter the array using the given Closure.:
```php
$array = ["100", 200, "300"];
$value = ArrayHelper::where($array, function($key, $value) {
   return is_string($value);
});
// Will be return Array ( [0] => 100 [2] => 300 );
```
------

#####```xmlStrToArray()```

Convert xml string to array.

```php
$xml = '<?xml version="1.0"?>
          <root>
            <id>1</id>
            <name>Bob</name>
          </root>';
          
ArrayHelper::xmlStrToArray($xml)

// ['id' => 1, 'name' => 'Bob']
```


####StringHelper
* ```StringHelper::removeStopWords('some text');``` - remove stop words from string
* ```StringHelper::removePunctuationSymbols('some text');``` - Remove punctuation symbols from string
