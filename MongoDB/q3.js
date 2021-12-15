db.laureates.aggregate([
    {$group : {_id : "$familyName.en", count: { $sum : 1}}},
    {$match : { $and: [ {count : {$gt : 4}}, {"_id" : {"$ne" : null}}]}},
    {$project : {_id: 0, familyName : "$_id"}}
]).pretty()