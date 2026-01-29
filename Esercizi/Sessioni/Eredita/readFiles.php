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

    if (file_exists("words.csv") && filesize("words.csv") > 0) {
        $data = file("words.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (!empty($data)) {
            $parole = explode(";", trim($data[0]));

            if (count($parole) >= 6) {
                $result = [
                    'p1' => $parole[0],
                    'p2' => $parole[1],
                    'p3' => $parole[2],
                    'p4' => $parole[3],
                    'p5' => $parole[4],
                    'correct' => $parole[5]
                ];
            }
        }
    }

    return $result;
}

// Scrive le parole nel file words.csv
function writeWords($p1, $p2, $p3, $p4, $p5, $correct)
{
    $ok = false;
    $file = fopen("words.csv", "w");

    if ($file !== false) {
        $str = trim($p1) . ";" . trim($p2) . ";" . trim($p3) . ";" . trim($p4) . ";" . trim($p5) . ";" . trim($correct) . "\n";
        fwrite($file, $str);
        fclose($file);
        $ok = true;
    }

    return $ok;
}

// Ritorna la guess dell'utente nel round indicato (da history.csv)
function getUserGuessForRound($username, $round)
{
    $guess = false;
    $history = readHistory();

    foreach ($history as $entry) {
        if ($entry['id'] !== 'a'
            && strcasecmp($entry['id'], $username) === 0
            && (string)$entry['round'] === (string)$round
        ) {
            $guess = ($entry['guess'] !== '' ? $entry['guess'] : false);
        }
    }

    return $guess;
}

// Verifica se un utente ha già risposto nel round indicato (da history.csv)
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
        $data = file("history.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($data as $line) {
            $parts = explode(";", trim($line));

            if (count($parts) >= 8) {
                $history[] = [
                    'id' => isset($parts[0]) ? $parts[0] : '',
                    'round' => isset($parts[1]) ? $parts[1] : '',
                    'p1' => isset($parts[2]) ? $parts[2] : '',
                    'p2' => isset($parts[3]) ? $parts[3] : '',
                    'p3' => isset($parts[4]) ? $parts[4] : '',
                    'p4' => isset($parts[5]) ? $parts[5] : '',
                    'p5' => isset($parts[6]) ? $parts[6] : '',
                    'correct' => isset($parts[7]) ? $parts[7] : '',
                    'guess' => isset($parts[8]) ? $parts[8] : '',
                    'result' => isset($parts[9]) ? $parts[9] : ''
                ];
            }
        }
    }

    return $history;
}

// Aggiunge una nuova entry alla history
function addHistoryEntry($id, $round, $p1, $p2, $p3, $p4, $p5, $correct, $guess, $result)
{
    $ok = false;
    $file = fopen("history.csv", "a");

    if ($file !== false) {
        $str = $id . ";" . $round . ";" . trim($p1) . ";" . trim($p2) . ";" . trim($p3) . ";" . trim($p4) . ";" . trim($p5) . ";" . trim($correct) . ";" . trim($guess) . ";" . trim($result) . "\n";
        fwrite($file, $str);
        fclose($file);
        $ok = true;
    }

    return $ok;
}

/*
    Inizializza un nuovo round (admin).
    Mantiene la cronologia precedente e aggiunge una nuova entry admin.
*/
function initHistory($p1, $p2, $p3, $p4, $p5, $correct)
{
    $history = readHistory();
    $nextRound = 0;

    foreach ($history as $entry) {
        if ($entry['id'] == 'a' && isset($entry['round']) && is_numeric($entry['round'])) {
            $roundNum = intval($entry['round']);
            if ($roundNum >= $nextRound) {
                $nextRound = $roundNum + 1;
            }
        }
    }

    $ok = addHistoryEntry('a', $nextRound, $p1, $p2, $p3, $p4, $p5, $correct, '', '');

    return $ok;
}

// Ottiene l'ID del round corrente dalla history
function getCurrentRoundId()
{
    $history = readHistory();
    $maxRound = 0;

    foreach ($history as $entry) {
        if ($entry['id'] == 'a' && isset($entry['round']) && is_numeric($entry['round'])) {
            $roundNum = intval($entry['round']);
            if ($roundNum > $maxRound) {
                $maxRound = $roundNum;
            }
        }
    }

    return $maxRound;
}

// Aggiunge una guess alla history del round corrente
function addGuessToHistory($username, $guess, $correct)
{
    $ok = false;
    $words = readWords();

    if ($words !== false) {
        $history = readHistory();
        $currentRound = getCurrentRoundId();

        $roundEntry = null;
        foreach ($history as $entry) {
            if ($entry['id'] == 'a' && isset($entry['round']) && intval($entry['round']) == $currentRound) {
                $roundEntry = $entry;
            }
        }

        if ($roundEntry !== null) {
            $result = $correct ? "1" : "0";
            $ok = addHistoryEntry(
                $username,
                $currentRound,
                $roundEntry['p1'],
                $roundEntry['p2'],
                $roundEntry['p3'],
                $roundEntry['p4'],
                $roundEntry['p5'],
                $roundEntry['correct'],
                $guess,
                $result
            );
        }
    }

    return $ok;
}
?>

