@extends('layouts.atllayout', ['title' => isset($item) ? 'Edit Catagory' : 'Add Catagory' ])

@section('content')
<div class="card">
	<div class="card-body">
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
    
        <div class="top-card-button-wrapper">
            <a href="{{route('catagory-management')}}" type="button" class="btn btn-primary btn-sm mb-2">back</a>
        </div>
    
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" {{ isset($item) ? 'action=' . route('catagory-management/edit') :'action=' . route('catagory-management/add')  }}  enctype="multipart/form-data" >
                            {{ csrf_field() }}
    
    
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Catagory Name</label>
    
                                <div class="col-md-6">
                                    <input id="id" type="hidden" class="form-control" name="id" value="{{isset($item) ? $item->id : ''}}" required autofocus>
                                    <input id="name" type="text" class="form-control" name="name" value="{{isset($item) ? $item->name : ''}}" required autofocus>
    
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <?php 
                                $listMenu = App\Model\Menu::orderBy('created_at', 'desc')->get();
                            ?>
                            
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Menu Name</label>
    
                                <div class="col-md-6">
									<select name="menu_id" id="cars" class="form-control">
    									@foreach ($listMenu as $indexKey => $itemMenu)
    										<option value="{{$itemMenu->id}}" {{(isset($item) && $itemMenu->id == $item->menu_id) || (isset($menu_id) && $itemMenu->id == $menu_id)  ? 'selected' : ''}}>{{$itemMenu->name}}</option>
                                		@endforeach
									</select> 
									@if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            
    
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
</div>

@if(isset($popupMode))
<script>
	$(".navbar-custom").hide();
	$(".left-side-menu").hide();
	$(".page-title-box").hide();
	$(".top-card-button-wrapper").hide();
	$(".content-page").css("margin-left","0px");
	$(".content-page").css("margin-top","0px");
	$(".content-page").css("padding-left","0px");
	$(".content-page").css("padding-bottom","0px");
	$(".content-page").css("padding-right","0px");
	$(".content").css("padding-left","0px");
	$(".content").css("padding-top","0px");
	$(".content").css("padding-bottom","0px");
	$(".content").css("padding-right","0px");
	$(".container-fluid").css("padding-left","0px");
	$(".container-fluid").css("padding-right","0px");
	$("body").css("padding-bottom","0px");
	$("body").css("overflow","hidden");
	setTimeout(function(){ $("#lastfooter").hide(); }, 500);
</script>
@endif
@endsection
