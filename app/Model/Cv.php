<?php
/**
 * Created by PhpStorm.
 * User: Anil
 * Date: 31/08/2017
 * Time: 18:47
 */

namespace App\Model;
use Illuminate\Database\Eloquent\Model;


class Cv extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }
}