import os
import time
print('getcwd: ', os.getcwd())
print('__file__:   ',__file__)
import subprocess

ruta = "/var/www/html/lista_daemon.py"
time.sleep(60)
subprocess.run(['python3',ruta])