

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
            json = getAPI.readJsonFromUrl("https://apimywebsite.000webhostapp.com/APIDoAnJava/get.php?Id="+Id);
            JSONArray jsonArray = json.getJSONArray("response");

            System.out.println(jsonArray.getJSONObject(0).getString("Repair_Id"));

            Customer_Name = jsonArray.getJSONObject(0).getString("Customer_Name");
            Laptop_Name = jsonArray.getJSONObject(0).getString("Laptop_Name");
            Repair_Id = jsonArray.getJSONObject(0).getString("Repair_Id");
            Email = jsonArray.getJSONObject(0).getString("Email");
            Status = jsonArray.getJSONObject(0).getString("Status");

            req.setAttribute("Id",Id);

            req.setAttribute("Repair_Id", Repair_Id);
            req.setAttribute("Customer_Name", Customer_Name);
            req.setAttribute("Laptop_Name", Laptop_Name);
            req.setAttribute("Email", Email);
            req.setAttribute("Status", Status);

            req.getRequestDispatcher("/View/view/tra-cuu.jsp").forward(req, resp);
        } catch (JSONException e) {
            req.setAttribute("Id",Id);
            req.setAttribute("Repair_Id", "Không tìm thấy");
            req.setAttribute("Customer_Name", "Không tìm thấy");
            req.setAttribute("Laptop_Name", "Không tìm thấy");
            req.setAttribute("Email", "Không tìm thấy");
            req.setAttribute("Status", "Không tìm thấy");
            req.getRequestDispatcher("/View/view/tra-cuu.jsp").forward(req, resp);
//            e.printStackTrace();
        }
    }
}
