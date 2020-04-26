package sqlconnect;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Scanner;

public class Main {

    public static void main(String[] args) throws SQLException {

        Request rq = new Request();
        Scanner sc = new Scanner(System.in);
        String[] proposals = {"Liste des clients", "Liste des prestataires", "Liste des services", "Liste des réservations", "Liste des types de services", "Liste des types d'abonnements", "Liste des prestations", "Quitter"};
        ArrayList<String[]> table = null;
        int proposal = -1;

        while (proposal < 0 || proposal > proposals.length - 1) {

            System.out.println("Veuillez sélectionner les informations voulues :");

            for (int k = 0; k < proposals.length; k++)
                System.out.println(k + " : " + proposals[k]);

            String str = sc.nextLine();

            try {

                proposal = Integer.parseInt(str);

            } catch (NumberFormatException e) {

                continue;

            }

        }

        switch (proposal) {

            case 0:
                table = rq.getCustomers();
                break;

            case 1:
                table = rq.getAssociates();
                break;

            case 2:
                table = rq.getServices();
                break;

            case 3:
                table = rq.getReservations();
                break;

            case 4:
                table = rq.getServicesTypes();
                break;

            case 5:
                table = rq.getSubscriptionTypes();
                break;

            case 6:
                table = rq.getServiceProvided();
                break;

            case 7:
                finish();
                break;

        }


        for (int i = 0; i < table.size(); i++) {

            for (int j = 0; j < table.get(i).length; j++) {

                System.out.print(table.get(i)[j] + " | ");

            }

            System.out.print("\n\n");

        }

    }

    public static void finish() {

        System.exit(1);

    }
}



