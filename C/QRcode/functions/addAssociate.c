
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
    fp = fopen("associate.temp", "w+");
    fprintf(fp, "lastName:%s\nfirstName:%s\nemail:%s\nphoneNumber%s\naddress:%s\ntown:%s\nsirenNumber:%d\ncompanyName:%s\nidentifier:%s\n", associate->lastName, associate->firstName, associate->email, associate->phoneNumber, associate->address, associate->town, associate->sirenNumber, associate->companyName, identifier);
    fclose(fp);
}