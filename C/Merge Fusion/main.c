#include <stdlib.h>
#include <stdio.h>
#include <stdint.h>
#include <dirent.h>
#include <string.h>

#include "includes/system.h"

#define DIR_SIZE 256

int main(int argc, char const *argv[]) {

  int16_t nbSQLFiles = 3;
  // FILE ** sqlFiles = malloc(nbSQLFiles * sizeof(FILE));
  char ** nameSQLFiles;
  DIR * rep = opendir(".");
  struct dirent * currentFile;
  int16_t counter = 0;

  checkDepository(rep);

  while ((currentFile = readdir(rep)) != NULL)
    counter++;
  closedir(rep);

  nameSQLFiles = malloc(counter * sizeof(char *));
  for(int16_t i = 0; i < counter; i++)
    nameSQLFiles[i] = malloc(DIR_SIZE * sizeof(char));

  rep = opendir(".");
  checkDepository(rep);

  for(int16_t k = 0; k < counter; k++){

    currentFile = readdir(rep);
    strcpy(nameSQLFiles[k], currentFile->d_name);

  }
  closedir(rep);
  freeStringArray(&nameSQLFiles, counter);

  return 0;
}
