package sqlconnect;

import java.io.*;

public class DatabaseConfig {

    public static final int PARAMETERS = 6;
    private final String driver;
    private final String host;
    private final String dbName;
    private final int port;
    private final String user;
    private final String password;

    public DatabaseConfig(String driver, String host, String dbName, int port, String user, String password) {

        this.driver = driver;
        this.host = host;
        this.dbName = dbName;
        this.port = port;
        this.user = user;
        this.password = password;

    }

    public static DatabaseConfig readConfig() {

        File config = new File("./database.env");
        String[] buffer = new String[PARAMETERS];

        if (config.exists() && config.isFile() && config.canRead()) {
            BufferedReader br = null;
            try {

                br = new BufferedReader(new FileReader(config));

                for (int i = 0; i < PARAMETERS; i++)
                    buffer[i] = br.readLine();

                br.close();

            } catch (FileNotFoundException e) {

                System.out.println(e.getMessage());

            } catch (IOException e) {

                System.out.println(e.getMessage());

            }

            return allocate(buffer);

        } else {

            return null;

        }

    }

    public static DatabaseConfig allocate(String[] buffer) {

        for (int i = 0; i < buffer.length; i++)
            buffer[i] = buffer[i].split(" = ")[1];

        return new DatabaseConfig(buffer[0], buffer[1], buffer[2], Integer.parseInt(buffer[3]), buffer[4], buffer[5]);
    }

    @Override
    public String toString() {
        return "DatabaseConfig{" +
                "driver='" + driver + '\'' +
                ", host='" + host + '\'' +
                ", port=" + port +
                ", user='" + user + '\'' +
                ", password='" + password + '\'' +
                '}';
    }

    public String getDriver() {
        return driver;
    }

    public String getHost() {
        return host;
    }

    public String getDbName() {
        return dbName;
    }

    public int getPort() {
        return port;
    }

    public String getUser() {
        return user;
    }

    public String getPassword() {
        return password;
    }
}
