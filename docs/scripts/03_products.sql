CREATE TABLE 'products' (
    'productId' INT(11) NOT NULL AUTO_INCREMENT,
    'productName' VARCHAR(255) NOT NULL,
    'productDescription' TEXT NOT NULL,
    'productPrice' DECIMAL(10,2) NOT NULL,
    'productImgUrl' VARCHAR(255) NOT NULL,
    'productStock' INT(11) NOT NULL DEFAULT 0,
    'productStatus' CHAR(3) NOT NULL,
    PRIMARY KEY ('productId')
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

-- if using pexels images: ?w=290&h=250