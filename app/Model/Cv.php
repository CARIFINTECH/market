<?php
/**
 * Created by PhpStorm.
 * User: sumra
 * Date: 31/08/2017
 * Time: 18:47
 */

namespace App\Model;
use Illuminate\Database\Eloquent\Model;


class Cv extends Model
{
    public function category()
    {
        return $this->hasOne('App\Model\Category');
    }
}