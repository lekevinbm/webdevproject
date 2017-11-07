<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Vote extends Model
{
    //
    protected $table = 'votes';
    protected $primaryKey = 'vote_id';

    public function getVote($picture_id, $user_id)
    {
    	return DB::table('votes')
    	->where('picture_id','=',$picture_id)
    	->where('user_id','=',$user_id)
    	->get();
    }

    public function getAllVotesFromUser($user_id){
        return DB::table('votes')
        ->where('user_id','=',$user_id)
        ->select('picture_id')
        ->get();
    }

    public function deleteAVote($picture_id, $user_id)
    {
    	DB::table('votes')
        ->where('picture_id','=',$picture_id)
    	->where('user_id','=',$user_id)
        ->delete();
    }

    public function  countNumberOfVotes($picture_id)
    {
    	return DB::table('votes')
                ->where('picture_id', '=',$picture_id)
                ->count();
    }

}
