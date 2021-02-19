CREATE DATABASE shopMA; -- Create database
use shopMA; -- Use database

-- Create table for users
CREATE TABLE Users(
	UserId INT PRIMARY KEY AUTO_INCREMENT,
    UName VARCHAR(20),
    Phone VARCHAR(30),
    Address VARCHAR(50),
    Email VARCHAR(50),
    Pass VARCHAR(20)
);

-- Get from Users
SELECT * FROM Users;

-- Insert Users
INSERT INTO Users VALUES(1, 'Milena', '7485963', 'Somewhere close', 'mimi@dk.dk', 'myPass788!');
INSERT INTO Users VALUES(2, 'Admin', '7485963', 'Somewhere closer', 'admin@dk.dk', 'myAdminPass23!');

-- Delete from Users
DELETE FROM Users WHERE UserId=10;

-- Delete table
DROP TABLE Users;

----------------------------------------------------------------------------------------------------------------------------------------------

-- Create table for Products
CREATE TABLE Products(
	ProductId INT PRIMARY KEY AUTO_INCREMENT,
	PName VARCHAR(20),
    PDes VARCHAR(150),
    Price VARCHAR(10),
    Image VARCHAR(1000),
    menu_id INT NOT NULL,
	FOREIGN KEY (menu_id) REFERENCES menu(menu_id)
);

-- Get from Products
SELECT * FROM Products;
SELECT * FROM Products WHERE CategoryName = 'SubBeauty';
SELECT ProductId, PName, PDes, Price FROM Products;
SELECT ProductId, PName, PDes, Price FROM Products WHERE ParentId = 2;

-- Insert into Products
INSERT INTO Products(ParentId, CategoryName) VALUES(0, 'Health');
INSERT INTO Products(ParentId, CategoryName) VALUES(0, 'Beauty');
INSERT INTO Products(ParentId, CategoryName) VALUES(0, 'Leisure');

INSERT INTO Products VALUES(1, 'Watter bottle', 'A very nice bottle', '10', 'https://sw21257.smartweb-static.com/upload_dir/shop/24_bottles_clima_termo_drikkedunk_rustfrit_staal_lush_500ml.w610.h610.fill.png', 6);
INSERT INTO Products VALUES(2, 'Face roller', 'That is an amazing face roller', '15', 'https://rosequartzrepublic.com/wp-content/uploads/2019/08/rose-quartz-roller.jpg', 5);
INSERT INTO Products VALUES(3, 'Hydrating mask', 'Face mask for tired face', '5', 'https://i5.walmartimages.ca/images/Large/017/689/6000198017689.jpg', 4);

-- Select from sub menu
SELECT ParentId, CategoryName FROM Products;

-- Delete Products
DELETE FROM Products WHERE ProductId=2;

-- Update products 
UPDATE Products SET PName='mimi', Image='image', Price= '10', PDes='heeey' WHERE ProductId=1;

-- Delete table
DROP TABLE Products;

----------------------------------------------------------------------------------------------------------------------------------------------
-- Create menu table
CREATE TABLE menu(
  menu_id int(11) PRIMARY KEY AUTO_INCREMENT,
  menu_name varchar(255) NOT NULL,
  parent_id int(11) NOT NULL DEFAULT '0' COMMENT '0',
  link varchar(255) NOT NULL,
  status enum('0','1') NOT NULL DEFAULT '1' COMMENT '0'
);

-- Insert MAIN categories for menu
INSERT INTO menu (menu_id, menu_name, parent_id, link, status) VALUES
(1, 'Beauty', 0, '#beauty', '1'),
(2, 'Health', 0, '#health', '1'),
(3, 'Leisure', 0, '#leisure', '1');

-- Insert subCategories for menu
INSERT INTO `menu` (`menu_id`, `menu_name`, `parent_id`, `link`, `status`) VALUES
(4, 'Face masks', 1, '#', '1'), -- 1 goes in Beauty (0), but if you want in Health, you put 2
(5, 'Face rollers', 2, '#', '1'),
(6, 'Bottles', 3, '#', '1');

-- Get all from menu
Select * from menu;

-- Delete menu table
DROP TABLE menu;