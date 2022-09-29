<?php

namespace PHPMaker2022\school;

// Page object
$FedFederationDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_federation: currentTable } });
var currentForm, currentPageID;
var ffed_federationdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_federationdelete = new ew.Form("ffed_federationdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_federationdelete;
    loadjs.done("ffed_federationdelete");
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
<form name="ffed_federationdelete" id="ffed_federationdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_federation">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fed_federation_id" class="fed_federation_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->federation->Visible) { // federation ?>
        <th class="<?= $Page->federation->headerCellClass() ?>"><span id="elh_fed_federation_federation" class="fed_federation_federation"><?= $Page->federation->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ceo->Visible) { // ceo ?>
        <th class="<?= $Page->ceo->headerCellClass() ?>"><span id="elh_fed_federation_ceo" class="fed_federation_ceo"><?= $Page->ceo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <th class="<?= $Page->createUserId->headerCellClass() ?>"><span id="elh_fed_federation_createUserId" class="fed_federation_createUserId"><?= $Page->createUserId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th class="<?= $Page->createDate->headerCellClass() ?>"><span id="elh_fed_federation_createDate" class="fed_federation_createDate"><?= $Page->createDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->federationMasterId->Visible) { // federationMasterId ?>
        <th class="<?= $Page->federationMasterId->headerCellClass() ?>"><span id="elh_fed_federation_federationMasterId" class="fed_federation_federationMasterId"><?= $Page->federationMasterId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fed_federation_id" class="el_fed_federation_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->federation->Visible) { // federation ?>
        <td<?= $Page->federation->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_federation_federation" class="el_fed_federation_federation">
<span<?= $Page->federation->viewAttributes() ?>>
<?= $Page->federation->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ceo->Visible) { // ceo ?>
        <td<?= $Page->ceo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_federation_ceo" class="el_fed_federation_ceo">
<span<?= $Page->ceo->viewAttributes() ?>>
<?= $Page->ceo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <td<?= $Page->createUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_federation_createUserId" class="el_fed_federation_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <td<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_federation_createDate" class="el_fed_federation_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->federationMasterId->Visible) { // federationMasterId ?>
        <td<?= $Page->federationMasterId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_federation_federationMasterId" class="el_fed_federation_federationMasterId">
<span<?= $Page->federationMasterId->viewAttributes() ?>>
<?= $Page->federationMasterId->getViewValue() ?></span>
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
