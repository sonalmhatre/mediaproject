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
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
</div>
@endif
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            {!! Form::model($video, ['method' => 'PATCH','route' => ['videodata.update', $video->id],'files'=>true, 'class'=>'j-pro']) !!} @csrf
                 <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="inputFirstname">Name</label>
                        
                        {!! Form::text('name', null, array('placeholder' => 'Enter name','class' => 'form-control', 'required' => true )) !!}
                    </div>
                  
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="inputAddressLine1">Video File</label>
                       
                        {!! Form::file('video_file', null, array('placeholder' => 'Enter name','class' => 'form-control', 'required' => true )) !!}
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="inputFirstname">Provider</label>
                        {!! Form::select('provider_id',array(''=>'Select Provider')+$provider->toArray(),null, array('class' => 'form-control')) !!}
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

 
                                            