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

Usage
-----
#####ArrayHelper
* ```ArrayHelper::first();``` - Return the first element in an array passing a given truth test.
```php
    $array = [100, 200, 300];
    $value = ArrayHelper::first($array, function($key, $value) {
          return $value >= 150; // Will be return 200;
    });
```
* ```ArrayHelper::last();``` - Return the last element in an array passing a given truth test.
```php
   $array = [100, 200, 300];
   $value = ArrayHelper::last($array, function($key, $value) {
        return $value; // Will be return 300;
   });
``` 
* ```ArrayHelper::where();``` - Filter the array using the given Closure.
```php
      $array = ["100", 200, "300"];
      $value = ArrayHelper::where($array, function($key, $value) {
           return is_string($value);
      });
      // Will be return Array ( [0] => 100 [2] => 300 );
```
* ```ArrayHelper::xmlStrToArray();``` - convert xml string to array
* ```ArrayHelper::sort();``` - sorts the array by the results of the given Closure.
```php
      $array = array(
            array('totalMatchPercent' => 10),
            array('totalMatchPercent' => 45),
      );
      $array = ArrayHelper::sort($array, function ($value) {
            return $value['totalMatchPercent'];
      });
```
* ```ArrayHelper::average($array);``` - Return AVERAGE of the values in your array
 
#####StringHelper
* ```StringHelper::removeStopWords();``` - remove stop words from string
* ```StringHelper::removePunctuationSymbols();``` - Remove punctuation symbols from string
