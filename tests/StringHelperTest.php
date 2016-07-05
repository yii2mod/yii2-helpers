<?php

namespace yii2mod\helpers\tests;

use Yii;
use yii2mod\helpers\ArrayHelper;
use yii2mod\helpers\StringHelper;

/**
 * Class StringHelperTest
 * @package yii2mod\helpers\tests
 */
class StringHelperTest extends TestCase
{
    public function testRemoveStopWords()
    {
        $this->assertEquals([1 => 'stopwords', 4 => 'removed'], StringHelper::removeStopWords('Some stopwords can be removed'));
        $this->assertEquals('stopwords removed', StringHelper::removeStopWords('Some stopwords can be removed', true));
    }

    public function testRemovePunctuationSymbols()
    {
        $this->assertEquals('punctuation symbols', StringHelper::removePunctuationSymbols('punctuation symbols !,.><'));
    }
}