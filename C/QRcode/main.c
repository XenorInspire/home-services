/*
C application to generate a QRCode in pdf format
Project Chrysalead
*/

#include "includes/struct.h"
#include <gtk/gtk.h>
#include "includes/QRcodeGenerator.h"
#include "includes/pdfgen.h"
#include "includes/QR_Encode.h"
#include "includes/addAssociate.h"
#include "includes/gui.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <windows.h>
#include <tchar.h>

int main(int argc, char *argv[])
{
    //Create Widget for the main window
    GtkBuilder *builder;
    GtkWidget *window;
    GdkPixbuf *pixbuf;

    //GTK initialisation
    gtk_init(&argc, &argv);

    builder = gtk_builder_new();
    gtk_builder_add_from_file(builder, "builder/mainWindow.glade", NULL);

    window = GTK_WIDGET(gtk_builder_get_object(builder, "mainWindow"));
    gtk_builder_connect_signals(builder, NULL);

    g_object_unref(builder);

    // pixbuf = gdk_pixbuf_new_from_file("builder/logo.png",NULL);
    
    // gtk_window_set_icon_from_file(GTK_WINDOW(window), "builder/logo.png", NULL);
    // gtk_window_set_icon(GTK_WINDOW(window), pixbuf);

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
 * gcc `pkg-config --cflags gtk+-3.0` pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o main.c -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`
 * 
 * Without the shell
 * gcc -mwindows `pkg-config --cflags gtk+-3.0` pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o logo.o main.c -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`
*/