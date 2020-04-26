package sqlconnect;

import java.sql.*;
import java.util.ArrayList;

public class Request {

    private static final DatabaseConfig dbc = DatabaseConfig.readConfig();

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

                        for (int j = 0; j < i; j++)
                            temp[j] = rs.getString(j + 1);

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

    public ArrayList<String[]> getCustomers() {

        String sql = new String("SELECT * FROM Customer");
        return query(sql);

    }

    public ArrayList<String[]> getAssociates() {

        String sql = new String("SELECT * FROM Associate");
        return query(sql);

    }

    public ArrayList<String[]> getServices() {

        String sql = new String("SELECT * FROM Service");
        return query(sql);

    }

    public ArrayList<String[]> getReservations() {

        String sql = new String("SELECT * FROM Reservation");
        return query(sql);

    }

    public ArrayList<String[]> getServicesTypes() {

        String sql = new String("SELECT * FROM ServiceType");
        return query(sql);

    }

    public ArrayList<String[]> getSubscriptionTypes() {

        String sql = new String("SELECT * FROM SubscriptionType");
        return query(sql);

    }

    public ArrayList<String[]> getServiceProvided() {

        String sql = new String("SELECT * FROM ServiceProvided");
        return query(sql);

    }


}
