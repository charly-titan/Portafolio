# Creado: 03/Jul/09     Autor: Gabriel Mancera gabriel.mancera@esmas.net
# Actualizado: -
# Para realizar el include de este modulo basta con copiar el archivo al mismo
# directorio del pythron principal e incluir la siguiente referencia:
#
# from conexion import ConnectDB
#
#


# HAGO EL IMPORT NECESARIO PARA REALIZAR LA CONEXION CON LA BASE DE DATOS
import MySQLdb

# Comienzo a delcarar mi clase ConnectDB
class ConnectDB:
    global cn, dbSrv, num_rows

    def __init__(self,srv, usr,psw,dtb):
        self.dbSrv = MySQLdb.connect(host=srv,user=usr,passwd=psw,db=dtb)
        self.cn    = self.dbSrv.cursor()
        
    def select(self,sql):
        self.cn.execute(sql)
        result = self.cn.fetchall()
        self.num_rows=self.cn.rowcount
        return result

    def insert(self,sql):
        self.cn.execute(sql)

    def commit(self):
        self.cn.execute("""COMMIT""")


