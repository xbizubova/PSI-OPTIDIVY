package repository;

import model.ContactLense;
import config.Database;
import model.Frame;
import model.Product;
import service.Filter;

import javax.swing.plaf.nimbus.State;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ContactLenseRepository {
    public List<ContactLense> getProducts(Filter filter) {
        QueryBuilder qb = new QueryBuilder();
        Query query = qb.build(filter);
        List<ContactLense> products = new ArrayList<>();

        try (Connection conn = Database.connect();
             PreparedStatement stmt = conn.prepareStatement(query.getQueryBody())) {

            int i = 1;
            for (Object param : query.getValues()) {
                stmt.setObject(i++, param);
            }

            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                ContactLense contactLense = new ContactLense(rs.getInt("id"), rs.getString("name"), rs.getString("wear_period"), rs.getDouble("price"));
                products.add(contactLense);
            }
            conn.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return products;
    }
}
