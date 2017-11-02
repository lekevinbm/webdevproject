<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Vote extends Model
{
    //
    public function getVote($picture_id, $user_id)
    {
    	return DB::table('votes')
    	->where('picture_id','=',$picture_id)
    	->where('user_id','=',$user_id)
    	->get();
    }

    public function deleteAVote($picture_id, $user_id)
    {
    	DB::table('votes')
        ->where('picture_id','=',$picture_id)
    	->where('user_id','=',$user_id)
        ->delete();
    }
}
