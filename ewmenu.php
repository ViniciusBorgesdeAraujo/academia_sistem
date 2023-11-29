<?php
namespace PHPMaker2020\sistema;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
	$MenuRelativePath = "";
	$MenuLanguage = &$Language;
} else { // Compat reports
	$LANGUAGE_FOLDER = "../lang/";
	$MenuRelativePath = "../";
	$MenuLanguage = new Language();
}

// Navbar menu
$topMenu = new Menu("navbar", TRUE, TRUE);
$topMenu->addMenuItem(16, "mi_home", $MenuLanguage->MenuPhrase("16", "MenuText"), $MenuRelativePath . "home.php", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}home.php'), FALSE, FALSE, "", "", TRUE);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", TRUE, FALSE);
$sideMenu->addMenuItem(12, "mi_videos", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "videoslist.php?cmd=resetall", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}videos'), FALSE, FALSE, "fa-video", "", FALSE);
$sideMenu->addMenuItem(2, "mi_aulas", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "aulaslist.php?cmd=resetall", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}aulas'), FALSE, FALSE, "fa-sitemap", "", FALSE);
$sideMenu->addMenuItem(4, "mi_endereco", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "enderecolist.php?cmd=resetall", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}endereco'), FALSE, FALSE, "fa-map", "", FALSE);
$sideMenu->addMenuItem(7, "mi_turnos", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "turnoslist.php?cmd=resetall", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}turnos'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(1, "mi_academia", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "academialist.php", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}academia'), FALSE, FALSE, "fa-university", "", FALSE);
$sideMenu->addMenuItem(3, "mi_documentos", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "documentoslist.php?cmd=resetall", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}documentos'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(5, "mi_pessoa", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "pessoalist.php?cmd=resetall", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}pessoa'), FALSE, FALSE, "fa fa-user", "", FALSE);
$sideMenu->addMenuItem(14, "mi_userlevels", $MenuLanguage->MenuPhrase("14", "MenuText"), $MenuRelativePath . "userlevelslist.php", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}userlevels'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(16, "mi_home", $MenuLanguage->MenuPhrase("16", "MenuText"), $MenuRelativePath . "home.php", -1, "", AllowListMenu('{448C0B4B-C32A-40EF-8151-41E96F03E813}home.php'), FALSE, FALSE, "", "", TRUE);
echo $sideMenu->toScript();
?>