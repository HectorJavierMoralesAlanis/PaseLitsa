import os
import time
print('getcwd: ', os.getcwd())
print('__file__:   ',__file__)
import subprocess
aux=0
ruta = "/var/www/html/lista_daemon.php"
#time.sleep(60)
while aux == 0:
    time.sleep(1)
    #time.sleep(86400)
    subprocess.run(['php',ruta])