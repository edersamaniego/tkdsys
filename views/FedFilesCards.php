<?php
namespace PHPMaker2022\school;
?>
<div class="ew-multi-column-grid">
<?php $Page->LayoutOptions->render("body") ?>
<?php if (!$Page->isExport()) { ?>
<div>
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="ffed_fileslist" id="ffed_fileslist" class="ew-form ew-list-form ew-multi-column-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_files">
<div class="<?= $Page->getMultiColumnRowClass() ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_fed_files",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
<div class="<?= $Page->getMultiColumnColClass() ?>" <?= $Page->rowAttributes() ?>>
<div class="<?= $Page->MultiColumnCardClass ?>">
    <?php if (StartsText("top", $Page->MultiColumnListOptionsPosition)) { ?>
    <div class="card-header">
        <div class="ew-multi-column-list-option ew-<?= $Page->MultiColumnListOptionsPosition ?>">
<?php
// Render list options (body, bottom)
$Page->ListOptions->Tag = "div";
$Page->ListOptions->render("body", $Page->MultiColumnListOptionsPosition, $Page->RowCount);
?>
        </div><!-- /.ew-multi-column-list-option -->
    </div>
    <?php } ?>
    <div class="card-body">
    <?php if ($Page->name->Visible) { // name ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row fed_files_name">
            <div class="col col-sm-4 fed_files_name"><?= $Page->renderFieldHeader($Page->name) ?></div>
            <div class="col col-sm-8"><div<?= $Page->name->cellAttributes() ?>>
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row fed_files_name">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->name->cellAttributes() ?>>
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->thumbs->Visible) { // thumbs ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row fed_files_thumbs">
            <div class="col col-sm-4 fed_files_thumbs"><?= $Page->renderFieldHeader($Page->thumbs) ?></div>
            <div class="col col-sm-8"><div<?= $Page->thumbs->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->thumbs, $Page->thumbs->getViewValue(), false) ?>
</span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row fed_files_thumbs">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->thumbs->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->thumbs->cellAttributes() ?>>
<span>
<?= GetFileViewTag($Page->thumbs, $Page->thumbs->getViewValue(), false) ?>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->category->Visible) { // category ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row fed_files_category">
            <div class="col col-sm-4 fed_files_category"><?= $Page->renderFieldHeader($Page->category) ?></div>
            <div class="col col-sm-8"><div<?= $Page->category->cellAttributes() ?>>
<span<?= $Page->category->viewAttributes() ?>>
<?= $Page->category->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row fed_files_category">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->category->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->category->cellAttributes() ?>>
<span<?= $Page->category->viewAttributes() ?>>
<?= $Page->category->getViewValue() ?></span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->type->Visible) { // type ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row fed_files_type">
            <div class="col col-sm-4 fed_files_type"><?= $Page->renderFieldHeader($Page->type) ?></div>
            <div class="col col-sm-8"><div<?= $Page->type->cellAttributes() ?>>
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row fed_files_type">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->type->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->type->cellAttributes() ?>>
<span<?= $Page->type->viewAttributes() ?>>
<?= $Page->type->getViewValue() ?></span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    </div><!-- /.card-body -->
<?php if (!$Page->isExport()) { ?>
    <?php if (StartsText("bottom", $Page->MultiColumnListOptionsPosition)) { ?>
    <div class="card-footer">
        <div class="ew-multi-column-list-option ew-<?= $Page->MultiColumnListOptionsPosition ?>">
<?php
// Render list options (body, bottom)
$Page->ListOptions->Tag = "div";
$Page->ListOptions->render("body", $Page->MultiColumnListOptionsPosition, $Page->RowCount);
?>
        </div><!-- /.ew-multi-column-list-option -->
    </div><!-- /.card-footer -->
    <?php } ?>
<?php } ?>
</div><!-- /.card -->
</div><!-- /.col-* -->
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
<?php } ?>
</div><!-- /.ew-multi-column-row -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div>
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-multi-column-grid -->
