@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref full-height">
            <div class="sellBike">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" enctype="multipart/form-data" action="/postNewParticipantPage1Data" >
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            @guest
                                <label for="email" class="col-md-4 control-label">Email*</label>
                            @endguest

                            <div class="col-md-6">
                                @auth
                                    <input id="email" type="hidden" class="form-control" name="email" value="{{ Auth::user()->email }}" required autofocus>
                                @else
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @endauth

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
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
                                    Volgende
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
