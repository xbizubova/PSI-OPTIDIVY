package model;

public class WearPeriod {
    int id;
    String name;

    public WearPeriod(int id, String name) {
        this.id = id;
        this.name = name;
    }

    public String getPeriod() {
        return this.name;
    }
}
