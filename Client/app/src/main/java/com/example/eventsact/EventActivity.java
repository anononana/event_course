package com.example.eventsact;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class EventActivity extends DrawerActivity {
    Api api;
    TextView title;
    TextView desc;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        LayoutInflater inflater = (LayoutInflater) this
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View contentView = inflater.inflate(R.layout.activity_event, null, false);
        drawerLayout.addView(contentView, 0);
        title = findViewById(R.id.titleEvent);
        desc = findViewById(R.id.eventDescription);
        api = NetworkService.getInstance()
                .getApi();
        GetEvent();
    }
    private void GetEvent() {
        Call<Event> call = api.getEvent(1);
        call.enqueue(new Callback<Event>() {
            @Override
            public void onResponse(Call<Event> call, Response<Event> response) {
                if(response.isSuccessful()) {
                    Event event = response.body();
                    title.setText(event.getTitle());
                    desc.setText(event.getDateStart());
                } else {
                    title.setText("Smths wrong");
                }
            }

            @Override
            public void onFailure(Call<Event> call, Throwable t) {
                title.setText(t.getMessage());
            }
        });
    }
}
