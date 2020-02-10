#include <stdlib.h>
#include <stdio.h>
#include <string.h>

int main(int argc, char const *argv[]) {

  char choice = 'o';
  while(choice == 'o'){

    if((argv[1] != NULL) && ((strncmp(argv[1],"-c",2)) == 0)) system("clear");

    system("gcc -c ../functions/system.c");
    system("gcc -c ../main.c");
    system("gcc -o SQLFusion.exe main.o system.o");

    system("mv system.o ../functions/system.o");
    system("mv main.o ../main.o");
    system("mv SQLFusion.exe ../SQLFusion.exe");

    printf("Recompiler ? (o/n) \n");
    fflush(stdin);
    scanf("%c",&choice);

  }

  return 0;
}
