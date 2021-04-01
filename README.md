# E-learning
create table salle (id_salle int primary key , salle varchar(20), type varchar(20) , check(type in ('TD','COURS,'TP'));
CREATE TABLE spécialité ( id_spec int primary key , nom varchar (20));
CREATE TABLE année ( id_année int primary key , année varchar (20));
create table niveau (id_niv int PRIMARY key , id_spec int , FOREIGN KEY(id_spec) REFERENCES spécialité(id_spec),id_année int , FOREIGN KEY(id_année) REFERENCES année(id_année));
create table groupe (id_groupe int PRIMARY key , nomGroupe varchar(30),id_niv int , FOREIGN KEY(id_niv) REFERENCES niveau(id_niv));
CREATE TABLE enseignant (id_ens int PRIMARY KEY not null , nom varchar(20) not null , prénom varchar(20) not null , date_naissance date , 
                         grade varchar(20) NOT null );
CREATE TABLE module ( id_mod int PRIMARY key , nom varchar(20) not null , id_ens int , id_niv int , FOREIGN KEY(id_ens) REFERENCES enseignant(id_ens)
                     , FOREIGN KEY(id_niv) REFERENCES niveau(id_niv));
create table etudiant ( id_etud int primary key , nom varchar(20) not null ,prénom varchar(20) not null ,date_naissance date not null , id_groupe int , FOREIGN KEY (id_groupe) REFERENCES groupe (id_groupe));
create table séance ( id_séance int PRIMARY key , type varchar(10) not null , jour varchar (20) not null ,
                     heure_debut time not null ,
                     heure_fin time not null ,
                     id_mod int ,
                     id_groupe int ,
                     FOREIGN key (id_mod) REFERENCES module (id_mod),
                     FOREIGN KEY (id_groupe) REFERENCES groupe (id_groupe));

