from selenium import webdriver
from selenium.webdriver.edge.service import Service
from selenium.webdriver.support.ui import Select
from selenium.webdriver.common.by import By
import time

# Ruta al msedgedriver.exe
service = Service(
    executable_path="D:/Xampp/htdocs/InventarioSistema/webdriver/msedgedriver.exe")
driver = webdriver.Edge(service=service)

# Abre tu formulario local
driver.get("http://localhost/InventarioSistema/clientes.php")
driver.maximize_window()
time.sleep(2)

# login
driver.find_element(By.NAME, "user_name").send_keys("admin")
driver.find_element(By.NAME, "user_password").send_keys("admin")
driver.find_element(By.ID, "submit").click()
time.sleep(1)

# Entrar a la pestaña clientes
driver.find_element(By.LINK_TEXT, "Clientes").click()
time.sleep(1)

driver.find_element(
    By.XPATH, "//button[@data-bs-target='#nuevoCliente']").click()
time.sleep(1)

# llenar el formulario
driver.find_element(By.NAME, "nombre").send_keys("Sofía")
driver.find_element(By.NAME, "apepaterno").send_keys("Ríos")
driver.find_element(By.NAME, "apematerno").send_keys("López")
driver.find_element(By.NAME, "direccion").send_keys("Av. Los Rosales 123")
driver.find_element(By.NAME, "dni").send_keys("56856856")
driver.find_element(By.NAME, "celular").send_keys("987654321")

fecha = "1998-07-15"
driver.execute_script(
    "document.getElementsByName('fecnac')[0].value = arguments[0];", fecha)

Select(driver.find_element(By.NAME, "sexo")).select_by_visible_text("Femenino")
Select(driver.find_element(By.NAME, "estado")
       ).select_by_visible_text("Soltero/a")
Select(driver.find_element(By.NAME, "departamento")).select_by_index(1)
time.sleep(1)
Select(driver.find_element(By.NAME, "provincia")).select_by_index(1)
time.sleep(1)
Select(driver.find_element(By.NAME, "distrito")).select_by_index(1)

driver.find_element(
    By.XPATH, "//button[contains(text(), 'Guardar datos')]").click()

time.sleep(2)

driver.quit()
