<?php

namespace PHPMaker2022\school;

// Page object
$ConfScholarityDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_scholarity: currentTable } });
var currentForm, currentPageID;
var fconf_scholaritydelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_scholaritydelete = new ew.Form("fconf_scholaritydelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_scholaritydelete;
    loadjs.done("fconf_scholaritydelete");
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
<form name="fconf_scholaritydelete" id="fconf_scholaritydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_scholarity">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_scholarity_id" class="conf_scholarity_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->escolarityBR->Visible) { // escolarityBR ?>
        <th class="<?= $Page->escolarityBR->headerCellClass() ?>"><span id="elh_conf_scholarity_escolarityBR" class="conf_scholarity_escolarityBR"><?= $Page->escolarityBR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->escolarityEN->Visible) { // escolarityEN ?>
        <th class="<?= $Page->escolarityEN->headerCellClass() ?>"><span id="elh_conf_scholarity_escolarityEN" class="conf_scholarity_escolarityEN"><?= $Page->escolarityEN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->escolaritySP->Visible) { // escolaritySP ?>
        <th class="<?= $Page->escolaritySP->headerCellClass() ?>"><span id="elh_conf_scholarity_escolaritySP" class="conf_scholarity_escolaritySP"><?= $Page->escolaritySP->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_conf_scholarity_id" class="el_conf_scholarity_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->escolarityBR->Visible) { // escolarityBR ?>
        <td<?= $Page->escolarityBR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_scholarity_escolarityBR" class="el_conf_scholarity_escolarityBR">
<span<?= $Page->escolarityBR->viewAttributes() ?>>
<?= $Page->escolarityBR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->escolarityEN->Visible) { // escolarityEN ?>
        <td<?= $Page->escolarityEN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_scholarity_escolarityEN" class="el_conf_scholarity_escolarityEN">
<span<?= $Page->escolarityEN->viewAttributes() ?>>
<?= $Page->escolarityEN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->escolaritySP->Visible) { // escolaritySP ?>
        <td<?= $Page->escolaritySP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_scholarity_escolaritySP" class="el_conf_scholarity_escolaritySP">
<span<?= $Page->escolaritySP->viewAttributes() ?>>
<?= $Page->escolaritySP->getViewValue() ?></span>
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
