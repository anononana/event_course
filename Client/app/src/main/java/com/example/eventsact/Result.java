package com.example.eventsact;

import com.google.gson.annotations.SerializedName;

public class Result {
    @SerializedName("id")
    private int resultId;
    @SerializedName("group_id")
    private int groupId;
    @SerializedName("task_id")
    private int taskId;
    @SerializedName("answer")
    private String answer;
    @SerializedName("link")
    private String link;

    public int getResultId() {
        return resultId;
    }

    public int getGroupId() {
        return groupId;
    }

    public int getTaskId() {
        return taskId;
    }

    public String getAnswer() {
        return answer;
    }

    public String getLink() {
        return link;
    }
}
