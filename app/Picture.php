<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Picture extends Model
{
    //
    public function getAPicture($picture_id)
    {
    	return DB::table('pictures')
    	->join('users','users.id','=','pictures.participent_id')
    	->where('picture_id','=',$picture_id)
    	->select('pictures.*','users.firstName','users.lastName')
    	->get();
    }

    public function getAllPictures(){
    	return DB::table('pictures')
    	->join('users','users.id','=','pictures.participent_id')
    	->select('pictures.*','users.firstName','users.lastName')
    	->get();
    }
}
