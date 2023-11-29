<?php
namespace PHPMaker2020\sistema;

/**
 * Page class
 */
class pessoa_update extends pessoa
{

	// Page ID
	public $PageID = "update";

	// Project ID
	public $ProjectID = "{448C0B4B-C32A-40EF-8151-41E96F03E813}";

	// Table name
	public $TableName = 'pessoa';

	// Page object name
	public $PageObjName = "pessoa_update";

	// Audit Trail
	public $AuditTrailOnAdd = TRUE;
	public $AuditTrailOnEdit = TRUE;
	public $AuditTrailOnDelete = TRUE;
	public $AuditTrailOnView = FALSE;
	public $AuditTrailOnViewData = FALSE;
	public $AuditTrailOnSearch = FALSE;

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
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (pessoa)
		if (!isset($GLOBALS["pessoa"]) || get_class($GLOBALS["pessoa"]) == PROJECT_NAMESPACE . "pessoa") {
			$GLOBALS["pessoa"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["pessoa"];
		}

		// Table object (aulas)
		if (!isset($GLOBALS['aulas']))
			$GLOBALS['aulas'] = new aulas();

		// Page ID (for backward compatibility only)
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'update');

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
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages, $DashboardReport;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

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
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = ["url" => $url, "modal" => "1"];
				$pageName = GetPageName($url);
				if ($pageName != $this->getListUrl()) { // Not List page
					$row["caption"] = $this->getModalCaption($pageName);
					if ($pageName == "pessoaview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				WriteJson($row);
			} else {
				SaveDebugMessage();
				AddHeader("Location", $url);
			}
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
	public $FormClassName = "ew-horizontal ew-form ew-update-form";
	public $IsModal = FALSE;
	public $IsMobileOrModal = FALSE;
	public $RecKeys;
	public $Disabled;
	public $UpdateCount = 0;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
			$FormError, $SkipHeaderFooter;

		// Is modal
		$this->IsModal = (Param("modal") == "1");

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
			if (!$Security->canEdit()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				if ($Security->canList())
					$this->terminate(GetUrl("pessoalist.php"));
				else
					$this->terminate(GetUrl("login.php"));
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

		// Create form object
		$CurrentForm = new HttpForm();
		$this->CurrentAction = Param("action"); // Set up current action
		$this->idpessoa->Visible = FALSE;
		$this->idaula->setVisibility();
		$this->Nome->setVisibility();
		$this->CPF->setVisibility();
		$this->Senha->setVisibility();
		$this->Sexo->setVisibility();
		$this->datanascimento->setVisibility();
		$this->Funcao->setVisibility();
		$this->Sessao->setVisibility();
		$this->_Email->setVisibility();
		$this->Ativado->setVisibility();
		$this->datadecadastro->setVisibility();
		$this->Idade->setVisibility();
		$this->hideFieldsForAddEdit();

		// Do not use lookup cache
		$this->setUseLookupCache(FALSE);

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

		// Set up lookup cache
		$this->setupLookupOptions($this->idaula);
		$this->setupLookupOptions($this->Funcao);

		// Check modal
		if ($this->IsModal)
			$SkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = IsMobile() || $this->IsModal;
		$this->FormClassName = "ew-form ew-update-form ew-horizontal";

		// Set up Breadcrumb
		$this->setupBreadcrumb();

		// Try to load keys from list form
		$this->RecKeys = $this->getRecordKeys(); // Load record keys

		// Check if valid User ID
		$sql = $this->getSql($this->getFilterFromRecordKeys(FALSE));
		$conn = $this->getConnection();
		if ($this->Recordset = LoadRecordset($sql, $conn)) {
			$res = TRUE;
			while (!$this->Recordset->EOF) {
				$this->loadRowValues($this->Recordset);
				if (!$this->showOptionLink('update')) {
					$userIdMsg = $Language->phrase("NoEditPermission");
					$this->setFailureMessage($userIdMsg);
					$res = FALSE;
					break;
				}
				$this->Recordset->moveNext();
			}
			$this->Recordset->close();
			if (!$res)
				$this->terminate("pessoalist.php"); // Return to list
		}
		if (Post("action") !== NULL && Post("action") !== "") {

			// Get action
			$this->CurrentAction = Post("action");
			$this->loadFormValues(); // Get form values

			// Validate form
			if (!$this->validateForm()) {
				$this->CurrentAction = "show"; // Form error, reset action
				$this->setFailureMessage($FormError);
			}
		} else {
			$this->loadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->terminate("pessoalist.php"); // No records selected, return to list
		if ($this->isUpdate()) {
				if ($this->updateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
					$this->terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->restoreFormValues(); // Restore form values
				}
		}

		// Render row
		if ($this->isConfirm()) { // Confirm page
			$this->RowType = ROWTYPE_VIEW; // Render view
			$this->Disabled = " disabled";
		} else {
			$this->RowType = ROWTYPE_EDIT; // Render edit
			$this->Disabled = "";
		}
		$this->resetAttributes();
		$this->renderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	protected function loadMultiUpdateValues()
	{
		$this->CurrentFilter = $this->getFilterFromRecordKeys();

		// Load recordset
		if ($this->Recordset = $this->loadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->idaula->setDbValue($this->Recordset->fields('idaula'));
					$this->Nome->setDbValue($this->Recordset->fields('Nome'));
					$this->CPF->setDbValue($this->Recordset->fields('CPF'));
					$this->Senha->setDbValue($this->Recordset->fields('Senha'));
					$this->Sexo->setDbValue($this->Recordset->fields('Sexo'));
					$this->datanascimento->setDbValue($this->Recordset->fields('datanascimento'));
					$this->Funcao->setDbValue($this->Recordset->fields('Funcao'));
					$this->Sessao->setDbValue($this->Recordset->fields('Sessao'));
					$this->_Email->setDbValue($this->Recordset->fields('Email'));
					$this->Ativado->setDbValue($this->Recordset->fields('Ativado'));
					$this->datadecadastro->setDbValue($this->Recordset->fields('datadecadastro'));
					$this->Idade->setDbValue($this->Recordset->fields('Idade'));
				} else {
					if (!CompareValue($this->idaula->DbValue, $this->Recordset->fields('idaula')))
						$this->idaula->CurrentValue = NULL;
					if (!CompareValue($this->Nome->DbValue, $this->Recordset->fields('Nome')))
						$this->Nome->CurrentValue = NULL;
					if (!CompareValue($this->CPF->DbValue, $this->Recordset->fields('CPF')))
						$this->CPF->CurrentValue = NULL;
					if (!CompareValue($this->Senha->DbValue, $this->Recordset->fields('Senha')))
						$this->Senha->CurrentValue = NULL;
					if (!CompareValue($this->Sexo->DbValue, $this->Recordset->fields('Sexo')))
						$this->Sexo->CurrentValue = NULL;
					if (!CompareValue($this->datanascimento->DbValue, $this->Recordset->fields('datanascimento')))
						$this->datanascimento->CurrentValue = NULL;
					if (!CompareValue($this->Funcao->DbValue, $this->Recordset->fields('Funcao')))
						$this->Funcao->CurrentValue = NULL;
					if (!CompareValue($this->Sessao->DbValue, $this->Recordset->fields('Sessao')))
						$this->Sessao->CurrentValue = NULL;
					if (!CompareValue($this->_Email->DbValue, $this->Recordset->fields('Email')))
						$this->_Email->CurrentValue = NULL;
					if (!CompareValue($this->Ativado->DbValue, $this->Recordset->fields('Ativado')))
						$this->Ativado->CurrentValue = NULL;
					if (!CompareValue($this->datadecadastro->DbValue, $this->Recordset->fields('datadecadastro')))
						$this->datadecadastro->CurrentValue = NULL;
					if (!CompareValue($this->Idade->DbValue, $this->Recordset->fields('Idade')))
						$this->Idade->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->moveNext();
			}
			$this->Recordset->close();
		}
	}

	// Set up key value
	protected function setupKeyValues($key)
	{
		$keyFld = $key;
		if (!is_numeric($keyFld))
			return FALSE;
		$this->idpessoa->OldValue = $keyFld;
		return TRUE;
	}

	// Update all selected rows
	protected function updateRows()
	{
		global $Language;
		$conn = $this->getConnection();
		$conn->beginTrans();
		if ($this->AuditTrailOnEdit)
			$this->writeAuditTrailDummy($Language->phrase("BatchUpdateBegin")); // Batch update begin

		// Get old recordset
		$this->CurrentFilter = $this->getFilterFromRecordKeys(FALSE);
		$sql = $this->getCurrentSql();
		$rsold = $conn->execute($sql);

		// Update all rows
		$key = "";
		foreach ($this->RecKeys as $reckey) {
			if ($this->setupKeyValues($reckey)) {
				$thisKey = $reckey;
				$this->SendEmail = FALSE; // Do not send email on update success
				$this->UpdateCount += 1; // Update record count for records being updated
				$updateRows = $this->editRow(); // Update this row
			} else {
				$updateRows = FALSE;
			}
			if (!$updateRows)
				break; // Update failed
			if ($key != "")
				$key .= ", ";
			$key .= $thisKey;
		}

		// Check if all rows updated
		if ($updateRows) {
			$conn->commitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->execute($sql);
			if ($this->AuditTrailOnEdit)
				$this->writeAuditTrailDummy($Language->phrase("BatchUpdateSuccess")); // Batch update success
			$table = 'pessoa';
			$subject = $table . " " . $Language->phrase("RecordUpdated");
			$action = $Language->phrase("ActionUpdatedMultiUpdate");
			$email = new Email();
			$email->load(Config("EMAIL_NOTIFY_TEMPLATE"));
			$email->replaceSender(Config("SENDER_EMAIL")); // Replace Sender
			$email->replaceRecipient(Config("RECIPIENT_EMAIL")); // Replace Recipient
			$email->replaceSubject($subject); // Replace Subject
			$email->replaceContent('<!--table-->', $table);
			$email->replaceContent('<!--key-->', $key);
			$email->replaceContent('<!--action-->', $action);
			$args = [];
			$args["rsold"] = $rsold->getRows();
			$args["rsnew"] = $rsnew->getRows();
			$emailSent = FALSE;
			if ($this->Email_Sending($email, $args))
				$emailSent = $email->send();

			// Send email failed
			if (!$emailSent)
				$this->setFailureMessage($email->SendErrDescription);
		} else {
			$conn->rollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit)
				$this->writeAuditTrailDummy($Language->phrase("BatchUpdateRollback")); // Batch update rollback
		}
		return $updateRows;
	}

	// Get upload files
	protected function getUploadFiles()
	{
		global $CurrentForm, $Language;
	}

	// Load form values
	protected function loadFormValues()
	{

		// Load from form
		global $CurrentForm;

		// Check field name 'idaula' first before field var 'x_idaula'
		$val = $CurrentForm->hasValue("idaula") ? $CurrentForm->getValue("idaula") : $CurrentForm->getValue("x_idaula");
		if (!$this->idaula->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->idaula->Visible = FALSE; // Disable update for API request
			else
				$this->idaula->setFormValue($val);
		}
		$this->idaula->MultiUpdate = $CurrentForm->getValue("u_idaula");

		// Check field name 'Nome' first before field var 'x_Nome'
		$val = $CurrentForm->hasValue("Nome") ? $CurrentForm->getValue("Nome") : $CurrentForm->getValue("x_Nome");
		if (!$this->Nome->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Nome->Visible = FALSE; // Disable update for API request
			else
				$this->Nome->setFormValue($val);
		}
		$this->Nome->MultiUpdate = $CurrentForm->getValue("u_Nome");

		// Check field name 'CPF' first before field var 'x_CPF'
		$val = $CurrentForm->hasValue("CPF") ? $CurrentForm->getValue("CPF") : $CurrentForm->getValue("x_CPF");
		if (!$this->CPF->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->CPF->Visible = FALSE; // Disable update for API request
			else
				$this->CPF->setFormValue($val);
		}
		$this->CPF->MultiUpdate = $CurrentForm->getValue("u_CPF");

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
		$this->Senha->MultiUpdate = $CurrentForm->getValue("u_Senha");

		// Check field name 'Sexo' first before field var 'x_Sexo'
		$val = $CurrentForm->hasValue("Sexo") ? $CurrentForm->getValue("Sexo") : $CurrentForm->getValue("x_Sexo");
		if (!$this->Sexo->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Sexo->Visible = FALSE; // Disable update for API request
			else
				$this->Sexo->setFormValue($val);
		}
		$this->Sexo->MultiUpdate = $CurrentForm->getValue("u_Sexo");

		// Check field name 'datanascimento' first before field var 'x_datanascimento'
		$val = $CurrentForm->hasValue("datanascimento") ? $CurrentForm->getValue("datanascimento") : $CurrentForm->getValue("x_datanascimento");
		if (!$this->datanascimento->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->datanascimento->Visible = FALSE; // Disable update for API request
			else
				$this->datanascimento->setFormValue($val);
			$this->datanascimento->CurrentValue = UnFormatDateTime($this->datanascimento->CurrentValue, 7);
		}
		$this->datanascimento->MultiUpdate = $CurrentForm->getValue("u_datanascimento");

		// Check field name 'Funcao' first before field var 'x_Funcao'
		$val = $CurrentForm->hasValue("Funcao") ? $CurrentForm->getValue("Funcao") : $CurrentForm->getValue("x_Funcao");
		if (!$this->Funcao->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Funcao->Visible = FALSE; // Disable update for API request
			else
				$this->Funcao->setFormValue($val);
		}
		$this->Funcao->MultiUpdate = $CurrentForm->getValue("u_Funcao");

		// Check field name 'Sessao' first before field var 'x_Sessao'
		$val = $CurrentForm->hasValue("Sessao") ? $CurrentForm->getValue("Sessao") : $CurrentForm->getValue("x_Sessao");
		if (!$this->Sessao->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Sessao->Visible = FALSE; // Disable update for API request
			else
				$this->Sessao->setFormValue($val);
		}
		$this->Sessao->MultiUpdate = $CurrentForm->getValue("u_Sessao");

		// Check field name 'Email' first before field var 'x__Email'
		$val = $CurrentForm->hasValue("Email") ? $CurrentForm->getValue("Email") : $CurrentForm->getValue("x__Email");
		if (!$this->_Email->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->_Email->Visible = FALSE; // Disable update for API request
			else
				$this->_Email->setFormValue($val);
		}
		$this->_Email->MultiUpdate = $CurrentForm->getValue("u__Email");

		// Check field name 'Ativado' first before field var 'x_Ativado'
		$val = $CurrentForm->hasValue("Ativado") ? $CurrentForm->getValue("Ativado") : $CurrentForm->getValue("x_Ativado");
		if (!$this->Ativado->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Ativado->Visible = FALSE; // Disable update for API request
			else
				$this->Ativado->setFormValue($val);
		}
		$this->Ativado->MultiUpdate = $CurrentForm->getValue("u_Ativado");

		// Check field name 'datadecadastro' first before field var 'x_datadecadastro'
		$val = $CurrentForm->hasValue("datadecadastro") ? $CurrentForm->getValue("datadecadastro") : $CurrentForm->getValue("x_datadecadastro");
		if (!$this->datadecadastro->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->datadecadastro->Visible = FALSE; // Disable update for API request
			else
				$this->datadecadastro->setFormValue($val);
			$this->datadecadastro->CurrentValue = UnFormatDateTime($this->datadecadastro->CurrentValue, 0);
		}
		$this->datadecadastro->MultiUpdate = $CurrentForm->getValue("u_datadecadastro");

		// Check field name 'Idade' first before field var 'x_Idade'
		$val = $CurrentForm->hasValue("Idade") ? $CurrentForm->getValue("Idade") : $CurrentForm->getValue("x_Idade");
		if (!$this->Idade->IsDetailKey) {
			if (IsApi() && $val === NULL)
				$this->Idade->Visible = FALSE; // Disable update for API request
			else
				$this->Idade->setFormValue($val);
		}
		$this->Idade->MultiUpdate = $CurrentForm->getValue("u_Idade");

		// Check field name 'idpessoa' first before field var 'x_idpessoa'
		$val = $CurrentForm->hasValue("idpessoa") ? $CurrentForm->getValue("idpessoa") : $CurrentForm->getValue("x_idpessoa");
		if (!$this->idpessoa->IsDetailKey)
			$this->idpessoa->setFormValue($val);
	}

	// Restore form values
	public function restoreFormValues()
	{
		global $CurrentForm;
		$this->idpessoa->CurrentValue = $this->idpessoa->FormValue;
		$this->idaula->CurrentValue = $this->idaula->FormValue;
		$this->Nome->CurrentValue = $this->Nome->FormValue;
		$this->CPF->CurrentValue = $this->CPF->FormValue;
		$this->Senha->CurrentValue = $this->Senha->FormValue;
		$this->Sexo->CurrentValue = $this->Sexo->FormValue;
		$this->datanascimento->CurrentValue = $this->datanascimento->FormValue;
		$this->datanascimento->CurrentValue = UnFormatDateTime($this->datanascimento->CurrentValue, 7);
		$this->Funcao->CurrentValue = $this->Funcao->FormValue;
		$this->Sessao->CurrentValue = $this->Sessao->FormValue;
		$this->_Email->CurrentValue = $this->_Email->FormValue;
		$this->Ativado->CurrentValue = $this->Ativado->FormValue;
		$this->datadecadastro->CurrentValue = $this->datadecadastro->FormValue;
		$this->datadecadastro->CurrentValue = UnFormatDateTime($this->datadecadastro->CurrentValue, 0);
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
		$row = [];
		$row['idpessoa'] = NULL;
		$row['idaula'] = NULL;
		$row['Nome'] = NULL;
		$row['CPF'] = NULL;
		$row['Senha'] = NULL;
		$row['Sexo'] = NULL;
		$row['datanascimento'] = NULL;
		$row['Funcao'] = NULL;
		$row['Sessao'] = NULL;
		$row['Email'] = NULL;
		$row['Ativado'] = NULL;
		$row['datadecadastro'] = NULL;
		$row['Idade'] = NULL;
		return $row;
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
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
			$this->idaula->ViewValue = $this->idaula->CurrentValue;
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
						$arwrk[2] = FormatNumber($rswrk->fields('df2'), 0, -2, -2, -2);
						$arwrk[3] = $rswrk->fields('df3');
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

			// Sessao
			$this->Sessao->ViewValue = $this->Sessao->CurrentValue;
			$this->Sessao->ViewCustomAttributes = "";

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

			// Sessao
			$this->Sessao->LinkCustomAttributes = "";
			$this->Sessao->HrefValue = "";
			$this->Sessao->TooltipValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";
			$this->_Email->TooltipValue = "";

			// Ativado
			$this->Ativado->LinkCustomAttributes = "";
			$this->Ativado->HrefValue = "";
			$this->Ativado->TooltipValue = "";

			// datadecadastro
			$this->datadecadastro->LinkCustomAttributes = "";
			$this->datadecadastro->HrefValue = "";
			$this->datadecadastro->TooltipValue = "";

			// Idade
			$this->Idade->LinkCustomAttributes = "";
			$this->Idade->HrefValue = "";
			$this->Idade->TooltipValue = "";
		} elseif ($this->RowType == ROWTYPE_EDIT) { // Edit row

			// idaula
			$this->idaula->EditAttrs["class"] = "form-control";
			$this->idaula->EditCustomAttributes = "";
			$this->idaula->EditValue = HtmlEncode($this->idaula->CurrentValue);
			$curVal = strval($this->idaula->CurrentValue);
			if ($curVal != "") {
				$this->idaula->EditValue = $this->idaula->lookupCacheOption($curVal);
				if ($this->idaula->EditValue === NULL) { // Lookup from database
					$filterWrk = "`idaulas`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$lookupFilter = function() {
						return "`ativado`=1";
					};
					$lookupFilter = $lookupFilter->bindTo($this);
					$sqlWrk = $this->idaula->Lookup->getSql(FALSE, $filterWrk, $lookupFilter, $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = [];
						$arwrk[1] = HtmlEncode($rswrk->fields('df'));
						$arwrk[2] = HtmlEncode(FormatNumber($rswrk->fields('df2'), 0, -2, -2, -2));
						$arwrk[3] = HtmlEncode($rswrk->fields('df3'));
						$this->idaula->EditValue = $this->idaula->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->idaula->EditValue = HtmlEncode($this->idaula->CurrentValue);
					}
				}
			} else {
				$this->idaula->EditValue = NULL;
			}
			$this->idaula->PlaceHolder = RemoveHtml($this->idaula->caption());

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

			// Sessao
			$this->Sessao->EditAttrs["class"] = "form-control";
			$this->Sessao->EditCustomAttributes = "";
			$this->Sessao->EditValue = HtmlEncode($this->Sessao->CurrentValue);
			$this->Sessao->PlaceHolder = RemoveHtml($this->Sessao->caption());

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

			// datadecadastro
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

			// Sessao
			$this->Sessao->LinkCustomAttributes = "";
			$this->Sessao->HrefValue = "";

			// Email
			$this->_Email->LinkCustomAttributes = "";
			$this->_Email->HrefValue = "";

			// Ativado
			$this->Ativado->LinkCustomAttributes = "";
			$this->Ativado->HrefValue = "";

			// datadecadastro
			$this->datadecadastro->LinkCustomAttributes = "";
			$this->datadecadastro->HrefValue = "";

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

		// Initialize form error message
		$FormError = "";
		$updateCnt = 0;
		if ($this->idaula->MultiUpdate == "1")
			$updateCnt++;
		if ($this->Nome->MultiUpdate == "1")
			$updateCnt++;
		if ($this->CPF->MultiUpdate == "1")
			$updateCnt++;
		if ($this->Senha->MultiUpdate == "1")
			$updateCnt++;
		if ($this->Sexo->MultiUpdate == "1")
			$updateCnt++;
		if ($this->datanascimento->MultiUpdate == "1")
			$updateCnt++;
		if ($this->Funcao->MultiUpdate == "1")
			$updateCnt++;
		if ($this->Sessao->MultiUpdate == "1")
			$updateCnt++;
		if ($this->_Email->MultiUpdate == "1")
			$updateCnt++;
		if ($this->Ativado->MultiUpdate == "1")
			$updateCnt++;
		if ($this->datadecadastro->MultiUpdate == "1")
			$updateCnt++;
		if ($this->Idade->MultiUpdate == "1")
			$updateCnt++;
		if ($updateCnt == 0) {
			$FormError = $Language->phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!Config("SERVER_VALIDATE"))
			return ($FormError == "");
		if ($this->idaula->Required) {
			if ($this->idaula->MultiUpdate != "" && !$this->idaula->IsDetailKey && $this->idaula->FormValue != NULL && $this->idaula->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->idaula->caption(), $this->idaula->RequiredErrorMessage));
			}
		}
		if ($this->idaula->MultiUpdate != "") {
			if (!CheckInteger($this->idaula->FormValue)) {
				AddMessage($FormError, $this->idaula->errorMessage());
			}
		}
		if ($this->Nome->Required) {
			if ($this->Nome->MultiUpdate != "" && !$this->Nome->IsDetailKey && $this->Nome->FormValue != NULL && $this->Nome->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Nome->caption(), $this->Nome->RequiredErrorMessage));
			}
		}
		if ($this->CPF->Required) {
			if ($this->CPF->MultiUpdate != "" && !$this->CPF->IsDetailKey && $this->CPF->FormValue != NULL && $this->CPF->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->CPF->caption(), $this->CPF->RequiredErrorMessage));
			}
		}
		if ($this->Senha->Required) {
			if ($this->Senha->MultiUpdate != "" && !$this->Senha->IsDetailKey && $this->Senha->FormValue != NULL && $this->Senha->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Senha->caption(), $this->Senha->RequiredErrorMessage));
			}
		}
		if ($this->Sexo->Required) {
			if ($this->Sexo->MultiUpdate != "" && $this->Sexo->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Sexo->caption(), $this->Sexo->RequiredErrorMessage));
			}
		}
		if ($this->datanascimento->Required) {
			if ($this->datanascimento->MultiUpdate != "" && !$this->datanascimento->IsDetailKey && $this->datanascimento->FormValue != NULL && $this->datanascimento->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->datanascimento->caption(), $this->datanascimento->RequiredErrorMessage));
			}
		}
		if ($this->datanascimento->MultiUpdate != "") {
			if (!CheckEuroDate($this->datanascimento->FormValue)) {
				AddMessage($FormError, $this->datanascimento->errorMessage());
			}
		}
		if ($this->Funcao->Required) {
			if ($this->Funcao->MultiUpdate != "" && !$this->Funcao->IsDetailKey && $this->Funcao->FormValue != NULL && $this->Funcao->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Funcao->caption(), $this->Funcao->RequiredErrorMessage));
			}
		}
		if ($this->Sessao->Required) {
			if ($this->Sessao->MultiUpdate != "" && !$this->Sessao->IsDetailKey && $this->Sessao->FormValue != NULL && $this->Sessao->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Sessao->caption(), $this->Sessao->RequiredErrorMessage));
			}
		}
		if ($this->_Email->Required) {
			if ($this->_Email->MultiUpdate != "" && !$this->_Email->IsDetailKey && $this->_Email->FormValue != NULL && $this->_Email->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->_Email->caption(), $this->_Email->RequiredErrorMessage));
			}
		}
		if ($this->_Email->MultiUpdate != "") {
			if (!CheckEmail($this->_Email->FormValue)) {
				AddMessage($FormError, $this->_Email->errorMessage());
			}
		}
		if ($this->Ativado->Required) {
			if ($this->Ativado->MultiUpdate != "" && $this->Ativado->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Ativado->caption(), $this->Ativado->RequiredErrorMessage));
			}
		}
		if ($this->datadecadastro->Required) {
			if ($this->datadecadastro->MultiUpdate != "" && !$this->datadecadastro->IsDetailKey && $this->datadecadastro->FormValue != NULL && $this->datadecadastro->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->datadecadastro->caption(), $this->datadecadastro->RequiredErrorMessage));
			}
		}
		if ($this->Idade->Required) {
			if ($this->Idade->MultiUpdate != "" && !$this->Idade->IsDetailKey && $this->Idade->FormValue != NULL && $this->Idade->FormValue == "") {
				AddMessage($FormError, str_replace("%s", $this->Idade->caption(), $this->Idade->RequiredErrorMessage));
			}
		}
		if ($this->Idade->MultiUpdate != "") {
			if (!CheckInteger($this->Idade->FormValue)) {
				AddMessage($FormError, $this->Idade->errorMessage());
			}
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
			$this->idaula->setDbValueDef($rsnew, $this->idaula->CurrentValue, NULL, $this->idaula->ReadOnly || $this->idaula->MultiUpdate != "1");

			// Nome
			$this->Nome->setDbValueDef($rsnew, $this->Nome->CurrentValue, NULL, $this->Nome->ReadOnly || $this->Nome->MultiUpdate != "1");

			// CPF
			$this->CPF->setDbValueDef($rsnew, $this->CPF->CurrentValue, "", $this->CPF->ReadOnly || $this->CPF->MultiUpdate != "1");

			// Senha
			$this->Senha->setDbValueDef($rsnew, $this->Senha->CurrentValue, "", $this->Senha->ReadOnly || $this->Senha->MultiUpdate != "1" || Config("ENCRYPTED_PASSWORD") && $rs->fields('Senha') == $this->Senha->CurrentValue);

			// Sexo
			$this->Sexo->setDbValueDef($rsnew, $this->Sexo->CurrentValue, NULL, $this->Sexo->ReadOnly || $this->Sexo->MultiUpdate != "1");

			// datanascimento
			$this->datanascimento->setDbValueDef($rsnew, UnFormatDateTime($this->datanascimento->CurrentValue, 7), NULL, $this->datanascimento->ReadOnly || $this->datanascimento->MultiUpdate != "1");

			// Funcao
			
			if ($Security->canAdmin()) { // System admin
				
				$this->Funcao->setDbValueDef($rsnew, $this->Funcao->CurrentValue, NULL, $this->Funcao->ReadOnly || $this->Funcao->MultiUpdate != "1");
				
			}
			

			// Sessao
			$this->Sessao->setDbValueDef($rsnew, $this->Sessao->CurrentValue, NULL, $this->Sessao->ReadOnly || $this->Sessao->MultiUpdate != "1");

			// Email
			$this->_Email->setDbValueDef($rsnew, $this->_Email->CurrentValue, NULL, $this->_Email->ReadOnly || $this->_Email->MultiUpdate != "1");

			// Ativado
			$this->Ativado->setDbValueDef($rsnew, $this->Ativado->CurrentValue, NULL, $this->Ativado->ReadOnly || $this->Ativado->MultiUpdate != "1");

			// datadecadastro
			$this->datadecadastro->CurrentValue = CurrentDateTime();
			$this->datadecadastro->setDbValueDef($rsnew, $this->datadecadastro->CurrentValue, NULL);

			// Idade
			$this->Idade->setDbValueDef($rsnew, $this->Idade->CurrentValue, NULL, $this->Idade->ReadOnly || $this->Idade->MultiUpdate != "1");

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
		if ($editRow) {
			if ($this->SendEmail)
				$this->sendEmailOnEdit($rsold, $rsnew);
		}
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

	// Show link optionally based on User ID
	protected function showOptionLink($id = "")
	{
		global $Security;
		if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id))
			return $Security->isValidUserID($this->idpessoa->CurrentValue);
		return TRUE;
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("pessoalist.php"), "", $this->TableVar, TRUE);
		$pageId = "update";
		$Breadcrumb->add("update", $pageId, $url);
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
							$row[2] = FormatNumber($row[2], 0, -2, -2, -2);
							$row['df2'] = $row[2];
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
} // End class
?>