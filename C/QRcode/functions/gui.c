
#include <gtk/gtk.h>
#include <stdio.h>
#include <stdlib.h>

G_MODULE_EXPORT void on_windowMain_destroy(){
    gtk_main_quit();
}

