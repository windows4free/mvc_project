-- ============================================================
-- Script: 04_ordenes.sql
-- Descripción: Tablas para el historial de compras
-- Ejecutar DESPUÉS de 03_products.sql
-- ============================================================

CREATE TABLE `ordenes` (
    `ordenId`       BIGINT(20)     NOT NULL AUTO_INCREMENT,
    `usercod`       BIGINT(10)     NOT NULL,
    `paypalOrderId` VARCHAR(128)   NOT NULL,
    `ordenFecha`    DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `ordenTotal`    DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
    `ordenEstado`   VARCHAR(20)    NOT NULL DEFAULT 'COMPLETADA',
    PRIMARY KEY (`ordenId`),
    KEY `idx_ordenes_user` (`usercod`),
    CONSTRAINT `fk_ordenes_usuario`
        FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE `detalle_ordenes` (
    `detId`         BIGINT(20)     NOT NULL AUTO_INCREMENT,
    `ordenId`       BIGINT(20)     NOT NULL,
    `productId`     INT(11)        NOT NULL,
    `productName`   VARCHAR(255)   NOT NULL,
    `productImgUrl` VARCHAR(255)   NOT NULL DEFAULT '',
    `detCantidad`   INT(11)        NOT NULL DEFAULT 1,
    `detPrecio`     DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
    PRIMARY KEY (`detId`),
    KEY `idx_detalle_orden` (`ordenId`),
    CONSTRAINT `fk_detalle_ordenes`
        FOREIGN KEY (`ordenId`) REFERENCES `ordenes` (`ordenId`)
        ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
