<?php

namespace PHPMaker2022\school;

// Page object
$SchoolUsersPreview = &$Page;
?>
<script>
ew.deepAssign(ew.vars, { tables: { school_users: <?= JsonEncode($Page->toClientVar()) ?> } });
</script>
<?php $Page->showPageHeader(); ?>
<?php if ($Page->TotalRecords > 0) { ?>
<div class="card ew-grid school_users"><!-- .card -->
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
<?php if ($Page->schoolIdMaster->Visible) { // schoolIdMaster ?>
    <?php if ($Page->SortUrl($Page->schoolIdMaster) == "") { ?>
        <th class="<?= $Page->schoolIdMaster->headerCellClass() ?>"><?= $Page->schoolIdMaster->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->schoolIdMaster->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->schoolIdMaster->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->schoolIdMaster->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->schoolIdMaster->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->schoolIdMaster->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <?php if ($Page->SortUrl($Page->schoolId) == "") { ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><?= $Page->schoolId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->schoolId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->schoolId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->schoolId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->schoolId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
    <?php if ($Page->SortUrl($Page->_login) == "") { ?>
        <th class="<?= $Page->_login->headerCellClass() ?>"><?= $Page->_login->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_login->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->_login->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->_login->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_login->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_login->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <?php if ($Page->SortUrl($Page->_email) == "") { ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><?= $Page->_email->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_email->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->_email->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->_email->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_email->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_email->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->activateEmail->Visible) { // activateEmail ?>
    <?php if ($Page->SortUrl($Page->activateEmail) == "") { ?>
        <th class="<?= $Page->activateEmail->headerCellClass() ?>"><?= $Page->activateEmail->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->activateEmail->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->activateEmail->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->activateEmail->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->activateEmail->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->activateEmail->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
    <?php if ($Page->SortUrl($Page->_password) == "") { ?>
        <th class="<?= $Page->_password->headerCellClass() ?>"><?= $Page->_password->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->_password->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->_password->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->_password->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->_password->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->_password->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <?php if ($Page->SortUrl($Page->createUserId) == "") { ?>
        <th class="<?= $Page->createUserId->headerCellClass() ?>"><?= $Page->createUserId->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->createUserId->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->createUserId->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->createUserId->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->createUserId->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->createUserId->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <?php if ($Page->SortUrl($Page->createDate) == "") { ?>
        <th class="<?= $Page->createDate->headerCellClass() ?>"><?= $Page->createDate->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->createDate->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->createDate->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->createDate->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->createDate->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->createDate->getSortIcon() ?></span>
            </div>
        </th>
    <?php } ?>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
    <?php if ($Page->SortUrl($Page->level) == "") { ?>
        <th class="<?= $Page->level->headerCellClass() ?>"><?= $Page->level->caption() ?></th>
    <?php } else { ?>
        <th class="<?= $Page->level->headerCellClass() ?>"><div role="button" data-sort="<?= HtmlEncode($Page->level->Name) ?>" data-sort-type="1" data-sort-order="<?= $Page->level->getNextSort() ?>">
            <div class="ew-table-header-btn">
                <span class="ew-table-header-caption"><?= $Page->level->caption() ?></span>
                <span class="ew-table-header-sort"><?= $Page->level->getSortIcon() ?></span>
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
<?php if ($Page->schoolIdMaster->Visible) { // schoolIdMaster ?>
        <!-- schoolIdMaster -->
        <td<?= $Page->schoolIdMaster->cellAttributes() ?>>
<span<?= $Page->schoolIdMaster->viewAttributes() ?>>
<?= $Page->schoolIdMaster->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <!-- schoolId -->
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_login->Visible) { // login ?>
        <!-- login -->
        <td<?= $Page->_login->cellAttributes() ?>>
<span<?= $Page->_login->viewAttributes() ?>>
<?= $Page->_login->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
        <!-- email -->
        <td<?= $Page->_email->cellAttributes() ?>>
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->activateEmail->Visible) { // activateEmail ?>
        <!-- activateEmail -->
        <td<?= $Page->activateEmail->cellAttributes() ?>>
<span<?= $Page->activateEmail->viewAttributes() ?>>
<?= $Page->activateEmail->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->_password->Visible) { // password ?>
        <!-- password -->
        <td<?= $Page->_password->cellAttributes() ?>>
<span<?= $Page->_password->viewAttributes() ?>>
<?= $Page->_password->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <!-- createUserId -->
        <td<?= $Page->createUserId->cellAttributes() ?>>
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <!-- createDate -->
        <td<?= $Page->createDate->cellAttributes() ?>>
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</td>
<?php } ?>
<?php if ($Page->level->Visible) { // level ?>
        <!-- level -->
        <td<?= $Page->level->cellAttributes() ?>>
<span<?= $Page->level->viewAttributes() ?>>
<?= $Page->level->getViewValue() ?></span>
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
