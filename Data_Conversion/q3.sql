SELECT P.familyName
FROM People P, AwardedPrizes A
WHERE P.id = A.id
GROUP BY P.familyName
HAVING COUNT(*) >= 5;