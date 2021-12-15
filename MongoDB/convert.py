import json

with open("/home/cs143/data/nobel-laureates.json") as file:
    fileData = json.load(file)

for obj in fileData["laureates"]:
    textFile = open("laureates.import", "a")
    textFile.write(json.dumps(obj) + "\n")
    textFile.close()