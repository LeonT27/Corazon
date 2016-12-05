package com.example.juanmtolentino.corazon;

import android.content.Context;
import android.util.Log;
import android.widget.Toast;

import com.google.android.gms.wearable.MessageEvent;
import com.google.android.gms.wearable.WearableListenerService;

import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * Created by Juan M. Tolentino on 05/12/2016.
 */

public class ListenerService extends WearableListenerService {

    String nodeId;
    private final String LOG_TAG = MainActivity.class.getSimpleName();

    @Override
    public void onMessageReceived(MessageEvent messageEvent) {
        nodeId = messageEvent.getSourceNodeId();
        Api ap = new Api();
        Date dNow = new Date( );
        SimpleDateFormat ft =
                new SimpleDateFormat ("dd-MM-yyyy");
        Log.v(LOG_TAG, "Recivido: " + messageEvent.getPath());
        String var = "pulsaciones="+messageEvent.getPath()+"&fecha="+ft.format(dNow);
        ap.post("http://104.198.75.154/Corazon/api/post",var);
        showToast(messageEvent.getPath());
    }

    private void showToast(String message) {
        Context context = getApplicationContext();
        Toast.makeText(context, message, Toast.LENGTH_LONG).show();
    }
}
