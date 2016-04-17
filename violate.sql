-- PRIMARY CONSTRAINTS

INSERT INTO Movie VALUES (9,'Zootopia',2016,'PG','Walt Disney');
-- there is already a movie with id 9 so this tuple is not unique

INSERT INTO Actor VALUES (10, 'Watson', 'Emma', 'Female', 1990-04-15, NULL);
-- there is already an actor with id 10 so this tuple is not unique

INSERT INTO Director VALUES (104, 'Spielberg', 'Steven', 1946-12-18, NULL);
-- there is already an actor with id 104 so this tuple is not unique

-- FOREIGN CONSTRAINTS

INSERT INTO Sales VALUES (10, 100, 5000);
-- All movies ids in Sales must reference an id in Movie but there is not Movie(id) = 10 

DELETE FROM Movie;
-- Movie genre references data Movie(id) so deleting all movies would violate constraint

INSERT INTO MovieDirector VALUES (9, 10);
-- All did's must reference Director(id) but there is no director with id 10

DELETE FROM Director;
-- MovieDirector table references Director(id) so deleteing all directors would violate constraint

DELETE FROM Actor;
-- MovieActor table references Actor(id) so deleting all actor violates constraint

INSERT INTO MovieActor VALUES (9, 3, 'Herself');
-- All aid's must reference Actor(id) but there is no actor with id 3

-- CHECKS

INSERT INTO Movie VALUES (9,'Zootopia',2020,'PG','Walt Disney');
-- 2020 is in the future which is not allowed

INSERT INTO Actor VALUES (3, 'Watson', 'Emma', 'Female', NULL, NULL);
-- dob cannot be null

UPDATE MovieRating SET imdb = 200 WHERE id = 272;
-- all ratings must be between 0 and 100 so a rating of 200 is invalid