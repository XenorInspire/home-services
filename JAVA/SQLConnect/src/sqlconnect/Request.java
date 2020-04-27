package sqlconnect;

import java.sql.*;

public class Request {

    private final DatabaseConfig dbc;

    public Request() {

        dbc = DatabaseConfig.readConfig();

    }

    public String[][] query(String sql) {

        Connection conn = null;
        Statement stmt = null;
        ResultSet rs = null;
        String[][] fields = null;

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
                    rs.last();
                    int c = rs.getRow();
                    rs.first();

                    fields = new String[c][i];

                    for (int l = 0; l < c; l++) {

                        String[] temp = new String[i];

                        for (int j = 0; j < i; j++)
                            temp[j] = rs.getString(j + 1);

                        fields[l] = temp;
                        rs.next();

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

    public String[][] getCustomers() {

        String sql = "SELECT * FROM Customer";
        return query(sql);

    }

    public String[][] getAssociates() {

        String sql = "SELECT * FROM Associate";
        return query(sql);

    }

    public String[][] getServices() {

        String sql = "SELECT * FROM Service";
        return query(sql);

    }

    public String[][] getReservations() {

        String sql = "SELECT reservationId,reservationDate,customer.email,service.serviceTitle,status FROM customer,reservation,serviceprovided,service WHERE serviceprovided.serviceProvidedId = reservation.serviceProvidedId AND serviceprovided.serviceId = service.serviceId;";
        return query(sql);

    }

    public String[][] getServicesTypes() {

        String sql = "SELECT * FROM ServiceType";
        return query(sql);

    }

    public String[][] getSubscriptionTypes() {

        String sql = "SELECT * FROM SubscriptionType";
        return query(sql);

    }

    public String[][] getServiceProvided() {

        String sql = "SELECT serviceProvidedId,date,beginHour,hours,service.serviceTitle,hoursAssociate,address,town FROM serviceProvided,service WHERE service.serviceId = serviceprovided.serviceId;";
        return query(sql);

    }

}
