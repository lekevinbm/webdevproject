@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref full-height">
            <div class="sellBike">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="/registerNewParticipant" >
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                            <label for="firstName" class="col-md-4 control-label">Voornaam*</label>

                            <div class="col-md-6">
                                <input id="firstName" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required autofocus>

                                @if ($errors->has('firstName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                            <label for="lastName" class="col-md-4 control-label">Achternaam*</label>

                            <div class="col-md-6">
                                <input id="lastName" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required autofocus>

                                @if ($errors->has('lastName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email*</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
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

                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <label for="image" class="col-md-4 control-label">Voeg je #FIFAISBAE-afbeelding toe*</label>
                            <div class="col-md-6">
                                <input type="file" name="image" /><br/>
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('caption') ? ' has-error' : '' }}">
                            <label for="caption" class="col-md-4 control-label">Schrijf een originele caption*</label>
                            <div class="col-md-6">
                                <textarea id="caption" type="text" class="form-control" name="caption" required>{{ old('caption') }}</textarea>
                                @if ($errors->has('caption'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('caption') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('serialNumberOfGame') ? ' has-error' : '' }}">
                            <label for="serialNumberOfGame" class="col-md-4 control-label">Serienummer van het jouw FIFA 18-spel*</label>

                            <div class="col-md-6">
                                <input id="serialNumberOfGame" type="text" class="form-control" name="serialNumberOfGame" value="{{ old('serialNumberOfGame') }}" required autofocus>

                                @if ($errors->has('serialNumberOfGame'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serialNumberOfGame') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Deelname opsturen
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
