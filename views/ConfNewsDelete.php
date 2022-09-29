<?php

namespace PHPMaker2022\school;

// Page object
$ConfNewsDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_news: currentTable } });
var currentForm, currentPageID;
var fconf_newsdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_newsdelete = new ew.Form("fconf_newsdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_newsdelete;
    loadjs.done("fconf_newsdelete");
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
<form name="fconf_newsdelete" id="fconf_newsdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_news">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_news_id" class="conf_news_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th class="<?= $Page->date->headerCellClass() ?>"><span id="elh_conf_news_date" class="conf_news_date"><?= $Page->date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->descriptionEN->Visible) { // descriptionEN ?>
        <th class="<?= $Page->descriptionEN->headerCellClass() ?>"><span id="elh_conf_news_descriptionEN" class="conf_news_descriptionEN"><?= $Page->descriptionEN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
        <th class="<?= $Page->link->headerCellClass() ?>"><span id="elh_conf_news_link" class="conf_news_link"><?= $Page->link->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_conf_news_id" class="el_conf_news_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <td<?= $Page->date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_news_date" class="el_conf_news_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->descriptionEN->Visible) { // descriptionEN ?>
        <td<?= $Page->descriptionEN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_news_descriptionEN" class="el_conf_news_descriptionEN">
<span<?= $Page->descriptionEN->viewAttributes() ?>>
<?= $Page->descriptionEN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->link->Visible) { // link ?>
        <td<?= $Page->link->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_news_link" class="el_conf_news_link">
<span<?= $Page->link->viewAttributes() ?>>
<?= $Page->link->getViewValue() ?></span>
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
