@extends('layouts.app')

@section('content')
	<div class="container">
		<h1>Alle Inzendingen</h1>
		@foreach($allPictures as $key => $picture)
	        <div class="col-md-4 contestPicture">
	            <a href="/openSendPicture/{{$picture->picture_id}}"><img src="{{ $picture->path }}"></a>
	            <div class="pictureInfo">
	            	<p class="caption">{{ $picture->caption }}</p>
		            <p class="participant">Van {{ $picture->firstName }} {{ $picture->lastName }}</p>
		            <p class="votes">Aantal stemmen: {{ $picture->numberOfVotes }}</p>
		          	@if( $picture->votes()->where('user_id',Auth::id())->get()->first()["wasVoted"]) 
		            	<a class="btn btn-danger" href="/deleteAVote/{{$picture->picture_id}}">Stemming ongedaan maken</a>
		            @else
		            	<a class="btn btn-primary" href="/voteForPicture/{{$picture->picture_id}}">Stemmen voor deze inzending</a>
		            @endif
	            </div>
	            
	        </div>
        @endforeach
    </div>
@endsection
