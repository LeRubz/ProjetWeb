# ProjetWeb
Projet WEB 2025

test numéro 1


`-- Table USER
CREATE TABLE USER (
    ID_USER INT PRIMARY KEY AUTO_INCREMENT,
    NAME VARCHAR(20) NOT NULL,
    FIRSTNAME VARCHAR(20) NOT NULL,
    EMAIL VARCHAR(100) UNIQUE NOT NULL,
    TEL VARCHAR(20),
    PASSWORD VARCHAR(255) NOT NULL,
    ADMIN_STATUS ENUM('0', '1', '2')
);

-- Table ADDRESS
CREATE TABLE ADDRESS (
    ID_ADDRESS INT PRIMARY KEY AUTO_INCREMENT,
    COUNTRY VARCHAR(100),
    POSTAL_CODE VARCHAR(10),
    CITY VARCHAR(100),
    ROAD VARCHAR(255),
    NUM VARCHAR(10)
);

-- Table COMPANY
CREATE TABLE COMPANY (
    ID_COMPANY INT PRIMARY KEY AUTO_INCREMENT,
    NAME VARCHAR(100),
    DESCR TEXT,
    ID_ADDRESS INT,
    NB_OFFER INT DEFAULT 0,
    MIDDLE_AGES FLOAT,
    FOREIGN KEY (ID_ADDRESS) REFERENCES ADDRESS(ID_ADDRESS)
);

-- Table NOTE
CREATE TABLE NOTE (
    ID_NOTE INT PRIMARY KEY AUTO_INCREMENT,
    ID_COMPANY INT,
    ID_USER INT,
    ADV_PRV_PRO TINYINT,
    ADV_SALARY TINYINT,
    INTEGRATION TINYINT,
    FOREIGN KEY (ID_COMPANY) REFERENCES COMPANY(ID_COMPANY),
    FOREIGN KEY (ID_USER) REFERENCES USER(ID_USER)
);

-- Table OFFER
CREATE TABLE OFFER (
    ID_OFFER INT PRIMARY KEY AUTO_INCREMENT,
    ID_COMPANY INT,
    TITRE VARCHAR(255),
    DESCR TEXT,
    SALARY DECIMAL(10,2),
    CONTRACT VARCHAR(100),
    NB_VIEW INT DEFAULT 0,
    NB_POST INT DEFAULT 0,
    PUB_DATE DATE,
    DOMAIN_ACT VARCHAR(50),
    STATUT TINYINT(1) NOT NULL DEFAULT 0 CHECK (STATUT IN (0,1)),
    FOREIGN KEY (ID_COMPANY) REFERENCES COMPANY(ID_COMPANY)
);

-- Table WISHLIST
CREATE TABLE WISHLIST (
    ID_USER INT,
    ID_OFFER INT,
    POSTULE TINYINT(1) DEFAULT 0,
    PRIMARY KEY (ID_USER, ID_OFFER),
    FOREIGN KEY (ID_USER) REFERENCES USER(ID_USER),
    FOREIGN KEY (ID_OFFER) REFERENCES OFFER(ID_OFFER)
);