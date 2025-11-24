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


    $categoria_precio = 1; // ID 1 = Cítricos
    $porcentaje = 1.10;      // Multiplicar por 1.10 es sumar el 10%

    $sql_update = "UPDATE productos SET precio = precio * :pct WHERE categoria_id = :cat";
    $stmt = $pdo->prepare($sql_update);

    $stmt->execute([
        ':pct' => $porcentaje,
        ':cat' => $categoria_precio
    ]);

    // rowCount() dice cuántas filas se tocaron
    $afectados = $stmt->rowCount();

    echo "<div class='info'>";
    echo "Se han actualizado <strong>$afectados productos</strong> de la categoría $categoria_precio.<br>";
    echo "Sus precios han subido un 10%.";
    // Saco los prodcutos con el precio aumentado
    $sql = "SELECT nombre, precio FROM productos WHERE categoria_id = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $precios_aumentados = $stmt->fetchAll();

    echo "<pre>";
    foreach ($precios_aumentados as $producto) {
        echo "<div class='productos'> $producto[nombre] $producto[precio] </div>";

    }
    echo "</pre>";

    // b y c, compra y validacion de stock

    $producto_id = 1;      // comprar Naranjas (ID 1)
    $cantidad_compra = 150; //  comprar 50 unidades

    echo "<p>Intentando comprar <strong>$cantidad_compra</strong> unidades del producto ID <strong>$producto_id</strong>...</p>";

    // verificar stock
    $stmt_check = $pdo->prepare("SELECT nombre, stock FROM productos WHERE id = ?");
    $stmt_check->execute([$producto_id]);
    $producto = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        echo "<p class='error'>El producto no existe.</p>";
    } else {
        $nombre = $producto['nombre'];
        $stock_actual = $producto['stock'];

        echo "<p>Stock actual de $nombre: <strong>$stock_actual</strong></p>";

        // valido que no me quede en negativo
        if (($stock_actual - $cantidad_compra) >= 0) {

            //  Reducir Stock
            $sql_resta = "UPDATE productos SET stock = stock - ? WHERE id = ?";
            $stmt_resta = $pdo->prepare($sql_resta);
            $stmt_resta->execute([$cantidad_compra, $producto_id]);

            echo "<p class='success'>Compra realizada con exito</p>";
            echo "<p>Nuevo stock: " . ($stock_actual - $cantidad_compra) . "</p>";

        } else {
            // Error si no hay suficiente
            echo "<p class='error'>Error: Stock insuficiente. No puedes dejar el stock en negativo.</p>";
            echo "<p>Te faltan " . ($cantidad_compra - $stock_actual) . " unidades.</p>";
        }
    }

    //--------------------------------------
    //PARTE 2 EJERCICIOS PRACTICOS

    //Ejercicio 6
    try {
        $sql_alter = "ALTER TABLE productos ADD COLUMN IF NOT EXISTS eliminado TINYINT(1) DEFAULT 0";
        //TINYINT me lo ha dicho la IA completamente, me ha dicho tambien que funciona como un boolean
        $pdo->exec($sql_alter);
        echo "<div class='log'>Estructura de tabla verificada (Columna 'eliminado' existe).</div>";
    } catch (Exception $e) {
    }

    // soft delete
    $sql_delete = "UPDATE productos SET eliminado = 1 WHERE stock = 0";
    $stmt = $pdo->prepare($sql_delete);
    $stmt->execute();

    $afectados = $stmt->rowCount();

    if ($afectados > 0) {
        echo "<div class='log' style='border-color: red;'>Se han enviado a la papelera <strong>$afectados productos</strong> (Stock 0).</div>";
    } else {
        echo "<div class='log'>No había productos con stock 0 para eliminar.</div>";
    }
    //muestro productos que quedan

    //filtro por eliminado = 0 para sacar los no eliminados
    $sql_activos = "SELECT nombre, stock FROM productos WHERE eliminado = 0";
    $stmt_activos = $pdo->query($sql_activos);

    echo "<ul>";
    while ($row = $stmt_activos->fetch(PDO::FETCH_ASSOC)) {
        echo "<li><strong>{$row['nombre']}</strong> (Stock: {$row['stock']})</li>";
    }
    echo "</ul>";
    echo "</div>";


    // EJERCICIO 7 fumada historica con IA
    // ==========================================
    // DATOS DE ENTRADA (Simulados)
    // ==========================================
    $usuario_id = 1;      // ID del cliente (Juan Pérez)
    $producto_id = 2;     // ID del producto (Limón)
    $cantidad_compra = 50; // Cantidad a comprar (Prueba a poner 5000 para forzar error) y 50 luego para comprobar que funca

    echo "<p>Cliente ID: <strong>$usuario_id</strong> intenta comprar <strong>$cantidad_compra</strong> unidades del Producto ID: <strong>$producto_id</strong></p>";

    // ==========================================
    // 🚦 INICIO DE LA TRANSACCIÓN
    // ==========================================
    // A partir de aquí, nada es definitivo hasta que hagamos commit()
    $pdo->beginTransaction();

    // 1. VALIDAR USUARIO
    // ------------------------------------------
    $stmtUser = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
    $stmtUser->execute([$usuario_id]);
    if (!$stmtUser->fetch()) {
        throw new Exception("El usuario no existe.");
    }
    echo "<div class='step'>✅ Paso 1: Usuario verificado.</div>";

    // 2. OBTENER PRECIO Y STOCK ACTUAL (BLOQUEO)
    // ------------------------------------------
    // "FOR UPDATE" bloquea la fila para que nadie más compre este producto mientras leemos
    $stmtProd = $pdo->prepare("SELECT nombre, precio, stock FROM productos WHERE id = ? AND eliminado = 0 FOR UPDATE");
    $stmtProd->execute([$producto_id]);
    $producto = $stmtProd->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        throw new Exception("El producto no existe o está eliminado.");
    }

    echo "<div class='step'>✅ Paso 2: Producto encontrado ({$producto['nombre']}). Stock actual: {$producto['stock']}</div>";

    // 3. VALIDAR STOCK SUFICIENTE
    // ------------------------------------------
    if ($producto['stock'] < $cantidad_compra) {
        throw new Exception("Stock insuficiente. Solo quedan {$producto['stock']} unidades.");
    }

    // 4. CALCULAR TOTAL Y CREAR PEDIDO
    // ------------------------------------------
    $total_pagar = $producto['precio'] * $cantidad_compra;

    // Insertamos en la tabla pedidos
    $stmtPedido = $pdo->prepare("INSERT INTO pedidos (usuario_id, total, fecha) VALUES (?, ?, NOW())");
    $stmtPedido->execute([$usuario_id, $total_pagar]);

    // Obtenemos el ID del pedido recién creado (útil para recibos)
    $pedido_id = $pdo->lastInsertId();

    echo "<div class='step'>✅ Paso 3: Pedido #$pedido_id creado. Total: $total_pagar €</div>";

    // 5. REDUCIR STOCK
    // ------------------------------------------
    $stmtUpdate = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
    $stmtUpdate->execute([$cantidad_compra, $producto_id]);

    echo "<div class='step'>✅ Paso 4: Stock actualizado.</div>";

    // ==========================================
    // 🏁 CONFIRMAR TRANSACCIÓN (COMMIT)
    // ==========================================
    // Si hemos llegado hasta aquí sin errores, guardamos todo permanentemente.
    $pdo->commit();

    echo "<div class='success'>
            <h3>🎉 ¡Compra Finalizada con Éxito!</h3>
            <p>Se ha generado el pedido y descontado el stock.</p>
          </div>";


    // =================================================================
    // EJERCICIO 8 fumada con IA tambien
    // (Esto crea la tabla detalles y mete datos falsos si no existen)
    // =================================================================

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS detalles_pedidos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            pedido_id INT NOT NULL,
            producto_id INT NOT NULL,
            cantidad INT NOT NULL,
            precio_unitario DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
            FOREIGN KEY (producto_id) REFERENCES productos(id)
        )
    ");

    // Si la tabla está vacía, insertamos datos de prueba para los reportes
    $check = $pdo->query("SELECT COUNT(*) FROM detalles_pedidos")->fetchColumn();
    if ($check == 0) {
        // Simulamos que el pedido 1 (que creaste antes) tiene productos
        // Asegúrate de tener al menos un pedido en la tabla 'pedidos' o esto fallará por la FK
        // Si no tienes pedidos, crea uno ficticio rápido:
        $pdo->exec("INSERT IGNORE INTO pedidos (id, usuario_id, total) VALUES (1, 1, 100)");

        $pdo->exec("INSERT INTO detalles_pedidos (pedido_id, producto_id, cantidad, precio_unitario) VALUES 
            (1, 1, 50, 1.50),  -- 50 Naranjas
            (1, 2, 30, 0.90),  -- 30 Limones
            (1, 7, 10, 3.80)   -- 10 Mangos
        ");
    }

    // =================================================================
    // A) PRODUCTOS MÁS VENDIDOS (Top Sellers)
    // =================================================================
    echo "<div class='report-card'>";
    echo "<h2>🏆 a) Productos Más Vendidos</h2>";

    // Lógica: Sumamos la cantidad vendida de la tabla detalles y agrupamos por producto
    $sql_a = "SELECT p.nombre, SUM(dp.cantidad) as total_vendido
              FROM detalles_pedidos dp
              JOIN productos p ON dp.producto_id = p.id
              GROUP BY dp.producto_id
              ORDER BY total_vendido DESC";

    $stmt = $pdo->query($sql_a);

    echo "<table><tr><th>Producto</th><th>Unidades Vendidas</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['nombre']}</td><td><strong>{$row['total_vendido']}</strong> uds.</td></tr>";
    }
    echo "</table></div>";

    // =================================================================
    // B) INGRESOS POR CATEGORÍA
    // =================================================================
    echo "<div class='report-card'>";
    echo "<h2>💰 b) Ingresos por Categoría</h2>";

    // Lógica: Unimos Detalles -> Productos -> Categorias
    // Calculamos (cantidad * precio) y sumamos todo agrupando por categoría
    $sql_b = "SELECT c.nombre, SUM(dp.cantidad * dp.precio_unitario) as ingresos
              FROM detalles_pedidos dp
              JOIN productos p ON dp.producto_id = p.id
              JOIN categorias c ON p.categoria_id = c.id
              GROUP BY c.id
              ORDER BY ingresos DESC";

    $stmt = $pdo->query($sql_b);

    echo "<table><tr><th>Categoría</th><th>Ingresos Totales</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['nombre']}</td><td class='money'>" . number_format($row['ingresos'], 2) . " €</td></tr>";
    }
    echo "</table></div>";

    // =================================================================
    // C) PRODUCTOS CON BAJO STOCK (< 10)
    // =================================================================
    echo "<div class='report-card'>";
    echo "<h2>⚠️ c) Alerta de Stock Bajo (< 10)</h2>";

    $sql_c = "SELECT nombre, stock, precio FROM productos WHERE stock < 10 AND eliminado = 0";
    $stmt = $pdo->query($sql_c);
    $data_c = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($data_c) {
        echo "<table><tr><th>Producto</th><th>Stock Actual</th><th>Acción</th></tr>";
        foreach($data_c as $row) {
            echo "<tr>
                    <td>{$row['nombre']}</td>
                    <td><span class='badge'>{$row['stock']}</span></td>
                    <td><a href='#' style='color:blue'>Reponer</a></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>✅ Todo el inventario está saludable.</p>";
    }
    echo "</div>";

    // =================================================================
    // D) MEJORES CLIENTES (Usuarios con más pedidos)
    // =================================================================
    echo "<div class='report-card'>";
    echo "<h2>🥇 d) Usuarios Más Activos</h2>";

    // Lógica: Contamos cuántos pedidos tiene cada usuario en la tabla 'pedidos'
    $sql_d = "SELECT u.nombre, COUNT(p.id) as num_pedidos, SUM(p.total) as gastado_total
              FROM pedidos p
              JOIN usuarios u ON p.usuario_id = u.id
              GROUP BY u.id
              ORDER BY num_pedidos DESC";

    $stmt = $pdo->query($sql_d);

    echo "<table><tr><th>Usuario</th><th>Pedidos Realizados</th><th>Gasto Total</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['nombre']}</td>
                <td>{$row['num_pedidos']}</td>
                <td class='money'>" . number_format($row['gastado_total'], 2) . " €</td>
              </tr>";
    }
    echo "</table></div>";
} catch(PDOException $e) {
    die("<p style='color: red; font-weight: bold;'>❌ Error de Conexión o Creación de BD: " . $e->getMessage() . "</p>");
}