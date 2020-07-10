package com.example.eventsact;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class Errors {
    @SerializedName("login")
    private List<String> login;
    @SerializedName("email")
    private List<String> email;

    public List<String> getLogin() {
        return login;
    }

    public List<String> getEmail() {
        return email;
    }
}
