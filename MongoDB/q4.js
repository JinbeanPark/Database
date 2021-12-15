db.laureates.aggregate([
    {$unwind : "$nobelPrizes"},
    {$unwind : "$nobelPrizes.affiliations"},
    {$match : {"nobelPrizes.affiliations.name.en" : "University of California"}},
    {$group : {_id : "$nobelPrizes.affiliations.city.en", count: {$sum: 1}}},
    {$group : {_id : null, count: {$sum: 1}}},
    {$project : {_id: 0, locations : '$count'}}
]).pretty()