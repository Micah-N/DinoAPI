import java.util.*;
import java.io.*;
import java.sql.*;

public class Dino
{

   public static void main(String[] args) throws SQLException{
      Scanner in = openInputFile("dinosours.txt");
      String[][] results = fillDatabase(in);
      sqlfill(results);
   }
   
   public static Scanner openInputFile(String fileName){
      Scanner fileScanner = null;
      File fileHandle;
      	
      try{
         fileHandle = new File(fileName); 
         fileScanner = new Scanner(fileHandle);
      }
      catch (FileNotFoundException e){
         System.out.println("Fail!");
      }
      return  fileScanner;      
   }
   
   public static String[][] fillDatabase(Scanner in){
      String[][] res = new String[497][6];
      String[] entry = new String[6];
      String line = "";
      int ix = 1, resIx = 0;
      while(in.hasNext()){
         line = in.nextLine();
         String delims = "[:;]+";
         String[] token = line.split(delims);
         switch(ix){
            case 1:
               entry[0] = line;
               break;
            case 2:
               entry[1] = token[1];
               entry[2] = token[3];
               break;
            case 3:
               entry[3] = token[1];
               entry[4] = token[3];
               entry[5] = token[5];
               for(int i = 0; i < entry.length; i++){
            	   res[resIx][i] = entry[i];
               }
               break;
            case 4:
               resIx++;
               ix = 0;
               break;
         }
         ix++; 
      }
      return res;
   }
   
   //This will create a database and table for you to use
   public static void sqlfill(String[][] results) throws SQLException{

        //Change these to use on your server
        String url = "jdbc:mysql://localhost/";
        String user = "root";
        String password = "";
        
        try
        {
            Class.forName("com.mysql.jdbc.Driver").newInstance();
            Connection con = DriverManager.getConnection(url, user, password);
            
            Statement stt = con.createStatement();
            
            stt.execute("CREATE DATABASE IF NOT EXISTS Dino");
            stt.execute("USE Dino");
           
            stt.execute("DROP TABLE IF EXISTS dinos");
            stt.execute("CREATE TABLE dinos (" +
            		"id BIGINT NOT NULL AUTO_INCREMENT,"
                    + "name VARCHAR(50),"
                    + "odr VARCHAR(50),"
                    + "subodr VARCHAR(50),"
                    + "time VARCHAR(50),"
                    + "place VARCHAR(100),"
                    + "food VARCHAR(50),"
                    + "PRIMARY KEY(id)"
                    + ")");

            for(int i = 0; i < results.length; i++){
            	stt.execute("INSERT INTO dinos (name, odr, subodr, time, place, food) VALUES" + 
                            "('"+results[i][0]+"', '"+results[i][1]+"', '"+results[i][2]+"', '"+results[i][3]+"', '"+results[i][4]+"', '"+results[i][5]+"')");
            }

            stt.close();
            con.close();
            
        }
        catch (Exception e)
        {
            e.printStackTrace();
        }
    }
}