/*
C application to generate a QRCode in pdf format
*/

#include "pdfgen.h"
#include "QR_Encode.h"
#include <fcntl.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <windows.h>
#include <tchar.h>

static void generateQR(const unsigned char *data, int width);

int main(int argc, char* argv[])
{   
    //Input
    char string[100] = "Petit test pour le QRcode";
    
    //Level of redundonce for error correction
    QR_Level level = QR_LEVEL_H;//L,M,Q,H 
    int version = 0;
    QR_MaskPattern mask = QR_MaskAuto;
    int ch;

    unsigned char encoded[MAX_BITDATA];

    int width = EncodeData(level, version, mask, string, 0, encoded);
    if (width <= 0) {
        exit(EXIT_FAILURE);
    }
    int size = ((width * width) / 8) + (((width * width) % 8) ? 1 : 0);

    printf("QR Code width: %d\n", width);

    //Draw QRcode in the PDF file
    generateQR(encoded, width);

    return 0;
}


static void generateQR(const unsigned char* data, int width)
{
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
    int QRcodeWidth = 150;
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
    pdf_save(pdf, "newQRcode.pdf");
    pdf_destroy(pdf);
}
/** 
 * Compilation commands
 * gcc -c pdfgen.c
 * gcc -c QR_Encode.c
 * gcc pdfgen.o QR_Encode.o QRcodeGenerator.c -o QRcodeGenerator.exe
*/