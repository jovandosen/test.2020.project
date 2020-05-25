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

	$users = json_encode($users);

	$result = file_put_contents('files/output.txt', $users);

	if( $result ){
		echo "Output file created.";
	}
}

getUserList();

?>