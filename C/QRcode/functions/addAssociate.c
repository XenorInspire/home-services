
#include "../includes/struct.h"
#include "../includes/addAssociate.h"
#include<gtk/gtk.h>
#include<stdio.h>
#include<string.h>

void identifierGenerator(ASSOCIATE * associate, char * identifier){
    char firstName[255] = " ";
    char lastName[255] = " ";
    int sirenNumber;

    strncpy(firstName,associate->firstName,1);
    strncpy(lastName, associate->lastName,1);
    sirenNumber = associate->sirenNumber % 10000;
    sprintf(identifier,"HM-%d-%s%s",sirenNumber,firstName,lastName);
}