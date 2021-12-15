db.laureates.aggregate (
    {$match: {$and: [{"givenName.en" : 'Marie'}, {"familyName.en" : 'Curie'}]}},
    {$limit : 1},
    {$project: {"_id" : 0, "id" : 1}}
).pretty()