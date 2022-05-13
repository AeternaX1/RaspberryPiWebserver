from gpiozero import CPUTemperature

cpu = CPUTemperature()
print("The current temperature of the Raspberry Pi is: " , cpu.temperature,"℃")
