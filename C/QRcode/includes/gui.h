
/**
 * @file gui.h
 * @brief For the GUI with GTK
 */

/**
 * @brief Called for closing the window with the "X" cross
*/
G_MODULE_EXPORT void on_windowMain_destroy();

/**
 * @brief Called when the user click on the button generate to insert associate's data and generate Qrcode 
*/
G_MODULE_EXPORT void on_generateButton_clicked(GtkWidget *widget, gpointer userData);
