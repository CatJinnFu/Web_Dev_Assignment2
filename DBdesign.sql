ALTER TABLE Products_Ordered DROP CONSTRAINT Order_ID_FK;
ALTER TABLE Products_Ordered DROP CONSTRAINT Product_ID_FK;
ALTER TABLE Products_Ordered DROP CONSTRAINT PK_Products_Ordered;
ALTER TABLE Orders DROP CONSTRAINT FK_UserOrder;

DROP TABLE Products_Ordered;
DROP TABLE Products;
DROP TABLE Users;
DROP TABLE Orders;

CREATE TABLE Products
     ( Product_ID NUMBER GENERATED ALWAYS as IDENTITY(START with 1 INCREMENT by 1), 
       Gender VARCHAR2(10), 
       Type VARCHAR2(20),
       Id VARCHAR(10),
       product VARCHAR(100), 
       brand VARCHAR2(100), 
       price VARCHAR2(100), 
       details VARCHAR2(500), 
       material VARCHAR2(500), 
       csize VARCHAR2(500),
       description VARCHAR2(500),
       photo_one VARCHAR2(100),
       photo_two VARCHAR2(100),
       Primary key (Product_ID) 
     ); 





CREATE TABLE Users
     ( User_ID  NUMBER GENERATED ALWAYS as IDENTITY(START with 1 INCREMENT by 1),
       password VARCHAR2(25), 
       firstname VARCHAR2(25),
       lastname VARCHAR2(25),
       address VARCHAR2(25),
       state VARCHAR2(25),
       country VARCHAR2(25),
       postcode VARCHAR2(25),  
       phone VARCHAR2(25), 
       email VARCHAR2(40), 
       Primary key (User_ID)
     ); 


CREATE TABLE Orders
     ( 	
       Order_ID NUMBER GENERATED ALWAYS as IDENTITY(START with 1 INCREMENT by 1),
       User_ID Number(4),
       Status VARCHAR2(25),
       Order_Date VARCHAR2(25),
       Total VARCHAR2(25),
       CONSTRAINT FK_UserOrder FOREIGN KEY (User_ID) REFERENCES Users(User_ID),
       Primary key (Order_ID)
     ); 




CREATE TABLE Products_Ordered
     ( 	
       Order_ID Number(6) NOT NULL,
       Product_ID Number(4) NOT NULL,
       Qty Number(6), 
       Total VARCHAR2(25),
       CONSTRAINT Order_ID_FK FOREIGN KEY (Order_ID) REFERENCES Orders(Order_ID),
       CONSTRAINT Product_ID_FK FOREIGN KEY (Product_ID) REFERENCES Products(Product_ID),
       CONSTRAINT PK_Products_Ordered PRIMARY KEY (Order_ID,Product_ID)
     ); 


	


