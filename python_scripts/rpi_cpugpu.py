import os

cmd = "vcgencmd get_mem arm && vcgencmd get_mem gpu"

os.system(cmd)



