<?php namespace Config;

/**
 * --------------------------------------------------------------------
 * URI Routing
 * --------------------------------------------------------------------
 * This file lets you re-map URI requests to specific controller functions.
 *
 * Typically there is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URL normally follow this pattern:
 *
 *    example.com/class/method/id
 *
 * In some instances, however, you may want to remap this relationship
 * so that a different class/function is called than the one
 * corresponding to the URL.
 */

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 * The RouteCollection object allows you to modify the way that the
 * Router works, by acting as a holder for it's configuration settings.
 * The following methods can be called on the object to modify
 * the default operations.
 *
 *    $routes->defaultNamespace()
 *
 * Modifies the namespace that is added to a controller if it doesn't
 * already have one. By default this is the global namespace (\).
 *
 *    $routes->defaultController()
 *
 * Changes the name of the class used as a controller when the route
 * points to a folder instead of a class.
 *
 *    $routes->defaultMethod()
 *
 * Assigns the method inside the controller that is ran when the
 * Router is unable to determine the appropriate method to run.
 *
 *    $routes->setAutoRoute()
 *
 * Determines whether the Router will attempt to match URIs to
 * Controllers when no specific route has been defined. If false,
 * only routes that have been defined here will be available.
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/mens', 'Home::index');
$routes->get('/womens', 'Home::index');
$routes->get('/couples', 'Home::index');
$routes->get('/success', 'Home::index');
$routes->get('/about', 'Home::index');
$routes->get('/contact', 'Home::index');
$routes->get('/churches', 'Home::index');
$routes->get('/eventlist', 'Home::index');
$routes->get('/eventdetail/(:any)', 'Home::index');
$routes->get('/reset_password', 'Home::index');
$routes->get('/billing/(:any)', 'Checkout::index');
$routes->get('/payment/(:any)', 'Checkout::index');
$routes->get('/agreements/(:any)', 'Checkout::index');
$routes->get('/healthinfo/(:any)', 'Checkout::index');
$routes->get('/notifications/(:any)', 'Checkout::index');
$routes->get('/depositepay/(:any)', 'Customer::index');
$routes->get('/myprofile', 'Customer::index');
$routes->get('/myprofile/rewards', 'Customer::index');
$routes->get('/myprofile/changepassword', 'Customer::index');
$routes->get('/myprofile/event', 'Customer::index');
$routes->get('/myprofile/skills', 'Customer::index');
$routes->get('/myprofile/healthinfo', 'Customer::index');
$routes->get('/myprofile/journey', 'Customer::index');
$routes->get('/myprofile/group', 'Customer::index');
$routes->get('/myprofile/results', 'Customer::index');
$routes->get('/myprofile/eventlist/(:any)', 'Customer::index');
$routes->get('/mygroup/send_mail/(:any)', 'Customer::index');
$routes->get('/agreement/eventagreement', 'Agreement::eventagreement');
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Home::logout');
$routes->get('/admindashboard', 'Admin::index');
$routes->get('/agentdashboard', 'Agent::index');
$routes->post('/api/login/validatelogin', 'Api/Login::validatelogin');
$routes->get('/api/user/getAllUsers', 'Api/User::getallusers');
$routes->get('/api/testimonials/getAllTestimonial', 'Api/Testimonial::getalltestimonials');
$routes->post('/api/testimonials/deleteTestimonial', 'Api/Testimonial::deleteTestimonial');
//$routes->get('/api/event/getallevents', 'Api/Event::getallevents');
$routes->get('/api/pages/settingsDetail', 'Api/Pages::settingsDetail');
$routes->post('/api/pages/updateSettings', 'Api/Pages::updateSettings');
$routes->get('/api/pages/getPaymentPlans', 'Api/Pages::getPaymentPlans');
$routes->post('/api/pages/update_payment_plan_settings', 'Api/Pages::update_payment_plan_settings');
$routes->get('/api/checkout/checkPaymentPlan', 'Api/Checkout::checkPaymentPlan');
//$routes->get('/resetpassword', 'Login::index');
//$routes->post('photos/create', 'Photos::create');
/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
