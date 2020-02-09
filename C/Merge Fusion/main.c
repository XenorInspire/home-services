#include <stdlib.h>
#include <stdio.h>
#include <stdint.h>
#include <dirent.h>
#include <string.h>

#define LENGTH(X) sizeof(X) / sizeof(char *)

int main(int argc, char const *argv[]) {

  int16_t nbSQLFiles = 3;
  // FILE ** sqlFiles = malloc(nbSQLFiles * sizeof(FILE));
  char ** nameSQLFiles;
  DIR * rep = opendir(".");
  struct dirent * currentFile;
  int16_t counter = 0;

  if(rep == NULL)
    exit(0);

  while ((currentFile = readdir(rep)) != NULL)
    counter++;
  closedir(rep);

  nameSQLFiles = malloc(counter * sizeof(char *));
  for(int16_t i = 0; i < counter; i++)
    nameSQLFiles[i] = malloc(256 * sizeof(char));

  rep = opendir(".");
  if(rep == NULL)
    exit(0);

  for(int16_t k = 0; k < counter; k++){

    currentFile = readdir(rep);
    strcpy(nameSQLFiles[k], currentFile->d_name);

  }
  closedir(rep);


  for(int16_t j = 0; j < counter; j++){

    printf("%s\n",nameSQLFiles[j]);
    free(nameSQLFiles[j]);

  }


  free(nameSQLFiles);

  return 0;
}
