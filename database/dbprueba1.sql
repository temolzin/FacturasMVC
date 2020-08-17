CREATE DATABASE dbprueba1;

USE dbprueba1;

CREATE TABLE clientes(
	cli_id int primary key auto_increment,
	cli_rfc varchar(20),
	cli_nombre varchar(255)
);

CREATE TABLE monedas(
	mon_id int primary key auto_increment,
	mon_abr varchar(20),
	mon_nombre varchar(255)
);

CREATE TABLE facturas(
	fac_id int primary key auto_increment,
	cli_id int,
	mon_id int,
	fac_fec date,
	fac_sub decimal(9,2),
	fac_iva int,
	fac_tot decimal(9,2),
	fac_tc varchar(100),
	foreign key (cli_id) references clientes(cli_id),
	foreign key (mon_id) references monedas(mon_id)
);

CREATE TABLE facturas_detalle(
	fac_id int,
	fac_det_id int,
	fac_det_can int,
	fac_det_pun decimal(9,2),
	fac_det_imp decimal(9,2),
	fac_det_con varchar(255),
	primary key (fac_id, fac_det_id),
	foreign key (fac_id) references facturas(fac_id)
);

/*Se hace la inserción de los 3 registros para el cliente*/
INSERT INTO clientes VALUES(
	null,
	'ROPT998800NN1',
	'Temolzin Roldan'
);
INSERT INTO clientes VALUES(
	null,
	'MORM910201AA1',
	'Monserratt Redonda'
);
INSERT INTO clientes VALUES(
	null,
	'GACE900103EEO',
	'Emmanuel Contreras'
);

/*Se hace la inserción de los registros para la tabla moneda*/
INSERT INTO monedas VALUES(
	null,
	"MXN",
	"Peso Mexicano"
);
INSERT INTO monedas VALUES(
	null,
	"USD",
	"Dolar Americano"
);