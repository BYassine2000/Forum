
Drop database if exists forum;
Create database forum;
Use forum;

Drop table if exists users;
Create table if not exists users (
	id_u int(11) not null auto_increment,
	pseudo varchar(15) UNIQUE,
	email varchar(255) UNIQUE,
	mdp varchar(255),
	lvl int not null default 1,
	primary key (id_u)
) Engine=InnoDB;

Insert into users values
(1, "yassineadmin", "admin@gmail.com", "107d348bff437c999a9ff192adcb78cb03b8ddc6", 3),
(2, "yassineodo", "modo@gmail.com", "107d348bff437c999a9ff192adcb78cb03b8ddc6", 2),
(3, "yassineuser", "user@gmail.com", "107d348bff437c999a9ff192adcb78cb03b8ddc6", 1);

Drop table if exists category;
Create table if not exists category (
	id_cat int(11) not null auto_increment,
	titre_cat varchar(50),
	lien_cat varchar(50),
	primary key (id_cat)
) Engine=InnoDB;

Insert into category values
(1, "Jeux-vidéos", "jeux-videos"),
(2, "Informatiques", "informatiques");

Drop table if exists topics;
Create table if not exists topics (
	id_t int(11) not null auto_increment,
	id_cat int not null,
	titre_top varchar(50),
	description text,
	primary key(id_t),
	foreign key (id_cat) references category (id_cat)
) Engine=InnoDB;

Create or replace view viewTopics as (
	SELECT t.id_t, c.titre_cat, t.titre_top, t.description
	FROM category c, topics t
	WHERE c.id_cat = t.id_t
);

Create or replace view viewTopics (id_t, id_cat, titre_top, description) as 
    SELECT t.id_t, c.titre_cat, t.titre_top, t.description
    FROM topics t, category c
    WHERE c.id_cat = t.id_t;

Insert into topics values
(1, 1, "Topic-1", "Vie scolaire"),
(2, 2, "Topic-2", "Cours municipaux adultes");

Drop table if exists posts;
Create table if not exists posts (
	id_p int(11) not null auto_increment,
	contenu text,
	date_p date,
	heure_p time,
	id_u int,
	id_t int,
	primary key (id_p),
	foreign key (id_u) references users (id_u),
	foreign key (id_t) references topics (id_t)
) Engine=InnoDB;

Create or replace view viewPosts as (
	SELECT c.titre_cat, t.description, p.contenu, p.date_p, p.heure_p
	FROM users u, topics t, posts p, category c
	WHERE u.id_u = p.id_p AND c.id_cat = p.id_p AND t.id_t = p.id_p
);

Insert into posts values
(1, "Le developpement durable", "2020-10-10", "10:10:00", 1, 1),
(2, "Emploi et jeunesse", "2020-08-07", "15:30", 2, 2);
