SELECT DISTINCT first, last
FROM Actor A
WHERE A.id IN (
    SELECT DISTINCT aid
    FROM MovieActor MA
    WHERE MA.mid IN (
        SELECT DISTINCT id
        FROM Movie M
        WHERE M.title = 'Die Another Day'
    )
);