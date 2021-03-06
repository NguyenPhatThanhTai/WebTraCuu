

import org.json.JSONArray;
import org.json.JSONException;

import org.json.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;


import java.io.*;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;
import java.nio.charset.Charset;
import java.util.Base64;
import java.util.Scanner;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.*;


@WebServlet(urlPatterns = "/Tra-Cuu")
public class Controller extends HttpServlet {
    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        req.getRequestDispatcher("/View/view/tra-cuu.jsp").forward(req, resp);
    }

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        String Id = req.getParameter("Id");
        JSONObject json = null;
        String Repair_Id = "";
        String Customer_Name = "";
        String Laptop_Name = "";
        String Email = "";
        String Status = "";
        try {
            getAPI getAPI = new getAPI();

            json = getAPI.readJsonFromUrl("https://apimywebsite.000webhostapp.com/APIDoAnJava/get.php?Id=" + Id);

            JSONArray jsonArray = json.getJSONArray("token");

            System.out.println(jsonArray.get(0));

            String token = jsonArray.get(0).toString();
            String[] chunks = token.split("\\.");

            Base64.Decoder decoder = Base64.getDecoder();

            String header = new String(decoder.decode(chunks[0]));
            String payload = new String(decoder.decode(chunks[1]));

            String[] strArray = new String[] {payload};

            JSONObject json2 = new JSONObject(strArray[0]);

            System.out.println(json2);

            JSONArray jsonArray2 = json2.getJSONArray("data");

            System.out.println(jsonArray2.getJSONObject(0).getString("Repair_Id"));

            Customer_Name = jsonArray2.getJSONObject(0).getString("Customer_Name");
            Laptop_Name = jsonArray2.getJSONObject(0).getString("Laptop_Name");
            Repair_Id = jsonArray2.getJSONObject(0).getString("Repair_Id");
            Email = jsonArray2.getJSONObject(0).getString("Email");
            Status = jsonArray2.getJSONObject(0).getString("Status");

            req.setAttribute("Id",Id);

            req.setAttribute("Repair_Id", Repair_Id);
            req.setAttribute("Customer_Name", Customer_Name);
            req.setAttribute("Laptop_Name", Laptop_Name);
            req.setAttribute("Email", Email);
            req.setAttribute("Status", Status);

            req.getRequestDispatcher("/View/view/tra-cuu.jsp").forward(req, resp);
        } catch (JSONException e) {
            req.setAttribute("Id",Id);
            req.setAttribute("Repair_Id", "Kh??ng t??m th???y");
            req.setAttribute("Customer_Name", "Kh??ng t??m th???y");
            req.setAttribute("Laptop_Name", "Kh??ng t??m th???y");
            req.setAttribute("Email", "Kh??ng t??m th???y");
            req.setAttribute("Status", "Kh??ng t??m th???y");
            req.getRequestDispatcher("/View/view/tra-cuu.jsp").forward(req, resp);
//            e.printStackTrace();
        }
    }
}
