package sqlconnect;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

public class Window extends JFrame {

    private static final int WIDTH = 1300;
    private static final int HEIGHT = 800;

    private final JPanel pan = new JPanel();
    private final JButton b1 = new JButton("Afficher clients");
    private final JButton b2 = new JButton("Afficher prestataires");
    private final JButton b3 = new JButton("Afficher services");
    private final JButton b4 = new JButton("Afficher réservations");
    private final JButton b5 = new JButton("Afficher types de services");
    private final JButton b6 = new JButton("Afficher types d'abonnements");
    private final JButton b7 = new JButton("Afficher prestations");

    public Window(Request rq) {

        this.setTitle("SQLConnect - Home-Services");
        this.setSize(WIDTH, HEIGHT);
        this.setLocationRelativeTo(null);
        this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        this.setIconImage(new ImageIcon("logo_chrysalead.png").getImage());
        this.setResizable(false);

        pan.add(b1);
        pan.add(b2);
        pan.add(b3);
        pan.add(b4);
        pan.add(b5);
        pan.add(b6);
        pan.add(b7);

        b1.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                String[] head = {"ID", "Nom", "Prénom", "Email", "Tél", "Adresse", "Ville", "MDP", "Activé"};
                JTable results = new JTable(rq.getCustomers(), head);
                pan.add(results.getTableHeader(), BorderLayout.NORTH);
                pan.add(new JScrollPane(results), BorderLayout.CENTER);
                refresh();

            }
        });

        b2.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                String[] head = {"ID", "Nom", "Prénom", "Email", "Tél", "Adresse", "Ville", "SIREN", "Entreprise", "Activé", "MDP"};
                JTable results = new JTable(rq.getAssociates(), head);
                pan.add(results.getTableHeader(), BorderLayout.NORTH);
                pan.add(new JScrollPane(results), BorderLayout.CENTER);
                refresh();

            }
        });

        b3.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                String[] head = {"ID", "Titre", "Description", "Récurrent", "Min H", "Prix", "Commission", "Type de service"};
                JTable results = new JTable(rq.getServices(), head);
                pan.add(results.getTableHeader(), BorderLayout.NORTH);
                pan.add(new JScrollPane(results), BorderLayout.CENTER);
                refresh();

            }
        });

        b4.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                String[] head = {"ID", "Date", "Client", "Prestation", "status"};
                JTable results = new JTable(rq.getReservations(), head);
                pan.add(results.getTableHeader(), BorderLayout.NORTH);
                pan.add(new JScrollPane(results), BorderLayout.CENTER);
                refresh();

            }
        });

        b5.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                String[] head = {"ID", "Titre"};
                JTable results = new JTable(rq.getServicesTypes(), head);
                pan.add(results.getTableHeader(), BorderLayout.NORTH);
                pan.add(new JScrollPane(results), BorderLayout.CENTER);
                refresh();

            }
        });

        b6.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                String[] head = {"ID", "Nom", "NB Jours", "De", "A", "NB Heures", "Prix", "Activé"};
                JTable results = new JTable(rq.getSubscriptionTypes(), head);
                pan.add(results.getTableHeader(), BorderLayout.NORTH);
                pan.add(new JScrollPane(results), BorderLayout.CENTER);
                refresh();

            }
        });

        b7.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                String[] head = {"ID", "Date", "Heure", "NB Heures C", "Service", "NB Heures P", "Adresse", "Ville"};
                JTable results = new JTable(rq.getServiceProvided(), head);
                pan.add(results.getTableHeader(), BorderLayout.NORTH);
                pan.add(new JScrollPane(results), BorderLayout.CENTER);
                refresh();

            }
        });

        this.setContentPane(pan);
        this.setVisible(true);

    }

    public void refresh() {

        this.setContentPane(pan);

    }

}
