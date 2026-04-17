CREATE TABLE
    products (
        productId int(11) NOT NULL AUTO_INCREMENT,
        productName varchar(255) NOT NULL,
        productDescription text NOT NULL,
        productPrice decimal(10, 2) NOT NULL,
        productImgUrl varchar(255) NOT NULL,
        productStock int(11) NOT NULL DEFAULT 0,
        productStatus char(3) NOT NULL,
        productCategory varchar(100) NOT NULL DEFAULT 'GEN',
        PRIMARY KEY (productId)
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4