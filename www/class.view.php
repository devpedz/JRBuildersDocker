<?php

namespace App\Controllers;

class View
{
    function Login()
    {
        global $db;
        global $session;
        if ($session->get('authenticated')) {
            header('Location: /');
        }
        header("Cache-Control: no-cache, must-revalidate");
        include 'view/login.php';
    }
    function Projects()
    {
        global $session;
        if ($session->get('project')) {
            header('Location: /');
        }
        include 'view/projects.php';
    }
    function ManageProjects()
    {
        include 'view/manage-projects.php';
    }
    function ProjectEmployees($id)
    {
        include 'view/project_employees.php';
    }
    function add_employee()
    {
        include 'view/employee-add.php';
    }
    function update_employee($employee_id)
    {
        include 'view/employee-update.php';
    }
    function attendance()
    {
        include 'view/attendance.php';
    }
    function FingerprintRegistration($employee_id)
    {
        include 'view/fingerprint-registration.php';
    }
    function Biometrics()
    {
        include 'view/biometrics.php';
    }
    function Home()
    {
        include 'view/home.php';
    }
    function Inventory()
    {
        include 'view/inventory.php';
    }
    function InventoryTypes()
    {
        include 'view/inventory-types.php';
    }
    function Employees()
    {
        include 'view/employees.php';
    }
    function Expenses($action)
    {
        switch ($action) {
            case 'category':
                include 'view/expenses-category.php';
                break;
            case 'list':
                include 'view/expenses-list.php';
                break;
        }
    }
    function CashAdvance()
    {
        include 'view/cash_advance.php';
    }
    function ReportExpenses()
    {
        include 'view/report_expenses.php';
    }

    function Payroll()
    {
        include 'view/payroll.php';
    }

    function Users()
    {
        include 'view/users.php';
    }
}
