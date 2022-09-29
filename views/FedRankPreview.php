<?php

namespace PHPMaker2022\school;

// Page object
$FedRankPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { fed_rank: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid fed_rank"><!-- .card -->
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
<?php if ($Page->rankBR->Visible) { // rankBR ?>
    <?php if ($Page->SortUrl($Page->rankBR) == "") { ?>
        <th class="<?= $Page->rankBR->headerCellClass() ?>"><?= $Page->rankBR->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->rankBR->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->rankBR->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->rankBR->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->rankBR->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->rankBR->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->rankUS->Visible) { // rankUS ?>
    <?php if ($Page->SortUrl($Page->rankUS) == "") { ?>
        <th class="<?= $Page->rankUS->headerCellClass() ?>"><?= $Page->rankUS->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->rankUS->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->rankUS->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->rankUS->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->rankUS->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->rankUS->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->rankES->Visible) { // rankES ?>
    <?php if ($Page->SortUrl($Page->rankES) == "") { ?>
        <th class="<?= $Page->rankES->headerCellClass() ?>"><?= $Page->rankES->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->rankES->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->rankES->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->rankES->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->rankES->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->rankES->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->ranking->Visible) { // ranking ?>
    <?php if ($Page->SortUrl($Page->ranking) == "") { ?>
        <th class="<?= $Page->ranking->headerCellClass() ?>"><?= $Page->ranking->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->ranking->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->ranking->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->ranking->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->ranking->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->ranking->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->nextrankId->Visible) { // nextrankId ?>
    <?php if ($Page->SortUrl($Page->nextrankId) == "") { ?>
        <th class="<?= $Page->nextrankId->headerCellClass() ?>"><?= $Page->nextrankId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->nextrankId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->nextrankId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->nextrankId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->nextrankId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->nextrankId->getSortIcon() ?></span>
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
<?php if ($Page->rankBR->Visible) { // rankBR ?>
        <!-- rankBR -->
        <td<?= $Page->rankBR->cellAttributes() ?>>
<span<?= $Page->rankBR->viewAttributes() ?>>
<?= $Page->rankBR->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->rankUS->Visible) { // rankUS ?>
        <!-- rankUS -->
        <td<?= $Page->rankUS->cellAttributes() ?>>
<span<?= $Page->rankUS->viewAttributes() ?>>
<?= $Page->rankUS->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->rankES->Visible) { // rankES ?>
        <!-- rankES -->
        <td<?= $Page->rankES->cellAttributes() ?>>
<span<?= $Page->rankES->viewAttributes() ?>>
<?= $Page->rankES->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->ranking->Visible) { // ranking ?>
        <!-- ranking -->
        <td<?= $Page->ranking->cellAttributes() ?>>
<span<?= $Page->ranking->viewAttributes() ?>>
<?= $Page->ranking->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->nextrankId->Visible) { // nextrankId ?>
        <!-- nextrankId -->
        <td<?= $Page->nextrankId->cellAttributes() ?>>
<span<?= $Page->nextrankId->viewAttributes() ?>>
<?= $Page->nextrankId->getViewValue() ?></span>
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
