<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Winner extends Model
{
    //
    protected $table = 'winners';
    protected $primaryKey = 'winner_id';

    public function getAllWinners(){
    	return DB::table('winners')
    	->join('pictures','pictures.picture_id','=','winners.picture_id')
    	->join('users','users.id','=','pictures.participent_id')
    	->select('pictures.*','winners.month','users.firstName','users.lastName')
    	->get();
    }
}
