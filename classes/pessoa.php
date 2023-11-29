<?php namespace PHPMaker2020\sistema; ?>
<?php

/**
 * Table class for pessoa
 */
class pessoa extends DbTable
{
	protected $SqlFrom = "";
	protected $SqlSelect = "";
	protected $SqlSelectList = "";
	protected $SqlWhere = "";
	protected $SqlGroupBy = "";
	protected $SqlHaving = "";
	protected $SqlOrderBy = "";
	public $UseSessionForListSql = TRUE;

	// Column CSS classes
	public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
	public $RightColumnClass = "col-sm-10";
	public $OffsetColumnClass = "col-sm-10 offset-sm-2";
	public $TableLeftColumnClass = "w-col-2";

	// Export
	public $ExportDoc;

	// Fields
	public $idpessoa;
	public $idaula;
	public $Nome;
	public $CPF;
	public $Senha;
	public $Sexo;
	public $datanascimento;
	public $Funcao;
	public $Sessao;
	public $_Email;
	public $Ativado;
	public $datadecadastro;
	public $Idade;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;
		parent::__construct();

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'pessoa';
		$this->TableName = 'pessoa';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`pessoa`";
		$this->Dbid = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
		$this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = TRUE; // Allow detail add
		$this->DetailEdit = TRUE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = TRUE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->BasicSearch = new BasicSearch($this->TableVar);

		// idpessoa
		$this->idpessoa = new DbField('pessoa', 'pessoa', 'x_idpessoa', 'idpessoa', '`idpessoa`', '`idpessoa`', 3, 11, -1, FALSE, '`idpessoa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->idpessoa->IsAutoIncrement = TRUE; // Autoincrement field
		$this->idpessoa->IsPrimaryKey = TRUE; // Primary key field
		$this->idpessoa->IsForeignKey = TRUE; // Foreign key field
		$this->idpessoa->Sortable = TRUE; // Allow sort
		$this->idpessoa->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idpessoa'] = &$this->idpessoa;

		// idaula
		$this->idaula = new DbField('pessoa', 'pessoa', 'x_idaula', 'idaula', '`idaula`', '`idaula`', 3, 11, -1, FALSE, '`idaula`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idaula->IsForeignKey = TRUE; // Foreign key field
		$this->idaula->Sortable = TRUE; // Allow sort
		$this->idaula->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->idaula->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->idaula->Lookup = new Lookup('idaula', 'view1', FALSE, 'idaulas', ["nome","turmas","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->idaula->Lookup = new Lookup('idaula', 'view1', FALSE, 'idaulas', ["nome","turmas","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->idaula->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['idaula'] = &$this->idaula;

		// Nome
		$this->Nome = new DbField('pessoa', 'pessoa', 'x_Nome', 'Nome', '`Nome`', '`Nome`', 200, 45, -1, FALSE, '`Nome`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Nome->Required = TRUE; // Required field
		$this->Nome->Sortable = TRUE; // Allow sort
		$this->fields['Nome'] = &$this->Nome;

		// CPF
		$this->CPF = new DbField('pessoa', 'pessoa', 'x_CPF', 'CPF', '`CPF`', '`CPF`', 200, 15, -1, FALSE, '`CPF`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->CPF->Nullable = FALSE; // NOT NULL field
		$this->CPF->Required = TRUE; // Required field
		$this->CPF->Sortable = TRUE; // Allow sort
		$this->fields['CPF'] = &$this->CPF;

		// Senha
		$this->Senha = new DbField('pessoa', 'pessoa', 'x_Senha', 'Senha', '`Senha`', '`Senha`', 200, 45, -1, FALSE, '`Senha`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'PASSWORD');
		$this->Senha->Nullable = FALSE; // NOT NULL field
		$this->Senha->Required = TRUE; // Required field
		$this->Senha->Sortable = TRUE; // Allow sort
		$this->fields['Senha'] = &$this->Senha;

		// Sexo
		$this->Sexo = new DbField('pessoa', 'pessoa', 'x_Sexo', 'Sexo', '`Sexo`', '`Sexo`', 3, 11, -1, FALSE, '`Sexo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Sexo->Sortable = TRUE; // Allow sort
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->Sexo->Lookup = new Lookup('Sexo', 'pessoa', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->Sexo->Lookup = new Lookup('Sexo', 'pessoa', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->Sexo->OptionCount = 3;
		$this->Sexo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Sexo'] = &$this->Sexo;

		// datanascimento
		$this->datanascimento = new DbField('pessoa', 'pessoa', 'x_datanascimento', 'datanascimento', '`datanascimento`', CastDateFieldForLike("`datanascimento`", 7, "DB"), 133, 10, 7, FALSE, '`datanascimento`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->datanascimento->Sortable = TRUE; // Allow sort
		$this->datanascimento->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_SEPARATOR"], $Language->phrase("IncorrectDateDMY"));
		$this->fields['datanascimento'] = &$this->datanascimento;

		// Funcao
		$this->Funcao = new DbField('pessoa', 'pessoa', 'x_Funcao', 'Funcao', '`Funcao`', '`Funcao`', 3, 11, -1, FALSE, '`Funcao`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Funcao->Sortable = TRUE; // Allow sort
		$this->Funcao->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Funcao->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->Funcao->Lookup = new Lookup('Funcao', 'userlevels', FALSE, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->Funcao->Lookup = new Lookup('Funcao', 'userlevels', FALSE, 'userlevelid', ["userlevelname","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->Funcao->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Funcao'] = &$this->Funcao;

		// Sessao
		$this->Sessao = new DbField('pessoa', 'pessoa', 'x_Sessao', 'Sessao', '`Sessao`', '`Sessao`', 201, 65535, -1, FALSE, '`Sessao`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Sessao->Sortable = TRUE; // Allow sort
		$this->fields['Sessao'] = &$this->Sessao;

		// Email
		$this->_Email = new DbField('pessoa', 'pessoa', 'x__Email', 'Email', '`Email`', '`Email`', 200, 45, -1, FALSE, '`Email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_Email->Sortable = TRUE; // Allow sort
		$this->_Email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
		$this->fields['Email'] = &$this->_Email;

		// Ativado
		$this->Ativado = new DbField('pessoa', 'pessoa', 'x_Ativado', 'Ativado', '`Ativado`', '`Ativado`', 3, 11, -1, FALSE, '`Ativado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Ativado->Sortable = TRUE; // Allow sort
		switch ($CurrentLanguage) {
			case "pt-BR":
				$this->Ativado->Lookup = new Lookup('Ativado', 'pessoa', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->Ativado->Lookup = new Lookup('Ativado', 'pessoa', FALSE, '', ["","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->Ativado->OptionCount = 2;
		$this->Ativado->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Ativado'] = &$this->Ativado;

		// datadecadastro
		$this->datadecadastro = new DbField('pessoa', 'pessoa', 'x_datadecadastro', 'datadecadastro', '`datadecadastro`', CastDateFieldForLike("`datadecadastro`", 0, "DB"), 133, 10, 0, FALSE, '`datadecadastro`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->datadecadastro->Sortable = TRUE; // Allow sort
		$this->datadecadastro->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
		$this->fields['datadecadastro'] = &$this->datadecadastro;

		// Idade
		$this->Idade = new DbField('pessoa', 'pessoa', 'x_Idade', 'Idade', 'YEAR(CURDATE()) - YEAR(datanascimento)', 'YEAR(CURDATE()) - YEAR(datanascimento)', 21, 5, -1, FALSE, 'YEAR(CURDATE()) - YEAR(datanascimento)', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Idade->IsCustom = TRUE; // Custom field
		$this->Idade->Sortable = TRUE; // Allow sort
		$this->Idade->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->fields['Idade'] = &$this->Idade;
	}

	// Field Visibility
	public function getFieldVisibility($fldParm)
	{
		global $Security;
		return $this->$fldParm->Visible; // Returns original value
	}

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function setLeftColumnClass($class)
	{
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " col-form-label ew-label";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
			$this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
		}
	}

	// Multiple column sort
	public function updateSort(&$fld, $ctrl)
	{
		if ($this->CurrentOrder == $fld->Name) {
			$sortField = $fld->Expression;
			$lastSort = $fld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$thisSort = $this->CurrentOrderType;
			} else {
				$thisSort = ($lastSort == "ASC") ? "DESC" : "ASC";
			}
			$fld->setSort($thisSort);
			if ($ctrl) {
				$orderBy = $this->getSessionOrderBy();
				if (ContainsString($orderBy, $sortField . " " . $lastSort)) {
					$orderBy = str_replace($sortField . " " . $lastSort, $sortField . " " . $thisSort, $orderBy);
				} else {
					if ($orderBy != "")
						$orderBy .= ", ";
					$orderBy .= $sortField . " " . $thisSort;
				}
				$this->setSessionOrderBy($orderBy); // Save to Session
			} else {
				$this->setSessionOrderBy($sortField . " " . $thisSort); // Save to Session
			}
		} else {
			if (!$ctrl)
				$fld->setSort("");
		}
	}

	// Current master table name
	public function getCurrentMasterTable()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")];
	}
	public function setCurrentMasterTable($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
	}

	// Session master WHERE clause
	public function getMasterFilter()
	{

		// Master filter
		$masterFilter = "";
		if ($this->getCurrentMasterTable() == "aulas") {
			if ($this->idaula->getSessionValue() != "")
				$masterFilter .= "`idaulas`=" . QuotedValue($this->idaula->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $masterFilter;
	}

	// Session detail WHERE clause
	public function getDetailFilter()
	{

		// Detail filter
		$detailFilter = "";
		if ($this->getCurrentMasterTable() == "aulas") {
			if ($this->idaula->getSessionValue() != "")
				$detailFilter .= "`idaula`=" . QuotedValue($this->idaula->getSessionValue(), DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $detailFilter;
	}

	// Master filter
	public function sqlMasterFilter_aulas()
	{
		return "`idaulas`=@idaulas@";
	}

	// Detail filter
	public function sqlDetailFilter_aulas()
	{
		return "`idaula`=@idaula@";
	}

	// Current detail table name
	public function getCurrentDetailTable()
	{
		return @$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")];
	}
	public function setCurrentDetailTable($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
	}

	// Get detail url
	public function getDetailUrl()
	{

		// Detail url
		$detailUrl = "";
		if ($this->getCurrentDetailTable() == "endereco") {
			$detailUrl = $GLOBALS["endereco"]->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
			$detailUrl .= "&fk_idpessoa=" . urlencode($this->idpessoa->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "documentos") {
			$detailUrl = $GLOBALS["documentos"]->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
			$detailUrl .= "&fk_idpessoa=" . urlencode($this->idpessoa->CurrentValue);
		}
		if ($detailUrl == "")
			$detailUrl = "pessoalist.php";
		return $detailUrl;
	}

	// Table level SQL
	public function getSqlFrom() // From
	{
		return ($this->SqlFrom != "") ? $this->SqlFrom : "`pessoa`";
	}
	public function sqlFrom() // For backward compatibility
	{
		return $this->getSqlFrom();
	}
	public function setSqlFrom($v)
	{
		$this->SqlFrom = $v;
	}
	public function getSqlSelect() // Select
	{
		return ($this->SqlSelect != "") ? $this->SqlSelect : "SELECT *, YEAR(CURDATE()) - YEAR(datanascimento) AS `Idade` FROM " . $this->getSqlFrom();
	}
	public function sqlSelect() // For backward compatibility
	{
		return $this->getSqlSelect();
	}
	public function setSqlSelect($v)
	{
		$this->SqlSelect = $v;
	}
	public function getSqlWhere() // Where
	{
		$where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
		$this->TableFilter = "";
		AddFilter($where, $this->TableFilter);
		return $where;
	}
	public function sqlWhere() // For backward compatibility
	{
		return $this->getSqlWhere();
	}
	public function setSqlWhere($v)
	{
		$this->SqlWhere = $v;
	}
	public function getSqlGroupBy() // Group By
	{
		return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
	}
	public function sqlGroupBy() // For backward compatibility
	{
		return $this->getSqlGroupBy();
	}
	public function setSqlGroupBy($v)
	{
		$this->SqlGroupBy = $v;
	}
	public function getSqlHaving() // Having
	{
		return ($this->SqlHaving != "") ? $this->SqlHaving : "";
	}
	public function sqlHaving() // For backward compatibility
	{
		return $this->getSqlHaving();
	}
	public function setSqlHaving($v)
	{
		$this->SqlHaving = $v;
	}
	public function getSqlOrderBy() // Order By
	{
		return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
	}
	public function sqlOrderBy() // For backward compatibility
	{
		return $this->getSqlOrderBy();
	}
	public function setSqlOrderBy($v)
	{
		$this->SqlOrderBy = $v;
	}

	// Apply User ID filters
	public function applyUserIDFilters($filter, $id = "")
	{
		global $Security;

		// Add User ID filter
		if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
			$filter = $this->addUserIDFilter($filter, $id);
		}
		return $filter;
	}

	// Check if User ID security allows view all
	public function userIDAllow($id = "")
	{
		$allow = $this->UserIDAllowSecurity;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			case "lookup":
				return (($allow & 256) == 256);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get recordset
	public function getRecordset($sql, $rowcnt = -1, $offset = -1)
	{
		$conn = $this->getConnection();
		$conn->raiseErrorFn = Config("ERROR_FUNC");
		$rs = $conn->selectLimit($sql, $rowcnt, $offset);
		$conn->raiseErrorFn = "";
		return $rs;
	}

	// Get record count
	public function getRecordCount($sql, $c = NULL)
	{
		$cnt = -1;
		$rs = NULL;
		$sql = preg_replace('/\/\*BeginOrderBy\*\/[\s\S]+\/\*EndOrderBy\*\//', "", $sql); // Remove ORDER BY clause (MSSQL)
		$pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';

		// Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
			preg_match($pattern, $sql) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sql) &&
			!preg_match('/^\s*select\s+distinct\s+/i', $sql) && !preg_match('/\s+order\s+by\s+/i', $sql)) {
			$sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sql);
		} else {
			$sqlwrk = "SELECT COUNT(*) FROM (" . $sql . ") COUNT_TABLE";
		}
		$conn = $c ?: $this->getConnection();
		if ($rs = $conn->execute($sqlwrk)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->close();
			}
			return (int)$cnt;
		}

		// Unable to get count, get record count directly
		if ($rs = $conn->execute($sql)) {
			$cnt = $rs->RecordCount();
			$rs->close();
			return (int)$cnt;
		}
		return $cnt;
	}

	// Get SQL
	public function getSql($where, $orderBy = "")
	{
		return BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderBy);
	}

	// Table SQL
	public function getCurrentSql()
	{
		$filter = $this->CurrentFilter;
		$filter = $this->applyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->getSql($filter, $sort);
	}

	// Table SQL with List page filter
	public function getListSql()
	{
		$filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->getSqlSelect();
		$sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
		return BuildSelectSql($select, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $filter, $sort);
	}

	// Get ORDER BY clause
	public function getOrderBy()
	{
		$sort = $this->getSessionOrderBy();
		return BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sort);
	}

	// Get record count based on filter (for detail record count in master table pages)
	public function loadRecordCount($filter)
	{
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->getRecordCount($sql);
		$this->CurrentFilter = $origFilter;
		return $cnt;
	}

	// Get record count (for current List page)
	public function listRecordCount()
	{
		$filter = $this->getSessionWhere();
		AddFilter($filter, $this->CurrentFilter);
		$filter = $this->applyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->getRecordCount($sql);
		return $cnt;
	}

	// INSERT statement
	protected function insertSql(&$rs)
	{
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom)
				continue;
			if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME"))
				$value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
			$names .= $this->fields[$name]->Expression . ",";
			$values .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " (" . $names . ") VALUES (" . $values . ")";
	}

	// Insert
	public function insert(&$rs)
	{
		$conn = $this->getConnection();
		$success = $conn->execute($this->insertSql($rs));
		if ($success) {

			// Get insert id if necessary
			$this->idpessoa->setDbValue($conn->insert_ID());
			$rs['idpessoa'] = $this->idpessoa->DbValue;
		}
		return $success;
	}

	// UPDATE statement
	protected function updateSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->IsCustom || $this->fields[$name]->IsAutoIncrement)
				continue;
			if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
				if ($value == $this->fields[$name]->OldValue) // No need to update hashed password if not changed
					continue;
				$value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
			}
			$sql .= $this->fields[$name]->Expression . "=";
			$sql .= QuotedValue($value, $this->fields[$name]->DataType, $this->Dbid) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		AddFilter($filter, $where);
		if ($filter != "")
			$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	public function update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE)
	{
		$conn = $this->getConnection();
		$success = $conn->execute($this->updateSql($rs, $where, $curfilter));
		return $success;
	}

	// DELETE statement
	protected function deleteSql(&$rs, $where = "", $curfilter = TRUE)
	{
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->arrayToFilter($where);
		if ($rs) {
			if (array_key_exists('idpessoa', $rs))
				AddFilter($where, QuotedName('idpessoa', $this->Dbid) . '=' . QuotedValue($rs['idpessoa'], $this->idpessoa->DataType, $this->Dbid));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		AddFilter($filter, $where);
		if ($filter != "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	public function delete(&$rs, $where = "", $curfilter = FALSE)
	{
		$success = TRUE;
		$conn = $this->getConnection();
		if ($success)
			$success = $conn->execute($this->deleteSql($rs, $where, $curfilter));
		return $success;
	}

	// Load DbValue from recordset or array
	protected function loadDbValues(&$rs)
	{
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idpessoa->DbValue = $row['idpessoa'];
		$this->idaula->DbValue = $row['idaula'];
		$this->Nome->DbValue = $row['Nome'];
		$this->CPF->DbValue = $row['CPF'];
		$this->Senha->DbValue = $row['Senha'];
		$this->Sexo->DbValue = $row['Sexo'];
		$this->datanascimento->DbValue = $row['datanascimento'];
		$this->Funcao->DbValue = $row['Funcao'];
		$this->Sessao->DbValue = $row['Sessao'];
		$this->_Email->DbValue = $row['Email'];
		$this->Ativado->DbValue = $row['Ativado'];
		$this->datadecadastro->DbValue = $row['datadecadastro'];
		$this->Idade->DbValue = $row['Idade'];
	}

	// Delete uploaded files
	public function deleteUploadedFiles($row)
	{
		$this->loadDbValues($row);
	}

	// Record filter WHERE clause
	protected function sqlKeyFilter()
	{
		return "`idpessoa` = @idpessoa@";
	}

	// Get record filter
	public function getRecordFilter($row = NULL)
	{
		$keyFilter = $this->sqlKeyFilter();
		if (is_array($row))
			$val = array_key_exists('idpessoa', $row) ? $row['idpessoa'] : NULL;
		else
			$val = $this->idpessoa->OldValue !== NULL ? $this->idpessoa->OldValue : $this->idpessoa->CurrentValue;
		if (!is_numeric($val))
			return "0=1"; // Invalid key
		if ($val == NULL)
			return "0=1"; // Invalid key
		else
			$keyFilter = str_replace("@idpessoa@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
		return $keyFilter;
	}

	// Return page URL
	public function getReturnUrl()
	{
		$name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");

		// Get referer URL automatically
		if (ServerVar("HTTP_REFERER") != "" && ReferPageName() != CurrentPageName() && ReferPageName() != "login.php") // Referer not same page or login page
			$_SESSION[$name] = ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] != "") {
			return $_SESSION[$name];
		} else {
			return "pessoalist.php";
		}
	}
	public function setReturnUrl($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
	}

	// Get modal caption
	public function getModalCaption($pageName)
	{
		global $Language;
		if ($pageName == "pessoaview.php")
			return $Language->phrase("View");
		elseif ($pageName == "pessoaedit.php")
			return $Language->phrase("Edit");
		elseif ($pageName == "pessoaadd.php")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "pessoalist.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("pessoaview.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("pessoaview.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm != "")
			$url = "pessoaadd.php?" . $this->getUrlParm($parm);
		else
			$url = "pessoaadd.php";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("pessoaedit.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("pessoaedit.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Inline edit URL
	public function getInlineEditUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
		return $this->addMasterUrl($url);
	}

	// Copy URL
	public function getCopyUrl($parm = "")
	{
		if ($parm != "")
			$url = $this->keyUrl("pessoaadd.php", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("pessoaadd.php", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
		return $this->addMasterUrl($url);
	}

	// Inline copy URL
	public function getInlineCopyUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
		return $this->addMasterUrl($url);
	}

	// Delete URL
	public function getDeleteUrl()
	{
		return $this->keyUrl("pessoadelete.php", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		if ($this->getCurrentMasterTable() == "aulas" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
			$url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_idaulas=" . urlencode($this->idaula->CurrentValue);
		}
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "idpessoa:" . JsonEncode($this->idpessoa->CurrentValue, "number");
		$json = "{" . $json . "}";
		if ($htmlEncode)
			$json = HtmlEncode($json);
		return $json;
	}

	// Add key value to URL
	public function keyUrl($url, $parm = "")
	{
		$url = $url . "?";
		if ($parm != "")
			$url .= $parm . "&";
		if ($this->idpessoa->CurrentValue != NULL) {
			$url .= "idpessoa=" . urlencode($this->idpessoa->CurrentValue);
		} else {
			return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
		}
		return $url;
	}

	// Sort URL
	public function sortUrl(&$fld)
	{
		if ($this->CurrentAction || $this->isExport() ||
			in_array($fld->Type, [128, 204, 205])) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->reverseSort());
			return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
		} else {
			return "";
		}
	}

	// Get record keys from Post/Get/Session
	public function getRecordKeys()
	{
		$arKeys = [];
		$arKey = [];
		if (Param("key_m") !== NULL) {
			$arKeys = Param("key_m");
			$cnt = count($arKeys);
		} else {
			if (Param("idpessoa") !== NULL)
				$arKeys[] = Param("idpessoa");
			elseif (IsApi() && Key(0) !== NULL)
				$arKeys[] = Key(0);
			elseif (IsApi() && Route(2) !== NULL)
				$arKeys[] = Route(2);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = [];
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get filter from record keys
	public function getFilterFromRecordKeys($setCurrent = TRUE)
	{
		$arKeys = $this->getRecordKeys();
		$keyFilter = "";
		foreach ($arKeys as $key) {
			if ($keyFilter != "") $keyFilter .= " OR ";
			if ($setCurrent)
				$this->idpessoa->CurrentValue = $key;
			else
				$this->idpessoa->OldValue = $key;
			$keyFilter .= "(" . $this->getRecordFilter() . ")";
		}
		return $keyFilter;
	}

	// Load rows based on filter
	public function &loadRs($filter)
	{

		// Set up filter (WHERE Clause)
		$sql = $this->getSql($filter);
		$conn = $this->getConnection();
		$rs = $conn->execute($sql);
		return $rs;
	}

	// Load row values from recordset
	public function loadListRowValues(&$rs)
	{
		$this->idpessoa->setDbValue($rs->fields('idpessoa'));
		$this->idaula->setDbValue($rs->fields('idaula'));
		$this->Nome->setDbValue($rs->fields('Nome'));
		$this->CPF->setDbValue($rs->fields('CPF'));
		$this->Senha->setDbValue($rs->fields('Senha'));
		$this->Sexo->setDbValue($rs->fields('Sexo'));
		$this->datanascimento->setDbValue($rs->fields('datanascimento'));
		$this->Funcao->setDbValue($rs->fields('Funcao'));
		$this->Sessao->setDbValue($rs->fields('Sessao'));
		$this->_Email->setDbValue($rs->fields('Email'));
		$this->Ativado->setDbValue($rs->fields('Ativado'));
		$this->datadecadastro->setDbValue($rs->fields('datadecadastro'));
		$this->Idade->setDbValue($rs->fields('Idade'));
	}

	// Render list row values
	public function renderListRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Common render codes
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

		// idpessoa
		$this->idpessoa->LinkCustomAttributes = "";
		$this->idpessoa->HrefValue = "";
		$this->idpessoa->TooltipValue = "";

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

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->customTemplateFieldValues();
	}

	// Render edit row values
	public function renderEditRow()
	{
		global $Security, $CurrentLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idpessoa
		$this->idpessoa->EditAttrs["class"] = "form-control";
		$this->idpessoa->EditCustomAttributes = "";
		$this->idpessoa->EditValue = $this->idpessoa->CurrentValue;
		$this->idpessoa->ViewCustomAttributes = "";

		// idaula
		$this->idaula->EditAttrs["class"] = "form-control";
		$this->idaula->EditCustomAttributes = "";
		if ($this->idaula->getSessionValue() != "") {
			$this->idaula->CurrentValue = $this->idaula->getSessionValue();
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
		}

		// Nome
		$this->Nome->EditAttrs["class"] = "form-control";
		$this->Nome->EditCustomAttributes = "";
		if (!$this->Nome->Raw)
			$this->Nome->CurrentValue = HtmlDecode($this->Nome->CurrentValue);
		$this->Nome->EditValue = $this->Nome->CurrentValue;
		$this->Nome->PlaceHolder = RemoveHtml($this->Nome->caption());

		// CPF
		$this->CPF->EditAttrs["class"] = "form-control";
		$this->CPF->EditCustomAttributes = "";
		if (!$this->CPF->Raw)
			$this->CPF->CurrentValue = HtmlDecode($this->CPF->CurrentValue);
		$this->CPF->EditValue = $this->CPF->CurrentValue;
		$this->CPF->PlaceHolder = RemoveHtml($this->CPF->caption());

		// Senha
		$this->Senha->EditAttrs["class"] = "form-control ew-password-strength";
		$this->Senha->EditCustomAttributes = "";
		$this->Senha->EditValue = $this->Senha->CurrentValue;
		$this->Senha->PlaceHolder = RemoveHtml($this->Senha->caption());

		// Sexo
		$this->Sexo->EditCustomAttributes = "";
		$this->Sexo->EditValue = $this->Sexo->options(FALSE);

		// datanascimento
		$this->datanascimento->EditAttrs["class"] = "form-control";
		$this->datanascimento->EditCustomAttributes = "";
		$this->datanascimento->EditValue = FormatDateTime($this->datanascimento->CurrentValue, 7);
		$this->datanascimento->PlaceHolder = RemoveHtml($this->datanascimento->caption());

		// Funcao
		$this->Funcao->EditAttrs["class"] = "form-control";
		$this->Funcao->EditCustomAttributes = "";
		if (!$Security->canAdmin()) { // System admin
			$this->Funcao->EditValue = $Language->phrase("PasswordMask");
		} else {
		}

		// Sessao
		$this->Sessao->EditAttrs["class"] = "form-control";
		$this->Sessao->EditCustomAttributes = "";
		$this->Sessao->EditValue = $this->Sessao->CurrentValue;
		$this->Sessao->PlaceHolder = RemoveHtml($this->Sessao->caption());

		// Email
		$this->_Email->EditAttrs["class"] = "form-control";
		$this->_Email->EditCustomAttributes = "";
		if (!$this->_Email->Raw)
			$this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
		$this->_Email->EditValue = $this->_Email->CurrentValue;
		$this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

		// Ativado
		$this->Ativado->EditCustomAttributes = "";
		$this->Ativado->EditValue = $this->Ativado->options(FALSE);

		// datadecadastro
		// Idade

		$this->Idade->EditAttrs["class"] = "form-control";
		$this->Idade->EditCustomAttributes = "";
		$this->Idade->EditValue = $this->Idade->CurrentValue;
		$this->Idade->PlaceHolder = RemoveHtml($this->Idade->caption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	public function aggregateListRowValues()
	{
	}

	// Aggregate list row (for rendering)
	public function aggregateListRow()
	{

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
	{
		if (!$recordset || !$doc)
			return;
		if (!$doc->ExportCustom) {

			// Write header
			$doc->exportTableHeader();
			if ($doc->Horizontal) { // Horizontal format, write header
				$doc->beginExportRow();
				if ($exportPageType == "view") {
					$doc->exportCaption($this->idpessoa);
					$doc->exportCaption($this->idaula);
					$doc->exportCaption($this->Nome);
					$doc->exportCaption($this->CPF);
					$doc->exportCaption($this->Senha);
					$doc->exportCaption($this->Sexo);
					$doc->exportCaption($this->datanascimento);
					$doc->exportCaption($this->Funcao);
					$doc->exportCaption($this->Sessao);
					$doc->exportCaption($this->_Email);
					$doc->exportCaption($this->Ativado);
					$doc->exportCaption($this->datadecadastro);
					$doc->exportCaption($this->Idade);
				} else {
					$doc->exportCaption($this->idpessoa);
					$doc->exportCaption($this->idaula);
					$doc->exportCaption($this->Nome);
					$doc->exportCaption($this->CPF);
					$doc->exportCaption($this->Senha);
					$doc->exportCaption($this->Sexo);
					$doc->exportCaption($this->datanascimento);
					$doc->exportCaption($this->Funcao);
					$doc->exportCaption($this->_Email);
					$doc->exportCaption($this->Ativado);
					$doc->exportCaption($this->datadecadastro);
					$doc->exportCaption($this->Idade);
				}
				$doc->endExportRow();
			}
		}

		// Move to first record
		$recCnt = $startRec - 1;
		if (!$recordset->EOF) {
			$recordset->moveFirst();
			if ($startRec > 1)
				$recordset->move($startRec - 1);
		}
		while (!$recordset->EOF && $recCnt < $stopRec) {
			$recCnt++;
			if ($recCnt >= $startRec) {
				$rowCnt = $recCnt - $startRec + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0)
						$doc->exportPageBreak();
				}
				$this->loadListRowValues($recordset);

				// Render row
				$this->RowType = ROWTYPE_VIEW; // Render view
				$this->resetAttributes();
				$this->renderListRow();
				if (!$doc->ExportCustom) {
					$doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
					if ($exportPageType == "view") {
						$doc->exportField($this->idpessoa);
						$doc->exportField($this->idaula);
						$doc->exportField($this->Nome);
						$doc->exportField($this->CPF);
						$doc->exportField($this->Senha);
						$doc->exportField($this->Sexo);
						$doc->exportField($this->datanascimento);
						$doc->exportField($this->Funcao);
						$doc->exportField($this->Sessao);
						$doc->exportField($this->_Email);
						$doc->exportField($this->Ativado);
						$doc->exportField($this->datadecadastro);
						$doc->exportField($this->Idade);
					} else {
						$doc->exportField($this->idpessoa);
						$doc->exportField($this->idaula);
						$doc->exportField($this->Nome);
						$doc->exportField($this->CPF);
						$doc->exportField($this->Senha);
						$doc->exportField($this->Sexo);
						$doc->exportField($this->datanascimento);
						$doc->exportField($this->Funcao);
						$doc->exportField($this->_Email);
						$doc->exportField($this->Ativado);
						$doc->exportField($this->datadecadastro);
						$doc->exportField($this->Idade);
					}
					$doc->endExportRow($rowCnt);
				}
			}

			// Call Row Export server event
			if ($doc->ExportCustom)
				$this->Row_Export($recordset->fields);
			$recordset->moveNext();
		}
		if (!$doc->ExportCustom) {
			$doc->exportTableFooter();
		}
	}

	// User ID filter
	public function getUserIDFilter($userId)
	{
		$userIdFilter = '`idpessoa` = ' . QuotedValue($userId, DATATYPE_NUMBER, Config("USER_TABLE_DBID"));
		return $userIdFilter;
	}

	// Add User ID filter
	public function addUserIDFilter($filter = "", $id = "")
	{
		global $Security;
		$filterWrk = "";
		if ($id == "")
			$id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
		if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
			$filterWrk = $Security->userIdList();
			if ($filterWrk != "")
				$filterWrk = '`idpessoa` IN (' . $filterWrk . ')';
		}

		// Call User ID Filtering event
		$this->UserID_Filtering($filterWrk);
		AddFilter($filter, $filterWrk);
		return $filter;
	}

	// User ID subquery
	public function getUserIDSubquery(&$fld, &$masterfld)
	{
		global $UserTable;
		$wrk = "";
		$sql = "SELECT " . $masterfld->Expression . " FROM `pessoa`";
		$filter = $this->addUserIDFilter("");
		if ($filter != "")
			$sql .= " WHERE " . $filter;

		// Use subquery
		if (Config("USE_SUBQUERY_FOR_MASTER_USER_ID")) {
			$wrk = $sql;
		} else {

			// List all values
			if ($rs = Conn($UserTable->Dbid)->execute($sql)) {
				while (!$rs->EOF) {
					if ($wrk != "")
						$wrk .= ",";
					$wrk .= QuotedValue($rs->fields[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
					$rs->moveNext();
				}
				$rs->close();
			}
		}
		if ($wrk != "")
			$wrk = $fld->Expression . " IN (" . $wrk . ")";
		else
			$wrk = "0=1"; // No User ID value found
		return $wrk;
	}

	// Add master User ID filter
	public function addMasterUserIDFilter($filter, $currentMasterTable)
	{
		$filterWrk = $filter;
		if ($currentMasterTable == "aulas") {
			$filterWrk = $GLOBALS["aulas"]->addUserIDFilter($filterWrk);
		}
		return $filterWrk;
	}

	// Add detail User ID filter
	public function addDetailUserIDFilter($filter, $currentMasterTable)
	{
		$filterWrk = $filter;
		if ($currentMasterTable == "aulas") {
			$mastertable = $GLOBALS["aulas"];
			if (!$mastertable->userIDAllow()) {
				$subqueryWrk = $mastertable->getUserIDSubquery($this->idaula, $mastertable->idaulas);
				AddFilter($filterWrk, $subqueryWrk);
			}
		}
		return $filterWrk;
	}

	// Get file data
	public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0)
	{

		// No binary fields
		return FALSE;
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending($email, &$args) {

		//var_dump($email); var_dump($args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>