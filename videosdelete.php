<?php
namespace PHPMaker2020\sistema;

// Autoload
include_once "autoload.php";

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	\Delight\Cookie\Session::start(Config("COOKIE_SAMESITE")); // Init session data

// Output buffering
ob_start();
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$videos_delete = new videos_delete();

// Run the page
$videos_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$videos_delete->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var fvideosdelete, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "delete";
	fvideosdelete = currentForm = new ew.Form("fvideosdelete", "delete");
	loadjs.done("fvideosdelete");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $videos_delete->showPageHeader(); ?>
<?php
$videos_delete->showMessage();
?>
<form name="fvideosdelete" id="fvideosdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="videos">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($videos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php echo ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($videos_delete->titulo->Visible) { // titulo ?>
		<th class="<?php echo $videos_delete->titulo->headerCellClass() ?>"><span id="elh_videos_titulo" class="videos_titulo"><?php echo $videos_delete->titulo->caption() ?></span></th>
<?php } ?>
<?php if ($videos_delete->idaulas->Visible) { // idaulas ?>
		<th class="<?php echo $videos_delete->idaulas->headerCellClass() ?>"><span id="elh_videos_idaulas" class="videos_idaulas"><?php echo $videos_delete->idaulas->caption() ?></span></th>
<?php } ?>
<?php if ($videos_delete->ativo->Visible) { // ativo ?>
		<th class="<?php echo $videos_delete->ativo->headerCellClass() ?>"><span id="elh_videos_ativo" class="videos_ativo"><?php echo $videos_delete->ativo->caption() ?></span></th>
<?php } ?>
<?php if ($videos_delete->views->Visible) { // views ?>
		<th class="<?php echo $videos_delete->views->headerCellClass() ?>"><span id="elh_videos_views" class="videos_views"><?php echo $videos_delete->views->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$videos_delete->RecordCount = 0;
$i = 0;
while (!$videos_delete->Recordset->EOF) {
	$videos_delete->RecordCount++;
	$videos_delete->RowCount++;

	// Set row properties
	$videos->resetAttributes();
	$videos->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$videos_delete->loadRowValues($videos_delete->Recordset);

	// Render row
	$videos_delete->renderRow();
?>
	<tr <?php echo $videos->rowAttributes() ?>>
<?php if ($videos_delete->titulo->Visible) { // titulo ?>
		<td <?php echo $videos_delete->titulo->cellAttributes() ?>>
<span id="el<?php echo $videos_delete->RowCount ?>_videos_titulo" class="videos_titulo">
<span<?php echo $videos_delete->titulo->viewAttributes() ?>><?php if (!EmptyString($videos_delete->titulo->getViewValue()) && $videos_delete->titulo->linkAttributes() != "") { ?>
<a<?php echo $videos_delete->titulo->linkAttributes() ?>><?php echo $videos_delete->titulo->getViewValue() ?></a>
<?php } else { ?>
<?php echo $videos_delete->titulo->getViewValue() ?>
<?php } ?></span>
</span>
</td>
<?php } ?>
<?php if ($videos_delete->idaulas->Visible) { // idaulas ?>
		<td <?php echo $videos_delete->idaulas->cellAttributes() ?>>
<span id="el<?php echo $videos_delete->RowCount ?>_videos_idaulas" class="videos_idaulas">
<span<?php echo $videos_delete->idaulas->viewAttributes() ?>><?php echo $videos_delete->idaulas->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($videos_delete->ativo->Visible) { // ativo ?>
		<td <?php echo $videos_delete->ativo->cellAttributes() ?>>
<span id="el<?php echo $videos_delete->RowCount ?>_videos_ativo" class="videos_ativo">
<span<?php echo $videos_delete->ativo->viewAttributes() ?>><?php echo $videos_delete->ativo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($videos_delete->views->Visible) { // views ?>
		<td <?php echo $videos_delete->views->cellAttributes() ?>>
<span id="el<?php echo $videos_delete->RowCount ?>_videos_views" class="videos_views">
<span<?php echo $videos_delete->views->viewAttributes() ?>><?php echo $videos_delete->views->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$videos_delete->Recordset->moveNext();
}
$videos_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $videos_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$videos_delete->showPageFooter();
if (Config("DEBUG"))
	echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function() {

	// Startup script
	// Write your table-specific startup script here
	// console.log("page loaded");

});
</script>
<?php include_once "footer.php"; ?>
<?php
$videos_delete->terminate();
?>