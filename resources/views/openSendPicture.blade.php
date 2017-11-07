@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-5">
            
            <img style="width: 100%" src="{{ asset($pictureToShow->path)  }}">
        </div>
        <div class="col-md-5">
        <h5>Jouw inzending:</h5>
        <p class="caption">{{$pictureToShow->caption}}</p>
        <h4>Van: {{$pictureToShow->firstName}} {{$pictureToShow->lastName}}</h5>
        <p class="votes">Aantal stemmen: {{$numberOfVotes}}</p>
            @if ( $hasAlreadyVoted )
                 <a class="btn btn-danger" href="/deleteAVote/{{$pictureToShow->picture_id}}">Stemming ongedaan maken</a>
            @else
                <a class="btn btn-primary" href="/voteForPicture/{{$pictureToShow->picture_id}}">Stemmen voor deze inzending</a>
            @endif
        </div>
    </div>
@endsection
