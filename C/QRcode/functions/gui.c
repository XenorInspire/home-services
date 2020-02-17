#include "../includes/struct.h"
#include <gtk/gtk.h>
#include "../includes/addAssociate.h"
#include "../includes/QRcodeGenerator.h"
#include "../includes/gui.h"
#include <stdio.h>
#include <stdlib.h>

G_MODULE_EXPORT void on_windowMain_destroy()
{
    gtk_main_quit();
}

G_MODULE_EXPORT void on_generateButton_clicked(GtkWidget *widget, gpointer userData)
{
    ASSOCIATE associate;

    const gchar *entry;
    char identifier[255];

    GLOBALDATA *data = (GLOBALDATA *)userData;

    GtkEntry *lastNameEntry = GTK_ENTRY(gtk_builder_get_object(data->builder, "lastNameEntry"));
    GtkEntry *firstNameEntry = GTK_ENTRY(gtk_builder_get_object(data->builder, "firstNameEntry"));
    GtkEntry *emailEntry = GTK_ENTRY(gtk_builder_get_object(data->builder, "emailEntry"));
    GtkEntry *phoneNumberEntry = GTK_ENTRY(gtk_builder_get_object(data->builder, "phoneNumberEntry"));
    GtkEntry *addressEntry = GTK_ENTRY(gtk_builder_get_object(data->builder, "addressEntry"));
    GtkEntry *townEntry = GTK_ENTRY(gtk_builder_get_object(data->builder, "townEntry"));
    GtkEntry *sirenNumberEntry = GTK_ENTRY(gtk_builder_get_object(data->builder, "sirenNumberEntry"));
    GtkEntry *companyNameEntry = GTK_ENTRY(gtk_builder_get_object(data->builder, "companyNameEntry"));
    //GtkWidget *firstNameEntry = GTK_WIDGET(gtk_builder_get_object(data->builder, "firstNameEntry"));

    /* Auto-connect signal handlers */
    gtk_builder_connect_signals(data->builder, lastNameEntry);
    gtk_builder_connect_signals(data->builder, firstNameEntry);
    gtk_builder_connect_signals(data->builder, emailEntry);
    gtk_builder_connect_signals(data->builder, phoneNumberEntry);
    gtk_builder_connect_signals(data->builder, addressEntry);
    gtk_builder_connect_signals(data->builder, townEntry);
    gtk_builder_connect_signals(data->builder, sirenNumberEntry);
    gtk_builder_connect_signals(data->builder, companyNameEntry);

    // entry = gtk_entry_get_text(GTK_ENTRY(firstNameEntry));
    sprintf(associate.lastName, "%s", gtk_entry_get_text(lastNameEntry));
    sprintf(associate.firstName, "%s", gtk_entry_get_text(firstNameEntry));
    sprintf(associate.email, "%s", gtk_entry_get_text(emailEntry));
    sprintf(associate.phoneNumber, "%s", gtk_entry_get_text(phoneNumberEntry));
    sprintf(associate.address, "%s", gtk_entry_get_text(addressEntry));
    sprintf(associate.town, "%s", gtk_entry_get_text(townEntry));
    associate.sirenNumber = atoi(gtk_entry_get_text(sirenNumberEntry));
    sprintf(associate.companyName, "%s", gtk_entry_get_text(companyNameEntry));

    identifierGenerator(&associate, identifier);

    printf("%s\n", associate.lastName);
    printf("%s\n", associate.firstName);
    printf("%s\n", associate.email);
    printf("%s\n", associate.phoneNumber);
    printf("%s\n", associate.address);
    printf("%s\n", associate.town);
    printf("%d\n", associate.sirenNumber);
    printf("%s\n", associate.companyName);
    printf("%s\n", identifier);


}