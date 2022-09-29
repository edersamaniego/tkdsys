<?php

namespace PHPMaker2022\school;

// Page object
$FinDebitPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { fin_debit: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid fin_debit"><!-- .card -->
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
<?php if ($Page->dueDate->Visible) { // dueDate ?>
    <?php if ($Page->SortUrl($Page->dueDate) == "") { ?>
        <th class="<?= $Page->dueDate->headerCellClass() ?>"><?= $Page->dueDate->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->dueDate->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->dueDate->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->dueDate->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->dueDate->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->dueDate->getSortIcon() ?></span>
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
<?php if ($Page->paymentMethod->Visible) { // paymentMethod ?>
    <?php if ($Page->SortUrl($Page->paymentMethod) == "") { ?>
        <th class="<?= $Page->paymentMethod->headerCellClass() ?>"><?= $Page->paymentMethod->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->paymentMethod->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->paymentMethod->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->paymentMethod->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->paymentMethod->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->paymentMethod->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->checkingAccountId->Visible) { // checkingAccountId ?>
    <?php if ($Page->SortUrl($Page->checkingAccountId) == "") { ?>
        <th class="<?= $Page->checkingAccountId->headerCellClass() ?>"><?= $Page->checkingAccountId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->checkingAccountId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->checkingAccountId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->checkingAccountId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->checkingAccountId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->checkingAccountId->getSortIcon() ?></span>
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
<?php if ($Page->dueDate->Visible) { // dueDate ?>
        <!-- dueDate -->
        <td<?= $Page->dueDate->cellAttributes() ?>>
<span<?= $Page->dueDate->viewAttributes() ?>>
<?= $Page->dueDate->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <!-- value -->
        <td<?= $Page->value->cellAttributes() ?>>
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->paymentMethod->Visible) { // paymentMethod ?>
        <!-- paymentMethod -->
        <td<?= $Page->paymentMethod->cellAttributes() ?>>
<span<?= $Page->paymentMethod->viewAttributes() ?>>
<?= $Page->paymentMethod->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->checkingAccountId->Visible) { // checkingAccountId ?>
        <!-- checkingAccountId -->
        <td<?= $Page->checkingAccountId->cellAttributes() ?>>
<span<?= $Page->checkingAccountId->viewAttributes() ?>>
<?= $Page->checkingAccountId->getViewValue() ?></span>
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
