/*
C application to generate a QRCode in pdf format
Project Chrysalead
*/


#include "includes/QRcodeGenerator.h"
#include "includes/pdfgen.h"
#include "includes/QR_Encode.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <windows.h>
#include <tchar.h>

// G_MODULE_EXPORT void on_generateButton_clicked(GtkWidget *widget, gpointer userData);

int main(int argc, char *argv[])
{
    if ((argv[1] != NULL)){
        generateQRcode(argv[1],argv[2],argv[3]);
    }
    return 0;
}

/** 
 * Compilation commands
 * gcc -c `pkg-config --cflags gtk+-3.0` functions/*.c `pkg-config --libs gtk+-3.0`
 * gcc pdfgen.o QR_Encode.o QRcodeGenerator.o main2.c -o QRcode.exe
 * 
 * Without the shell
 * gcc -mwindows pdfgen.o QR_Encode.o QRcodeGenerator.o main2.c -o QRcode.exe
*/