<?php
# get the id parameter from the request
$id = intval($_GET['id']);

# set the Content-Type header to JSON, so that the client knows that we are returning a JSON data
header('Content-Type: application/json');

$db = new mysqli('localhost', 'cs143', '', 'cs143');
if ($db -> connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$query1 = "SELECT O.id, O.orgName, O.foundedDate, O.foundedCity, O.foundedCountry, A.awardYear, A.category, A.sortOrder, A.portion, A.prizeStatus, A.dateAwarded, A.motivation, A.prizeAmount, A.affiliationName, A.affiliationCity, A.affiliationCountry
FROM AwardedPrizes A, Organization O
WHERE $id IN (
    SELECT id
    FROM Organization
) AND $id = O.id
AND A.id = O.id";

$query2 = "SELECT P.id, P.givenName, P.familyName, P.gender, P.birthDate, P.birthCity, P.birthCountry, A.awardYear, A.category, A.sortOrder, A.portion, A.prizeStatus, A.dateAwarded, A.motivation, A.prizeAmount, A.affiliationName, A.affiliationCity, A.affiliationCountry
FROM AwardedPrizes A, People P
WHERE $id IN (
    SELECT id
    FROM People
) AND $id = P.id
AND A.id = P.id";


$chkOrg = true;

$searchedTuples = $db->query($query1);
if (mysqli_num_rows($searchedTuples) == 0) {
    $chkOrg = false;
    $searchedTuples = $db->query($query2);
    if (!$searchedTuples) {
        $errmsg = $db->error;
        print "Query failed: $errmsg <br>";
        exit(1);
    }
}

$row = $searchedTuples->fetch_assoc();
if (!$chkOrg) {
    $peoID = $row['id'];
    $peoGivenName = $row['givenName'];
    $peoFamilyName = $row['familyName'];
    $peoGender = $row['gender'];
    $birthDate = $row['birthDate'];
    $birthCity = $row['birthCity'];
    $birthCountry = $row['birthCountry'];
    $awardYear = $row['awardYear'];
    $category = $row['category'];
    $sortOrder = $row['sortOrder'];
    $portion = $row['portion'];
    $prizeStatus = $row['prizeStatus'];
    $dateAwarded = $row['dateAwarded'];
    $motivation = $row['motivation'];
    $prizeAmount = $row['prizeAmount'];
    $affiliationName = $row['affiliationName'];
    $affiliationCity = $row['affiliationCity'];
    $affiliationCountry = $row['affiliationCountry'];
}
else {
    $orgID = $row['id'];
    $orgName = $row['orgName'];
    $orgFoundedDate = $row['foundedDate'];
    $orgFoundedCity = $row['foundedCity'];
    $orgFoundedCountry = $row['foundedCountry'];
    $awardYear = $row['awardYear'];
    $category = $row['category'];
    $sortOrder = $row['sortOrder'];
    $portion = $row['portion'];
    $prizeStatus = $row['prizeStatus'];
    $dateAwarded = $row['dateAwarded'];
    $motivation = $row['motivation'];
    $prizeAmount = $row['prizeAmount'];
    $affiliationName = $row['affiliationName'];
    $affiliationCity = $row['affiliationCity'];
    $affiliationCountry = $row['affiliationCountry'];
}


if ($chkOrg) {
    $jsonData = array("id"=>$orgID, "orgName"=>array("en"=>$orgName), 
    "founded"=>array("date"=>$orgFoundedDate, "place"=>array("city"=>array("en"=>$orgFoundedCity), "country"=>array("en"=>$orgFoundedCountry))),
    "nobelPrizes"=>array(array("awardYear"=>$awardYear, "category"=>array("en"=>$category), 
    "sortOrder"=>$sortOrder, "portion"=>$portion, "prizeStatus"=>$prizeStatus, 
    "dateAwarded"=>$dateAwarded, "motivation"=>array("en"=>$motivation), 
    "prizeAmount"=>$prizeAmount, 
    "affiliations"=>array(array("name"=>array("en"=>$affiliationName), 
    "city"=>array("en"=>$affiliationCity), "country"=>array("en"=>$affiliationCountry))))));
}
else {
    $jsonData = array("id"=>$peoID, "givenName"=>array("en"=>$peoGivenName), 
    "familyName"=>array("en"=>$peoFamilyName), "gender"=>$peoGender, 
    "birth"=>array("date"=>$birthDate, "place"=>array("city"=>array("en"=>$birthCity),
    "country"=>array("en"=>$birthCountry))),
    "nobelPrizes"=>array(array("awardYear"=>$awardYear, "category"=>array("en"=>$category), 
    "sortOrder"=>$sortOrder, "portion"=>$portion, "prizeStatus"=>$prizeStatus, 
    "dateAwarded"=>$dateAwarded, "motivation"=>array("en"=>$motivation), 
    "prizeAmount"=>$prizeAmount, 
    "affiliations"=>array(array("name"=>array("en"=>$affiliationName), 
    "city"=>array("en"=>$affiliationCity), "country"=>array("en"=>$affiliationCountry))))));
}
$searchedTuples->free();
echo json_encode($jsonData);
$db->close();
?>
