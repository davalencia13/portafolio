@echo off
chcp 65001 >nul
echo 🚀 SUBIENDO TODO EL PROYECTO AL SERVIDOR
echo ================================================

REM Crear archivo de comandos FTP
echo open 15.235.119.22 > ftp_all_project.txt
echo portafo4 >> ftp_all_project.txt
echo @q5S9jv;zS1LW7 >> ftp_all_project.txt
echo cd public_html >> ftp_all_project.txt
echo binary >> ftp_all_project.txt

REM Archivos principales
echo put index.php >> ftp_all_project.txt
echo put .htaccess >> ftp_all_project.txt

REM Controladores
echo put application/controllers/Dashboard.php >> ftp_all_project.txt
echo put application/controllers/Login.php >> ftp_all_project.txt
echo put application/controllers/C_Autentication.php >> ftp_all_project.txt
echo put application/controllers/C_Welcome.php >> ftp_all_project.txt
echo put application/controllers/Producto.php >> ftp_all_project.txt

REM Vistas
echo put application/views/header.php >> ftp_all_project.txt
echo put application/views/footer.php >> ftp_all_project.txt
echo put application/views/dashboard.php >> ftp_all_project.txt
echo put application/views/view_login.php >> ftp_all_project.txt
echo put application/views/view_register.php >> ftp_all_project.txt
echo put application/views/view_landing.php >> ftp_all_project.txt
echo put application/views/view_producto.php >> ftp_all_project.txt
echo put application/views/welcome_message.php >> ftp_all_project.txt

REM Modelos
echo put application/models/Model_User.php >> ftp_all_project.txt
echo put application/models/Model_Loginuser.php >> ftp_all_project.txt
echo put application/models/M_Login.php >> ftp_all_project.txt

REM Configuración
echo put application/config/routes.php >> ftp_all_project.txt
echo put application/config/config.php >> ftp_all_project.txt
echo put application/config/database.php >> ftp_all_project.txt
echo put application/config/autoload.php >> ftp_all_project.txt
echo put application/config/constants.php >> ftp_all_project.txt

REM Archivos del proyecto
echo put composer.json >> ftp_all_project.txt
echo put readme.rst >> ftp_all_project.txt
echo put license.txt >> ftp_all_project.txt

echo bye >> ftp_all_project.txt

REM Ejecutar FTP
echo 🔄 Ejecutando subida FTP...
ftp -s:ftp_all_project.txt

echo.
echo ✅ Proceso completado!
echo 📁 Todos los archivos del proyecto han sido subidos
pause 