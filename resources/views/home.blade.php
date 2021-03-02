@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{route('providers.index')}}" class="btn btn-primary">Providers List</a><br><br>
                    <a href="{{route('videodata.index')}}" class="btn btn-primary">Video List</a>
                    <br><br>
                    <a href="{{route('photos.index')}}" class="btn btn-primary">Image List</a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
