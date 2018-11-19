package store_parse;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.util.HashMap;
import java.util.Map;
import org.json.JSONArray;
import org.json.JSONObject;

public class Store_parse{
    static Map<String, Game> games = new HashMap<String, Game>();
    
    public static void main(String[] args){
        add_steam_games();
        add_gog_games();
        
        output();
    }
    
    public static void add_steam_games(){
        String steam_api = "http://api.steampowered.com/ISteamApps/GetAppList/v0002/";
            
        JSONObject steam_games = new JSONObject(http_request(steam_api));
        JSONObject applist = steam_games.getJSONObject("applist");
        JSONArray apps = applist.getJSONArray("apps");
        
        // Three initial games are test games
        for (int i = 3; i < apps.length(); i++){
            JSONObject game = apps.getJSONObject(i);
            String title = game.getString("name");
            int steam_id = game.getInt("appid");
            
            Game g = games.get(title);
            
            if (g == null){
                g = new Game(title);
                games.put(title, g);
            }
            
            g.steam = new Steam(steam_id);
        }
    }
    
    public static void add_gog_games(){
        String gog_api = "https://www.gog.com/games/ajax/filtered?mediaType=game&page=";

        JSONObject page = new JSONObject(http_request(gog_api + 1));
        
        int page_number = 1;
        int total_pages = page.getInt("totalPages");
        
        while (page_number <= total_pages){
            page = new JSONObject(http_request(gog_api + page_number));
            JSONArray game_list = page.getJSONArray("products");
            
            for (int i = 0; i < game_list.length(); i++){
                JSONObject game = game_list.getJSONObject(i);
                String title = game.getString("title");
                
                Game g = games.get(title);
                
                if (g == null){
                    g = new Game(title);
                    games.put(title, g);
                }
                
                g.gog = new GOG();
            }
            
            page_number++;
        }
    }
    
    public static String http_request(String url){
        try{
            URLConnection api = new URL(url).openConnection();

            BufferedReader in = new BufferedReader(
                new InputStreamReader(api.getInputStream())
            );

            StringBuilder response = new StringBuilder();
            String line;

            while ((line = in.readLine()) != null)
                response.append(line);

            return response.toString();
            
        }catch (MalformedURLException e) {
            System.out.println("Invalid GOG API link");
        }catch (IOException e) {
            System.out.println("Error reading GOG API");
        }
        
        return null;
    }
    
    public static void output(){
        int x = 0;
        
        for (Map.Entry pair : games.entrySet()){
            String title = (String) pair.getKey();
            Game game = (Game) pair.getValue();
            System.out.println(game);
            
            x++;
            if (x >= 10)
                break;
        }
    }
}
