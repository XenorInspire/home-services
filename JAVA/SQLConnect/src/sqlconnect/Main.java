package sqlconnect;

import java.sql.*;

public class Main {

    public static void main(String[] args) {


        Connection conn = null;
        Statement stmt = null;
        ResultSet rs = null;

        try {
            conn =
                    DriverManager.getConnection("jdbc:mysql://localhost/home-services?" +
                            "user=root&password=root");

            // Do something with the Connection

            try {
                stmt = conn.createStatement();
                //rs = stmt.executeQuery("SELECT foo FROM bar");

                // or alternatively, if you don't know ahead of time that
                // the query will be a SELECT...

                if (stmt.execute("SELECT * FROM Customer")) {
                    rs = stmt.getResultSet();

                    while (rs.next())
                        System.out.println(rs.getString("email"));

                }

                // Now do something with the ResultSet ....
            } catch (SQLException ex) {
                // handle any errors
                System.out.println("SQLException: " + ex.getMessage());
                System.out.println("SQLState: " + ex.getSQLState());
                System.out.println("VendorError: " + ex.getErrorCode());
            } finally {
                // it is a good idea to release
                // resources in a finally{} block
                // in reverse-order of their creation
                // if they are no-longer needed

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



