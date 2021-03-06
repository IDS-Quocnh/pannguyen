@extends('layouts.atllayout', ['title' => $itemCatagory->name, 'menukey' =>
'dataCenter']) @section('content')
<div class="card">
	<div class="card-body">
	
		<div class="top-card-button-wrapper" style="display: inline-block;">
            <a href="/catagory-management/show?id={{$itemCatagory->id}}" type="button" class="btn btn-primary btn-sm mb-2">Back to Catagory</a>
        </div>

		<div class="dropdown float-right">
			<a href="#" class="dropdown-toggle arrow-none card-drop"
				data-toggle="dropdown" aria-expanded="false"> <i
				class="dripicons-dots-3"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right" style="">
				<!-- item-->
				<a href="javascript:void(0);" class="dropdown-item img-edit"><i
					class="mdi mdi-pencil mr-1"></i>Edit</a>
				<!-- item-->
				<a href="javascript:void(0);" class="dropdown-item img-delete"><i
					class="mdi mdi-delete mr-1"></i>Delete</a>
			</div>
		</div>


		@if(isset($susscessMessage))
		<div class="alert alert-success" role="alert">{{$susscessMessage}}</div>
		@endif @if(isset($dangerMessage))
		<div class="alert alert-danger" role="alert">{{$dangerMessage}}</div>
		@endif @if(isset($warningMessage))
		<div class="alert alert-warning" role="alert">{{$warningMessage}}</div>
		@endif
		
		<div style="border-bottom: 1px solid #e4e4e4"></div>
		<div>
			<div class="post-title pb-3">
				<h4 style="padding: 0; margin: 0; line-height: 40px">{{$item->name}}</h4>
			</div>
			<div class="post-content">
				{!! $item->content !!}
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="editPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" >
  <div class="modal-dialog" role="document" style="max-width: 1200px;">
    <div class="modal-content" style="height: 900px"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Catagory</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-top: 0px">
      	<iframe id="editCatagoryFrame" src="/post-management/edit?popupMode=true&id={{$item->id}}" style="width: 100%; height:100%; overflow: hidden;" frameBorder="0"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="clickImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" >
  <div class="modal-dialog" role="document" style="max-width: 1800px;">
    <div class="modal-content" style="height: 900px"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Image Show</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="padding-top: 0px">
      	<iframe id="showImageFrame" src="http://www.pannguyen.com/storage/app/upload_me/0.JPG" style="width: 1800px; height:100%; overflow: hidden;" frameBorder="0"></iframe>
      </div>
    </div>
  </div>
</div>

<div class="top-card-button-wrapper" >
	<button data-toggle="modal" data-target="#editPost" id="btnOpenEditModal" hidden
		class="btn btn-success btn-sm mb-2" style="color:white">Edit Post</button>
		
	<button data-toggle="modal" data-target="#clickImage" id="btnClickImage" hidden
	class="btn btn-success btn-sm mb-2" style="color:white">ShowImage</button>
</div>
<script>
	$(".img-delete").click(function(){
		keepRefresh = false;
		token = $('[name ="_token"]').val();
		$.ajax({
			url: "/post-management/delete",
			type: "post",
		    data: {_token : token, id : {{$item->id}}},
			success: function(result){
				window.location.href = "/catagory-management/show?id=" + {{$itemCatagory->id}};
		  }});
	});

	$(".img-edit").click(function(){
		keepRefresh = false;
		$('#btnOpenEditModal').trigger('click');
	});
	
	$(".post-content img").click(function(){
		keepRefresh = true;
		$('#showImageFrame').attr("src", $(this).attr("src"));
		$('#btnClickImage').trigger('click');
		setTimeout(function(){$('#showImageFrame').contents().find('img').css("max-width", "1770px"); }, 200);
		
	});
	
	$(".post-content img").css("cursor", "pointer");
	
	
	
</script>

<style>
	.post-content img {
	  background: url(img/duck.png) no-repeat;
	  -moz-box-shadow: 0px 6px 5px #ccc;
	  -webkit-box-shadow: 0px 6px 5px #ccc;
	  box-shadow: 0px 6px 5px #ccc;
	  border-radius: 5px;
	  margin-bottom : 10px;
	}
</style>

@endsection
