package com.example.eventsact;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ProfileActivity extends DrawerActivity {
    TextView name;
    TextView surname;
    TextView description;
    Api api;
    ImageView profileImage;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        LayoutInflater inflater = (LayoutInflater) this
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        View contentView = inflater.inflate(R.layout.activity_profile, null, false);
        drawerLayout.addView(contentView, 0);
        if(RegActivity.token == null) {
            startActivity(new Intent(ProfileActivity.this, RegActivity.class));
        } else {
            profileImage = findViewById(R.id.imageV);
            name = findViewById(R.id.profileName);
            surname = findViewById(R.id.profileSurname);
            description = findViewById(R.id.Pdescription);
            api = NetworkService.getInstance()
                    .getApi();


            GetProfile();
        }
    }
    private void GetUsers() {
        Call<List<User>> call = api.getUsers();
        call.enqueue(new Callback<List<User>>() {
            @Override
            public void onResponse(Call<List<User>> call, Response<List<User>> response) {
                if (!response.isSuccessful()) {
                    name.setText(response.message() + response.code());
                    return;
                }
                List<User> users = response.body();
                name.setText(users.get(0).getName());
                surname.setText(users.get(0).getSurname());
                description.setText(users.get(0).getName());

            }

            @Override
            public void onFailure(Call<List<User>> call, Throwable t) {
                name.setText(t.getMessage());
            }
        });
    }
    private void GetProfile() {
        Call<User> call = api.getProfile("Bearer " + RegActivity.token.getACCESS_TOKEN());
        call.enqueue(new Callback<User>() {
            @Override
            public void onResponse(Call<User> call, Response<User> response) {
                if (!response.isSuccessful()) {
                    name.setText(response.message() + response.code());
                    return;
                }
                User user = response.body();
                name.setText(user.getName());
                surname.setText(user.getSurname());
                description.setText(user.getDescription());
                Picasso.get().load(user.getImage()).into(profileImage);
            }

            @Override
            public void onFailure(Call<User> call, Throwable t) {
                name.setText(t.getMessage());
            }
        });
    }
}
