//TIP To <b>Run</b> code, press <shortcut actionId="Run"/> or
// click the <icon src="AllIcons.Actions.Execute"/> icon in the gutter.
import config.Database;

import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;
import ui.CLI;

public class Main {
    public static void main(String[] args) {
        CLI cli = new CLI();
        cli.display();
    }
}