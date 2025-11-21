<?php
// Información de PHP
echo "<h2>📦 Versión de PHP</h2>";
echo "<p class='info'>PHP " . phpversion() . "</p>";

// Conexión a la base de datos
echo "<h2>🔌 Conexión a MariaDB</h2>";

$host = 'db';  // Nombre del servicio en docker-compose
$dbname = 'testdb';
$username = 'alumno';
$password = 'alumno';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<p class='success'>✅ Conexión exitosa a la base de datos</p>";

    // Obtener versión de MariaDB
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "<p class='info'>MariaDB versión: $version</p>";

    //Crear base de datos (no deja porque soy un pendejo sin permiso)
    //$pdo->exec("CREATE DATABASE IF NOT EXISTS tienda_frutas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    //Añado tablas
    $pdo->exec("CREATE TABLE IF NOT EXISTS categorias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT
    )
    ");

    // Tabla 2: usuarios
    $pdo->exec( "CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(150) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        contraseña VARCHAR(255) NOT NULL
    )
    ");

    // Tabla 3: productos (depende de categorias)
    $pdo->exec( "CREATE TABLE IF NOT EXISTS productos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        categoria_id INT NOT NULL,
        precio DECIMAL(10, 2) NOT NULL,
        stock INT NOT NULL DEFAULT 0,
        FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE RESTRICT
    )
    ");


    // Tabla 4: pedidos (depende de usuarios)
    $pdo->exec( "CREATE TABLE IF NOT EXISTS pedidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario_id INT NOT NULL,
        fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        total DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE RESTRICT
    )
    ");

    // Insercion de datos

    echo "<h1>🧹 Reiniciando Datos... gitanada</h1>";
    //Limpio los datos de las tablas antes de insertar mas datos para no tener duplicados

    // 1. Desactivar revisión de claves foráneas para poder vaciar tablas
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    // 2. Vaciar las tablas (TRUNCATE borra todo y reinicia los IDs a 1)
    $pdo->exec("TRUNCATE TABLE productos");
    $pdo->exec("TRUNCATE TABLE categorias");

    // 3. Reactivar revisión de claves foráneas (no se que es esto, PREGUNTAR)
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "<p>✅ Tablas vaciadas correctamente.</p>";


    $sql_categorias = "
        INSERT INTO categorias (id, nombre, descripcion) VALUES
        (1, 'Cítricos', 'Frutas con alto contenido de vitamina C, como naranjas y limones.'),
        (2, 'Frutas Rojas', 'Bayas y otras frutas con pigmentos rojizos, ricas en antioxidantes.'),
        (3, 'Tropicales', 'Frutas exóticas que crecen en climas cálidos, como mangos y piñas.')
        ON DUPLICATE KEY UPDATE nombre=VALUES(nombre);
    ";

    $pdo->exec($sql_categorias);
    echo "<p style='color: blue;'>➡️ 3 categorías insertadas/actualizadas (Cítricos, Frutas Rojas, Tropicales).</p>";


    $sql_productos = "
        INSERT INTO productos (nombre, categoria_id, precio, stock) VALUES
        ('Naranja', 1, 1.50, 150),
        ('Limón', 1, 0.90, 200),
        ('Pomelo', 1, 2.10, 80),
        ('Fresa', 2, 3.50, 120),
        ('Frambuesa', 2, 4.20, 75),
        ('Cereza', 2, 5.00, 90),
        ('Mango', 3, 3.80, 60),
        ('Piña', 3, 2.50, 110),
        ('Maracuyá', 3, 4.90, 40),
        ('Aguacate', 3, 2.90, 100)
        ON DUPLICATE KEY UPDATE stock=stock;
    ";
    $pdo->exec($sql_productos);
    echo "<p style='color: blue;'>➡️ 10 productos insertados/actualizados.</p>";

    /// Ejercicio3 CONSULTAS


    //Preparo la query con la consulta
    $stmt = $pdo->query('SELECT * FROM productos order by precio ASC');
    //Ejecuto la consulta
    $stmt->execute();
    //Obtengo los resultados
    $productos_ordenados = $stmt->fetchAll();

    // <pre> mantiene el formato de espacios y saltos de línea
    echo "<pre>";
    foreach ($productos_ordenados as $producto) {
        echo "<div class='productos'> $producto[nombre] $producto[categoria_id] $producto[precio] </div>";

    }
    echo "</pre>";

    // OBTENER PRODUCTOS DE UNA CATEGORIA

    // Variable que simula lo que vendría de un formulario
    $id_categoria_buscada = 1;
    // Prueba de una categoria que no existe  $id_categoria_buscada_dos = 10;

    // PASO 1: Preparamos la sentencia con un marcador anónimo (?)
    $sql_b = "SELECT nombre, precio, stock FROM productos WHERE categoria_id = ?";
    $stmt_b = $pdo->prepare($sql_b);

    // PASO 2: Ejecutamos pasando el valor en un array
    $stmt_b->execute([$id_categoria_buscada]);
    // Prueba de una categoria que no existe $stmt_b->execute([$id_categoria_buscada_dos]);

    // PASO 3: Mostrar resultados
    $resultados_b = $stmt_b->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados_b) {
        echo "<ul>";
        foreach ($resultados_b as $prod) {
            echo "<li><strong>{$prod['nombre']}</strong> (Stock: {$prod['stock']}) - {$prod['precio']}€</li>";
        } // Si hay productos en esa categoria los muestro
        echo "</ul>";
    } else { // Si no muestro mensaje
        echo "<p>No hay productos en esta categoría.</p>";
    }
    echo "</div>";



    // OBTENER PRODUCTOS CON STOCK MENOR A 20

    //Defino el limite en el stock (totalmente opcional)
    $stock_limite = 20;

    // PASO 1: Preparamos la consulta

    $sql_c = "SELECT nombre, stock FROM productos WHERE stock > $stock_limite";
    $stmt_c = $pdo->prepare($sql_c);

    // PASO 2: Ejecutar
    $stmt_c->execute();
    $resultados_c = $stmt_c->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar resultados
    if ($resultados_c) {
        echo "<ul>";
        foreach ($resultados_c as $prod) {
            echo "<li><strong>{$prod['nombre']}</strong> solo tiene {$prod['stock']} unidades.</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>ℹ️ No se encontraron productos con stock menor a $stock_limite.<br></p>";
    }

    // OBTENER CANTIDAD TOTAL DE PRODUCTOS

    // PASO 1: Preparar la consulta de conteo
    $sql_d = "SELECT COUNT(*) FROM productos";
    $stmt_d = $pdo->prepare($sql_d);

    // PASO 2: Ejecutar
    $stmt_d->execute();

    // PASO 3: Obtener el dato único con fetchColumn()
    // fetchColumn() es perfecto cuando la consulta solo devuelve un número o un solo dato
    $total_productos = $stmt_d->fetchColumn();

    echo "<p>Actualmente tenemos <strong>$total_productos</strong> productos registrados en la base de datos.</p>";


    //Ejercicio 4 (PREGUNTAR DUDA INNER JOIN)

    $sql = "SELECT 
                p.nombre AS producto, 
                p.precio, 
                c.nombre AS categoria 
            FROM productos p 
            INNER JOIN categorias c ON p.categoria_id = c.id
            ORDER BY c.nombre ASC, p.precio ASC";

    $stmt = $pdo->query($sql); // Usamos query directo porque no hay parámetros (?)

    echo "<h2>Listado de Productos</h2>";

    // 3. Mostrar resultados en una LISTA simple
    echo "<ul>"; // Abrimos la lista

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Imprimimos una línea por cada producto
        echo "<li>";
        echo "<strong>" . $row['categoria'] . ":</strong> ";
        echo $row['producto'] . " (" . $row['precio'] . " €)";
        echo "</li>";
    }


    //EJERCICIO 5


    echo "</ul>";
} catch(PDOException $e) {
    die("<p style='color: red; font-weight: bold;'>❌ Error de Conexión o Creación de BD: " . $e->getMessage() . "</p>");
}