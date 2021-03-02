<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	@if(Session::has('success'))
        <p class="alert alert-success">{{Session::get('success')}}</p> 
    @endif
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
        	<a href="{{route('photos.create')}}" class="btn btn-info">Add New</a>
        	<br><br>
			<table class="table">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Name</th>
			      <th scope="col">Provider</th>
			      <th scope="col">File</th>
			      <th scope="col">Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($images as $key=>$value)
			  	
			    <tr>
			      <th scope="row">{{$key+1}}</th>
			      <td>{{ $value->name }}</td>
			      <td>{{ $value->provider->name }}</td>
			      <td><img src="{{ $value->image_file }}" height="50px" width="50px"></td>
			      <td><a href="{{route('photos.edit',$value->id)}}" class="btn btn-info">Edit</a></td>
			    </tr>
			    @endforeach
			    
			  </tbody>
			</table>
			{{ $images->links() }}
		</div>
	</div>
</div>



</body>
</html>