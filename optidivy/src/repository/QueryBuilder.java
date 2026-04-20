package repository;

import service.Filter;

import java.util.ArrayList;
import java.util.List;

public class QueryBuilder {
    public Query build(Filter filter) {
        StringBuilder query = new StringBuilder();
        List<Object> values = new ArrayList<>();

        if ("frames".equals(filter.getType())){
            query.append("SELECT * FROM frames WHERE 1=1");
        }
        else if ("contacts".equals(filter.getType())){
            query.append("SELECT * FROM contact_lenses WHERE 1=1");
        }
        else{
            throw new IllegalArgumentException("Incorrect filter type");
        }

        if (filter.getMaxPrice() != null){
            values.add(filter.getMaxPrice());
            query.append(" AND price <= ?");
        }
        if (filter.getMinPrice() != null){
            values.add(filter.getMinPrice());
            query.append(" AND price >= ?");
        }

        if (filter.isSortByPrice()){
            query.append(" ORDER BY price ");
            query.append(filter.isSortOrderAsc() ? "ASC" : " DESC");
        }
        return new Query(query.toString(), values);
    }
}
