<?php

namespace PHPMaker2022\school;

// Page object
$ConfCityDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_city: currentTable } });
var currentForm, currentPageID;
var fconf_citydelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_citydelete = new ew.Form("fconf_citydelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_citydelete;
    loadjs.done("fconf_citydelete");
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
<form name="fconf_citydelete" id="fconf_citydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_city">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_city_id" class="conf_city_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
        <th class="<?= $Page->city->headerCellClass() ?>"><span id="elh_conf_city_city" class="conf_city_city"><?= $Page->city->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
        <th class="<?= $Page->uf->headerCellClass() ?>"><span id="elh_conf_city_uf" class="conf_city_uf"><?= $Page->uf->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ufId->Visible) { // ufId ?>
        <th class="<?= $Page->ufId->headerCellClass() ?>"><span id="elh_conf_city_ufId" class="conf_city_ufId"><?= $Page->ufId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->county->Visible) { // county ?>
        <th class="<?= $Page->county->headerCellClass() ?>"><span id="elh_conf_city_county" class="conf_city_county"><?= $Page->county->caption() ?></span></th>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
        <th class="<?= $Page->longitude->headerCellClass() ?>"><span id="elh_conf_city_longitude" class="conf_city_longitude"><?= $Page->longitude->caption() ?></span></th>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
        <th class="<?= $Page->latitude->headerCellClass() ?>"><span id="elh_conf_city_latitude" class="conf_city_latitude"><?= $Page->latitude->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_conf_city_id" class="el_conf_city_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
        <td<?= $Page->city->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_city_city" class="el_conf_city_city">
<span<?= $Page->city->viewAttributes() ?>>
<?= $Page->city->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
        <td<?= $Page->uf->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_city_uf" class="el_conf_city_uf">
<span<?= $Page->uf->viewAttributes() ?>>
<?= $Page->uf->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ufId->Visible) { // ufId ?>
        <td<?= $Page->ufId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_city_ufId" class="el_conf_city_ufId">
<span<?= $Page->ufId->viewAttributes() ?>>
<?= $Page->ufId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->county->Visible) { // county ?>
        <td<?= $Page->county->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_city_county" class="el_conf_city_county">
<span<?= $Page->county->viewAttributes() ?>>
<?= $Page->county->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
        <td<?= $Page->longitude->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_city_longitude" class="el_conf_city_longitude">
<span<?= $Page->longitude->viewAttributes() ?>>
<?= $Page->longitude->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
        <td<?= $Page->latitude->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_city_latitude" class="el_conf_city_latitude">
<span<?= $Page->latitude->viewAttributes() ?>>
<?= $Page->latitude->getViewValue() ?></span>
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
