@extends('layouts.app')

@section('content')
    <h1>Alle gebruikers</h1>
    <div class="container">
        <h3>Alle deelnemers</h3>
        <table class="table table-hover">
            <thead>
              <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Adres</th>
                <th>IP-adres</th>
                <th>Rol</th>
              </tr>
            </thead>
            <tbody>
                @foreach($allUsers as $key => $user)
                    @if($user->isParticipant)
                        <tr>
                            <td>
                                <p>{{$user->firstName}} {{$user->lastName}}</p>
                            </td>
                            <td>
                                <p>{{$user->email}}</p>
                            </td>
                            <td>
                                <p>{{$user->streetAndNumber}}</p>
                                <p>{{$user->zipcode}} {{$user->placeOfResidence}}</p>
                            </td>
                            <td>
                                <p>{{$user->ipAddress}}</p>
                            </td>
                            <td>
                                @if($user->isAdmin)
                                    <p>Administrator</p>
                                @else
                                    <p>Deelnemer</p>
                                @endif                            
                            </td>
                            <td>
                                <a href="/deleteAUser/{{$user->id}}"><p>Verwijderen</p></a>
                                @if(!$user->isAdmin)
                                    <a href="/setUserAsAdmin/{{$user->id}}"><p>Maak administrator</p></a>
                                @else
                                    <a href="/setAdminAsNormalUser/{{$user->id}}"><p>Ontneem adminrechten</p></a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
          </table>
    </div>
    
    <div class="container">
        <h3>Alle gebruikers</h3>
        <table class="table table-hover">
            <thead>
              <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Adres</th>
                <th>IP-adres</th>
                <th>Rol</th>
              </tr>
            </thead>
            <tbody>
                @foreach($allUsers as $key => $user)
                    <tr>
                        <td>
                            <p>{{$user->firstName}} {{$user->lastName}}</p>
                        </td>
                        <td>
                            <p>{{$user->email}}</p>
                        </td>
                        <td>
                            <p>{{$user->streetAndNumber}}</p>
                            <p>{{$user->zipcode}} {{$user->placeOfResidence}}</p>
                        </td>
                        <td>
                                @if($user->isParticipant)
                                    <p>{{$user->ipAddress}}</p>
                                @else
                                    <p>Nog niet toegewezen</p>
                                @endif
                        </td>
                        <td>
                            @if($user->isAdmin)
                                <p>Administrator</p>
                            @elseif($user->isParticipant)
                                <p>Deelnemer</p>
                            @else
                                <p>Gebruiker</p>
                            @endif                            
                        </td>
                        <td>
                            <a href="/deleteAUser/{{$user->id}}"><p>Verwijderen</p></a>
                            @if(!$user->isAdmin)
                                <a href="/setUserAsAdmin/{{$user->id}}"><p>Maak administrator</p></a>
                            @else
                                <a href="/setAdminAsNormalUser/{{$user->id}}"><p>Ontneem adminrechten</p></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        
@endsection
