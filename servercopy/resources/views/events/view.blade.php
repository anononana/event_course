
@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="card-deck row">
            @foreach($data as $event)
                <div class="col-md-4">
                    <div class="card box-shadow">
                        <img class="card-img-top" src="https://user-images.githubusercontent.com/48566979/54383061-9eb8d580-4667-11e9-9f82-e5a23078e8a5.png" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$event->title}}</h5>
                            <p class="card-text">{{$event->description}}.</p>
                            <p class="card-text"><small class="text-muted">Место проведения: {{$event->place}}</small></p>
                            <p class="card-text"><small class="text-muted">Даты проведения: {{\Carbon\Carbon::parse($event->dt)->format('H:i \o\n l jS F Y')}} — {{\Carbon\Carbon::parse($event->dt_exp)->format('H:i \o\n l jS F Y')}}</small> </p>

                                <a href="{{$event->path()}}" class="btn btn-outline-secondary">View</a>
@if(Auth::user() !== null && in_array(Auth::user()->id, App\Expert::where('event_id', $event->id)->pluck('user_id')->toArray()))
                                    <a href="{{$event->path()}}/edit" class="btn btn-outline-secondary">Edit</a>
                                <button type="button" class="btn btn-outline-danger float-right" data-toggle="modal" data-target="#deleteModalCenter">
                                    Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="deleteModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLongTitle">Вы действительно хотите удалить мероприятие?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{$event->path()}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <a type="button" class="btn btn-outline-danger-info" data-dismiss="modal">Close</a>
                                                    <button class="btn btn-outline-danger float-right">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
