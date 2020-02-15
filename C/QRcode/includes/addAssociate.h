/**
 * @brief gnereate an identifier for the QRcode Format : HM-4lastSirenNumber-AssociateInitial
 * @param associate Struct ASSOCIATE 
 * @param identifier String where to write the identifier of the asscociate
*/
void identifierGnerator(ASSOCIATE *associate, char *identifier);

/**
 * @brief get the associate data (array) ans put in a struct ASSOCIATE
 * @param associate Struct ASSOCIATE 
 * @param associateData Data of the associate in an array
*/
int getAssociateData(ASSOCIATE *associate, char **associateData);