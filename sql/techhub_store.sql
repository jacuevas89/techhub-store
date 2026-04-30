DROP DATABASE IF EXISTS `techhub_store`;
CREATE DATABASE `techhub_store` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `techhub_store`;

-- Crea Tablas

CREATE TABLE usuarios (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	rut VARCHAR(10) NOT NULL UNIQUE,
	rut_completo VARCHAR(12) NOT NULL UNIQUE,
	nombre_completo VARCHAR(150) NOT NULL,
	email VARCHAR(150) NOT NULL UNIQUE,
	clave_hash VARCHAR(255) NOT NULL,
	admin TINYINT(1) NOT NULL DEFAULT 0,
	fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    precio INT NOT NULL,
    categoria VARCHAR(80) NOT NULL,
    subcategoria VARCHAR(80) NOT NULL,
    imagen VARCHAR(100) NOT NULL,
	fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE carritos (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    usuario_rut VARCHAR(10) NOT NULL UNIQUE,
    cart_data JSON NULL,
	fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_carritos_usuario FOREIGN KEY (usuario_rut) REFERENCES usuarios(rut) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE ordenes (
    id_orden INT AUTO_INCREMENT PRIMARY KEY,
    usuario_rut VARCHAR(10) NOT NULL,
    total INT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente',
	fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_ordenes_usuario FOREIGN KEY (usuario_rut) REFERENCES usuarios(rut) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE detalles_orden (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    orden_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario INT NOT NULL,
    subtotal INT NOT NULL,  
    CONSTRAINT fk_detalles_orden FOREIGN KEY (orden_id) REFERENCES ordenes(id_orden) ON DELETE CASCADE,
    CONSTRAINT fk_detalles_producto FOREIGN KEY (producto_id) REFERENCES productos(id_producto) ON DELETE RESTRICT
);

-- Inserta datos de prueba

INSERT INTO usuarios (rut, rut_completo, nombre_completo, email, clave_hash, admin) VALUES
('11111111', '11111111-1', 'Administrador TechHub', 'admin@techhub.cl', '$2y$12$WBg3IahOMNah2pAmy3oJ6u5eiycARBQMCrmiod8ZYJYkWxztAh96O', 1),
('22222222', '22222222-2', 'Usuario Demo', 'usuario@techhub.cl', '$2y$12$WBg3IahOMNah2pAmy3oJ6u5eiycARBQMCrmiod8ZYJYkWxztAh96O', 0);

/*Credenciales:
Administrador: admin@techhub.cl			Clave: 12345678
Usuario normal: usuario@techhub.cl		Clave: 12345678
*/

-- Inserta productos de prueba

INSERT INTO productos (nombre, descripcion, precio, categoria, subcategoria, imagen) VALUES
('Lenovo IdeaPad Pro5', 'Notebook para estudio y trabajo diario con buen rendimiento.', 549990, 'Computación', 'Notebooks', 'notebook.jpg'),
('Audífonos Gamer con Micrófono', 'Audio envolvente y micrófono integrado.', 69990, 'Audio', 'Audífonos', 'audifonos.jpg'),
('Samsung Galaxy Tab S10', 'Tablet ideal para entretenimiento, clases y lectura.', 289990, 'Movilidad', 'Tablets', 'tablet.jpg'),
('Monitor Gamer 27 pulgadas', 'Pantalla con alta tasa de refresco para gaming.', 239990, 'Computación', 'Monitores', 'monitor.jpg'),
('Xiaomi Redmi 15 5G', 'Teléfono inteligente con excelente relación precio-calidad.', 219990, 'Telefonía', 'Smartphones', 'smartphone.jpg'),
('Teclado Inalámbrico Compacto', 'Accesorio práctico para escritorio minimalista.', 34990, 'Accesorios', 'Teclados', 'teclado.jpg'),
('Monitor LG 24 pulgadas', 'Monitor Full HD para oficina, estudio y entretenimiento.', 149990, 'Computación', 'Monitores', 'monitor.jpg'),
('iPad Básico', 'Tablet liviana y rápida para tareas diarias y consumo de contenido.', 399990, 'Movilidad', 'Tablets', 'tablet.jpg'),
('Teclado Mecánico RGB', 'Teclado con retroiluminación y buena respuesta táctil.', 59990, 'Accesorios', 'Teclados', 'teclado.jpg'),
('Mouse Gamer Óptico', 'Mouse con precisión mejorada para sesiones largas.', 29990, 'Accesorios', 'Mouse', 'mouse.jpg'),
('HP Pavilion x360', 'Equipo portátil equilibrado para productividad y multimedia.', 699990, 'Computación', 'Notebooks', 'notebook.jpg'),
('Audífonos Bluetooth', 'Audífonos cómodos para música, trabajo y videollamadas.', 45990, 'Audio', 'Audífonos', 'audifonos.jpg'),
('Samsung Galaxy A20 5G', 'Equipo moderno con buena cámara y batería duradera.', 279990, 'Telefonía', 'Smartphones', 'smartphone.jpg'),
('Impresora Multifuncional', 'Imprime, copia y escanea en un solo equipo.', 129990, 'Oficina', 'Impresoras', 'impresora.jpg'),
('Webcam Full HD', 'Cámara web ideal para clases y reuniones online.', 39990, 'Accesorios', 'Webcams', 'webcam.jpg'),
('Router WiFi Doble Banda', 'Mejora la cobertura y estabilidad de tu red doméstica.', 64990, 'Redes', 'Routers', 'router.jpg'),
('Mouse Inalámbrico', 'Mouse cómodo y compacto para oficina.', 19990, 'Accesorios', 'Mouse', 'mouse.jpg'),
('SSD 1TB', 'Unidad de almacenamiento rápida para notebooks y PCs.', 79990, 'Componentes', 'Almacenamiento', 'ssd.jpg'),
('Memoria RAM 16GB', 'Módulo de memoria para mejorar el rendimiento del equipo.', 54990, 'Componentes', 'Memoria', 'memoria-ram.jpg'),
('PC Escritorio Oficina', 'Equipo de escritorio para trabajo administrativo y académico.', 499990, 'Computación', 'PC Escritorio', 'pc-escritorio.jpg');
