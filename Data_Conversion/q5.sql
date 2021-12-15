SELECT COUNT(DISTINCT awardYear)
FROM AwardedPrizes A
WHERE A.id IN (
    SELECT id
    FROM Organization
);