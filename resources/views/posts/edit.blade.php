@extends('layouts.app')

@section('content')
<form method="POST" action="{{route('posts.update')}}">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input value="{{ $post->title }}" name="title" type="text" class="form-control" id="title">
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea name='description' id='description' class="form-control">{{ $post->description }}</textarea>
    </div>
    <div class="mb-3">
      <label for="posted_by" class="form-label">posted_by</label>
      <select class="form-control" name="user_id" id="posted_by">
        @foreach ($users as $user)
        <option @if ($post->user_id === $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Edit</button>
  </form>


@endsection
