package store_parse;

public class Steam{
    int steam_id;
    
    public Steam(int steam_id){
        this.steam_id = steam_id;
    }
    
    @Override
    public String toString(){
        return String.format("Steam:{steam_id: %d}", steam_id);
    }
}
