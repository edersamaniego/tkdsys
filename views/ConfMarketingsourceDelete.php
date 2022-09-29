<?php

namespace PHPMaker2022\school;

// Page object
$ConfMarketingsourceDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_marketingsource: currentTable } });
var currentForm, currentPageID;
var fconf_marketingsourcedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_marketingsourcedelete = new ew.Form("fconf_marketingsourcedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_marketingsourcedelete;
    loadjs.done("fconf_marketingsourcedelete");
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
<form name="fconf_marketingsourcedelete" id="fconf_marketingsourcedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_marketingsource">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_marketingsource_id" class="conf_marketingsource_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->marketingsourceBR->Visible) { // marketingsourceBR ?>
        <th class="<?= $Page->marketingsourceBR->headerCellClass() ?>"><span id="elh_conf_marketingsource_marketingsourceBR" class="conf_marketingsource_marketingsourceBR"><?= $Page->marketingsourceBR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->marketingsourceEN->Visible) { // marketingsourceEN ?>
        <th class="<?= $Page->marketingsourceEN->headerCellClass() ?>"><span id="elh_conf_marketingsource_marketingsourceEN" class="conf_marketingsource_marketingsourceEN"><?= $Page->marketingsourceEN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->marketingsourceSP->Visible) { // marketingsourceSP ?>
        <th class="<?= $Page->marketingsourceSP->headerCellClass() ?>"><span id="elh_conf_marketingsource_marketingsourceSP" class="conf_marketingsource_marketingsourceSP"><?= $Page->marketingsourceSP->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_conf_marketingsource_id" class="el_conf_marketingsource_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->marketingsourceBR->Visible) { // marketingsourceBR ?>
        <td<?= $Page->marketingsourceBR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_marketingsource_marketingsourceBR" class="el_conf_marketingsource_marketingsourceBR">
<span<?= $Page->marketingsourceBR->viewAttributes() ?>>
<?= $Page->marketingsourceBR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->marketingsourceEN->Visible) { // marketingsourceEN ?>
        <td<?= $Page->marketingsourceEN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_marketingsource_marketingsourceEN" class="el_conf_marketingsource_marketingsourceEN">
<span<?= $Page->marketingsourceEN->viewAttributes() ?>>
<?= $Page->marketingsourceEN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->marketingsourceSP->Visible) { // marketingsourceSP ?>
        <td<?= $Page->marketingsourceSP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_marketingsource_marketingsourceSP" class="el_conf_marketingsource_marketingsourceSP">
<span<?= $Page->marketingsourceSP->viewAttributes() ?>>
<?= $Page->marketingsourceSP->getViewValue() ?></span>
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
