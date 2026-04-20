package repository;

import model.Frame;
import config.Database;
import model.Product;
import service.Filter;

import javax.swing.plaf.nimbus.State;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class FrameRepository {
    public List<Frame> getProducts(Filter filter) {
        QueryBuilder qb = new QueryBuilder();
        Query query = qb.build(filter);
        List<Frame> products = new ArrayList<>();

        try (Connection conn = Database.connect();
             PreparedStatement stmt = conn.prepareStatement(query.getQueryBody())) {

            int i = 1;
            for (Object param : query.getValues()) {
                stmt.setObject(i++, param);
            }

            ResultSet rs = stmt.executeQuery();

            while (rs.next()) {
                products.add(new Frame(rs.getInt("id"), rs.getString("name"), rs.getString("color"), rs.getDouble("price")
                ));
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return products;
    }
}
