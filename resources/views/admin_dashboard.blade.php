@extends('layouts.app')

@section('content')
<div class="container mb-3">
<div class="card container shadow-sm bg-light" style="width: auto;">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h5 class="card-title">Greetings {{ Auth::user()->usr_name }}</h5>
            <a href="/logout" class="mt-1">Logout</a>
        </div>
    </div>
</div>
</div>
<div class="container mb-3">
    <div id="rolesManager"></div>
</div>
<div class="container">
    <div id="usersManager"></div>
</div>

@endsection
