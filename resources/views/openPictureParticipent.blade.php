@extends('layouts.app')

@section('content')
		<h4>Mijn Inzendingen</h4>
		@foreach($allPictures as $key => $picture)
	        <div class="col-md-4 contestPicture">
	            <a href="/openSendPicture/{{$picture->picture_id}}"><img src="{{ $picture->path }}"></a>
	            <div class="pictureInfo">
		            <p class="caption">{{ $picture->caption }}</p>
		            <p class="votes">Aantal stemmen: {{ $picture->numberOfVotes }}</p>
		            @if($picture->created_at > $startOfCurrentMonth)
			            @if( $picture->votes()->where('user_id',Auth::id())->get()->first()["wasVoted"]) 
			            	<a class="btn btn-danger" href="/deleteAVote/{{$picture->picture_id}}">Stemming ongedaan maken</a>
			            @else
			            	<a class="btn btn-primary" href="/voteForPicture/{{$picture->picture_id}}">Stemmen voor deze inzending</a>
			            @endif
			        @else
			        	<p>Ingezonden in {{ $picture->created_at->formatLocalized('%B') }}</p>
			        @endif
	            </div>
	        </div>
        @endforeach
@endsection