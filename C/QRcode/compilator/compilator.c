#include <stdlib.h>
#include <stdio.h>
#include <string.h>

int main(int argc, char const *argv[]) {

  char choice = 'o';
  while(choice == 'o'){

    if((argv[1] != NULL) && ((strncmp(argv[1],"-c",2)) == 0)) system("clear");

    system("gcc -c ../functions/gui.c");
    system("gcc -c ../functions/addAssociate.c");
    system("gcc -c ../functions/pdfgen.c");
    system("gcc -c ../functions/QR_Encode.c");
    system("gcc -c ../functions/QRcodeGenerator.c");
    system("gcc -c ../main.c");
    system("gcc -o QRcodeGenerator.exe main.o gui.o addAssociate.o pdfgen.o QR_Encode.o QRcodeGenerator.o ../mysql/lib/libmysql.lib");

    system("mv gui.o ../functions/gui.o");
    system("mv addAssociate.o ../functions/addAssociate.o");
    system("mv pdfgen.o ../functions/pdfgen.o");
    system("mv QR_Encode.o ../functions/QR_Encode.o");
    system("mv QRcodeGenerator.o ../functions/QRcodeGenerator.o");
    system("mv main.o ../main.o");
    system("mv QRcodeGenerator.exe ../QRcodeGenerator.exe");

    printf("Recompiler ? (o/n) \n");
    fflush(stdin);
    scanf("%c",&choice);

  }

  return 0;
}
