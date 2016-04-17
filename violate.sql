-- PRIMARY CONSTRAINTS

INSERT INTO Movie VALUES (9,'Zootopia',2016,'PG','Walt Disney');
-- there is already a movie with id 9 so this tuple is not unique, violates primary key constraint
-- Output: ERROR 1062 (23000): Duplicate entry '9' for key 'PRIMARY'

INSERT INTO Actor VALUES (10, 'Watson', 'Emma', 'Female', 1990-04-15, NULL);
-- there is already an actor with id 10 so this tuple is not unique
-- Output: ERROR 1062 (23000): Duplicate entry '10' for key 'PRIMARY'

INSERT INTO Director VALUES (104, 'Spielberg', 'Steven', 1946-12-18, NULL);
-- there is already an actor with id 104 so this tuple is not unique, violates primary key constraint
-- Output: ERROR 1062 (23000): Duplicate entry '104' for key 'PRIMARY'

-- FOREIGN CONSTRAINTS

INSERT INTO Sales VALUES (10, 100, 5000);
-- All movies ids in Sales must reference an id in Movie but there is not Movie(id) = 10 
-- Output: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails
--								('CS143', 'Sales', CONSTRAINT 'Sales_ibfk_1' FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))

DELETE FROM Movie;
-- Movie genre references data Movie(id) so deleting all movies would violate constraint
-- Output: ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails
-- 								('CS143', 'Sales', CONSTRAINT 'Sales_ibfk_1' FOREIGN KEY ('mid') REFERENCES 'Movie' ('id'))

INSERT INTO MovieDirector VALUES (9, 10);
-- All did's must reference Director(id) but there is no director with id 10
-- Output: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails
--								('CS143', 'MovieDirector', CONSTRAINT 'MovieDirector_ibfk_2' FOREIGN KEY ('did') REFERENCES 'Director' ('id'))

DELETE FROM Director;
-- MovieDirector table references Director(id) so deleteing all directors would violate constraint
-- Output: ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails
--								('CS143', 'MovieDirector', CONSTRAINT 'MovieDirector_ibfk_2' FOREIGN KEY ('did') REFERENCES 'Director' ('id'))

DELETE FROM Actor;
-- MovieActor table references Actor(id) so deleting all actor violates constraint
-- Output: ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails
--								('CS143', 'MovieActor', CONSTRAINT 'MovieActor_ibfk_2' FOREIGN KEY ('aid') REFERENCES 'Actor' ('id'))


INSERT INTO MovieActor VALUES (9, 3, 'Herself');
-- All aid's must reference Actor(id) but there is no actor with id 3
-- All did's must reference Director(id) but there is no director with id 10
-- Output: ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint fails
--								('CS143', 'MovieActor', CONSTRAINT 'MovieActor_ibfk_2' FOREIGN KEY ('aid') REFERENCES 'Actor' ('id'))

-- CHECKS

INSERT INTO Movie VALUES (9,'Zootopia',2020,'PG','Walt Disney');
-- 2020 is in the future which is not allowed

INSERT INTO Actor VALUES (3, 'Watson', 'Emma', 'Female', NULL, NULL);
-- dob cannot be null

UPDATE MovieRating SET imdb = 200 WHERE id = 272;
-- all ratings must be between 0 and 100 so a rating of 200 is invalid