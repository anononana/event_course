@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-6 text-white bg-dark mb-3" style="">
                <div class="card-header">{{$group->event->title}}</div>
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src={{$group->logo}} class="card-img" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Ваша группа: {{$group->name}}</h5>
                        <p class="card-text">{{$group->description}}</p>
                        <a href={{$group->event->path()}} type="button" class="btn btn-outline-light btn-sm">Смотреть мероприятие</a>
                        <a data-toggle="modal" data-target="#participantModal" type="button" class="btn btn-outline-light btn-sm">Пригласить участников</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Мероприятие, в котором вы участвуете</div>

                    <div class="card-body">
                        <p>{{$group->event->title}}</p>
                        <p>{{$group->event->description}}</p>
                        <a href="{{$group->event->path()}}" class="btn btn-outline-dark">Перейти к мероприятию</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Список участников</div>

                    <div class="card-body">
                        <div id="carouselGroupControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img style="height:300px !important; min-height: 300px !important;" class="" src="https://www.technistone.com/color-range/image-slab/deska_noble_desiree_grey_p.jpg" alt="First slide">
                                </div>
                                @foreach($group->users as $participant)
                                    <div class="carousel-item">
                                        <img style="height:300px !important; min-height: 300px !important;" class="" src="{{$participant->image}}" alt="First slide">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5 style="background-color: rgba(0,0,0,0.6);" class="text-light">Участник: {{$participant->name}} {{$participant->surname}}</h5>
                                            <p style="background-color: rgba(0,0,0,0.6);" class="text-light">Логин: {{$participant->login}}</p>
                                        </div>
                                    </div>
                            @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselGroupControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselGroupControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="participantModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Введите логин пользователя</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card card-body">
                                <form action=/groups/{{$group->id}}/attach method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="login">Логин пользователя *</label>
                                        <input value="{{old("login")}}" name="login" type="text"
                                               class="form-control" id="login" aria-describedby="loginHelp"
                                               linkholder="Enter login">
                                        <small id="loginHelp" class="form-text text-muted">The title</small>
                                        @error('login')
                                        <small class="text-danger">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <button class="btn btn-outline-dark">Добавить</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

    </div>
@endsection
