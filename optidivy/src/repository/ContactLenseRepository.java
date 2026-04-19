package repository;

import model.ContactLense;
import config.Database;
import model.Frame;

import javax.swing.plaf.nimbus.State;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ContactLenseRepository {
    public List<ContactLense> findAll() {
        List<ContactLense> contactLenses = new ArrayList<>();

        try{
            Connection conn = Database.connect();

            Statement stm = conn.createStatement();
            ResultSet rs = stm.executeQuery("SELECT * FROM contact_lenses");
            while (rs.next()) {
                ContactLense contactLense = new ContactLense(rs.getInt("id"), rs.getString("name"), rs.getInt("wear_period"), rs.getDouble("price"));
                contactLenses.add(contactLense);
            }
            conn.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return contactLenses;
    }
}
