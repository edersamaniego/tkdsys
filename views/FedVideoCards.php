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
<form name="ffed_videolist" id="ffed_videolist" class="ew-form ew-list-form ew-multi-column-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_video">
<?php if ($Page->getCurrentMasterTable() == "fed_videosection" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_videosection">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->section->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "fed_videosubsection" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_videosubsection">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->subsection->getSessionValue()) ?>">
<?php } ?>
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
            "id" => "r" . $Page->RowCount . "_fed_video",
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
    <?php if ($Page->_title->Visible) { // title ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row fed_video__title">
            <div class="col col-sm-4 fed_video__title"><?= $Page->renderFieldHeader($Page->_title) ?></div>
            <div class="col col-sm-8"><div<?= $Page->_title->cellAttributes() ?>>
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row fed_video__title">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->_title->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_title->cellAttributes() ?>>
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->URL->Visible) { // URL ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row fed_video_URL">
            <div class="col col-sm-4 fed_video_URL"><?= $Page->renderFieldHeader($Page->URL) ?></div>
            <div class="col col-sm-8"><div<?= $Page->URL->cellAttributes() ?>>
<span><iframe src="https://player.vimeo.com/video/<?= CurrentPage()->URL->CurrentValue ?>" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
</span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row fed_video_URL">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->URL->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->URL->cellAttributes() ?>>
<span><iframe src="https://player.vimeo.com/video/<?= CurrentPage()->URL->CurrentValue ?>" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
</span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->section->Visible) { // section ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row fed_video_section">
            <div class="col col-sm-4 fed_video_section"><?= $Page->renderFieldHeader($Page->section) ?></div>
            <div class="col col-sm-8"><div<?= $Page->section->cellAttributes() ?>>
<span<?= $Page->section->viewAttributes() ?>>
<?= $Page->section->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row fed_video_section">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->section->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->section->cellAttributes() ?>>
<span<?= $Page->section->viewAttributes() ?>>
<?= $Page->section->getViewValue() ?></span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->subsection->Visible) { // subsection ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row fed_video_subsection">
            <div class="col col-sm-4 fed_video_subsection"><?= $Page->renderFieldHeader($Page->subsection) ?></div>
            <div class="col col-sm-8"><div<?= $Page->subsection->cellAttributes() ?>>
<span<?= $Page->subsection->viewAttributes() ?>>
<?= $Page->subsection->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row fed_video_subsection">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->subsection->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->subsection->cellAttributes() ?>>
<span<?= $Page->subsection->viewAttributes() ?>>
<?= $Page->subsection->getViewValue() ?></span>
</div></div>
        </div>
        <?php } ?>
    <?php } ?>
    <?php if ($Page->createDate->Visible) { // createDate ?>
        <?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
        <div class="row fed_video_createDate">
            <div class="col col-sm-4 fed_video_createDate"><?= $Page->renderFieldHeader($Page->createDate) ?></div>
            <div class="col col-sm-8"><div<?= $Page->createDate->cellAttributes() ?>>
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</div></div>
        </div>
        <?php } else { // Add/edit record ?>
        <div class="row fed_video_createDate">
            <label class="<?= $Page->LeftColumnClass ?>"><?= $Page->createDate->caption() ?></label>
            <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->createDate->cellAttributes() ?>>
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
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
