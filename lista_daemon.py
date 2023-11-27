"""import requests
import datetime
import pymysql
from pytz import timezone
import time

# URL de la página que contiene la información del alumno y su matrícula
url_pagina_alumnos = "http://157.245.253.25/Alumnos/"  # Reemplaza con la URL real

# URL del script PHP
url_php_script = "http://157.245.253.25/lista.php"

# Parámetro para la solicitud POST (si es necesario)
parametros_post = {"uid": "valor_de_uid"}

# Convertir los datos a bytes
datos_bytes = {k: v.encode('utf-8') for k, v in parametros_post.items()}

# Tiempo de espera entre cada solicitud en segundos
tiempo_espera = 20  # por ejemplo, una solicitud cada minuto

# Configuración de la conexión a la base de datos
conexion = pymysql.connect(
    host="157.245.253.25",
    user="admin",
    password="3d54d0c824c2c3f7b4415dff96ed0fbeb752c151b68224dc",
    database="lista"
)

# Otorgar permisos en MySQL
try:
    conexion_grant = pymysql.connect(
        host="157.245.253.25",
        user="admin",
        password="3d54d0c824c2c3f7b4415dff96ed0fbeb752c151b68224dc",
        database="lista"  # Puede variar según la configuración de tu servidor MySQL
    )

    with conexion_grant.cursor() as cursor_grant:
        cursor_grant.execute("GRANT ALL PRIVILEGES ON *.* TO 'Admin2'@'fixed-187-189-136-98.totalplay.net' IDENTIFIED BY 'Pase_Asistencia' WITH GRANT OPTION;")
        cursor_grant.execute("FLUSH PRIVILEGES;")

except Exception as e:
    print(f"Error al otorgar permisos en MySQL: {e}")

finally:
    if 'conexion_grant' in locals():
        conexion_grant.close()


# Rangos de tiempo para la mañana
rangos_tiempo_manana = [
    {"inicio": "07:00:00", "fin": "07:55:00"},
    {"inicio": "07:55:00", "fin": "08:49:00"},
    {"inicio": "08:50:00", "fin": "09:44:00"},
    {"inicio": "09:45:00", "fin": "10:39:00"},
    {"inicio": "12:05:00", "fin": "12:59:00"}
]

# Días en los que se realizará la inasistencia
dias_inasistencia = ["Lun", "Mar", "Mié", "Jue", "Vie"]

def verificar_inasistencia():
    try:
        # Obtener la hora y el día actual en la zona horaria del servidor
        tz = timezone('America/Monterrey')
        ahora = datetime.datetime.now(tz)
        dia_actual = ahora.strftime("%a")
        hora_actual = ahora.strftime("%H:%M:%S")

        # Verificar si es un día de inasistencia y la hora actual está fuera de los rangos de la mañana
        if dia_actual in dias_inasistencia and all(not (rango["inicio"] <= hora_actual <= rango["fin"]) for rango in rangos_tiempo_manana):
            # Realizar una nueva solicitud para marcar a todos los alumnos como inasistentes
            nueva_solicitud = requests.post(url_php_script, data=datos_bytes)

            # Imprimir la respuesta de la nueva solicitud
            print(f"Inasistencia para todos los alumnos: {nueva_solicitud.text} el día: {dia_actual} a las {hora_actual}")

            # Actualizar la base de datos con inasistencias para todos los registros
            with conexion.cursor() as cursor:
                # Ejecutar la consulta SQL para actualizar inasistencias
                consulta_actualizacion = "UPDATE Pase_de_lista SET Asistio = 0 WHERE Dia = %s AND Hora BETWEEN %s AND %s"
                cursor.execute(consulta_actualizacion, (ahora.strftime("%Y-%m-%d"), "00:00:00", ahora.strftime("%H:%M:%S")))
            
                # Confirmar los cambios en la base de datos
                conexion.commit()

    except Exception as e:
        print(f"Error al verificar la inasistencia: {e}")

# Bucle principal
while True:
    verificar_inasistencia()
    time.sleep(tiempo_espera)
"""
import mysql.connector

# Replace these values with your own database connection details
db_config = {
    # Replace these values with your MySQL server credentials
    'host': 'localhost',
    'user': 'Admin',
    'password': 'Pase_Asistencia',
    'database': 'lista'
}

try:
    # Establish a connection to the MySQL server
    connection = mysql.connector.connect(**db_config)

    # Create a cursor object to interact with the database
    cursor = connection.cursor()

    # Example SELECT query
    query = "SELECT * FROM alumnos"
    cursor.execute(query)

    # Fetch all rows from the result set
    result = cursor.fetchall()

    # Print the results
    for row in result:
        print(row)

except mysql.connector.Error as err:
    print(f"MySQL Error: {err}")

finally:
    # Close the cursor and connection
    if 'connection' in locals() and connection.is_connected():
        cursor.close()
        connection.close()
        print("MySQL connection is closed.")









