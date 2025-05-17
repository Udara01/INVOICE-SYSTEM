<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//$route['login'] = 'welcome/login';

$route['login'] = 'Authentication/login';
$route['signup'] = 'Authentication/signUp';
$route['dbcheck'] = 'DBcheck/index';

$route['app/home'] = 'Home/Landing';

$route['login/submit'] = 'Authentication/CreateAccount';
$route['user/login'] = 'Authentication/UserLogin';

$route['logout'] = 'Authentication/logout';

$route['additem'] = 'Items/index';
$route['item/addItem'] = 'Items/addItem';


$route['item'] = 'Items/ItemList';
$route['updateItem'] = 'Items/UpdateList';
$route['item/updateItem'] = 'Items/UpdateItem';


$route['deleteItem'] = 'Items/showDeleteItemForm';
$route['item/deleteItem'] = 'Items/deleteItem';

$route['invoice'] = 'Invoice/index';
$route['invoice/create'] = 'Invoice/Create_Invoice';

$route['invoice/print/(:num)'] = 'Invoice/print/$1';

$route['land'] = 'Home/index';

$route['invoice/view/(:num)'] = 'invoice/view/$1';
$route['invoice/update/(:num)'] = 'invoice/update/$1';
$route['invoice/delete/(:num)'] = 'invoice/delete/$1';



$route['invoiceform'] = 'Customer_Invoice/index';
$route['submit_invoice'] = 'Customer_Invoice/create_invoice';

$route['customer'] = 'Customer_controller/index';
$route['add-customer'] = 'Customer_controller/add_customer';
$route['customerlist'] = 'Customer_controller/Customer_list';

$route['invoicelist'] = 'Customer_invoice/invoice_list';
$route['Customer_invoice/edit_invoice/(:num)'] = 'Customer_invoice/edit_invoice/$1';



$route['categoryadd'] = 'Category_controller/add_category_form';
$route['categoryadd'] = 'Category_controller/get_categories';



$route['additem'] = 'Items/show_categories';


$route['invoice/return'] = 'ReturnInvoice_controller/index';

// config/routes.php
$route['returnInvoices/list'] = 'ReturnInvoice_controller/index';

$route['dashboard'] = 'Dashboard_controller/index';

$route['dashboard/return'] = 'Dashboard_controller/showReturnInvoice';

