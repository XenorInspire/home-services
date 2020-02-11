/*
C application to generate a QRCode in pdf format
Project Chrysalead
*/

#include "includes/QRcodeGenerator.h"
#include "includes/pdfgen.h"
#include "includes/QR_Encode.h"
#include <fcntl.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <windows.h>
#include <tchar.h>

int main(int argc, char *argv[])
{
    char string[100] = "CCC";
    generateQRcode(string);
    system("pause");
    return 0;
}

/** 
 * Compilation commands
 * gcc -c functions/*.c
 * gcc pdfgen.o QR_Encode.o QRcodeGenerator.o main.c -o QRcodeGenerator.exe
*/