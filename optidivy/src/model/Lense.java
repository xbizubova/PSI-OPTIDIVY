package model;

public class Lense {
    int id;
    String type;
    double price;

    public Lense(int id, String type, double price) {
        this.id = id;
        this.type = type;
        this.price = price;
    }

    @Override
    public String toString() {
        return type + ": " + price ;
    }
}
