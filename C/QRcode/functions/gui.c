
#include <gtk/gtk.h>
#include "../includes/QRcodeGenerator.h"
#include <stdio.h>
#include <stdlib.h>

G_MODULE_EXPORT void on_windowMain_destroy(){
    gtk_main_quit();
}

G_MODULE_EXPORT void on_generateButton_clicked(GtkWidget *widget, gpointer data)
{
    printf("HI\n");

    // GtkWidget *entry = GTK_WIDGET(gtk_builder_get_object(builder, "firstNameEntry"));
    // printf("%s", gtk_entry_get_text(GTK_ENTRY(entry));
    GtkBuilder *builder;
    builder = gtk_builder_new();

    gtk_builder_add_from_file(builder, "../builder/mainWindow.glade", NULL);

    if (gtk_builder_get_object(builder, "firstNameEntry") == NULL)
    {
        printf("Pas reussi");
    }

    GtkWidget *firstNameEntry1 = GTK_WIDGET(gtk_builder_get_object(builder, "firstNameEntry"));
    //GtkEntry *firstNameEntry1 = GTK_ENTRY(gtk_builder_get_object(builder, "firstNameEntry"));

    /* Auto-connect signal handlers */
    gtk_builder_connect_signals(builder, firstNameEntry1);

    // g_object_unref(builder);

    const gchar * entry;
    entry = gtk_entry_get_text(GTK_ENTRY(firstNameEntry1));
    //entry = gtk_entry_get_text(firstNameEntry1);
    // printf("%s", firstNameEntry);

    printf("%s", entry);

    // gtk_label_set_text(GTK_LABEL(display),d_string);
}
