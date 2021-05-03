import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.Base64;

public class test {
    public static void main(String[] args) throws IOException, JSONException {
//        getAPI getAPI = new getAPI();
//
//        JSONObject json = getAPI.readJsonFromUrl("https://apimywebsite.000webhostapp.com/APIDoAnJava/get.php?Id=RP163611");
//
//        JSONArray jsonArray = json.getJSONArray("token");
//
//        System.out.println(jsonArray.get(0));

        String token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJrZXkiOiJib3k4ODFuMzE5Iiwic3RhdHVzIjoiNDAwIiwiaXNzIjoiMDAwd2ViaG9zdGFwcC5jb20iLCJhdWQiOiJUaGFuaFRhaSIsImlhdCI6MTYyMDA0MzAwOCwiZXhwIjoxNjIwMDQzMDY4LCJkYXRhIjoibm90IGZvdW5kIHZhbHVlIn0.HPx_RMma4bm_S55GwQoePmo_zXchpuc1zv4TCz31G-Y";
        String[] chunks = token.split("\\.");

        Base64.Decoder decoder = Base64.getDecoder();

        String header = new String(decoder.decode(chunks[0]));
        String payload = new String(decoder.decode(chunks[1]));

        System.out.println(header);
        System.out.println(payload);

//        String[] strArray = new String[] {payload};
//
//        JSONObject json2 = new JSONObject(strArray[0]);
//
//        System.out.println(json2);
//
//        JSONArray jsonArray2 = json2.getJSONArray("data");
//
//        System.out.println(jsonArray2.getJSONObject(0).getString("Customer_Name"));
//
//        System.out.println("Header" + header);
//        System.out.println("Payload" + payload);
    }
}
