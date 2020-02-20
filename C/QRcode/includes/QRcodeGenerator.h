/**
 * @file QRcodeGenerator.h
 */

/**
 * @brief generate the complete QRcode and save it in PDF format
 * @param inputString string to encode into the Qrcode
 * @param lastName of the associate dor the pdf naming
 * @param firstName of the associate dor the pdf naming
 * 
*/
void generateQRcode(const char *inputString, const char *lastName, const char *firstName);

    /**
 * @brief draw QRcode in PDF file
 * @param data QRcode encoded content
 * @param width of the QRcode
 * @param pdfName the pdf name to save 
*/
    void generateQRcodeToPDF(const unsigned char *data, int width, const char *pdfName);