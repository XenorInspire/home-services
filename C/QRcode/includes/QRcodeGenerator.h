/**
 * @file QRcodeGenerator.h
 */

/**
 * @brief generate the complete QRcode and save it in PDF format
 * @param inputString string to encode into the Qrcode
*/
void generateQRcode(const char *inputString);

/**
 * @brief draw QRcode in PDF file
 * @param data QRcode encoded content
 * @param width of the QRcode
*/
void generateQRcodeToPDF(const unsigned char *data, int width);