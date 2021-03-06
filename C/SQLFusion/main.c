#include <stdlib.h>
#include <stdio.h>
#include <windows.h>
#include <stdint.h>
#include <dirent.h>
#include <string.h>

#include "includes/struct.h"
#include "includes/system.h"
#include "includes/repository.h"
#include "includes/sqlmanage.h"
#include "includes/sqlrequest.h"

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

  // Store the entire sql entries
  backup = extractData(&SQLDirectory, fileName);

  SQLExec(backup, SQLDirectory.totalNbLinesSQL);

  free(fileName);
  free(SQLDirectory.nbLinesSQL);
  freeStringArray(SQLDirectory.nameSQLFiles, SQLDirectory.nbSQLFiles);
  freeStringArray(backup, SQLDirectory.totalNbLinesSQL);

  printf("Le programme s'est execut%c sans erreur !", 130);
  Sleep(5000);
  return 0;

}
