<?php

namespace PHPMaker2022\school;

// Page object
$ConfCountryDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_country: currentTable } });
var currentForm, currentPageID;
var fconf_countrydelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_countrydelete = new ew.Form("fconf_countrydelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_countrydelete;
    loadjs.done("fconf_countrydelete");
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
<form name="fconf_countrydelete" id="fconf_countrydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_country">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_country_id" class="conf_country_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
        <th class="<?= $Page->country->headerCellClass() ?>"><span id="elh_conf_country_country" class="conf_country_country"><?= $Page->country->caption() ?></span></th>
<?php } ?>
<?php if ($Page->countryLanguage->Visible) { // countryLanguage ?>
        <th class="<?= $Page->countryLanguage->headerCellClass() ?>"><span id="elh_conf_country_countryLanguage" class="conf_country_countryLanguage"><?= $Page->countryLanguage->caption() ?></span></th>
<?php } ?>
<?php if ($Page->countryFlag->Visible) { // countryFlag ?>
        <th class="<?= $Page->countryFlag->headerCellClass() ?>"><span id="elh_conf_country_countryFlag" class="conf_country_countryFlag"><?= $Page->countryFlag->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_conf_country_id" class="el_conf_country_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
        <td<?= $Page->country->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_country_country" class="el_conf_country_country">
<span<?= $Page->country->viewAttributes() ?>>
<?= $Page->country->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->countryLanguage->Visible) { // countryLanguage ?>
        <td<?= $Page->countryLanguage->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_country_countryLanguage" class="el_conf_country_countryLanguage">
<span<?= $Page->countryLanguage->viewAttributes() ?>>
<?= $Page->countryLanguage->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->countryFlag->Visible) { // countryFlag ?>
        <td<?= $Page->countryFlag->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_country_countryFlag" class="el_conf_country_countryFlag">
<span<?= $Page->countryFlag->viewAttributes() ?>>
<?= $Page->countryFlag->getViewValue() ?></span>
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
