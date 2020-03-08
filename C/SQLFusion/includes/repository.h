// All these functions are related to the SQL directory

// Find SQL files en the depository
int8_t findSQLFiles(DIR_INFO * SQLDirectory);

// Count the entries in a directory
void cntFiles(DIR_INFO * SQLDirectory);

// Count lines in all SQL files of the depository
void allocateNbLines(DIR_INFO * SQLDirectory);