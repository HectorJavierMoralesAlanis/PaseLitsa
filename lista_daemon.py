from datetime import datetime
from datetime import date
import mysql.connector

#dt = datetime.now()
#ts = datetime.timestamp(dt)
fecha = date.today()
print(type(fecha))
hora = datetime.now().time()
print(hora)
# Replace these values with your own database connection details
db_config = {
    # Replace these values with your MySQL server credentials
    'host': 'localhost',
    'user': 'admin',
    'password': '3d54d0c824c2c3f7b4415dff96ed0fbeb752c151b68224dc',
    'database': 'lista'
}


try:
    # Establish a connection to the MySQL server
    connection = mysql.connector.connect(**db_config)

    # Create a cursor object to interact with the database
    cursor = connection.cursor()

    # Example SELECT query
    query = "INSERT INTO `Pase_de_lista`(`Matricula`, `Asistio`, `Dia`, `Hora`, `Grupo`, `Clase`) VALUES ('2030103','0','DATE(%s)','TIME(%s)','1','Matematicas')"
    cursor.execute(query,(date(fecha),time(hora)))
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









