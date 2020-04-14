/*
C application to generate a QRCode in pdf format and insert all Associate information into the database with GUI 
Project Chrysalead
*/

#include "includes/struct.h"
#include <gtk/gtk.h>
#include "includes/QRcodeGenerator.h"
#include "includes/pdfgen.h"
#include "includes/QR_Encode.h"
#include "includes/addAssociate.h"
#include "includes/gui.h"
// #include "includes/mysql/mysql.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <windows.h>
#include <tchar.h>

// G_MODULE_EXPORT void on_generateButton_clicked(GtkWidget *widget, gpointer userData);

int main(int argc, char *argv[])
{
    //MYSQL *con = mysql_init(NULL);
    //Create Widget for the main window
    GtkWidget *window;

    // GtkBuilder *builder;
    GLOBALDATA data;
    data.builder = gtk_builder_new();

    //GTK initialisation
    gtk_init(&argc, &argv);

    //Adding the glade file to the builder
    gtk_builder_add_from_file(data.builder, "builder/mainWindow.glade", NULL);

    //Getting the wmain window Widget
    window = GTK_WIDGET(gtk_builder_get_object(data.builder, "mainWindow"));

    //Making all the connection to the signal
    gtk_builder_connect_signals(data.builder, &data);

    //Display the main window
    gtk_widget_show(window);

    //GTK loop
    gtk_main();

    return 0;
}

/** 
 * Exeample of use to print QRcode
 * char string[100] = "CCC";
 * generateQRcode(string);
 * system("pause");
 * return 0;
 * 
 * Set ICON
 * #windres builder/logo.rc -o logo.o
 * 
 * Compilation commands
 * gcc -c `pkg-config --cflags gtk+-3.0` functions/*.c `pkg-config --libs gtk+-3.0`
 * 
 * With the shell
 * gcc `pkg-config --cflags gtk+-3.0` pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o addAssociate.o logo.o main.c -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`
 * 
 * Without the shell
 * gcc -mwindows `pkg-config --cflags gtk+-3.0` pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o addAssociate.o logo.o main.c -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`
 * 
 * 
 * Bad ones not working (Trying directly with mysql lib)
 * gcc -mwindows `pkg-config --cflags gtk+-3.0` pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o logo.o main.c -L/functions -lmysqlclient -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`
 * gcc `pkg-config --cflags gtk+-3.0` main.c pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o logo.o functions/libmysqlclient.a -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`
 * gcc -mwindows `pkg-config --cflags gtk+-3.0` main.c functions/libmysqlclient.a pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o logo.o -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`
 * gcc `pkg-config --cflags gtk+-3.0` main.c pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o addAssociate.o logo.o -Lfunctions -lmysqlclient -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`
*/