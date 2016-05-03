CREATE TABLE Movie (
	id INT NOT NULL, 
	-- id cannot be null
	title VARCHAR(100),
	year INT,
	rating VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY (id), 
	-- movie id must be uniqe
	CHECK(year <= 2016) 
	-- movie cannot be released in the future
)ENGINE = INNODB;

CREATE TABLE Actor (
	id INT NOT NULL,
	last VARCHAR(20),
	first VARCHAR(20),
	sex VARCHAR(6),
	dob DATE,
	dod DATE,
	PRIMARY KEY (id), -- actor id is unique among actors
	CHECK (dob IS NOT NULL) -- actor must have dob
)ENGINE = INNODB;

CREATE TABLE Sales (
	mid INT,
	ticketsSold INT,
	totalIncome INT,
	-- movie id must refer to actual movie in Movie
	FOREIGN KEY (mid) references Movie(id) 
) ENGINE=INNODB;

CREATE TABLE Director (
	id INT NOT NULL,
	last VARCHAR(20),
	first VARCHAR(20),
	dob DATE,
	dod DATE,
	PRIMARY KEY (id)
)ENGINE = INNODB;

CREATE TABLE MovieGenre (
	mid INT,
	genre VARCHAR(20),
	-- movie id must refer to actual movie in Movie
	FOREIGN KEY (mid) references Movie(id) 

)ENGINE=INNODB;

CREATE TABLE MovieDirector (
	mid INT,
	did INT,
	-- movie id must refer to actual movie in Movie
	FOREIGN KEY (mid) references Movie(id),
	-- director id must refer to actual director
	FOREIGN KEY (did) references Director(id)
) ENGINE=INNODB;

CREATE TABLE MovieActor (
	mid INT,
	aid INT,
	role VARCHAR(50),
	-- movie id must refer to actual movie in Movie
	FOREIGN KEY (mid) references Movie(id),
	-- actor id must refer to actual actor
	FOREIGN KEY (aid) references Actor(id)
) ENGINE=INNODB;

CREATE TABLE MovieRating (
	mid INT,
	imdb INT,
	rot INT,
	-- make sure ratings are between 0 and 100 as specified in spec
	CHECK(imdb >= 0 AND imdb <= 100),
	CHECK(rot >= 0 AND rot <= 100)
)ENGINE = INNODB;

CREATE TABLE Review (
	name VARCHAR(20),
	time TIMESTAMP,
	mid INT,
	rating INT,
	comment VARCHAR(500)
)ENGINE = INNODB;

CREATE TABLE MaxPersonID (
	id INT
)ENGINE = INNODB;

CREATE TABLE MaxMovieID (
	id INT
)ENGINE = INNODB;