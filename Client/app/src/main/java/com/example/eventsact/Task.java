package com.example.eventsact;

import com.google.gson.annotations.SerializedName;

public class Task {
    @SerializedName("id")
    private int taskId;
    @SerializedName("title")
    private String title;
    @SerializedName("task")
    private String task;
    @SerializedName("event_id")
    private int eventId;
    @SerializedName("link")
    private String link;
    @SerializedName("right_answer")
    private String rightAnswer;
    @SerializedName("rate")
    private int rate;

    public int getTaskId() {
        return taskId;
    }

    public String getTitle() {
        return title;
    }

    public String getTask() {
        return task;
    }

    public int getEventId() {
        return eventId;
    }

    public String getLink() {
        return link;
    }

    public String getRightAnswer() {
        return rightAnswer;
    }

    public int getRate() {
        return rate;
    }
}
