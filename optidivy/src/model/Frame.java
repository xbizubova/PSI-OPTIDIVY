package model;

public class Frame implements Product {
    int id;
    String name;
    String color;
    double price;

    public Frame(int id, String name, String color, double price) {
        this.id = id;
        this.name = name;
        this.color = color;
        this.price = price;
    }

    public double getPrice() {
        return price;
    }

    @Override
    public String toString() {
        return name + " (" + color + ") :" + price ;
    }
}
