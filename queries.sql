--Answers to database query questions--

--Names of all the actors in 'Die Another Day'--
SELECT concat(first, " ", last)
FROM Actor, Movie, MovieActor
WHERE Actor.id = MovieActor.aid
		and Movie.title = "Die Another Day"

--Count of actors who are in multiple movies--
SELECT count(*)
from (	
		SELECT aid
		FROM MovieActor
		GROUP BY aid
		HAVING count(*) > 1
		)

--Title of movie that sells more than 1,000,000 tickets--
SELECT title
FROM Movie, Sales
WHERE Movie.id = Sales.mid
		and
		ticketsSold > 1000000