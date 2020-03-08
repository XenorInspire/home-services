// All these functions are used to check everything is ok during the process

#ifdef _WIN32
  #include <windows.h>
  #define SLEEP(x) Sleep(x)
#else
  #include <unistd.h>
  #define SLEEP(x) sleep(x * 0.001)
#endif

// Check if the directory is usable
void checkDepository(DIR * rep);

// Check if a simple pointer is NULL
void checkSimplePtr(char * ptr);

// Check if a double pointer is NULL
void checkDoublePtr(char ** ptr);

// Free an entire string array
void freeStringArray(char ** ptr, int16_t size);

// Check if a file * is NULL
void checkFile(FILE * SQLFile);

// Check if a double FILE pointer is NULL
void checkDoubleFilePtr(FILE ** sqlFiles);

// Check if a simple integer pointer is NULL
void checkSimpleIntPtr(int32_t *ptr);