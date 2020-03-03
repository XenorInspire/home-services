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
#include <time.h>


int main(int argc, char *argv[])
{
    if ((argv[1] != NULL)){
        
        generateQRcode(argv[1],argv[2],argv[3]);

        HANDLE thread = CreateThread(NULL, 0, NULL, NULL, 0, NULL);
        if (thread)
        {
            char command[255] = "";
            //Generating Time
            time_t t = time(NULL);
            struct tm tm = *localtime(&t);

            //Launch the created PDF
            sprintf(command, "cd pdf/ && %s-%s-%02d-%02d-%02d.pdf", argv[2], argv[3], tm.tm_mday, tm.tm_mon + 1, tm.tm_year + 1900);
            system(command);
            return 0;
        }
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