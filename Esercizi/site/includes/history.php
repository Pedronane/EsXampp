<?php
/**
 * History storage (text file) for games and guesses.
 *
 * Format (semicolon-separated):
 * - GAME;ISO_TIMESTAMP;ADMIN;w1;w2;w3;w4;w5;correct
 * - GUESS;ISO_TIMESTAMP;USER;guess;w1;w2;w3;w4;w5;correct;isCorrect
 */
function history_file_path()
{
    $path = __DIR__ . '/../data/history.csv';
    return $path;
}

function history_normalize_word($value)
{
    $out = '';
    if ($value !== null) {
        $out = strtolower(trim((string)$value));
        $out = str_replace(["\r", "\n", ";"], [' ', ' ', ','], $out);
        $out = trim($out);
    }
    return $out;
}

function history_ensure_file($filename)
{
    $ok = true;
    if (!file_exists($filename)) {
        $written = @file_put_contents($filename, '');
        if ($written === false) {
            $ok = false;
        }
    }
    return $ok;
}

function history_append_line($line, $filename = null)
{
    $ok = false;
    $file = $filename;
    if ($file === null) {
        $file = history_file_path();
    }

    if (history_ensure_file($file)) {
        $bytes = @file_put_contents($file, $line . "\n", FILE_APPEND | LOCK_EX);
        if ($bytes !== false) {
            $ok = true;
        }
    }

    return $ok;
}

function history_append_game($adminUser, $words, $filename = null)
{
    $ok = false;
    $w = [];
    if (is_array($words)) {
        for ($i = 0; $i < 6; $i++) {
            $w[$i] = history_normalize_word($words[$i] ?? '');
        }
    } else {
        for ($i = 0; $i < 6; $i++) {
            $w[$i] = '';
        }
    }

    $ts = date('c');
    $admin = history_normalize_word($adminUser);
    $line = 'GAME' . ';' . $ts . ';' . $admin . ';' . implode(';', array_slice($w, 0, 5)) . ';' . ($w[5] ?? '');
    $ok = history_append_line($line, $filename);

    return $ok;
}

function history_append_guess($username, $guess, $words, $isCorrect, $filename = null)
{
    $ok = false;
    $w = [];
    if (is_array($words)) {
        for ($i = 0; $i < 6; $i++) {
            $w[$i] = history_normalize_word($words[$i] ?? '');
        }
    } else {
        for ($i = 0; $i < 6; $i++) {
            $w[$i] = '';
        }
    }

    $ts = date('c');
    $user = history_normalize_word($username);
    $g = history_normalize_word($guess);
    $correctFlag = $isCorrect ? '1' : '0';
    $line = 'GUESS' . ';' . $ts . ';' . $user . ';' . $g . ';' . implode(';', array_slice($w, 0, 5)) . ';' . ($w[5] ?? '') . ';' . $correctFlag;
    $ok = history_append_line($line, $filename);

    return $ok;
}

function history_read_events($filename = null)
{
    $events = [];
    $file = $filename;
    if ($file === null) {
        $file = history_file_path();
    }

    if (file_exists($file) && filesize($file) > 0) {
        $rows = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (is_array($rows)) {
            foreach ($rows as $row) {
                $line = trim((string)$row);
                if ($line === '') {
                    continue;
                }

                $parts = explode(';', $line);
                $type = $parts[0] ?? '';
                if ($type === 'GAME') {
                    $events[] = [
                        'type' => 'GAME',
                        'ts' => $parts[1] ?? '',
                        'admin' => $parts[2] ?? '',
                        'words' => array_slice($parts, 3, 5),
                        'correct' => $parts[8] ?? '',
                    ];
                } elseif ($type === 'GUESS') {
                    $events[] = [
                        'type' => 'GUESS',
                        'ts' => $parts[1] ?? '',
                        'user' => $parts[2] ?? '',
                        'guess' => $parts[3] ?? '',
                        'words' => array_slice($parts, 4, 5),
                        'correct' => $parts[9] ?? '',
                        'isCorrect' => ($parts[10] ?? '0') === '1',
                    ];
                }
            }
        }
    }

    return $events;
}
