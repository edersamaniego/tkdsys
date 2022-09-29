<?php

namespace PHPMaker2022\school;

// Page object
$FedSchoolPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { fed_school: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid fed_school"><!-- .card -->
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
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
    <?php if ($Page->SortUrl($Page->masterSchoolId) == "") { ?>
        <th class="<?= $Page->masterSchoolId->headerCellClass() ?>"><?= $Page->masterSchoolId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->masterSchoolId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->masterSchoolId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->masterSchoolId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->masterSchoolId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->masterSchoolId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
    <?php if ($Page->SortUrl($Page->school) == "") { ?>
        <th class="<?= $Page->school->headerCellClass() ?>"><?= $Page->school->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->school->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->school->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->school->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->school->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->school->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
    <?php if ($Page->SortUrl($Page->countryId) == "") { ?>
        <th class="<?= $Page->countryId->headerCellClass() ?>"><?= $Page->countryId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->countryId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->countryId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->countryId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->countryId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->countryId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
    <?php if ($Page->SortUrl($Page->cityId) == "") { ?>
        <th class="<?= $Page->cityId->headerCellClass() ?>"><?= $Page->cityId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->cityId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->cityId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->cityId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->cityId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->cityId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->owner->Visible) { // owner ?>
    <?php if ($Page->SortUrl($Page->owner) == "") { ?>
        <th class="<?= $Page->owner->headerCellClass() ?>"><?= $Page->owner->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->owner->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->owner->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->owner->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->owner->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->owner->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->applicationId->Visible) { // applicationId ?>
    <?php if ($Page->SortUrl($Page->applicationId) == "") { ?>
        <th class="<?= $Page->applicationId->headerCellClass() ?>"><?= $Page->applicationId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->applicationId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->applicationId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->applicationId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->applicationId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->applicationId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->isheadquarter->Visible) { // isheadquarter ?>
    <?php if ($Page->SortUrl($Page->isheadquarter) == "") { ?>
        <th class="<?= $Page->isheadquarter->headerCellClass() ?>"><?= $Page->isheadquarter->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->isheadquarter->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->isheadquarter->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->isheadquarter->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->isheadquarter->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->isheadquarter->getSortIcon() ?></span>
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
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
        <!-- masterSchoolId -->
        <td<?= $Page->masterSchoolId->cellAttributes() ?>>
<span<?= $Page->masterSchoolId->viewAttributes() ?>>
<?= $Page->masterSchoolId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
        <!-- school -->
        <td<?= $Page->school->cellAttributes() ?>>
<span<?= $Page->school->viewAttributes() ?>>
<?= $Page->school->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
        <!-- countryId -->
        <td<?= $Page->countryId->cellAttributes() ?>>
<span<?= $Page->countryId->viewAttributes() ?>>
<?= $Page->countryId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
        <!-- cityId -->
        <td<?= $Page->cityId->cellAttributes() ?>>
<span<?= $Page->cityId->viewAttributes() ?>>
<?= $Page->cityId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->owner->Visible) { // owner ?>
        <!-- owner -->
        <td<?= $Page->owner->cellAttributes() ?>>
<span<?= $Page->owner->viewAttributes() ?>>
<?= $Page->owner->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->applicationId->Visible) { // applicationId ?>
        <!-- applicationId -->
        <td<?= $Page->applicationId->cellAttributes() ?>>
<span<?= $Page->applicationId->viewAttributes() ?>>
<?= $Page->applicationId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->isheadquarter->Visible) { // isheadquarter ?>
        <!-- isheadquarter -->
        <td<?= $Page->isheadquarter->cellAttributes() ?>>
<span<?= $Page->isheadquarter->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isheadquarter_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isheadquarter->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isheadquarter->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isheadquarter_<?= $Page->RowCount ?>"></label>
</div></span>
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
