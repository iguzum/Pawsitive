<?php
// :: START AOS SCRIPT PATH
$aosCurrentScript = $_SERVER['PHP_SELF'] ?? '';
$aosScriptPath = preg_match('~/(services|pages|admin|staff)/~', $aosCurrentScript)
    ? '../assets/scripts/aos-init.js'
    : './assets/scripts/aos-init.js';
// :: END AOS SCRIPT PATH
?>
<!-- :: START AOS SCRIPT INCLUDE -->
<script src="<?= htmlspecialchars($aosScriptPath, ENT_QUOTES, 'UTF-8') ?>"></script>
<!-- :: END AOS SCRIPT INCLUDE -->
