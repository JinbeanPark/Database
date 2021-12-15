db.laureates.aggregate([
    {$unwind : "$nobelPrizes"},
    {$match : {givenName : {"$exists" : false}}},
    {$group : {_id : "$nobelPrizes.awardYear", count: {$sum: 1}}},
    {$group : {_id : null, count: {$sum: 1}}},
    {$project : {_id: 0, years : '$count'}}
]).pretty()