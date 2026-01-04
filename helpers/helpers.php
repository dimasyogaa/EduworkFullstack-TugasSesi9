<?php
function h($str)
{
    return htmlspecialchars($str ?? "", ENT_QUOTES, "UTF-8");
}

function rupiah($angka)
{
    return "Rp " . number_format((int)$angka, 0, ",", ".");
}

function redirect($to)
{
    header("Location: " . $to);
    exit;
}
