#include <stdlib.h>
#include <stdio.h>
#include <stdint.h>
#include <dirent.h>
#include <string.h>

#include "includes/struct.h"
#include "includes/system.h"
#include "includes/repository.h"
#include "includes/sqlmanage.h"

#define SIZE_FILE_NAME 256

int main(int argc, char const *argv[]) {

  DIR_INFO SQLDirectory;
  if(findSQLFiles(&SQLDirectory) != 0){

    printf("Aucune entr%ce SQL d%ct%cct%ce \n",130,130,130,130);
    exit(0);

  }

  char ** backup;
  char * fileName = malloc(SIZE_FILE_NAME * sizeof(char));
  checkSimplePtr(fileName);

  printf("Nom du fichier : \n");
  fflush(stdin);
  fgets(fileName,SIZE_FILE_NAME,stdin);

  if(fileName[strlen(fileName) - 1] == '\n')
    fileName[strlen(fileName) - 1] = '\0';

  backup = extractData(&SQLDirectory, fileName);
  
  free(fileName);
  free(SQLDirectory.nbLinesSQL);
  freeStringArray(SQLDirectory.nameSQLFiles, SQLDirectory.nbSQLFiles);
  freeStringArray(backup, SQLDirectory.totalNbLinesSQL);
  return 0;

}
