package model;

public class ContactLense implements Product {
    int id;
    String name;
    String wearPeriod;
    double price;

    public ContactLense(int id, String name, String wearPeriod, double price) {
        this.id = id;
        this.name = name;
        this.wearPeriod = wearPeriod;
        this.price = price;
    }

    public double getPrice() {
        return price;
    }

    @Override
    public String toString() {
        return name + " (" + wearPeriod + ") :" + price ;
    }
}
