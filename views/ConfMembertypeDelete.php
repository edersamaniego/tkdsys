<?php

namespace PHPMaker2022\school;

// Page object
$ConfMembertypeDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_membertype: currentTable } });
var currentForm, currentPageID;
var fconf_membertypedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_membertypedelete = new ew.Form("fconf_membertypedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_membertypedelete;
    loadjs.done("fconf_membertypedelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fconf_membertypedelete" id="fconf_membertypedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_membertype">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_membertype_id" class="conf_membertype_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <th class="<?= $Page->type->headerCellClass() ?>"><span id="elh_conf_membertype_type" class="conf_membertype_type"><?= $Page->type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isStudent->Visible) { // isStudent ?>
        <th class="<?= $Page->isStudent->headerCellClass() ?>"><span id="elh_conf_membertype_isStudent" class="conf_membertype_isStudent"><?= $Page->isStudent->caption() ?></span></th>
<?php } ?>
<?php if ($Page->isOwner->Visible) { // isOwner ?>
        <th class="<?= $Page->isOwner->headerCellClass() ?>"><span id="elh_conf_membertype_isOwner" class="conf_membertype_isOwner"><?= $Page->isOwner->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_membertype_id" class="el_conf_membertype_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
        <td<?= $Page->type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_membertype_type" class="el_conf_membertype_type">
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isStudent->Visible) { // isStudent ?>
        <td<?= $Page->isStudent->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_membertype_isStudent" class="el_conf_membertype_isStudent">
<span<?= $Page->isStudent->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isStudent_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isStudent->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isStudent->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isStudent_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->isOwner->Visible) { // isOwner ?>
        <td<?= $Page->isOwner->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_membertype_isOwner" class="el_conf_membertype_isOwner">
<span<?= $Page->isOwner->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isOwner_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isOwner->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isOwner->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isOwner_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
