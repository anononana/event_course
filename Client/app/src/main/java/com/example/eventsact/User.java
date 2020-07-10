package com.example.eventsact;

import com.google.gson.annotations.SerializedName;

public class User {
    @SerializedName("id")
    private int UserId;

    @SerializedName("name")
    private String name;
    @SerializedName("surname")
    private String surname;
    @SerializedName("login")
    private String login;
    @SerializedName("email")
    private String email;
    @SerializedName("image")
    private String image;
    @SerializedName("description")
    private String description;
    @SerializedName("admin")
    private Boolean isAdmin;
    @SerializedName("password")
    private String password;
    public int getUserId() {
        return UserId;
    }

    public String getName() {
        return name;
    }

    public String getSurname() {
        return surname;
    }

    public String getLogin() {
        return login;
    }

    public String getEmail() {
        return email;
    }

    public String getImage() {
        return image;
    }

    public String getDescription() {
        return description;
    }

    public Boolean getAdmin() {
        return isAdmin;
    }

    public User(int id, String name, String surname, String login, String email, String image, String description, Boolean isAdmin) {
        this.UserId = id;
        this.name = name;
        this.surname = surname;
        this.login = login;
        this.email = email;
        this.image = image;
        this.description = description;
        this.isAdmin = isAdmin;
    }

    public User(String name, String surname, String login, String email, String image, String description, Boolean isAdmin, String password) {
        this.name = name;
        this.surname = surname;
        this.login = login;
        this.email = email;
        this.image = image;
        this.description = description;
        this.isAdmin = isAdmin;
        this.password = password;
    }

    public User(String email, String password) {
        this.email = email;
        this.password = password;
    }
}

