<?php
// Marchesi Pietro 5AI readFiles.php

/*
    Legge tutti gli utenti dal file users.csv
    Ritorna un array
*/
function readUsers()
{
	$users = [];

	if (file_exists("users.csv")) {
		$data = file("users.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		foreach ($data as $line) {
			[$username, $password, $role] = explode(':', trim($line), 3);
			$users[] = [
				'username' => $username,
				'password' => $password,
				'role' => trim($role)
			];
		}
	}

	return $users;
}

// Verifica le credenziali di un utente
function checkCredentials($username, $password)
{
	$role = false;
	$users = readUsers();

	foreach ($users as $user) {
		if (strtolower($user['username']) == strtolower($username) && $user['password'] == $password) {
			$role = trim($user['role']);
		}
	}

	return $role;
}

// Verifica se un username esiste già
function usernameExists($username)
{
	$check = false;
	$users = readUsers();

	foreach ($users as $user) {
		if (strtolower($user['username']) == strtolower($username) && trim($user['role']) == "user") {
			$check = true;
		}
	}

	return $check;
}

// Registra un nuovo utente nel file users.csv
function registerUser($username, $password)
{
	$check = false;
	$file = fopen("users.csv", "a");

	if ($file !== false) {
		fwrite($file, strtolower($username) . ":" . $password . ":user\n");
		fclose($file);
		$check = true;
	}

	return $check;
}

// Legge le parole dal file words.csv
function readWords()
{
	$result = false;

	$parole = getCurrentRound();

	if ($parole != false) {
		$result = [
			'p1' => $parole[1],
			'p2' => $parole[2],
			'p3' => $parole[3],
			'p4' => $parole[4],
			'p5' => $parole[5],
			'correct' => $parole[6]
		];
	}

	return $result;
}

// Ritorna l'ultimo round
function getCurrentRound()
{
	$result = false;

	if (file_exists("rounds.csv") && filesize("rounds.csv") > 0) {
		$data = file("rounds.csv");

		if (!empty($data)) {
			$data = array_pop($data);
			$parole = explode(";", trim($data));

			if (count($parole) >= 7) {
				$result = $parole;
			}
		}
	}

	return $result;
}

// Ottiene l'id del round corrente
function getCurrentRoundId()
{
	$result = false;

	$round = getCurrentRound();

	if ($round != false)
		$result = $round[0];

	return $result;
}

function getRoundById($id){
	$result = false;

	if (file_exists("rounds.csv") && filesize("rounds.csv") > 0) {
		$data = file("rounds.csv");

		if (!empty($data)) {
			foreach($data as $round){
				$parole = explode(";", $round);
				if((int)$parole[0] == $id)
					$result = $parole;
			}

		}
	}

	return $result;
}

// Scrive le parole nel file words.csv
function writeWords($p1, $p2, $p3, $p4, $p5, $correct)
{
	$ok = false;
	$file = fopen("rounds.csv", "a");

	if ($file !== false) {
		$round = getCurrentRoundId();
		if ($round != false) {
			$round++;
			$str = $round  . ";" . trim($p1) . ";" . trim($p2) . ";" . trim($p3) . ";" . trim($p4) . ";" . trim($p5) . ";" . trim($correct) . "\n";
			fwrite($file, $str);
			fclose($file);
			$ok = true;
		}
	}

	return $ok;
}

// Ritorna la guess dell'utente nel round indicato
function getUserGuessForRound($username, $round)
{
	$guess = false;
	$history = readHistory();

	foreach ($history as $entry) {
		if ($entry['user'] == $username && $entry['round'] == $round && !empty($entry['guess'])) {
			$guess = $entry['guess'];
		}
	}

	return $guess;
}

// Verifica se un utente ha già risposto nel round indicato
function hasUserGuessedForRound($username, $round)
{
	$hasGuessed = false;
	$guess = getUserGuessForRound($username, $round);

	if ($guess !== false) {
		$hasGuessed = true;
	}

	return $hasGuessed;
}

// Legge la history dal file history.csv
function readHistory()
{
	$history = [];

	if (file_exists("history.csv") && filesize("history.csv") > 0) {
		$data = file("history.csv");

		foreach ($data as $line) {
			$parts = explode(";", trim($line));

			if (count($parts) >= 5) {
				$history[] = [
					'id' => isset($parts[0]) ? $parts[0] : '',
					'round' => isset($parts[1]) ? $parts[1] : '',
					'user' => isset($parts[2]) ? $parts[2] : '',
					'guess' => isset($parts[3]) ? $parts[3] : '',
					'result' => isset($parts[4]) ? $parts[4] : ''
				];
			}
		}
	}

	return $history;
}

//Trova l'id dell'ultima entry nell'history
function getEntryId()
{
	$result = 0;

	if (file_exists("history.csv") && filesize("history.csv") > 0) {
		$data = file("history.csv");

		if (!empty($data)) {
			$data = array_pop($data);
			$entry = explode(";", trim($data));
			$result = $entry['0'];
		}
	}

	return $result;
}

// Aggiunge una nuova entry alla history
function addHistoryEntry($round, $user, $guess, $result)
{
	$ok = false;
	$file = fopen("history.csv", "a");

	$entry = getEntryId() + 1;

	if ($round != false) {

		if ($file !== false) {
			$str = $entry . ";" . $round . ";" . trim($user) . ";" . trim($guess) . ";" . trim($result) . "\n";
			fwrite($file, $str);
			fclose($file);
			$ok = true;
		}
	}

	return $ok;
}

// Aggiunge una guess alla history del round corrente
function addGuessToHistory($username, $guess, $correct)
{
	$ok = false;

	$round = getCurrentRoundId();
	$result = $correct ? "1" : "0";

	$ok = addHistoryEntry($round, $username, $guess, $result);

	return $ok;
}
