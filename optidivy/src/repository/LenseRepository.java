package repository;

import model.Lense;
import config.Database;

import javax.swing.plaf.nimbus.State;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class LenseRepository {
    public List<Lense> findAll() {
        List<Lense> lenses = new ArrayList<>();

        try{
            Connection conn = Database.connect();

            Statement stm = conn.createStatement();
            ResultSet rs = stm.executeQuery("SELECT * FROM lenses");
            while (rs.next()) {
                Lense lense = new Lense(rs.getInt("id"), rs.getString("type"), rs.getDouble("price"));
                lenses.add(lense);
            }
            conn.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return lenses;
    }
}
