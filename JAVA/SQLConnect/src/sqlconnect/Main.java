package sqlconnect;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class Main {

    public static void main(String[] args) {

        DatabaseConfig dbc = DatabaseConfig.readConfig();

        if(dbc == null)
            finish(1);

        try {

            Connection conn = null;
            conn =
                    DriverManager.getConnection("jdbc:" + dbc.getDriver() + "://"
                            + dbc.getHost() + "/" + dbc.getDbName() + "?" +
                            "user=" + dbc.getUser() + "&password=" + dbc.getPassword());


        } catch (SQLException ex) {

            finish(2);

        }

        Request rq = new Request();
        Window window = new Window(rq);

    }

    public static void finish(int mode) {

        switch (mode) {

            case 1:
                System.out.println("Fichier introuvable");
                break;

            case 2:
                System.out.println("Base de données injoignable");
                break;

        }

        System.exit(1);

    }
}



