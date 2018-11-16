package json_parse;

import java.io.BufferedWriter;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.io.PrintWriter;
import java.io.Writer;
import java.util.Iterator;
import java.util.Map;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

public class Json_Parse{
    public static void main(String[] args){
        steam();
    }
    
    public static void steam(){
        String fileName = "steam_game_ids.json";
        
        try{
            Object obj = new JSONParser().parse(new FileReader(fileName));
            JSONObject jo = (JSONObject) obj;
            
            Map applist = (Map) jo.get("applist");
            JSONArray apps = (JSONArray) applist.get("apps");
            Iterator applistIter = apps.iterator();
            
            PrintWriter w = new PrintWriter("insert_statements.sql", "UTF-8");
            
            while (applistIter.hasNext()){
                Iterator<Map.Entry> appIter = ((Map) applistIter.next()).entrySet().iterator();
                
                while (appIter.hasNext()){
                    Map.Entry pair = appIter.next();
                    String steam_id = pair.getValue().toString();
                    pair = appIter.next();
                    String name = pair.getValue().toString();
                    
                    for (int i = 0; i < name.length(); i++){
                        char c = name.charAt(i);
                        
                        if (c == '"' || c == '\''){
                            name = String.format("%s\\%s",  name.substring(0, i), name.substring(i));
                            i++;
                        }
                    }
                    
                    if (name.charAt(name.length() - 1) == '\\')
                        name = String.format("%s\\", name);
                    
                    String format = "INSERT INTO games (title, steam_id) VALUES (\"%s\", %s);";
                    String query = String.format(format, name, steam_id);
                    
                    w.println(query);
                } 
            }
            
            w.close();
        }catch (Exception e){
            System.out.println("Error");
        }
    }
}
