<?php

namespace PHPMaker2022\school;

// Page object
$FedRankSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_rank: currentTable } });
var currentForm, currentPageID;
var ffed_ranksearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ffed_ranksearch = new ew.Form("ffed_ranksearch", "search");
    <?php if ($Page->IsModal) { ?>
    currentAdvancedSearchForm = ffed_ranksearch;
    <?php } else { ?>
    currentForm = ffed_ranksearch;
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var fields = currentTable.fields;
    ffed_ranksearch.addFields([
        ["id", [ew.Validators.integer], fields.id.isInvalid],
        ["rankBR", [], fields.rankBR.isInvalid],
        ["rankUS", [], fields.rankUS.isInvalid],
        ["rankES", [], fields.rankES.isInvalid],
        ["ranking", [], fields.ranking.isInvalid],
        ["nextrankId", [ew.Validators.integer], fields.nextrankId.isInvalid],
        ["levelTournamentId", [ew.Validators.integer], fields.levelTournamentId.isInvalid],
        ["martialArtsId", [ew.Validators.integer], fields.martialArtsId.isInvalid],
        ["createUserId", [ew.Validators.integer], fields.createUserId.isInvalid],
        ["createDate", [ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid]
    ]);

    // Validate form
    ffed_ranksearch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm();

        // Validate fields
        if (!this.validateFields())
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    ffed_ranksearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_ranksearch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_ranksearch.lists.nextrankId = <?= $Page->nextrankId->toClientList($Page) ?>;
    ffed_ranksearch.lists.martialArtsId = <?= $Page->martialArtsId->toClientList($Page) ?>;
    loadjs.done("ffed_ranksearch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ffed_ranksearch" id="ffed_ranksearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_rank">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->id->Visible) { // id ?>
    <div id="r_id"<?= $Page->id->rowAttributes() ?>>
        <label for="x_id" class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_id"><?= $Page->id->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_id" id="z_id" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->id->cellAttributes() ?>>
            <span id="el_fed_rank_id" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->id->getInputTextType() ?>" name="x_id" id="x_id" data-table="fed_rank" data-field="x_id" value="<?= $Page->id->EditValue ?>" placeholder="<?= HtmlEncode($Page->id->getPlaceHolder()) ?>"<?= $Page->id->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->id->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->rankBR->Visible) { // rankBR ?>
    <div id="r_rankBR"<?= $Page->rankBR->rowAttributes() ?>>
        <label for="x_rankBR" class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_rankBR"><?= $Page->rankBR->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_rankBR" id="z_rankBR" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->rankBR->cellAttributes() ?>>
            <span id="el_fed_rank_rankBR" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->rankBR->getInputTextType() ?>" name="x_rankBR" id="x_rankBR" data-table="fed_rank" data-field="x_rankBR" value="<?= $Page->rankBR->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->rankBR->getPlaceHolder()) ?>"<?= $Page->rankBR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->rankBR->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->rankUS->Visible) { // rankUS ?>
    <div id="r_rankUS"<?= $Page->rankUS->rowAttributes() ?>>
        <label for="x_rankUS" class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_rankUS"><?= $Page->rankUS->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_rankUS" id="z_rankUS" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->rankUS->cellAttributes() ?>>
            <span id="el_fed_rank_rankUS" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->rankUS->getInputTextType() ?>" name="x_rankUS" id="x_rankUS" data-table="fed_rank" data-field="x_rankUS" value="<?= $Page->rankUS->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->rankUS->getPlaceHolder()) ?>"<?= $Page->rankUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->rankUS->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->rankES->Visible) { // rankES ?>
    <div id="r_rankES"<?= $Page->rankES->rowAttributes() ?>>
        <label for="x_rankES" class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_rankES"><?= $Page->rankES->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_rankES" id="z_rankES" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->rankES->cellAttributes() ?>>
            <span id="el_fed_rank_rankES" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->rankES->getInputTextType() ?>" name="x_rankES" id="x_rankES" data-table="fed_rank" data-field="x_rankES" value="<?= $Page->rankES->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->rankES->getPlaceHolder()) ?>"<?= $Page->rankES->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->rankES->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->ranking->Visible) { // ranking ?>
    <div id="r_ranking"<?= $Page->ranking->rowAttributes() ?>>
        <label for="x_ranking" class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_ranking"><?= $Page->ranking->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_ranking" id="z_ranking" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->ranking->cellAttributes() ?>>
            <span id="el_fed_rank_ranking" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ranking->getInputTextType() ?>" name="x_ranking" id="x_ranking" data-table="fed_rank" data-field="x_ranking" value="<?= $Page->ranking->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Page->ranking->getPlaceHolder()) ?>"<?= $Page->ranking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ranking->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->nextrankId->Visible) { // nextrankId ?>
    <div id="r_nextrankId"<?= $Page->nextrankId->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_nextrankId"><?= $Page->nextrankId->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_nextrankId" id="z_nextrankId" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->nextrankId->cellAttributes() ?>>
            <span id="el_fed_rank_nextrankId" class="ew-search-field ew-search-field-single">
<?php
$onchange = $Page->nextrankId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->nextrankId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->nextrankId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_nextrankId" class="ew-auto-suggest">
    <input type="<?= $Page->nextrankId->getInputTextType() ?>" class="form-control" name="sv_x_nextrankId" id="sv_x_nextrankId" value="<?= RemoveHtml($Page->nextrankId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->nextrankId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->nextrankId->getPlaceHolder()) ?>"<?= $Page->nextrankId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fed_rank" data-field="x_nextrankId" data-input="sv_x_nextrankId" data-value-separator="<?= $Page->nextrankId->displayValueSeparatorAttribute() ?>" name="x_nextrankId" id="x_nextrankId" value="<?= HtmlEncode($Page->nextrankId->AdvancedSearch->SearchValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->nextrankId->getErrorMessage(false) ?></div>
<script>
loadjs.ready("ffed_ranksearch", function() {
    ffed_ranksearch.createAutoSuggest(Object.assign({"id":"x_nextrankId","forceSelect":false}, ew.vars.tables.fed_rank.fields.nextrankId.autoSuggestOptions));
});
</script>
<?= $Page->nextrankId->Lookup->getParamTag($Page, "p_x_nextrankId") ?>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->levelTournamentId->Visible) { // levelTournamentId ?>
    <div id="r_levelTournamentId"<?= $Page->levelTournamentId->rowAttributes() ?>>
        <label for="x_levelTournamentId" class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_levelTournamentId"><?= $Page->levelTournamentId->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_levelTournamentId" id="z_levelTournamentId" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->levelTournamentId->cellAttributes() ?>>
            <span id="el_fed_rank_levelTournamentId" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->levelTournamentId->getInputTextType() ?>" name="x_levelTournamentId" id="x_levelTournamentId" data-table="fed_rank" data-field="x_levelTournamentId" value="<?= $Page->levelTournamentId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->levelTournamentId->getPlaceHolder()) ?>"<?= $Page->levelTournamentId->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->levelTournamentId->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->martialArtsId->Visible) { // martialArtsId ?>
    <div id="r_martialArtsId"<?= $Page->martialArtsId->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_martialArtsId"><?= $Page->martialArtsId->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_martialArtsId" id="z_martialArtsId" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->martialArtsId->cellAttributes() ?>>
            <span id="el_fed_rank_martialArtsId" class="ew-search-field ew-search-field-single">
<?php
$onchange = $Page->martialArtsId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->martialArtsId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->martialArtsId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_martialArtsId" class="ew-auto-suggest">
    <input type="<?= $Page->martialArtsId->getInputTextType() ?>" class="form-control" name="sv_x_martialArtsId" id="sv_x_martialArtsId" value="<?= RemoveHtml($Page->martialArtsId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->martialArtsId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->martialArtsId->getPlaceHolder()) ?>"<?= $Page->martialArtsId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fed_rank" data-field="x_martialArtsId" data-input="sv_x_martialArtsId" data-value-separator="<?= $Page->martialArtsId->displayValueSeparatorAttribute() ?>" name="x_martialArtsId" id="x_martialArtsId" value="<?= HtmlEncode($Page->martialArtsId->AdvancedSearch->SearchValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->martialArtsId->getErrorMessage(false) ?></div>
<script>
loadjs.ready("ffed_ranksearch", function() {
    ffed_ranksearch.createAutoSuggest(Object.assign({"id":"x_martialArtsId","forceSelect":false}, ew.vars.tables.fed_rank.fields.martialArtsId.autoSuggestOptions));
});
</script>
<?= $Page->martialArtsId->Lookup->getParamTag($Page, "p_x_martialArtsId") ?>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <div id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <label for="x_createUserId" class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_createUserId"><?= $Page->createUserId->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_createUserId" id="z_createUserId" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->createUserId->cellAttributes() ?>>
            <span id="el_fed_rank_createUserId" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->createUserId->getInputTextType() ?>" name="x_createUserId" id="x_createUserId" data-table="fed_rank" data-field="x_createUserId" value="<?= $Page->createUserId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->createUserId->getPlaceHolder()) ?>"<?= $Page->createUserId->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->createUserId->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <div id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <label for="x_createDate" class="<?= $Page->LeftColumnClass ?>"><span id="elh_fed_rank_createDate"><?= $Page->createDate->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_createDate" id="z_createDate" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->createDate->cellAttributes() ?>>
            <span id="el_fed_rank_createDate" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->createDate->getInputTextType() ?>" name="x_createDate" id="x_createDate" data-table="fed_rank" data-field="x_createDate" value="<?= $Page->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->createDate->getPlaceHolder()) ?>"<?= $Page->createDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->createDate->getErrorMessage(false) ?></div>
<?php if (!$Page->createDate->ReadOnly && !$Page->createDate->Disabled && !isset($Page->createDate->EditAttrs["readonly"]) && !isset($Page->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_ranksearch", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem()
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                    next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                }
            },
            meta: {
                format
            }
        };
    ew.createDateTimePicker("ffed_ranksearch", "x_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("Search") ?></button>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("fed_rank");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
