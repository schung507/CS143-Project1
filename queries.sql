-- Answers to database query questions

-- Names of all the actors in 'Die Another Day'
SELECT concat(first, " ", last)
FROM Actor, Movie, MovieActor
WHERE MovieActor.mid = Movie.id
		AND Actor.id = MovieActor.aid
		AND Movie.title = "Die Another Day";

-- Count of actors who are in multiple movies
SELECT count(*)
from (	
		SELECT aid
		FROM MovieActor
		GROUP BY aid
		HAVING count(*) > 1
		) T;

-- Title of movies that sells more than 1,000,000 tickets
SELECT title
FROM Movie, Sales
WHERE Movie.id = Sales.mid
		AND ticketsSold > 1000000;

-- Find the highest grossing film
SELECT title
FROM Movie, Sales
WHERE Movie.id = Sales.mid
		AND totalIncome > ALL (SELECT totalIncome
								FROM Sales s
								WHERE Sales.mid <> s.mid); -- make sure not to compare movie with itself

-- Count of number of female and male actors who directed and were in their own movies
SELECT Actor.sex, count(*)
FROM Actor, MovieDirector, MovieActor
WHERE MovieDirector.did = Actor.id
		AND MovieActor.aid = Actor.id
		AND MovieDirector.mid = MovieActor.mid
GROUP BY Actor.sex;