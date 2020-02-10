#include <stdio.h>
#include <dirent.h>
#include <stdint.h>
#include "../includes/system.h"

// Check if the directory is usable
void checkDepository(DIR * rep) {

  if(rep == NULL){

    printf("Impossible d'acc%cder au r%cpertoire demand%c \n",130,130,130);
    exit(0);

  }

}

// Check if a simple pointer is NULL
void checkSimplePtr(char * ptr){

  if(ptr == NULL){

    printf("Vous ne disposez pas d'assez de m%cmoire disponible, le programme va donc s'%cteindre \n",130,130);
    SLEEP(3000);
    exit(0);

  }

}

// Check if a double pointer is NULL
void checkDoublePtr(char ** ptr){

  if(ptr == NULL){

    printf("Vous ne disposez pas d'assez de m%cmoire disponible, le programme va donc s'%cteindre \n",130,130);
    SLEEP(3000);
    exit(0);

  }

}

// Free an entire string array
void freeStringArray(char ** ptr, int16_t size){

  for(int16_t j = 0; j < size; j++)
    free(ptr[j]);

  free(ptr);

}
