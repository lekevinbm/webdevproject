@extends('layouts.app')

@section('content')
		<h1>Alle Inzendingen</h1>
		@foreach($allPictures as $key => $picture)
	        <div class="col-md-4 contestPicture">
	            <a href="/openSendPicture/{{$picture->picture_id}}"><img style="width: 90%" src="{{ $picture->path }}"></a>
	            <p>{{ $picture->caption }}</p>
	            <p>Van {{ $picture->firstName }} {{ $picture->lastName }}</p>
	            <p>Aantal stemmen: {{ $picture->numberOfVotes }}</p>
	            <a class="btn btn-primary" href="/voteForPicture/{{$picture->picture_id}}">Stemmen voor deze inzending</a>
	        </div>
        @endforeach
@endsection
