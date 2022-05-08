@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{route('posts.store')}}">
    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input name="title" value="{{ old('title') }}" type="text" class="form-control" id="title">
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea name='description' id='description' class="form-control">{{ old('description') }}</textarea>
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
