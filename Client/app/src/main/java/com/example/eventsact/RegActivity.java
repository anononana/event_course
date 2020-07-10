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

import com.basgeekball.awesomevalidation.AwesomeValidation;
import com.basgeekball.awesomevalidation.ValidationStyle;
import com.basgeekball.awesomevalidation.utility.RegexTemplate;
import com.google.android.material.snackbar.Snackbar;

import java.io.IOException;
import java.lang.annotation.Annotation;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Converter;
import retrofit2.Response;

public class RegActivity extends AppCompatActivity {
    static AccessToken token;
    EditText email;
    EditText login;
    EditText name;
    EditText surname;
    EditText password;
    Api api;
    AwesomeValidation validator;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reg);
        TextView textToLog = findViewById(R.id.redirectToLog);

        textToLog.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                startLog();
            }
        });
        api = NetworkService.getInstance()
                .getApi();
        Button btnReg = findViewById(R.id.reg_btn);
        validator = new AwesomeValidation(ValidationStyle.BASIC);
        setupRules();
        btnReg.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                Register();
            }
        });
    }
    private void startLog() {
        Intent intent = new Intent(RegActivity.this, LoginActivity.class);
        startActivity(intent);
    }
    private void Register() {
        email = findViewById(R.id.regEmail);
        login = findViewById(R.id.regLogin);
        name = findViewById(R.id.regName);
        surname = findViewById(R.id.regSurname);
        password = findViewById(R.id.regPassword);

        if(validator.validate()) {
            Call<AccessToken> call = api.register(new User(name.getText().toString(),
                                                    surname.getText().toString(),
                                                    login.getText().toString(),
                                                    email.getText().toString(),
                                                    null,
                                                    null,
                                                    null,
                                                    password.getText().toString())) ;
            call.enqueue(new Callback<AccessToken>() {
                @Override
                public void onResponse(Call<AccessToken> call, Response<AccessToken> response) {

                    if (response.isSuccessful()) {
                        token = new AccessToken(response.body().getACCESS_TOKEN());
                        Snackbar mySnackbar = Snackbar.make(findViewById(R.id.sign), R.string.success, 1);
                        mySnackbar.show();
                        final Handler handler = new Handler();
                        handler.postDelayed(new Runnable() {
                            @Override
                            public void run() {
                                // Do something after 1.5s
                                startActivity(new Intent(RegActivity.this, ProfileActivity.class));
                            }
                        }, 1500);


                    } else {
                       TextView err = findViewById(R.id.err_email);
                        Converter<ResponseBody, ErrorResponse> converter =
                               NetworkService.getInstance().getRetrofit().responseBodyConverter(ErrorResponse.class, new Annotation[0]);
                        try {

                            ErrorResponse errorResponse = converter.convert(response.errorBody());
                            if(errorResponse.getErrors().getLogin() != null && errorResponse.getErrors().getEmail() != null)
                                err.setText(errorResponse.getErrors().getLogin().get(0)+ errorResponse.getErrors().getEmail().get(0));
                            else if(errorResponse.getErrors().getLogin() != null)
                                err.setText(errorResponse.getErrors().getLogin().get(0));
                            else if(errorResponse.getErrors().getEmail() != null)
                                err.setText(errorResponse.getErrors().getEmail().get(0));
                        } catch (IOException e) {
                            e.printStackTrace();
                        }

                       /* if (response.errorBody() != null) {

                            try {
                                JSONObject jObjError = new JSONObject(response.errorBody().string());

                                if(jObjError.getJSONObject("errors").toString().contains("login"))
                                    err.setText(jObjError.getJSONObject("errors").getString("login"));
                                else if((jObjError.getJSONObject("errors").toString().contains("email")))
                                    err.setText(jObjError.getJSONObject("errors").getString("email"));
                            } catch (Exception e) {
                                Toast.makeText(getApplicationContext(), e.getMessage(), Toast.LENGTH_LONG).show();
                            }
                        } else {
                            err.setText(response.message());
                        } */
                    }
                }
                @Override
                public void onFailure(Call<AccessToken> call, Throwable t) {
                    TextView err = findViewById(R.id.err_email);
                    err.setText(t.getMessage());
                }
            });
        }


    }
    public void setupRules(){

       validator.addValidation(this, R.id.regName, RegexTemplate.NOT_EMPTY, R.string.err_req);
        validator.addValidation(this, R.id.regSurname, RegexTemplate.NOT_EMPTY, R.string.err_req);
        validator.addValidation(this, R.id.regLogin, RegexTemplate.NOT_EMPTY, R.string.err_req);
        validator.addValidation(this, R.id.regEmail, Patterns.EMAIL_ADDRESS, R.string.err_email);
        validator.addValidation(this, R.id.regPassword, "[a-zA-Z0-9]{6,}", R.string.err_password);

    }

}
