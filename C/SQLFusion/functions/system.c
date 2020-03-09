#include <stdio.h>
#include <dirent.h>
#include <stdint.h>
#include "../includes/system.h"

#define SIZE_LINE 3000

// Check if the directory is usable
void checkDepository(DIR *rep)
{

  if (rep == NULL)
  {

    printf("Impossible d'acc%cder au r%cpertoire demand%c \n", 130, 130, 130);
    exit(0);
  }
}

// Check if a simple char pointer is NULL
void checkSimplePtr(char *ptr)
{

  if (ptr == NULL)
  {

    printf("Vous ne disposez pas d'assez de m%cmoire disponible, le programme va donc s'%cteindre \n", 130, 130);
    SLEEP(3000);
    exit(0);
  }
}

// Check if a double char pointer is NULL
void checkDoublePtr(char **ptr)
{

  if (ptr == NULL)
  {

    printf("Vous ne disposez pas d'assez de m%cmoire disponible, le programme va donc s'%cteindre \n", 130, 130);
    SLEEP(3000);
    exit(0);
  }
}

// Free an entire string array
void freeStringArray(char **ptr, int16_t size)
{

  for (int16_t j = 0; j < size; j++)
    free(ptr[j]);

  free(ptr);
}

// Check if a file * is NULL
void checkFile(FILE *SQLFile)
{

  if (SQLFile == NULL)
  {

    printf("Vous ne disposez pas d'assez de m%cmoire disponible, le programme va donc s'%cteindre \n", 130, 130);
    SLEEP(3000);
    exit(0);
  }
}

// Check if a double FILE pointer is NULL
void checkDoubleFilePtr(FILE **sqlFiles)
{

  if (sqlFiles == NULL)
  {

    printf("Vous ne disposez pas d'assez de m%cmoire disponible \n", 130);
    SLEEP(3000);
    exit(0);
  }
}

// Check if a simple integer pointer is NULL
void checkSimpleIntPtr(int32_t *ptr)
{

  if (ptr == NULL)
  {

    printf("Vous ne disposez pas d'assez de m%cmoire disponible \n", 130);
    SLEEP(3000);
    exit(0);
  }
}

// Allocate memory to the string array
char ** initializer(char ** buffer, int32_t size){

  for(int16_t j = 0; j < size; j++){

      buffer[j] = malloc(SIZE_LINE * sizeof(char));
      checkSimplePtr(buffer[j]);

    }

  return buffer;

}