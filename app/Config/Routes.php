<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/pembayaran', 'Pembayaran::index');

$routes->get('pembayaran/get_token/(:segment)', 'Pembayaran::get_token/$1');
$routes->get('pembayaran/success/(:segment)', 'Pembayaran::success/$1');

$routes->get('/test-email', 'Home::testEmail');

// ================= AUTENTIKASI (LOGIN,LOGOUT,REGISTER) =================
$routes->get('/login', 'Auth::index');
$routes->post('/login/process', 'Auth::process');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Register::index');
$routes->post('/register/save', 'Register::save');
$routes->get('/forgot-password', function() {
    return view('auth/forgot_password');
});


// ================= ADMIN =================
$routes->group('admin', ['filter' => 'auth:admin'], function($routes){
$routes->get('services/delete/(:num)', 'Admin\Services::delete/$1');
$routes->get('services/edit/(:num)', 'Admin\Services::edit/$1');

    $routes->get('dashboard', 'Admin\Dashboard::index');

    // services
    $routes->get('services', 'Admin\Services::index');
    $routes->get('services/create', 'Admin\Services::create');
    $routes->get('services/store', 'Admin\Services::store');
    $routes->get('/pembayaran', 'Pembayaran::index');

    // bookings
    $routes->get('bookings', 'Admin\Bookings::index');
    $routes->get('bookings/history', 'Admin\Bookings::history');
    $routes->get('bookings/confirm/(:num)', 'Admin\Bookings::confirm/$1');
    $routes->get('bookings/cancel/(:num)', 'Admin\Bookings::cancel/$1');
});


// ================= CUSTOMER =================
$routes->group('customer', ['filter' => 'auth:customer'], function($routes){

    $routes->get('booking', 'Customer\Booking::index');
    $routes->post('booking/save', 'Customer\Booking::save'); 
    $routes->get('booking/edit/(:num)', 'Customer\Booking::edit/$1');
    $routes->post('booking/update/(:num)', 'Customer\Booking::update/$1');
    $routes->get('booking/delete/(:num)', 'Customer\Booking::delete/$1');
    $routes->get('payment/(:num)', 'Customer\Booking::payment/$1');
    $routes->get('history', 'Customer\History::index');
    $routes->get('/customer/booking/delete/(:num)', 'Customer\Booking::delete/$1');
    $routes->get('booking/invoice/(:num)', 'Customer\Booking::invoice/$1');
});


// ================= STAFF =================
$routes->group('staff', ['filter' => 'auth:staff'], function($routes) {
    $routes->get('dashboard', 'Staff\Dashboard::index');
    $routes->get('booking',              'Staff\Booking::index');
    $routes->get('booking/take/(:num)',  'Staff\Booking::take/$1');
    $routes->get('booking/complete/(:num)', 'Staff\Booking::complete/$1');
    $routes->get('booking/history',      'Staff\Booking::history');
});


// ================= API =================
$routes->group('api', function($routes){

    $routes->get('services', 'Api\ServicesApi::index');
    $routes->get('booking-status/(:num)', 'Api\BookingApi::status/$1');

    // midtrans callback
    $routes->post('payment/callback', 'Api\PaymentCallback::index');
});
