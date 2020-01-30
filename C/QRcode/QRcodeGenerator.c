/*
C application to generate a QRCode
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

#define MODE 777
static int margin = 4;

/* Because getprogname(3) is not portable yet. */
const char* progname;

static void usage(void);
static void white(void);
static void black(void);
static void nl(void);
static void top_bottom_margin(int width);
static void left_right_margin(void);
static void ansi_qr(const unsigned char* data, int width);

void Color(int flags)
{
    HANDLE H=GetStdHandle(STD_OUTPUT_HANDLE);
    SetConsoleTextAttribute(H,(WORD)flags);
}

static void usage(void)
{
    fprintf(stderr, "%s [-l level] [-v version] [-p mask] [-o file] "
                    "[-m margin] <input string>\n",
        progname);
    fprintf(stderr, "level, version and mask defaults to 3, 0 and auto respectively\n");
    exit(2);
}
int main(int argc, char* argv[])
{
    progname = argv[0];
    QR_Level level = QR_LEVEL_H;
    int version = 0;
    QR_MaskPattern mask = QR_MaskAuto;
    char* fname = NULL;
    int fd = -1;
    int ch;

    while ((ch = getopt(argc, argv, "l:v:o:m:p:")) != -1) {
        switch (ch) {
        case 'l':
            level = atoi(optarg);
            break;
        case 'v':
            version = atoi(optarg);
            break;
        case 'o':
            fname = optarg;
            break;
        case 'm':
            margin = atoi(optarg);
            break;
        case 'p':
            mask = atoi(optarg);
            break;
        default:
            usage();
            /* NOTREACHED */
        }
    }

    argc -= optind;
    argv += optind;

    if (argc != 1) {
        usage();
        /* NOTREACHED */
    }
    // errno = EINVAL;
    if (level < QR_LEVEL_L || level > QR_LEVEL_H) {
        fprintf(stderr, "level \n");
    }
    if (version < 0 || version > 40) {
        fprintf(stderr, "version \n");
    }
    if (mask < QR_MaskAuto || mask > QR_Mask8) {
        fprintf(stderr, "mask \n");
    }
    errno = 0;
    unsigned char encoded[MAX_BITDATA];

    int width = EncodeData(level, version, mask, argv[0], 0, encoded);
    if (width <= 0) {
        exit(EXIT_FAILURE);
    }
    int size = ((width * width) / 8) + (((width * width) % 8) ? 1 : 0);

    printf("QR Code width: %d\n", width);

    if (fname != NULL && *fname != '\0') {
        fd = open(fname, O_WRONLY | O_CREAT | O_TRUNC, MODE);
        if (fd == -1) {
            fprintf(stderr, "failed to open \n");
        }

        printf("writing file (%d bytes)\n", size);
        if (write(fd, encoded, size) != size) {
            fprintf(stderr, "writing problem \n");
        }

        close(fd);
    }

    ansi_qr(encoded, width);

    return 0;
}

enum { was_reset,
    was_white,
    was_black } static last_color
    = was_reset;

static void white(void)
{
    if (last_color != was_white) {
        // printf(WHITE);
        Color(BACKGROUND_BLUE|BACKGROUND_RED|BACKGROUND_GREEN);
        // printf("  ");
        last_color = was_white;
    }
    // Color(0);
    // printf("  ");
}

static void black(void)
{
    if (last_color != was_black) {
        // printf(BLACK);
        Color(0);
        // printf("  ");
        last_color = was_black;
    }
    // Color(0);
    // printf("  ");
}

static void nl(void)
{
    if (last_color != was_reset) {
        // printf(RESET);
        // printf("  ");
        last_color = was_reset;
    }
    printf("\n");
}

static void top_bottom_margin(int width)
{
    int i, j;

    for (i = 0; i < margin; i++) {
        for (j = 0; j < width + (margin * 2); j++) {
            white();
        }
        nl();
    }
}

static void left_right_margin(void)
{
    int i;

    for (i = 0; i < margin; i++) {
        white();
    }
}

static void ansi_qr(const unsigned char* data, int width)
{
    struct pdf_info info = {.creator = "My software",
                            .producer = "My software",
                            .title = "My document",
                            .author = "My name",
                            .subject = "My subject",
                            .date = "Today"};
    struct pdf_doc *pdf = pdf_create(PDF_A4_WIDTH, PDF_A4_HEIGHT, &info);
    pdf_set_font(pdf, "Times-Roman");
    pdf_append_page(pdf);

    int i, j;
    int whiteCase = 0;

    // top_bottom_margin(width);
    for (i = 0; i < width; i++) {
        // left_right_margin();
        for (j = 0; j < width; j++) {
            long byte = (i * width + j) / 8;
            long bit = (i * width + j) % 8;
            if (data[byte] & (0x80 >> bit)) {
                // black();
                // printf("B");
                pdf_add_filled_rectangle(pdf, NULL, 200+j*10, 600-i*10, 10, 10, 1, PDF_BLACK);
            } else {
                // white();
                // printf("W");
                pdf_add_filled_rectangle(pdf, NULL, 200+j*10, 600-i*10, 10, 10, 1, PDF_WHITE);
            }
        }
        // left_right_margin();
        nl();
    }
    // top_bottom_margin(width);

    pdf_save(pdf, "newQRcode.pdf");
    pdf_destroy(pdf);
}

//gcc pdfgen.o QR_Encode.o QRcodeGenerator.c -o QRcodeGenerator.exe
