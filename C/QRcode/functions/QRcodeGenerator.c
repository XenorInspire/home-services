/*
C application to generate a QRCode in pdf format
*/
#include "../includes/struct.h"
#include "../includes/pdfgen.h"
#include "../includes/QR_Encode.h"
#include "../includes/QRcodeGenerator.h"
#include <fcntl.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <windows.h>
#include <tchar.h>
#include <stdio.h>
#include <time.h>

void generateQRcode(const char *inputString, const char *lastName, const char *firstName)
{
    //Generating Time
    time_t t = time(NULL);
    struct tm tm = *localtime(&t);

    char pdfName[255] = " ";
    sprintf(pdfName, "%s-%s-%02d-%02d-%02d", lastName, firstName, tm.tm_mday, tm.tm_mon + 1, tm.tm_year + 1900);

    //Level of redundonce for error correction
    QR_Level level = QR_LEVEL_H; //L,M,Q,H
    int version = 0;
    QR_MaskPattern mask = QR_MaskAuto;
    int ch;

    unsigned char encoded[MAX_BITDATA];

    int width = EncodeData(level, version, mask, inputString, 0, encoded);
    if (width <= 0)
    {
        exit(EXIT_FAILURE);
    }
    int size = ((width * width) / 8) + (((width * width) % 8) ? 1 : 0);

    // printf("QR Code width: %d\n", width);

    //Draw QRcode in the PDF file
    generateQRcodeToPDF(encoded, width,pdfName);

    // system("pause");
}

void generateQRcodeToPDF(const unsigned char *data, int width, const char *pdfName)
{
    char newPdfName[255] = " ";
    strcpy(newPdfName,pdfName);
    //Creation of the pdf format 
    struct pdf_info info = {.creator = "My software",
                            .producer = "My software",
                            .title = "My document",
                            .author = "My name",
                            .subject = "My subject",
                            .date = "Today"};
    struct pdf_doc *pdf = pdf_create(PDF_A4_WIDTH, PDF_A4_HEIGHT, &info);
    pdf_set_font(pdf, "Times-Roman");
    pdf_append_page(pdf);

    //Variables for drawing
    int i, j;
    int QRcodeWidth = 240;
    int QrcodeHeight = 600;
    int pixelWidth = 5;

    //Drawing QRcode in PDF
    for (i = 0; i < width; i++) {
        for (j = 0; j < width; j++) {
            long byte = (i * width + j) / 8;
            long bit = (i * width + j) % 8;
            if (data[byte] & (0x80 >> bit)) {
                //Black pixels
                pdf_add_filled_rectangle(pdf, NULL, QRcodeWidth+j*pixelWidth, QrcodeHeight-i*pixelWidth, pixelWidth, pixelWidth, 1, PDF_BLACK);
            } else {
                //White pixels
                pdf_add_filled_rectangle(pdf, NULL, QRcodeWidth+j*pixelWidth, QrcodeHeight-i*pixelWidth, pixelWidth, pixelWidth, 1, PDF_WHITE);
            }
        }
    }
    //Save PDF
    strcat(newPdfName,".pdf");
    pdf_save(pdf,newPdfName);
    pdf_destroy(pdf);

    //Move pdf into the folder
    char command[255] = "";
    sprintf(command,"cp %s pdf/ && rm -r %s",newPdfName,newPdfName);
    system(command);
}
/** 
 * Compilation commands
 * gcc -c pdfgen.c
 * gcc -c QR_Encode.c
 * gcc pdfgen.o QR_Encode.o QRcodeGenerator.c -o QRcodeGenerator.exe
*/