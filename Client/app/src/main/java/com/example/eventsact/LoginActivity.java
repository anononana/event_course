package com.example.eventsact;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Patterns;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.basgeekball.awesomevalidation.AwesomeValidation;
import com.basgeekball.awesomevalidation.ValidationStyle;
import com.google.android.material.snackbar.Snackbar;

import java.io.IOException;
import java.lang.annotation.Annotation;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Converter;
import retrofit2.Response;

public class LoginActivity extends AppCompatActivity {

    EditText email;
    EditText password;
    Api api;
    AwesomeValidation validator;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        TextView textToReg = findViewById(R.id.redirectToReg);
        textToReg.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                startReg();
            }
        });
        api = NetworkService.getInstance()
                .getApi();
        Button btnLog = findViewById(R.id.log_btn);
        validator = new AwesomeValidation(ValidationStyle.BASIC);
        setupRules();
        btnLog.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                Login();
            }
        });
    }
    private void startReg() {
        Intent intent = new Intent(LoginActivity.this, RegActivity.class);
        startActivity(intent);
    }
    private void Login() {
        email = findViewById(R.id.logEmail);
        password = findViewById(R.id.logPassword);
        if (validator.validate()) {
            Call<AccessToken> call = api.login(new User(
                    email.getText().toString(),
                    password.getText().toString()));
            call.enqueue(new Callback<AccessToken>() {
                @Override
                public void onResponse(Call<AccessToken> call, Response<AccessToken> response) {
                    if (response.isSuccessful()) {
                        RegActivity.token = new AccessToken(response.body().getACCESS_TOKEN());
                        Snackbar mySnackbar = Snackbar.make(findViewById(R.id.sign), R.string.successLog, 2000);
                        mySnackbar.show();
                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 1.5s
                                startActivity(new Intent(LoginActivity.this, ProfileActivity.class));
                            }
                        }, 2000);


                    } else {

                        Converter<ResponseBody, ErrorResponse> converter =
                                NetworkService.getInstance().getRetrofit().responseBodyConverter(ErrorResponse.class, new Annotation[0]);
                        try {

                            ErrorResponse errorResponse = converter.convert(response.errorBody());
                            Toast.makeText(getApplicationContext(), errorResponse.getMessage(), Toast.LENGTH_LONG).show();
                        } catch (IOException e) {
                            e.printStackTrace();
                        }
                    }
                }

                @Override
                public void onFailure(Call<AccessToken> call, Throwable t) {
                    TextView err = findViewById(R.id.err);
                    err.setText(t.getMessage());
                }
            });
        }
    }
    public void setupRules() {
        validator.addValidation(this, R.id.logEmail, Patterns.EMAIL_ADDRESS, R.string.err_email);
        validator.addValidation(this, R.id.logPassword, "[a-zA-Z0-9]{6,}", R.string.err_password);
    }
}
