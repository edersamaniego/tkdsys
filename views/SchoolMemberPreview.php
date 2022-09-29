<?php

namespace PHPMaker2022\school;

// Page object
$SchoolMemberPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { school_member: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid school_member"><!-- .card -->
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
<?php if ($Page->name->Visible) { // name ?>
    <?php if ($Page->SortUrl($Page->name) == "") { ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><?= $Page->name->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->name->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->name->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->name->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->name->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
    <?php if ($Page->SortUrl($Page->lastName) == "") { ?>
        <th class="<?= $Page->lastName->headerCellClass() ?>"><?= $Page->lastName->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->lastName->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->lastName->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->lastName->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->lastName->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->lastName->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
    <?php if ($Page->SortUrl($Page->martialArtId) == "") { ?>
        <th class="<?= $Page->martialArtId->headerCellClass() ?>"><?= $Page->martialArtId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->martialArtId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->martialArtId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->martialArtId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->martialArtId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->martialArtId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
    <?php if ($Page->SortUrl($Page->rankId) == "") { ?>
        <th class="<?= $Page->rankId->headerCellClass() ?>"><?= $Page->rankId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->rankId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->rankId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->rankId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->rankId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->rankId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
    <?php if ($Page->SortUrl($Page->photo) == "") { ?>
        <th class="<?= $Page->photo->headerCellClass() ?>"><?= $Page->photo->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->photo->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->photo->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->photo->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->photo->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->photo->getSortIcon() ?></span>
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
<?php if ($Page->name->Visible) { // name ?>
        <!-- name -->
        <td<?= $Page->name->cellAttributes() ?>>
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
        <!-- lastName -->
        <td<?= $Page->lastName->cellAttributes() ?>>
<span<?= $Page->lastName->viewAttributes() ?>>
<?= $Page->lastName->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
        <!-- martialArtId -->
        <td<?= $Page->martialArtId->cellAttributes() ?>>
<span<?= $Page->martialArtId->viewAttributes() ?>>
<?= $Page->martialArtId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
        <!-- rankId -->
        <td<?= $Page->rankId->cellAttributes() ?>>
<span<?= $Page->rankId->viewAttributes() ?>>
<?= $Page->rankId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->photo->Visible) { // photo ?>
        <!-- photo -->
        <td<?= $Page->photo->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->photo, $Page->photo->getViewValue(), false) ?>
</span>
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
