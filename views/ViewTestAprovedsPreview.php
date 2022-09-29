<?php

namespace PHPMaker2022\school;

// Page object
$ViewTestAprovedsPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { view_test_aproveds: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid view_test_aproveds"><!-- .card -->
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel ew-preview-middle-panel"><!-- .table-responsive -->
<table class="table table-bordered table-hover table-sm ew-table ew-preview-table"><!-- .table -->
    <thead><!-- Table header -->
        <tr class="ew-table-header">
<?php
// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
    <?php if ($Page->SortUrl($Page->id) == "") { ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><?= $Page->id->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->id->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->id->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->id->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->id->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
    <?php if ($Page->SortUrl($Page->memberId) == "") { ?>
        <th class="<?= $Page->memberId->headerCellClass() ?>"><?= $Page->memberId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->memberId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->memberId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->memberId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->memberId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->memberId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nextRankId->Visible) { // nextRankId ?>
    <?php if ($Page->SortUrl($Page->nextRankId) == "") { ?>
        <th class="<?= $Page->nextRankId->headerCellClass() ?>"><?= $Page->nextRankId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nextRankId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->nextRankId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nextRankId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nextRankId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nextRankId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->memberAge->Visible) { // memberAge ?>
    <?php if ($Page->SortUrl($Page->memberAge) == "") { ?>
        <th class="<?= $Page->memberAge->headerCellClass() ?>"><?= $Page->memberAge->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->memberAge->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->memberAge->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->memberAge->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->memberAge->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->memberAge->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->renew->Visible) { // renew ?>
    <?php if ($Page->SortUrl($Page->renew) == "") { ?>
        <th class="<?= $Page->renew->headerCellClass() ?>"><?= $Page->renew->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->renew->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->renew->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->renew->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->renew->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->renew->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->memberDOB->Visible) { // memberDOB ?>
    <?php if ($Page->SortUrl($Page->memberDOB) == "") { ?>
        <th class="<?= $Page->memberDOB->headerCellClass() ?>"><?= $Page->memberDOB->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->memberDOB->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->memberDOB->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->memberDOB->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->memberDOB->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->memberDOB->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
        </tr>
    </thead>
    <tbody><!-- Table body -->
<?php
$Page->RecCount = 0;
$Page->RowCount = 0;
while ($Page->Recordset && !$Page->Recordset->EOF) {
    // Init row class and style
    $Page->RecCount++;
    $Page->RowCount++;
    $Page->CssStyle = "";
    $Page->loadListRowValues($Page->Recordset);

    // Render row
    $Page->RowType = ROWTYPE_PREVIEW; // Preview record
    $Page->resetAttributes();
    $Page->renderListRow();

    // Render list options
    $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
<?php if ($Page->id->Visible) { // id ?>
        <!-- id -->
        <td<?= $Page->id->cellAttributes() ?>>
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <!-- memberId -->
        <td<?= $Page->memberId->cellAttributes() ?>>
<span<?= $Page->memberId->viewAttributes() ?>>
<?php if (!EmptyString($Page->memberId->getViewValue()) && $Page->memberId->linkAttributes() != "") { ?>
<a<?= $Page->memberId->linkAttributes() ?>><?= $Page->memberId->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->memberId->getViewValue() ?>
<?php } ?>
</span>
</td>
<?php } ?>
<?php if ($Page->nextRankId->Visible) { // nextRankId ?>
        <!-- nextRankId -->
        <td<?= $Page->nextRankId->cellAttributes() ?>>
<span<?= $Page->nextRankId->viewAttributes() ?>>
<?= $Page->nextRankId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->memberAge->Visible) { // memberAge ?>
        <!-- memberAge -->
        <td<?= $Page->memberAge->cellAttributes() ?>>
<span<?= $Page->memberAge->viewAttributes() ?>>
<?= $Page->memberAge->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->renew->Visible) { // renew ?>
        <!-- renew -->
        <td<?= $Page->renew->cellAttributes() ?>>
<span<?= $Page->renew->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_renew_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->renew->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->renew->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_renew_<?= $Page->RowCount ?>"></label>
</div></span>
</td>
<?php } ?>
<?php if ($Page->memberDOB->Visible) { // memberDOB ?>
        <!-- memberDOB -->
        <td<?= $Page->memberDOB->cellAttributes() ?>>
<span<?= $Page->memberDOB->viewAttributes() ?>>
<?= $Page->memberDOB->getViewValue() ?></span>
</td>
<?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    $Page->Recordset->moveNext();
} // while
?>
    </tbody>
</table><!-- /.table -->
</div><!-- /.table-responsive -->
<div class="card-footer ew-grid-lower-panel ew-preview-lower-panel"><!-- .card-footer -->
<?= $Page->Pager->render() ?>
<?php } else { // No record ?>
<div class="card no-border">
<div class="ew-detail-count"><?= $Language->phrase("NoRecord") ?></div>
<?php } ?>
<div class="ew-preview-other-options">
<?php
    foreach ($Page->OtherOptions as $option)
        $option->render("body");
?>
</div>
<?php if ($Page->TotalRecords > 0) { ?>
</div><!-- /.card-footer -->
<?php } ?>
</div><!-- /.card -->
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
