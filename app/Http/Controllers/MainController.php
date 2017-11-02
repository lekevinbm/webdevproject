<?php

namespace App\Http\Controllers;

use App\User;
use App\Picture;
use App\Vote;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Redirect;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(){
        return view('home');
    }

    public function openNewParticipant()
    {
        return view('newParticipant');
    }

    public function registerNewParticipant(Request $request)
    {
        $user = new User;
        $picture = new Picture;

        $validator = Validator::make($request->all(), [
          'firstName' => 'required',
          'lastName' => 'required',
          'email' => 'required',
          'streetAndNumber' => 'required',
          'zipcode' => 'required',
          'placeOfResidence' => 'required',
          'image' => 'required',
          'caption' => 'required',
          'serialNumberOfGame' => 'required'
        ]);

        if ($validator->passes()){

            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->firstName = $request->firstName;
            $user->email = $request->email;
            $user->streetAndNumber = $request->streetAndNumber;
            $user->zipcode = $request->zipcode;
            $user->placeOfResidence = $request->placeOfResidence;
            $user->isAdmin = False;
            $user->save();
            $user_id = $user->id;

            //Getting the image and save it in local folder
            $image = $request->image;
            $imageName = 'user-'.$user_id.'-'.str_random(5).$image->getClientOriginalName();
            $image->move('img/picturesOfParticipants/', $imageName);
            $path = 'img/picturesOfParticipants/'.$imageName;

            $picture->serialNumberOfGame = $request->serialNumberOfGame;
            $picture->caption = $request->caption;
            $picture->path = $path;
            $picture->participent_id = $user_id;
            $picture->serialNumberOfGame = $request->serialNumberOfGame;
            $picture->save();
            $picture_id = $picture->picture_id;

            return redirect('/openSendPicture/'.$picture_id);
                
        } else{
            return Redirect::back()->withErrors($validator);
        }

        
    }

    public function openSendPicture($picture_id){
        $picture = new Picture();
        $pictureToShow = $picture->getAPicture($picture_id)->first();

        $vote = new Vote();
        $user_id = Auth::id();
        $hasAlreadyVoted = False;
        $voteToCheck = $vote->getVote($picture_id,$user_id);
        if (!$voteToCheck->isEmpty()){
            $hasAlreadyVoted = True;
        }

        return view('openSendPicture',
            [
            'pictureToShow' => $pictureToShow,
            'hasAlreadyVoted' => $hasAlreadyVoted,
            ]);
    }

    public function voteForPicture($picture_id){
       
            $vote = new Vote;
            $vote->user_id = Auth::id();
            $vote->picture_id = $picture_id;
            $vote->save();

        return redirect('/openSendPicture/'.$picture_id);
    }

    public function deleteAVote($picture_id){

        $vote = new Vote;
        $user_id = Auth::id();

        $vote->deleteAVote($picture_id, $user_id);
        
        return redirect('/openSendPicture/'.$picture_id);
    }

    public function allParticipants(){
        return view('allParticipants');
    }
}