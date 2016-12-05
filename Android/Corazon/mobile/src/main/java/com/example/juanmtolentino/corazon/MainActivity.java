package com.example.juanmtolentino.corazon;

import android.os.Bundle;
import android.os.StrictMode;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;
import android.net.*;

import java.io.IOException;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        StrictMode.setThreadPolicy(policy);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Registros Actualizados ;)", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
                Api ap = new Api();
                TextView t1 =(TextView) findViewById(R.id.textView1);
                TextView t2 =(TextView) findViewById(R.id.textView2);
                    //t2.setText(ap.get("http://104.198.75.154/Corazon/api/get"));
                ConnectivityManager connMgr = (ConnectivityManager)
                        getSystemService(CONNECTIVITY_SERVICE);
                NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
                if (networkInfo != null && networkInfo.isConnected()) {
                    // fetch data
                    t1.setText("Si");
                    try
                    {

                        t2.setText("Registros: ");
                        t2.append("\n \n");
                        String[] re = ap.json(ap.get("http://104.198.75.154/Corazon/api/get"));
                        for ( int i=0; i<re.length; i++)
                        {
                            t2.append(re[i]);
                            t2.append("\n");
                        }
                    }
                    catch (IOException ex)
                    {
                        ex.printStackTrace();
                    }
                } else {
                    // display error
                    t1.setText("No");
                }
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {

        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
