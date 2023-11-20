create table kunde (
    id int(11) not null auto_increment primary key,
    name varchar(255) not null,
    anrede varchar(255),
    strasse varchar(255),
    hausnummer int(20),
    plz varchar(255),
    ort varchar(255),
    telefon varchar(255),
    email varchar(255)
);