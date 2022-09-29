<?php

namespace PHPMaker2022\school;

// Page object
$FinOrderdetailsPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { fin_orderdetails: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid fin_orderdetails"><!-- .card -->
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
<?php if ($Page->orderId->Visible) { // orderId ?>
    <?php if ($Page->SortUrl($Page->orderId) == "") { ?>
        <th class="<?= $Page->orderId->headerCellClass() ?>"><?= $Page->orderId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->orderId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->orderId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->orderId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->orderId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->orderId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->item->Visible) { // item ?>
    <?php if ($Page->SortUrl($Page->item) == "") { ?>
        <th class="<?= $Page->item->headerCellClass() ?>"><?= $Page->item->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->item->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->item->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->item->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->item->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->item->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
    <?php if ($Page->SortUrl($Page->amount) == "") { ?>
        <th class="<?= $Page->amount->headerCellClass() ?>"><?= $Page->amount->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->amount->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->amount->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->amount->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->amount->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->amount->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <?php if ($Page->SortUrl($Page->value) == "") { ?>
        <th class="<?= $Page->value->headerCellClass() ?>"><?= $Page->value->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->value->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->value->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->value->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->value->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->value->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->discountId->Visible) { // discountId ?>
    <?php if ($Page->SortUrl($Page->discountId) == "") { ?>
        <th class="<?= $Page->discountId->headerCellClass() ?>"><?= $Page->discountId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->discountId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->discountId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->discountId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->discountId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->discountId->getSortIcon() ?></span>
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
<?php if ($Page->orderId->Visible) { // orderId ?>
        <!-- orderId -->
        <td<?= $Page->orderId->cellAttributes() ?>>
<span<?= $Page->orderId->viewAttributes() ?>>
<?= $Page->orderId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->item->Visible) { // item ?>
        <!-- item -->
        <td<?= $Page->item->cellAttributes() ?>>
<span<?= $Page->item->viewAttributes() ?>>
<?= $Page->item->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->amount->Visible) { // amount ?>
        <!-- amount -->
        <td<?= $Page->amount->cellAttributes() ?>>
<span<?= $Page->amount->viewAttributes() ?>>
<?= $Page->amount->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <!-- value -->
        <td<?= $Page->value->cellAttributes() ?>>
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->discountId->Visible) { // discountId ?>
        <!-- discountId -->
        <td<?= $Page->discountId->cellAttributes() ?>>
<span<?= $Page->discountId->viewAttributes() ?>>
<?= $Page->discountId->getViewValue() ?></span>
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
