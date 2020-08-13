@extends('layouts.atllayout', ['title' => __("Edit Profiles")])

@section('content')
<div class="card">
    @if(isset($susscessMessage))
    <div class="alert alert-success" role="alert">
        {{$susscessMessage}}
    </div>
    @endif
    @if(isset($dangerMessage))
    <div class="alert alert-danger" role="alert">
        {{$dangerMessage}}
    </div>
    @endif
    @if(isset($warningMessage))
    <div class="alert alert-warning" role="alert">
        {{$warningMessage}}
    </div>
    @endif

    {{--<div class="top-card-button-wrapper">
        <a href="{{route('poll-management')}}" type="button" class="btn btn-primary btn-sm">{{ __("back") }}</a>
    </div>--}}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" {{ isset($item) ? 'action=' . route('my-profiles') :'action=' . route('my-profiles')  }}  enctype="multipart/form-data" >
                        {{ csrf_field() }}


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">{{__("Name")}}</label>

                            <div class="col-md-6">
                                <input id="id" type="hidden" class="form-control" name="id" value="{{isset($item) ? (isset($item->id) ? isset($item->id) : null) : null}}" required>
                                <input id="name" type="text" class="form-control" name="name" value="{{auth()->user()->name}}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                            <label for="surname" class="col-md-4 control-label">{{__("Surname")}}</label>

                            <div class="col-md-6">
                                <input id="profiles" type="text" class="form-control" name="surname" value="{{isset(auth()->user()->surname) ? auth()->user()->surname : ''}}">

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{__("Email")}}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{auth()->user()->email}}" disabled>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('profiles') ? ' has-error' : '' }}">
                            <label for="profiles" class="col-md-4 control-label">{{__("Profiles")}}</label>

                            <div class="col-md-6">
                                <select name="profiles" id="profiles" class="form-control" disabled>
                                    <option value="Interviewer" {{isset($user) && $user->profiles =="Interviewer" ? "selected" : ""}}>{{__("Interviewer")}}</option>
                                    <option value="Human resource" {{isset($user) && $user->profiles =="Human resource" ? "selected" : ""}}>{{__("Human resource")}}</option>
                                    <option value="Hiring manager" {{isset($user) && $user->profiles =="Hiring manager" ? "selected" : ""}}>{{__("Hiring manager")}}</option>
                                </select>
                                @if ($errors->has('profiles'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('profiles') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                            <label for="company_name" class="col-md-4 control-label">{{__("Company Name")}}</label>

                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control" name="company_name" value="{{isset($item->company_name) ? $item->company_name : ''}}" {{Illuminate\Support\Str::lower(auth()->user()->profiles) == Illuminate\Support\Str::lower("Human Resource") ? '' : 'disabled'}}>

                                @if ($errors->has('company_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('company_address') ? ' has-error' : '' }}">
                            <label for="company_address" class="col-md-4 control-label">{{__("Company Address")}}</label>

                            <div class="col-md-6">
                                <input id="company_address" type="text" class="form-control" name="company_address" value="{{isset($item->company_address) ? $item->company_address : ''}}" {{Illuminate\Support\Str::lower(auth()->user()->profiles) == Illuminate\Support\Str::lower("Human Resource") ? '' : 'disabled'}}>

                                @if ($errors->has('company_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('company_email') ? ' has-error' : '' }}">
                            <label for="company_email" class="col-md-4 control-label">{{__("Company Email")}}</label>

                            <div class="col-md-6">
                                <input id="company_email" type="text" class="form-control" name="company_email" value="{{isset($item->company_email) ? $item->company_email : ''}}" {{Illuminate\Support\Str::lower(auth()->user()->profiles) == Illuminate\Support\Str::lower("Human Resource") ? '' : 'disabled'}}>

                                @if ($errors->has('company_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('company_description') ? ' has-error' : '' }}">
                            <label for="company_description" class="col-md-4 control-label">{{__("Company Description")}}</label>

                            <div class="col-md-6">
                                <textarea id="company_description" type="text" class="form-control" name="company_description" value="" style="height: 200px" {{Illuminate\Support\Str::lower(auth()->user()->profiles) == Illuminate\Support\Str::lower("Human Resource") ? '' : 'disabled'}}>{{isset($item->company_description) ? $item->company_description : ''}}</textarea>
                                @if ($errors->has('company_description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('company_vat_number') ? ' has-error' : '' }}" >
                            <label for="company_vat_number" class="col-md-4 control-label">{{__("Company VAT Number")}}</label>

                            <div class="col-md-6">
                                <input id="company_vat_number" type="number" class="form-control" name="company_vat_number" value="{{isset($item->company_vat_number) ? $item->company_vat_number : ''}}" {{Illuminate\Support\Str::lower(auth()->user()->profiles) == Illuminate\Support\Str::lower("Human Resource") ? '' : 'disabled'}}>

                                @if ($errors->has('company_vat_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_vat_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('company_logo') ? ' has-error' : '' }}">
                            <label for="company_logo" class="col-md-4 control-label">{{__("Company Logo")}}</label>
                            <br>
                            <img style="height: 150px; margin-left: 15px" id="company_logo" type="number" src="{{isset($item->company_logo) ? $item->company_logo : ''}}"/>

                            @if ($errors->has('company_logo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('company_logo') }}</strong>
                                </span>
                            @endif
                        </div>

                        @if (Illuminate\Support\Str::lower(auth()->user()->profiles) == Illuminate\Support\Str::lower("Human Resource"))
                        <div class="form-group row">
                            <label class="col-form-label ml-2 col-lg-12">Please Select Image For The Company Logo </label>
                            <div class="col-lg-12 ml-2">
                                <input id="file" type="file" name="company_logo" value=""
                                       class="form-control h-auto" {{ isset($item) ? '' : 'required'}}  accept="image/x-png,image/gif,image/jpeg" />

                            </div>
                        </div>
                        @endif


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    {{isset($item) ? 'Edit submit' : 'Add'}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
