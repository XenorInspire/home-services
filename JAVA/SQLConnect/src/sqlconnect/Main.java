package sqlconnect;

import java.sql.*;
import java.util.ArrayList;

public class Main {

    public static void main(String[] args) throws SQLException {

        Request rq = new Request();
        ArrayList<String[]> table = rq.query("SELECT * FROM Customer");

        for (int i = 0; i < table.size(); i++) {

            for (int j = 0; j < table.get(i).length; j++) {

                System.out.print(table.get(i)[j] + " | ");

            }

            System.out.print("\n\n");

        }

    }
}



