<?php

namespace PHPMaker2022\school;

// Page object
$ConfUfDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_uf: currentTable } });
var currentForm, currentPageID;
var fconf_ufdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_ufdelete = new ew.Form("fconf_ufdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_ufdelete;
    loadjs.done("fconf_ufdelete");
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
<form name="fconf_ufdelete" id="fconf_ufdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_uf">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_uf_id" class="conf_uf_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->UF->Visible) { // UF ?>
        <th class="<?= $Page->UF->headerCellClass() ?>"><span id="elh_conf_uf_UF" class="conf_uf_UF"><?= $Page->UF->caption() ?></span></th>
<?php } ?>
<?php if ($Page->abbreviation->Visible) { // abbreviation ?>
        <th class="<?= $Page->abbreviation->headerCellClass() ?>"><span id="elh_conf_uf_abbreviation" class="conf_uf_abbreviation"><?= $Page->abbreviation->caption() ?></span></th>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
        <th class="<?= $Page->countryId->headerCellClass() ?>"><span id="elh_conf_uf_countryId" class="conf_uf_countryId"><?= $Page->countryId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_conf_uf_id" class="el_conf_uf_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->UF->Visible) { // UF ?>
        <td<?= $Page->UF->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_uf_UF" class="el_conf_uf_UF">
<span<?= $Page->UF->viewAttributes() ?>>
<?= $Page->UF->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->abbreviation->Visible) { // abbreviation ?>
        <td<?= $Page->abbreviation->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_uf_abbreviation" class="el_conf_uf_abbreviation">
<span<?= $Page->abbreviation->viewAttributes() ?>>
<?= $Page->abbreviation->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
        <td<?= $Page->countryId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_uf_countryId" class="el_conf_uf_countryId">
<span<?= $Page->countryId->viewAttributes() ?>>
<?= $Page->countryId->getViewValue() ?></span>
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
