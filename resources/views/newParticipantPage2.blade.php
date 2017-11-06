@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref full-height">
            @guest
                <p>Je hebt een account nodig om een afbeelding in te zenden.</p>
            @else
                <p>We hebben nog enkele gegevens nodig.</p>
            @endguest
            <div class="">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="/registerNewParticipant" >
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                            @guest
                                <label for="firstName" class="col-md-4 control-label">Voornaam*</label>
                            @endguest
                            <div class="col-md-6">
                                @guest
                                    <input id="firstName" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required autofocus>
                                @endguest

                                @if ($errors->has('firstName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                            @guest
                                <label for="lastName" class="col-md-4 control-label">Achternaam*</label>
                            @endguest
                            <div class="col-md-6">
                                @guest
                                    <input id="lastName" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required autofocus>
                                @endguest
                                @if ($errors->has('lastName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        

                        <div class="form-group{{ $errors->has('streetAndNumber') ? ' has-error' : '' }}">
                            <label for="streetAndNumber" class="col-md-4 control-label">Straat en nummer*</label>

                            <div class="col-md-6">
                                <input id="streetAndNumber" type="text" class="form-control" name="streetAndNumber" value="{{ old('streetAndNumber') }}" required autofocus>

                                @if ($errors->has('streetAndNumber'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('streetAndNumber') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                            <label for="zipcode" class="col-md-4 control-label">Postcode*</label>

                            <div class="col-md-6">
                                <input id="zipcode" type="text" class="form-control" name="zipcode" value="{{ old('zipcode') }}" required autofocus>

                                @if ($errors->has('zipcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zipcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('placeOfResidence') ? ' has-error' : '' }}">
                            <label for="placeOfResidence" class="col-md-4 control-label">Woonplaats*</label>

                            <div class="col-md-6">
                                <input id="placeOfResidence" type="text" class="form-control" name="placeOfResidence" value="{{ old('placeOfResidence') }}" required autofocus>

                                @if ($errors->has('placeOfResidence'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('placeOfResidence') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            @guest
                                <label for="email" class="col-md-4 control-label">Email*</label>
                            @endguest
                            <div class="col-md-6">
                                @guest
                                    <input disabled id="email" type="email" class="form-control" name="email" value="{{ $participantEmail }}" required autofocus>
                                @endguest
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            @guest
                                <label for="password" class="col-md-4 control-label">Wachtwoord*</label>
                            @endguest
                            <div class="col-md-6">
                                @guest
                                    <input id="password" type="password" class="form-control" name="password" required>
                                @endguest
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Zend foto in
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
