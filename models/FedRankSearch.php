<?php

namespace PHPMaker2022\school;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class FedRankSearch extends FedRank
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'fed_rank';

    // Page object name
    public $PageObjName = "FedRankSearch";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        $url = rtrim(UrlFor($route->getName(), $args), "/") . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return $this->TableVar == $CurrentForm->getValue("t");
            }
            if (Get("t") !== null) {
                return $this->TableVar == Get("t");
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (fed_rank)
        if (!isset($GLOBALS["fed_rank"]) || get_class($GLOBALS["fed_rank"]) == PROJECT_NAMESPACE . "fed_rank") {
            $GLOBALS["fed_rank"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'fed_rank');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $tbl = Container("fed_rank");
                $doc = new $class($tbl);
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "FedRankView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = $ar["ajax"] ?? Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $ar["q"] ?? Param("q") ?? $ar["sv"] ?? Post("sv", "");
            $pageSize = $ar["n"] ?? Param("n") ?? $ar["recperpage"] ?? Post("recperpage", 10);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $ar["q"] ?? Param("q", "");
            $pageSize = $ar["n"] ?? Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $ar["start"] ?? Param("start", -1);
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $ar["page"] ?? Param("page", -1);
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($ar["s"] ?? Post("s", ""));
        $userFilter = Decrypt($ar["f"] ?? Post("f", ""));
        $userOrderBy = Decrypt($ar["o"] ?? Post("o", ""));
        $keys = $ar["keys"] ?? Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $ar["v0"] ?? $ar["lookupValue"] ?? Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $ar["v" . $i] ?? Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, !is_array($ar)); // Use settings from current page
    }
    public $FormClassName = "ew-form ew-search-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->rankBR->setVisibility();
        $this->rankUS->setVisibility();
        $this->rankES->setVisibility();
        $this->ranking->setVisibility();
        $this->nextrankId->setVisibility();
        $this->levelTournamentId->setVisibility();
        $this->martialArtsId->setVisibility();
        $this->createUserId->setVisibility();
        $this->createDate->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->nextrankId);
        $this->setupLookupOptions($this->martialArtsId);

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        if ($this->isPageRequest()) {
            // Get action
            $this->CurrentAction = Post("action");
            if ($this->isSearch()) {
                // Build search string for advanced search, remove blank field
                $this->loadSearchValues(); // Get search values
                if ($this->validateSearch()) {
                    $srchStr = $this->buildAdvancedSearch();
                } else {
                    $srchStr = "";
                }
                if ($srchStr != "") {
                    $srchStr = $this->getUrlParm($srchStr);
                    $srchStr = "FedRankList" . "?" . $srchStr;
                    $this->terminate($srchStr); // Go to list page
                    return;
                }
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Render row for search
        $this->RowType = ROWTYPE_SEARCH;
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Build advanced search
    protected function buildAdvancedSearch()
    {
        $srchUrl = "";
        $this->buildSearchUrl($srchUrl, $this->id); // id
        $this->buildSearchUrl($srchUrl, $this->rankBR); // rankBR
        $this->buildSearchUrl($srchUrl, $this->rankUS); // rankUS
        $this->buildSearchUrl($srchUrl, $this->rankES); // rankES
        $this->buildSearchUrl($srchUrl, $this->ranking); // ranking
        $this->buildSearchUrl($srchUrl, $this->nextrankId); // nextrankId
        $this->buildSearchUrl($srchUrl, $this->levelTournamentId); // levelTournamentId
        $this->buildSearchUrl($srchUrl, $this->martialArtsId); // martialArtsId
        $this->buildSearchUrl($srchUrl, $this->createUserId); // createUserId
        $this->buildSearchUrl($srchUrl, $this->createDate); // createDate
        if ($srchUrl != "") {
            $srchUrl .= "&";
        }
        $srchUrl .= "cmd=search";
        return $srchUrl;
    }

    // Build search URL
    protected function buildSearchUrl(&$url, &$fld, $oprOnly = false)
    {
        global $CurrentForm;
        $wrk = "";
        $fldParm = $fld->Param;
        $fldVal = $CurrentForm->getValue("x_$fldParm");
        $fldOpr = $CurrentForm->getValue("z_$fldParm");
        $fldCond = $CurrentForm->getValue("v_$fldParm");
        $fldVal2 = $CurrentForm->getValue("y_$fldParm");
        $fldOpr2 = $CurrentForm->getValue("w_$fldParm");
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr ?? ""));
        $fldDataType = ($fld->IsVirtual) ? DATATYPE_STRING : $fld->DataType;
        if ($fldOpr == "BETWEEN") {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal) && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            }
        } else {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal));
            if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr, $fldDataType)) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            } elseif ($fldOpr == "IS NULL" || $fldOpr == "IS NOT NULL" || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr, $fldDataType))) {
                $wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
            }
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2, $fldDataType)) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&w_" . $fldParm . "=" . urlencode($fldOpr2);
            } elseif ($fldOpr2 == "IS NULL" || $fldOpr2 == "IS NOT NULL" || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2, $fldDataType))) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
            }
        }
        if ($wrk != "") {
            if ($url != "") {
                $url .= "&";
            }
            $url .= $wrk;
        }
    }

    // Check if search value is numeric
    protected function searchValueIsNumeric($fld, $value)
    {
        if (IsFloatFormat($fld->Type)) {
            $value = ConvertToFloatString($value);
        }
        return is_numeric($value);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // id
        if ($this->id->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // rankBR
        if ($this->rankBR->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // rankUS
        if ($this->rankUS->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // rankES
        if ($this->rankES->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // ranking
        if ($this->ranking->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // nextrankId
        if ($this->nextrankId->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // levelTournamentId
        if ($this->levelTournamentId->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // martialArtsId
        if ($this->martialArtsId->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // createUserId
        if ($this->createUserId->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // createDate
        if ($this->createDate->AdvancedSearch->get()) {
            $hasValue = true;
        }
        return $hasValue;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id
        $this->id->RowCssClass = "row";

        // rankBR
        $this->rankBR->RowCssClass = "row";

        // rankUS
        $this->rankUS->RowCssClass = "row";

        // rankES
        $this->rankES->RowCssClass = "row";

        // ranking
        $this->ranking->RowCssClass = "row";

        // nextrankId
        $this->nextrankId->RowCssClass = "row";

        // levelTournamentId
        $this->levelTournamentId->RowCssClass = "row";

        // martialArtsId
        $this->martialArtsId->RowCssClass = "row";

        // createUserId
        $this->createUserId->RowCssClass = "row";

        // createDate
        $this->createDate->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // rankBR
            $this->rankBR->ViewValue = $this->rankBR->CurrentValue;
            $this->rankBR->ViewCustomAttributes = "";

            // rankUS
            $this->rankUS->ViewValue = $this->rankUS->CurrentValue;
            $this->rankUS->ViewCustomAttributes = "";

            // rankES
            $this->rankES->ViewValue = $this->rankES->CurrentValue;
            $this->rankES->ViewCustomAttributes = "";

            // ranking
            $this->ranking->ViewValue = $this->ranking->CurrentValue;
            $this->ranking->ViewCustomAttributes = "";

            // nextrankId
            $this->nextrankId->ViewValue = $this->nextrankId->CurrentValue;
            $curVal = strval($this->nextrankId->CurrentValue);
            if ($curVal != "") {
                $this->nextrankId->ViewValue = $this->nextrankId->lookupCacheOption($curVal);
                if ($this->nextrankId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->nextrankId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->nextrankId->Lookup->renderViewRow($rswrk[0]);
                        $this->nextrankId->ViewValue = $this->nextrankId->displayValue($arwrk);
                    } else {
                        $this->nextrankId->ViewValue = FormatNumber($this->nextrankId->CurrentValue, $this->nextrankId->formatPattern());
                    }
                }
            } else {
                $this->nextrankId->ViewValue = null;
            }
            $this->nextrankId->ViewCustomAttributes = "";

            // levelTournamentId
            $this->levelTournamentId->ViewValue = $this->levelTournamentId->CurrentValue;
            $this->levelTournamentId->ViewValue = FormatNumber($this->levelTournamentId->ViewValue, $this->levelTournamentId->formatPattern());
            $this->levelTournamentId->ViewCustomAttributes = "";

            // martialArtsId
            $this->martialArtsId->ViewValue = $this->martialArtsId->CurrentValue;
            $curVal = strval($this->martialArtsId->CurrentValue);
            if ($curVal != "") {
                $this->martialArtsId->ViewValue = $this->martialArtsId->lookupCacheOption($curVal);
                if ($this->martialArtsId->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->martialArtsId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->martialArtsId->Lookup->renderViewRow($rswrk[0]);
                        $this->martialArtsId->ViewValue = $this->martialArtsId->displayValue($arwrk);
                    } else {
                        $this->martialArtsId->ViewValue = FormatNumber($this->martialArtsId->CurrentValue, $this->martialArtsId->formatPattern());
                    }
                }
            } else {
                $this->martialArtsId->ViewValue = null;
            }
            $this->martialArtsId->ViewCustomAttributes = "";

            // createUserId
            $this->createUserId->ViewValue = $this->createUserId->CurrentValue;
            $this->createUserId->ViewValue = FormatNumber($this->createUserId->ViewValue, $this->createUserId->formatPattern());
            $this->createUserId->ViewCustomAttributes = "";

            // createDate
            $this->createDate->ViewValue = $this->createDate->CurrentValue;
            $this->createDate->ViewValue = FormatDateTime($this->createDate->ViewValue, $this->createDate->formatPattern());
            $this->createDate->ViewCustomAttributes = "";

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";
            $this->id->TooltipValue = "";

            // rankBR
            $this->rankBR->LinkCustomAttributes = "";
            $this->rankBR->HrefValue = "";
            $this->rankBR->TooltipValue = "";

            // rankUS
            $this->rankUS->LinkCustomAttributes = "";
            $this->rankUS->HrefValue = "";
            $this->rankUS->TooltipValue = "";

            // rankES
            $this->rankES->LinkCustomAttributes = "";
            $this->rankES->HrefValue = "";
            $this->rankES->TooltipValue = "";

            // ranking
            $this->ranking->LinkCustomAttributes = "";
            $this->ranking->HrefValue = "";
            $this->ranking->TooltipValue = "";

            // nextrankId
            $this->nextrankId->LinkCustomAttributes = "";
            $this->nextrankId->HrefValue = "";
            $this->nextrankId->TooltipValue = "";

            // levelTournamentId
            $this->levelTournamentId->LinkCustomAttributes = "";
            $this->levelTournamentId->HrefValue = "";
            $this->levelTournamentId->TooltipValue = "";

            // martialArtsId
            $this->martialArtsId->LinkCustomAttributes = "";
            $this->martialArtsId->HrefValue = "";
            $this->martialArtsId->TooltipValue = "";

            // createUserId
            $this->createUserId->LinkCustomAttributes = "";
            $this->createUserId->HrefValue = "";
            $this->createUserId->TooltipValue = "";

            // createDate
            $this->createDate->LinkCustomAttributes = "";
            $this->createDate->HrefValue = "";
            $this->createDate->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // id
            $this->id->setupEditAttributes();
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = HtmlEncode($this->id->AdvancedSearch->SearchValue);
            $this->id->PlaceHolder = RemoveHtml($this->id->caption());

            // rankBR
            $this->rankBR->setupEditAttributes();
            $this->rankBR->EditCustomAttributes = "";
            if (!$this->rankBR->Raw) {
                $this->rankBR->AdvancedSearch->SearchValue = HtmlDecode($this->rankBR->AdvancedSearch->SearchValue);
            }
            $this->rankBR->EditValue = HtmlEncode($this->rankBR->AdvancedSearch->SearchValue);
            $this->rankBR->PlaceHolder = RemoveHtml($this->rankBR->caption());

            // rankUS
            $this->rankUS->setupEditAttributes();
            $this->rankUS->EditCustomAttributes = "";
            if (!$this->rankUS->Raw) {
                $this->rankUS->AdvancedSearch->SearchValue = HtmlDecode($this->rankUS->AdvancedSearch->SearchValue);
            }
            $this->rankUS->EditValue = HtmlEncode($this->rankUS->AdvancedSearch->SearchValue);
            $this->rankUS->PlaceHolder = RemoveHtml($this->rankUS->caption());

            // rankES
            $this->rankES->setupEditAttributes();
            $this->rankES->EditCustomAttributes = "";
            if (!$this->rankES->Raw) {
                $this->rankES->AdvancedSearch->SearchValue = HtmlDecode($this->rankES->AdvancedSearch->SearchValue);
            }
            $this->rankES->EditValue = HtmlEncode($this->rankES->AdvancedSearch->SearchValue);
            $this->rankES->PlaceHolder = RemoveHtml($this->rankES->caption());

            // ranking
            $this->ranking->setupEditAttributes();
            $this->ranking->EditCustomAttributes = "";
            if (!$this->ranking->Raw) {
                $this->ranking->AdvancedSearch->SearchValue = HtmlDecode($this->ranking->AdvancedSearch->SearchValue);
            }
            $this->ranking->EditValue = HtmlEncode($this->ranking->AdvancedSearch->SearchValue);
            $this->ranking->PlaceHolder = RemoveHtml($this->ranking->caption());

            // nextrankId
            $this->nextrankId->setupEditAttributes();
            $this->nextrankId->EditCustomAttributes = "";
            $this->nextrankId->EditValue = HtmlEncode($this->nextrankId->AdvancedSearch->SearchValue);
            $curVal = strval($this->nextrankId->AdvancedSearch->SearchValue);
            if ($curVal != "") {
                $this->nextrankId->EditValue = $this->nextrankId->lookupCacheOption($curVal);
                if ($this->nextrankId->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->nextrankId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->nextrankId->Lookup->renderViewRow($rswrk[0]);
                        $this->nextrankId->EditValue = $this->nextrankId->displayValue($arwrk);
                    } else {
                        $this->nextrankId->EditValue = HtmlEncode(FormatNumber($this->nextrankId->AdvancedSearch->SearchValue, $this->nextrankId->formatPattern()));
                    }
                }
            } else {
                $this->nextrankId->EditValue = null;
            }
            $this->nextrankId->PlaceHolder = RemoveHtml($this->nextrankId->caption());

            // levelTournamentId
            $this->levelTournamentId->setupEditAttributes();
            $this->levelTournamentId->EditCustomAttributes = "";
            $this->levelTournamentId->EditValue = HtmlEncode($this->levelTournamentId->AdvancedSearch->SearchValue);
            $this->levelTournamentId->PlaceHolder = RemoveHtml($this->levelTournamentId->caption());

            // martialArtsId
            $this->martialArtsId->setupEditAttributes();
            $this->martialArtsId->EditCustomAttributes = "";
            $this->martialArtsId->EditValue = HtmlEncode($this->martialArtsId->AdvancedSearch->SearchValue);
            $curVal = strval($this->martialArtsId->AdvancedSearch->SearchValue);
            if ($curVal != "") {
                $this->martialArtsId->EditValue = $this->martialArtsId->lookupCacheOption($curVal);
                if ($this->martialArtsId->EditValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->martialArtsId->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->martialArtsId->Lookup->renderViewRow($rswrk[0]);
                        $this->martialArtsId->EditValue = $this->martialArtsId->displayValue($arwrk);
                    } else {
                        $this->martialArtsId->EditValue = HtmlEncode(FormatNumber($this->martialArtsId->AdvancedSearch->SearchValue, $this->martialArtsId->formatPattern()));
                    }
                }
            } else {
                $this->martialArtsId->EditValue = null;
            }
            $this->martialArtsId->PlaceHolder = RemoveHtml($this->martialArtsId->caption());

            // createUserId
            $this->createUserId->setupEditAttributes();
            $this->createUserId->EditCustomAttributes = "";
            $this->createUserId->EditValue = HtmlEncode($this->createUserId->AdvancedSearch->SearchValue);
            $this->createUserId->PlaceHolder = RemoveHtml($this->createUserId->caption());

            // createDate
            $this->createDate->setupEditAttributes();
            $this->createDate->EditCustomAttributes = "";
            $this->createDate->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->createDate->AdvancedSearch->SearchValue, $this->createDate->formatPattern()), $this->createDate->formatPattern()));
            $this->createDate->PlaceHolder = RemoveHtml($this->createDate->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckInteger($this->id->AdvancedSearch->SearchValue)) {
            $this->id->addErrorMessage($this->id->getErrorMessage(false));
        }
        if (!CheckInteger($this->nextrankId->AdvancedSearch->SearchValue)) {
            $this->nextrankId->addErrorMessage($this->nextrankId->getErrorMessage(false));
        }
        if (!CheckInteger($this->levelTournamentId->AdvancedSearch->SearchValue)) {
            $this->levelTournamentId->addErrorMessage($this->levelTournamentId->getErrorMessage(false));
        }
        if (!CheckInteger($this->martialArtsId->AdvancedSearch->SearchValue)) {
            $this->martialArtsId->addErrorMessage($this->martialArtsId->getErrorMessage(false));
        }
        if (!CheckInteger($this->createUserId->AdvancedSearch->SearchValue)) {
            $this->createUserId->addErrorMessage($this->createUserId->getErrorMessage(false));
        }
        if (!CheckDate($this->createDate->AdvancedSearch->SearchValue, $this->createDate->formatPattern())) {
            $this->createDate->addErrorMessage($this->createDate->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->id->AdvancedSearch->load();
        $this->rankBR->AdvancedSearch->load();
        $this->rankUS->AdvancedSearch->load();
        $this->rankES->AdvancedSearch->load();
        $this->ranking->AdvancedSearch->load();
        $this->nextrankId->AdvancedSearch->load();
        $this->levelTournamentId->AdvancedSearch->load();
        $this->martialArtsId->AdvancedSearch->load();
        $this->createUserId->AdvancedSearch->load();
        $this->createDate->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("FedRankList"), "", $this->TableVar, true);
        $pageId = "search";
        $Breadcrumb->add("search", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_nextrankId":
                    break;
                case "x_martialArtsId":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $ar[strval($row["lf"])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
