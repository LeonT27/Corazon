package com.example.juanmtolentino.corazon;

/**
 * Created by Juan M. Tolentino on 03/12/2016.
 */

import android.os.AsyncTask;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.StreamCorruptedException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import org.json.*;

public class Api {

    public String get(String targetURL) throws MalformedURLException, IOException
    {

        URL url = new URL(targetURL);
        String response = null;

        try (BufferedReader reader = new BufferedReader(new InputStreamReader(url.openStream(), "UTF-8"))) {
            for (String line; (line = reader.readLine()) != null;) {
                response = line;
                //System.out.println(line);
            }
            return response;
        }
        catch (IOException ex)
        {
            ex.printStackTrace();
            return "ño";
        }
    }

    public  String post(String targetURL, String urlParameters) {
        HttpURLConnection connection = null;

        try {
            //Create connection
            URL url = new URL(targetURL);

            connection = (HttpURLConnection) url.openConnection();
            connection.setRequestMethod("POST");
            connection.setRequestProperty("Content-Type",
                    "application/x-www-form-urlencoded");

            connection.setRequestProperty("Content-Length",
                    Integer.toString(urlParameters.getBytes().length));
            connection.setRequestProperty("Content-Language", "en-US");

            connection.setUseCaches(false);
            connection.setDoOutput(true);

            //Send request
            DataOutputStream wr = new DataOutputStream (
                    connection.getOutputStream());
            wr.writeBytes(urlParameters);
            wr.close();

            //Get Response
            InputStream is = connection.getInputStream();
            BufferedReader rd = new BufferedReader(new InputStreamReader(is));
            StringBuilder response = new StringBuilder(); // or StringBuffer if Java version 5+
            String line;
            while ((line = rd.readLine()) != null) {
                response.append(line);
                response.append('\r');
            }
            rd.close();
            return response.toString();
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        } finally {
            if (connection != null) {
                connection.disconnect();
            }
        }
    }

    public String[] json(String jsonString)
    {
        try
        {
            JSONObject jsonObject = new JSONObject(jsonString);
            JSONArray arr = jsonObject.getJSONArray("assignments");
            String[] a = new String[arr.length()];
            for (int i = 0; i < arr.length(); i++){
                //System.out.println(arr.get(i));
                a[i] = arr.get(i).toString();
            }
            return a;
        }catch (Exception e)
        {
            String[] ex = {"ño"};
            e.printStackTrace();
            return ex;
        }

    }

}
