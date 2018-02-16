<?php
/**
 * Created by PhpStorm.
 * User: anil
 * Date: 29/11/2017
 * Time: 15:27
 */

namespace App\Model;
use Illuminate\Database\Eloquent\Model;


class LookingFor extends Model
{
	public $timestamps = false;
	public function locationsPreferred()
	{
		return $this->hasMany('App\Model\Location');
	}
	public function jobTypes()
	{
		return $this->belongsToMany('App\Model\Field');
	}
	public function sectors()
	{
		return $this->hasMany('App\Model\Category', 'looking_for_sectors');
	}
	public function profile(){
        return $this->belongsTo('App\Model\Profile');
    }
}