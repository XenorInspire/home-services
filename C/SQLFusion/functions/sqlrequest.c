#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <dirent.h>
#include <string.h>

#include "../includes/mysql.h"
#include "../includes/sqlrequest.h"

void SQLExec(char ** backup, int32_t nbLines) {

  MYSQL *con = mysql_init(NULL);
  MYSQL_RES *result;
  MYSQL_ROW row;
  int num_fields;

  char errors[nbLines][200];
  char* select = malloc(sizeof(char) * 255);
  char* update = malloc(sizeof(char) * 1000);
  char id[11] = "";
  char** infoReq;

  char login[255];
  char password[255];
  char server[255];
  char database[255];
  int port;
  int i;
  int j;
  int k;
  int r;

  if (con == NULL) {
    // fprintf(stderr, "%s\n", mysql_error(con));
    exit(1);
  }

  strcpy(login, "root");
  strcpy(password, "stevendatabase8");
  strcpy(server, "localhost");
  strcpy(database, "home-services");
  port = 3306;

// Try connection with database
  if (mysql_real_connect(con, server, login, password, database, port, NULL, 0) == NULL) {
    mysql_close(con);
    exit(1);
  }

// Send requests and get errors
  // for (i = 0; i < nbLines; i++) {
  //   if (mysql_query(con, backup[i])) strcpy(errors[i], mysql_error(con));
  //   else errors[i][0] = '\0';
  // }

// If there are errors
  // for (i = 0; i < nbLines; i++) {
  //   if (strstr(errors[i], "duplicate") != NULL) {
  //     printf("%s\n\n", backup[i]);
  //   }
  // }

  // strcpy(select, "SELECT * FROM Associate WHERE associateId='");
  // printf("%s", select);
  // strncpy(id, (*(backup) + 31), 10);
  // id[11] = '\0';
  // strcat(select, id);
  // strcat(select, "';");
  //
  // if (mysql_query(con, select)) {
  //     printf("%s", mysql_error(con));
  // }
  //
  //  result = mysql_store_result(con);
  //
  // int num_fields = mysql_num_fields(result);
  //
  // while (row = mysql_fetch_row(result)) {
  //   for(i = 0; i < num_fields; i++)
  //   {
  //       printf("%s ", row[i] ? row[i] : "NULL");
  //   }
  //       printf("\n");
  // }

  update[0] = '\0';
  for (i = 0; i < nbLines; i++) {

    strcpy(select, "SELECT * FROM Associate WHERE associateId='");
    strncpy(id, (backup[i] + 31), 10);
    id[11] = '\0';
    strcat(select, id);
    strcat(select, "';");

    if (mysql_query(con, select)) {
        printf("%s\n", mysql_error(con));
    }

    result = mysql_store_result(con);

    num_fields = mysql_num_fields(result);
    infoReq = parse(backup[i]);

    while (row = mysql_fetch_row(result)) {
      for (j = 0; j < num_fields; j++) {
        if (strcmp(infoReq[j], row[j]) != 0) {
          printf("1 . Anciennes informations :\n");
          for (k = 0; k < num_fields; k++)
            printf("%s ", row[k]);
          printf("\n2 . Nouvelles informations :\n");
          for (k = 0; k < num_fields; k++)
            printf("%s ", infoReq[k]);
          printf("\nQuelles informations souhaitez-vous conserver ?\n");
          do {
            fflush(stdin);
            scanf("%d", &r);
          } while(r != 1 && r != 2);

          strcpy(update, "UPDATE Associate SET lastName=\"");

          if (r == 2) {
            strcat(update, infoReq[1]);
            strcat(update, "\",firstName=\"");
            strcat(update, infoReq[2]);
            strcat(update, "\",email=\"");
            strcat(update, infoReq[3]);
            strcat(update, "\",phoneNumber=\"");
            strcat(update, infoReq[4]);
            strcat(update, "\",address=\"");
            strcat(update, infoReq[5]);
            strcat(update, "\",town=\"");
            strcat(update, infoReq[6]);
            strcat(update, "\",sirenNumber=\"");
            strcat(update, infoReq[7]);
            strcat(update, "\",companyName=\"");
            strcat(update, infoReq[8]);
            strcat(update, "\",password=\"");
            strcat(update, infoReq[9]);
            strcat(update, "\",enable=");
            strcat(update, infoReq[10]);
          }

          if (r == 1) {
            strcat(update, row[1]);
            strcat(update, "\",firstName=\"");
            strcat(update, row[2]);
            strcat(update, "\",email=\"");
            strcat(update, row[3]);
            strcat(update, "\",phoneNumber=\"");
            strcat(update, row[4]);
            strcat(update, "\",address=\"");
            strcat(update, row[5]);
            strcat(update, "\",town=\"");
            strcat(update, row[6]);
            strcat(update, "\",sirenNumber=\"");
            strcat(update, row[7]);
            strcat(update, "\",companyName=\"");
            strcat(update, row[8]);
            strcat(update, "\",password=\"");
            strcat(update, row[9]);
            strcat(update, "\",enable=");
            strcat(update, row[10]);
          }

          strcat(update, " WHERE associateId=\"");
          strcat(update, id);
          strcat(update, "\";");

          printf("%s\n", update);

          if (mysql_query(con, update)) {
              printf("%s\n", mysql_error(con));
          } else printf("OK !\n");
        }
      }
    }
  }



  mysql_free_result(result);
  mysql_close(con);
}

char** parse(char* query) {
  char** result;
  char* ptr1;
  char* ptr2;
  int i;

  result = malloc(sizeof(char*) * 11);

  for(i = 0; i < 11; i++) {
    result[i] = malloc(sizeof(char) * 250);
  }

  ptr1 = strchr(query, '"') + 1;
  ptr2 = strchr(ptr1, '"');

  strncpy(result[0], ptr1, ptr2 - ptr1);
  result[0][ptr2 - ptr1] = '\0';

  for(i = 1; i < 10; i++) {
    ptr1 = strchr(ptr2 + 1, '"') + 1;
    ptr2 = strchr(ptr1, '"');

    strncpy(result[i], ptr1, ptr2 - ptr1);
    result[i][ptr2 - ptr1] = '\0';
  }

  ptr1 = strpbrk(ptr2, "01");
  strncpy(result[10], ptr1, 1);
  result[10][1] = '\0';

  return result;
}
