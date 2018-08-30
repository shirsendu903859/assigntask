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
$route['admin/login'] = 'admin/login';
$route['admin/logout'] = 'admin/logout';
$route['admin/logo-management'] = 'admin/logomanagement';
$route['admin/driver-management'] = 'admin/usermanagement';
$route['admin/user-management'] = 'admin/usermanagement';
$route['admin/service-management'] = 'admin/servicemanagement';
$route['admin/profile'] = 'admin/adminprofile';
$route['admin/site-management'] = 'admin/sitemanagement';
$route['admin/coupon-management'] = 'admin/couponmanagement';
$route['admin/category-management'] = 'admin/categorymanagement';
$route['admin/product-management'] = 'admin/productmanagement';
$route['admin/add-product'] = 'admin/addproduct';
$route['admin/attribute-management'] = 'admin/attributemanagement';
$route['admin/banner-management'] = 'admin/bannermanagement';
$route['admin/content-management'] = 'admin/contentmanagement';
$route['admin/blog-management'] = 'admin/blogmanagement';
$route['admin/about-management'] = 'admin/aboutmanagement';
$route['admin/vehicle-type-management'] = 'admin/vehicletypemanagement';
$route['admin/fare-management'] = 'admin/faremanagement';
$route['admin/vehicle-management'] = 'admin/vehicletypemanagement';
$route['admin/bannermanagementchangestatus/(:any)'] = 'admin/bannermanagementchangestatus/$1';
$route['admin/bannermanagementfetchdatabyid/(:any)'] = 'admin/bannermanagementfetchdatabyid/$1';
$route['admin/sub-service-management'] = 'admin/subservicemanagement';
$route['admin/customer-management'] = 'admin/customermanagement';
$route['admin/testimonial-management'] = 'admin/testimonialmanagement';
$route['admin/privacy-policy-management'] = 'admin/privacypolicymanagement';
$route['form/caregiver-registration'] = 'form/caregiverregistration';
$route['admin/faq-topic-management'] = 'admin/faqtopicmanagement';
$route['admin/faq-management'] = 'admin/faqmanagement';
$route['admin/terms-and-conditions'] = 'admin/termsconditions';
$route['admin/contact-query'] = 'admin/contactquery';
$route['admin/blog-category-management'] = 'admin/blogcategorymanagement';
$route['admin/blog-tag-management'] = 'admin/blogtagmanagement';
$route['admin/resource-management'] = 'admin/resourcemanagement';
$route['admin/process-management'] = 'admin/processmanagement';
$route['admin/rates-management'] = 'admin/ratesmanagement';
$route['admin/identity-validation'] = 'admin/identityvalidation';
$route['admin/seo-management/(:any)'] = 'admin/seomanagement/$1';
$route['admin/project-management'] = 'admin/projectmanagement';
$route['admin/project-page-management'] = 'admin/projectpage';
$route['admin/plan-management'] = 'plan';



$route['blog'] = 'user/blog';
$route['blog-details/(:any)/(:any)'] = 'user/blogdetails/$1/$2';
$route['project'] = 'user/project';
