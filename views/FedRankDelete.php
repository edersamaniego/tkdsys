<?php

namespace PHPMaker2022\school;

// Page object
$FedRankDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_rank: currentTable } });
var currentForm, currentPageID;
var ffed_rankdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_rankdelete = new ew.Form("ffed_rankdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_rankdelete;
    loadjs.done("ffed_rankdelete");
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
<form name="ffed_rankdelete" id="ffed_rankdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_rank">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fed_rank_id" class="fed_rank_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rankBR->Visible) { // rankBR ?>
        <th class="<?= $Page->rankBR->headerCellClass() ?>"><span id="elh_fed_rank_rankBR" class="fed_rank_rankBR"><?= $Page->rankBR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rankUS->Visible) { // rankUS ?>
        <th class="<?= $Page->rankUS->headerCellClass() ?>"><span id="elh_fed_rank_rankUS" class="fed_rank_rankUS"><?= $Page->rankUS->caption() ?></span></th>
<?php } ?>
<?php if ($Page->rankES->Visible) { // rankES ?>
        <th class="<?= $Page->rankES->headerCellClass() ?>"><span id="elh_fed_rank_rankES" class="fed_rank_rankES"><?= $Page->rankES->caption() ?></span></th>
<?php } ?>
<?php if ($Page->ranking->Visible) { // ranking ?>
        <th class="<?= $Page->ranking->headerCellClass() ?>"><span id="elh_fed_rank_ranking" class="fed_rank_ranking"><?= $Page->ranking->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nextrankId->Visible) { // nextrankId ?>
        <th class="<?= $Page->nextrankId->headerCellClass() ?>"><span id="elh_fed_rank_nextrankId" class="fed_rank_nextrankId"><?= $Page->nextrankId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fed_rank_id" class="el_fed_rank_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rankBR->Visible) { // rankBR ?>
        <td<?= $Page->rankBR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_rank_rankBR" class="el_fed_rank_rankBR">
<span<?= $Page->rankBR->viewAttributes() ?>>
<?= $Page->rankBR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rankUS->Visible) { // rankUS ?>
        <td<?= $Page->rankUS->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_rank_rankUS" class="el_fed_rank_rankUS">
<span<?= $Page->rankUS->viewAttributes() ?>>
<?= $Page->rankUS->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->rankES->Visible) { // rankES ?>
        <td<?= $Page->rankES->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_rank_rankES" class="el_fed_rank_rankES">
<span<?= $Page->rankES->viewAttributes() ?>>
<?= $Page->rankES->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->ranking->Visible) { // ranking ?>
        <td<?= $Page->ranking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_rank_ranking" class="el_fed_rank_ranking">
<span<?= $Page->ranking->viewAttributes() ?>>
<?= $Page->ranking->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nextrankId->Visible) { // nextrankId ?>
        <td<?= $Page->nextrankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_rank_nextrankId" class="el_fed_rank_nextrankId">
<span<?= $Page->nextrankId->viewAttributes() ?>>
<?= $Page->nextrankId->getViewValue() ?></span>
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
