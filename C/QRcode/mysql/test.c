#include <stdlib.h>
#include <stdio.h>
//#include "./include/my_global.h"
#include "./include/mysql.h"
//#include <crtdbg.h>

#define INPUT_SIZE 3000

int main(int argc, char **argv) {
  // Initialization of a variable that will be used for the connection
  MYSQL *con = mysql_init(NULL);
  char password[255];
  char login[255];
  char server[255];
  char database[255];
  //char input[INPUT_SIZE];
  int port;

  // If the variable is NULL, the error is showed and the program stops
  if (con == NULL) {
      // fprintf(stderr, "%s\n", mysql_error(con));
      exit(1);
  }

    printf("Welcome to the MySQL C API !\n");
    //printf("Login :");
    //fgets(login, 255, stdin);
    strcpy(login, "root");

    //printf("Password :");
    //fgets(password, 255, stdin);
    strcpy(password, "stevendatabase8");

    //printf("Server :");
    //fgets(server, 255, stdin);
    strcpy(server, "localhost");

    //printf("Database name :");
    //fgets(database, 255, stdin);
    strcpy(database, "testdb");

    //printf("Port :");
    //scanf("%d", &port);
    port = 3306;

  // The program tries to connect to the database, if it fails, the program stops after showing the error
  if (mysql_real_connect(con, server, login, password, database, port, NULL, 0) == NULL) {
    // fprintf(stderr, "%s\n", mysql_error(con));
    mysql_close(con);
    exit(1);
  }

  //fgets(input, INPUT_SIZE, stdin);
  if (mysql_query(con, "INSERT INTO `user` VALUES ('steven');")) printf("%s\n", mysql_error(con));

  if (mysql_query(con, "SELECT 'no' from `user`;")) printf("%s\n", mysql_error(con));


  /*if (mysql_real_connect(con, server, login, password,
          NULL, port, NULL, 0) == NULL) {
      fprintf(stderr, "%s\n", mysql_error(con));
      mysql_close(con);
      exit(1);
  } else {
    printf("Connection done !\n");
  }*/



  mysql_close(con);
  exit(0);
}

// gcc -Wall -g -c .\test.c -o main.o
// gcc -o test.exe main.o lib\libmysql.lib
