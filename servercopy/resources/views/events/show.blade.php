@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card box-shadow">
                    <img class="card-img-top"
                         src="https://user-images.githubusercontent.com/48566979/54383061-9eb8d580-4667-11e9-9f82-e5a23078e8a5.png"
                         alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{$event->title}}</h5>
                        <p class="card-text">{{$event->description}}.</p>
                        <p class="card-text"><small class="text-muted">Место проведения: {{$event->place}}</small></p>
@if(Auth::user()!==null && (Auth::user()->admin || $event->isUserExpert()))
                            <a href="{{$event->path()}}" class="btn btn-outline-secondary">View</a>
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{$event->title}}</div>

                    <div class="card-body">
                        <p>{{$event->description}}</p>
                        <p>Мероприятие начнется: {{\Carbon\Carbon::parse($event->dt)->format('H:i \o\n l jS F Y')}}</p>
                        <p>Окончание мероприятия: {{\Carbon\Carbon::parse($event->dt_exp)->format('H:i \o\n l jS F Y')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{$event->title}}</div>

                    <div class="card-body">
                        @if(Auth::user() === null)
                            <a class="btn btn-outline-secondary mb-3" href="{{ route('login') }}">Необходима авторизация</a>
                            @endif
                        @if(Auth::user() !== null && $event->isUserExpert() && $event->dt > Carbon\Carbon::now(+3))
                            <a class="btn btn-outline-secondary mb-3" data-toggle="collapse" href="#collapseExample"
                               role="button" aria-expanded="false" aria-controls="collapseExample">Добавить задание</a>

                        @elseif(Auth::user() !== null && !$event->isUserExpert() && $event->dt > Carbon\Carbon::now(+3) && !$event->isUserParticipant())
                            <a class="btn btn-outline-secondary mb-3" data-toggle="collapse" href="#collapseGroup"
                               role="button" aria-expanded="false" aria-controls="collapseGroup">Принять участие</a>
                        @endif
                        @if(Auth::user() !== null && $event->isUserExpert() && $event->dt_exp < \Carbon\Carbon::now(+3) && !$event->finished)
                            <form action="{{$event->path()}}/finish" method="POST">
                                @method('PATCH')
                                @csrf
                                <button class="btn btn-outline-secondary mb-3"
                                     role="button" aria-expanded="false">Завершить мероприятие</button>
                            </form>

                            @endif
                            @if($event->isUserExpert())
                                <div><a class="btn btn-outline-info" data-toggle="collapse" href="#collapseExpert">Добавить эксперта</a></div>
                                <div class="collapse" id="collapseExpert">
                                    <div class="card card-body">
                                        <form action=/events/{{$event->id}}/attachExpert method="POST">
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
                                @endif
                            @if($event->finished)
                                <h5 class="justify-content-center">Мероприятие закончилось ( ͡~ ͜ʖ ͡°)</h5>
                            @endif
                        @if(Auth::user() !== null && $event->isUserParticipant())
                                <div class="card text-white bg-dark mb-3" style="">
                                    <div class="card-header">{{$event->title}}</div>
                                    <div class="row no-gutters">
                                        <div class="col-md-4">
                                            <img src={{$event->group($event)->logo}} class="card-img" alt="...">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Ваша группа: {{$event->group($event)->name}}</h5>
                                            <p class="card-text">{{$event->group($event)->description}}</p>
                                            <a href={{$event->group($event)->path()}} type="button" class="btn btn-outline-light btn-sm">Смотреть группу</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        <div class="collapse" id="collapseExample">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">Добавить задание</div>

                                        <div class="card-body">
                                            <form action=/tasks/{{$event->id}} method="POST">

                                                @csrf
                                                <div class="form-group">
                                                    <label for="title">Заголовок *</label>
                                                    <input value="{{old("title")}}" name="title" type="text"
                                                           class="form-control" id="title" aria-describedby="titleHelp"
                                                           linkholder="Enter title">
                                                    <small id="titleHelp" class="form-text text-muted">The title</small>
                                                    @error('title')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>


                                                <div class="form-group">
                                                    <label for="rate">Оценка *</label>
                                                    <input value="{{old("rate")}}" name="rate" type="number"
                                                           class="form-control" id="rate" aria-describedby="rateHelp"
                                                           linkholder="Enter rate">
                                                    <small id="rateHelp" class="form-text text-muted">The rate</small>
                                                    @error('rate')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="task">Задание *</label>
                                                    <textarea value="{{old("task")}}" name="task" type="text"
                                                              class="form-control" id="task" aria-describedby="taskHelp"
                                                              taskholder="Enter the task of the news"
                                                              rows="3">{{old("task")}}</textarea>
                                                    <small id="taskHelp" class="form-text text-muted">The task</small>
                                                    @error('task')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="link">Дополнительная ссылка </label>
                                                    <textarea value="{{old("link")}}" name="link" type="text"
                                                              class="form-control" id="link" aria-describedby="linkHelp"
                                                              linkholder="Enter the link of the news"
                                                              rows="3">{{old("link")}}</textarea>
                                                    <small id="linkHelp" class="form-text text-muted">The link</small>
                                                    @error('link')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="right_answer">Правильный ответ </label>
                                                    <input value="{{old("right_answer")}}" name="right_answer"
                                                           type="text" class="form-control" id="right_answer"
                                                           aria-describedby="right_answerHelp"
                                                           linkholder="Введите правильный ответ (если есть)">
                                                    <small id="right_answerHelp" class="form-text text-muted">Введите
                                                        правильный ответ (если есть)</small>
                                                    @error('right_answer')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>

                                                <button type="submit" class="btn btn-primary">Создать задание</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="collapseGroup">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">Создать группу</div>

                                        <div class="card-body">
                                            <form action=/groups/{{$event->id}} method="POST">

                                                @csrf
                                                <div class="form-group">
                                                    <label for="name">Название команды *</label>
                                                    <input value="{{old("name")}}" name="name" type="text"
                                                           class="form-control" id="name" aria-describedby="nameHelp"
                                                           linkholder="Enter name">
                                                    <small id="nameHelp" class="form-text text-muted">The name</small>
                                                    @error('name')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Описание *</label>
                                                    <textarea value="{{old("description")}}" name="description" type="text"
                                                              class="form-control" id="description" aria-describedby="descriptionHelp"
                                                              taskholder="Enter the description"
                                                              rows="3">{{old("description")}}</textarea>
                                                    <small id="descriptionHelp" class="form-text text-muted">The description</small>
                                                    @error('description')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="logo">Логотип группы </label>
                                                    <textarea value="{{old("logo")}}" name="logo" type="text"
                                                              class="form-control" id="logo" aria-describedby="logoHelp"
                                                              linkholder="Enter the logo"
                                                              rows="3">{{old("logo")}}</textarea>
                                                    <small id="logoHelp" class="form-text text-muted">The logo</small>
                                                    @error('logo')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>

                                                <button type="submit" class="btn btn-dark">Создать группу</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Список групп-участников</div>

                    <div class="card-body">
            <div id="carouselGroupControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img style="height:300px !important; min-height: 300px !important;" class="" src="https://www.technistone.com/color-range/image-slab/deska_noble_desiree_grey_p.jpg" alt="First slide">
                         <div class="carousel-caption d-none d-md-block">
                        <h5 style="background-color: rgba(0,0,0,0.6);" class="text-light">Здесь будет ваша реклама</h5>
                         </div>
                    </div>
                    @foreach($event->groups as $group)
                    <div class="carousel-item">
                        <img style="height:300px !important; min-height: 300px !important;" class="" src="{{$group->logo}}" alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5 style="background-color: rgba(0,0,0,0.6);" class="text-light">Группа: {{$group->name}}</h5>
                            <p style="background-color: rgba(0,0,0,0.6);" class="text-light">Описание: {{$group->description}}</p>
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
            @if(Auth::user() !== null && ($event->isUserExpert() || $event->dt < \Carbon\Carbon::now(+3) || Auth::user()->admin))
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Список заданий</div>

                        <div class="card-body">
                            @foreach($event->tasks as $task)
                                <div class="card border-info mb-3" style="max-width: 18rem;">
                                    <div class="card-header">{{$task->title}}</div>
                                    <div class="card-body text-info">
                                        <h5 class="card-title">Оценивается в {{$task->rate}} баллов</h5>
                                        <a href="{{$task->path()}}" class="btn btn-outline-secondary">View</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Список жюри</div>

                    <div class="card-body">
                        <div id="carouselExpertControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img style="height:300px !important; min-height: 300px !important;" class="" src="https://www.technistone.com/color-range/image-slab/deska_noble_desiree_grey_p.jpg" alt="First slide">
                                </div>
                                @foreach($event->users as $expert)
                                    <div class="carousel-item">
                                        <img style="height:300px !important; min-height: 300px !important;" class="" src="{{$expert->image}}" alt="First slide">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5 style="background-color: rgba(0,0,0,0.6);">Эксперт: {{$expert->name}} {{$expert->surname}}</h5>
                                            <p style="background-color: rgba(0,0,0,0.6);">Login: {{$expert->login}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExpertControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExpertControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($event->finished)
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Результаты мероприятия "{{$event->title}}"
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#collapseCommon" aria-expanded="false" aria-controls="collapseCommon">Общий зачет</button>
                        <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#collapseParticular" aria-expanded="false" aria-controls="collapseParticular">Рейтинг по вопросам</button>
                    </div></div>

                <div class="card-body">

                    <div class="collapse" id="collapseCommon">
                        <table class="table table-striped table-dark">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Score</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($event->overallResults() as $key => $group)
                            <tr>

                                <th scope="row">{{$key + 1}}.</th>
                                <td>Группа: {{$group->name}}</td>
                                <td>Кол-во баллов: {{$group->total}}</td>

                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="collapse" id="collapseParticular">
                        <select onselect="" name="taskId" class="custom-select">
                            <option selected>Выбрать задание</option>
                            @foreach($event->tasks as $task)
                            <option value="{{$task->id}}">{{$task->title}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
            </div>
        </div>
            @endif
        </div>

    @endif
@endsection
