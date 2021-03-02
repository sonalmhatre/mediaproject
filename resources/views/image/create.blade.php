<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>


<div class="container py-5">
    
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
    
    <div class="row">
        <div class="col-md-10 mx-auto">
            {!! Form::open(array('route' => 'photos.store','method'=>'POST','files'=>true)) !!}
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="inputFirstname">Name</label>
                        
                         {!! Form::text('name', null, array('placeholder' => 'Enter name','class' => 'form-control', 'required' => true )) !!}
                    </div>
                   
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="inputFirstname">Image</label>
                        {!! Form::file('image_file', null, array('placeholder' => 'Enter name','class' => 'form-control', 'required' => true )) !!}
                    </div>
                   
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="inputFirstname">Provider</label>
                        {!! Form::select('provider_id',array(''=>'Select Provider')+$provider->toArray(),null, array('class' => 'form-control')) !!}
                    </div>
                   
                </div>
                 <div class="form-group row">
                    <button type="submit" class="btn btn-primary px-4 float-right">Save</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</body>
</html>