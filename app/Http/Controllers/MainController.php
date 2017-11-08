<?php

namespace App\Http\Controllers;

use App\User;
use App\Picture;
use App\Vote;
use App\Winner;
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
        $winner = new Winner;
        $allWinners = $winner->getAllWinners();
        return view('home',[
            'allWinners' => $allWinners
            ]);
    }

    public function test(){
        $allFiles = File::allFiles('img/tempPictures');
        foreach($allFiles as $key => $filePath){
            $fileName = basename($filePath);
            $fileNameArray = explode("-", $fileName);
            $timestampFileAddedWithHour = $fileNameArray[0] + 3600;
            $currentTime = Carbon::now()->timestamp;

            if($currentTime > $timestampFileAddedWithHour){
                unlink($filePath);
                return "normaal verwijderd";
            } else{
                return "Uur is nog niet voorbij";
            }
        }
        

    }

    public function test2(){
        $currentDay = Carbon::today();
        $currentDaySubbedWithMonth = Carbon::today()->submonth(1);
        Carbon::setLocale('nl');
        $previousMonth = $currentDaySubbedWithMonth->format('F');

        $picture = new Picture;
        $allPicturesFromPreviousMonth = $picture->getAllPicturesFromPreviousMonth($currentDaySubbedWithMonth,$currentDay);
        $winningPicture_id = $allPicturesFromPreviousMonth->first()->picture_id;
        
        $winner = new Winner;
        $winner->picture_id = $winningPicture_id;
        $winner->month = $previousMonth;
        $winner->save();

        return $winner;
    }

    public function openAllPictures(){

        $allPictures = Picture::join('users','users.id','=','pictures.participent_id')
        ->select('pictures.*','users.firstName','users.lastName')
        ->get();

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
          'email' => 'required|string|email|max:255',
          'image' => 'required|image',
          'caption' => 'required|string|max:255',
          'serialNumberOfGame' => 'required|string|max:10'
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
              'streetAndNumber' => 'required|string|max:255',
              'zipcode' => 'required|string|max:255',
              'placeOfResidence' => 'required|string|max:255',
            ]);

        } else{
            $hasUserAnAccount = False;

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
            $user->ipAddress = $request->ip();
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
            Auth::user()->ipAddress = $request->ip();
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
        return $picture_id = $picture->picture_id;

    }

    public function openPicturesParticipent(){
        $user_id = Auth::id();
        $allPictures = Picture::join('users','users.id','=','pictures.participent_id')
        ->where('participent_id','=',$user_id)
        ->select('pictures.*','users.firstName','users.lastName')
        ->get();



        return view('openPictureParticipent',
            [
            'allPictures' => $allPictures,
            ]);
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

            $pictureToEdit = $picture::find($picture_id);
            $originalNumberOfVotes = $pictureToEdit->numberOfVotes;
            $pictureToEdit->numberOfVotes = $originalNumberOfVotes + 1;
            $pictureToEdit->save();
        }

        return Redirect::back();
    }

    public function deleteAVote($picture_id){

        $vote = new Vote;
        $picture = new Picture;
        $user_id = Auth::id();

        $voteToCheck = $vote->getVote($picture_id, Auth::id());

        if(!$voteToCheck->isEmpty()){
            $vote->deleteAVote($picture_id, $user_id);

            $pictureToEdit = $picture::find($picture_id);
            $originalNumberOfVotes = $pictureToEdit->numberOfVotes;
            $pictureToEdit->numberOfVotes = $originalNumberOfVotes - 1;
            $pictureToEdit->save();
        }   
        
        return Redirect::back();
    }

    public function allParticipants(){

        $allUsers =  User::all();
        
        return view('allParticipants',[
            'allUsers' => $allUsers
            ]);
    }

    public function deleteAUser($user_id){
        $user = User::find($user_id);    
        $user->delete();
        return Redirect::back();
    }

    public function setUserAsAdmin($user_id){
        $user = User::find($user_id);
        $user->isAdmin = True;
        $user->save();
        return Redirect::back();
    }

    public function setAdminAsNormalUser($user_id){
        $user = User::find($user_id);
        $user->isAdmin = False;
        $user->save();
        return Redirect::back();
    }


}