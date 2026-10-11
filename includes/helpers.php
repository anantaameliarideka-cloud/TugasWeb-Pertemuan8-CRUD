<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Escape output HTML (wajib dipakai di semua echo data)
function e($teks): string
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

// Simpan pesan flash (tampil sekali setelah redirect)
function setFlash(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function showFlash(): void
{
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        echo '<div class="alert ' . e($f['tipe']) . '">' . e($f['pesan']) . '</div>';
    }
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}