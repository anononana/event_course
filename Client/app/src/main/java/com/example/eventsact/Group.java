package com.example.eventsact;

import com.google.gson.annotations.SerializedName;

public class Group {
    @SerializedName("id")
    private int groupId;
    @SerializedName("name")
    private String name;
    @SerializedName("logo")
    private String logo;
    @SerializedName("description")
    private String description;
    @SerializedName("event_id")
    private int eventId;

    public int getGroupId() {
        return groupId;
    }

    public String getName() {
        return name;
    }

    public String getLogo() {
        return logo;
    }

    public String getDescription() {
        return description;
    }

    public int getEventId() {
        return eventId;
    }
}
