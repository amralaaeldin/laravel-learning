@extends('layouts.app')
    @section('content')
        <a href="{{route('posts.create')}}" class="btn btn-success">Create Post</a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">title</th>
                    <th scope="col">posted by</th>
                    <th scope="col">created at</th>
                    <th scope="col">actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($posts as $post)
                <tr>
                @if ($post->trashed())
                <th scope="row">{{$post->id}}</th>
                <td colspan="3"></td>
                <td colspan="3">
                    <form style="display: inline" action="{{route('posts.restore', ['postId'=>$post->id])}}"
                        method="POST">
                        @csrf
                        <input hidden type="text" value='{{ $post->id }}'>
                        <button type="submit" class="btn btn-outline-secondary">Restore</button>
                    </form>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#modalForce{{$post->id}}">
                        Force Delete
                    </button>
                    <div class="modal fade" id="modalForce{{$post->id}}" tabindex="-1" aria-labelledby="modal{{$post->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalForce{{$post->id}}Label">You Sure you want to delete this ?</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <form style="display: inline" action="{{route('posts.delete', ['postId'=>$post->id])}}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <input hidden type="text" value='{{ $post->id }}'>
                                <button type="submit" class="btn btn-danger">Force Delete</button>
                            </form>
                            </div>
                          </div>
                        </div>
                      </div>
                </td>
                @else
                <th scope="row">{{$post->id}}</th>
                <td>{{$post->title}}</td>
                <td>{{$post->user->name ?? 'unknown'}}</td>
                <td>{{\Carbon\Carbon::create($post->created_at)->format('l jS \\of F Y h:i:s A');}}</td>
                <td colspan="3">
                    <a href='{{route('posts.show', ['postId'=>$post->id])}}' class="btn btn-info">View</a>
                    {{-- <button type="button" data-id='{{ $post->id }}' class="btn btn-info showModalBtn"
                        data-bs-toggle="modal" data-bs-target="#showModal">
                        View
                      </button> --}}
                    <a href='{{route('posts.edit', ['postId'=>$post->id])}}' class="btn btn-primary">Edit</a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#modal{{$post->id}}">
                        Delete
                    </button>
                      <!-- Modal -->
                  <div class="modal fade" id="modal{{$post->id}}" tabindex="-1" aria-labelledby="modal{{$post->id}}" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modal{{$post->id}}Label">You Sure you want to delete this ?</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form style="display: inline" action="{{route('posts.destroy', ['postId'=>$post->id])}}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <input hidden type="text" value='{{ $post->id }}'>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                @endif
                </tr>
                @endforeach

            </tbody>
        </table>


        <footer class="py-5">
            {{ $posts->links() }}
        </footer>
        @endsection


{{--
  <!-- Modal -->
  <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="showModal"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id='post_title'></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id='post_description'></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> --}}


        {{-- @section('script')

    <script>
        const modalBtn = document.querySelectorAll(".showModalBtn"),
              table = document.querySelector(".table"),
              postTitle = document.querySelector("#post_title"),
              postDescription = document.querySelector("#post_description");

            const fetchData = async (postId) => {
                        const res = await fetch(`/posts/${postId}`)
                        const data = await res.json()
                        postTitle.innerText = data.title
                        postDescription.innerText = data.description
                }

            const showData = (e) => {
                e.preventDefault();
                if ([...e.target.classList].includes('showModalBtn')) {
                    const modalBtn = e.target,
                    postId = modalBtn.dataset.id;
                    fetchData(postId);
                    };
                };

        table.addEventListener("click", showData);

    </script>
        @endsection --}}
