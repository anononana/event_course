package com.example.eventsact;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class ErrorResponse {
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
}
