<?php
/**
 * Created by JetBrains PhpStorm.
 * User: erik
 * Date: 29.06.13
 * Time: 14:06
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Db\Mongo;

use \Mvc\Db\MongoDb\Collection as Collection;

class TestCollection extends Collection
{
    protected $name = 'cartoons';
}