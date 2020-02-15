#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <dirent.h>
#include <string.h>

#include "../includes/struct.h"
#include "../includes/sqlmanage.h"
#include "../includes/system.h"

#define SIZE_LINE 256

// This function is charged to organize the saving of the final SQL file
void extractData(DIR_INFO * SQLDirectory, char * fileName){

  strcpy(fileName,verifyExtension(fileName));

  FILE ** sqlFiles = malloc(SQLDirectory->nbSQLFiles * sizeof(FILE));
  if(sqlFiles == NULL){

    printf("Vous ne disposez pas d'assez de m%cmoire disponible \n",130);
    SLEEP(3000);
    exit(0);

  }

  int32_t indexBuffer = 0;
  char ** buffer;
  char * temp = malloc(SIZE_LINE * sizeof(char *));
  checkSimplePtr(temp);

  FILE * SQLResult = fopen(fileName,"wb");
  checkFile(SQLResult);

  for(int16_t k = 0; k < SQLDirectory->nbSQLFiles; k++){

    sqlFiles[k] = fopen(SQLDirectory->nameSQLFiles[k],"rb");
    int32_t nbLinesSQL = nbLines(SQLDirectory->nameSQLFiles[k]);
    buffer = malloc(nbLinesSQL * sizeof(char *));

    for(int16_t j = 0; j < nbLinesSQL; j++){

      buffer[j] = malloc(SIZE_LINE * sizeof(char));
      checkSimplePtr(buffer[j]);

    }

    while(fgets(temp, SIZE_LINE - 1, sqlFiles[k]) != NULL){

      if(strstr(temp,"INSERT INTO") != NULL)
        strcpy(buffer[indexBuffer], temp);
      
      indexBuffer++;

    }
    
    fclose(sqlFiles[k]);
    writeSQL(SQLResult, buffer, indexBuffer - 1);
    indexBuffer = 0;
    //fonction qui écrit dans le fichier SQL final
    freeStringArray(buffer,nbLinesSQL);

  }

  fclose(SQLResult);

}

// Count the lines of SQL files
int32_t nbLines(const char * fileName){

  int32_t numberOfLines = 0;
  FILE * fileSQL = fopen(fileName, "r");
  int8_t character;

  while((character = fgetc(fileSQL)) != EOF)
  {

  	if(character == '\n')
  		numberOfLines++;
  }

  fclose(fileSQL);
  return numberOfLines;

}

// Check if the filename has only one extension
char * verifyExtension(char * fileName){

  if(strstr(fileName,".sql") == NULL){
    
    strcat(fileName, ".sql");
    return fileName;

  }

  int8_t counter = 0;
  char * ptr = fileName;

  while((ptr = strstr(ptr,".sql")) != NULL){

    counter++;
    if(counter > 1){

      strcpy(ptr,ptr + strlen(".sql"));

    }else{

      ptr++;

    }

  }
    
  return fileName;
   
}

// Write data in the final SQL file
void writeSQL(FILE * SQLResult, char ** buffer, int32_t size){

  fseek(SQLResult, 0, SEEK_END);
  for(int32_t i = 0; i < size; i++)
    fprintf(SQLResult,"%s",buffer[i]);

}