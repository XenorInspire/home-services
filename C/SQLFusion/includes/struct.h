typedef struct DIR_INFO {

    char ** nameSQLFiles;
    int16_t nbSQLFiles;
    int16_t nbFiles;
    int32_t * nbLinesSQL;
    int32_t totalNbLinesSQL;
    DIR * rep;

} DIR_INFO;