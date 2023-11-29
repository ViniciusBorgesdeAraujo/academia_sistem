<?php
namespace PHPMaker2020\sistema;

/**
 * Page class
 */
class pessoa_grid extends pessoa
{

	// Page ID
	public $PageID = "grid";

	// Project ID
	public $ProjectID = "{448C0B4B-C32A-40EF-8151-41E96F03E813}";

	// Table name
	public $TableName = 'pessoa';

	// Page object name
	public $PageObjName = "pessoa_grid";

	// Grid form hidden field names
	public $FormName = "fpessoagrid";
	public $FormActionName = "k_action";
	public $FormKeyName = "k_key";
	public $FormOldKeyName = "k_oldkey";
	public $FormBlankRowName = "k_blankrow";
	public $FormKeyCountName = "key_count";

	// Page URLs
	public $AddUrl;
	public $EditUrl;
	public $CopyUrl;
	public $DeleteUrl;
	public $ViewUrl;
	public $ListUrl;

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;

	// Token
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken;

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading != "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading != "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->phrase($this->PageID);
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		$url = CurrentPageName() . "?";
		if ($this->UseTokenInUrl)
			$url .= "t=" . $this->TableVar . "&"; // Add page token
		return $url;
	}

	// Messages
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = TRUE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message != "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fas fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage != "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fas fa-exclamation"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage != "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fas fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage != "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fas fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = [];

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message != "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage != "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage != "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage != "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header != "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer != "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		global $CurrentForm;
		if ($this->UseTokenInUrl) {
			if ($CurrentForm)
				return ($this->TableVar == $CurrentForm->getValue("t"));
			if (Get("t") !== NULL)
				return ($this->TableVar == Get("t"));
		}
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(Config("TOKEN_NAME")) === NULL)
			return FALSE;
		$fn = Config("CHECK_TOKEN_FUNC");
		if (is_callable($fn))
			return $fn(Post(Config("TOKEN_NAME")), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;
		$fn = Config("CREATE_TOKEN_FUNC"); // Always create token, required by API file/lookup request
		if ($this->Token == "" && is_callable($fn)) // Create token
			$this->Token = $fn();
		$CurrentToken = $this->Token; // Save to global variable
	}

	// Constructor
	public function __construct()
	{
		global $Language, $DashboardReport;
		global $UserTable;

		// Check token
		$this->CheckToken = Config("CHECK_TOKEN");

		// Initialize
		$this->FormActionName .= "_" . $this->FormName;
		$this->FormKeyName .= "_" . $this->FormName;
		$this->FormOldKeyName .= "_" . $this->FormName;
		$this->FormBlankRowName .= "_" . $this->FormName;
		$this->FormKeyCountName .= "_" . $this->FormName;
		$GLOBALS["Grid"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (pessoa)
		if (!isset($GLOBALS["pessoa"]) || get_class($GLOBALS["pessoa"]) == PROJECT_NAMESPACE . "pessoa") {
			$GLOBALS["pessoa"] = &$this;

			// $GLOBALS["MasterTable"] = &$GLOBALS["Table"];
			// if (!isset($GLOBALS["Table"]))
			// 	$GLOBALS["Table"] = &$GLOBALS["pessoa"];

		}
		$this->AddUrl = "pessoaadd.php";

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'grid');

		// Table name (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'pessoa');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($GLOBALS["Conn"]))
			$GLOBALS["Conn"] = $this->getConnection();

		// User table object (pessoa)
		$UserTable = $UserTable ?: new pessoa();

		// List options
		$this->ListOptions = new ListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Other options
		if (!$this->OtherOptions)
			$this->OtherOptions = new ListOptionsArray();
		$this->OtherOptions["addedit"] = new ListOptions("div");
		$this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;

		// Export
		global $pessoa;
		if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
				$content = ob_get_contents();
			if ($ExportFileName == "")
				$ExportFileName = $this->TableVar;
			$class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
			if (class_exists($class)) {
				$doc = new $class($pessoa);
				$doc->Text = @$content;
				if ($this->isExport("email"))
					echo $this->exportEmail($doc->Text);
				else
					$doc->export();
				DeleteTempImages(); // Delete temp images
				exit();
			}
		}

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		unset($GLOBALS["Grid"]);
		if ($url === "")
			return;
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url != "") {
			if (!Config("DEBUG") && ob_get_length())
				ob_end_clean();
			SaveDebugMessage();
			AddHeader("Location", $url);
		}
		exit();
	}

	// Get records from recordset
	protected function getRecordsFromRecordset($rs, $current = FALSE)
	{
		$rows = [];
		if (is_object($rs)) { // Recordset
			while ($rs && !$rs->EOF) {
				$this->loadRowValues($rs); // Set up DbValue/CurrentValue
				$row = $this->getRecordFromArray($rs->fields);
				if ($current)
					return $row;
				else
					$rows[] = $row;
				$rs->moveNext();
			}
		} elseif (is_array($rs)) {
			foreach ($rs as $ar) {
				$row = $this->getRecordFromArray($ar);
				if ($current)
					return $row;
				else
					$rows[] = $row;
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
				if (array_key_exists($fldname, $this->fields) && ($this->fields[$fldname]->Visible || $this->fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
					$fld = &$this->fields[$fldname];
					if ($fld->HtmlTag == "FILE") { // Upload field
						if (EmptyValue($val)) {
							$row[$fldname] = NULL;
						} else {
							if ($fld->DataType == DATATYPE_BLOB) {
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									Config("API_FIELD_NAME") . "=" . $fld->Param . "&" .
									Config("API_KEY_NAME") . "=" . rawurlencode($this->getRecordKeyValue($ar)))); //*** need to add this? API may not be in the same folder
								$row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
							} elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
								$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
									Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
									"fn=" . Encrypt($fld->physicalUploadPath() . $val)));
								$row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
							} else { // Multiple files
								$files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
								$ar = [];
								foreach ($files as $file) {
									$url = FullUrl(GetApiUrl(Config("API_FILE_ACTION"),
										Config("API_OBJECT_NAME") . "=" . $fld->TableVar . "&" .
										"fn=" . Encrypt($fld->physicalUploadPath() . $file)));
									if (!EmptyValue($file))
										$ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
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
			$key .= @$ar['idpessoa'];
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
		if ($this->isAdd() || $this->isCopy() || $this->isGridAdd())
			$this->idpessoa->Visible = FALSE;
		if ($this->isAddOrEdit())
			$this->datadecadastro->Visible = FALSE;
	}

	// Lookup data
	public function lookup()
	{
		global $Language, $Security;
		if (!isset($Language))
			$Language = new Language(Config("LANGUAGE_FOLDER"), Post("language", ""));

		// Set up API request
		if (!ValidApiRequest())
			return FALSE;
		$this->setupApiSecurity();

		// Get lookup object
		$fieldName = Post("field");
		if (!array_key_exists($fieldName, $this->fields))
			return FALSE;
		$lookupField = $this->fields[$fieldName];
		$lookup = $lookupField->Lookup;
		if ($lookup === NULL)
			return FALSE;
		$tbl = $lookup->getTable();
		if (!$Security->allowLookup(Config("PROJECT_ID") . $tbl->TableName)) // Lookup permission
			return FALSE;

		// Get lookup parameters
		$lookupType = Post("ajax", "unknown");
		$pageSize = -1;
		$offset = -1;
		$searchValue = "";
		if (SameText($lookupType, "modal")) {
			$searchValue = Post("sv", "");
			$pageSize = Post("recperpage", 10);
			$offset = Post("start", 0);
		} elseif (SameText($lookupType, "autosuggest")) {
			$searchValue = Param("q", "");
			$pageSize = Param("n", -1);
			$pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
			if ($pageSize <= 0)
				$pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
			$start = Param("start", -1);
			$start = is_numeric($start) ? (int)$start : -1;
			$page = Param("page", -1);
			$page = is_numeric($page) ? (int)$page : -1;
			$offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
		}
		$userSelect = Decrypt(Post("s", ""));
		$userFilter = Decrypt(Post("f", ""));
		$userOrderBy = Decrypt(Post("o", ""));
		$keys = Post("keys");
		$lookup->LookupType = $lookupType; // Lookup type
		if ($keys !== NULL) { // Selected records from modal
			if (is_array($keys))
				$keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
			$lookup->FilterFields = []; // Skip parent fields if any
			$lookup->FilterValues[] = $keys; // Lookup values
			$pageSize = -1; // Show all records
		} else { // Lookup values
			$lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
		}
		$cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
		for ($i = 1; $i <= $cnt; $i++)
			$lookup->FilterValues[] = Post("v" . $i, "");
		$lookup->SearchValue = $searchValue;
		$lookup->PageSize = $pageSize;
		$lookup->Offset = $offset;
		if ($userSelect != "")
			$lookup->UserSelect = $userSelect;
		if ($userFilter != "")
			$lookup->UserFilter = $userFilter;
		if ($userOrderBy != "")
			$lookup->UserOrderBy = $userOrderBy;
		$lookup->toJson($this); // Use settings from current page
	}

	// Set up API security
	public function setupApiSecurity()
	{
		global $Security;

		// Setup security for API request
		if ($Security->isLoggedIn()) $Security->TablePermission_Loading();
		$Security->loadCurrentUserLevel(Config("PROJECT_ID") . $this->TableName);
		if ($Security->isLoggedIn()) $Security->TablePermission_Loaded();
		$Security->UserID_Loading();
		$Security->loadUserID();
		$Security->UserID_Loaded();
	}

	// Class variables
	public $ListOptions; // List options
	public $ExportOptions; // Export options
	public $SearchOptions; // Search options
	public $OtherOptions; // Other options
	public $FilterOptions; // Filter options
	public $ImportOptions; // Import options
	public $ListActions; // List actions
	public $SelectedCount = 0;
	public $SelectedIndex = 0;
	public $ShowOtherOptions = FALSE;
	public $DisplayRecords = 10;
	public $StartRecord;
	public $StopRecord;
	public $TotalRecords = 0;
	public $RecordRange = 10;
	public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
	public $DefaultSearchWhere = ""; // Default search WHERE clause
	public $SearchWhere = ""; // Search WHERE clause
	public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
	public $SearchRowCount = 0; // For extended search
	public $SearchColumnCount = 0; // For extended search
	public $SearchFieldsPerRow = 1; // For extended search
	public $RecordCount = 0; // Record count
	public $EditRowCount;
	public $StartRowCount = 1;
	public $RowCount = 0;
	public $Attrs = []; // Row attributes and cell attributes
	public $RowIndex = 0; // Row index
	public $KeyCount = 0; // Key count
	public $RowAction = ""; // Row action
	public $RowOldKey = ""; // Row old key (for copy)
	public $MultiColumnClass = "col-sm";
	public $MultiColumnEditClass = "w-100";
	public $DbMasterFilter = ""; // Master filter
	public $DbDetailFilter = ""; // Detail filter
	public $MasterRecordExists;
	public $MultiSelectKey;
	public $Command;
	public $RestoreSearch = FALSE;
	public $endereco_Count;
	public $documentos_Count;
	public $DetailPages;
	public $OldRecordset;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$FormError, $SearchError;

		// User profile
		$UserProfile = new UserProfile();

		// Security
		if (ValidApiRequest()) { // API request
			$this->setupApiSecurity(); // Set up API Security
		} else {
			$Security = new AdvancedSecurity();
			if (IsPasswordExpired())
				$this->terminate(GetUrl("changepwd.php"));
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canList()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				$this->terminate(GetUrl("index.php"));
				return;
			}
			if ($Security->isLoggedIn()) {
				$Security->UserID_Loading();
				$Security->loadUserID();
				$Security->UserID_Loaded();
				if (strval($Security->currentUserID()) == "") {
					$this->setFailureMessage(DeniedMessage()); // Set no permission
					$this->terminate(GetUrl("pessoalist.php"));
					return;
				}
			}
		}

		// Update last accessed time
		if ($UserProfile->isValidUser(CurrentUserName(), session_id())) {
		} else {
			Write($Language->phrase("UserProfileCorrupted"));
			$this->terminate();
		}

		// Get grid add count
		$gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->setupListOptions();
		$this->idpessoa->Visible = FALSE;
		$this->idaula->setVisibility();
		$this->Nome->setVisibility();
		$this->CPF->setVisibility();
		$this->Senha->setVisibility();
		$this->Sexo->setVisibility();
		$this->datanascimento->setVisibility();
		$this->Funcao->setVisibility();
		$this->Sessao->Visible = FALSE;
		$this->_Email->setVisibility();
		$this->Ativado->setVisibility();
		$this->datadecadastro->Visible = FALSE;
		$this->Idade->setVisibility();
		$this->hideFieldsForAddEdit();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();

		// Set up master detail parameters
		$this->setupMasterParms();

		// Setup other options
		$this->setupOtherOptions();

		// Set up lookup cache
		$this->setupLookupOptions($this->idaula);
		$this->setupLookupOptions($this->Funcao);

		// Search filters
		$srchAdvanced = ""; // Advanced search filter
		$srchBasic = ""; // Basic search filter
		$filter = "";

		// Get command
		$this->Command = strtolower(Get("cmd"));
		if ($this->isPageRequest()) { // Validate request

			// Set up records per page
			$this->setupDisplayRecords();

			// Handle reset command
			$this->resetCmd();

			// Hide list options
			if ($this->isExport()) {
				$this->ListOptions->hideAllOptions(["sequence"]);
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->isGridAdd() || $this->isGridEdit()) {
				$this->ListOptions->hideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->isGridAdd() || $this->isGridEdit()) {
					$item = $this->ListOptions["griddelete"];
					if ($item)
						$item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->setupSortOrder();
		}

		// Restore display records
		if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
			$this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecords = 10; // Load default
			$this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
		}

		// Load Sorting Order
		if ($this->Command != "json")
			$this->loadSortOrder();

		// Build filter
		$filter = "";
		if (!$Security->canList())
			$filter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->getMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Restore detail filter

		// Add master User ID filter
		if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
			if ($this->getCurrentMasterTable() == "aulas")
				$this->DbMasterFilter = $this->addMasterUserIDFilter($this->DbMasterFilter, "aulas"); // Add master User ID filter
		}
		AddFilter($filter, $this->DbDetailFilter);
		AddFilter($filter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode != "add" && $this->getMasterFilter() != "" && $this->getCurrentMasterTable() == "aulas") {
			global $aulas;
			$rsmaster = $aulas->loadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record found
				$this->terminate("aulaslist.php"); // Return to master page
			} else {
				$aulas->loadListRowValues($rsmaster);
				$aulas->RowType = ROWTYPE_MASTER; // Master row
				$aulas->renderListRow();
				$rsmaster->close();
			}
		}

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSql = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $filter;
		} else {
			$this->setSessionWhere($filter);
			$this->CurrentFilter = "";
		}
		if ($this->isGridAdd()) {
			if ($this->CurrentMode == "copy") {
				$selectLimit = $this->UseSelectLimit;
				if ($selectLimit) {
					$this->TotalRecords = $this->listRecordCount();
					$this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
				} else {
					if ($this->Recordset = $this->loadRecordset())
						$this->TotalRecords = $this->Recordset->RecordCount();
				}
				$this->StartRecord = 1;
				$this->DisplayRecords = $this->TotalRecords;
			} else {
				$this->CurrentFilter = "0=1";
				$this->StartRecord = 1;
				$this->DisplayRecords = $this->GridAddRowCount;
			}
			$this->TotalRecords = $this->DisplayRecords;
			$this->StopRecord = $this->DisplayRecords;
		} else {
			$selectLimit = $this->UseSelectLimit;
			if ($selectLimit) {
				$this->TotalRecords = $this->listRecordCount();
			} else {
				if ($this->Recordset = $this->loadRecordset())
					$this->TotalRecords = $this->Recordset->RecordCount();
			}
			$this->StartRecord = 1;
			$this->DisplayRecords = $this->TotalRecords; // Display all records
			if ($selectLimit)
				$this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);
		}

		// Normal return
		if (IsApi()) {
			$rows = $this->getRecordsFromRecordset($this->Recordset);
			$this->Recordset->close();
			WriteJson(["success" => TRUE, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
			$this->terminate(TRUE);
		}

		// Set up pager
		$this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);
	}

	// Set up number of records displayed per page
	protected function setupDisplayRecords()
	{
		$wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
		if ($wrk != "") {
			if (is_numeric($wrk)) {
				$this->DisplayRecords = (int)$wrk;
			} else {
				if (SameText($wrk, "all")) { // Display all records
					$this->DisplayRecords = -1;
				} else {
					$this->DisplayRecords = 10; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecords); // Save to Session

			// Reset start position
			$this->StartRecord = 1;
			$this->setStartRecordNumber($this->StartRecord);
		}
	}

	// Exit inline mode
	protected function clearInlineMode()
	{
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	protected function gridAddMode()
	{
		$this->CurrentAction = "gridadd";
		$_SESSION[SESSION_INLINE_MODE] = "gridadd";
		$this->hideFieldsForAddEdit();
	}

	// Switch to Grid Edit mode
	protected function gridEditMode()
	{
		$this->CurrentAction = "gridedit";
		$_SESSION[SESSION_INLINE_MODE] = "gridedit";
		$this->hideFieldsForAddEdit();
	}

	// Perform update to grid
	public function gridUpdate()
	{
		global $Language, $CurrentForm, $FormError;
		$gridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->buildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		if ($rs = $conn->execute($sql)) {
			$rsold = $rs->getRows();
			$rs->close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}
		$key = "";

		// Update row index and get row key
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$CurrentForm->Index = $rowindex;
			$rowkey = strval($CurrentForm->getValue($this->FormKeyName));
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction != "insertdelete") { // Skip insert then deleted rows
				$this->loadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$gridUpdate = $this->setupKeyValues($rowkey); // Set up key values
				} else {
					$gridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->emptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($gridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->getRecordFilter();
						$gridUpdate = $this->deleteRows(); // Delete this row
					} else if (!$this->validateForm()) {
						$gridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($FormError);
					} else {
						if ($rowaction == "insert") {
							$gridUpdate = $this->addRow(); // Insert this row
						} else {
							if ($rowkey != "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$gridUpdate = $this->editRow(); // Update this row
							}
						} // End update
					}
				}
				if ($gridUpdate) {
					if ($key != "")
						$key .= ", ";
					$key .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($gridUpdate) {

			// Get new recordset
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			$this->clearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
		}
		return $gridUpdate;
	}

	// Build filter for all keys
	protected function buildKeyFilter()
	{
		global $CurrentForm;
		$wrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$CurrentForm->Index = $rowindex;
		$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		while ($thisKey != "") {
			if ($this->setupKeyValues($thisKey)) {
				$filter = $this->getRecordFilter();
				if ($wrkFilter != "")
					$wrkFilter .= " OR ";
				$wrkFilter .= $filter;
			} else {
				$wrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$CurrentForm->Index = $rowindex;
			$thisKey = strval($CurrentForm->getValue($this->FormKeyName));
		}
		return $wrkFilter;
	}

	// Set up key values
	protected function setupKeyValues($key)
	{
		$arKeyFlds = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
		if (count($arKeyFlds) >= 1) {
			$this->idpessoa->setOldValue($arKeyFlds[0]);
			if (!is_numeric($this->idpessoa->OldValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	public function gridInsert()
	{
		global $Language, $CurrentForm, $FormError;
		$rowindex = 1;
		$gridInsert = FALSE;
		$conn = $this->getConnection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
			return FALSE;
		}

		// Init key filter
		$wrkfilter = "";
		$addcnt = 0;
		$key = "";

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "" && $rowaction != "insert")
				continue; // Skip
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
				$this->loadOldRecord(); // Load old record
			}
			$this->loadFormValues(); // Get form values
			if (!$this->emptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->validateForm()) {
					$gridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($FormError);
				} else {
					$gridInsert = $this->addRow($this->OldRecordset); // Insert this row
				}
				if ($gridInsert) {
					if ($key != "")
						$key .= Config("COMPOSITE_KEY_SEPARATOR");
					$key .= $this->idpessoa->CurrentValue;

					// Add filter for this record
					$filter = $this->getRecordFilter();
					if ($wrkfilter != "")
						$wrkfilter .= " OR ";
					$wrkfilter .= $filter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->clearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($gridInsert) {

			// Get new recordset
			$this->CurrentFilter = $wrkfilter;
			$sql = $this->getCurrentSql();
			if ($rs = $conn->execute($sql)) {
				$rsnew = $rs->getRows();
				$rs->close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			$this->clearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
		}
		return $gridInsert;
	}

	// Check if empty row
	public function emptyRow()
	{
		global $CurrentForm;
		if ($CurrentForm->hasValue("x_idaula") && $CurrentForm->hasValue("o_idaula") && $this->idaula->CurrentValue != $this->idaula->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Nome") && $CurrentForm->hasValue("o_Nome") && $this->Nome->CurrentValue != $this->Nome->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_CPF") && $CurrentForm->hasValue("o_CPF") && $this->CPF->CurrentValue != $this->CPF->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Senha") && $CurrentForm->hasValue("o_Senha") && $this->Senha->CurrentValue != $this->Senha->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Sexo") && $CurrentForm->hasValue("o_Sexo") && $this->Sexo->CurrentValue != $this->Sexo->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_datanascimento") && $CurrentForm->hasValue("o_datanascimento") && $this->datanascimento->CurrentValue != $this->datanascimento->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Funcao") && $CurrentForm->hasValue("o_Funcao") && $this->Funcao->CurrentValue != $this->Funcao->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x__Email") && $CurrentForm->hasValue("o__Email") && $this->_Email->CurrentValue != $this->_Email->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Ativado") && $CurrentForm->hasValue("o_Ativado") && $this->Ativado->CurrentValue != $this->Ativado->OldValue)
			return FALSE;
		if ($CurrentForm->hasValue("x_Idade") && $CurrentForm->hasValue("o_Idade") && $this->Idade->CurrentValue != $this->Idade->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	public function validateGridForm()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "delete" && $rowaction != "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else if (!$this->validateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	public function getGridFormValues()
	{
		global $CurrentForm;

		// Get row count
		$CurrentForm->Index = -1;
		$rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = [];

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$CurrentForm->Index = $rowindex;
			$rowaction = strval($CurrentForm->getValue($this->FormActionName));
			if ($rowaction != "delete" && $rowaction != "insertdelete") {
				$this->loadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->emptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->getFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	public function restoreCurrentRowFormValues($idx)
	{
		global $CurrentForm;

		// Get row based on current index
		$CurrentForm->Index = $idx;
		$this->loadFormValues(); // Load form values
	}

	// Set up sort parameters
	protected function setupSortOrder()
	{

		// Check for "order" parameter
		if (Get("order") !== NULL) {
			$this->CurrentOrder = Get("order");
			$this->CurrentOrderType = Get("ordertype", "");
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	protected function loadSortOrder()
	{
		$orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($orderBy == "") {
			if ($this->getSqlOrderBy() != "") {
				$orderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($orderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)

	protected function resetCmd()
	{

		// Check if reset command
		if (StartsString("reset", $this->Command)) {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->idaula->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$orderBy = "";
				$this->setSessionOrderBy($orderBy);
			}

			// Reset start position
			$this->StartRecord = 1;
			$this->setStartRecordNumber($this->StartRecord);
		}
	}

	// Set up list options
	protected function setupListOptions()
	{
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->add("griddelete");
			$item->CssClass = "text-nowrap";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->canEdit();
		$item->OnLeft = TRUE;

		// Drop down button for ListOptions
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;

		//$this->ListOptions->ButtonClass = ""; // Class for button group
		// Call ListOptions_Load event

		$this->ListOptions_Load();
		$item = $this->ListOptions[$this->ListOptions->GroupOptionName];
		$item->Visible = $this->ListOptions->groupOptionVisible();
	}

	// Render list options
	public function renderListOptions()
	{
		global $Security, $Language, $CurrentForm;
		$this->ListOptions->loadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode != "view") {
			$CurrentForm->Index = $this->RowIndex;
			$actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$keyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction != "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
			if ($CurrentForm->hasValue($this->FormOldKeyName))
				$this->RowOldKey = strval($CurrentForm->getValue($this->FormOldKeyName));
			if ($this->RowOldKey != "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $CurrentForm->getValue($this->FormKeyName);
				$this->setupKeyValues($rowkey);

				// Reload hidden key for delete
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . HtmlEncode($rowkey) . "\">";
			}
			if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
				$options = &$this->ListOptions;
				$options->UseButtonGroup = TRUE; // Use button group for grid delete button
				$opt = $options["griddelete"];
				if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$opt->Body = "&nbsp;";
				} else {
					$opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" onclick=\"return ew.deleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->phrase("DeleteLink") . "</a>";
				}
			}
		}
		if ($this->CurrentMode == "view") { // View mode

		// "view"
		$opt = $this->ListOptions["view"];
		$viewcaption = HtmlTitle($Language->phrase("ViewLink"));
		if ($Security->canView() && $this->showOptionLink('view')) {
			$opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode($this->ViewUrl) . "\">" . $Language->phrase("ViewLink") . "</a>";
		} else {
			$opt->Body = "";
		}

		// "edit"
		$opt = $this->ListOptions["edit"];
		$editcaption = HtmlTitle($Language->phrase("EditLink"));
		if ($Security->canEdit() && $this->showOptionLink('edit')) {
			$opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode($this->EditUrl) . "\">" . $Language->phrase("EditLink") . "</a>";
		} else {
			$opt->Body = "";
		}
		} // End View mode
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex) && $this->RowAction != "delete") {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $keyName . "\" id=\"" . $keyName . "\" value=\"" . $this->idpessoa->CurrentValue . "\">";
		}
		$this->renderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set record key
	public function setRecordKey(&$key, $rs)
	{
		$key = "";
		if ($key != "")
			$key .= Config("COMPOSITE_KEY_SEPARATOR");
		$key .= $rs->fields('idpessoa');
	}

	// Set up other options
	protected function setupOtherOptions()
	{
		global $Language, $Security;
		$option = $this->OtherOptions["addedit"];
		$option->UseDropDownButton = FALSE;
		$option->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
		$option->UseButtonGroup = TRUE;

		//$option->ButtonClass = ""; // Class for button group
		$item = &$option->add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Add
		if ($this->CurrentMode == "view") { // Check view mode
			$item = &$option->add("add");
			$addcaption = HtmlTitle($Language->phrase("AddLink"));
			$this->AddUrl = $this->getAddUrl();
			$item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode($this->AddUrl) . "\">" . $Language->phrase("AddLink") . "</a>";
			$item->Visible = $this->AddUrl != "" && $Security->canAdd();
		}
	}

	// Render other options
	public function renderOtherOptions()
	{
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if (($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") && !$this->isConfirm()) { // Check add/copy/edit mode
			if ($this->AllowAddDeleteRow) {
				$option = $options["addedit"];
				$option->UseDropDownButton = FALSE;
				$item = &$option->add("addblankrow");
				$item->Body = "<a class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" href=\"#\" onclick=\"return ew.addGridRow(this);\">" . $Language->phrase("AddBlankRow") . "</a>";
				$item->Visible = $Security->canAdd();
				$this->ShowOtherOptions = $item->Visible;
			}
		}
		if ($this->CurrentMode == "view") { // Check view mode
			$option = $options["addedit"];
			$item = $option["add"];
			$this->ShowOtherOptions = $item && $item->Visible;
		}
	}

	// Set up list options (extended codes)
	protected function setupListOptionsExt()
	{
	}

	// Render list options (extended codes)
	protected function renderListOptionsExt()
	{
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load default values
	protected function loadDefaultValues()
	{
		$this->idpessoa->CurrentValue = NULL;
		$this->idpessoa->OldValue = $this->idpessoa->CurrentValue;
		$this->idaula->CurrentValue = NULL;
		$this->idaula->OldValue = $this->idaula->CurrentValue;
		$this->Nome->CurrentValue = NULL;
		$this->Nome->OldValue = $this->Nome->CurrentValue;
		$this->CPF->CurrentValue = NULL;
		$this->CPF->OldValue = $this->CPF->CurrentValue;
		$this->Senha->CurrentValue = NULL;
		$this->Senha->OldValue = $this->Senha->CurrentValue;
		$this->Sexo->CurrentValue = NULL;
		$this->Sexo->OldValue = $this->Sexo->CurrentValue;
		$this->datanascimento->CurrentValue = NULL;
		$this->datanascimento->OldValue = $this->datanascimento->CurrentValue;
		$this->Funcao->CurrentValue = 0;
		$this->Funcao->OldValue = $this->Funcao->CurrentValue;
		$this->Sessao->CurrentValue = NULL;
		$this->Sessao->OldValue = $this->Sessao->CurrentValue;
		$this->_Email->CurrentValue = NULL;
		$this->_Email->OldValue = $this->_Email->CurrentValue;
		$this->Ativado->CurrentValue = NULL;
		$this->Ativado->OldValue = $this->Ativado->CurrentValue;
		$this->datadecadastro->CurrentValue = NULL;
		$this->datadecadastro->OldValue = $this->datadecadastro->CurrentValue;
		$this->Idade->CurrentValue = NULL;
		$this->Idade->OldValue = $this->Idade->CurrentValue;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;
		$CurrentForm->FormName = $this->FormName;

		// Check field name 'idaula' first before field var 'x_idaula'
		$val = $CurrentForm->hasValue("idaula") ? $CurrentForm->getValue("idaula") : $CurrentForm->getValue("x_idaula");
		if (!$this->idaula->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->idaula->Visible = FALSE; // Disable update for API request
			else
				$this->idaula->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_idaula"))
			$this->idaula->setOldValue($CurrentForm->getValue("o_idaula"));

		// Check field name 'Nome' first before field var 'x_Nome'
		$val = $CurrentForm->hasValue("Nome") ? $CurrentForm->getValue("Nome") : $CurrentForm->getValue("x_Nome");
		if (!$this->Nome->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Nome->Visible = FALSE; // Disable update for API request
			else
				$this->Nome->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Nome"))
			$this->Nome->setOldValue($CurrentForm->getValue("o_Nome"));

		// Check field name 'CPF' first before field var 'x_CPF'
		$val = $CurrentForm->hasValue("CPF") ? $CurrentForm->getValue("CPF") : $CurrentForm->getValue("x_CPF");
		if (!$this->CPF->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->CPF->Visible = FALSE; // Disable update for API request
			else
				$this->CPF->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_CPF"))
			$this->CPF->setOldValue($CurrentForm->getValue("o_CPF"));

		// Check field name 'Senha' first before field var 'x_Senha'
		$val = $CurrentForm->hasValue("Senha") ? $CurrentForm->getValue("Senha") : $CurrentForm->getValue("x_Senha");
		if (!$this->Senha->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Senha->Visible = FALSE; // Disable update for API request
			else
				if (Config("ENCRYPTED_PASSWORD")) // Encrypted password, use raw value
					$this->Senha->setRawFormValue($val);
				else
					$this->Senha->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Senha"))
			$this->Senha->setOldValue($CurrentForm->getValue("o_Senha"));

		// Check field name 'Sexo' first before field var 'x_Sexo'
		$val = $CurrentForm->hasValue("Sexo") ? $CurrentForm->getValue("Sexo") : $CurrentForm->getValue("x_Sexo");
		if (!$this->Sexo->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Sexo->Visible = FALSE; // Disable update for API request
			else
				$this->Sexo->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Sexo"))
			$this->Sexo->setOldValue($CurrentForm->getValue("o_Sexo"));

		// Check field name 'datanascimento' first before field var 'x_datanascimento'
		$val = $CurrentForm->hasValue("datanascimento") ? $CurrentForm->getValue("datanascimento") : $CurrentForm->getValue("x_datanascimento");
		if (!$this->datanascimento->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->datanascimento->Visible = FALSE; // Disable update for API request
			else
				$this->datanascimento->setFormValue($val);
			$this->datanascimento->CurrentValue = UnFormatDateTime($this->datanascimento->CurrentValue, 7);
		}
		if ($CurrentForm->hasValue("o_datanascimento"))
			$this->datanascimento->setOldValue($CurrentForm->getValue("o_datanascimento"));

		// Check field name 'Funcao' first before field var 'x_Funcao'
		$val = $CurrentForm->hasValue("Funcao") ? $CurrentForm->getValue("Funcao") : $CurrentForm->getValue("x_Funcao");
		if (!$this->Funcao->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Funcao->Visible = FALSE; // Disable update for API request
			else
				$this->Funcao->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Funcao"))
			$this->Funcao->setOldValue($CurrentForm->getValue("o_Funcao"));

		// Check field name 'Email' first before field var 'x__Email'
		$val = $CurrentForm->hasValue("Email") ? $CurrentForm->getValue("Email") : $CurrentForm->getValue("x__Email");
		if (!$this->_Email->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->_Email->Visible = FALSE; // Disable update for API request
			else
				$this->_Email->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o__Email"))
			$this->_Email->setOldValue($CurrentForm->getValue("o__Email"));

		// Check field name 'Ativado' first before field var 'x_Ativado'
		$val = $CurrentForm->hasValue("Ativado") ? $CurrentForm->getValue("Ativado") : $CurrentForm->getValue("x_Ativado");
		if (!$this->Ativado->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Ativado->Visible = FALSE; // Disable update for API request
			else
				$this->Ativado->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Ativado"))
			$this->Ativado->setOldValue($CurrentForm->getValue("o_Ativado"));

		// Check field name 'Idade' first before field var 'x_Idade'
		$val = $CurrentForm->hasValue("Idade") ? $CurrentForm->getValue("Idade") : $CurrentForm->getValue("x_Idade");
		if (!$this->Idade->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Idade->Visible = FALSE; // Disable update for API request
			else
				$this->Idade->setFormValue($val);
		}
		if ($CurrentForm->hasValue("o_Idade"))
			$this->Idade->setOldValue($CurrentForm->getValue("o_Idade"));

		// Check field name 'idpessoa' first before field var 'x_idpessoa'
		$val = $CurrentForm->hasValue("idpessoa") ? $CurrentForm->getValue("idpessoa") : $CurrentForm->getValue("x_idpessoa");
		if (!$this->idpessoa->IsDetailKey && !$this->isGridAdd() && !$this->isAdd())
			$this->idpessoa->setFormValue($val);
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		if (!$this->isGridAdd() && !$this->isAdd())
			$this->idpessoa->CurrentValue = $this->idpessoa->FormValue;
		$this->idaula->CurrentValue = $this->idaula->FormValue;
		$this->Nome->CurrentValue = $this->Nome->FormValue;
		$this->CPF->CurrentValue = $this->CPF->FormValue;
		$this->Senha->CurrentValue = $this->Senha->FormValue;
		$this->Sexo->CurrentValue = $this->Sexo->FormValue;
		$this->datanascimento->CurrentValue = $this->datanascimento->FormValue;
		$this->datanascimento->CurrentValue = UnFormatDateTime($this->datanascimento->CurrentValue, 7);
		$this->Funcao->CurrentValue = $this->Funcao->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
		$this->Ativado->CurrentValue = $this->Ativado->FormValue;
		$this->Idade->CurrentValue = $this->Idade->FormValue;
	}

	// Load recordset
	public function loadRecordset($offset = -1, $rowcnt = -1)
	{

		// Load List page SQL
		$sql = $this->getListSql();
		$conn = $this->getConnection();

		// Load recordset
		$dbtype = GetConnectionType($this->Dbid);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			if ($dbtype == "MSSQL") {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset, ["_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())]);
			} else {
				$rs = $conn->selectLimit($sql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = "";
		} else {
			$rs = LoadRecordset($sql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	public function loadRow()
	{
		global $Security, $Language;
		$filter = $this->getRecordFilter();

		// Call Row Selecting event
		$this->Row_Selecting($filter);

		// Load SQL based on filter
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$res = FALSE;
		$rs = LoadRecordset($sql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->loadRowValues($rs); // Load row values
			$rs->close();
		}
		return $res;
	}

	// Load row values from recordset
	public function loadRowValues($rs = NULL)
	{
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->newRow();

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->idpessoa->setDbValue($row['idpessoa']);
		$this->idaula->setDbValue($row['idaula']);
		$this->Nome->setDbValue($row['Nome']);
		$this->CPF->setDbValue($row['CPF']);
		$this->Senha->setDbValue($row['Senha']);
		$this->Sexo->setDbValue($row['Sexo']);
		$this->datanascimento->setDbValue($row['datanascimento']);
		$this->Funcao->setDbValue($row['Funcao']);
		$this->Sessao->setDbValue($row['Sessao']);
		$this->_Email->setDbValue($row['Email']);
		$this->Ativado->setDbValue($row['Ativado']);
		$this->datadecadastro->setDbValue($row['datadecadastro']);
		$this->Idade->setDbValue($row['Idade']);
	}

	// Return a row with default values
	protected function newRow()
	{
		$this->loadDefaultValues();
		$row = [];
		$row['idpessoa'] = $this->idpessoa->CurrentValue;
		$row['idaula'] = $this->idaula->CurrentValue;
		$row['Nome'] = $this->Nome->CurrentValue;
		$row['CPF'] = $this->CPF->CurrentValue;
		$row['Senha'] = $this->Senha->CurrentValue;
		$row['Sexo'] = $this->Sexo->CurrentValue;
		$row['datanascimento'] = $this->datanascimento->CurrentValue;
		$row['Funcao'] = $this->Funcao->CurrentValue;
		$row['Sessao'] = $this->Sessao->CurrentValue;
		$row['Email'] = $this->_Email->CurrentValue;
		$row['Ativado'] = $this->Ativado->CurrentValue;
		$row['datadecadastro'] = $this->datadecadastro->CurrentValue;
		$row['Idade'] = $this->Idade->CurrentValue;
		return $row;
	}

	// Load old record
	protected function loadOldRecord()
	{

		// Load key values from Session
		$validKey = TRUE;
		$keys = [$this->RowOldKey];
		$cnt = count($keys);
		if ($cnt >= 1) {
			if (strval($keys[0]) != "")
				$this->idpessoa->OldValue = strval($keys[0]); // idpessoa
			else
				$validKey = FALSE;
		} else {
			$validKey = FALSE;
		}

		// Load old record
		$this->OldRecordset = NULL;
		if ($validKey) {
			$this->CurrentFilter = $this->getRecordFilter();
			$sql = $this->getCurrentSql();
			$conn = $this->getConnection();
			$this->OldRecordset = LoadRecordset($sql, $conn);
		}
		$this->loadRowValues($this->OldRecordset); // Load row values
		return $validKey;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->getViewUrl();
		$this->EditUrl = $this->getEditUrl();
		$this->CopyUrl = $this->getCopyUrl();
		$this->DeleteUrl = $this->getDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idpessoa
		// idaula
		// Nome
		// CPF
		// Senha
		// Sexo
		// datanascimento
		// Funcao
		// Sessao
		// Email
		// Ativado
		// datadecadastro
		// Idade

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// idpessoa
			$this->idpessoa->ViewValue = $this->idpessoa->CurrentValue;
			$this->idpessoa->ViewCustomAttributes = "";

			// idaula
			$curVal = strval($this->idaula->CurrentValue);
			if ($curVal != "") {
				$this->idaula->ViewValue = $this->idaula->lookupCacheOption($curVal);
				if ($this->idaula->ViewValue === NULL) { // Lookup from database
					$filterWrk = "`idaulas`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					$sqlWrk = $this->idaula->Lookup->getSql(FALSE, $filterWrk, $lookupFilter, $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = $rswrk->fields('df');
						$arwrk[2] = $rswrk->fields('df2');
						$this->idaula->ViewValue = $this->idaula->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idaula->ViewValue = $this->idaula->CurrentValue;
					}
				}
			} else {
				$this->idaula->ViewValue = NULL;
			}
			$this->idaula->ViewCustomAttributes = "";

			// Nome
			$this->Nome->ViewValue = $this->Nome->CurrentValue;
			$this->Nome->ViewCustomAttributes = "";

			// CPF
			$this->CPF->ViewValue = $this->CPF->CurrentValue;
			$this->CPF->ViewCustomAttributes = "";

			// Senha
			$this->Senha->ViewValue = $Language->phrase("PasswordMask");
			$this->Senha->ViewCustomAttributes = "";

			// Sexo
			if (strval($this->Sexo->CurrentValue) != "") {
				$this->Sexo->ViewValue = $this->Sexo->optionCaption($this->Sexo->CurrentValue);
			} else {
				$this->Sexo->ViewValue = NULL;
			}
			$this->Sexo->ViewCustomAttributes = "";

			// datanascimento
			$this->datanascimento->ViewValue = $this->datanascimento->CurrentValue;
			$this->datanascimento->ViewValue = FormatDateTime($this->datanascimento->ViewValue, 7);
			$this->datanascimento->ViewCustomAttributes = "";

			// Funcao
			if ($Security->canAdmin()) { // System admin
				$curVal = strval($this->Funcao->CurrentValue);
				if ($curVal != "") {
					$this->Funcao->ViewValue = $this->Funcao->lookupCacheOption($curVal);
					if ($this->Funcao->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`userlevelid`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$sqlWrk = $this->Funcao->Lookup->getSql(FALSE, $filterWrk, '', $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$this->Funcao->ViewValue = $this->Funcao->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->Funcao->ViewValue = $this->Funcao->CurrentValue;
						}
					}
				} else {
					$this->Funcao->ViewValue = NULL;
				}
			} else {
				$this->Funcao->ViewValue = $Language->phrase("PasswordMask");
			}
			$this->Funcao->ViewCustomAttributes = "";

			// Email
			$this->_Email->ViewValue = $this->_Email->CurrentValue;
			$this->_Email->ViewCustomAttributes = "";

			// Ativado
			if (strval($this->Ativado->CurrentValue) != "") {
				$this->Ativado->ViewValue = $this->Ativado->optionCaption($this->Ativado->CurrentValue);
			} else {
				$this->Ativado->ViewValue = NULL;
			}
			$this->Ativado->ViewCustomAttributes = "";

			// datadecadastro
			$this->datadecadastro->ViewValue = $this->datadecadastro->CurrentValue;
			$this->datadecadastro->ViewValue = FormatDateTime($this->datadecadastro->ViewValue, 0);
			$this->datadecadastro->ViewCustomAttributes = "";

			// Idade
			$this->Idade->ViewValue = $this->Idade->CurrentValue;
			$this->Idade->ViewValue = FormatNumber($this->Idade->ViewValue, 0, -2, -2, -2);
			$this->Idade->ViewCustomAttributes = "";

			// idaula
			$this->idaula->LinkCustomAttributes = "";
			$this->idaula->HrefValue = "";
			$this->idaula->TooltipValue = "";

			// Nome
			$this->Nome->LinkCustomAttributes = "";
			$this->Nome->HrefValue = "";
			$this->Nome->TooltipValue = "";

			// CPF
			$this->CPF->LinkCustomAttributes = "";
			$this->CPF->HrefValue = "";
			$this->CPF->TooltipValue = "";

			// Senha
			$this->Senha->LinkCustomAttributes = "";
			$this->Senha->HrefValue = "";
			$this->Senha->TooltipValue = "";

			// Sexo
			$this->Sexo->LinkCustomAttributes = "";
			$this->Sexo->HrefValue = "";
			$this->Sexo->TooltipValue = "";

			// datanascimento
			$this->datanascimento->LinkCustomAttributes = "";
			$this->datanascimento->HrefValue = "";
			$this->datanascimento->TooltipValue = "";

			// Funcao
			$this->Funcao->LinkCustomAttributes = "";
			$this->Funcao->HrefValue = "";
			$this->Funcao->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";

			// Ativado
			$this->Ativado->LinkCustomAttributes = "";
			$this->Ativado->HrefValue = "";
			$this->Ativado->TooltipValue = "";

			// Idade
			$this->Idade->LinkCustomAttributes = "";
			$this->Idade->HrefValue = "";
			$this->Idade->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_ADD) { // Add row

			// idaula
			$this->idaula->EditAttrs["class"] = "form-control";
			$this->idaula->EditCustomAttributes = "";
			if ($this->idaula->getSessionValue() != "") {
				$this->idaula->CurrentValue = $this->idaula->getSessionValue();
				$this->idaula->OldValue = $this->idaula->CurrentValue;
				$curVal = strval($this->idaula->CurrentValue);
				if ($curVal != "") {
					$this->idaula->ViewValue = $this->idaula->lookupCacheOption($curVal);
					if ($this->idaula->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`idaulas`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$lookupFilter = function() {
							return "`ativado`=1";
						};
						$lookupFilter = $lookupFilter->bindTo($this);
						$sqlWrk = $this->idaula->Lookup->getSql(FALSE, $filterWrk, $lookupFilter, $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$arwrk[2] = $rswrk->fields('df2');
							$this->idaula->ViewValue = $this->idaula->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idaula->ViewValue = $this->idaula->CurrentValue;
						}
					}
				} else {
					$this->idaula->ViewValue = NULL;
				}
				$this->idaula->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->idaula->CurrentValue));
				if ($curVal != "")
					$this->idaula->ViewValue = $this->idaula->lookupCacheOption($curVal);
				else
					$this->idaula->ViewValue = $this->idaula->Lookup !== NULL && is_array($this->idaula->Lookup->Options) ? $curVal : NULL;
				if ($this->idaula->ViewValue !== NULL) { // Load from cache
					$this->idaula->EditValue = array_values($this->idaula->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`idaulas`" . SearchString("=", $this->idaula->CurrentValue, DATATYPE_NUMBER, "");
					}
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					$sqlWrk = $this->idaula->Lookup->getSql(TRUE, $filterWrk, $lookupFilter, $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->idaula->EditValue = $arwrk;
				}
			}

			// Nome
			$this->Nome->EditAttrs["class"] = "form-control";
			$this->Nome->EditCustomAttributes = "";
			if (!$this->Nome->Raw)
				$this->Nome->CurrentValue = HtmlDecode($this->Nome->CurrentValue);
			$this->Nome->EditValue = HtmlEncode($this->Nome->CurrentValue);
			$this->Nome->PlaceHolder = RemoveHtml($this->Nome->caption());

			// CPF
			$this->CPF->EditAttrs["class"] = "form-control";
			$this->CPF->EditCustomAttributes = "";
			if (!$this->CPF->Raw)
				$this->CPF->CurrentValue = HtmlDecode($this->CPF->CurrentValue);
			$this->CPF->EditValue = HtmlEncode($this->CPF->CurrentValue);
			$this->CPF->PlaceHolder = RemoveHtml($this->CPF->caption());

			// Senha
			$this->Senha->EditAttrs["class"] = "form-control ew-password-strength";
			$this->Senha->EditCustomAttributes = "";
			$this->Senha->EditValue = HtmlEncode($this->Senha->CurrentValue);
			$this->Senha->PlaceHolder = RemoveHtml($this->Senha->caption());

			// Sexo
			$this->Sexo->EditCustomAttributes = "";
			$this->Sexo->EditValue = $this->Sexo->options(FALSE);

			// datanascimento
			$this->datanascimento->EditAttrs["class"] = "form-control";
			$this->datanascimento->EditCustomAttributes = "";
			$this->datanascimento->EditValue = HtmlEncode(FormatDateTime($this->datanascimento->CurrentValue, 7));
			$this->datanascimento->PlaceHolder = RemoveHtml($this->datanascimento->caption());

			// Funcao
			$this->Funcao->EditAttrs["class"] = "form-control";
			$this->Funcao->EditCustomAttributes = "";
			if (!$Security->canAdmin()) { // System admin
				$this->Funcao->EditValue = $Language->phrase("PasswordMask");
			} else {
				$curVal = trim(strval($this->Funcao->CurrentValue));
				if ($curVal != "")
					$this->Funcao->ViewValue = $this->Funcao->lookupCacheOption($curVal);
				else
					$this->Funcao->ViewValue = $this->Funcao->Lookup !== NULL && is_array($this->Funcao->Lookup->Options) ? $curVal : NULL;
				if ($this->Funcao->ViewValue !== NULL) { // Load from cache
					$this->Funcao->EditValue = array_values($this->Funcao->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`userlevelid`" . SearchString("=", $this->Funcao->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->Funcao->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->Funcao->EditValue = $arwrk;
				}
			}

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			if (!$this->_Email->Raw)
				$this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
			$this->_Email->EditValue = HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

			// Ativado
			$this->Ativado->EditCustomAttributes = "";
			$this->Ativado->EditValue = $this->Ativado->options(FALSE);

			// Idade
			$this->Idade->EditAttrs["class"] = "form-control";
			$this->Idade->EditCustomAttributes = "";
			$this->Idade->EditValue = HtmlEncode($this->Idade->CurrentValue);
			$this->Idade->PlaceHolder = RemoveHtml($this->Idade->caption());

			// Add refer script
			// idaula

			$this->idaula->LinkCustomAttributes = "";
			$this->idaula->HrefValue = "";

			// Nome
			$this->Nome->LinkCustomAttributes = "";
			$this->Nome->HrefValue = "";

			// CPF
			$this->CPF->LinkCustomAttributes = "";
			$this->CPF->HrefValue = "";

			// Senha
			$this->Senha->LinkCustomAttributes = "";
			$this->Senha->HrefValue = "";

			// Sexo
			$this->Sexo->LinkCustomAttributes = "";
			$this->Sexo->HrefValue = "";

			// datanascimento
			$this->datanascimento->LinkCustomAttributes = "";
			$this->datanascimento->HrefValue = "";

			// Funcao
			$this->Funcao->LinkCustomAttributes = "";
			$this->Funcao->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";

			// Ativado
			$this->Ativado->LinkCustomAttributes = "";
			$this->Ativado->HrefValue = "";

			// Idade
			$this->Idade->LinkCustomAttributes = "";
			$this->Idade->HrefValue = "";
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// idaula
			$this->idaula->EditAttrs["class"] = "form-control";
			$this->idaula->EditCustomAttributes = "";
			if ($this->idaula->getSessionValue() != "") {
				$this->idaula->CurrentValue = $this->idaula->getSessionValue();
				$this->idaula->OldValue = $this->idaula->CurrentValue;
				$curVal = strval($this->idaula->CurrentValue);
				if ($curVal != "") {
					$this->idaula->ViewValue = $this->idaula->lookupCacheOption($curVal);
					if ($this->idaula->ViewValue === NULL) { // Lookup from database
						$filterWrk = "`idaulas`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
						$lookupFilter = function() {
							return "`ativado`=1";
						};
						$lookupFilter = $lookupFilter->bindTo($this);
						$sqlWrk = $this->idaula->Lookup->getSql(FALSE, $filterWrk, $lookupFilter, $this);
						$rswrk = Conn()->execute($sqlWrk);
						if ($rswrk && !$rswrk->EOF) { // Lookup values found
							$arwrk = [];
							$arwrk[1] = $rswrk->fields('df');
							$arwrk[2] = $rswrk->fields('df2');
							$this->idaula->ViewValue = $this->idaula->displayValue($arwrk);
							$rswrk->Close();
						} else {
							$this->idaula->ViewValue = $this->idaula->CurrentValue;
						}
					}
				} else {
					$this->idaula->ViewValue = NULL;
				}
				$this->idaula->ViewCustomAttributes = "";
			} else {
				$curVal = trim(strval($this->idaula->CurrentValue));
				if ($curVal != "")
					$this->idaula->ViewValue = $this->idaula->lookupCacheOption($curVal);
				else
					$this->idaula->ViewValue = $this->idaula->Lookup !== NULL && is_array($this->idaula->Lookup->Options) ? $curVal : NULL;
				if ($this->idaula->ViewValue !== NULL) { // Load from cache
					$this->idaula->EditValue = array_values($this->idaula->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`idaulas`" . SearchString("=", $this->idaula->CurrentValue, DATATYPE_NUMBER, "");
					}
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					$sqlWrk = $this->idaula->Lookup->getSql(TRUE, $filterWrk, $lookupFilter, $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->idaula->EditValue = $arwrk;
				}
			}

			// Nome
			$this->Nome->EditAttrs["class"] = "form-control";
			$this->Nome->EditCustomAttributes = "";
			if (!$this->Nome->Raw)
				$this->Nome->CurrentValue = HtmlDecode($this->Nome->CurrentValue);
			$this->Nome->EditValue = HtmlEncode($this->Nome->CurrentValue);
			$this->Nome->PlaceHolder = RemoveHtml($this->Nome->caption());

			// CPF
			$this->CPF->EditAttrs["class"] = "form-control";
			$this->CPF->EditCustomAttributes = "";
			if (!$this->CPF->Raw)
				$this->CPF->CurrentValue = HtmlDecode($this->CPF->CurrentValue);
			$this->CPF->EditValue = HtmlEncode($this->CPF->CurrentValue);
			$this->CPF->PlaceHolder = RemoveHtml($this->CPF->caption());

			// Senha
			$this->Senha->EditAttrs["class"] = "form-control ew-password-strength";
			$this->Senha->EditCustomAttributes = "";
			$this->Senha->EditValue = HtmlEncode($this->Senha->CurrentValue);
			$this->Senha->PlaceHolder = RemoveHtml($this->Senha->caption());

			// Sexo
			$this->Sexo->EditCustomAttributes = "";
			$this->Sexo->EditValue = $this->Sexo->options(FALSE);

			// datanascimento
			$this->datanascimento->EditAttrs["class"] = "form-control";
			$this->datanascimento->EditCustomAttributes = "";
			$this->datanascimento->EditValue = HtmlEncode(FormatDateTime($this->datanascimento->CurrentValue, 7));
			$this->datanascimento->PlaceHolder = RemoveHtml($this->datanascimento->caption());

			// Funcao
			$this->Funcao->EditAttrs["class"] = "form-control";
			$this->Funcao->EditCustomAttributes = "";
			if (!$Security->canAdmin()) { // System admin
				$this->Funcao->EditValue = $Language->phrase("PasswordMask");
			} else {
				$curVal = trim(strval($this->Funcao->CurrentValue));
				if ($curVal != "")
					$this->Funcao->ViewValue = $this->Funcao->lookupCacheOption($curVal);
				else
					$this->Funcao->ViewValue = $this->Funcao->Lookup !== NULL && is_array($this->Funcao->Lookup->Options) ? $curVal : NULL;
				if ($this->Funcao->ViewValue !== NULL) { // Load from cache
					$this->Funcao->EditValue = array_values($this->Funcao->Lookup->Options);
				} else { // Lookup from database
					if ($curVal == "") {
						$filterWrk = "0=1";
					} else {
						$filterWrk = "`userlevelid`" . SearchString("=", $this->Funcao->CurrentValue, DATATYPE_NUMBER, "");
					}
					$sqlWrk = $this->Funcao->Lookup->getSql(TRUE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					$arwrk = $rswrk ? $rswrk->getRows() : [];
					if ($rswrk)
						$rswrk->close();
					$this->Funcao->EditValue = $arwrk;
				}
			}

			// Email
			$this->_Email->EditAttrs["class"] = "form-control";
			$this->_Email->EditCustomAttributes = "";
			if (!$this->_Email->Raw)
				$this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
			$this->_Email->EditValue = HtmlEncode($this->_Email->CurrentValue);
			$this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

			// Ativado
			$this->Ativado->EditCustomAttributes = "";
			$this->Ativado->EditValue = $this->Ativado->options(FALSE);

			// Idade
			$this->Idade->EditAttrs["class"] = "form-control";
			$this->Idade->EditCustomAttributes = "";
			$this->Idade->EditValue = HtmlEncode($this->Idade->CurrentValue);
			$this->Idade->PlaceHolder = RemoveHtml($this->Idade->caption());

			// Edit refer script
			// idaula

			$this->idaula->LinkCustomAttributes = "";
			$this->idaula->HrefValue = "";

			// Nome
			$this->Nome->LinkCustomAttributes = "";
			$this->Nome->HrefValue = "";

			// CPF
			$this->CPF->LinkCustomAttributes = "";
			$this->CPF->HrefValue = "";

			// Senha
			$this->Senha->LinkCustomAttributes = "";
			$this->Senha->HrefValue = "";

			// Sexo
			$this->Sexo->LinkCustomAttributes = "";
			$this->Sexo->HrefValue = "";

			// datanascimento
			$this->datanascimento->LinkCustomAttributes = "";
			$this->datanascimento->HrefValue = "";

			// Funcao
			$this->Funcao->LinkCustomAttributes = "";
			$this->Funcao->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";

			// Ativado
			$this->Ativado->LinkCustomAttributes = "";
			$this->Ativado->HrefValue = "";

			// Idade
			$this->Idade->LinkCustomAttributes = "";
			$this->Idade->HrefValue = "";
		}
		if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->setupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType != ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	protected function validateForm()
	{
		global $Language, $FormError;

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return ($FormError == "");
		if ($this->idaula->Required) {
			if (!$this->idaula->IsDetailKey && $this->idaula->FormValue != NULL && $this->idaula->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idaula->caption(), $this->idaula->RequiredErrorMessage));
			}
		}
		if ($this->Nome->Required) {
			if (!$this->Nome->IsDetailKey && $this->Nome->FormValue != NULL && $this->Nome->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Nome->caption(), $this->Nome->RequiredErrorMessage));
			}
		}
		if ($this->CPF->Required) {
			if (!$this->CPF->IsDetailKey && $this->CPF->FormValue != NULL && $this->CPF->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->CPF->caption(), $this->CPF->RequiredErrorMessage));
			}
		}
		if ($this->Senha->Required) {
			if (!$this->Senha->IsDetailKey && $this->Senha->FormValue != NULL && $this->Senha->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Senha->caption(), $this->Senha->RequiredErrorMessage));
			}
		}
		if ($this->Sexo->Required) {
			if ($this->Sexo->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Sexo->caption(), $this->Sexo->RequiredErrorMessage));
			}
		}
		if ($this->datanascimento->Required) {
			if (!$this->datanascimento->IsDetailKey && $this->datanascimento->FormValue != NULL && $this->datanascimento->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->datanascimento->caption(), $this->datanascimento->RequiredErrorMessage));
			}
		}
		if (!CheckEuroDate($this->datanascimento->FormValue)) {
			AddMessage($FormError, $this->datanascimento->errorMessage());
		}
		if ($this->Funcao->Required) {
			if (!$this->Funcao->IsDetailKey && $this->Funcao->FormValue != NULL && $this->Funcao->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Funcao->caption(), $this->Funcao->RequiredErrorMessage));
			}
		}
		if ($this->_Email->Required) {
			if (!$this->_Email->IsDetailKey && $this->_Email->FormValue != NULL && $this->_Email->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->_Email->caption(), $this->_Email->RequiredErrorMessage));
			}
		}
		if (!CheckEmail($this->_Email->FormValue)) {
			AddMessage($FormError, $this->_Email->errorMessage());
		}
		if ($this->Ativado->Required) {
			if ($this->Ativado->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Ativado->caption(), $this->Ativado->RequiredErrorMessage));
			}
		}
		if ($this->Idade->Required) {
			if (!$this->Idade->IsDetailKey && $this->Idade->FormValue != NULL && $this->Idade->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Idade->caption(), $this->Idade->RequiredErrorMessage));
			}
		}
		if (!CheckInteger($this->Idade->FormValue)) {
			AddMessage($FormError, $this->Idade->errorMessage());
		}

		// Return validate result
		$validateForm = ($FormError == "");

		// Call Form_CustomValidate event
		$formCustomError = "";
		$validateForm = $validateForm && $this->Form_CustomValidate($formCustomError);
		if ($formCustomError != "") {
			AddMessage($FormError, $formCustomError);
		}
		return $validateForm;
	}

	// Delete records based on current filter
	protected function deleteRows()
	{
		global $Language, $Security;
		if (!$Security->canDelete()) {
			$this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$deleteRows = TRUE;
		$sql = $this->getCurrentSql();
		$conn = $this->getConnection();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = "";
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // No record found
			$rs->close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->getRows() : [];

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->close();

		// Call row deleting event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$deleteRows = $this->Row_Deleting($row);
				if (!$deleteRows)
					break;
			}
		}
		if ($deleteRows) {
			$key = "";
			foreach ($rsold as $row) {
				$thisKey = "";
				if ($thisKey != "")
					$thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
				$thisKey .= $row['idpessoa'];
				if (Config("DELETE_UPLOADED_FILES")) // Delete old files
					$this->deleteUploadedFiles($row);
				$conn->raiseErrorFn = Config("ERROR_FUNC");
				$deleteRows = $this->delete($row); // Delete
				$conn->raiseErrorFn = "";
				if ($deleteRows === FALSE)
					break;
				if ($key != "")
					$key .= ", ";
				$key .= $thisKey;
			}
		}
		if (!$deleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage != "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("DeleteCancelled"));
			}
		}

		// Call Row Deleted event
		if ($deleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}

		// Write JSON for API request (Support single row only)
		if (IsApi() && $deleteRows) {
			$row = $this->getRecordsFromRecordset($rsold, TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $deleteRows;
	}

	// Update record based on key values
	protected function editRow()
	{
		global $Security, $Language;
		$oldKeyFilter = $this->getRecordFilter();
		$filter = $this->applyUserIDFilters($oldKeyFilter);
		$conn = $this->getConnection();
		$this->CurrentFilter = $filter;
		$sql = $this->getCurrentSql();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->execute($sql);
		$conn->raiseErrorFn = "";
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
			$editRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->loadDbValues($rsold);
			$rsnew = [];

			// idaula
			$this->idaula->setDbValueDef($rsnew, $this->idaula->CurrentValue, NULL, $this->idaula->ReadOnly);

			// Nome
			$this->Nome->setDbValueDef($rsnew, $this->Nome->CurrentValue, NULL, $this->Nome->ReadOnly);

			// CPF
			$this->CPF->setDbValueDef($rsnew, $this->CPF->CurrentValue, "", $this->CPF->ReadOnly);

			// Senha
			$this->Senha->setDbValueDef($rsnew, $this->Senha->CurrentValue, "", $this->Senha->ReadOnly || Config("ENCRYPTED_PASSWORD") && $rs->fields('Senha') == $this->Senha->CurrentValue);

			// Sexo
			$this->Sexo->setDbValueDef($rsnew, $this->Sexo->CurrentValue, NULL, $this->Sexo->ReadOnly);

			// datanascimento
			$this->datanascimento->setDbValueDef($rsnew, UnFormatDateTime($this->datanascimento->CurrentValue, 7), NULL, $this->datanascimento->ReadOnly);

			// Funcao
			
			if ($Security->canAdmin()) { // System admin
				
				$this->Funcao->setDbValueDef($rsnew, $this->Funcao->CurrentValue, NULL, $this->Funcao->ReadOnly);
				
			}
			

			// Email
			$this->_Email->setDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, $this->_Email->ReadOnly);

			// Ativado
			$this->Ativado->setDbValueDef($rsnew, $this->Ativado->CurrentValue, NULL, $this->Ativado->ReadOnly);

			// Idade
			$this->Idade->setDbValueDef($rsnew, $this->Idade->CurrentValue, NULL, $this->Idade->ReadOnly);

			// Call Row Updating event
			$updateRow = $this->Row_Updating($rsold, $rsnew);

			// Check for duplicate key when key changed
			if ($updateRow) {
				$newKeyFilter = $this->getRecordFilter($rsnew);
				if ($newKeyFilter != $oldKeyFilter) {
					$rsChk = $this->loadRs($newKeyFilter);
					if ($rsChk && !$rsChk->EOF) {
						$keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
						$this->setFailureMessage($keyErrMsg);
						$rsChk->close();
						$updateRow = FALSE;
					}
				}
			}
			if ($updateRow) {
				$conn->raiseErrorFn = Config("ERROR_FUNC");
				if (count($rsnew) > 0)
					$editRow = $this->update($rsnew, "", $rsold);
				else
					$editRow = TRUE; // No field to update
				$conn->raiseErrorFn = "";
				if ($editRow) {
				}
			} else {
				if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage != "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->phrase("UpdateCancelled"));
				}
				$editRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($editRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->close();

		// Clean upload path if any
		if ($editRow) {
		}

		// Write JSON for API request
		if (IsApi() && $editRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $editRow;
	}

	// Add record
	protected function addRow($rsold = NULL)
	{
		global $Language, $Security;

		// Check if valid User ID
		$validUser = FALSE;
		if ($Security->currentUserID() != "" && !EmptyValue($this->idpessoa->CurrentValue) && !$Security->isAdmin()) { // Non system admin
			$validUser = $Security->isValidUserID($this->idpessoa->CurrentValue);
			if (!$validUser) {
				$userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
				$userIdMsg = str_replace("%u", $this->idpessoa->CurrentValue, $userIdMsg);
				$this->setFailureMessage($userIdMsg);
				return FALSE;
			}
		}

		// Check if valid key values for master user
		if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
			$masterFilter = $this->sqlMasterFilter_aulas();
			if (strval($this->idaula->CurrentValue) != "") {
				$masterFilter = str_replace("@idaulas@", AdjustSql($this->idaula->CurrentValue, "DB"), $masterFilter);
			} else {
				$masterFilter = "";
			}
			if ($masterFilter != "") {
				$rsmaster = $GLOBALS["aulas"]->loadRs($masterFilter);
				$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
				$validMasterKey = TRUE;
				if ($this->MasterRecordExists) {
					$validMasterKey = $Security->isValidUserID($rsmaster->fields['idaluno']);
				} elseif ($this->getCurrentMasterTable() == "aulas") {
					$validMasterKey = FALSE;
				}
				if (!$validMasterKey) {
					$masterUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedMasterUserID"));
					$masterUserIdMsg = str_replace("%f", $masterFilter, $masterUserIdMsg);
					$this->setFailureMessage($masterUserIdMsg);
					return FALSE;
				}
				if ($rsmaster)
					$rsmaster->close();
			}
		}

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "aulas") {
				$this->idaula->CurrentValue = $this->idaula->getSessionValue();
			}
		$conn = $this->getConnection();

		// Load db values from rsold
		$this->loadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = [];

		// idaula
		$this->idaula->setDbValueDef($rsnew, $this->idaula->CurrentValue, NULL, FALSE);

		// Nome
		$this->Nome->setDbValueDef($rsnew, $this->Nome->CurrentValue, NULL, FALSE);

		// CPF
		$this->CPF->setDbValueDef($rsnew, $this->CPF->CurrentValue, "", FALSE);

		// Senha
		$this->Senha->setDbValueDef($rsnew, $this->Senha->CurrentValue, "", FALSE);

		// Sexo
		$this->Sexo->setDbValueDef($rsnew, $this->Sexo->CurrentValue, NULL, FALSE);

		// datanascimento
		$this->datanascimento->setDbValueDef($rsnew, UnFormatDateTime($this->datanascimento->CurrentValue, 7), NULL, FALSE);

		// Funcao
		
		if ($Security->canAdmin()) { // System admin
			
			$this->Funcao->setDbValueDef($rsnew, $this->Funcao->CurrentValue, NULL, strval($this->Funcao->CurrentValue) == "");
			
		}
		

		// Email
		$this->_Email->setDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, FALSE);

		// Ativado
		$this->Ativado->setDbValueDef($rsnew, $this->Ativado->CurrentValue, NULL, FALSE);

		// Idade
		$this->Idade->setDbValueDef($rsnew, $this->Idade->CurrentValue, NULL, FALSE);

		// idpessoa
		// Call Row Inserting event

		$rs = ($rsold) ? $rsold->fields : NULL;
		$insertRow = $this->Row_Inserting($rs, $rsnew);
		if ($insertRow) {
			$conn->raiseErrorFn = Config("ERROR_FUNC");
			$addRow = $this->insert($rsnew);
			$conn->raiseErrorFn = "";
			if ($addRow) {
			}
		} else {
			if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage != "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->phrase("InsertCancelled"));
			}
			$addRow = FALSE;
		}
		if ($addRow) {

			// Call Row Inserted event
			$rs = ($rsold) ? $rsold->fields : NULL;
			$this->Row_Inserted($rs, $rsnew);
		}

		// Clean upload path if any
		if ($addRow) {
		}

		// Write JSON for API request
		if (IsApi() && $addRow) {
			$row = $this->getRecordsFromRecordset([$rsnew], TRUE);
			WriteJson(["success" => TRUE, $this->TableVar => $row]);
		}
		return $addRow;
	}

	// Show link optionally based on User ID
	protected function showOptionLink($id = "")
	{
		global $Security;
		if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id))
			return $Security->isValidUserID($this->idpessoa->CurrentValue);
		return TRUE;
	}

	// Set up master/detail based on QueryString
	protected function setupMasterParms()
	{

		// Hide foreign keys
		$masterTblVar = $this->getCurrentMasterTable();
		if ($masterTblVar == "aulas") {
			$this->idaula->Visible = FALSE;
			if ($GLOBALS["aulas"]->EventCancelled)
				$this->EventCancelled = TRUE;
		}
		$this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// Get default connection and filter
			$conn = $this->getConnection();
			$lookupFilter = "";

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL and connection
			switch ($fld->FieldVar) {
				case "x_idaula":
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					break;
				case "x_Sexo":
					break;
				case "x_Funcao":
					break;
				case "x_Ativado":
					break;
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
				$totalCnt = $this->getRecordCount($sql, $conn);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
						case "x_idaula":
							break;
						case "x_Funcao":
							break;
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
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
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$customError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions["new"]->Body = "xxx";

	}
} // End class
?>