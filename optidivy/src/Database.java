import java.sql.Connection;
import java.sql.DriverManager;
import java.util.Properties;
import java.io.FileInputStream;

public class Database {

    public static Connection connect() {
        try {
            Properties props = new Properties();
            props.load(new FileInputStream("db.properties"));

            return DriverManager.getConnection(
                    props.getProperty("url"),
                    props.getProperty("user"),
                    props.getProperty("password")
            );

        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
}