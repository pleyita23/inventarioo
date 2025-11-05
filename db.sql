CREATE DATABASE IF NOT EXISTS inventario CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE inventario;

CREATE TABLE IF NOT EXISTS articulos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  unidades INT NOT NULL DEFAULT 0,
  tipo ENUM('PC','teclado','disco duro','mouse') NOT NULL,
  bodega ENUM('norte','sur','oriente','occidente') NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
