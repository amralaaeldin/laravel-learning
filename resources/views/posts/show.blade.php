@extends('layouts.app')
@section('content')

<div class="card"">
    <div class="card-header">
      Post Details
    </div>
      <p class="card-text">{{$post->description}}</p>
    </div>
  </div>

  @endsection
