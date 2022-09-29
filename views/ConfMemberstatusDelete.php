<?php

namespace PHPMaker2022\school;

// Page object
$ConfMemberstatusDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_memberstatus: currentTable } });
var currentForm, currentPageID;
var fconf_memberstatusdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_memberstatusdelete = new ew.Form("fconf_memberstatusdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_memberstatusdelete;
    loadjs.done("fconf_memberstatusdelete");
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
<form name="fconf_memberstatusdelete" id="fconf_memberstatusdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_memberstatus">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_memberstatus_id" class="conf_memberstatus_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->statusES->Visible) { // statusES ?>
        <th class="<?= $Page->statusES->headerCellClass() ?>"><span id="elh_conf_memberstatus_statusES" class="conf_memberstatus_statusES"><?= $Page->statusES->caption() ?></span></th>
<?php } ?>
<?php if ($Page->statusEN->Visible) { // statusEN ?>
        <th class="<?= $Page->statusEN->headerCellClass() ?>"><span id="elh_conf_memberstatus_statusEN" class="conf_memberstatus_statusEN"><?= $Page->statusEN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_conf_memberstatus_status" class="conf_memberstatus_status"><?= $Page->status->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_conf_memberstatus_id" class="el_conf_memberstatus_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->statusES->Visible) { // statusES ?>
        <td<?= $Page->statusES->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_memberstatus_statusES" class="el_conf_memberstatus_statusES">
<span<?= $Page->statusES->viewAttributes() ?>>
<?= $Page->statusES->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->statusEN->Visible) { // statusEN ?>
        <td<?= $Page->statusEN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_memberstatus_statusEN" class="el_conf_memberstatus_statusEN">
<span<?= $Page->statusEN->viewAttributes() ?>>
<?= $Page->statusEN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_memberstatus_status" class="el_conf_memberstatus_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
