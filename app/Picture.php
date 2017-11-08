<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Picture extends Model
{
    //

    protected $primaryKey = 'picture_id';
    protected $table = 'pictures';

    public function getAPicture($picture_id)
    {
    	return DB::table('pictures')
    	->join('users','users.id','=','pictures.participent_id')
    	->where('picture_id','=',$picture_id)
    	->select('pictures.*','users.firstName','users.lastName')
    	->get();
    }

    public function getAllPicturesFromParticipent($user_id)
    {
    	return DB::table('pictures')
    	->join('users','users.id','=','pictures.participent_id')
    	->where('participent_id','=',$user_id)
    	->select('pictures.*','users.firstName','users.lastName')
    	->get();
    }

    public function getAllPictures(){
    	return DB::table('pictures')
    	->join('users','users.id','=','pictures.participent_id')
    	->select('pictures.*','users.firstName','users.lastName')
    	->get();
    }

    public function getAllPicturesFromPreviousMonth($beginMonth,$endMonth){
        return DB::table('pictures')
        ->where('created_at','>=',$beginMonth)
        ->where('created_at','<',$endMonth)
        ->orderBy('numberOfVotes', 'desc')
        ->get();
    }

    public function votes(){
    	return $this->hasMany('App\Vote','picture_id');
    }
}
