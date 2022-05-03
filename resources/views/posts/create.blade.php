@extends('layouts.app')

@section('content')
<form method="POST" action="{{route('posts.store')}}">
    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input name="title" type="text" class="form-control" id="title">
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea name='description' id='description' class="form-control"></textarea>
    </div>
    <div class="mb-3">
      <label for="posted_by" class="form-label">posted_by</label>
      <select class="form-control" name="user_id" id="posted_by">
        @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-success">Create</button>
  </form>


@endsection
