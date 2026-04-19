package model;

public class ContactLense {
    int id;
    String name;
    int wearPeriodId;
    double price;

    public ContactLense(int id, String name, int wearPeriodId, double price) {
        this.id = id;
        this.name = name;
        this.wearPeriodId = wearPeriodId;
        this.price = price;
    }

    @Override
    public String toString() {
        return name + " (" + wearPeriodId + ") :" + price ;
    }
}
