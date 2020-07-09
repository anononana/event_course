@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">My articles</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="/articles/create" class="btn btn-dark">Create New Articles</a>
                    </div>

                    <div class="card-deck row">
                        @foreach($articles as $article)
                            <div class="col-md-4">
                                <div class="card box-shadow">
                                    <img class="card-img-top" src={{$article->image}} alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$article->topic}}</h5>
                                        <p class="card-text">{{$article->description}}.</p>
                                        <p class="card-text"><small class="text-muted">Author: you</small></p>
                                        <form action="{{$article->path()}}" method="POST">
                                            <a href="{{$article->path()}}" class="btn btn-outline-secondary">View</a>
                                            <a href="{{$article->path()}}/edit" class="btn btn-outline-secondary">Edit</a>
                                            @method('DELETE')
                                            @csrf

                                            <button class="btn btn-outline-danger float-right">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
