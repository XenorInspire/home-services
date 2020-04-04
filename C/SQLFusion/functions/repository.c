#include <dirent.h>
#include <stdint.h>
#include <stdlib.h>
#include <stdio.h>
#include <string.h>

#include "../includes/struct.h"
#include "../includes/repository.h"
#include "../includes/system.h"
#include "../includes/sqlmanage.h"

#define PATH "SQLFiles/"
#define DIR_SIZE 256

// Find SQL files en the depository
int8_t findSQLFiles(DIR_INFO * SQLDirectory){

    cntFiles(SQLDirectory);
    if(SQLDirectory->nbSQLFiles == 0) return -1;

    struct dirent * currentFile;
    int16_t k = 0;
    SQLDirectory->nameSQLFiles = malloc(SQLDirectory->nbSQLFiles * sizeof(char*));
    checkDoublePtr(SQLDirectory->nameSQLFiles);

    for(int16_t i = 0; i < SQLDirectory->nbSQLFiles; i++){

        SQLDirectory->nameSQLFiles[i] = malloc(DIR_SIZE * sizeof(char));
        checkSimplePtr(SQLDirectory->nameSQLFiles[i]);

    }

    SQLDirectory->rep = opendir(PATH);
    checkDepository(SQLDirectory->rep);
    
    while ((currentFile = readdir(SQLDirectory->rep)) != NULL){

        if(strstr(currentFile->d_name, ".sql") != NULL){

            strcpy(SQLDirectory->nameSQLFiles[k], PATH);
            strcat(SQLDirectory->nameSQLFiles[k], currentFile->d_name);
            k++;

        }
    
    }

    closedir(SQLDirectory->rep);
    allocateNbLines(SQLDirectory);
    return 0;

}

// Count the SQL entries in a depository
void cntFiles(DIR_INFO * SQLDirectory){

    SQLDirectory->rep = opendir(PATH);
    checkDepository(SQLDirectory->rep);

    struct dirent * currentFile;
    int16_t counterSQL = 0;
    int16_t counter = 0;

    while ((currentFile = readdir(SQLDirectory->rep)) != NULL){

        if(strstr(currentFile->d_name, ".sql") != NULL)
            counterSQL++;

        counter++;
        
    }
    
    SQLDirectory->nbFiles = counter;
    SQLDirectory->nbSQLFiles = counterSQL;

    closedir(SQLDirectory->rep);

}

// Count lines in all SQL files of the depository
void allocateNbLines(DIR_INFO * SQLDirectory){

    
    SQLDirectory->totalNbLinesSQL = 0;
    SQLDirectory->nbLinesSQL = malloc(SQLDirectory->nbSQLFiles * sizeof(int32_t));
    
    checkSimpleIntPtr(SQLDirectory->nbLinesSQL);

    for (int16_t i = 0; i < SQLDirectory->nbSQLFiles; i++){

        SQLDirectory->nbLinesSQL[i] = nbLines(SQLDirectory->nameSQLFiles[i]);
        SQLDirectory->totalNbLinesSQL += SQLDirectory->nbLinesSQL[i];

    }

}