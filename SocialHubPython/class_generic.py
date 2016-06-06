# -*- coding: latin-1 -*-

class Generic:

    global config

    def __init__(self):
        self.config={}
        self.get_config()

    # Obtengo la configuracion de la aplicacion
    def get_config(self):
        fileIN = open("config.config", "r")
        line = fileIN.readline()
        while line:
            line=self.remove_line_breaks(line)
            if(line!=""):
                if(line[0]!='#'):
                    tmp=line.split("|")
                    if len(tmp)==2:
                        if not tmp[0] in self.config:
                            self.config[tmp[0]]=str(tmp[1])
            line = fileIN.readline()



    # Limpia la linea de los saltos de linea y retornos de carro
    def remove_line_breaks(self,line):
        if line[-1] == '\r':
            line = line[:-1]
        if line[-1] == '\n':
            line = line[:-1]
        return line



    