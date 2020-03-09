#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <dirent.h>
#include <string.h>

#include "../includes/struct.h"
#include "../includes/sqlmanage.h"
#include "../includes/system.h"

#define SIZE_LINE 3000

// This function is charged to organize the saving of the final SQL file
char ** extractData(DIR_INFO * SQLDirectory, char * fileName){

  strcpy(fileName,verifyExtension(fileName));

  FILE ** sqlFiles = malloc(SQLDirectory->nbSQLFiles * sizeof(FILE));
  checkDoubleFilePtr(sqlFiles);

  int32_t indexBuffer = 0;
  int32_t indexBackup = 0;
  
  char ** buffer;
  char * temp = malloc(SIZE_LINE * sizeof(char));
  checkSimplePtr(temp);

  char ** backup;
  backup = malloc(SQLDirectory->totalNbLinesSQL * sizeof(char *));
  checkDoublePtr(backup);
  backup = initializer(backup,SQLDirectory->totalNbLinesSQL);

  FILE * SQLResult = fopen(fileName,"wb");
  checkFile(SQLResult);

  // For all the SQL files we have to merge
  for(int16_t k = 0; k < SQLDirectory->nbSQLFiles; k++){

    int32_t nbLinesSQL = SQLDirectory->nbLinesSQL[k];
    sqlFiles[k] = fopen(SQLDirectory->nameSQLFiles[k],"rb");
    buffer = malloc(nbLinesSQL * sizeof(char *));
    checkDoublePtr(buffer);
    buffer = initializer(buffer, nbLinesSQL);

    // Copy all the INSERT in a buffer
    while(fgets(temp, SIZE_LINE - 1, sqlFiles[k]) != NULL){

      if(strstr(temp,"INSERT INTO") != NULL || strstr(temp,"insert into") != NULL){

        strcpy(buffer[indexBuffer], temp);
        strcpy(backup[indexBackup], temp);
        indexBuffer++;
        indexBackup++;

      }

    }
    
    fclose(sqlFiles[k]);
    writeSQL(SQLResult, buffer, indexBuffer, SQLDirectory->nameSQLFiles[k]);
    
    SQLDirectory->nbLinesSQL[k] = indexBuffer;
    indexBuffer = 0;

    freeStringArray(buffer,nbLinesSQL);

  }

  fclose(SQLResult);
  SQLDirectory->totalNbLinesSQL = indexBackup;
  return backup;

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

// Check if the file name has only one SQL extension (or not)
char * verifyExtension(char * fileName){

  // If there isn't a .sql extension
  if(strstr(fileName,".sql") == NULL){
    
    strcat(fileName, ".sql");
    return fileName;

  }

  int8_t counter = 0;
  char * ptr = fileName;

  // If there are several .sql extension in the file name
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
void writeSQL(FILE * SQLResult, char ** buffer, int32_t size, char * fileName){

  fprintf(SQLResult,"%s %s\n","--",fileName);

  for(int32_t i = 0; i < size; i++)
    fprintf(SQLResult,"%s",buffer[i]);

  fprintf(SQLResult,"%s","\n");

}