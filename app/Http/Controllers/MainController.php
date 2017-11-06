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
use Carbon\Carbon;
use File;


use Symfony\Component\HttpFoundation\Session\Session;

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

    public function openAllPictures(){
        $picture = new Picture;
        $allPictures = $picture->getAllPictures();
        return view('allPictures',[
            'allPictures' => $allPictures,
            ]);
    }

    public function openNewParticipant()
    {
        return view('newParticipant');
    }

    public function postNewParticipantPage1Data(Request $request){

        $validator = Validator::make($request->all(), [
          'email' => 'required',
          'image' => 'required',
          'caption' => 'required',
          'serialNumberOfGame' => 'required'
        ]);

        if ($validator->passes()){            

            //temporary save the image
            $currentTime = Carbon::now()->timestamp;
            $image = $request->image;
            $extension = pathinfo(storage_path().$image->getClientOriginalName(), PATHINFO_EXTENSION);

            $imageName = $currentTime.'-'.str_random(5).'.'.$extension;
            $image->move("img/tempPictures/", $imageName);
            $imagePath = 'img/tempPictures/'.$imageName;



            $participantData = [
                'email' => $request->email,
                'caption' => $request->caption,
                'serialNumberOfGame' => $request->serialNumberOfGame,
                'imageName' => $imageName,
                'imagePath' => $imagePath,
            ];

            $request->session()->put('participantData', $participantData);

            return redirect('openNewParticipantPage2');

        } else{
            return Redirect::back()->withErrors($validator);
        }        
    }

    public function openNewParticipantPage2(Request $request){

        $participantData = $request->session()->get('participantData');
        $participantEmail = $participantData['email'];

        $user = new User;
        if(Auth::check()) {
            if(Auth::user()->isParticipant){
                $picture_id = $this->sendPictureAndGiveId($participantData, Auth::id());
                return redirect('/openSendPicture/'.$picture_id);
            } else{
                return view('newParticipantPage2');
            }
            
        } else{
            if ($user->getUserWithEmail($participantEmail)->isEmpty()){
                return view('newParticipantPage2',
                    [
                    'participantEmail' => $participantEmail
                    ]);
            } else{
                $request->session()->put('nextPageLink', '/openNewParticipantPage2');
                return redirect('/login');
            }
        }

        
    }




    public function registerNewParticipant(Request $request)
    {
        $user = new User;

        if(Auth::check()){
            $hasUserAnAccount = True;

            $validator = Validator::make($request->all(), [
              'streetAndNumber' => 'required',
              'zipcode' => 'required',
              'placeOfResidence' => 'required',
            ]);

        } else{
            $hasUserAnAccount = True;

            $validator = Validator::make($request->all(), [
              'firstName' => 'required',
              'lastName' => 'required',
              'streetAndNumber' => 'required',
              'zipcode' => 'required',
              'placeOfResidence' => 'required',
              'password' => 'required',
            ]);
        }

        //Get the data from the previous page (the participantdata)
        $participantData = $request->session()->get('participantData');

        if ($validator->passes() && !$hasUserAnAccount){

            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $participantData['email'];
            $user->password = bcrypt($request->password);
            $user->streetAndNumber = $request->streetAndNumber;
            $user->zipcode = $request->zipcode;
            $user->placeOfResidence = $request->placeOfResidence;
            $user->isAdmin = False;
            $user->isParticipant = True;
            $user->save();
            $user_id = $user->id;

            $picture_id = $this->sendPictureAndGiveId($participantData, $user_id);

            Auth::login($user, true);

            return redirect('/openSendPicture/'.$picture_id);
    
        } elseif($validator->passes() && $hasUserAnAccount){
            Auth::user()->streetAndNumber = $request->streetAndNumber;            
            Auth::user()->zipcode = $request->zipcode;
            Auth::user()->placeOfResidence = $request->placeOfResidence;
            Auth::user()->isParticipant = True;
            Auth::user()->save();

            $picture_id = $this->sendPictureAndGiveId($participantData, Auth::id());
            return redirect('/openSendPicture/'.$picture_id);
        }else{
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

        $numberOfVotes = $vote->countNumberOfVotes($picture_id);

        return view('openSendPicture',
            [
            'pictureToShow' => $pictureToShow,
            'hasAlreadyVoted' => $hasAlreadyVoted,
            'numberOfVotes' => $numberOfVotes,
            ]);
    }

    public function sendPictureAndGiveId($participantData, $user_id){

        $picture = new Picture;

        //Getting the image and save it in local folder
        $image = File::get($participantData['imagePath']);
        $imageExtension = File::extension($participantData['imagePath']);
        $path = 'img/picturesOfParticipants/user-'.$user_id.'-'.str_random(5).'.'.$imageExtension;

        File::move($participantData['imagePath'],$path);
            
        $picture->serialNumberOfGame = $participantData['serialNumberOfGame'];
        $picture->caption = $participantData['caption'];
        $picture->path = $path;
        $picture->participent_id = $user_id;
        $picture->serialNumberOfGame = $participantData['serialNumberOfGame'];
        $picture->numberOfVotes = 0;
        $picture->save();
        return $picture_id = $picture->id;

    }

    public function voteForPicture($picture_id){
       
        $vote = new Vote;
        $picture = new Picture;

        $voteToCheck = $vote->getVote($picture_id, Auth::id());
        
        if($voteToCheck->isEmpty()){
            $vote->user_id = Auth::id();
            $vote->picture_id = $picture_id;
            $vote->wasVoted = True;
            $vote->save();

            $pictureToEdit = $picture->getAPicture($picture_id)->first();
            $pictureToEdit->numberOfVotes = $pictureToEdit->numberOfVotes + 1;
        }

        return redirect('/openSendPicture/'.$picture_id);
    }

    public function deleteAVote($picture_id){

        $vote = new Vote;
        $picture = new Picture;
        $user_id = Auth::id();

        $voteToCheck = $vote->getVote($picture_id, Auth::id());

        if(!$voteToCheck->isEmpty()){
            $vote->deleteAVote($picture_id, $user_id);

            $pictureToEdit = $picture->getAPicture($picture_id)->first();
            $pictureToEdit->numberOfVotes = $pictureToEdit->numberOfVotes - 1;
        }   
        
        return redirect('/openSendPicture/'.$picture_id);
    }

    public function allParticipants(){
        return view('allParticipants');
    }
}