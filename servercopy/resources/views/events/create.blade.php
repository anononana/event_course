@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Event</div>

                    <div class="card-body">
                        <form action="/events" method="POST">

                            @csrf
                            <div class="form-group">
                                <label for="title">Title *</label>
                                <input value="{{old("title")}}" name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" scaleholder="Enter title">
                                <small id="titleHelp" class="form-text text-muted">The title</small>
                                @error('title')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="description">Description *</label>
                                <input value="{{old("description")}}" name="description" type="text" class="form-control" id="description" aria-describedby="descriptionHelp" scaleholder="Enter description">
                                <small id="descriptionHelp" class="form-text text-muted">The description</small>
                                @error('description')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="place">Place *</label>
                                <textarea value="{{old("place")}}" name="place" type="text" class="form-control" id="place" aria-describedby="placeHelp" placeholder="Enter the place of the news" rows="3">{{old("place")}}</textarea>
                                <small id="placeHelp" class="form-text text-muted">The place</small>
                                @error('place')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="scale">Scale *</label>
                                <textarea value="{{old("scale")}}" name="scale" type="text" class="form-control" id="scale" aria-describedby="scaleHelp" scaleholder="Enter the scale of the news" rows="3">{{old("scale")}}</textarea>
                                <small id="scaleHelp" class="form-text text-muted">The scale</small>
                                @error('scale')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="dt">Дата начала *</label>
                                <input value="{{old("dt")}}" name="dt" type="datetime-local" class="form-control" id="dt" aria-describedby="dtHelp" scaleholder="Enter date">
                                <small id="dtHelp" class="form-text text-muted">Дата начала</small>
                                @error('dt')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="dt_exp">Дата окончания *</label>
                                <input value="{{old("dt_exp")}}" name="dt_exp" type="datetime-local" class="form-control" id="dt_exp" aria-describedby="dt_expHelp" scaleholder="Enter date">
                                <small id="dt_expHelp" class="form-text text-muted">Дата окончания</small>
                                @error('dt_exp')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                               <!-- value="//// $event->date->format('Y-m-d') " -->

                            <button type="submit" class="btn btn-primary">Create an Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
