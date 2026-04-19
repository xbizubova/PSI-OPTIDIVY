package repository;

import model.WearPeriod;
import config.Database;

import javax.swing.plaf.nimbus.State;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class WearPeriodRepository {
    public List<WearPeriod> findAll() {
        List<WearPeriod> wearPeriods = new ArrayList<>();

        try{
            Connection conn = Database.connect();

            Statement stm = conn.createStatement();
            ResultSet rs = stm.executeQuery("SELECT * FROM wear_period_options");
            while (rs.next()) {
                WearPeriod wearPeriod = new WearPeriod(rs.getInt("id"), rs.getString("name"));
                wearPeriods.add(wearPeriod);
            }
            conn.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return wearPeriods;
    }
}
