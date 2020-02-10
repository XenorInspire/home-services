#include <stdlib.h>
#include <stdio.h>
#include <stdint.h>
#include <dirent.h>
#include <string.h>

#include "includes/struct.h"
#include "includes/system.h"
#include "includes/repository.h"

int main(int argc, char const *argv[]) {

  DIR_INFO SQLDirectory;
  if(findSQLFiles(&SQLDirectory) != 0){

    printf("Aucune entr%ce SQL d%ct%cct%ce \n",130,130,130,130);
    exit(0);

  }

  // FILE ** sqlFiles = malloc(SQLDirectory.nbSQLFiles * sizeof(FILE));

  for(int16_t i = 0; i < SQLDirectory.nbSQLFiles; i++)
    printf("|%s| \n",SQLDirectory.nameSQLFiles[i]);

  freeStringArray(SQLDirectory.nameSQLFiles, SQLDirectory.nbSQLFiles);

  return 0;
}
