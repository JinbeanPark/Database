#!/usr/bin/python
# dummy code for the converter in Python
import json

path = "/home/cs143/data/nobel-laureates.json"
with open(path, "r", encoding='utf-8') as nobelJson:
    nobelInfo = json.load(nobelJson)

for laurea, winner in nobelInfo.items():
    for orgPeo in winner:
        loadTuple = ''
        if "orgName" in orgPeo:
            orgID = orgPeo["id"]
            orgName = orgPeo["orgName"]["en"]
            if "founded" in orgPeo:
                foundedDate = orgPeo["founded"]["date"]
            else:
                foundedDate = "\\N"
            if "founded" in orgPeo and "city" in orgPeo["founded"]["place"]:
                foundedCity = orgPeo["founded"]["place"]["city"]["en"]
                foundedCountry = orgPeo["founded"]["place"]["country"]["en"]
            else:
                foundedCity = "\\N"
                foundedCountry = "\\N"
            loadTuple = orgID + "@" + orgName + "@" + foundedDate + "@" + foundedCity + "@" + foundedCountry
            textFile = open("organization.del", "a")
            textFile.write(loadTuple + "\n")
            textFile.close()
            
            for nobelPrize in orgPeo["nobelPrizes"]:
                awardYear = nobelPrize["awardYear"]
                category = nobelPrize["category"]["en"]
                sortOrder = nobelPrize["sortOrder"]
                portion = nobelPrize["portion"]
                prizeStatus = nobelPrize["prizeStatus"]
                dateAwarded = nobelPrize["dateAwarded"]
                motivation = nobelPrize["motivation"]["en"]
                prizeAmount = nobelPrize["prizeAmount"]
                orgAffName = "\\N"
                orgAffCity = "\\N"
                orgAffCountry = "\\N"
                if "affiliations" in nobelPrize:
                    for affiliation in nobelPrize["affiliations"]:
                        orgAffName = affiliation["name"]["en"]
                        if "city" in affiliation:
                            orgAffCity = affiliation["city"]["en"]
                            orgAffCountry = affiliation["country"]["en"]
                loadTuple = orgID + "@" + awardYear + "@" + category + "@" + sortOrder + "@" + portion + "@" + prizeStatus + "@" + dateAwarded + "@" + motivation + "@" + str(prizeAmount) + "@" + orgAffName + "@" + orgAffCity + "@" + orgAffCountry
                textFile = open("AwardedPrizes.del", "a")
                textFile.write(loadTuple + "\n")
                textFile.close()
        else:
            peoID = orgPeo["id"]
            peoGivenName = orgPeo["givenName"]["en"]
            if "familyName" in orgPeo:
                peoFamilyName = orgPeo["familyName"]["en"]
            else:
                peoFamilyName = "NA"
            
            peoGender = orgPeo["gender"]
            
            if "birth" in orgPeo:
                peoBirDate = orgPeo["birth"]["date"]
            else:
                peoBirDate = "\\N"
            if "birth" in orgPeo and "city" in orgPeo["birth"]["place"]:
                peoBirCity = orgPeo["birth"]["place"]["city"]["en"]
                peoBirCountry = orgPeo["birth"]["place"]["country"]["en"]
            else:
                peoBirCity = "\\N"
                peoBirCountry = "\\N" 
            loadTuple = peoID + "@" + peoGivenName + "@" + peoFamilyName + "@" + peoGender + "@" + peoBirDate + "@" + peoBirCity + "@" + peoBirCountry
            textFile = open("people.del", "a")
            textFile.write(loadTuple + "\n")
            textFile.close()
            
            for nobelPrize in orgPeo["nobelPrizes"]:
                peoAwardYear = nobelPrize["awardYear"]
                peoCategory = nobelPrize["category"]["en"]
                peoSortOrder = nobelPrize["sortOrder"]
                peoPortion = nobelPrize["portion"]
                peoPrizeStatus = nobelPrize["prizeStatus"]
                if "dateAwarded" in nobelPrize:
                    peoDateAwarded = nobelPrize["dateAwarded"]
                else:
                    peoDateAwarded = "\\N"
                peoMotivation = nobelPrize["motivation"]["en"]
                peoPrizeAmount = nobelPrize["prizeAmount"]
                if "affiliations" in nobelPrize:
                    for affiliation in nobelPrize["affiliations"]:
                        peoAffName = affiliation["name"]["en"]
                        if "city" in affiliation:
                            peoAffCity = affiliation["city"]["en"]
                            peoAffCountry = affiliation["country"]["en"]
                        else:
                            peoAffCity = "\\N"
                            peoAffCountry = "\\N"
                else:
                    peoAffName = "\\N"
                    peoAffCity = "\\N"
                    peoAffCountry = "\\N"                    
                loadTuple = peoID + "@" + peoAwardYear + "@" + peoCategory + "@" + peoSortOrder + "@" + peoPortion + "@" + peoPrizeStatus + "@" + peoDateAwarded + "@" + peoMotivation + "@" + str(peoPrizeAmount) + "@" + peoAffName + "@" + peoAffCity + "@" + peoAffCountry
                textFile = open("AwardedPrizes.del", "a")
                textFile.write(loadTuple + "\n")
                textFile.close()