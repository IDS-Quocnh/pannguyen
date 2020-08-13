@extends('layouts.atllayout', ['title' => 'User List', 'menukey' => 'userManager'])

@section('content')
@if(Auth::user()->is_admin == 1)
@endif
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
<link href="{{ asset('assets/blacktheme/atom.css') }}" rel="stylesheet">
<link href="{{ asset('assets/blacktheme/led_lights.css') }}" rel="stylesheet">
<div class="card">
    <table class="table datatable-button-html5-basic">
   <thead>
      <tr class="bg-primary border border-secondary text-white">
         <th scope="col">User Name</th>
         <th scope="col">Surname</th>
         <th scope="col">Email Address</th>
         <th scope="col">User Profiles</th>
         <th scope="col"></th>
      </tr>
   </thead>
   <tbody class="table-bordered">
   @foreach ($userList as $user)
      <tr>
         <td class="align-middle"><a href="{{route('user-management/edit',['id' => $user->id])}}">{{$user->name}}</a></td>
         <td class="align-middle">{{$user->surname}}</td>
         <td class="align-middle">{{$user->email}}</td>
         <td class="align-middle">{{$user->profiles}}</td>
         <td class="align-middle text-left">
             @if(Auth::user()->is_admin == 1)
                 <a href="{{route('user-management/edit',['id' => $user->id])}}" type="button" class="btn btn-primary btn-sm" >Edit</a>
                 <form method="POST" action="{{ route('user-management/delete') }}" style="display: inline-block">
                     {{ csrf_field() }}
                     <input type="hidden" name="id" value="{{$user->id}}" />
                     <button type="submit" class="btn btn-danger btn-sm" style="color: white">Delete</button>
                 </form>
             @endif
         </td>
      </tr>
      @endforeach
   </tbody>
</table>
</div>
@endsection
