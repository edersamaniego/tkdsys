<?php

namespace PHPMaker2022\school;

// Page object
$ConfSchooltypeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_schooltype: currentTable } });
var currentForm, currentPageID;
var fconf_schooltypeview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_schooltypeview = new ew.Form("fconf_schooltypeview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fconf_schooltypeview;
    loadjs.done("fconf_schooltypeview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<?php } ?>
<form name="fconf_schooltypeview" id="fconf_schooltypeview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_schooltype">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_schooltype_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_schooltype_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->typeBr->Visible) { // typeBr ?>
    <tr id="r_typeBr"<?= $Page->typeBr->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_schooltype_typeBr"><?= $Page->typeBr->caption() ?></span></td>
        <td data-name="typeBr"<?= $Page->typeBr->cellAttributes() ?>>
<span id="el_conf_schooltype_typeBr">
<span<?= $Page->typeBr->viewAttributes() ?>>
<?= $Page->typeBr->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->typeEs->Visible) { // typeEs ?>
    <tr id="r_typeEs"<?= $Page->typeEs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_schooltype_typeEs"><?= $Page->typeEs->caption() ?></span></td>
        <td data-name="typeEs"<?= $Page->typeEs->cellAttributes() ?>>
<span id="el_conf_schooltype_typeEs">
<span<?= $Page->typeEs->viewAttributes() ?>>
<?= $Page->typeEs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->typeEn->Visible) { // typeEn ?>
    <tr id="r_typeEn"<?= $Page->typeEn->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_schooltype_typeEn"><?= $Page->typeEn->caption() ?></span></td>
        <td data-name="typeEn"<?= $Page->typeEn->cellAttributes() ?>>
<span id="el_conf_schooltype_typeEn">
<span<?= $Page->typeEn->viewAttributes() ?>>
<?= $Page->typeEn->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
    <tr id="r_federationId"<?= $Page->federationId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_schooltype_federationId"><?= $Page->federationId->caption() ?></span></td>
        <td data-name="federationId"<?= $Page->federationId->cellAttributes() ?>>
<span id="el_conf_schooltype_federationId">
<span<?= $Page->federationId->viewAttributes() ?>>
<?= $Page->federationId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->registerDate->Visible) { // registerDate ?>
    <tr id="r_registerDate"<?= $Page->registerDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_schooltype_registerDate"><?= $Page->registerDate->caption() ?></span></td>
        <td data-name="registerDate"<?= $Page->registerDate->cellAttributes() ?>>
<span id="el_conf_schooltype_registerDate">
<span<?= $Page->registerDate->viewAttributes() ?>>
<?= $Page->registerDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->licensevalue->Visible) { // licensevalue ?>
    <tr id="r_licensevalue"<?= $Page->licensevalue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_schooltype_licensevalue"><?= $Page->licensevalue->caption() ?></span></td>
        <td data-name="licensevalue"<?= $Page->licensevalue->cellAttributes() ?>>
<span id="el_conf_schooltype_licensevalue">
<span<?= $Page->licensevalue->viewAttributes() ?>>
<?= $Page->licensevalue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_default->Visible) { // default ?>
    <tr id="r__default"<?= $Page->_default->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_schooltype__default"><?= $Page->_default->caption() ?></span></td>
        <td data-name="_default"<?= $Page->_default->cellAttributes() ?>>
<span id="el_conf_schooltype__default">
<span<?= $Page->_default->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x__default_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->_default->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->_default->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x__default_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
