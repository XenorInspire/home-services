package sqlconnect;

import javax.swing.*;
import javax.swing.table.DefaultTableModel;
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

        //Customer button
        b1.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                reset();
                String[] head = {"ID", "Nom", "Prénom", "Email", "Tél", "Adresse", "Ville", "MDP", "Activé"};
                JTable results = new JTable(rq.getCustomers(), head);
                results.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
                results.setModel(model(rq.getCustomers(), head));
                results.setBounds(200, 200, 500, 500);
                pan.add(results.getTableHeader());
                pan.add(new JScrollPane(results));
                refresh();

            }
        });

        //Associate button
        b2.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                reset();
                String[] head = {"ID", "Nom", "Prénom", "Email", "Tél", "Adresse", "Ville", "SIREN", "Entreprise", "Activé", "MDP"};
                JTable results = new JTable(rq.getAssociates(), head);
                results.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
                results.setModel(model(rq.getAssociates(), head));
                results.setBounds(200, 200, 500, 500);
                pan.add(results.getTableHeader());
                pan.add(new JScrollPane(results));
                refresh();

            }
        });

        //Services button
        b3.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                reset();
                String[] head = {"ID", "Titre", "Description", "Récurrent", "Min H", "Prix", "Commission", "Type de service"};
                JTable results = new JTable(rq.getServices(), head);
                results.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
                results.setModel(model(rq.getServices(), head));
                results.setBounds(200, 200, 500, 500);
                pan.add(results.getTableHeader());
                pan.add(new JScrollPane(results));
                refresh();

            }
        });

        //Reservations button
        b4.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                reset();
                String[] head = {"ID", "Date", "Client", "Prestation", "status"};
                JTable results = new JTable(rq.getReservations(), head);
                results.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
                results.setModel(model(rq.getReservations(), head));
                results.setBounds(200, 200, 500, 500);
                pan.add(results.getTableHeader());
                pan.add(new JScrollPane(results));
                refresh();

            }
        });

        //Service Types button
        b5.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                reset();
                String[] head = {"ID", "Titre"};
                JTable results = new JTable(rq.getServicesTypes(), head);
                results.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
                results.setModel(model(rq.getServicesTypes(), head));
                results.setBounds(200, 200, 500, 500);
                pan.add(results.getTableHeader());
                pan.add(new JScrollPane(results));
                refresh();

            }
        });

        //Subscription Types button
        b6.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                reset();
                String[] head = {"ID", "Nom", "NB Jours", "De", "A", "NB Heures", "Prix", "Activé"};
                JTable results = new JTable(rq.getSubscriptionTypes(), head);
                results.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
                results.setModel(model(rq.getSubscriptionTypes(), head));
                results.setBounds(200, 200, 500, 500);
                pan.add(results.getTableHeader());
                pan.add(new JScrollPane(results));
                refresh();

            }
        });

        //Service Provided button
        b7.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                reset();
                String[] head = {"ID", "Date", "Heure", "NB Heures C", "Service", "NB Heures P", "Adresse", "Ville"};
                JTable results = new JTable(rq.getServiceProvided(), head);
                results.setAutoResizeMode(JTable.AUTO_RESIZE_OFF);
                results.setModel(model(rq.getServiceProvided(), head));
                results.setBounds(200, 200, 500, 500);
                pan.add(results.getTableHeader());
                pan.add(new JScrollPane(results));
                refresh();

            }
        });

        this.setContentPane(pan);
        this.setVisible(true);

    }

    public void refresh() {

        this.setContentPane(pan);

    }

    private void reset() {

        pan.removeAll();
        pan.add(b1);
        pan.add(b2);
        pan.add(b3);
        pan.add(b4);
        pan.add(b5);
        pan.add(b6);
        pan.add(b7);

    }

    //Make the cells not changeable
    private DefaultTableModel model(Object[][] data, Object[] columnNames) {
        DefaultTableModel tableModel = new DefaultTableModel(data, columnNames) {

            @Override
            public boolean isCellEditable(int row, int column) {
                return false;
            }
        };
        return tableModel;
    }

}
