package sqlconnect;

import java.sql.*;

public class Main {

    public static void main(String[] args) {

        DatabaseConfig dbc = DatabaseConfig.readConfig();
        Connection conn = null;
        Statement stmt = null;
        ResultSet rs = null;

        try {
            conn =
                    DriverManager.getConnection("jdbc:" + dbc.getDriver() + "://"
                            + dbc.getHost() + "/" + dbc.getDbName() + "?" +
                            "user=" + dbc.getUser() + "&password=" + dbc.getPassword());


            try {
                stmt = conn.createStatement();

                if (stmt.execute("SELECT * FROM Customer")) {
                    rs = stmt.getResultSet();

                    while (rs.next())
                        System.out.println(rs.getString("email"));

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

    }
}



