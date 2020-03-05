/**
 * @brief genereate an identifier for the QRcode Format : HM-4lastSirenNumber-AssociateInitial
 * @param associate Struct ASSOCIATE 
 * @param identifier String where to write the identifier of the asscociate
*/
void identifierGenerator(ASSOCIATE *associate, char *identifier);

/**
 * @brief Give all the data to insert the associate 
 * @param associate Struct ASSOCIATE 
 * @param identifier String where to write the identifier of the asscociate
*/
void writeAssociate(ASSOCIATE *associate, const char *identifier);

/**
 * @brief Encrypt the sring containning alll data of the associate
 * @param string data of the associate 
*/
void encryptString(char *string);
