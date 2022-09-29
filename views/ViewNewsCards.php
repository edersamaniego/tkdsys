<?php
namespace PHPMaker2022\school;
?>
<div class="ew-multi-column-grid">
<?php $Page->LayoutOptions->render("body") ?>
<form name="fview_newslist" id="fview_newslist" class="ew-form ew-list-form ew-multi-column-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_news">
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
            "id" => "r" . $Page->RowCount . "_view_news",
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
    <?php if ($Page->date->Visible) { // date ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row view_news_date">
            <div class="col col-sm-4 view_news_date"><?= $Page->renderFieldHeader($Page->date) ?></div>
            <div class="col col-sm-8"><div<?= $Page->date->cellAttributes() ?>>
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row view_news_date">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->date->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->date->cellAttributes() ?>>
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->id->Visible) { // id ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row view_news_id">
            <div class="col col-sm-4 view_news_id"><?= $Page->renderFieldHeader($Page->id) ?></div>
            <div class="col col-sm-8"><div<?= $Page->id->cellAttributes() ?>>
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row view_news_id">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->id->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id->cellAttributes() ?>>
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->link->Visible) { // link ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row view_news_link">
            <div class="col col-sm-4 view_news_link"><?= $Page->renderFieldHeader($Page->link) ?></div>
            <div class="col col-sm-8"><div<?= $Page->link->cellAttributes() ?>>
<span<?= $Page->link->viewAttributes() ?>>
<?= $Page->link->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row view_news_link">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->link->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->link->cellAttributes() ?>>
<span<?= $Page->link->viewAttributes() ?>>
<?= $Page->link->getViewValue() ?></span>
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
