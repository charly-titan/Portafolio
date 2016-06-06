import ftplib
import logging

class Uploads:
    global ftp

    def __init__(self, config):
        self.ftp = ftplib.FTP(config["SERVER"],config["USR"],config["PSW"])
        if "PATH" in config:
            self.move_to_dir(config["PATH"])
        
    def upload_file(self,upfile,fname):
        logging.debug(" Directorio donde se sube el archivo: %s/%s ",self.ftp.pwd(), fname)
        if(fname!=""):
            f = open(upfile,'rb')
            self.ftp.storbinary('STOR '+fname, f)
            f.close()
            return 1
      
    def move_to_dir(self,path):
        try:
            self.ftp.cwd(path)
            return 1
        except:
            logging.debug(" El directorio %s no existia, se procede a crearlo",path)
           
        tpath=path.split("/")
        rpath=""
        for p in tpath:
            if(p!=""):
                rpath+=p+"/"
                try:
                    self.ftp.cwd(rpath)
                except:
                    self.ftp.mkd(p)
                    self.ftp.cwd(p+"/")
        return self.ftp.pwd()
