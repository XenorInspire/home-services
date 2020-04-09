#include <stdlib.h>
#include <stdio.h>
#include "./include/mysql.h"
#define FILENAME "associate.temp"

//#define INPUT_SIZE 3000

void decryptString(char* string);
void deleteTempFile(FILE* pf);

int main(int argc, char **argv) {
  // Initialization of a variable that will be used for the connection
  MYSQL *con = mysql_init(NULL);
  char password[255];
  char login[255];
  char server[255];
  char database[255];
  //char input[INPUT_SIZE];
  int port;
  FILE* pf = fopen(FILENAME, "r");
  char* string = malloc(sizeof(char) * 2500);
  char* stringPtr;
  char* stringPtr1;
  char request[3000];
  char value[100];
  int counter;



    // If the variable is NULL, the error is showed and the program stops
    if (con == NULL) {
      // fprintf(stderr, "%s\n", mysql_error(con));
      exit(1);
    }

      //printf("Login :");
      //fgets(login, 255, stdin);
      strcpy(login, "root");

      //printf("Password :");
      //fgets(password, 255, stdin);
      strcpy(password, "root");

      //printf("Server :");
      //fgets(server, 255, stdin);
      strcpy(server, "localhost");

      //printf("Database name :");
      //fgets(database, 255, stdin);
      strcpy(database, "home-services");

      //printf("Port :");
      //scanf("%d", &port);
      port = 3306;

    // The program tries to connect to the database, if it fails, the program stops after showing the error
    if (mysql_real_connect(con, server, login, password, database, port, NULL, 0) == NULL) {
      // fprintf(stderr, "%s\n", mysql_error(con));
      mysql_close(con);
      exit(1);
    }

    if (pf != NULL) {
      fread(string, 1, 2500, pf);
      decryptString(string);
      printf("%s", string);

    //fgets(input, INPUT_SIZE, stdin);
    //if (mysql_query(con, "INSERT INTO `user` VALUES ('steven');")) printf("%s\n", mysql_error(con));

    //if (mysql_query(con, "SELECT 'no' from `user`;")) printf("%s\n", mysql_error(con));

    strcpy(request, "INSERT INTO Associate(`lastName`, `firstName`, `email`, `phoneNumber`, `address`, `town`, `sirenNumber`, `companyName`, `AssociateId`, `enable`)");
    strcat(request, " VALUES ('");
    stringPtr = string;
    stringPtr = strchr(string, ':');
    strncpy(value, string, stringPtr - string);
    value[stringPtr - string] = '\0';
    strcat(request, value);
    strcat(request, "'");
    stringPtr++;

    for(counter = 0; counter < 9; counter++) {
      strcat(request, ",'");
      stringPtr1 = stringPtr;
      stringPtr = strchr(stringPtr, ':');
      strncpy(value, stringPtr1, stringPtr - stringPtr1);
      value[stringPtr - stringPtr1] = '\0';
      strcat(request, value);
      strcat(request, "'");
      stringPtr++;
    }
    strcat(request, ");");
    printf("\n%s\n", request);

    if (mysql_query(con, request)) printf("%s\n", mysql_error(con));

    mysql_close(con);
    deleteTempFile(pf);
    exit(0);
  }
}

void decryptString(char *string) {
    int i;
    const int decrement = 100;
    for (i = 0; i < strlen(string); i++) {
        string[i] = string[i] - decrement;
    }
}

void deleteTempFile(FILE *pf) {
  fclose(pf);
  remove(FILENAME);
}

// gcc -Wall -g -c .\test.c -o main.o
// gcc -o test.exe main.o lib\libmysql.lib

//gcc mainSql.c -o SqlManage.exe lib\libmysql.lib
