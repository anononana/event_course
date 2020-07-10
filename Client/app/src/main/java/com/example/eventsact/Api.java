package com.example.eventsact;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.Field;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.Headers;
import retrofit2.http.POST;
import retrofit2.http.Path;

public interface Api {
    //String headerToken = "Authorization: Bearer " + RegActivity.token.getACCESS_TOKEN();
    //@Headers({"Accept: application/json", "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMWVlYTM4OGU0YzA4NDAyNzY5NTI1ZjkwNzAwMGExYzY5MzIxNjM5NGQyYmUzYjVmMjhkNzlhNmViMGQzNGRhMTVkYzVmZjljNTIxYTYxZmQiLCJpYXQiOjE1OTA3NDEwNDAsIm5iZiI6MTU5MDc0MTA0MCwiZXhwIjoxNjIyMjc3MDQwLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.ao5Ccl16Zzp5n_QPOsSymlBt4lRMwN6zEXM0AwHx_xkwZfleiuMbT3CQ6AoyTn2D3sV5jL_6BCsZ0VQjgP92rIAHIOVHYo9l7PW1Dg_Iye_7VX_zyZangvA3bKN3FSqG1NU340y5NM197KoU0kpkM-m68WBsf3E6uItwtsEaZJdSXQG3bTUe4rxJmD-quFxlNypJRaHGuGglLWqhb-yUQoIXypEPiSNngsYOH3spqrL3JkasFDMgbNPbp3rT1HtSibSKPfzZcoRdJsI3FLi7LO_V-7F9YB8DmVHnQAuoXK7bPaNUNMBCkHEnvM4ylTsr8kVHK0ylMcg3mgKqCjGxYX21iYdDEnu-POfgxuUyUbN2DmK0vJF6Vold3EpPJR4518vajqhSmTKNBE6w8qdE2vmez5L3oH0yMSUYcFqYAb-1Iv6XFgFsDxdhhL6wbjHJ6E3SB_70gP5vtl94FffucGvWi9_DPkZtZnUAf1ae-0E4eJBe9cWtMhijcEC7GfRqat7UFwoxVSomLzUYH0egsZHyIm6QR_Hfo59ob86GxE2su0Q4s_lRJcJs3eac6ztPvO7mEl9qJw50cvfTIaAvPW6TSyE4VwqMrAW3NLLF7D3Mqoh_GlFETOxYe96ItuSRhXPcp1ya6_3ZbziFmzbyGwor51ytvmwR2DUXuoOK7z8"})

    @GET("users")
    Call<List<User>> getUsers();


   @GET("user")
    Call<User> getProfile(@Header("Authorization") String headerToken);


    @POST("register")
    Call<AccessToken> register(@Body User user);

    @GET("events/{event}")
    Call<Event> getEvent(@Path("event") int eventId);

    @GET("events")
    Call<List<Event>> getEvents();

    @POST("login")
    Call<AccessToken> login(@Body User user);

}
