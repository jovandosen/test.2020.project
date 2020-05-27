<?php

function getUserList()
{
	$dataSetOne = file('files/comma.txt');

	$users = [];

	foreach ($dataSetOne as $key => $value) {

		$details = explode(",", $value);

		$user = new stdClass();

		$user->firstName = trim($details[1]);
		$user->lastName = trim($details[0]);
		$user->gender = trim($details[2]);
		$user->favoriteColor = trim($details[3]);
		$user->dateOfBirth = trim($details[4]);

		$users[] = $user;
	}

	$dataSetTwo = file('files/pipe.txt');

	foreach ($dataSetTwo as $key => $value) {
		
		$detailsTwo = explode("|", $value);

		if( trim($detailsTwo[3]) == 'M' ){
			$userGender = 'Male';
		} else {
			$userGender = 'Female';
		}

		$userDateOfBirth = str_replace("-", "/", trim($detailsTwo[5]));

		$user = new stdClass();

		$user->firstName = trim($detailsTwo[0]);
		$user->lastName = trim($detailsTwo[1]);
		$user->gender = $userGender;
		$user->favoriteColor = trim($detailsTwo[4]);
		$user->dateOfBirth = $userDateOfBirth;

		$users[] = $user;
	}

	$dataSetThree = file('files/space.txt');

	foreach ($dataSetThree as $key => $value) {
		
		$detailsThree = explode(" ", $value);

		if( trim($detailsThree[3]) == 'F' ){
			$userGenderData = 'Female';
		} else {
			$userGenderData = 'Male';
		}

		$userBirthDate = str_replace("-", "/", trim($detailsThree[4]));

		$user = new stdClass();

		$user->firstName = trim($detailsThree[1]);
		$user->lastName = trim($detailsThree[0]);
		$user->gender = $userGenderData;
		$user->favoriteColor = trim($detailsThree[5]);
		$user->dateOfBirth = $userBirthDate;

		$users[] = $user;
	}

	return $users;
}

function sortLogic($items)
{
	$dataPartOne = $dataPartTwo = [];

	if( count($items) < 2 ){
		return $items;
	}

	$firstItemKey = key($items);

	$firstItemValue = array_shift($items);

	foreach ($items as $item) {

		if( $item <= $firstItemValue ){
			$dataPartOne[] = $item;
		} elseif( $item > $firstItemValue ){
			$dataPartTwo[] = $item;
		}

	}

	return array_merge( sortLogic($dataPartOne), array($firstItemKey=>$firstItemValue), sortLogic($dataPartTwo) );
}

function sortByDateOfBirth()
{
	$users = getUserList();

	$years = [];

	foreach ($users as $user) {
		$date = $user->dateOfBirth;
		$dateData = explode("/", $date);
		$year = end($dateData);
		$years[] = (int) $year;
	}

	$sortedYears = sortLogic($years);

	$userList = [];

	$checkYears = [];

	$checkNames = [];

	foreach ($sortedYears as $key => $value) {
		
		foreach ($users as $k => $v) {
			
			$userDateValue = $v->dateOfBirth;

			$userDateData = explode("/", $userDateValue);

			$yearValue = end($userDateData);

			$yearValue = (int) $yearValue;

			if( $value === $yearValue ){

				if( ! in_array($yearValue, $checkYears) ){

					$checkYears[] = $yearValue;

					$checkNames[] = $v->firstName;

					$userList[] = $v;

					break;

				} else {

					if( ! in_array($v->firstName, $checkNames) ){

						$checkNames[] = $v->firstName;

						$userList[] = $v;

						break;

					}

				}

			}

		}

	}

	return $userList;
}

function sortByLastName()
{
	$users = getUserList();

	$lastNames = [];

	foreach ($users as $user) {
		$lastNames[] = $user->lastName;
	}

	$sortedLastNames = sortLogic($lastNames);

	$sortedLastNames = array_reverse($sortedLastNames);

	$userList = [];

	foreach ($sortedLastNames as $userLastName) {
		
		foreach ($users as $userRecord) {
			
			if( $userLastName == $userRecord->lastName ){
				$userList[] = $userRecord;
				break;
			}

		}

	}

	return $userList;
}

function sortByGenderAndLastName()
{
	$users = getUserList();

	$women = [];

	$men = [];

	foreach ($users as $user) {

		if( $user->gender == 'Female' ){
			$women[] = $user;
		} else {
			$men[] = $user;
		}

	}

	$womenLastNames = [];

	foreach ($women as $woman) {
		$womenLastNames[] = $woman->lastName;
	}

	$sortedWomenLastNames = sortLogic($womenLastNames);

	$womenList = [];

	foreach ($sortedWomenLastNames as $womanLastName) {
		
		foreach ($women as $womenData) {
			
			if( $womanLastName == $womenData->lastName ){
				$womenList[] = $womenData;
				break;
			}

		}

	}

	$menLastNames = [];

	foreach ($men as $man) {
		$menLastNames[] = $man->lastName;
	}

	$sortedMenLastNames = sortLogic($menLastNames);

	$menList = [];

	foreach ($sortedMenLastNames as $menLastName) {
		
		foreach ($men as $menData) {
			
			if( $menLastName == $menData->lastName ){
				$menList[] = $menData;
				break;
			}

		}

	}

	$userList = array_merge($womenList, $menList);

	return $userList;
}

function generateOutput()
{
	// USER LIST - SORT BY GENDER AND LAST NAME ASCENDING

	$usersSortedByGenderAndLastName = sortByGenderAndLastName();

	$firstRow = "User List - Sorted by Gender and Last Name - Ascending\n--------------------------------------------------------------------\n";

	$rows[] = $firstRow;

	foreach ($usersSortedByGenderAndLastName as $userInformation) {
		
		$row = str_pad($userInformation->lastName, 15) . " " . str_pad($userInformation->firstName, 15) . " " . str_pad($userInformation->gender, 15) . " " . str_pad($userInformation->dateOfBirth, 15) . " " . str_pad($userInformation->favoriteColor, 15) . "\n";

		$rows[] = $row;

	}

	$lastRow = "\n--------------------------------------------------------------------";

	$rows[] = $lastRow;

	// END

	// USER LIST - SORTED BY DATE OF BIRTH - ASCENDING 

	$usersSortedByDate = sortByDateOfBirth();

	$firstRow = "\n\nUser List - Sorted by Date of Birth - Ascending\n--------------------------------------------------------------------\n";

	$rows[] = $firstRow;

	foreach ($usersSortedByDate as $userDetails) {
		
		$row = str_pad($userDetails->lastName, 15) . " " . str_pad($userDetails->firstName, 15) . " " . str_pad($userDetails->gender, 15) . " " . str_pad($userDetails->dateOfBirth, 15) . " " . str_pad($userDetails->favoriteColor, 15) . "\n";

		$rows[] = $row;

	}

	$rows[] = $lastRow;

	// END

	// USER LIST - SORT BY LAST NAME - DESCENDING

	$usersSortedByLastName = sortByLastName();

	$firstRow = "\n\nUser List - Sorted by Last Name - Descending\n--------------------------------------------------------------------\n";

	$rows[] = $firstRow;

	foreach ($usersSortedByLastName as $userInfo) {
		
		$row = str_pad($userInfo->lastName, 15) . " " . str_pad($userInfo->firstName, 15) . " " . str_pad($userInfo->gender, 15) . " " . str_pad($userInfo->dateOfBirth, 15) . " " . str_pad($userInfo->favoriteColor, 15) . "\n";

		$rows[] = $row;

	}

	$rows[] = $lastRow;

	// END

	file_put_contents('files/output.txt', $rows);

	echo "Output created. User List generated.";
}

generateOutput();

?>