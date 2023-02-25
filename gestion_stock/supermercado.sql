-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2023 a las 19:18:40
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `supermercado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(9, 'Bebidas'),
(10, 'Condimentos'),
(11, 'Frutas/Verduras'),
(12, 'Carnes'),
(13, 'Pescado/Marisco'),
(14, 'Lácteos'),
(15, 'Repostería'),
(16, 'Granos/Cereales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(60) DEFAULT NULL,
  `categoria` int(11) DEFAULT NULL,
  `proveedor` int(11) DEFAULT NULL,
  `cantidad_unidad` varchar(70) DEFAULT NULL,
  `precio` int(10) UNSIGNED DEFAULT NULL,
  `unidades_existentes` int(10) UNSIGNED NOT NULL,
  `unidades_pedidas` int(10) UNSIGNED NOT NULL,
  `producto_eliminado` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `categoria`, `proveedor`, `cantidad_unidad`, `precio`, `unidades_existentes`, `unidades_pedidas`, `producto_eliminado`) VALUES
(1, 'Té Dharamsala', 9, 1, '10 cajas x 20 bolsas', 15500, 39, 0, 0),
(2, 'Cerveza tibetana Barley', 9, 1, '24 - bot. 12 l', 16300, 17, 40, 0),
(3, 'Sirope de regaliz', 10, 1, '12 - bot. 550 ml', 8600, 13, 70, 0),
(4, 'Especias Cajun del chef Anton', 10, 2, '48 - frascos 6 l', 18900, 53, 0, 0),
(5, 'Mezcla Gumbo del chef Anton', 10, 2, '36 cajas', 18300, 0, 0, 1),
(6, 'Mermelada de grosellas de la abuela', 10, 3, '12 - frascos 8 l', 21400, 120, 0, 0),
(7, 'Peras secas orgánicas del tío Bob', 11, 3, '12 - paq. 1 kg', 25700, 15, 0, 0),
(8, 'Salsa de arándanos Northwoods', 10, 3, '12 - frascos 12 l', 34300, 6, 0, 0),
(9, 'Buey Mishi Kobe', 12, 4, '18 - paq. 500 g', 83200, 29, 0, 1),
(10, 'Pez espada', 13, 4, '12 - frascos 200 ml', 26600, 31, 0, 0),
(11, 'Queso Cabrales', 14, 5, 'paq. 1 kg', 18000, 22, 30, 0),
(12, 'Queso Manchego La Pastora', 14, 5, '10 - paq. 500 g', 32600, 86, 0, 0),
(13, 'Algas Konbu', 13, 6, 'caja 2 kg', 5100, 24, 0, 0),
(14, 'Cuajada de judías', 11, 6, '40 - paq. 100 g', 19900, 35, 0, 0),
(15, 'Salsa de soja baja en sodio', 10, 6, '24 - bot. 250 ml', 13300, 39, 0, 0),
(16, 'Postre de merengue Pavlova', 15, 7, '32 - cajas 500 g', 15000, 29, 0, 0),
(17, 'Cordero Alice Springs', 12, 7, '20 - latas 1 kg', 33500, 0, 0, 1),
(18, 'Langostinos tigre Carnarvon', 13, 7, 'paq. 16 kg', 53600, 42, 0, 0),
(19, 'Pastas de té de chocolate', 15, 8, '10 cajas x 12 piezas', 7900, 25, 0, 0),
(20, 'Mermelada de Sir Rodney\'s', 15, 8, '30 cajas regalo', 69500, 40, 0, 0),
(21, 'Bollos de Sir Rodney\'s', 15, 8, '24 paq. x 4 piezas', 8600, 3, 40, 0),
(22, 'Pan de centeno crujiente estilo Gustaf\'s', 16, 9, '24 - paq. 500 g', 18000, 104, 0, 0),
(23, 'Pan fino', 16, 9, '12 - paq. 250 g', 7700, 61, 0, 0),
(24, 'Refresco Guaraná Fantástica', 9, 10, '12 - latas 355 ml', 3900, 20, 0, 1),
(25, 'Crema de chocolate y nueces NuNuCa', 15, 11, '20 - vasos  450 g', 12000, 76, 0, 0),
(26, 'Ositos de goma Gumbär', 15, 11, '100 - bolsas 250 g', 26800, 15, 0, 0),
(27, 'Chocolate Schoggi', 15, 11, '100 - piezas 100 g', 37700, 49, 0, 0),
(28, 'Col fermentada Rössle', 11, 12, '25 - latas 825 g', 39100, 26, 0, 1),
(29, 'Salchicha Thüringer', 12, 12, '50 bolsas x 30 salch', 106200, 0, 0, 1),
(30, 'Arenque blanco del noroeste', 13, 13, '10 - vasos 200 g', 22200, 10, 0, 0),
(31, 'Queso gorgonzola Telino', 14, 14, '12 - paq. 100 g', 10700, 0, 70, 0),
(32, 'Queso Mascarpone Fabioli', 14, 14, '24 - paq. 200 g', 27500, 9, 40, 0),
(33, 'Queso de cabra', 14, 15, '500 g', 2100, 112, 0, 0),
(34, 'Cerveza Sasquatch', 9, 16, '24 - bot. 12 l', 12000, 111, 0, 0),
(35, 'Cerveza negra Steeleye', 9, 16, '24 - bot. 12 l', 15400, 20, 0, 0),
(36, 'Escabeche de arenque', 13, 17, '24 - frascos 250 g', 16300, 112, 0, 0),
(37, 'Salmón ahumado Gravad', 13, 17, '12 - paq. 500 g', 22300, 11, 50, 0),
(38, 'Vino Côte de Blaye', 9, 18, '12 - bot. 75 cl', 226100, 17, 0, 0),
(39, 'Licor verde Chartreuse', 9, 18, '750 cc por bot.', 15400, 69, 0, 0),
(40, 'Carne de cangrejo de Boston', 13, 19, '24 - latas 4 l', 15800, 123, 0, 0),
(41, 'Crema de almejas estilo Nueva Inglaterra', 13, 19, '12 - latas 12 l', 8300, 85, 0, 0),
(42, 'Tallarines de Singapur', 16, 20, '32 - 1 kg paq.', 12000, 26, 0, 1),
(43, 'Café de Malasia', 9, 20, '16 - latas 500 g', 39500, 17, 10, 0),
(44, 'Azúcar negra Malacca', 10, 20, '20 - bolsas 2 kg', 16700, 27, 0, 0),
(45, 'Arenque ahumado', 13, 21, 'paq. 1k', 8200, 5, 70, 0),
(46, 'Arenque salado', 13, 21, '4 - vasos 450 g', 10300, 95, 0, 0),
(47, 'Galletas Zaanse', 15, 22, '10 - cajas 4 l', 8200, 36, 0, 0),
(48, 'Chocolate holandés', 15, 22, '10 paq.', 10900, 15, 70, 0),
(49, 'Regaliz', 15, 23, '24 - paq. 50 g', 17200, 10, 60, 0),
(50, 'Chocolate blanco', 15, 23, '12 - barras 100 g', 13900, 65, 0, 0),
(51, 'Manzanas secas Manjimup', 11, 24, '50 - paq. 300 g', 45500, 20, 0, 0),
(52, 'Cereales para Filo', 16, 24, '16 - cajas 2 kg', 6000, 38, 0, 0),
(53, 'Empanada de carne', 12, 24, '48 porc.', 28100, 0, 0, 1),
(54, 'Empanada de cerdo', 12, 25, '16 tartas', 6400, 21, 0, 0),
(55, 'Paté chino', 12, 25, '24 cajas x 2 tartas', 20600, 115, 0, 0),
(56, 'Gnocchi de la abuela Alicia', 16, 26, '24 - paq. 250 g', 32600, 21, 10, 0),
(57, 'Raviolis Angelo', 16, 26, '24 - paq. 250 g', 16700, 36, 0, 0),
(58, 'Caracoles de Borgoña', 13, 27, '24 porc.', 11400, 62, 0, 0),
(59, 'Raclet de queso Courdavault', 14, 28, 'paq. 5 kg', 47200, 79, 0, 0),
(60, 'Camembert Pierrot', 14, 28, '15 - paq. 300 g', 29200, 19, 0, 0),
(61, 'Sirope de arce', 10, 29, '24 - bot. 500 ml', 24500, 113, 0, 0),
(62, 'Tarta de azúcar', 15, 29, '48 tartas', 42300, 17, 0, 0),
(63, 'Sandwich de vegetales', 10, 7, '15 - frascos 625 g', 37700, 24, 0, 0),
(64, 'Bollos de pan de Wimmer', 16, 12, '20 bolsas x 4 porc.', 28500, 22, 80, 0),
(65, 'Salsa de pimiento picante de Luisiana', 10, 2, '32 - bot. 8 l', 18100, 76, 0, 0),
(66, 'Especias picantes de Luisiana', 10, 2, '24 - frascos 8 l', 14600, 4, 100, 0),
(67, 'Cerveza Laughing Lumberjack', 9, 16, '24 - bot. 12 l', 12000, 52, 0, 0),
(68, 'Barras de pan de Escocia', 15, 8, '10 cajas x 8 porc.', 10700, 6, 10, 0),
(69, 'Queso Gudbrandsdals', 14, 15, 'paq. 10 kg', 30900, 26, 0, 0),
(70, 'Cerveza Outback', 9, 7, '24 - bot. 355 ml', 12900, 15, 10, 0),
(71, 'Crema de queso Fløtemys', 14, 15, '10 - paq. 500 g', 18400, 26, 0, 0),
(72, 'Queso Mozzarella Giovanni', 14, 14, '24 - paq. 200 g', 29900, 14, 0, 0),
(73, 'Caviar rojo', 13, 17, '24 - frascos150 g', 12900, 101, 0, 0),
(74, 'Queso de soja Longlife', 11, 4, 'paq. 5 kg', 8600, 4, 20, 0),
(75, 'Cerveza Klosterbier Rhönbräu', 9, 12, '24 - bot. 0,5 l', 6600, 125, 0, 0),
(76, 'Licor Cloudberry', 9, 23, '500 ml', 15400, 57, 0, 0),
(77, 'Salsa verde original Frankfurter', 10, 12, '12 cajas', 11200, 32, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_proveedor` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_proveedor`) VALUES
(1, 'Exotic Liquids'),
(2, 'New Orleans Cajun Delights'),
(3, 'Grandma Kelly\'s Homestead'),
(4, 'Tokyo Traders'),
(5, 'Cooperativa de Quesos \'Las Cabras\''),
(6, 'Mayumi\'s'),
(7, 'Pavlova, Ltd.'),
(8, 'Specialty Biscuits, Ltd.'),
(9, 'PB Knäckebröd AB'),
(10, 'Refrescos Americanas LTDA'),
(11, 'Heli Süßwaren GmbH & Co. KG'),
(12, 'Plutzer Lebensmittelgroßmärkte AG'),
(13, 'Nord-Ost-Fisch Handelsgesellschaft mbH'),
(14, 'Formaggi Fortini s.r.l.'),
(15, 'Norske Meierier'),
(16, 'Bigfoot Breweries'),
(17, 'Svensk Sjöföda AB'),
(18, 'Aux joyeux ecclésiastiques'),
(19, 'New England Seafood Cannery'),
(20, 'Leka Trading'),
(21, 'Lyngbysild'),
(22, 'Zaanse Snoepfabriek'),
(23, 'Karkki Oy'),
(24, 'G\'day, Mate'),
(25, 'Ma Maison'),
(26, 'Pasta Buttini s.r.l.'),
(27, 'Escargots Nouveaux'),
(28, 'Gai pâturage'),
(29, 'Forêts d\'érables');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `categoria` (`categoria`),
  ADD KEY `proveedor` (`proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`proveedor`) REFERENCES `proveedores` (`id_proveedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
