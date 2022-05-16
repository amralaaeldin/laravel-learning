@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <div class="my-3">

                        @if (session()->has('data.github'))
                            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#showGithubData">
                                Show Github Data
                              </button>
                              <!-- Modal -->
                            <div class="modal fade" id="showGithubData" tabindex="-1" aria-labelledby="showGithubDataLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="showGithubDataLabel">Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-4">
                                            <img src="{{ session()->get('data.github')['avatar_url'] }}" class="img-fluid rounded-start" alt="avatar">
                                        </div>
                                        <p><b>Id</b>: {{ session()->get('data.github')['id'] }}</p>
                                        <p><b>Name</b>: {{ session()->get('data.github')['name'] }}</p>
                                        <p><b>repos_url</b>: <a href="{{ session()->get('data.github')['repos_url'] }}">https://api.github.com/users/amralaaeledin/repos</a></p>
                                        <p><b>html_url</b>: <a href="{{ session()->get('data.github')['html_url'] }}">https://github.com/amralaaeledin</a></p>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        @else
                            <a class="btn btn-dark" href="/connect/github">
                                Connect to Github
                            </a>
                        @endif
                        @if (session()->has('data.google'))
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#showData">
                                Show Google Data
                              </button>
                              <!-- Modal -->
                            <div class="modal fade" id="showData" tabindex="-1" aria-labelledby="showDataLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="showDataLabel">Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-md-4">
                                            <img src="{{ session()->get('data.google')['avatar_url'] }}" class="img-fluid rounded-start" alt="avatar">
                                        </div>
                                        <p><b>Id</b>: {{ session()->get('data.google')['id'] }}</p>
                                        <p><b>Name</b>: {{ session()->get('data.google')['name'] }}</p>
                                        <p><b>Email</b>: {{ session()->get('data.google')['email'] }}</p>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        @else
                            <a class="btn btn-primary" href="/connect/google">
                                Connect to Google
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
