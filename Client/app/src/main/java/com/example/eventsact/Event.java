package com.example.eventsact;

import com.google.gson.annotations.SerializedName;

import java.util.GregorianCalendar;

public class Event {
    @SerializedName("id")
    private int eventId;
    @SerializedName("title")
    private String title;
    @SerializedName("description")
    private String description;
    @SerializedName("place")
    private String place;
    @SerializedName("scale")
    private int scale;
    @SerializedName("finished")
    private boolean finished;
    @SerializedName("dt")
    private String dateStart;
    @SerializedName("dt_exp")
    private String dateEnd;

    public int getEventId() {
        return eventId;
    }

    public String getTitle() {
        return title;
    }

    public String getDescription() {
        return description;
    }

    public String getPlace() {
        return place;
    }

    public int getScale() {
        return scale;
    }

    public boolean isFinished() {
        return finished;
    }

    public String getDateStart() {
        return dateStart;
    }

    public String getDateEnd() {
        return dateEnd;
    }
}
