package ui;

import model.ContactLense;
import model.Frame;
import model.Lense;
import model.WearPeriod;
import repository.ContactLenseRepository;
import repository.WearPeriodRepository;
import service.ProductService;

import java.util.List;
import java.util.Scanner;

public class CLI {
    private ProductService productService = new ProductService();
    private Scanner scanner = new Scanner(System.in);

    public void showAllProducts() {
        List<Frame> frames = productService.getAllFrames();
        List<ContactLense> contactLenses = productService.getAllContactLenses();

        for (Frame frame : frames) {
            System.out.println(frame);
        }
        for (ContactLense contactLense : contactLenses) {
            System.out.println(contactLense);
        }
    }
    public void showAllFrames() {
        List<Frame> frames = productService.getAllFrames();
        for (Frame frame : frames) {
            System.out.println(frame);
        }
    }
    public void showAllContactLenses() {
        List<ContactLense> contactLenses = productService.getAllContactLenses();
        for (ContactLense contactLense : contactLenses) {
            System.out.println(contactLense);
        }
    }

    public void display() {
        boolean running = true;
        while (running) {
            System.out.println("\n=== OPTIDIVY===");
            System.out.println("1. All");
            System.out.println("2. Frames");
            System.out.println("3. Contact Lenses");
            System.out.println("0. Exit");

            int choice = scanner.nextInt();

            switch (choice) {
                case 1:
                    this.showAllProducts();
                    break;
                case 2:
                    this.showAllFrames();
                    break;
                case 3:
                    this.showAllContactLenses();
                    break;
                case 0:
                    running = false;
                    break;
            }
        }
    }
}
