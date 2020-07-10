package com.example.eventsact;

import com.google.gson.annotations.SerializedName;

public class Review {
    @SerializedName("id")
    private int reviewId;
    @SerializedName("body")
    private int text;
    @SerializedName("rate")
    private int rate;
    @SerializedName("result_id")
    private int resultId;
    @SerializedName("expert_id")
    private int expertId;

    public int getReviewId() {
        return reviewId;
    }

    public int getText() {
        return text;
    }

    public int getRate() {
        return rate;
    }

    public int getResultId() {
        return resultId;
    }

    public int getExpertId() {
        return expertId;
    }
}
