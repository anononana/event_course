@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Event</div>

                    <div class="card-body">
                        <form action="/events/{{$event->id}}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input value="{{$event->title}}" name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" placeholder="Enter title">
                                <small id="titleHelp" class="form-text text-muted">The title</small>
                                @error('title')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>



                            <div class="form-group">
                                <label for="description">Description *</label>
                                <input value="{{$event->description}}" name="description" type="text" class="form-control" id="description" aria-describedby="descriptionHelp" placeholder="Enter description">
                                <small id="descriptionHelp" class="form-text text-muted">The description</small>
                                @error('description')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="place">Place *</label>
                                <textarea value="{{$event->place}}" name="place" type="text" class="form-control" id="place" aria-describedby="placeHelp" placeholder="Enter the place of the news" rows="3">{{$event->place}}</textarea>
                                <small id="placeHelp" class="form-text text-muted">The place</small>
                                @error('place')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="scale">Scale *</label>
                                <input value="{{$event->scale}}" name="scale" type="number" class="form-control" id="scale" aria-describedby="scaleHelp" scaleholder="Enter the scale">
                                <small id="scaleHelp" class="form-text text-muted">The scale</small>
                                @error('scale')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="dt">Дата начала *</label>
                                <input value="{{\Carbon\Carbon::parse($event->dt)->format('Y-m-d\TH:i')}}" name="dt" type="datetime-local" class="form-control" id="dt" aria-describedby="dtHelp" scaleholder="Enter date">
                                <small id="dtHelp" class="form-text text-muted">Дата начала</small>
                                @error('dt')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="dt_exp">Дата окончания *</label>
                                <input value="{{\Carbon\Carbon::parse($event->dt_exp)->format('Y-m-d\TH:i')}}" name="dt_exp" type="datetime-local" class="form-control" id="dt_exp" aria-describedby="dt_expHelp" scaleholder="Enter date">
                                <small id="dt_expHelp" class="form-text text-muted">Дата окончания</small>
                                @error('dt_exp')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Edit an Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
