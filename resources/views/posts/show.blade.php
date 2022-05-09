@extends('layouts.app')
@section('content')

<div class="card"">
    <div class="card-header">
      Post Details
    </div>
      <h3 class="card-text">{{$post->title}}</h3>
      <p class="card-text">{{$post->description}}</p>
    </div>
  </div>

  @endsection
