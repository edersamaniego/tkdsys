<?php

namespace PHPMaker2022\school;

// Page object
$FedLicenseschoolPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { fed_licenseschool: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid fed_licenseschool"><!-- .card -->
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
<?php if ($Page->application->Visible) { // application ?>
    <?php if ($Page->SortUrl($Page->application) == "") { ?>
        <th class="<?= $Page->application->headerCellClass() ?>"><?= $Page->application->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->application->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->application->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->application->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->application->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->application->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dateLicense->Visible) { // dateLicense ?>
    <?php if ($Page->SortUrl($Page->dateLicense) == "") { ?>
        <th class="<?= $Page->dateLicense->headerCellClass() ?>"><?= $Page->dateLicense->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dateLicense->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->dateLicense->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->dateLicense->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->dateLicense->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->dateLicense->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dateStart->Visible) { // dateStart ?>
    <?php if ($Page->SortUrl($Page->dateStart) == "") { ?>
        <th class="<?= $Page->dateStart->headerCellClass() ?>"><?= $Page->dateStart->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dateStart->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->dateStart->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->dateStart->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->dateStart->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->dateStart->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->dateFinish->Visible) { // dateFinish ?>
    <?php if ($Page->SortUrl($Page->dateFinish) == "") { ?>
        <th class="<?= $Page->dateFinish->headerCellClass() ?>"><?= $Page->dateFinish->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dateFinish->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->dateFinish->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->dateFinish->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->dateFinish->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->dateFinish->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->schooltype->Visible) { // schooltype ?>
    <?php if ($Page->SortUrl($Page->schooltype) == "") { ?>
        <th class="<?= $Page->schooltype->headerCellClass() ?>"><?= $Page->schooltype->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->schooltype->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->schooltype->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->schooltype->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->schooltype->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->schooltype->getSortIcon() ?></span>
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
<?php if ($Page->application->Visible) { // application ?>
        <!-- application -->
        <td<?= $Page->application->cellAttributes() ?>>
<span<?= $Page->application->viewAttributes() ?>>
<?= $Page->application->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dateLicense->Visible) { // dateLicense ?>
        <!-- dateLicense -->
        <td<?= $Page->dateLicense->cellAttributes() ?>>
<span<?= $Page->dateLicense->viewAttributes() ?>>
<?= $Page->dateLicense->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dateStart->Visible) { // dateStart ?>
        <!-- dateStart -->
        <td<?= $Page->dateStart->cellAttributes() ?>>
<span<?= $Page->dateStart->viewAttributes() ?>>
<?= $Page->dateStart->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->dateFinish->Visible) { // dateFinish ?>
        <!-- dateFinish -->
        <td<?= $Page->dateFinish->cellAttributes() ?>>
<span<?= $Page->dateFinish->viewAttributes() ?>>
<?= $Page->dateFinish->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->schooltype->Visible) { // schooltype ?>
        <!-- schooltype -->
        <td<?= $Page->schooltype->cellAttributes() ?>>
<span<?= $Page->schooltype->viewAttributes() ?>>
<?= $Page->schooltype->getViewValue() ?></span>
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
