# Yii2 Helpers
This extension is a collection of useful helper functions for Yii Framework 2.0. 

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
2. **[collapse()](#collapse)**
3. **[except()](#except)**
4. **[has()](#has)**
5. **[first()](#first)**
6. **[flatten()](#flatten)**
7. **[last()](#last)**
8. **[only()](#only)**
9. **[prepend()](#prepend)**
10. **[pull()](#pull)**
11. **[where()](#where)**
12. **[xmlStrToArray()](#xmlstrtoarray)**

Method Listing
-------------------
#####```add()```

Add a given key / value pair to the array if the given key doesn't already exist in the array:
```php
$array = ArrayHelper::add(['card' => 'Visa'], 'price', 200);
// ['card' => 'Visa', 'price' => 200]
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

#####```pull()```

Get a value from the array, and remove it:
```php
$array = ['name' => 'Desk', 'price' => 100];

$name = ArrayHelper::pull($array, 'name');

// $name: Desk

// $array: ['price' => 100]
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

###```xmlStrToArray();```

Convert xml string to array.


####StringHelper
* ```StringHelper::removeStopWords();``` - remove stop words from string
* ```StringHelper::removePunctuationSymbols();``` - Remove punctuation symbols from string
