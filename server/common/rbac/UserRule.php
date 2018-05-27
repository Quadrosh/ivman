<?php
namespace common\rbac;

use yii\rbac\Rule;

class UserRule extends Rule
{
    public $name = 'User';

    public function execute($user, $item, $params)
    {
        return true;
    }
}