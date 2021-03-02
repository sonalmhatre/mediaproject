<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if(Session::has('error'))
        <p class="alert alert-danger">{{Session::get('error')}}</p> 
    @endif
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            
            {!! Form::open(array('route' => 'providers.store','method'=>'POST','files'=>true)) !!}
                 <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="inputFirstname">Name</label>
                        <input type="text" name="name" class="form-control" id="inputFirstname" placeholder="Name">
                    </div>
                  
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="inputAddressLine1">Description</label>
                        <textarea type="textarea" name="description" class="form-control" id="inputAddressLine1" placeholder="Street Address"></textarea>
                    </div>
                    
                </div>
                
              <div class="form-group row">
                <button  class="btn btn-primary px-4 float-right">Save</button>
              </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</body>
</html>