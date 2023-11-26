import requests
import datetime
#import pymysql
from pytz import timezone  # Asegúrate de tener instalado el paquete 'pytz'
#from daemonize import Daemonize

# URL del script PHP
url_php_script = "http://157.245.253.25/lista.php"

# Parámetro para la solicitud POST (si es necesario)
parametros_post = {"uid": "valor_de_uid"}

# Convertir los datos a bytes
datos_bytes = {k: v.encode('utf-8') for k, v in parametros_post.items()}

# Tiempo de espera entre cada solicitud en segundos
tiempo_espera = 60  # por ejemplo, una solicitud cada minuto

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

# Configuración de la conexión a la base de datos
"""conexion = pymysql.connect(
    host="localhost",  # Cambia esto al host correcto
    user="Admin2",  # Cambia esto al usuario correcto
    password="Pase_Asistencia",  # Cambia esto a la contraseña correcta
    database="lista"  # Cambia esto a la base de datos correcta
)"""

def ejecutar_script():
    try:
        # Obtener la hora y el día actual en la zona horaria del servidor
        tz = timezone('America/Monterrey')  # Ajusta la zona horaria según tu ubicación
        ahora = datetime.datetime.now(tz)
        dia_actual = ahora.strftime("%a")
        hora_actual = ahora.strftime("%H:%M:%S")

        # Verificar si es un día de inasistencia y la hora actual está fuera de los rangos de la mañana
        if dia_actual in dias_inasistencia and all(not (rango["inicio"] <= hora_actual <= rango["fin"]) for rango in rangos_tiempo_manana):
            # Realizar una nueva solicitud para marcar a todos los alumnos como inasistentes
            nueva_solicitud = requests.post(url_php_script, data=datos_bytes)

            # Imprimir la respuesta de la nueva solicitud
            print(f"Inasistencia para el alumno: {nueva_solicitud.text} el día: {dia_actual} a las {hora_actual}")

            # Actualizar la base de datos con inasistencias
            with conexion.cursor() as cursor:
                # Ejecutar la consulta SQL para actualizar inasistencias
                consulta_actualizacion = "UPDATE Pase_de_lista SET Asistio = 0 WHERE Dia = %s AND Hora BETWEEN %s AND %s"
                cursor.execute(consulta_actualizacion, (ahora.strftime("%Y-%m-%d"), "00:00:00", ahora.strftime("%H:%M:%S")))
            
            # Confirmar los cambios en la base de datos
            conexion.commit()

    except Exception as e:
        print(f"Error al realizar la solicitud: {e}")

# Configuración del daemon
#pid = "/tmp/inasistencia_daemon.pid"
#daemon = Daemonize(app="inasistencia_daemon", pid=pid, action=ejecutar_script)
ejecutar_script( )
# Iniciar el daemon
#daemon.start()








