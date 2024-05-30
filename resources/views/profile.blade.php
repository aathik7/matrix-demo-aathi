@extends('layout')
  
@section('content')
<div class="container" style="font-family: Nunito Sans;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header"><h3>{{ __('User Profile') }}</h3></div>

            <div class="name-box">
                <b><h2>{{$userDetails['name']}}</h2></b>
                <b>Email: </b> {{$userDetails['email']}}
            </div>
        </div>
    </div>
</div>
<style>
    .name-box {
        background-color: #f5f8fa;
        width: 300px;
        border: 1px solid #e3e3e3;
        padding: 20px;
        margin: 20px;
    }
</style>
@extends('footer')
@endsection