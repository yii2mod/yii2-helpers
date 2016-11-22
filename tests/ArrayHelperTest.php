<?php

namespace yii2mod\helpers\tests;

use yii2mod\helpers\ArrayHelper;

/**
 * Class ArrayHelperTest
 *
 * @package yii2mod\helpers\tests
 */
class ArrayHelperTest extends TestCase
{
    public function testAdd()
    {
        $array = ArrayHelper::add(['card' => 'Visa'], 'price', 200);
        $this->assertEquals(['card' => 'Visa', 'price' => 200], $array);
    }

    public function testAverage()
    {
        $this->assertEquals(3, ArrayHelper::average([1, 2, 3, 4, 5]));

        // pass the key

        $array = [
            ['score' => 10],
            ['score' => 30],
            ['score' => 50],
        ];
        $this->assertEquals(30, ArrayHelper::average($array, 'score'));
    }

    public function testCollapse()
    {
        $array = ArrayHelper::collapse([[1, 2, 3], [4, 5, 6]]);
        $this->assertEquals([1, 2, 3, 4, 5, 6], $array);
    }

    public function testExcept()
    {
        $array = ['name' => 'Desk', 'price' => 100];
        $array = ArrayHelper::except($array, ['price']);
        $this->assertEquals(['name' => 'Desk'], $array);
    }

    public function testHas()
    {
        $array = ['products' => ['desk' => ['price' => 100]]];
        $this->assertTrue(ArrayHelper::has($array, 'products.desk'));
        $this->assertFalse(ArrayHelper::has($array, 'products.price'));
    }

    public function testFirst()
    {
        $array = [100, 200, 300];
        $this->assertEquals(100, ArrayHelper::first($array));

        // via custom callback

        $value = ArrayHelper::first($array, function ($key, $value) {
            return $value >= 150; // 200
        });
        $this->assertEquals(200, $value);
    }

    public function testLast()
    {
        $array = [100, 200, 300];
        $this->assertEquals(300, ArrayHelper::last($array));

        // via custom callback

        $value = ArrayHelper::last($array, function ($key, $value) {
            return $value;
        });
        $this->assertEquals(300, $value);
    }

    public function testFlatten()
    {
        $array = ['name' => 'Bob', 'languages' => ['PHP', 'Python']];
        $this->assertEquals(['Bob', 'PHP', 'Python'], ArrayHelper::flatten($array));
    }

    public function testOnly()
    {
        $array = ['name' => 'Desk', 'price' => 100, 'orders' => 10];
        $this->assertEquals(['name' => 'Desk', 'price' => 100], ArrayHelper::only($array, ['name', 'price']));
    }

    public function testPrepend()
    {
        $array = ['one', 'two', 'three', 'four'];
        $array = ArrayHelper::prepend($array, 'zero');
        $this->assertEquals(['zero', 'one', 'two', 'three', 'four'], $array);
    }

    public function testPluck()
    {
        $array = [
            ['product_id' => 'prod-100', 'name' => 'Desk'],
            ['product_id' => 'prod-200', 'name' => 'Chair'],
        ];
        $plucked = ArrayHelper::pluck($array, 'name');
        $this->assertEquals(['Desk', 'Chair'], $plucked);

        // You may also specify how you wish the resulting collection to be keyed
        $plucked = ArrayHelper::pluck($array, 'name', 'product_id');
        $this->assertEquals(['prod-100' => 'Desk', 'prod-200' => 'Chair'], $plucked);
    }

    public function testPull()
    {
        $array = ['name' => 'Desk', 'price' => 100];
        $name = ArrayHelper::pull($array, 'name');
        $this->assertEquals('Desk', $name);
        $this->assertEquals(['price' => 100], $array);
    }

    public function testSet()
    {
        $array = ['products' => ['desk' => ['price' => 100]]];
        ArrayHelper::set($array, 'products.desk.price', 200);
        $this->assertEquals(['products' => ['desk' => ['price' => 200]]], $array);
    }

    public function testSort()
    {
        $array = [
            ['name' => 'Desk'],
            ['name' => 'Chair'],
        ];

        $array = ArrayHelper::sort($array, function ($value) {
            return $value['name'];
        });
        $this->assertEquals([
            1 => ['name' => 'Chair'],
            0 => ['name' => 'Desk'],
        ], $array);
    }

    public function testSortRecursive()
    {
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
        $this->assertEquals([
            [
                'Chair',
                'Desc',
            ],
            [
                'JavaScript',
                'PHP',
                'Ruby',
            ],
        ], $array);
    }

    public function testWhere()
    {
        $array = ['100', 200, '300'];
        $value = ArrayHelper::where($array, function ($key, $value) {
            return is_string($value);
        });
        $this->assertEquals([100, 2 => 300], $value);
    }

    public function testXmlStrToArray()
    {
        $xml = '<?xml version="1.0"?>
          <root>
            <id>1</id>
            <name>Bob</name>
          </root>';

        $this->assertEquals(['id' => 1, 'name' => 'Bob'], ArrayHelper::xmlStrToArray($xml));
    }

    public function testXmlWithAttributesToArray()
    {
        $xml = '<?xml version="1.0"?><root><PackageDimensions><Weight Units="hundredths-pounds">57</Weight></PackageDimensions></root>';

        $this->assertEquals(['PackageDimensions' => [
            'Weight' => [
                '@content' => '57',
                '@attributes' => [
                    'Units' => 'hundredths-pounds',
                ],
            ],
        ]], ArrayHelper::xmlStrToArray($xml));
    }
}
