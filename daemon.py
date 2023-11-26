import os
import time
print('getcwd: ', os.getcwd())
print('__file__:   ',__file__)
import subprocess

ruta = "/var/www/html/lista.php"
time.sleep(60)
"""while aux == 0:
time.sleep(86400)
"""
subprocess.run(['php',ruta])