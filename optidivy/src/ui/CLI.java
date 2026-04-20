package ui;

import model.ContactLense;
import model.Frame;
import model.Lense;
import model.WearPeriod;
import repository.ContactLenseRepository;
import repository.WearPeriodRepository;
import service.Filter;
import service.ProductService;

import java.util.List;
import java.util.Scanner;

public class CLI {
    private ProductService productService = new ProductService();
    private Scanner scanner = new Scanner(System.in);
    private Filter filter = new Filter();

    public void showAllProducts(Filter filter) {
        List<Frame> frames = productService.getAllFrames(filter);
        List<ContactLense> contactLenses = productService.getAllContactLenses(filter);

        for (Frame frame : frames) {
            System.out.println(frame);
        }
        for (ContactLense contactLense : contactLenses) {
            System.out.println(contactLense);
        }
    }
    public void showAllFrames(Filter filter) {
        List<Frame> frames = productService.getAllFrames(filter);
        for (Frame frame : frames) {
            System.out.println(frame);
        }
    }
    public void showAllContactLenses(Filter filter) {
        List<ContactLense> contactLenses = productService.getAllContactLenses(filter);
        for (ContactLense contactLense : contactLenses) {
            System.out.println(contactLense);
        }
    }

    public void display() {
        boolean running = true;
        while (running) {
            System.out.println("\n=== OPTIDIVY===");
            System.out.println("1. Frames");
            System.out.println("2. Contact Lenses");
            System.out.println("0. Exit");

            int choice = scanner.nextInt();
            double limit;
            int ascDesc;

            switch (choice) {
                case 1:
                    filter.setType("frames");
                    System.out.println("\n=== OPTIDIVY===");
                    System.out.println("1. Done");
                    System.out.println("2. Filter by price");
                    choice = scanner.nextInt();
                    switch (choice) {
                        case 1:
                            filter.setMaxPrice(null);
                            filter.setMinPrice(null);
                            filter.setSortByPrice(false);
                            filter.setSortByPrice(true);
                            this.showAllFrames(filter);
                            break;
                        case 2:
                            System.out.println("\n=== OPTIDIVY===");
                            System.out.println("1. Set Min and Max price");
                            System.out.println("2. Set Min price");
                            System.out.println("3. Set Max price");
                            choice = scanner.nextInt();
                            switch (choice) {
                                case 1:
                                    System.out.println("Min price: ");
                                    limit = scanner.nextDouble();
                                    filter.setMinPrice(limit);
                                    System.out.println("Max price: ");
                                    limit = scanner.nextDouble();
                                    filter.setMaxPrice(limit);
                                    System.out.println("Order products?");
                                    System.out.println("1. ASC");
                                    System.out.println("2. DESC");
                                    System.out.println("3. None");
                                    ascDesc = scanner.nextInt();
                                    switch (ascDesc) {
                                        case 1:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(true);
                                            this.showAllFrames(filter);
                                            break;
                                        case 2:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(false);
                                            this.showAllFrames(filter);
                                            break;
                                        case 3:
                                            filter.setSortByPrice(false);
                                            this.showAllFrames(filter);
                                            break;
                                    }
                                    break;
                                case 2:
                                    System.out.println("Min price: ");
                                    limit = scanner.nextDouble();
                                    filter.setMinPrice(limit);
                                    System.out.println("Order products?");
                                    System.out.println("1. ASC");
                                    System.out.println("2. DESC");
                                    System.out.println("3. None");
                                    ascDesc = scanner.nextInt();
                                    switch (ascDesc) {
                                        case 1:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(true);
                                            this.showAllFrames(filter);
                                            break;
                                        case 2:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(false);
                                            this.showAllFrames(filter);
                                            break;
                                        case 3:
                                            filter.setSortByPrice(false);
                                            this.showAllFrames(filter);
                                            break;
                                    }
                                    break;
                                case 3:
                                    System.out.println("Max price: ");
                                    limit = scanner.nextDouble();
                                    filter.setMaxPrice(limit);
                                    System.out.println("Order products?");
                                    System.out.println("1. ASC");
                                    System.out.println("2. DESC");
                                    System.out.println("3. None");
                                    ascDesc = scanner.nextInt();
                                    switch (ascDesc) {
                                        case 1:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(true);
                                            this.showAllFrames(filter);
                                            break;
                                        case 2:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(false);
                                            this.showAllFrames(filter);
                                            break;
                                        case 3:
                                            filter.setSortByPrice(false);
                                            this.showAllFrames(filter);
                                            break;
                                    }
                                    break;
                            }
                            break;
                    }
                    break;
                case 2:
                    filter.setType("contacts");
                    System.out.println("\n=== OPTIDIVY===");
                    System.out.println("1. Done");
                    System.out.println("2. Filter by price");
                    choice = scanner.nextInt();
                    switch (choice) {
                        case 1:
                            filter.setMaxPrice(null);
                            filter.setMinPrice(null);
                            filter.setSortByPrice(false);
                            filter.setSortByPrice(true);
                            this.showAllContactLenses(filter);
                            break;
                        case 2:
                            System.out.println("\n=== OPTIDIVY===");
                            System.out.println("1. Set Min and Max price");
                            System.out.println("2. Set Min price");
                            System.out.println("3. Set Max price");
                            choice = scanner.nextInt();
                            switch (choice) {
                                case 1:
                                    System.out.println("Min price: ");
                                    limit = scanner.nextDouble();
                                    filter.setMinPrice(limit);
                                    System.out.println("Max price: ");
                                    limit = scanner.nextDouble();
                                    filter.setMaxPrice(limit);
                                    System.out.println("Order products?");
                                    System.out.println("1. ASC");
                                    System.out.println("2. DESC");
                                    System.out.println("3. None");
                                    ascDesc = scanner.nextInt();
                                    switch (ascDesc) {
                                        case 1:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(true);
                                            this.showAllContactLenses(filter);
                                            break;
                                        case 2:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(false);
                                            this.showAllContactLenses(filter);
                                            break;
                                        case 3:
                                            filter.setSortByPrice(false);
                                            this.showAllContactLenses(filter);
                                            break;
                                    }
                                    break;
                                case 2:
                                    System.out.println("Min price: ");
                                    limit = scanner.nextDouble();
                                    filter.setMinPrice(limit);
                                    System.out.println("Order products?");
                                    System.out.println("1. ASC");
                                    System.out.println("2. DESC");
                                    System.out.println("3. None");
                                    ascDesc = scanner.nextInt();
                                    switch (ascDesc) {
                                        case 1:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(true);
                                            this.showAllContactLenses(filter);
                                            break;
                                        case 2:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(false);
                                            this.showAllContactLenses(filter);
                                            break;
                                        case 3:
                                            filter.setSortByPrice(false);
                                            this.showAllContactLenses(filter);
                                            break;
                                    }
                                    break;
                                case 3:
                                    System.out.println("Max price: ");
                                    limit = scanner.nextDouble();
                                    filter.setMaxPrice(limit);
                                    System.out.println("Order products?");
                                    System.out.println("1. ASC");
                                    System.out.println("2. DESC");
                                    System.out.println("3. None");
                                    ascDesc = scanner.nextInt();
                                    switch (ascDesc) {
                                        case 1:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(true);
                                            this.showAllContactLenses(filter);
                                            break;
                                        case 2:
                                            filter.setSortByPrice(true);
                                            filter.setSortOrderAsc(false);
                                            this.showAllContactLenses(filter);
                                            break;
                                        case 3:
                                            filter.setSortByPrice(false);
                                            this.showAllContactLenses(filter);
                                            break;
                                    }
                                    break;
                            }
                            break;
                    }
                    break;
                case 0:
                    running = false;
                    break;
            }
        }
    }
}
