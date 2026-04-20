package service;

public class Filter {
    Double minPrice;
    Double maxPrice;
    String type;
    boolean sortByPrice;
    boolean sortOrderAsc;

    public Filter() {
        this.minPrice = null;
        this.maxPrice = null;
        this.type = null;
        this.sortByPrice = false;
        this.sortOrderAsc = true;
    }

    public Double getMinPrice() {
        return minPrice;
    }

    public void setMinPrice(Double minPrice) {
        this.minPrice = minPrice;
    }

    public Double getMaxPrice() {
        return maxPrice;
    }

    public void setMaxPrice(Double maxPrice) {
        this.maxPrice = maxPrice;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public boolean isSortByPrice() {
        return sortByPrice;
    }

    public void setSortByPrice(boolean sortByPrice) {
        this.sortByPrice = sortByPrice;
    }

    public boolean isSortOrderAsc() {
        return sortOrderAsc;
    }

    public void setSortOrderAsc(boolean sortOrderAsc) {
        this.sortOrderAsc = sortOrderAsc;
    }
}
