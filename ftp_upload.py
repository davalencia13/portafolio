#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Script para subir archivos por FTP al servidor
Autor: Sistema de Dashboard
Fecha: 2024
"""

import ftplib
import os
import sys
from pathlib import Path
import time

# Configuración FTP
FTP_CONFIG = {
    "name": "portafoliobasico",
    "host": "15.235.119.22",
    "protocol": "ftp",
    "port": 21,
    "username": "portafo4",
    "password": "@q5S9jv;zS1LW7",
    "remotePath": "/public_html/",
    "uploadOnSave": True
}

class FTPUploader:
    def __init__(self, config):
        self.config = config
        self.ftp = None
        self.uploaded_files = []
        self.failed_files = []
        
    def connect(self):
        """Conectar al servidor FTP"""
        try:
            print(f"🔄 Conectando a {self.config['host']}:{self.config['port']}...")
            self.ftp = ftplib.FTP()
            self.ftp.connect(self.config['host'], self.config['port'])
            self.ftp.login(self.config['username'], self.config['password'])
            print(f"✅ Conexión exitosa como {self.config['username']}")
            return True
        except Exception as e:
            print(f"❌ Error al conectar: {str(e)}")
            return False
    
    def disconnect(self):
        """Desconectar del servidor FTP"""
        if self.ftp:
            self.ftp.quit()
            print("🔌 Desconectado del servidor FTP")
    
    def create_remote_directories(self, local_path, remote_base_path):
        """Crear directorios remotos si no existen"""
        try:
            # Obtener la ruta relativa desde el directorio actual
            current_dir = Path.cwd()
            relative_path = Path(local_path).relative_to(current_dir)
            
            # Crear la estructura de directorios en el servidor
            path_parts = relative_path.parts
            current_remote_path = remote_base_path.rstrip('/')
            
            for part in path_parts[:-1]:  # Excluir el archivo
                current_remote_path += '/' + part
                try:
                    self.ftp.mkd(current_remote_path)
                    print(f"📁 Directorio creado: {current_remote_path}")
                except ftplib.error_perm as e:
                    if "550" in str(e):  # Directorio ya existe
                        pass
                    else:
                        print(f"⚠️  Error al crear directorio {current_remote_path}: {e}")
        except Exception as e:
            print(f"⚠️  Error al crear directorios: {e}")
    
    def upload_file(self, local_file, remote_path):
        """Subir un archivo específico"""
        try:
            # Crear directorios remotos si es necesario
            self.create_remote_directories(local_file, remote_path)
            
            # Construir la ruta remota completa
            current_dir = Path.cwd()
            relative_path = Path(local_file).relative_to(current_dir)
            full_remote_path = remote_path.rstrip('/') + '/' + str(relative_path)
            
            # Cambiar al directorio remoto
            remote_dir = os.path.dirname(full_remote_path)
            if remote_dir != remote_path.rstrip('/'):
                try:
                    self.ftp.cwd(remote_dir)
                except:
                    pass
            
            # Subir el archivo
            filename = os.path.basename(local_file)
            with open(local_file, 'rb') as file:
                self.ftp.storbinary(f'STOR {filename}', file)
            
            print(f"✅ Subido: {local_file} -> {full_remote_path}")
            self.uploaded_files.append(local_file)
            return True
            
        except Exception as e:
            print(f"❌ Error al subir {local_file}: {str(e)}")
            self.failed_files.append((local_file, str(e)))
            return False
    
    def upload_directory(self, local_dir=".", exclude_patterns=None):
        """Subir un directorio completo"""
        if exclude_patterns is None:
            exclude_patterns = [
                '__pycache__', '.git', '.vscode', 'node_modules',
                '.DS_Store', 'Thumbs.db', '*.log', '*.tmp'
            ]
        
        print(f"📁 Iniciando subida del directorio: {local_dir}")
        print(f"🎯 Ruta remota: {self.config['remotePath']}")
        
        # Conectar al FTP
        if not self.connect():
            return False
        
        try:
            # Cambiar al directorio remoto base
            self.ftp.cwd(self.config['remotePath'])
            
            # Recorrer todos los archivos
            for root, dirs, files in os.walk(local_dir):
                # Filtrar directorios excluidos
                dirs[:] = [d for d in dirs if not any(pattern in d for pattern in exclude_patterns)]
                
                for file in files:
                    # Verificar si el archivo debe ser excluido
                    if any(pattern in file for pattern in exclude_patterns):
                        continue
                    
                    local_file = os.path.join(root, file)
                    self.upload_file(local_file, self.config['remotePath'])
            
            # Mostrar resumen
            self.show_summary()
            
        except Exception as e:
            print(f"❌ Error durante la subida: {str(e)}")
            return False
        finally:
            self.disconnect()
        
        return True
    
    def upload_specific_files(self, file_list):
        """Subir archivos específicos"""
        print(f"📁 Iniciando subida de {len(file_list)} archivos específicos")
        
        if not self.connect():
            return False
        
        try:
            # Cambiar al directorio remoto base
            self.ftp.cwd(self.config['remotePath'])
            
            for file_path in file_list:
                if os.path.exists(file_path):
                    self.upload_file(file_path, self.config['remotePath'])
                else:
                    print(f"⚠️  Archivo no encontrado: {file_path}")
                    self.failed_files.append((file_path, "Archivo no encontrado"))
            
            # Mostrar resumen
            self.show_summary()
            
        except Exception as e:
            print(f"❌ Error durante la subida: {str(e)}")
            return False
        finally:
            self.disconnect()
        
        return True
    
    def show_summary(self):
        """Mostrar resumen de la subida"""
        print("\n" + "="*50)
        print("📊 RESUMEN DE LA SUBIDA")
        print("="*50)
        print(f"✅ Archivos subidos exitosamente: {len(self.uploaded_files)}")
        print(f"❌ Archivos con errores: {len(self.failed_files)}")
        
        if self.uploaded_files:
            print("\n📋 Archivos subidos:")
            for file in self.uploaded_files:
                print(f"   ✅ {file}")
        
        if self.failed_files:
            print("\n❌ Archivos con errores:")
            for file, error in self.failed_files:
                print(f"   ❌ {file}: {error}")
        
        print("="*50)

def main():
    """Función principal"""
    print("🚀 SCRIPT DE SUBIDA FTP - PORTAFOLIO BÁSICO")
    print("="*50)
    
    # Crear instancia del uploader
    uploader = FTPUploader(FTP_CONFIG)
    
    # Verificar argumentos de línea de comandos
    if len(sys.argv) > 1:
        if sys.argv[1] == "--files":
            # Subir archivos específicos
            files = sys.argv[2:]
            if files:
                uploader.upload_specific_files(files)
            else:
                print("❌ Debes especificar archivos para subir")
                print("Uso: python ftp_upload.py --files archivo1.php archivo2.php")
        elif sys.argv[1] == "--dashboard":
            # Subir solo archivos del dashboard
            dashboard_files = [
                "application/controllers/Dashboard.php",
                "application/views/header.php",
                "application/views/footer.php",
                "application/views/dashboard.php",
                "application/config/routes.php"
            ]
            uploader.upload_specific_files(dashboard_files)
        elif sys.argv[1] == "--help":
            show_help()
        else:
            print("❌ Opción no válida. Usa --help para ver las opciones disponibles.")
    else:
        # Subir todo el directorio
        print("📁 Subiendo todo el directorio actual...")
        uploader.upload_directory()

def show_help():
    """Mostrar ayuda"""
    print("""
📖 AYUDA - SCRIPT DE SUBIDA FTP

Uso:
    python ftp_upload.py                    # Subir todo el directorio
    python ftp_upload.py --dashboard        # Subir solo archivos del dashboard
    python ftp_upload.py --files arch1 arch2 # Subir archivos específicos
    python ftp_upload.py --help             # Mostrar esta ayuda

Opciones:
    --dashboard    Sube solo los archivos del dashboard
    --files        Sube archivos específicos (lista de archivos)
    --help         Muestra esta ayuda

Ejemplos:
    python ftp_upload.py --dashboard
    python ftp_upload.py --files index.php application/config/config.php
    python ftp_upload.py
    """)

if __name__ == "__main__":
    main() 