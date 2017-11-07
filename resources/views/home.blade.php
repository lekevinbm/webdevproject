@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div id="home-text" class="col-md-6">
        	<h4>De fotowedstrijd</h4>
           	<p>Stuur je originele #FIFAISBAE- foto (= een foto die aantoont hoe belangerijk het spel FIFA voor je is) en laat je vrienden op je foto stemmen.</p>
           	<p>Elke maand krijgt de eigenaar van de foto met de meeste stemmen, een duoticket cadeau (incl. vlucht en verblijf) voor een thuiswedstrijd van Real Madrid in het Santiago Bernabeu stadion.</p>
           	<h5>The one rule:</h5>
           	<ul>
           		<li>Je moet in het bezit zijn van het FIFA 18 spel.</li>
           	</ul>
           	<a class="button" href="/newParticipant">Een foto inzenden</a>
        </div>
        <div id="home-text" class="col-md-4 col-md-offset-1">
           <img class="home-img" src="{{ asset('img/Santiago1.jpg') }}">
           <img class="home-img" src="{{ asset('img/Santiago2.jpg') }}">
        </div>
    </div>
</div>
<div class="container">
    <h4>Vorige Winnaars</h4>
    <div class="col-md-4 contestPicture">
    			<h5>November</h5>
	            <img style="width: 90%" src="{{ asset('img/picturesOfParticipants/user-1-gSK0n.jpg') }}">
	            <div class="pictureInfo">
		            <p class="caption"></p>
		            <p class="votes">Aantal stemmen: </p>
	            </div>
	        </div>
</div>
@endsection
