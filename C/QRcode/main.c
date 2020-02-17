/*
C application to generate a QRCode in pdf format
*/

#include "QRcodeGenerator.h"
#include "pdfgen.h"
#include "QR_Encode.h"
#include <fcntl.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <windows.h>
#include <tchar.h>


int main(int argc, char *argv[])
{
    char string[100] = "CC";
    generateQRcode(string);
    return 0;
}

/** 
 * Compilation commands
 * gcc -c pdfgen.c
 * gcc -c QR_Encode.c
 * gcc -c QRcodeGenerator.c 
 * gcc pdfgen.o QR_Encode.o QRcodeGenerator.o main.c -o QRcodeGenerator.exe
*/