
#include "../includes/struct.h"
#include "../includes/addAssociate.h"
#include <gtk/gtk.h>
#include <stdio.h>
#include <string.h>

void identifierGenerator(ASSOCIATE *associate, char *identifier)
{
    char firstName[255] = " ";
    char lastName[255] = " ";
    int sirenNumber;

    strncpy(firstName, associate->firstName, 1);
    strncpy(lastName, associate->lastName, 1);
    sirenNumber = associate->sirenNumber % 10000;
    sprintf(identifier, "HM-%d-%s%s", sirenNumber, firstName, lastName);
}

void writeAssociate(ASSOCIATE *associate, const char *identifier)
{
    FILE *fp;
    char string[2500];
    fp = fopen("mysql/associate.temp", "w+");
    
    sprintf(string, "%s:%s:%s:%s:%s:%s:%d:%s:%s:%d:", associate->lastName, associate->firstName, associate->email, associate->phoneNumber, associate->address, associate->town, associate->sirenNumber, associate->companyName, identifier, 0);

    encryptString(string);

    fprintf(fp,"%s",string);

    fclose(fp);
}

void encryptString(char *string)
{
    int i;
    const int increment = 100;
    for (i = 0; i < strlen(string); i++)
    {
        string[i] = string[i] + increment;
    }
}