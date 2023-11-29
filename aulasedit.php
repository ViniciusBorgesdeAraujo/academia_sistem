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
$aulas_edit = new aulas_edit();

// Run the page
$aulas_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$aulas_edit->Page_Render();
?>
<?php include_once "header.php"; ?>
<script>
var faulasedit, currentPageID;
loadjs.ready("head", function() {

	// Form object
	currentPageID = ew.PAGE_ID = "edit";
	faulasedit = currentForm = new ew.Form("faulasedit", "edit");

	// Validate form
	faulasedit.validate = function() {
		if (!this.validateRequired)
			return true; // Ignore validation
		var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
		if ($fobj.find("#confirm").val() == "confirm")
			return true;
		var elm, felm, uelm, addcnt = 0;
		var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
		var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
		var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
		var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
		for (var i = startcnt; i <= rowcnt; i++) {
			var infix = ($k[0]) ? String(i) : "";
			$fobj.data("rowindex", infix);
			<?php if ($aulas_edit->idturnos->Required) { ?>
				elm = this.getElements("x" + infix + "_idturnos");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_edit->idturnos->caption(), $aulas_edit->idturnos->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($aulas_edit->idaluno->Required) { ?>
				elm = this.getElements("x" + infix + "_idaluno");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_edit->idaluno->caption(), $aulas_edit->idaluno->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($aulas_edit->nome->Required) { ?>
				elm = this.getElements("x" + infix + "_nome");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_edit->nome->caption(), $aulas_edit->nome->RequiredErrorMessage)) ?>");
			<?php } ?>
			<?php if ($aulas_edit->ativado->Required) { ?>
				elm = this.getElements("x" + infix + "_ativado");
				if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
					return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $aulas_edit->ativado->caption(), $aulas_edit->ativado->RequiredErrorMessage)) ?>");
			<?php } ?>

				// Call Form_CustomValidate event
				if (!this.Form_CustomValidate(fobj))
					return false;
		}

		// Process detail forms
		var dfs = $fobj.find("input[name='detailpage']").get();
		for (var i = 0; i < dfs.length; i++) {
			var df = dfs[i], val = df.value;
			if (val && ew.forms[val])
				if (!ew.forms[val].validate())
					return false;
		}
		return true;
	}

	// Form_CustomValidate
	faulasedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

		// Your custom validation code here, return false if invalid.
		return true;
	}

	// Use JavaScript validation or not
	faulasedit.validateRequired = <?php echo Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

	// Dynamic selection lists
	faulasedit.lists["x_idturnos"] = <?php echo $aulas_edit->idturnos->Lookup->toClientList($aulas_edit) ?>;
	faulasedit.lists["x_idturnos"].options = <?php echo JsonEncode($aulas_edit->idturnos->lookupOptions()) ?>;
	faulasedit.lists["x_idaluno"] = <?php echo $aulas_edit->idaluno->Lookup->toClientList($aulas_edit) ?>;
	faulasedit.lists["x_idaluno"].options = <?php echo JsonEncode($aulas_edit->idaluno->lookupOptions()) ?>;
	faulasedit.lists["x_nome"] = <?php echo $aulas_edit->nome->Lookup->toClientList($aulas_edit) ?>;
	faulasedit.lists["x_nome"].options = <?php echo JsonEncode($aulas_edit->nome->lookupOptions()) ?>;
	faulasedit.lists["x_ativado"] = <?php echo $aulas_edit->ativado->Lookup->toClientList($aulas_edit) ?>;
	faulasedit.lists["x_ativado"].options = <?php echo JsonEncode($aulas_edit->ativado->options(FALSE, TRUE)) ?>;
	loadjs.done("faulasedit");
});
</script>
<script>
loadjs.ready("head", function() {

	// Client script
	// Write your client script here, no need to add script tags.

});
</script>
<?php $aulas_edit->showPageHeader(); ?>
<?php
$aulas_edit->showMessage();
?>
<?php if (!$aulas_edit->IsModal) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php echo $aulas_edit->Pager->render() ?>
<div class="clearfix"></div>
</form>
<?php } ?>
<form name="faulasedit" id="faulasedit" class="<?php echo $aulas_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($Page->CheckToken) { ?>
<input type="hidden" name="<?php echo Config("TOKEN_NAME") ?>" value="<?php echo $Page->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="aulas">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$aulas_edit->IsModal ?>">
<?php if ($aulas->getCurrentMasterTable() == "turnos") { ?>
<input type="hidden" name="<?php echo Config("TABLE_SHOW_MASTER") ?>" value="turnos">
<input type="hidden" name="fk_idturnos" value="<?php echo HtmlEncode($aulas_edit->idturnos->getSessionValue()) ?>">
<?php } ?>
<div class="ew-edit-div"><!-- page* -->
<?php if ($aulas_edit->idturnos->Visible) { // idturnos ?>
	<div id="r_idturnos" class="form-group row">
		<label id="elh_aulas_idturnos" for="x_idturnos" class="<?php echo $aulas_edit->LeftColumnClass ?>"><?php echo $aulas_edit->idturnos->caption() ?><?php echo $aulas_edit->idturnos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $aulas_edit->RightColumnClass ?>"><div <?php echo $aulas_edit->idturnos->cellAttributes() ?>>
<?php if ($aulas_edit->idturnos->getSessionValue() != "") { ?>
<span id="el_aulas_idturnos">
<span<?php echo $aulas_edit->idturnos->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_edit->idturnos->ViewValue)) ?>"></span>
</span>
<input type="hidden" id="x_idturnos" name="x_idturnos" value="<?php echo HtmlEncode($aulas_edit->idturnos->CurrentValue) ?>">
<?php } else { ?>
<span id="el_aulas_idturnos">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idturnos" data-value-separator="<?php echo $aulas_edit->idturnos->displayValueSeparatorAttribute() ?>" id="x_idturnos" name="x_idturnos"<?php echo $aulas_edit->idturnos->editAttributes() ?>>
			<?php echo $aulas_edit->idturnos->selectOptionListHtml("x_idturnos") ?>
		</select>
</div>
<?php echo $aulas_edit->idturnos->Lookup->getParamTag($aulas_edit, "p_x_idturnos") ?>
</span>
<?php } ?>
<?php echo $aulas_edit->idturnos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($aulas_edit->idaluno->Visible) { // idaluno ?>
	<div id="r_idaluno" class="form-group row">
		<label id="elh_aulas_idaluno" for="x_idaluno" class="<?php echo $aulas_edit->LeftColumnClass ?>"><?php echo $aulas_edit->idaluno->caption() ?><?php echo $aulas_edit->idaluno->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $aulas_edit->RightColumnClass ?>"><div <?php echo $aulas_edit->idaluno->cellAttributes() ?>>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn() && !$aulas->userIDAllow("edit")) { // Non system admin ?>
<span id="el_aulas_idaluno">
<span<?php echo $aulas_edit->idaluno->viewAttributes() ?>><input type="text" readonly class="form-control-plaintext" value="<?php echo HtmlEncode(RemoveHtml($aulas_edit->idaluno->EditValue)) ?>"></span>
</span>
<input type="hidden" data-table="aulas" data-field="x_idaluno" name="x_idaluno" id="x_idaluno" value="<?php echo HtmlEncode($aulas_edit->idaluno->CurrentValue) ?>">
<?php } else { ?>
<span id="el_aulas_idaluno">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_idaluno" data-value-separator="<?php echo $aulas_edit->idaluno->displayValueSeparatorAttribute() ?>" id="x_idaluno" name="x_idaluno"<?php echo $aulas_edit->idaluno->editAttributes() ?>>
			<?php echo $aulas_edit->idaluno->selectOptionListHtml("x_idaluno") ?>
		</select>
</div>
<?php echo $aulas_edit->idaluno->Lookup->getParamTag($aulas_edit, "p_x_idaluno") ?>
</span>
<?php } ?>
<?php echo $aulas_edit->idaluno->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($aulas_edit->nome->Visible) { // nome ?>
	<div id="r_nome" class="form-group row">
		<label id="elh_aulas_nome" for="x_nome" class="<?php echo $aulas_edit->LeftColumnClass ?>"><?php echo $aulas_edit->nome->caption() ?><?php echo $aulas_edit->nome->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $aulas_edit->RightColumnClass ?>"><div <?php echo $aulas_edit->nome->cellAttributes() ?>>
<span id="el_aulas_nome">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="aulas" data-field="x_nome" data-value-separator="<?php echo $aulas_edit->nome->displayValueSeparatorAttribute() ?>" id="x_nome" name="x_nome"<?php echo $aulas_edit->nome->editAttributes() ?>>
			<?php echo $aulas_edit->nome->selectOptionListHtml("x_nome") ?>
		</select>
</div>
<?php echo $aulas_edit->nome->Lookup->getParamTag($aulas_edit, "p_x_nome") ?>
</span>
<?php echo $aulas_edit->nome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($aulas_edit->ativado->Visible) { // ativado ?>
	<div id="r_ativado" class="form-group row">
		<label id="elh_aulas_ativado" class="<?php echo $aulas_edit->LeftColumnClass ?>"><?php echo $aulas_edit->ativado->caption() ?><?php echo $aulas_edit->ativado->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $aulas_edit->RightColumnClass ?>"><div <?php echo $aulas_edit->ativado->cellAttributes() ?>>
<span id="el_aulas_ativado">
<div id="tp_x_ativado" class="ew-template"><input type="radio" class="custom-control-input" data-table="aulas" data-field="x_ativado" data-value-separator="<?php echo $aulas_edit->ativado->displayValueSeparatorAttribute() ?>" name="x_ativado" id="x_ativado" value="{value}"<?php echo $aulas_edit->ativado->editAttributes() ?>></div>
<div id="dsl_x_ativado" data-repeatcolumn="5" class="ew-item-list d-none"><div>
<?php echo $aulas_edit->ativado->radioButtonListHtml(FALSE, "x_ativado") ?>
</div></div>
</span>
<?php echo $aulas_edit->ativado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
	<input type="hidden" data-table="aulas" data-field="x_idaulas" name="x_idaulas" id="x_idaulas" value="<?php echo HtmlEncode($aulas_edit->idaulas->CurrentValue) ?>">
<?php if ($aulas->getCurrentDetailTable() != "") { ?>
<?php
	$aulas_edit->DetailPages->ValidKeys = explode(",", $aulas->getCurrentDetailTable());
	$firstActiveDetailTable = $aulas_edit->DetailPages->activePageIndex();
?>
<div class="ew-detail-pages"><!-- detail-pages -->
<div class="ew-nav-tabs" id="aulas_edit_details"><!-- tabs -->
	<ul class="<?php echo $aulas_edit->DetailPages->navStyle() ?>"><!-- .nav -->
<?php
	if (in_array("pessoa", explode(",", $aulas->getCurrentDetailTable())) && $pessoa->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "pessoa") {
			$firstActiveDetailTable = "pessoa";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $aulas_edit->DetailPages->pageStyle("pessoa") ?>" href="#tab_pessoa" data-toggle="tab"><?php echo $Language->tablePhrase("pessoa", "TblCaption") ?></a></li>
<?php
	}
?>
<?php
	if (in_array("videos", explode(",", $aulas->getCurrentDetailTable())) && $videos->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "videos") {
			$firstActiveDetailTable = "videos";
		}
?>
		<li class="nav-item"><a class="nav-link <?php echo $aulas_edit->DetailPages->pageStyle("videos") ?>" href="#tab_videos" data-toggle="tab"><?php echo $Language->tablePhrase("videos", "TblCaption") ?></a></li>
<?php
	}
?>
	</ul><!-- /.nav -->
	<div class="tab-content"><!-- .tab-content -->
<?php
	if (in_array("pessoa", explode(",", $aulas->getCurrentDetailTable())) && $pessoa->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "pessoa")
			$firstActiveDetailTable = "pessoa";
?>
		<div class="tab-pane <?php echo $aulas_edit->DetailPages->pageStyle("pessoa") ?>" id="tab_pessoa"><!-- page* -->
<?php include_once "pessoagrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
<?php
	if (in_array("videos", explode(",", $aulas->getCurrentDetailTable())) && $videos->DetailEdit) {
		if ($firstActiveDetailTable == "" || $firstActiveDetailTable == "videos")
			$firstActiveDetailTable = "videos";
?>
		<div class="tab-pane <?php echo $aulas_edit->DetailPages->pageStyle("videos") ?>" id="tab_videos"><!-- page* -->
<?php include_once "videosgrid.php" ?>
		</div><!-- /page* -->
<?php } ?>
	</div><!-- /.tab-content -->
</div><!-- /tabs -->
</div><!-- /detail-pages -->
<?php } ?>
<?php if (!$aulas_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $aulas_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $aulas_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
<?php if (!$aulas_edit->IsModal) { ?>
<?php echo $aulas_edit->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$aulas_edit->showPageFooter();
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
$aulas_edit->terminate();
?>