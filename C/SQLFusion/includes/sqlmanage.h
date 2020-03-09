// All these functions are used to read SQL files and write the new one

// Count the lines of SQL files
int32_t nbLines(const char * fileName);

// This function is charged to read SQL files
char ** extractData(DIR_INFO * SQLDirectory, char * fileName);

// Check if the filename has only one extension
char * verifyExtension(char * fileName);

// Write data in the final SQL file
void writeSQL(FILE * SQLResult, char ** buffer, int32_t size, char * fileName);