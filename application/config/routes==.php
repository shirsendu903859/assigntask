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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'user';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*custom added routes for admin*/
$route['admin/logo-management'] = 'admin/logomanagement';
$route['admin/user-management'] = 'admin/usermanagement';
$route['admin/blog-management'] = 'admin/blogmanagement';
$route['admin/profile'] = 'admin/adminprofile';
$route['admin/site-management'] = 'admin/sitemanagement';
$route['admin/coupon-management'] = 'admin/couponmanagement';
$route['admin/category-management'] = 'admin/categorymanagement';
$route['admin/product-management'] = 'admin/productmanagement';
$route['admin/add-product'] = 'admin/addproduct';
$route['admin/attribute-management'] = 'admin/attributemanagement';
$route['admin/banner-management'] = 'admin/bannermanagement';
$route['admin/seo-management'] = 'admin/seomanagement';

/*custom added routes for frontend*/
$route['chat'] = 'user/chat';
$route['details/(:any)/(:any)'] = 'user/productdetails/$1/$2';
$route['my-wishlist'] = 'user/mywishlist';
$route['customer-feedback'] = 'user/feedback';
$route['our-venture'] = 'user/aboutus';
$route['my-cart'] = 'user/mycart';
$route['checkout'] = 'user/checkout';
$route['confirm-order/(:any)'] = 'user/confirmorder/$1';

