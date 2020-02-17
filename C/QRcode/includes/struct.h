#include<gtk/gtk.h>

typedef struct associate
{
    int idAssociate;
    char lastName[255];
    char firstName[255];
    char email[255];
    char phoneNumber[255];
    char address[255];
    char town[255];
    int sirenNumber;
    char companyName[255];
} ASSOCIATE;

typedef struct
{
    GtkBuilder *builder;
    gpointer userData;
} GLOBALDATA;