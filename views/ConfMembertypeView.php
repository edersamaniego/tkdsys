<?php

namespace PHPMaker2022\school;

// Page object
$ConfMembertypeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_membertype: currentTable } });
var currentForm, currentPageID;
var fconf_membertypeview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_membertypeview = new ew.Form("fconf_membertypeview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fconf_membertypeview;
    loadjs.done("fconf_membertypeview");
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
<form name="fconf_membertypeview" id="fconf_membertypeview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_membertype">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_membertype_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_membertype_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
    <tr id="r_type"<?= $Page->type->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_membertype_type"><?= $Page->type->caption() ?></span></td>
        <td data-name="type"<?= $Page->type->cellAttributes() ?>>
<span id="el_conf_membertype_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isStudent->Visible) { // isStudent ?>
    <tr id="r_isStudent"<?= $Page->isStudent->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_membertype_isStudent"><?= $Page->isStudent->caption() ?></span></td>
        <td data-name="isStudent"<?= $Page->isStudent->cellAttributes() ?>>
<span id="el_conf_membertype_isStudent">
<span<?= $Page->isStudent->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isStudent_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isStudent->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isStudent->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isStudent_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->isOwner->Visible) { // isOwner ?>
    <tr id="r_isOwner"<?= $Page->isOwner->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_membertype_isOwner"><?= $Page->isOwner->caption() ?></span></td>
        <td data-name="isOwner"<?= $Page->isOwner->cellAttributes() ?>>
<span id="el_conf_membertype_isOwner">
<span<?= $Page->isOwner->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isOwner_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isOwner->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isOwner->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isOwner_<?= $Page->RowCount ?>"></label>
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
