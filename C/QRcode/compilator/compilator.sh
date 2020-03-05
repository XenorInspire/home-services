
# cd .. && C:\\msys64\\mingw64.exe gcc -c `pkg-config --cflags gtk+-3.0` ../functions/*.c `pkg-config --libs gtk+-3.0`
# C:\\msys64\\mingw64.exe gcc mainSql.c -o SqlManage.exe lib\\libmysql.lib
# C:\\msys64\\mingw64.exe gcc pdfgen.o QR_Encode.o QRcodeGenerator.o mainQRcode.c -o QRcode.exe
# C:\\msys64\\mingw64.exe gcc `pkg-config --cflags gtk+-3.0` pdfgen.o QR_Encode.o QRcodeGenerator.o gui.o addAssociate.o logo.o main.c -o QRcodeGenerator.exe `pkg-config --libs gtk+-3.0`
    

C:\\msys64\\mingw64.exe gcc -c `pkg-config --cflags gtk+-3.0` test.c -o test.exe `pkg-config --libs gtk+-3.0`