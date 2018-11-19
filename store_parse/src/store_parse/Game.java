package store_parse;

public class Game{
    String title;
    Steam steam = null;
    GOG gog = null;
    
    public Game(String title){
        this.title = title;
    }
    
    @Override
    public String toString(){
        return String.format("title:    %s\non_steam: %b\non_gog:   %b\n", title, steam != null, gog != null);
    }
}
