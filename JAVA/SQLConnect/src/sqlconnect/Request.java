package sqlconnect;

import java.sql.*;
import java.util.ArrayList;

public class Request {

    private static DatabaseConfig dbc = DatabaseConfig.readConfig();

    public ArrayList<String[]> query(String sql) {

        Connection conn = null;
        Statement stmt = null;
        ResultSet rs = null;
        ArrayList<String[]> fields = new ArrayList<String[]>();

        try {
            conn =
                    DriverManager.getConnection("jdbc:" + dbc.getDriver() + "://"
                            + dbc.getHost() + "/" + dbc.getDbName() + "?" +
                            "user=" + dbc.getUser() + "&password=" + dbc.getPassword());


            try {
                stmt = conn.createStatement();

                if (stmt.execute(sql)) {
                    rs = stmt.getResultSet();
                    int i = rs.getMetaData().getColumnCount();

                    while (rs.next()) {

                        String[] temp = new String[i];

                        for (int j = 0; j < i; j++) {
                            temp[j] = rs.getString(j+1);
                        }

                        fields.add(temp);

                    }


                }

            } catch (SQLException ex) {
                // handle any errors
                System.out.println("SQLException: " + ex.getMessage());
                System.out.println("SQLState: " + ex.getSQLState());
                System.out.println("VendorError: " + ex.getErrorCode());
            } finally {

                if (rs != null) {
                    try {
                        rs.close();
                    } catch (SQLException sqlEx) {
                    } // ignore

                    rs = null;
                }

                if (stmt != null) {
                    try {
                        stmt.close();
                    } catch (SQLException sqlEx) {
                    } // ignore

                    stmt = null;
                }
            }


        } catch (SQLException ex) {
            // handle any errors
            System.out.println("SQLException: " + ex.getMessage());
            System.out.println("SQLState: " + ex.getSQLState());
            System.out.println("VendorError: " + ex.getErrorCode());
        }

        return fields;

    }

}
