package repository;

import java.util.List;

public class Query {
    String queryBody;
    List<Object> values;

    public Query(String string, List<Object> values) {
        queryBody = string;
        this.values = values;
    }

    public String getQueryBody() {
        return queryBody;
    }

    public List<Object> getValues() {
        return values;
    }
}
