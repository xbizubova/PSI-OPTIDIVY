package repository;

import model.Frame;
import config.Database;

import javax.swing.plaf.nimbus.State;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class FrameRepository {
    public List<Frame> findAll() {
        List<Frame> frames = new ArrayList<>();

        try{
            Connection conn = Database.connect();

            Statement stm = conn.createStatement();
            ResultSet rs = stm.executeQuery("SELECT * FROM frames");
            while (rs.next()) {
                Frame frame = new Frame(rs.getInt("id"), rs.getString("name"), rs.getString("color"), rs.getDouble("price"));
                frames.add(frame);
            }
            conn.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return frames;
    }
}
