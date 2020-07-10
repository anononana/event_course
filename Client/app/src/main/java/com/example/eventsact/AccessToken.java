package com.example.eventsact;

import com.google.gson.annotations.SerializedName;

public class AccessToken {
    @SerializedName("accessToken")
    private final String ACCESS_TOKEN;
    @SerializedName("user")
    private User user;

    @SerializedName("message")
    private String message;
    @SerializedName("errors")
    private Errors errors;

    public String getMessage() {
        return message;
    }

    public Errors getErrors() {
        return errors;
    }
    public AccessToken(String access_token) {
        ACCESS_TOKEN = access_token;
    }


    public String getACCESS_TOKEN() {
        return ACCESS_TOKEN;
    }
}
