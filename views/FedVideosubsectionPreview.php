<?php

namespace PHPMaker2022\school;

// Page object
$FedVideosubsectionPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { fed_videosubsection: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid fed_videosubsection"><!-- .card -->
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
<?php if ($Page->section->Visible) { // section ?>
    <?php if ($Page->SortUrl($Page->section) == "") { ?>
        <th class="<?= $Page->section->headerCellClass() ?>"><?= $Page->section->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->section->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->section->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->section->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->section->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->section->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
    <?php if ($Page->SortUrl($Page->subsection) == "") { ?>
        <th class="<?= $Page->subsection->headerCellClass() ?>"><?= $Page->subsection->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->subsection->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->subsection->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->subsection->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->subsection->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->subsection->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->subsectionBr->Visible) { // subsectionBr ?>
    <?php if ($Page->SortUrl($Page->subsectionBr) == "") { ?>
        <th class="<?= $Page->subsectionBr->headerCellClass() ?>"><?= $Page->subsectionBr->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->subsectionBr->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->subsectionBr->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->subsectionBr->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->subsectionBr->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->subsectionBr->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->subsectionSp->Visible) { // subsectionSp ?>
    <?php if ($Page->SortUrl($Page->subsectionSp) == "") { ?>
        <th class="<?= $Page->subsectionSp->headerCellClass() ?>"><?= $Page->subsectionSp->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->subsectionSp->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->subsectionSp->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->subsectionSp->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->subsectionSp->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->subsectionSp->getSortIcon() ?></span>
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
<?php if ($Page->section->Visible) { // section ?>
        <!-- section -->
        <td<?= $Page->section->cellAttributes() ?>>
<span<?= $Page->section->viewAttributes() ?>>
<?= $Page->section->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
        <!-- subsection -->
        <td<?= $Page->subsection->cellAttributes() ?>>
<span<?= $Page->subsection->viewAttributes() ?>>
<?= $Page->subsection->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->subsectionBr->Visible) { // subsectionBr ?>
        <!-- subsectionBr -->
        <td<?= $Page->subsectionBr->cellAttributes() ?>>
<span<?= $Page->subsectionBr->viewAttributes() ?>>
<?= $Page->subsectionBr->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->subsectionSp->Visible) { // subsectionSp ?>
        <!-- subsectionSp -->
        <td<?= $Page->subsectionSp->cellAttributes() ?>>
<span<?= $Page->subsectionSp->viewAttributes() ?>>
<?= $Page->subsectionSp->getViewValue() ?></span>
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
