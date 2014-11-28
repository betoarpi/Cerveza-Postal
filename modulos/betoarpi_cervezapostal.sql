drop database if exists betoarpi_cervezapostal;
create database betoarpi_cervezapostal;

	use betoarpi_cervezapostal;



	create table Clientes	(NomClie	varchar		(40)not null,
					  		MailClie	varchar		(30)not null,
					  		EstClie		varchar		(20)not null);
	


	create table Pedido		(c1			varchar		(20)not null,
							c2			varchar		(20)not null,
							c3			varchar		(20)not null,
							c4			varchar		(20)not null,
							c5			varchar		(20)not null,
							c6			varchar		(20)not null,
							PrecioPedi	float		(9) not null,
							MailPedi	varchar		(30)not null);



		
	/*Creacion de las tablas iniciales

	Base de Datos
	base de datos: betoarpi_cervezapostal
	usr: betoarpi_startup
	psswd: StartupWknd2014
*/
