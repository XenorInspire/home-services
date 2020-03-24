#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <dirent.h>
#include <string.h>

#include "../includes/mysql.h"

void SQLExec(char ** backup, int32_t nbLines) {

  MYSQL *con = mysql_init(NULL);

  char errors[nbLines][200];

  char login[255];
  char password[255];
  char server[255];
  char database[255];
  int port;
  int i;

  if (con == NULL) {
    // fprintf(stderr, "%s\n", mysql_error(con));
    exit(1);
  }

  strcpy(login, "root");
  strcpy(password, "root");
  strcpy(server, "localhost");
  strcpy(database, "home-services");
  port = 3306;

  if (mysql_real_connect(con, server, login, password, database, port, NULL, 0) == NULL) {
    mysql_close(con);
    exit(1);
  }

  for (i = 0; i < nbLines; i++) {
    if (mysql_query(con, backup[i])) strcpy(errors[i], mysql_error(con));
    else errors[i][0] = '\0';
  }

  for (i = 0; i < nbLines; i++) {
    printf("%s\n\n", errors[i]);
  }

  mysql_close(con);
}
