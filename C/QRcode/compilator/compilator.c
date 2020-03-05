#include <stdlib.h>
#include <stdio.h>
#include <string.h>

int main(int argc, char const *argv[]) {

  char choice = 'o';
  while(choice == 'o'){

    
      
    //Functions
    system("cd .. && C:\\msys64\\mingw64.exe gcc -c `pkg-config --cflags gtk+-3.0` ../functions/*.c `pkg-config --libs gtk+-3.0`");
    //Sql
    system("C:\\msys64\\mingw64.exe gcc mainSql.c -o SqlManage.exe lib\\libmysql.lib");

    //Qrcode
    system("C:\\msys64\\mingw64.exe gcc pdfgen.o QR_Encode.o QRcodeGenerator.o mainQRcode.c -o QRcode.exe");

    //GUI
    if ((argv[1] != NULL) && ((strncmp(argv[1], "-w", 2)) == 0))
    {
      system("C:\\msys64\\mingw64.exe gcc -mwindows `pkg-config --cflags gtk+-3.0` pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o addAssociate.o logo.o main.c -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`");
    }
    else
    {
      system("C:\\msys64\\mingw64.exe gcc `pkg-config --cflags gtk+-3.0` pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o addAssociate.o logo.o main.c -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`");
    }

    printf("Recompiler ? (o/n) \n");
    fflush(stdin);
    scanf("%c",&choice);

  }

  return 0;
}

//gcc compilator.c -o compilator.exe
