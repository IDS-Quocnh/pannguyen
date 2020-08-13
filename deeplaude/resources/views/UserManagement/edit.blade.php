@extends('layouts.atllayout', ['title' => 'Edit User', 'menukey' => 'userManager'])
@section('content')

@if(isset($susscessMessage))
<div class="alert alert-success" role="alert">
    {{$susscessMessage}}
</div>15
@endif
<div class="card">
    <div class="container" style="margin-left: 15px; padding-top: 15px">
        @if(Auth::user()->is_admin == 1)
            <div class="top-card-button-wrapper">
                <a href="{{route('user-management')}}" type="button" class="btn btn-success btn-sm">back</a>
            </div>
        @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('user-management/edit') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="username" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="id" type="hidden" class="form-control" name="id" value="{{ $user->id }}" required autofocus>
                                <input id="username" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                            <label for="surname" class="col-md-4 control-label">Surname</label>

                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control" name="surname" value="{{ $user->surname }}" required autofocus>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">New Password (optional)</label>

                            <div class="col-md-6">
                                <input id="password" type="text" class="form-control" name="password" autocomplete="new-password" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_admin" class="col-md-4 control-label">User profiles</label>

                            <div class="col-md-6" style="text-align: left">
                                <select name="profiles" id="profiles" class="form-control">
                                    <option value="Interviewer" {{isset($user) && $user->profiles =="Interviewer" ? "selected" : ""}}>{{__("Interviewer")}}</option>
                                    <option value="Human Resource" {{isset($user) && $user->profiles =="Human Resource" ? "selected" : ""}}>{{__("Human Resource")}}</option>
                                    <option value="Hiring Manager" {{isset($user) && $user->profiles =="Hiring Manager" ? "selected" : ""}}>{{__("Hiring Manager")}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div
        </div>
    </div>
</div>
</div>
<script>
    $('#countryCode option[value={{$user->country_code}}]').attr('selected','selected');
</script>
@endsection
