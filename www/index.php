<?php
// Require composer autoloader
use App\Controllers\API;
use App\Controllers\View;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/db.pdo.php';
require __DIR__ . '/vendor/session.php';
require __DIR__ . '/app.php';


// Start the session
$session = new Session();
$session->init();
$db = new DBConnect();
$api = new API();


// Create Router instance
$router = new \Bramus\Router\Router();

$router->set404(function () {
    echo "<script>window.location.assign('/404.php');</script>";
});
$router->setNamespace('\App\Controllers');

$router->before('GET|POST', '/.*', function () use ($router) {
    global $session;
    $excludedRoutes = ['/biometrics', '/getProject', '/updateProject', '/deleteProject', '/addProject','/setAttendance'];
    $userRole = $session->get('user_data')['role'] ?? '';

    if (in_array($router->getCurrentUri(), $excludedRoutes)) {
        return;
    }
 
    if (!$session->get('authenticated')) {
        if ($router->getCurrentUri() != '/login') {
            header("location: /login");
        }
    } else {
        if (!$session->get('project') && $userRole != 'Superadmin') {
            if ($router->getCurrentUri() != '/projects') {
                header("location: /projects");
            }
        }
    }
});


$router->get('/biometrics', 'View@Biometrics');
$router->get('/login', 'View@Login');
$router->get('/logout', 'API@Logout');
$router->post('/login', 'API@Login');


$router->get('/projects', 'View@Projects');
$router->post('/getProject', 'API@getProject');
$router->post('/addProject', 'API@addProject');
$router->post('/updateProject', 'API@updateProject');
$router->post('/deleteProject', 'API@deleteProject');




$router->post('/setProject', 'API@setProject');
$router->get('/employees', 'View@Employees');
$router->get('/add-employee', 'View@add_employee');
$router->post('/deleteEmployee', 'API@deleteEmployee');
$router->get('/update-employee/{id}', 'View@update_employee');
$router->post('/addEmployee', 'API@addEmployee');
$router->post('/updateEmployee/{id}', 'API@updateEmployee');
$router->post('/loadEmployees', 'API@loadEmployees');


$router->post('/setAttendance', 'API@attendance');
$router->get('/attendance', 'View@attendance');
$router->post('/addAttendance', 'API@addAttendance');
$router->post('/updateAttendance', 'API@updateAttendance');
$router->post('/getAttendance', 'API@getAttendance');
$router->post('/deleteAttendance', 'API@deleteAttendance');



$router->get('/expenses/{action}', 'View@Expenses');
$router->post('/addExpenses', 'API@addExpenses');
$router->post('/loadExpenses', 'API@loadExpenses');
$router->post('/getExpenses', 'API@getExpenses');
$router->post('/updateExpenses', 'API@updateExpenses');
$router->post('/deleteExpenses', 'API@deleteExpenses');



$router->post('/loadCategories', 'API@loadCategories');
$router->post('/addCategory', 'API@addCategory');
$router->post('/getCategory', 'API@getCategory');
$router->post('/deleteCategory', 'API@deleteCategory');

$router->post('/updateCategory', 'API@updateCategory');


$router->post('/loadAttendance', 'API@loadAttendance');

$router->post('/loadInventory', 'API@loadInventory');
$router->post('/deleteInventory', 'API@deleteInventory');
$router->post('/addInventory', 'API@addInventory');
$router->post('/updateType', 'API@updateType');
$router->post('/addType', 'API@addType');
$router->post('/deleteType', 'API@deleteType');
$router->post('/updateInventory', 'API@updateInventory');
$router->post('/getInventory', 'API@getInventory');
$router->post('/print/inventory', 'API@printInventory');
$router->get('/types', 'View@InventoryTypes');
$router->get('/inventory', 'View@Inventory');

$router->get('/cash-advance', 'VIEW@CashAdvance');
$router->post('/getRate', 'API@getRate');
$router->post('/addCashAdvance', 'API@addCashAdvance');
$router->post('/deleteCashAdvance', 'API@deleteCashAdvance');
$router->post('/loadCashAdvance', 'API@loadCashAdvance');

$router->get('/fingerprint-registration/{employee_id}', 'VIEW@FingerprintRegistration');

$router->get('/', function () {
    global $session;
    if ($session->get('authenticated')) {
        header('Location: home');
    }
});

$router->post('/payroll', function () {
    include 'template/report.payroll.php';
});

$router->post('/payslip', function () {
    include 'template/report.payslip.php';
});

$router->get('/cash-advance', function () {
    echo "Maintendance";
    // header('Location: home');
});
$router->get('/report-expenses', 'View@ReportExpenses');
$router->post('/loadReportExpenses', 'API@loadReportExpenses');
$router->post('/print/expense', 'API@printExpense');
$router->post('/print/expenses', 'API@printExpenses');


$router->get('/report-payroll', 'View@Payroll');
$router->post('/loadPayroll', 'API@loadPayroll');

$router->get('/users', 'View@Users');
$router->post('/loadUsers', 'API@loadUsers');
$router->post('/addUser', 'API@addUser');
$router->post('/updateUser', 'API@updateUser');
$router->post('/updateUserPw', 'API@updateUserPw');
$router->post('/deleteUser', 'API@deleteUser');
$router->post('/getUser', 'API@getUser');
$router->post('/updateAccount', 'API@updateAccount');

$router->get('/manage-project-employees/{project_id}', 'VIEW@ProjectEmployees');
$router->get('/manage-projects', 'View@ManageProjects');
$router->post('/addProjectEmployee', 'API@addProjectEmployee');
$router->post('/deleteProjectEmployee', 'API@deleteProjectEmployee');


$router->get('/change-project', function () {
    global $session;
    $session->set('project', false);
    header('Location: projects');
});


$router->get('/home', 'View@Home');



$router->run();
