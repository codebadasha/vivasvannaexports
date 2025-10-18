-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 18, 2025 at 04:04 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vivasvanna`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `role_id`, `name`, `email`, `mobile`, `password`, `is_active`, `is_default`, `is_delete`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Luv Jain', 'admin@admin.com', '9978955809', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 1, 1, 0, NULL, NULL, '2025-09-16 23:09:37'),
(2, 1, 'Kunal Udani', 'asdasdasd@gmail.com', '1111111112', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 0, 0, 0, NULL, '2023-12-27 01:02:17', '2025-09-16 23:23:20'),
(3, 1, 'JAIMIN PATEL', 'jaimin.patel@vivasvannaexports.com', '9726861858', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 1, 0, 0, NULL, '2024-01-09 11:07:14', '2025-09-16 23:09:42'),
(4, 1, 'ALTAF GANJHI', 'SALES@VIVASVANNAEXPORTS.COM', '7990580463', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 1, 0, 1, NULL, '2024-01-09 11:08:06', '2025-09-16 23:09:37'),
(5, 2, 'PARTH DESAI', 'OPT@VIVASVANNAEXPORTS.COM', '9081514555', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 1, 0, 1, NULL, '2024-05-10 10:15:13', '2025-09-16 23:09:37'),
(6, 4, 'SACHIN PATEL', 'ACCOUNTS@VIVASVANNAEXPORTS.COM', '9328828497', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 1, 0, 1, NULL, '2024-05-10 10:15:47', '2025-09-16 23:09:37'),
(7, 4, 'MAHINDRA PANCHAL', 'ACCOUNTS2@VIVASVANNAEXPORTS.COM', '6351769990', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 1, 0, 0, NULL, '2024-05-10 10:16:52', '2025-09-16 23:09:43'),
(8, 5, 'ANJAL PATEL', 'accounts@swarrnim.com', '9978955814', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 1, 0, 0, NULL, '2024-05-10 10:17:18', '2025-09-16 23:09:37'),
(9, 1, 'LUV JAIN', 'LUV.JAIN@VIVASVANNAEXPORTS.COM', '9979955809', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 1, 0, 1, NULL, '2024-05-10 10:18:01', '2025-09-16 23:09:37'),
(10, 2, 'LADANI JAY', 'test@gmail.com', '9876544567', '$2y$12$MP3pX8ZdqLjrwM/nD7XfZOvOBZnqJhdz56jyM5MzYuyUIg0m6/GW.', 1, 0, 1, NULL, '2025-09-16 22:37:45', '2025-09-16 23:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `admins_password_resets`
--

DROP TABLE IF EXISTS `admins_password_resets`;
CREATE TABLE IF NOT EXISTS `admins_password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `admins_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `api_call_log`
--

DROP TABLE IF EXISTS `api_call_log`;
CREATE TABLE IF NOT EXISTS `api_call_log` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_data` json DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_data` json DEFAULT NULL,
  `request_time` timestamp NULL DEFAULT NULL,
  `response_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `api_call_log`
--

INSERT INTO `api_call_log` (`id`, `service`, `url`, `request_data`, `status`, `response_data`, `request_time`, `response_time`, `created_at`, `updated_at`) VALUES
(1, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AADCK9076E1ZH\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AADCK9076E1ZH\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_oWvUOJCvbVFzLuuuaLfl\", \"less_info\": false, \"promoters\": [\"Arun  Kumar \", \"Mahipal Singh \"], \"legal_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"pan_number\": \"AADCK9076E\", \"gstin_status\": \"Active\", \"business_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 100 Cr. to 500 Cr.\", \"contact_details\": {\"principal\": {\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"Maavel Rahenank Plot No. 171, Moje Bhabharnava Binkheti R.S No. 255/1/2, Napa Milkat No. 9236, Banaskantha, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Works Contract, Supplier of Services, Retail Business\"}, \"additional\": [{\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"krmank no 87 rakba no 2.4928 hectare, village morvada tehsil suigam, Morvada Branch Post Office, Morwada, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Wholesale Business, Works Contract, Supplier of Services\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 4,Range - Range - 8,Unit - Ghatak 35 (Deesa) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - GANDHINAGAR,Division - DIVISION PALANPUR,Range - RANGE III - DEESA\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2021-03-16\", \"field_visit_conducted\": \"Yes\", \"nature_bus_activities\": [\"Works Contract\", \"Supplier of Services\", \"Retail Business\", \"Wholesale Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2024-05-27\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:11:52', '2025-08-31 05:11:54', '2025-08-31 05:11:52', '2025-08-31 05:11:54'),
(2, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\"}', 'failed', '{\"error\": \"cURL error 28: Operation timed out after 30005 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list\", \"message\": \"API request failed\", \"success\": false}', '2025-08-31 05:11:54', '2025-08-31 05:12:24', '2025-08-31 05:11:54', '2025-08-31 05:12:24'),
(3, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AADCK9076E1ZH\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AADCK9076E1ZH\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_KxajsqVcsJdfUfFLCJkv\", \"less_info\": false, \"promoters\": [\"Arun  Kumar \", \"Mahipal Singh \"], \"legal_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"pan_number\": \"AADCK9076E\", \"gstin_status\": \"Active\", \"business_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 100 Cr. to 500 Cr.\", \"contact_details\": {\"principal\": {\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"Maavel Rahenank Plot No. 171, Moje Bhabharnava Binkheti R.S No. 255/1/2, Napa Milkat No. 9236, Banaskantha, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Works Contract, Supplier of Services, Retail Business\"}, \"additional\": [{\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"krmank no 87 rakba no 2.4928 hectare, village morvada tehsil suigam, Morvada Branch Post Office, Morwada, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Wholesale Business, Works Contract, Supplier of Services\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 4,Range - Range - 8,Unit - Ghatak 35 (Deesa) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - GANDHINAGAR,Division - DIVISION PALANPUR,Range - RANGE III - DEESA\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2021-03-16\", \"field_visit_conducted\": \"Yes\", \"nature_bus_activities\": [\"Works Contract\", \"Supplier of Services\", \"Retail Business\", \"Wholesale Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2024-05-27\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:12:32', '2025-08-31 05:12:33', '2025-08-31 05:12:32', '2025-08-31 05:12:33'),
(4, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_EgPysEgjxqbFFNcxfidL\", \"company_list\": [{\"cin_number\": \"AAN-0446\", \"company_name\": \"D.R.C INFRATECH LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U05004AP2018PTC108221\", \"company_name\": \"K.R.C AQUA INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U15313RJ1996PLC012609\", \"company_name\": \"K.R.P. INDUSTRIES LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U25203TG2010PTC070548\", \"company_name\": \"K.R.C. PLAST PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45200HR2010PTC040279\", \"company_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45201TN1991PTC020823\", \"company_name\": \"K.R.C. BUILDERS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45309UP2018PTC102675\", \"company_name\": \"VISHWANATH INFRAPROJECTS & INFRAPRODUCTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U74899DL1985PLC022177\", \"company_name\": \"K.T.C. (INDIA) LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U74999CT2016PTC007490\", \"company_name\": \"K.R.C. CONSTRUCTIONS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U85300UR2021NPL011949\", \"company_name\": \"A.R.C ASHIANA FOUNDATION\", \"company_type\": \"other\"}], \"company_name_search\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:12:33', '2025-08-31 05:12:49', '2025-08-31 05:12:33', '2025-08-31 05:12:49'),
(5, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AADCK9076E1ZH\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AADCK9076E1ZH\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_qdIepZQTMWCMnwLchehv\", \"less_info\": false, \"promoters\": [\"Arun  Kumar \", \"Mahipal Singh \"], \"legal_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"pan_number\": \"AADCK9076E\", \"gstin_status\": \"Active\", \"business_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 100 Cr. to 500 Cr.\", \"contact_details\": {\"principal\": {\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"Maavel Rahenank Plot No. 171, Moje Bhabharnava Binkheti R.S No. 255/1/2, Napa Milkat No. 9236, Banaskantha, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Works Contract, Supplier of Services, Retail Business\"}, \"additional\": [{\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"krmank no 87 rakba no 2.4928 hectare, village morvada tehsil suigam, Morvada Branch Post Office, Morwada, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Wholesale Business, Works Contract, Supplier of Services\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 4,Range - Range - 8,Unit - Ghatak 35 (Deesa) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - GANDHINAGAR,Division - DIVISION PALANPUR,Range - RANGE III - DEESA\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2021-03-16\", \"field_visit_conducted\": \"Yes\", \"nature_bus_activities\": [\"Works Contract\", \"Supplier of Services\", \"Retail Business\", \"Wholesale Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2024-05-27\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:13:50', '2025-08-31 05:13:51', '2025-08-31 05:13:50', '2025-08-31 05:13:51'),
(6, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_lVxLyifryYorivTpridK\", \"company_list\": [{\"cin_number\": \"AAN-0446\", \"company_name\": \"D.R.C INFRATECH LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U05004AP2018PTC108221\", \"company_name\": \"K.R.C AQUA INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U15313RJ1996PLC012609\", \"company_name\": \"K.R.P. INDUSTRIES LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U25203TG2010PTC070548\", \"company_name\": \"K.R.C. PLAST PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45200HR2010PTC040279\", \"company_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45201TN1991PTC020823\", \"company_name\": \"K.R.C. BUILDERS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45309UP2018PTC102675\", \"company_name\": \"VISHWANATH INFRAPROJECTS & INFRAPRODUCTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U74899DL1985PLC022177\", \"company_name\": \"K.T.C. (INDIA) LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U74999CT2016PTC007490\", \"company_name\": \"K.R.C. CONSTRUCTIONS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U85300UR2021NPL011949\", \"company_name\": \"A.R.C ASHIANA FOUNDATION\", \"company_type\": \"other\"}], \"company_name_search\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:13:51', '2025-08-31 05:13:53', '2025-08-31 05:13:51', '2025-08-31 05:13:53'),
(7, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AADCK9076E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_pQiKyxdTvVYnIffeqXnw\", \"pan_number\": \"AADCK9076E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 05:13:53', '2025-08-31 05:13:55', '2025-08-31 05:13:53', '2025-08-31 05:13:55'),
(8, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AADCK9076E1ZH\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AADCK9076E1ZH\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_ucjcLyPhCqykFymbcMJD\", \"less_info\": false, \"promoters\": [\"Arun  Kumar \", \"Mahipal Singh \"], \"legal_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"pan_number\": \"AADCK9076E\", \"gstin_status\": \"Active\", \"business_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 100 Cr. to 500 Cr.\", \"contact_details\": {\"principal\": {\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"Maavel Rahenank Plot No. 171, Moje Bhabharnava Binkheti R.S No. 255/1/2, Napa Milkat No. 9236, Banaskantha, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Works Contract, Supplier of Services, Retail Business\"}, \"additional\": [{\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"krmank no 87 rakba no 2.4928 hectare, village morvada tehsil suigam, Morvada Branch Post Office, Morwada, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Wholesale Business, Works Contract, Supplier of Services\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 4,Range - Range - 8,Unit - Ghatak 35 (Deesa) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - GANDHINAGAR,Division - DIVISION PALANPUR,Range - RANGE III - DEESA\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2021-03-16\", \"field_visit_conducted\": \"Yes\", \"nature_bus_activities\": [\"Works Contract\", \"Supplier of Services\", \"Retail Business\", \"Wholesale Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2024-05-27\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:14:21', '2025-08-31 05:14:22', '2025-08-31 05:14:21', '2025-08-31 05:14:22'),
(9, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_XWgKybCguUrabeLtDwWc\", \"company_list\": [{\"cin_number\": \"AAN-0446\", \"company_name\": \"D.R.C INFRATECH LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U05004AP2018PTC108221\", \"company_name\": \"K.R.C AQUA INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U15313RJ1996PLC012609\", \"company_name\": \"K.R.P. INDUSTRIES LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U25203TG2010PTC070548\", \"company_name\": \"K.R.C. PLAST PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45200HR2010PTC040279\", \"company_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45201TN1991PTC020823\", \"company_name\": \"K.R.C. BUILDERS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45309UP2018PTC102675\", \"company_name\": \"VISHWANATH INFRAPROJECTS & INFRAPRODUCTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U74899DL1985PLC022177\", \"company_name\": \"K.T.C. (INDIA) LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U74999CT2016PTC007490\", \"company_name\": \"K.R.C. CONSTRUCTIONS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U85300UR2021NPL011949\", \"company_name\": \"A.R.C ASHIANA FOUNDATION\", \"company_type\": \"other\"}], \"company_name_search\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:14:22', '2025-08-31 05:14:24', '2025-08-31 05:14:22', '2025-08-31 05:14:24'),
(10, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AADCK9076E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_MwQkfOyHrFlNcxnZognL\", \"pan_number\": \"AADCK9076E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 05:14:24', '2025-08-31 05:14:26', '2025-08-31 05:14:24', '2025-08-31 05:14:26'),
(11, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AAGCV8932P1ZL\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AAGCV8932P1ZL\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_aiJIOmkpyMUlTYzdcqFx\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \"], \"legal_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"pan_number\": \"AAGCV8932P\", \"gstin_status\": \"Active\", \"business_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 25 Cr. to 100 Cr. \", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"6351769990\", \"address\": \"WORLD BUSINESS CENTRE, 20, NR PARIMAL GARDEN, PARIMAL GARDEN ROAD, AHMEDABAD, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Retail Business, Factory / Manufacturing, Import, Warehouse / Depot\"}, \"additional\": [{\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"6351769990\", \"address\": \"Survey No. 185/1 of Block No. 485, B/h asha kiran scool, sanand, Viramgam, Ahmedabad, Gujarat, 382150\", \"nature_of_business\": \"Factory / Manufacturing\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE V (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2019-04-09\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Retail Business\", \"Factory / Manufacturing\", \"Import\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2024-01-06\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"TRD:TWD\", \"nature_of_core_business_activity_description\": \"Trader, Wholesaler/Distributor\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:19:32', '2025-08-31 05:19:33', '2025-08-31 05:19:32', '2025-08-31 05:19:33'),
(12, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_WuvVqXqpefkVZsUefzON\", \"company_list\": [{\"cin_number\": \"AAB-5129\", \"company_name\": \"VIVASVANT SYSTEMS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ABZ-2467\", \"company_name\": \"VIVASVAN ENTERPRISE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-6826\", \"company_name\": \"VIVASVAN INFRA LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U29100MH2019PTC323869\", \"company_name\": \"VIVASVANA ENVIROTECH PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U40106KA2018PTC119210\", \"company_name\": \"VIVASWANA VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U40108TG2013PTC089933\", \"company_name\": \"VIVASVAN ENERGY PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909GJ2019PTC107573\", \"company_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U52100GJ2011PTC064689\", \"company_name\": \"EMPORIS EXPORTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U68200AS2023PTC025305\", \"company_name\": \"VIVASVAN BUILDWELL PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U72900DL2007PTC159914\", \"company_name\": \"VIVASVAN TECHNOLOGIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:19:33', '2025-08-31 05:19:42', '2025-08-31 05:19:33', '2025-08-31 05:19:42'),
(13, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AAGCV8932P\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_gtuoNqKtWnuBgvIEgUcA\", \"pan_number\": \"AAGCV8932P\", \"udyam_exists\": true, \"migration_status\": \"migrated\"}, \"message\": \"success\", \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:19:42', '2025-08-31 05:19:43', '2025-08-31 05:19:42', '2025-08-31 05:19:43'),
(14, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AADCK9076E1ZH\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AADCK9076E1ZH\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_MFZvEhOeevpbGLNQPjmc\", \"less_info\": false, \"promoters\": [\"Arun  Kumar \", \"Mahipal Singh \"], \"legal_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"pan_number\": \"AADCK9076E\", \"gstin_status\": \"Active\", \"business_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 100 Cr. to 500 Cr.\", \"contact_details\": {\"principal\": {\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"Maavel Rahenank Plot No. 171, Moje Bhabharnava Binkheti R.S No. 255/1/2, Napa Milkat No. 9236, Banaskantha, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Works Contract, Supplier of Services, Retail Business\"}, \"additional\": [{\"email\": \"account@krcinfraprojects.com\", \"mobile\": \"8130996474\", \"address\": \"krmank no 87 rakba no 2.4928 hectare, village morvada tehsil suigam, Morvada Branch Post Office, Morwada, Banaskantha, Gujarat, 385320\", \"nature_of_business\": \"Wholesale Business, Works Contract, Supplier of Services\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 4,Range - Range - 8,Unit - Ghatak 35 (Deesa) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - GANDHINAGAR,Division - DIVISION PALANPUR,Range - RANGE III - DEESA\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2021-03-16\", \"field_visit_conducted\": \"Yes\", \"nature_bus_activities\": [\"Works Contract\", \"Supplier of Services\", \"Retail Business\", \"Wholesale Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2024-05-27\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:24:26', '2025-08-31 05:24:27', '2025-08-31 05:24:26', '2025-08-31 05:24:27'),
(15, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_uafOEwGIsglkIWCfsFnh\", \"company_list\": [{\"cin_number\": \"AAN-0446\", \"company_name\": \"D.R.C INFRATECH LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U05004AP2018PTC108221\", \"company_name\": \"K.R.C AQUA INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U15313RJ1996PLC012609\", \"company_name\": \"K.R.P. INDUSTRIES LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U25203TG2010PTC070548\", \"company_name\": \"K.R.C. PLAST PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45200HR2010PTC040279\", \"company_name\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45201TN1991PTC020823\", \"company_name\": \"K.R.C. BUILDERS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45309UP2018PTC102675\", \"company_name\": \"VISHWANATH INFRAPROJECTS & INFRAPRODUCTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U74899DL1985PLC022177\", \"company_name\": \"K.T.C. (INDIA) LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U74999CT2016PTC007490\", \"company_name\": \"K.R.C. CONSTRUCTIONS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U85300UR2021NPL011949\", \"company_name\": \"A.R.C ASHIANA FOUNDATION\", \"company_type\": \"other\"}], \"company_name_search\": \"K.R.C. INFRAPROJECTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:24:27', '2025-08-31 05:24:28', '2025-08-31 05:24:27', '2025-08-31 05:24:28'),
(16, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AADCK9076E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_leHmaBPLbJwyhdFlxbRb\", \"pan_number\": \"AADCK9076E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 05:24:28', '2025-08-31 05:24:30', '2025-08-31 05:24:28', '2025-08-31 05:24:30'),
(17, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AAGCV8932P1ZL\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AAGCV8932P1ZL\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_ojvhzhidmVruvBdPeOWu\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \"], \"legal_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"pan_number\": \"AAGCV8932P\", \"gstin_status\": \"Active\", \"business_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 25 Cr. to 100 Cr. \", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"6351769990\", \"address\": \"WORLD BUSINESS CENTRE, 20, NR PARIMAL GARDEN, PARIMAL GARDEN ROAD, AHMEDABAD, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Retail Business, Factory / Manufacturing, Import, Warehouse / Depot\"}, \"additional\": [{\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"6351769990\", \"address\": \"Survey No. 185/1 of Block No. 485, B/h asha kiran scool, sanand, Viramgam, Ahmedabad, Gujarat, 382150\", \"nature_of_business\": \"Factory / Manufacturing\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE V (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2019-04-09\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Retail Business\", \"Factory / Manufacturing\", \"Import\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2024-01-06\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"TRD:TWD\", \"nature_of_core_business_activity_description\": \"Trader, Wholesaler/Distributor\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:25:50', '2025-08-31 05:25:51', '2025-08-31 05:25:50', '2025-08-31 05:25:51'),
(18, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_VnnopgKkbhQUrcBlfQwm\", \"company_list\": [{\"cin_number\": \"AAB-5129\", \"company_name\": \"VIVASVANT SYSTEMS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ABZ-2467\", \"company_name\": \"VIVASVAN ENTERPRISE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-6826\", \"company_name\": \"VIVASVAN INFRA LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U29100MH2019PTC323869\", \"company_name\": \"VIVASVANA ENVIROTECH PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U40106KA2018PTC119210\", \"company_name\": \"VIVASWANA VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U40108TG2013PTC089933\", \"company_name\": \"VIVASVAN ENERGY PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909GJ2019PTC107573\", \"company_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U52100GJ2011PTC064689\", \"company_name\": \"EMPORIS EXPORTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U68200AS2023PTC025305\", \"company_name\": \"VIVASVAN BUILDWELL PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U72900DL2007PTC159914\", \"company_name\": \"VIVASVAN TECHNOLOGIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:25:51', '2025-08-31 05:25:53', '2025-08-31 05:25:51', '2025-08-31 05:25:53'),
(19, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AAGCV8932P\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_lxUmulHbmxDJhyQwjLxr\", \"pan_number\": \"AAGCV8932P\", \"udyam_exists\": true, \"migration_status\": \"migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:25:53', '2025-08-31 05:25:54', '2025-08-31 05:25:53', '2025-08-31 05:25:54'),
(20, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AAGCV8932P1ZL\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AAGCV8932P1ZL\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_ODVbrQgaucpdmzbZMMnn\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \"], \"legal_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"pan_number\": \"AAGCV8932P\", \"gstin_status\": \"Active\", \"business_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 25 Cr. to 100 Cr. \", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"6351769990\", \"address\": \"WORLD BUSINESS CENTRE, 20, NR PARIMAL GARDEN, PARIMAL GARDEN ROAD, AHMEDABAD, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Retail Business, Factory / Manufacturing, Import, Warehouse / Depot\"}, \"additional\": [{\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"6351769990\", \"address\": \"Survey No. 185/1 of Block No. 485, B/h asha kiran scool, sanand, Viramgam, Ahmedabad, Gujarat, 382150\", \"nature_of_business\": \"Factory / Manufacturing\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE V (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2019-04-09\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Retail Business\", \"Factory / Manufacturing\", \"Import\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2024-01-06\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"TRD:TWD\", \"nature_of_core_business_activity_description\": \"Trader, Wholesaler/Distributor\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:36:29', '2025-08-31 05:36:30', '2025-08-31 05:36:29', '2025-08-31 05:36:30'),
(21, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_XszsjwgPrugePCdAFQgm\", \"company_list\": [{\"cin_number\": \"AAB-5129\", \"company_name\": \"VIVASVANT SYSTEMS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ABZ-2467\", \"company_name\": \"VIVASVAN ENTERPRISE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-6826\", \"company_name\": \"VIVASVAN INFRA LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U29100MH2019PTC323869\", \"company_name\": \"VIVASVANA ENVIROTECH PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U40106KA2018PTC119210\", \"company_name\": \"VIVASWANA VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U40108TG2013PTC089933\", \"company_name\": \"VIVASVAN ENERGY PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909GJ2019PTC107573\", \"company_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U52100GJ2011PTC064689\", \"company_name\": \"EMPORIS EXPORTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U68200AS2023PTC025305\", \"company_name\": \"VIVASVAN BUILDWELL PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U72900DL2007PTC159914\", \"company_name\": \"VIVASVAN TECHNOLOGIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:36:30', '2025-08-31 05:36:32', '2025-08-31 05:36:30', '2025-08-31 05:36:32'),
(22, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AAGCV8932P\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_dhIngfmwtzNrqserVtjU\", \"pan_number\": \"AAGCV8932P\", \"udyam_exists\": true, \"migration_status\": \"migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:36:32', '2025-08-31 05:36:33', '2025-08-31 05:36:32', '2025-08-31 05:36:33'),
(23, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AAGCV8932P1ZL\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AAGCV8932P1ZL\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_AipBGLarsyheqqeYjqAc\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \"], \"legal_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"pan_number\": \"AAGCV8932P\", \"gstin_status\": \"Active\", \"business_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 25 Cr. to 100 Cr. \", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"6351769990\", \"address\": \"WORLD BUSINESS CENTRE, 20, NR PARIMAL GARDEN, PARIMAL GARDEN ROAD, AHMEDABAD, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Retail Business, Factory / Manufacturing, Import, Warehouse / Depot\"}, \"additional\": [{\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"6351769990\", \"address\": \"Survey No. 185/1 of Block No. 485, B/h asha kiran scool, sanand, Viramgam, Ahmedabad, Gujarat, 382150\", \"nature_of_business\": \"Factory / Manufacturing\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE V (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2019-04-09\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Retail Business\", \"Factory / Manufacturing\", \"Import\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2024-01-06\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"TRD:TWD\", \"nature_of_core_business_activity_description\": \"Trader, Wholesaler/Distributor\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:41:15', '2025-08-31 05:41:16', '2025-08-31 05:41:15', '2025-08-31 05:41:16'),
(24, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_JqocFyLmtmJTAFrNXnzv\", \"company_list\": [{\"cin_number\": \"AAB-5129\", \"company_name\": \"VIVASVANT SYSTEMS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ABZ-2467\", \"company_name\": \"VIVASVAN ENTERPRISE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-6826\", \"company_name\": \"VIVASVAN INFRA LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U29100MH2019PTC323869\", \"company_name\": \"VIVASVANA ENVIROTECH PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U40106KA2018PTC119210\", \"company_name\": \"VIVASWANA VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U40108TG2013PTC089933\", \"company_name\": \"VIVASVAN ENERGY PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909GJ2019PTC107573\", \"company_name\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U52100GJ2011PTC064689\", \"company_name\": \"EMPORIS EXPORTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U68200AS2023PTC025305\", \"company_name\": \"VIVASVAN BUILDWELL PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U72900DL2007PTC159914\", \"company_name\": \"VIVASVAN TECHNOLOGIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"VIVASVANNA EXPORTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:41:16', '2025-08-31 05:41:18', '2025-08-31 05:41:16', '2025-08-31 05:41:18'),
(25, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AAGCV8932P\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_qqwxxVxuevwoOvxBlPFA\", \"pan_number\": \"AAGCV8932P\", \"udyam_exists\": true, \"migration_status\": \"migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 05:41:18', '2025-08-31 05:41:18', '2025-08-31 05:41:18', '2025-08-31 05:41:18'),
(26, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_ukuahemZwgkTyqUoYUCl\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:08:00', '2025-08-31 08:08:02', '2025-08-31 08:08:00', '2025-08-31 08:08:02'),
(27, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'failed', '{\"data\": null, \"error\": null, \"message\": \"Internal Server Error Occurred\", \"success\": false, \"status_code\": 500, \"message_code\": \"contact_support\"}', '2025-08-31 08:08:02', '2025-08-31 08:08:19', '2025-08-31 08:08:02', '2025-08-31 08:08:19'),
(28, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_mALAgtmnNlApfuknMalb\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:08:26', '2025-08-31 08:08:27', '2025-08-31 08:08:26', '2025-08-31 08:08:27'),
(29, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_wlPxPrfqNxrHatHtUXIm\", \"company_list\": [{\"cin_number\": \"L05005TG1992PLC014678\", \"company_name\": \"NCC BLUE WATER PRODUCTS LTD.\", \"company_type\": \"other\"}, {\"cin_number\": \"U26921WB1981PTC033577\", \"company_name\": \"HKC TECHIND PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U45200TG2004PLC043015\", \"company_name\": \"GKC PROJECTS LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U45202DL2003PTC121288\", \"company_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51109WB1994PTC065109\", \"company_name\": \"NAC TRAVELS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U72200WB2006PTC109866\", \"company_name\": \"NKA COMMERCIAL PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1991PTC052784\", \"company_name\": \"NKB FINANCIAL SERVICES PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1993PTC059795\", \"company_name\": \"AKC CONSULTANCY PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74210WB1965PTC026506\", \"company_name\": \"N.C. ENGINEERS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74899DL1988PLC032808\", \"company_name\": \"NEC INDUSTRIAL PROJECTS LTD\", \"company_type\": \"other\"}], \"company_name_search\": \"NKC PROJECTS PVT LTD\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:08:27', '2025-08-31 08:08:55', '2025-08-31 08:08:27', '2025-08-31 08:08:55');
INSERT INTO `api_call_log` (`id`, `service`, `url`, `request_data`, `status`, `response_data`, `request_time`, `response_time`, `created_at`, `updated_at`) VALUES
(30, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_huxJmtnhGytylUeEdYcg\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": true, \"migration_status\": \"not_migrated\"}, \"message\": \"success\", \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:08:55', '2025-08-31 08:08:57', '2025-08-31 08:08:55', '2025-08-31 08:08:57'),
(31, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"08AACCN4070E2ZO\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"08AACCN4070E2ZO\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_PjgFYxjCdjqCrGzastqX\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"20, SCHEME NO 8, GANDHI NAGAR, ALWAR, Alwar, Rajasthan, 301001\", \"nature_of_business\": \"Works Contract\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO 223 229  229/2, POST OFIICE TEORI, TEHSIL TEORI, GAGARI, Jodhpur, Rajasthan, 342306\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARI NO 602/439 470/2, TEHSIL BAP, BUNGRI, Jodhpur, Rajasthan, 342307\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"khasara no. 576, 7499/573, TEHSIL NOKHA, VILLAGE PANCHOO, Bikaner, Rajasthan, 334804\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO. 3053, TEHSIL. BALESAR, VILLAGE. BELWA, Jodhpur, Rajasthan, 342023\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO. 263, TEHSIL. PACHPADRA, VILLAGE. HATLOO, Barmer, Rajasthan, 344022\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO 742, TEHSIL  BAPINI, ISHRU, Jodhpur, Rajasthan, 342311\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"746/386, VILLAGE TRISINGADI, TEHSIL PACHPADRA, Barmer, Rajasthan, 344022\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Rajasthan,Zone - Alwar,Circle - Circle-B, Alwar,Ward - Circle-B, Alwar, AC / CTO Ward\", \"center_jurisdiction\": \"State - CBIC,Zone - JAIPUR,Commissionerate - ALWAR,Division - CGST Division- Alwar - I,Range - GST RANGE-II ALWAR (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2019-04-25\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Recipient of Goods or Services\", \"Office / Sale Office\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-02-20\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:29:40', '2025-08-31 08:29:41', '2025-08-31 08:29:40', '2025-08-31 08:29:41'),
(32, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PRIVATE LIMITED\"}', 'failed', '{\"error\": \"cURL error 28: Operation timed out after 30013 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list\", \"message\": \"API request failed\", \"success\": false}', '2025-08-31 08:29:41', '2025-08-31 08:30:11', '2025-08-31 08:29:41', '2025-08-31 08:30:11'),
(33, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"08AACCN4070E2ZO\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"08AACCN4070E2ZO\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_vVvgumnvamLjtLQUxXyl\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"20, SCHEME NO 8, GANDHI NAGAR, ALWAR, Alwar, Rajasthan, 301001\", \"nature_of_business\": \"Works Contract\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO 223 229  229/2, POST OFIICE TEORI, TEHSIL TEORI, GAGARI, Jodhpur, Rajasthan, 342306\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARI NO 602/439 470/2, TEHSIL BAP, BUNGRI, Jodhpur, Rajasthan, 342307\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"khasara no. 576, 7499/573, TEHSIL NOKHA, VILLAGE PANCHOO, Bikaner, Rajasthan, 334804\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO. 3053, TEHSIL. BALESAR, VILLAGE. BELWA, Jodhpur, Rajasthan, 342023\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO. 263, TEHSIL. PACHPADRA, VILLAGE. HATLOO, Barmer, Rajasthan, 344022\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO 742, TEHSIL  BAPINI, ISHRU, Jodhpur, Rajasthan, 342311\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"746/386, VILLAGE TRISINGADI, TEHSIL PACHPADRA, Barmer, Rajasthan, 344022\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Rajasthan,Zone - Alwar,Circle - Circle-B, Alwar,Ward - Circle-B, Alwar, AC / CTO Ward\", \"center_jurisdiction\": \"State - CBIC,Zone - JAIPUR,Commissionerate - ALWAR,Division - CGST Division- Alwar - I,Range - GST RANGE-II ALWAR (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2019-04-25\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Recipient of Goods or Services\", \"Office / Sale Office\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-02-20\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:30:51', '2025-08-31 08:30:52', '2025-08-31 08:30:51', '2025-08-31 08:30:52'),
(34, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_uqoBfbdhntrJmdfFolhj\", \"company_list\": [{\"cin_number\": \"AAP-8729\", \"company_name\": \"NKC BEARING LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ABZ-8122\", \"company_name\": \"NKC INFRASTRUTURE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U45200TG2004PLC043015\", \"company_name\": \"GKC PROJECTS LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U45202DL2003PTC121288\", \"company_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45400MH2012PTC230795\", \"company_name\": \"NBC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70101DL2004PTC128248\", \"company_name\": \"NKA PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70102PB2011PTC035109\", \"company_name\": \"NKG PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70109OR2017PTC027725\", \"company_name\": \"MKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70109WB2008PTC127768\", \"company_name\": \"DKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70200WB1998PTC086867\", \"company_name\": \"NKB PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"NKC PROJECTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:30:52', '2025-08-31 08:30:55', '2025-08-31 08:30:52', '2025-08-31 08:30:55'),
(35, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_BbPbliMeUERgvGlnlovi\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": true, \"migration_status\": \"not_migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:30:55', '2025-08-31 08:30:55', '2025-08-31 08:30:55', '2025-08-31 08:30:55'),
(36, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"08AACCN4070E2ZO\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"08AACCN4070E2ZO\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_hsYQaJiepsutzlcenNmo\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"20, SCHEME NO 8, GANDHI NAGAR, ALWAR, Alwar, Rajasthan, 301001\", \"nature_of_business\": \"Works Contract\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO 223 229  229/2, POST OFIICE TEORI, TEHSIL TEORI, GAGARI, Jodhpur, Rajasthan, 342306\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARI NO 602/439 470/2, TEHSIL BAP, BUNGRI, Jodhpur, Rajasthan, 342307\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"khasara no. 576, 7499/573, TEHSIL NOKHA, VILLAGE PANCHOO, Bikaner, Rajasthan, 334804\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO. 3053, TEHSIL. BALESAR, VILLAGE. BELWA, Jodhpur, Rajasthan, 342023\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO. 263, TEHSIL. PACHPADRA, VILLAGE. HATLOO, Barmer, Rajasthan, 344022\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO 742, TEHSIL  BAPINI, ISHRU, Jodhpur, Rajasthan, 342311\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"746/386, VILLAGE TRISINGADI, TEHSIL PACHPADRA, Barmer, Rajasthan, 344022\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Rajasthan,Zone - Alwar,Circle - Circle-B, Alwar,Ward - Circle-B, Alwar, AC / CTO Ward\", \"center_jurisdiction\": \"State - CBIC,Zone - JAIPUR,Commissionerate - ALWAR,Division - CGST Division- Alwar - I,Range - GST RANGE-II ALWAR (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2019-04-25\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Recipient of Goods or Services\", \"Office / Sale Office\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-02-20\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:35:38', '2025-08-31 08:35:39', '2025-08-31 08:35:38', '2025-08-31 08:35:39'),
(37, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_rrsBhotvKilmntGgwaeg\", \"company_list\": [{\"cin_number\": \"AAP-8729\", \"company_name\": \"NKC BEARING LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ABZ-8122\", \"company_name\": \"NKC INFRASTRUTURE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U45200TG2004PLC043015\", \"company_name\": \"GKC PROJECTS LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U45202DL2003PTC121288\", \"company_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45400MH2012PTC230795\", \"company_name\": \"NBC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70101DL2004PTC128248\", \"company_name\": \"NKA PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70102PB2011PTC035109\", \"company_name\": \"NKG PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70109OR2017PTC027725\", \"company_name\": \"MKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70109WB2008PTC127768\", \"company_name\": \"DKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70200WB1998PTC086867\", \"company_name\": \"NKB PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"NKC PROJECTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:35:39', '2025-08-31 08:35:40', '2025-08-31 08:35:39', '2025-08-31 08:35:40'),
(38, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_mvyQkLbTavTtLRtunarc\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": true, \"migration_status\": \"not_migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:35:40', '2025-08-31 08:35:40', '2025-08-31 08:35:40', '2025-08-31 08:35:40'),
(39, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"08AACCN4070E2ZO\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"08AACCN4070E2ZO\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_dkonxybTnFqqjqoBgTdG\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"20, SCHEME NO 8, GANDHI NAGAR, ALWAR, Alwar, Rajasthan, 301001\", \"nature_of_business\": \"Works Contract\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO 223 229  229/2, POST OFIICE TEORI, TEHSIL TEORI, GAGARI, Jodhpur, Rajasthan, 342306\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARI NO 602/439 470/2, TEHSIL BAP, BUNGRI, Jodhpur, Rajasthan, 342307\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"khasara no. 576, 7499/573, TEHSIL NOKHA, VILLAGE PANCHOO, Bikaner, Rajasthan, 334804\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO. 3053, TEHSIL. BALESAR, VILLAGE. BELWA, Jodhpur, Rajasthan, 342023\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO. 263, TEHSIL. PACHPADRA, VILLAGE. HATLOO, Barmer, Rajasthan, 344022\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHASARA NO 742, TEHSIL  BAPINI, ISHRU, Jodhpur, Rajasthan, 342311\", \"nature_of_business\": \"Works Contract\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"746/386, VILLAGE TRISINGADI, TEHSIL PACHPADRA, Barmer, Rajasthan, 344022\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Rajasthan,Zone - Alwar,Circle - Circle-B, Alwar,Ward - Circle-B, Alwar, AC / CTO Ward\", \"center_jurisdiction\": \"State - CBIC,Zone - JAIPUR,Commissionerate - ALWAR,Division - CGST Division- Alwar - I,Range - GST RANGE-II ALWAR (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2019-04-25\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Recipient of Goods or Services\", \"Office / Sale Office\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-02-20\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:36:47', '2025-08-31 08:36:48', '2025-08-31 08:36:47', '2025-08-31 08:36:48'),
(40, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PRIVATE LIMITED\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_BhvjqQqUazcKHCDuKGwy\", \"company_list\": [{\"cin_number\": \"AAP-8729\", \"company_name\": \"NKC BEARING LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ABZ-8122\", \"company_name\": \"NKC INFRASTRUTURE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U45200TG2004PLC043015\", \"company_name\": \"GKC PROJECTS LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U45202DL2003PTC121288\", \"company_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U45400MH2012PTC230795\", \"company_name\": \"NBC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70101DL2004PTC128248\", \"company_name\": \"NKA PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70102PB2011PTC035109\", \"company_name\": \"NKG PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70109OR2017PTC027725\", \"company_name\": \"MKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70109WB2008PTC127768\", \"company_name\": \"DKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U70200WB1998PTC086867\", \"company_name\": \"NKB PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"NKC PROJECTS PRIVATE LIMITED\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:36:48', '2025-08-31 08:36:51', '2025-08-31 08:36:48', '2025-08-31 08:36:51'),
(41, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_QmqpraqzrpOXnjoDInvj\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": true, \"migration_status\": \"not_migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 08:36:51', '2025-08-31 08:36:51', '2025-08-31 08:36:51', '2025-08-31 08:36:51'),
(42, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_aujkGDpvppYtWwZmnECe\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:40:27', '2025-08-31 10:40:29', '2025-08-31 10:40:27', '2025-08-31 10:40:29'),
(43, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_gOGzprnHprhWfeRmnZEO\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:40:29', '2025-08-31 10:40:50', '2025-08-31 10:40:29', '2025-08-31 10:40:50'),
(44, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_DushwqfrsrVBQpVjkiEj\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 10:40:50', '2025-08-31 10:40:53', '2025-08-31 10:40:50', '2025-08-31 10:40:53'),
(45, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_rLSztUAbNSWfbSwGxeAj\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:43:47', '2025-08-31 10:43:52', '2025-08-31 10:43:47', '2025-08-31 10:43:52'),
(46, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_aqUwLHhQIwnoMuUnardH\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:43:52', '2025-08-31 10:44:02', '2025-08-31 10:43:52', '2025-08-31 10:44:02'),
(47, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_MwXGqEbdqqnibnptxWpz\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 10:44:02', '2025-08-31 10:44:04', '2025-08-31 10:44:02', '2025-08-31 10:44:04'),
(48, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_OoOqjaaIjZeqhesOTEex\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:45:03', '2025-08-31 10:45:05', '2025-08-31 10:45:03', '2025-08-31 10:45:05'),
(49, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_llkgWnGmfAcHjVgftkSJ\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:45:05', '2025-08-31 10:45:06', '2025-08-31 10:45:05', '2025-08-31 10:45:06'),
(50, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_habInOiMoibOxqorowvV\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 10:45:06', '2025-08-31 10:45:08', '2025-08-31 10:45:06', '2025-08-31 10:45:08'),
(51, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_vbuRikOwVhkZEKwilPRV\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:48:09', '2025-08-31 10:48:10', '2025-08-31 10:48:09', '2025-08-31 10:48:10'),
(52, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_swkxlnwzmvddhjOilPUA\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:48:10', '2025-08-31 10:48:12', '2025-08-31 10:48:10', '2025-08-31 10:48:12'),
(53, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_dqXhrnXRMuYezobhCxhz\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 10:48:12', '2025-08-31 10:48:14', '2025-08-31 10:48:12', '2025-08-31 10:48:14'),
(54, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_HhlmueypBoYgeZJcRfuC\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:52:24', '2025-08-31 10:52:25', '2025-08-31 10:52:24', '2025-08-31 10:52:25'),
(55, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_urGbsXxhLeGnzxjkOGZj\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 10:52:25', '2025-08-31 10:52:27', '2025-08-31 10:52:25', '2025-08-31 10:52:27'),
(56, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_iZZkkxkudrykzgxbYBPn\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 10:52:27', '2025-08-31 10:52:29', '2025-08-31 10:52:27', '2025-08-31 10:52:29'),
(57, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_dpPenNkmdJEutjhMovjp\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 11:56:52', '2025-08-31 11:56:54', '2025-08-31 11:56:52', '2025-08-31 11:56:54'),
(58, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_zBRnlOfHrmfauzfhQAkP\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 11:56:54', '2025-08-31 11:57:14', '2025-08-31 11:56:54', '2025-08-31 11:57:14'),
(59, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_qieQUpwvfZloAzDviAaa\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 11:57:14', '2025-08-31 11:57:16', '2025-08-31 11:57:14', '2025-08-31 11:57:16');
INSERT INTO `api_call_log` (`id`, `service`, `url`, `request_data`, `status`, `response_data`, `request_time`, `response_time`, `created_at`, `updated_at`) VALUES
(60, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_kllqWcXrevoxnVwyLteK\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 11:57:16', '2025-08-31 11:57:17', '2025-08-31 11:57:16', '2025-08-31 11:57:17'),
(61, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_WcRcYWsGyddLkavPyqVa\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 11:57:17', '2025-08-31 11:57:19', '2025-08-31 11:57:17', '2025-08-31 11:57:19'),
(62, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_bHurpnFfUvnizrEnrCkg\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 11:57:19', '2025-08-31 11:57:21', '2025-08-31 11:57:19', '2025-08-31 11:57:21'),
(63, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_cseMUcMBakukQHegmrWi\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 11:59:50', '2025-08-31 11:59:52', '2025-08-31 11:59:50', '2025-08-31 11:59:52'),
(64, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_BezoeFxFiQyPpIldDiaK\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 11:59:52', '2025-08-31 11:59:54', '2025-08-31 11:59:52', '2025-08-31 11:59:54'),
(65, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_xfgngrlejJehzxRsriga\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 11:59:54', '2025-08-31 11:59:56', '2025-08-31 11:59:54', '2025-08-31 11:59:56'),
(66, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_oWvSRexrYlsnKsbGZdQn\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:01:02', '2025-08-31 12:01:03', '2025-08-31 12:01:02', '2025-08-31 12:01:03'),
(67, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_GdcFYjnFzdNAtxamlBXf\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:01:03', '2025-08-31 12:01:04', '2025-08-31 12:01:03', '2025-08-31 12:01:04'),
(68, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_iUaavudpsGcxyIBoeDBQ\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 12:01:04', '2025-08-31 12:01:06', '2025-08-31 12:01:04', '2025-08-31 12:01:06'),
(69, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_xfAExqqwbPnBdZreNicf\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:07:40', '2025-08-31 12:07:41', '2025-08-31 12:07:40', '2025-08-31 12:07:41'),
(70, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_UpwybrCakkgELhAprNza\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:07:41', '2025-08-31 12:07:42', '2025-08-31 12:07:41', '2025-08-31 12:07:42'),
(71, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_bOJaKuyMZBMbbsAqhJti\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-08-31 12:07:42', '2025-08-31 12:07:45', '2025-08-31 12:07:42', '2025-08-31 12:07:45'),
(72, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_psxkAffiUnqvzHxaIiyb\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:08:49', '2025-08-31 12:08:51', '2025-08-31 12:08:49', '2025-08-31 12:08:51'),
(73, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_hiuvznikKfqwlHhBgjRm\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:08:51', '2025-08-31 12:08:52', '2025-08-31 12:08:51', '2025-08-31 12:08:52'),
(74, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_IbNbhmxvLCqzqIJjunFj\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Internal Server Error, try later.\", \"success\": false, \"status_code\": 500, \"message_code\": \"internal_server_error\"}', '2025-08-31 12:08:52', '2025-08-31 12:08:54', '2025-08-31 12:08:52', '2025-08-31 12:08:54'),
(75, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_vRQpymMSSjRtHutajhov\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:10:05', '2025-08-31 12:10:06', '2025-08-31 12:10:05', '2025-08-31 12:10:06'),
(76, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_UasKntadNhWQWOXpmsdU\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:10:06', '2025-08-31 12:10:08', '2025-08-31 12:10:06', '2025-08-31 12:10:08'),
(77, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_njNgwsHiRLFevockxneD\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Internal Server Error, try later.\", \"success\": false, \"status_code\": 500, \"message_code\": \"internal_server_error\"}', '2025-08-31 12:10:08', '2025-08-31 12:10:09', '2025-08-31 12:10:08', '2025-08-31 12:10:09'),
(78, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_weesWRceFrZMSCrcaidq\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:11:49', '2025-08-31 12:11:50', '2025-08-31 12:11:49', '2025-08-31 12:11:50'),
(79, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_tEaunuyitobuqcsUjvtn\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:11:50', '2025-08-31 12:11:52', '2025-08-31 12:11:50', '2025-08-31 12:11:52'),
(80, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_QeSgfRJgoADovOPFteUa\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Internal Server Error, try later.\", \"success\": false, \"status_code\": 500, \"message_code\": \"internal_server_error\"}', '2025-08-31 12:11:52', '2025-08-31 12:11:53', '2025-08-31 12:11:52', '2025-08-31 12:11:53'),
(81, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_qNcdvhZdYpmseqFigGXz\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:16:56', '2025-08-31 12:16:57', '2025-08-31 12:16:56', '2025-08-31 12:16:57'),
(82, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_rwroqajrqCeEhVyqyzto\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-08-31 12:16:57', '2025-08-31 12:16:59', '2025-08-31 12:16:57', '2025-08-31 12:16:59'),
(83, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_pLljsxvlAsWwfrPGptaf\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Internal Server Error, try later.\", \"success\": false, \"status_code\": 500, \"message_code\": \"internal_server_error\"}', '2025-08-31 12:16:59', '2025-08-31 12:17:00', '2025-08-31 12:16:59', '2025-08-31 12:17:00'),
(84, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_VnbNsxjlwNtuNDYlPFbk\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 04:56:28', '2025-09-01 04:56:30', '2025-09-01 04:56:28', '2025-09-01 04:56:30'),
(85, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_bFwTLftZShswhlljjvbr\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 04:56:30', '2025-09-01 04:56:42', '2025-09-01 04:56:30', '2025-09-01 04:56:42'),
(86, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"error\": \"cURL error 28: Operation timed out after 30011 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check\", \"message\": \"API request failed\", \"success\": false}', '2025-09-01 04:56:42', '2025-09-01 04:57:12', '2025-09-01 04:56:42', '2025-09-01 04:57:12'),
(87, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_rLxhtOklcxweTezuuaPj\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:23:03', '2025-09-01 05:23:04', '2025-09-01 05:23:03', '2025-09-01 05:23:04'),
(88, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_ijDnhcSzfRdohWYRfajN\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:23:04', '2025-09-01 05:23:06', '2025-09-01 05:23:04', '2025-09-01 05:23:06'),
(89, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_kcILErJuozCKhaoxtiyD\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-09-01 05:23:06', '2025-09-01 05:23:30', '2025-09-01 05:23:06', '2025-09-01 05:23:30'),
(90, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_DyldrchpwWzgnnwutCxp\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:23:38', '2025-09-01 05:23:39', '2025-09-01 05:23:38', '2025-09-01 05:23:39'),
(91, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_IjYzpBwqqGqlXvsShwvN\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:23:39', '2025-09-01 05:23:41', '2025-09-01 05:23:39', '2025-09-01 05:23:41'),
(92, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"error\": \"cURL error 28: Operation timed out after 30013 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check\", \"message\": \"API request failed\", \"success\": false}', '2025-09-01 05:23:41', '2025-09-01 05:24:11', '2025-09-01 05:23:41', '2025-09-01 05:24:11');
INSERT INTO `api_call_log` (`id`, `service`, `url`, `request_data`, `status`, `response_data`, `request_time`, `response_time`, `created_at`, `updated_at`) VALUES
(93, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_WDllxOsuXNueggXRPyeY\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:27:10', '2025-09-01 05:27:12', '2025-09-01 05:27:10', '2025-09-01 05:27:12'),
(94, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_hkZzghxurytjzJyElAsi\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:27:12', '2025-09-01 05:27:14', '2025-09-01 05:27:12', '2025-09-01 05:27:14'),
(95, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_ejdlKmbdUxRkrngJlkhU\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-09-01 05:27:14', '2025-09-01 05:27:35', '2025-09-01 05:27:14', '2025-09-01 05:27:35'),
(96, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_blmJtjPnfwbsxgbcZkLe\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:29:50', '2025-09-01 05:29:52', '2025-09-01 05:29:50', '2025-09-01 05:29:52'),
(97, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_GNtvyCQTrpSCCfZgJQbj\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:29:52', '2025-09-01 05:29:54', '2025-09-01 05:29:52', '2025-09-01 05:29:54'),
(98, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"error\": \"cURL error 28: Operation timed out after 30015 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check\", \"message\": \"API request failed\", \"success\": false}', '2025-09-01 05:29:54', '2025-09-01 05:30:24', '2025-09-01 05:29:54', '2025-09-01 05:30:24'),
(99, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_PrTjTJvvDMwhaVcbujDZ\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:31:31', '2025-09-01 05:31:33', '2025-09-01 05:31:31', '2025-09-01 05:31:33'),
(100, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_LxidYTbfLHGBYqZigmGN\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:31:33', '2025-09-01 05:31:36', '2025-09-01 05:31:33', '2025-09-01 05:31:36'),
(101, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_hifvLbvSbcCqThuXlqeh\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-09-01 05:31:36', '2025-09-01 05:31:56', '2025-09-01 05:31:36', '2025-09-01 05:31:56'),
(102, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_xYscyGtqefnhJyETZNvY\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:33:22', '2025-09-01 05:33:23', '2025-09-01 05:33:22', '2025-09-01 05:33:23'),
(103, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_clZwtufNcatOzUtyRerI\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:33:23', '2025-09-01 05:33:25', '2025-09-01 05:33:23', '2025-09-01 05:33:25'),
(104, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_gtCPXSfbatbXuVnRHNWw\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-09-01 05:33:25', '2025-09-01 05:33:46', '2025-09-01 05:33:25', '2025-09-01 05:33:46'),
(105, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_ipaOalJlTpghKSBomZwf\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:42:39', '2025-09-01 05:42:40', '2025-09-01 05:42:39', '2025-09-01 05:42:40'),
(106, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_yyCpqZALAhvnNvwdjvxt\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:42:40', '2025-09-01 05:42:43', '2025-09-01 05:42:40', '2025-09-01 05:42:43'),
(107, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_LebtZqlXJQkmmfTOTvnv\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-09-01 05:42:43', '2025-09-01 05:42:51', '2025-09-01 05:42:43', '2025-09-01 05:42:51'),
(108, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_lCvfwbbpwBdqiqtubgad\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:44:10', '2025-09-01 05:44:11', '2025-09-01 05:44:10', '2025-09-01 05:44:11'),
(109, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_BhrNtmvEeMCeovWPOkUb\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:44:11', '2025-09-01 05:44:13', '2025-09-01 05:44:11', '2025-09-01 05:44:13'),
(110, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_uyGyACnbwXtydkvupEyi\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Internal Server Error, try later.\", \"success\": false, \"status_code\": 500, \"message_code\": \"internal_server_error\"}', '2025-09-01 05:44:13', '2025-09-01 05:44:19', '2025-09-01 05:44:13', '2025-09-01 05:44:19'),
(111, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_oswlXjeZnmWnunPsopqn\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:46:02', '2025-09-01 05:46:04', '2025-09-01 05:46:02', '2025-09-01 05:46:04'),
(112, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_mxCWNUQjySkclmmGOqTF\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:46:04', '2025-09-01 05:46:07', '2025-09-01 05:46:04', '2025-09-01 05:46:07'),
(113, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_XdcJqQjidlqziSBLRJtc\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Internal Server Error, try later.\", \"success\": false, \"status_code\": 500, \"message_code\": \"internal_server_error\"}', '2025-09-01 05:46:07', '2025-09-01 05:46:17', '2025-09-01 05:46:07', '2025-09-01 05:46:17'),
(114, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AFLFS3149E1ZZ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AFLFS3149E1ZZ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_bEdwTHyvcHsZaDityEpa\", \"less_info\": false, \"promoters\": [\"RISHABHKUMAR GAYAPRASAD JAIN \", \"ADIKUMAR RISHABHKUMAR JAIN \", \"JIKISHA JAIN \"], \"legal_name\": \"SWARNIM INFRA LLP\", \"pan_number\": \"AFLFS3149E\", \"gstin_status\": \"Active\", \"business_name\": \"SWARNIM INFRA LLP\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"NA\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"20, WORLD BUSINESS HOUSE, NR. PARIMAL GARDEN, Ellis Bridge, Ahmedabad, Ahmedabad, Gujarat, 380006\", \"nature_of_business\": \"Office / Sale Office, Supplier of Services, Works Contract, Recipient of Goods or Services\"}, \"additional\": []}, \"einvoice_status\": false, \"filing_frequency\": [], \"aadhaar_validation\": \"Yes\", \"annual_turnover_fy\": \"\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 10 (Ahmedabad)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VII - SATELLITE,Range - RANGE IV (Jurisdictional Office)\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2025-04-10\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Office / Sale Office\", \"Supplier of Services\", \"Works Contract\", \"Recipient of Goods or Services\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"2025-05-10\", \"constitution_of_business\": \"Limited Liability Partnership\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:49:26', '2025-09-01 05:49:28', '2025-09-01 05:49:26', '2025-09-01 05:49:28'),
(115, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"SWARNIM INFRA LLP\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_wzyOyLbSVwrdziMoSaag\", \"company_list\": [{\"cin_number\": \"AAI-6018\", \"company_name\": \"SWARNIM VYAPAAR LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAJ-0144\", \"company_name\": \"SWARNIM SUPPLIERS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAO-0047\", \"company_name\": \"SWARNIM AUTO LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAS-2651\", \"company_name\": \"SWARNIM HOMES LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-5787\", \"company_name\": \"SWARNIM GOODS LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAX-8239\", \"company_name\": \"SWARNIM BHOOMI LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"AAY-3651\", \"company_name\": \"SWARNIM ENGICON LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACB-9301\", \"company_name\": \"SWARNIM REALTY LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACC-0132\", \"company_name\": \"SWARNIM BUILDHOME LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"ACH-5587\", \"company_name\": \"SWARNIM ELYSIUM INFRA LLP\", \"company_type\": \"llp\"}], \"company_name_search\": \"SWARNIM INFRA LLP\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 05:49:28', '2025-09-01 05:49:30', '2025-09-01 05:49:28', '2025-09-01 05:49:30'),
(116, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AFLFS3149E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_gfnhhCrjXoUsLzckTfcQ\", \"pan_number\": \"AFLFS3149E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Internal Server Error, try later.\", \"success\": false, \"status_code\": 500, \"message_code\": \"internal_server_error\"}', '2025-09-01 05:49:30', '2025-09-01 05:49:36', '2025-09-01 05:49:30', '2025-09-01 05:49:36'),
(117, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_YmppwFcbaLiMwSGVOApp\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 07:52:11', '2025-09-01 07:52:16', '2025-09-01 07:52:11', '2025-09-01 07:52:16'),
(118, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AXVPJ6876H\"}', 'success', '{\"data\": {\"category\": \"person\", \"client_id\": \"pan_seOmokIzjmOlHtharjzu\", \"full_name\": \"LOVE RISHABH JAIN\", \"pan_number\": \"AXVPJ6876H\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 07:52:16', '2025-09-01 07:52:25', '2025-09-01 07:52:16', '2025-09-01 07:52:25'),
(119, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_eHCGfevgEFmpfIYoUyvr\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 08:01:27', '2025-09-01 08:01:32', '2025-09-01 08:01:27', '2025-09-01 08:01:32'),
(120, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AXVPJ6876H\"}', 'success', '{\"data\": {\"category\": \"person\", \"client_id\": \"pan_ypEmhjxNpiyzixLftkgb\", \"full_name\": \"LOVE RISHABH JAIN\", \"pan_number\": \"AXVPJ6876H\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 08:01:32', '2025-09-01 08:01:34', '2025-09-01 08:01:32', '2025-09-01 08:01:34'),
(121, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_raxfUiXyVnwNmehsMUKb\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 08:08:00', '2025-09-01 08:08:01', '2025-09-01 08:08:00', '2025-09-01 08:08:01'),
(122, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_QfxwlkwwnlqjvxrRiYLl\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 08:08:01', '2025-09-01 08:08:10', '2025-09-01 08:08:01', '2025-09-01 08:08:10'),
(123, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_MfdIvaszgyfnHDvnhfkq\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-09-01 08:08:10', '2025-09-01 08:08:12', '2025-09-01 08:08:10', '2025-09-01 08:08:12'),
(124, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_zOcqzMEFVGfEnpfboZsT\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 08:09:00', '2025-09-01 08:09:01', '2025-09-01 08:09:00', '2025-09-01 08:09:01'),
(125, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_MhgTrzjTyCnqiqKlksIn\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 08:09:01', '2025-09-01 08:09:03', '2025-09-01 08:09:01', '2025-09-01 08:09:03'),
(126, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_wVaocsaAuvemesFQqghT\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-09-01 08:09:03', '2025-09-01 08:09:06', '2025-09-01 08:09:03', '2025-09-01 08:09:06');
INSERT INTO `api_call_log` (`id`, `service`, `url`, `request_data`, `status`, `response_data`, `request_time`, `response_time`, `created_at`, `updated_at`) VALUES
(127, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_wCZJPljqqEzbsivoBfaI\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:04:19', '2025-09-01 12:04:21', '2025-09-01 12:04:19', '2025-09-01 12:04:21'),
(128, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AXVPJ6876H\"}', 'success', '{\"data\": {\"category\": \"person\", \"client_id\": \"pan_eiszFxoEZQcjWCDMHMfF\", \"full_name\": \"LOVE RISHABH JAIN\", \"pan_number\": \"AXVPJ6876H\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:04:21', '2025-09-01 12:04:23', '2025-09-01 12:04:21', '2025-09-01 12:04:23'),
(129, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_ykwOANVVshAAryxpGraa\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:04:46', '2025-09-01 12:04:47', '2025-09-01 12:04:46', '2025-09-01 12:04:47'),
(130, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AXVPJ6876H\"}', 'success', '{\"data\": {\"category\": \"person\", \"client_id\": \"pan_PlmIHdHjwVKqZyhXLfYh\", \"full_name\": \"LOVE RISHABH JAIN\", \"pan_number\": \"AXVPJ6876H\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:04:47', '2025-09-01 12:04:48', '2025-09-01 12:04:47', '2025-09-01 12:04:48'),
(131, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"24AXVPJ6876H1ZQ\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"24AXVPJ6876H1ZQ\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_drVuervokYJrgntIbexc\", \"less_info\": false, \"promoters\": [\"LOVE RISHABH JAIN \"], \"legal_name\": \"LOVEKUMAR RISHABHKUMAR JAIN\", \"pan_number\": \"AXVPJ6876H\", \"gstin_status\": \"Active\", \"business_name\": \"RATNAMANI INDUSTRIES\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 0 to 40 lakhs\", \"contact_details\": {\"principal\": {\"email\": \"anjalpatel48@gmail.com\", \"mobile\": \"9978955814\", \"address\": \"SECOND FLOOR, OFFICE NO. 20, WORLD BUSSINESS CENTER, NR PARIMAL GARDEN, AMBAWADI, Ahmedabad, Gujarat, 380015\", \"nature_of_business\": \"Wholesale Business, Factory / Manufacturing, Retail Business\"}, \"additional\": []}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Gujarat,Division - Division - 1,Range - Range - 3,Unit - Ghatak 9 (Ahmedabad) (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - AHMEDABAD,Commissionerate - AHMEDABAD SOUTH,Division - DIVISION-VI - VASTRAPUR,Range - RANGE III\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Wholesale Business\", \"Factory / Manufacturing\", \"Retail Business\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Proprietorship\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"MFT\", \"nature_of_core_business_activity_description\": \"Manufacturer\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:05:45', '2025-09-01 12:05:47', '2025-09-01 12:05:45', '2025-09-01 12:05:47'),
(132, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AXVPJ6876H\"}', 'success', '{\"data\": {\"category\": \"person\", \"client_id\": \"pan_MVSuCceaxeaxeIThCxNB\", \"full_name\": \"LOVE RISHABH JAIN\", \"pan_number\": \"AXVPJ6876H\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:05:47', '2025-09-01 12:05:48', '2025-09-01 12:05:47', '2025-09-01 12:05:48'),
(133, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"RATNAMANI INDUSTRIES\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_NkSMTFSruZWqlemermCU\", \"company_list\": [{\"cin_number\": \"AAJ-2198\", \"company_name\": \"RATNAMANI BUILDSPACE LLP\", \"company_type\": \"llp\"}, {\"cin_number\": \"U01112MH2022PTC394294\", \"company_name\": \"RATNAKANT AGRO INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U25209GJ2021PTC124772\", \"company_name\": \"RATNAMANI PLASTCRAFT INDUSTRIES INDIA PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U34300MH2020PTC340264\", \"company_name\": \"RATNAMANI TRADELINK PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U36100MP2014PTC033183\", \"company_name\": \"RATNAMANI INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51909PN2017PTC172662\", \"company_name\": \"RATNAMANI STAINLESS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U67190OR2019PLN032145\", \"company_name\": \"RATNAMANI NIDHI LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U70100MH2020PTC337320\", \"company_name\": \"RATNAMANI VENTURES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U88900MH2024NPL424278\", \"company_name\": \"RATNAMAN FOUNDATION\", \"company_type\": \"other\"}, {\"cin_number\": \"U99999GJ1985PTC007954\", \"company_name\": \"RATNAMANI TUBE INDUSTRIES PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}], \"company_name_search\": \"RATNAMANI INDUSTRIES\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:05:48', '2025-09-01 12:05:57', '2025-09-01 12:05:48', '2025-09-01 12:05:57'),
(134, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AXVPJ6876H\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_VwpFmnAhijvZeRxylTtp\", \"pan_number\": \"AXVPJ6876H\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Invalid PAN Number.\", \"success\": false, \"status_code\": 422, \"message_code\": \"verification_failed\"}', '2025-09-01 12:05:57', '2025-09-01 12:06:01', '2025-09-01 12:05:57', '2025-09-01 12:06:01'),
(135, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_bflxnWvVvLQBcfGuZCki\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:06:59', '2025-09-01 12:07:00', '2025-09-01 12:06:59', '2025-09-01 12:07:00'),
(136, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"category\": \"company\", \"client_id\": \"pan_orYorhVKkVJcCRDMtlez\", \"full_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:07:00', '2025-09-01 12:07:02', '2025-09-01 12:07:00', '2025-09-01 12:07:02'),
(137, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'failed', '{\"data\": null, \"error\": null, \"message\": \"Internal Server Error Occurred\", \"success\": false, \"status_code\": 500, \"message_code\": \"contact_support\"}', '2025-09-01 12:07:02', '2025-09-01 12:07:04', '2025-09-01 12:07:02', '2025-09-01 12:07:04'),
(138, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'failed', '{\"data\": {\"client_id\": \"pan_udyam_check_ulgjimQPctxbdeCyfNqs\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": false, \"migration_status\": null}, \"message\": \"Internal Server Error, try later.\", \"success\": false, \"status_code\": 500, \"message_code\": \"internal_server_error\"}', '2025-09-01 12:07:04', '2025-09-01 12:07:05', '2025-09-01 12:07:04', '2025-09-01 12:07:05'),
(139, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_NrNuRnrbaNfVMVrKTywO\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:07:17', '2025-09-01 12:07:18', '2025-09-01 12:07:17', '2025-09-01 12:07:18'),
(140, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"category\": \"company\", \"client_id\": \"pan_eTpXiBnMTaUJIPccSgLq\", \"full_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-01 12:07:18', '2025-09-01 12:07:18', '2025-09-01 12:07:18', '2025-09-01 12:07:18'),
(141, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_vzwyWzRvqcEbVIZHjcox\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-02 04:53:28', '2025-09-02 04:53:30', '2025-09-02 04:53:28', '2025-09-02 04:53:30'),
(142, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"category\": \"company\", \"client_id\": \"pan_EYpXsihuGWLAIsLxMCxc\", \"full_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-02 04:53:30', '2025-09-02 04:53:31', '2025-09-02 04:53:30', '2025-09-02 04:53:31'),
(143, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_brZybuVZBhfvUwszjNFi\", \"company_list\": [{\"cin_number\": \"L05005TG1992PLC014678\", \"company_name\": \"NCC BLUE WATER PRODUCTS LTD.\", \"company_type\": \"other\"}, {\"cin_number\": \"U26921WB1981PTC033577\", \"company_name\": \"HKC TECHIND PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U45200TG2004PLC043015\", \"company_name\": \"GKC PROJECTS LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U45202DL2003PTC121288\", \"company_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51109WB1994PTC065109\", \"company_name\": \"NAC TRAVELS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U72200WB2006PTC109866\", \"company_name\": \"NKA COMMERCIAL PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1991PTC052784\", \"company_name\": \"NKB FINANCIAL SERVICES PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1993PTC059795\", \"company_name\": \"AKC CONSULTANCY PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74210WB1965PTC026506\", \"company_name\": \"N.C. ENGINEERS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74899DL1988PLC032808\", \"company_name\": \"NEC INDUSTRIAL PROJECTS LTD\", \"company_type\": \"other\"}], \"company_name_search\": \"NKC PROJECTS PVT LTD\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-02 04:53:31', '2025-09-02 04:53:44', '2025-09-02 04:53:31', '2025-09-02 04:53:44'),
(144, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'failed', '{\"error\": \"cURL error 28: Operation timed out after 30012 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check\", \"message\": \"API request failed\", \"success\": false}', '2025-09-02 04:53:44', '2025-09-02 04:54:14', '2025-09-02 04:53:44', '2025-09-02 04:54:14'),
(145, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_bGlvwednnktGHIwcfLfd\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-02 05:04:01', '2025-09-02 05:04:03', '2025-09-02 05:04:01', '2025-09-02 05:04:03'),
(146, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"category\": \"company\", \"client_id\": \"pan_sCjdggUmrwCwfiqtwYUa\", \"full_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-02 05:04:03', '2025-09-02 05:04:09', '2025-09-02 05:04:03', '2025-09-02 05:04:09'),
(147, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_tdqSpVsHlhpvhGKnxijj\", \"company_list\": [{\"cin_number\": \"L05005TG1992PLC014678\", \"company_name\": \"NCC BLUE WATER PRODUCTS LTD.\", \"company_type\": \"other\"}, {\"cin_number\": \"U26921WB1981PTC033577\", \"company_name\": \"HKC TECHIND PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U45200TG2004PLC043015\", \"company_name\": \"GKC PROJECTS LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U45202DL2003PTC121288\", \"company_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51109WB1994PTC065109\", \"company_name\": \"NAC TRAVELS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U72200WB2006PTC109866\", \"company_name\": \"NKA COMMERCIAL PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1991PTC052784\", \"company_name\": \"NKB FINANCIAL SERVICES PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1993PTC059795\", \"company_name\": \"AKC CONSULTANCY PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74210WB1965PTC026506\", \"company_name\": \"N.C. ENGINEERS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74899DL1988PLC032808\", \"company_name\": \"NEC INDUSTRIAL PROJECTS LTD\", \"company_type\": \"other\"}], \"company_name_search\": \"NKC PROJECTS PVT LTD\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-02 05:04:09', '2025-09-02 05:04:21', '2025-09-02 05:04:09', '2025-09-02 05:04:21'),
(148, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'failed', '{\"error\": \"cURL error 28: Operation timed out after 30016 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check\", \"message\": \"API request failed\", \"success\": false}', '2025-09-02 05:04:21', '2025-09-02 05:04:51', '2025-09-02 05:04:21', '2025-09-02 05:04:51'),
(149, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_xXuuzykkufchpruRvgua\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:30:24', '2025-09-17 09:30:26', '2025-09-17 09:30:24', '2025-09-17 09:30:26'),
(150, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"category\": \"company\", \"client_id\": \"pan_VcKoHDNOCTxvcVoRJXuv\", \"full_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:30:26', '2025-09-17 09:30:27', '2025-09-17 09:30:26', '2025-09-17 09:30:27'),
(151, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'failed', '{\"error\": \"cURL error 28: Operation timed out after 30015 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list\", \"message\": \"API request failed\", \"success\": false}', '2025-09-17 09:30:27', '2025-09-17 09:30:57', '2025-09-17 09:30:27', '2025-09-17 09:30:57'),
(152, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_BajzYapHcpogpdwnIUsM\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": true, \"migration_status\": \"not_migrated\"}, \"message\": \"success\", \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:30:57', '2025-09-17 09:30:59', '2025-09-17 09:30:57', '2025-09-17 09:30:59'),
(153, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_oNJZrzgFwbyeufGkwmYg\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:39:23', '2025-09-17 09:39:24', '2025-09-17 09:39:23', '2025-09-17 09:39:24'),
(154, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"category\": \"company\", \"client_id\": \"pan_EBqxWesUrLooKkJAsAuC\", \"full_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:39:24', '2025-09-17 09:39:24', '2025-09-17 09:39:24', '2025-09-17 09:39:24'),
(155, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'failed', '{\"error\": \"cURL error 28: Operation timed out after 30004 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list\", \"message\": \"API request failed\", \"success\": false}', '2025-09-17 09:39:24', '2025-09-17 09:39:55', '2025-09-17 09:39:24', '2025-09-17 09:39:55'),
(156, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_phfggIKYWjJwqgcMVUKt\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": true, \"migration_status\": \"not_migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:39:55', '2025-09-17 09:39:55', '2025-09-17 09:39:55', '2025-09-17 09:39:55'),
(157, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_bWczqJOFdscautnbODUg\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:40:00', '2025-09-17 09:40:01', '2025-09-17 09:40:00', '2025-09-17 09:40:01'),
(158, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"category\": \"company\", \"client_id\": \"pan_ekpniUVQiPTctMEQeptl\", \"full_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:40:01', '2025-09-17 09:40:01', '2025-09-17 09:40:01', '2025-09-17 09:40:01'),
(159, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_btsOoHUetInlvWodQAqY\", \"company_list\": [{\"cin_number\": \"L05005TG1992PLC014678\", \"company_name\": \"NCC BLUE WATER PRODUCTS LTD.\", \"company_type\": \"other\"}, {\"cin_number\": \"U26921WB1981PTC033577\", \"company_name\": \"HKC TECHIND PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U45200TG2004PLC043015\", \"company_name\": \"GKC PROJECTS LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U45202DL2003PTC121288\", \"company_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51109WB1994PTC065109\", \"company_name\": \"NAC TRAVELS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U72200WB2006PTC109866\", \"company_name\": \"NKA COMMERCIAL PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1991PTC052784\", \"company_name\": \"NKB FINANCIAL SERVICES PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1993PTC059795\", \"company_name\": \"AKC CONSULTANCY PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74210WB1965PTC026506\", \"company_name\": \"N.C. ENGINEERS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74899DL1988PLC032808\", \"company_name\": \"NEC INDUSTRIAL PROJECTS LTD\", \"company_type\": \"other\"}], \"company_name_search\": \"NKC PROJECTS PVT LTD\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:40:01', '2025-09-17 09:40:03', '2025-09-17 09:40:01', '2025-09-17 09:40:03'),
(160, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_cxcqvyYOYijJslErmWpo\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": true, \"migration_status\": \"not_migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:40:03', '2025-09-17 09:40:03', '2025-09-17 09:40:03', '2025-09-17 09:40:03'),
(161, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_ypufRtwmsaBdrMjYNwie\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:40:21', '2025-09-17 09:40:22', '2025-09-17 09:40:21', '2025-09-17 09:40:22'),
(162, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"category\": \"company\", \"client_id\": \"pan_XTnVbtOlQnAUnjcLpWzr\", \"full_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:40:22', '2025-09-17 09:40:23', '2025-09-17 09:40:22', '2025-09-17 09:40:23');
INSERT INTO `api_call_log` (`id`, `service`, `url`, `request_data`, `status`, `response_data`, `request_time`, `response_time`, `created_at`, `updated_at`) VALUES
(163, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_IdyHfinRfhJwIrFLgJvG\", \"company_list\": [{\"cin_number\": \"L05005TG1992PLC014678\", \"company_name\": \"NCC BLUE WATER PRODUCTS LTD.\", \"company_type\": \"other\"}, {\"cin_number\": \"U26921WB1981PTC033577\", \"company_name\": \"HKC TECHIND PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U45200TG2004PLC043015\", \"company_name\": \"GKC PROJECTS LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U45202DL2003PTC121288\", \"company_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51109WB1994PTC065109\", \"company_name\": \"NAC TRAVELS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U72200WB2006PTC109866\", \"company_name\": \"NKA COMMERCIAL PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1991PTC052784\", \"company_name\": \"NKB FINANCIAL SERVICES PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1993PTC059795\", \"company_name\": \"AKC CONSULTANCY PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74210WB1965PTC026506\", \"company_name\": \"N.C. ENGINEERS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74899DL1988PLC032808\", \"company_name\": \"NEC INDUSTRIAL PROJECTS LTD\", \"company_type\": \"other\"}], \"company_name_search\": \"NKC PROJECTS PVT LTD\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:40:23', '2025-09-17 09:40:25', '2025-09-17 09:40:23', '2025-09-17 09:40:25'),
(164, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_gQdpMZvoVfuIcnrikmWI\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": true, \"migration_status\": \"not_migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:40:25', '2025-09-17 09:40:26', '2025-09-17 09:40:25', '2025-09-17 09:40:26'),
(165, 'surepass-ValidateGSTIN', 'https://kyc-api.surepass.app/api/v1/corporate/gstin-advanced', '{\"id_number\": \"06AACCN4070E1ZT\"}', 'success', '{\"data\": {\"fy\": null, \"gstin\": \"06AACCN4070E1ZT\", \"address\": null, \"hsn_info\": [], \"client_id\": \"corporate_gstin_advanced_jxyjTZlkUmespxGYKytY\", \"less_info\": false, \"promoters\": [\"NARESH  KUMAR \", \"ROHIT KUMAR GUPTA \", \"JAI KUMAR GARG \", \"PREMWATI \"], \"legal_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\", \"gstin_status\": \"Active\", \"business_name\": \"NKC PROJECTS PVT LTD\", \"filing_status\": [], \"taxpayer_type\": \"Regular\", \"address_details\": [], \"annual_turnover\": \"Slab: Rs. 500 Cr. and above\", \"contact_details\": {\"principal\": {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016\", \"nature_of_business\": \"Works Contract, Others\"}, \"additional\": [{\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No 525, Khewat No 420, Kila No 10/2,11,12,19,20,21,22,23, Village Thau, Tehsil Alewa, Jind, Haryana, 126111\", \"nature_of_business\": \"Works Contract, Recipient of Goods or Services, Office / Sale Office, Supplier of Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"Khatoni No. 505, Khewat No. 413, Killa No. 9,10,11,12,19/1,20/1, Tehsil Kalayat, Village Chaushala, Kaithal, Haryana, 136117\", \"nature_of_business\": \"Works Contract, Office / Sale Office, Recipient of Goods or Services\"}, {\"email\": \"arun@nkcproject.com\", \"mobile\": \"9268579832\", \"address\": \"KHEWAT NO. 418/1/332, SH 15A, JHAJJAR FARRUKHNAGR ROAD, Silani Pana Zalim, Jhajjar, Haryana, 124103\", \"nature_of_business\": \"Warehouse / Depot\"}]}, \"einvoice_status\": true, \"filing_frequency\": [], \"aadhaar_validation\": \"No\", \"annual_turnover_fy\": \"2024-2025\", \"percentage_in_cash\": \"NA\", \"state_jurisdiction\": \"State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)\", \"center_jurisdiction\": \"State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1\", \"date_of_cancellation\": \"1800-01-01\", \"date_of_registration\": \"2017-07-01\", \"field_visit_conducted\": \"No\", \"nature_bus_activities\": [\"Works Contract\", \"Others\", \"Recipient of Goods or Services\", \"Office / Sale Office\", \"Supplier of Services\", \"Warehouse / Depot\"], \"percentage_in_cash_fy\": \"\", \"aadhaar_validation_date\": \"1800-01-01\", \"constitution_of_business\": \"Private Limited Company\", \"liability_percentage_details\": [], \"nature_of_core_business_activity_code\": \"SPO\", \"nature_of_core_business_activity_description\": \"Service Provider and Others\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:41:57', '2025-09-17 09:41:58', '2025-09-17 09:41:57', '2025-09-17 09:41:58'),
(166, 'surepass-ValidatePAN', 'https://kyc-api.surepass.app/api/v1/pan/pan', '{\"id_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"category\": \"company\", \"client_id\": \"pan_cprBcKcwdaBfLoouTvSJ\", \"full_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"pan_number\": \"AACCN4070E\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:41:58', '2025-09-17 09:41:59', '2025-09-17 09:41:58', '2025-09-17 09:41:59'),
(167, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/name-to-cin-list', '{\"company_name_search\": \"NKC PROJECTS PVT LTD\"}', 'success', '{\"data\": {\"client_id\": \"corporate_name_list_KTFneuwycmXqcpWedQGw\", \"company_list\": [{\"cin_number\": \"L05005TG1992PLC014678\", \"company_name\": \"NCC BLUE WATER PRODUCTS LTD.\", \"company_type\": \"other\"}, {\"cin_number\": \"U26921WB1981PTC033577\", \"company_name\": \"HKC TECHIND PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U45200TG2004PLC043015\", \"company_name\": \"GKC PROJECTS LIMITED\", \"company_type\": \"ltd\"}, {\"cin_number\": \"U45202DL2003PTC121288\", \"company_name\": \"NKC PROJECTS PRIVATE LIMITED\", \"company_type\": \"pvt_ltd\"}, {\"cin_number\": \"U51109WB1994PTC065109\", \"company_name\": \"NAC TRAVELS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U72200WB2006PTC109866\", \"company_name\": \"NKA COMMERCIAL PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1991PTC052784\", \"company_name\": \"NKB FINANCIAL SERVICES PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74140WB1993PTC059795\", \"company_name\": \"AKC CONSULTANCY PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74210WB1965PTC026506\", \"company_name\": \"N.C. ENGINEERS PVT LTD\", \"company_type\": \"other\"}, {\"cin_number\": \"U74899DL1988PLC032808\", \"company_name\": \"NEC INDUSTRIAL PROJECTS LTD\", \"company_type\": \"other\"}], \"company_name_search\": \"NKC PROJECTS PVT LTD\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:41:59', '2025-09-17 09:42:01', '2025-09-17 09:41:59', '2025-09-17 09:42:01'),
(168, 'surepass-ValidateCIN', 'https://kyc-api.surepass.app/api/v1/corporate/pan-udyam-check', '{\"enrich\": \"true\", \"pan_number\": \"AACCN4070E\"}', 'success', '{\"data\": {\"client_id\": \"pan_udyam_check_FCrwhrwtWdYGhftdafkr\", \"pan_number\": \"AACCN4070E\", \"udyam_exists\": true, \"migration_status\": \"not_migrated\"}, \"message\": null, \"success\": true, \"status_code\": 200, \"message_code\": \"success\"}', '2025-09-17 09:42:01', '2025-09-17 09:42:01', '2025-09-17 09:42:01', '2025-09-17 09:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `authorized_people`
--

DROP TABLE IF EXISTS `authorized_people`;
CREATE TABLE IF NOT EXISTS `authorized_people` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_company_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authorized_people`
--

INSERT INTO `authorized_people` (`id`, `supplier_company_id`, `name`, `email`, `mobile`, `created_at`, `updated_at`) VALUES
(1, 1, 'test', 'tewerwe@gmail.com', '1231231231', '2023-12-29 04:21:57', '2023-12-29 04:21:57'),
(2, 2, 'Luv Jain', 'luv.jain@vivasvannaexports.com', '9978955809', '2024-01-09 11:02:54', '2024-01-09 11:02:54'),
(3, 2, 'Anjal Patel', 'accounts@vivasvannaexports.com', '9978955814', '2024-01-09 11:02:54', '2024-01-09 11:02:54'),
(4, 3, 'AMIT', 'INFO.AMITWAXUDYOG@GMAIL.COM', '9831023121', '2024-01-09 11:05:45', '2024-01-09 11:05:45'),
(5, 4, 'DAILY WAY', 'petro@dailyway.in', '9036902902', '2024-04-04 12:04:13', '2024-04-04 12:04:13'),
(6, 5, 'luv jain', 'luv.jain@vivasvannaexports.com', '9978955809', '2024-05-20 12:08:17', '2024-05-20 12:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'State Bank Of India', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(2, 'Bank Of Baroda', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(3, 'Axis Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(4, 'HDFC Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(5, 'Equitas Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(6, 'Kotak Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(7, 'Indusind Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(8, 'Canara Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(9, 'Bank of Maharashtra', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(10, 'Central Bank of India', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(11, 'Indian Overseas Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(12, 'Indian Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(13, 'Punjab and Sind Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(14, 'Punjab National Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(15, 'UCO Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(16, 'Union Bank of India', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(17, 'Bandhan Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(18, 'CSB Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(19, 'City Union Bank	', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(20, 'DCB Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(21, 'Dhanlaxmi Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(22, 'Federal Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(23, 'ICICI Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(24, 'IDFC First', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(25, 'IDBI Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(26, 'Jammu & Kashmir Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(27, 'Karur Vysya Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(28, 'RBL Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55'),
(29, 'South Indian Bank', '2024-03-09 07:28:55', '2024-03-09 07:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `boqs`
--

DROP TABLE IF EXISTS `boqs`;
CREATE TABLE IF NOT EXISTS `boqs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` int NOT NULL,
  `project_id` int NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `boqs`
--

INSERT INTO `boqs` (`id`, `name`, `client_id`, `project_id`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'bitumen', 19, 10, 1, 0, '2025-08-26 10:12:45', '2025-08-26 10:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `boq_items`
--

DROP TABLE IF EXISTS `boq_items`;
CREATE TABLE IF NOT EXISTS `boq_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `boq_id` int NOT NULL,
  `category_id` int NOT NULL,
  `variation_id` int NOT NULL,
  `qty` double(10,2) NOT NULL,
  `remaining_qty` double(10,2) DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `boq_items`
--

INSERT INTO `boq_items` (`id`, `boq_id`, `category_id`, `variation_id`, `qty`, `remaining_qty`, `unit`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 13, 5000.00, 5000.00, 'MT', 1, 0, '2025-08-26 10:23:02', '2025-08-26 10:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `client_companies`
--

DROP TABLE IF EXISTS `client_companies`;
CREATE TABLE IF NOT EXISTS `client_companies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int NOT NULL,
  `director_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `msme_register` tinyint(1) NOT NULL DEFAULT '0',
  `turnover` tinyint NOT NULL COMMENT '0 = below 50cr, 1 = 50cr-150cr, 2 = 150cr-250cr, 3 = 250cr-500cr, 4 = 500cr-1000cr, 5 = above 1000 cr',
  `credit_amount` double(10,2) DEFAULT NULL,
  `interest_rate` double(10,2) DEFAULT NULL,
  `tolerance` double(10,2) DEFAULT NULL,
  `otp` int NOT NULL DEFAULT '0',
  `is_verify` tinyint(1) NOT NULL DEFAULT '0',
  `pan_verify` tinyint(1) NOT NULL DEFAULT '0',
  `gst_by_pan` tinyint(1) NOT NULL DEFAULT '0',
  `cin_verify` tinyint(1) NOT NULL DEFAULT '0',
  `msme_verify` tinyint(1) NOT NULL DEFAULT '0',
  `is_credit_req` tinyint(1) NOT NULL DEFAULT '0',
  `is_terms_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `is_auto_password` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = manual, 1 = auto-generated',
  `is_active` tinyint NOT NULL DEFAULT '0',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_companies`
--

INSERT INTO `client_companies` (`id`, `uuid`, `company_name`, `address`, `state_id`, `director_name`, `mobile_number`, `email`, `password`, `gstn`, `cin`, `pan_number`, `msme_register`, `turnover`, `credit_amount`, `interest_rate`, `tolerance`, `otp`, `is_verify`, `pan_verify`, `gst_by_pan`, `cin_verify`, `msme_verify`, `is_credit_req`, `is_terms_accepted`, `is_auto_password`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(26, 'c583d3db-ccab-4985-8e52-494e063c5992', 'NKC PROJECTS PVT LTD', 'THIRD FLOOR, 872, UDYOG VIHAR, PHASE-V, GURGAON, Gurugram, Haryana, 122016', 6, 'ROHIT KUMAR GUPTA', '9268579832', 'arun@nkcproject.com', '$2y$12$gRBwJT9CcFPkeYIqKSgk6uygoVWkOUqJspd5oom.u9GJOUilZZt8u', '06AACCN4070E1ZT', 'U45202DL2003PTC121288', 'AACCN4070E', 1, 1, NULL, NULL, NULL, 0, 1, 0, 0, 1, 0, 0, 1, 0, 1, 0, '2025-09-17 09:42:22', '2025-09-17 09:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `client_companies_old`
--

DROP TABLE IF EXISTS `client_companies_old`;
CREATE TABLE IF NOT EXISTS `client_companies_old` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int NOT NULL,
  `director_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_amount` double(10,2) DEFAULT NULL,
  `interest_rate` double(10,2) DEFAULT NULL,
  `tolerance` double(10,2) DEFAULT NULL,
  `is_verify` tinyint(1) NOT NULL DEFAULT '0',
  `is_credit_req` tinyint(1) NOT NULL DEFAULT '0',
  `is_terms_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint NOT NULL DEFAULT '0',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_companies_old`
--

INSERT INTO `client_companies_old` (`id`, `uuid`, `company_name`, `address`, `state_id`, `director_name`, `mobile_number`, `email`, `password`, `gstn`, `cin`, `pan_number`, `credit_amount`, `interest_rate`, `tolerance`, `is_verify`, `is_credit_req`, `is_terms_accepted`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, '5be44198-f3d0-436b-98f5-f9cbf8d7ef64', '123', '123', 1, '1233', '1231213123', '23123123@gmail.com', NULL, '121313123123123', '1231231231231', 'ASDASDASDA', NULL, NULL, NULL, 0, 0, 0, 0, 1, '2023-12-27 04:58:23', '2024-01-24 11:05:21'),
(2, '3830175a-f4cc-448c-b8b3-101a893650d6', 'CDS INFRAPROJECTS LTD', 'DELHI', 25, 'SANDEEP CHANDRA', '9999988888', 'MD@CDSINFRA.COM', NULL, '24AXAVPJ617H1ZL', '24AXVPJ617H1ZL', '24AXVPJ617', 5000000.00, 18.00, 5.00, 0, 0, 1, 1, 0, '2024-01-10 10:24:58', '2024-12-02 07:35:52'),
(3, '7a67743c-9a93-4989-86a1-75f2ec3fea7f', 'NKC PROEJECTS PVT LTD', 'DELHI', 25, 'NARESHKUMAR', '9999988888', 'MD@NKCINFRA.COM', NULL, '24AXVPJ617H11ZL', '24AXVPJ617H11ZL', '24AXVPJ617', 5000000.00, 18.00, 5.00, 0, 0, 0, 1, 0, '2024-01-10 10:29:04', '2024-05-10 10:18:56'),
(4, '4383c26e-c0fd-406f-953a-4de9e51c6bf7', 'K.R.C. INFRAPROJECTS PRIVATE LIMITED', 'Maavel Rahenank Plot No. 171, Moje Bhabharnava, Binkheti R.S No. 255/1/2, Napa Milkat No. 9236', 6, 'ARUN KUMAR CHAUDHARY', '9911200084', 'krcearth@gmail.com', NULL, '24AADCK9076E1ZH', 'U45200HR2010PTC040279', 'HR2010PTC0', 2500000.00, 18.00, 5.00, 0, 0, 0, 1, 0, '2024-05-10 09:46:30', '2024-05-10 10:20:06'),
(5, '2097de44-c629-463f-a562-e7421c00dc25', 'NKC PROJECTS PRIVATE LIMITED - HARYANA SITE', 'Unit No. 154, Vardhman Crown Mall Plot No. 2 Sec-19 Dwarka New Delhi New Delhi DL 110075 IN.', 6, 'NARESHKUMARJI', '9717697587', 'anil.chawla@nkcproject.com', NULL, '06AACCN4070E1ZT', 'U45202DL2003PTC121288', 'AACCN4070E', 2500000.00, 15.00, 0.00, 0, 0, 0, 1, 0, '2024-05-10 09:51:09', '2024-05-10 10:20:04'),
(6, 'e4285f07-e898-4153-b968-095eca7da6b3', 'NKC PROJECTS PRIVATE LIMITED - GUJARAT', 'VILLAGE - HOTLOO, TEHSIL - PACHPADRA, KHASRA NO - 263, BALOTRA, SAMDARI ROAD, DISTRICT - BARMER PIN - 344022', 19, 'NARESH KUMARJI', '9717697587', 'anil.chawla@nkcproject.com', NULL, '08AACCN4070E2ZO', 'U45202DL2003PTC121288', 'AACCN4070E', 2500000.00, 15.00, 0.00, 0, 0, 1, 1, 0, '2024-05-10 09:54:09', '2024-12-02 07:35:44'),
(7, '8e53f056-0da7-45b2-a6bf-b6b4b738506a', 'Test', 'New test', 5, 'Ne wtest', '9876543210', 'test111@gmail.com', NULL, '24DGDGDGDFGDFGD', 'dfgdfg', 'DFGDFGDFGD', NULL, NULL, NULL, 0, 0, 0, 0, 0, '2025-01-28 07:19:05', '2025-01-28 07:19:05'),
(8, 'a642cc0e-2ba7-4c19-b398-9552634d1b9c', 'dgdgd', 'dfgdfgdf', 5, 'sdfsd', '9876987600', 'bb@gmail.com', NULL, '464646456456456', '4645645645', '4564564645', NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-01-28 12:43:14', '2025-01-28 12:45:44'),
(9, 'ae399c48-3703-439b-9fea-78477ded823c', 'dgdgd', 'dfgdfgdf', 5, 'sdfsd', '9876987600', 'bb@gmail.com', NULL, '464646456456456', '4645645645', '4564564645', NULL, NULL, NULL, 0, 0, 0, 0, 1, '2025-01-28 12:43:26', '2025-01-28 12:45:41'),
(10, 'd005547a-91df-447b-871f-87bbe7511469', 'TESTING', 'TESTING', 6, 'TESTING', '543543543543', 'test@test.com', NULL, '27AAAAA0000A1Z6', 'FDGGFD34354FSS', 'AAAAA0000A', NULL, NULL, NULL, 0, 0, 0, 0, 0, '2025-01-28 12:51:58', '2025-01-28 12:51:58');

-- --------------------------------------------------------

--
-- Table structure for table `client_company_authorized_people`
--

DROP TABLE IF EXISTS `client_company_authorized_people`;
CREATE TABLE IF NOT EXISTS `client_company_authorized_people` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_company_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_company_authorized_people`
--

INSERT INTO `client_company_authorized_people` (`id`, `client_company_id`, `name`, `email`, `mobile`, `created_at`, `updated_at`) VALUES
(1, 11, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-29 21:02:13', '2025-08-29 21:02:13'),
(3, 12, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-29 21:33:40', '2025-08-29 21:33:40'),
(5, 14, 'LOVE RISHABH JAIN', 'anjalpatel48@gmail.com', '9978955814', '2025-08-30 02:41:06', '2025-08-30 02:41:06'),
(14, 20, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-31 08:19:37', '2025-08-31 08:19:37'),
(21, 13, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-31 08:43:36', '2025-08-31 08:43:36'),
(22, 13, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 08:43:36', '2025-08-31 08:43:36'),
(23, 21, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-31 08:45:13', '2025-08-31 08:45:13'),
(24, 21, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 08:45:13', '2025-08-31 08:45:13'),
(29, 22, 'RISHABHKUMAR GAYAPRASAD JAIN', 'anjalpatel48@gmail.com', '9978955814', '2025-08-31 11:50:43', '2025-08-31 11:50:43'),
(30, 22, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 11:50:43', '2025-08-31 11:50:43'),
(32, 25, 'RISHABHKUMAR GAYAPRASAD JAIN', 'anjalpatel48@gmail.com', '9978955814', '2025-09-01 05:55:17', '2025-09-01 05:55:17'),
(33, 26, 'ROHIT KUMAR GUPTA', 'arun@nkcproject.com', '9268579832', '2025-09-17 09:42:22', '2025-09-17 09:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `client_company_contacts`
--

DROP TABLE IF EXISTS `client_company_contacts`;
CREATE TABLE IF NOT EXISTS `client_company_contacts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_company_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_company_contacts`
--

INSERT INTO `client_company_contacts` (`id`, `client_company_id`, `name`, `email`, `mobile`, `created_at`, `updated_at`) VALUES
(1, 1, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-28 11:29:46', '2025-08-28 11:29:46'),
(2, 1, 'LADANI JAY', 'jay@yopmail.com', '9537649802', '2025-08-28 11:29:46', '2025-08-28 11:29:46'),
(3, 1, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-28 11:55:54', '2025-08-28 11:55:54'),
(4, 1, 'LADANI Jay Jay Ladani', 'jay@yopmail.com', '9537649802', '2025-08-28 11:55:54', '2025-08-28 11:55:54'),
(5, 2, 'LOVE RISHABH JAIN', 'anjalpatel48@gmail.com', '9978955814', '2025-08-29 02:36:40', '2025-08-29 02:36:40'),
(6, 2, 'LADANI Jay Jay Ladani', 'jay@yopmail.com', '9537649802', '2025-08-29 02:36:40', '2025-08-29 02:36:40'),
(7, 3, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-29 03:12:05', '2025-08-29 03:12:05'),
(8, 3, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 03:12:05', '2025-08-29 03:12:05'),
(9, 4, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-29 03:12:15', '2025-08-29 03:12:15'),
(10, 4, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 03:12:15', '2025-08-29 03:12:15'),
(11, 5, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-29 03:12:39', '2025-08-29 03:12:39'),
(12, 5, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 03:12:39', '2025-08-29 03:12:39'),
(13, 6, 'NARESH  KUMAR', 'arun@nkcproject.com', '9268579832', '2025-08-29 03:13:19', '2025-08-29 03:13:19'),
(14, 6, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 03:13:19', '2025-08-29 03:13:19'),
(15, 7, 'LOVE RISHABH JAIN', 'anjalpatel48@gmail.com', '9978955814', '2025-08-29 06:18:43', '2025-08-29 06:18:43'),
(16, 7, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 06:18:43', '2025-08-29 06:18:43'),
(17, 8, 'LOVE RISHABH JAIN', 'anjalpatel48@gmail.com', '9978955814', '2025-08-29 06:22:31', '2025-08-29 06:22:31'),
(18, 8, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 06:22:31', '2025-08-29 06:22:31'),
(19, 9, 'ROHIT KUMAR GUPTA', 'arun@nkcproject.com', '9268579832', '2025-08-29 06:23:29', '2025-08-29 06:23:29'),
(20, 9, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 06:23:29', '2025-08-29 06:23:29'),
(21, 10, 'LOVE RISHABH JAIN', 'anjalpatel48@gmail.com', '9978955814', '2025-08-29 06:27:30', '2025-08-29 06:27:30'),
(22, 10, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 06:27:30', '2025-08-29 06:27:30'),
(23, 11, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 21:02:13', '2025-08-29 21:02:13'),
(25, 12, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-29 21:33:40', '2025-08-29 21:33:40'),
(27, 14, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-30 02:41:06', '2025-08-30 02:41:06'),
(28, 15, 'ssss', 'jay.ladani003@gmail.com', '9537649802', '2025-08-30 04:30:05', '2025-08-30 04:30:05'),
(29, 15, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-30 04:30:05', '2025-08-30 04:30:05'),
(30, 16, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-30 05:13:44', '2025-08-30 05:13:44'),
(31, 16, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-30 05:13:44', '2025-08-30 05:13:44'),
(72, 20, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 08:19:37', '2025-08-31 08:19:37'),
(83, 13, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 08:43:36', '2025-08-31 08:43:36'),
(84, 13, 'ADIKUMAR RISHABHKUMAR JAIN', 'anjalpatel48@gmail.com', '6351769990', '2025-08-31 08:43:36', '2025-08-31 08:43:36'),
(85, 13, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 08:43:36', '2025-08-31 08:43:36'),
(86, 13, 'LADANI Jay Jay Ladani', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 08:43:36', '2025-08-31 08:43:36'),
(87, 21, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 08:45:13', '2025-08-31 08:45:13'),
(88, 21, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 08:45:13', '2025-08-31 08:45:13'),
(93, 22, 'LADANI JAYs', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 11:50:43', '2025-08-31 11:50:43'),
(94, 22, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 11:50:43', '2025-08-31 11:50:43'),
(95, 23, 'LOVE RISHABH JAIN', 'anjalpatel48@gmail.com', '9978955814', '2025-08-31 12:12:25', '2025-08-31 12:12:25'),
(96, 23, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 12:12:25', '2025-08-31 12:12:25'),
(97, 24, 'LOVE RISHABH JAIN', 'anjalpatel48@gmail.com', '9978955814', '2025-08-31 12:18:28', '2025-08-31 12:18:28'),
(98, 24, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-08-31 12:18:28', '2025-08-31 12:18:28'),
(100, 25, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-09-01 05:55:17', '2025-09-01 05:55:17'),
(101, 26, 'LADANI JAY', 'jay.ladani003@gmail.com', '9537649802', '2025-09-17 09:42:22', '2025-09-17 09:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `client_company_invitations`
--

DROP TABLE IF EXISTS `client_company_invitations`;
CREATE TABLE IF NOT EXISTS `client_company_invitations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_registered` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0=expired, 1=pending, 2=registered',
  `is_master` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = master link',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_company_invitations_token_unique` (`token`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_company_invitations`
--

INSERT INTO `client_company_invitations` (`id`, `email`, `url`, `gstn`, `token`, `is_registered`, `status`, `is_master`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'admin@admin.com', 'http://127.0.0.1:8000/company-register/invitation/df2a873c-2340-445d-a9d4-f15df7f804a11', NULL, 'df2a873c-2340-445d-a9d4-f15df7f804a1', 0, 1, 1, 1, '2025-08-31 05:10:10', '2025-08-31 05:26:25'),
(2, 'jay.ladani003@gmail.com', 'http://127.0.0.1:8000/company-register/invitation/ab61da17-7864-4272-b121-8fbbb9d3d6952', NULL, 'ab61da17-7864-4272-b121-8fbbb9d3d695', 0, 1, 0, 1, '2025-09-01 03:49:23', '2025-09-01 03:49:23'),
(3, 'jagdish@vivasvannaexports.com', 'http://127.0.0.1:8000/company-register/invitation/5156860c-a06b-4b8d-833f-48d303e5a20e3', NULL, '5156860c-a06b-4b8d-833f-48d303e5a20e', 0, 1, 0, 1, '2025-09-01 10:15:26', '2025-09-01 10:15:26');

-- --------------------------------------------------------

--
-- Table structure for table `client_gst_details`
--

DROP TABLE IF EXISTS `client_gst_details`;
CREATE TABLE IF NOT EXISTS `client_gst_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_company_id` bigint UNSIGNED DEFAULT NULL,
  `gstn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nature_of_business` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promoters` json DEFAULT NULL,
  `annual_turnover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `annual_turnover_fy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhaar_validation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aadhaar_validation_date` date DEFAULT NULL,
  `einvoice_status` tinyint(1) NOT NULL DEFAULT '0',
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `legal_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `center_jurisdiction` text COLLATE utf8mb4_unicode_ci,
  `state_jurisdiction` text COLLATE utf8mb4_unicode_ci,
  `date_of_registration` date DEFAULT NULL,
  `constitution_of_business` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taxpayer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gstin_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nature_bus_activities` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_gst_details_client_company_id_foreign` (`client_company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_gst_details`
--

INSERT INTO `client_gst_details` (`id`, `client_company_id`, `gstn`, `pan`, `cin`, `nature_of_business`, `promoters`, `annual_turnover`, `annual_turnover_fy`, `aadhaar_validation`, `aadhaar_validation_date`, `einvoice_status`, `client_id`, `business_name`, `legal_name`, `center_jurisdiction`, `state_jurisdiction`, `date_of_registration`, `constitution_of_business`, `taxpayer_type`, `gstin_status`, `nature_bus_activities`, `created_at`, `updated_at`) VALUES
(14, 26, '06AACCN4070E1ZT', 'AACCN4070E', 'U45202DL2003PTC121288', NULL, '\"[\\\"NARESH  KUMAR \\\",\\\"ROHIT KUMAR GUPTA \\\",\\\"JAI KUMAR GARG \\\",\\\"PREMWATI \\\"]\"', 'Slab: Rs. 500 Cr. and above', '2024-2025', 'No', '1800-01-01', 1, NULL, 'NKC PROJECTS PVT LTD', 'NKC PROJECTS PRIVATE LIMITED', 'State - CBIC,Zone - PANCHKULA,Commissionerate - GURUGRAM,Division - DIVISION-NORTH-1,Range - R-1', 'State - Haryana,Range - Gurgaon,District - Gurgaon (North),Ward - Gurgaon (North) Ward 2 (Jurisdictional Office)', '2017-07-01', 'Private Limited Company', 'Regular', 'Active', '\"[\\\"Works Contract\\\",\\\"Others\\\",\\\"Recipient of Goods or Services\\\",\\\"Office \\\\/ Sale Office\\\",\\\"Supplier of Services\\\",\\\"Warehouse \\\\/ Depot\\\"]\"', '2025-09-01 12:07:05', '2025-09-17 09:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `client_investors`
--

DROP TABLE IF EXISTS `client_investors`;
CREATE TABLE IF NOT EXISTS `client_investors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `investor_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_investors`
--

INSERT INTO `client_investors` (`id`, `client_id`, `investor_id`, `created_at`, `updated_at`) VALUES
(1, 4, 3, '2024-05-10 09:46:30', '2024-05-10 09:46:30'),
(2, 5, 3, '2024-05-10 09:51:09', '2024-05-10 09:51:09'),
(3, 6, 3, '2024-05-10 09:54:09', '2024-05-10 09:54:09'),
(5, 7, 3, '2025-01-28 07:20:16', '2025-01-28 07:20:16'),
(6, 20, 4, '2025-08-26 09:37:02', '2025-08-26 09:37:02'),
(7, 12, 4, '2025-08-29 21:33:40', '2025-08-29 21:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `client_password_resets`
--

DROP TABLE IF EXISTS `client_password_resets`;
CREATE TABLE IF NOT EXISTS `client_password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `client_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_team_members`
--

DROP TABLE IF EXISTS `company_team_members`;
CREATE TABLE IF NOT EXISTS `company_team_members` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_company_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_team_members`
--

INSERT INTO `company_team_members` (`id`, `client_company_id`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 3, 6, '2024-05-10 10:18:30', '2024-05-10 10:18:30'),
(2, 2, 6, '2024-05-10 10:19:03', '2024-05-10 10:19:03'),
(3, 4, 6, '2024-05-10 10:19:15', '2024-05-10 10:19:15'),
(4, 5, 7, '2024-05-10 10:19:35', '2024-05-10 10:19:35'),
(5, 6, 6, '2024-05-10 10:19:51', '2024-05-10 10:19:51'),
(6, 17, 6, '2025-08-25 22:03:36', '2025-08-25 22:03:36'),
(7, 20, 6, '2025-08-26 09:53:44', '2025-08-26 09:53:44'),
(8, 20, 7, '2025-08-26 09:53:44', '2025-08-26 09:53:44'),
(9, 19, 7, '2025-08-26 09:54:17', '2025-08-26 09:54:17'),
(10, 12, 6, '2025-08-29 21:16:05', '2025-08-29 21:16:05'),
(11, 13, 6, '2025-08-29 21:42:06', '2025-08-29 21:42:06'),
(12, 14, 6, '2025-08-30 02:41:06', '2025-08-30 02:41:06'),
(13, 15, 6, '2025-08-30 04:30:05', '2025-08-30 04:30:05'),
(14, 16, 6, '2025-08-30 05:13:44', '2025-08-30 05:13:44'),
(15, 13, 6, '2025-08-31 05:48:51', '2025-08-31 05:48:51'),
(16, 20, 6, '2025-08-31 08:19:37', '2025-08-31 08:19:37'),
(17, 21, 6, '2025-08-31 08:37:45', '2025-08-31 08:37:45'),
(18, 22, 6, '2025-08-31 10:55:33', '2025-08-31 10:55:33'),
(19, 23, 6, '2025-08-31 12:12:25', '2025-08-31 12:12:25'),
(20, 24, 6, '2025-08-31 12:18:28', '2025-08-31 12:18:28'),
(21, 25, 6, '2025-09-01 05:50:02', '2025-09-01 05:50:02'),
(22, 26, 1, '2025-09-17 09:42:22', '2025-09-17 09:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `credit_data`
--

DROP TABLE IF EXISTS `credit_data`;
CREATE TABLE IF NOT EXISTS `credit_data` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `credit_request_id` int NOT NULL,
  `bank_statement` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit_financial_data`
--

DROP TABLE IF EXISTS `credit_financial_data`;
CREATE TABLE IF NOT EXISTS `credit_financial_data` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `credit_request_id` int NOT NULL,
  `year` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `credit_requests`
--

DROP TABLE IF EXISTS `credit_requests`;
CREATE TABLE IF NOT EXISTS `credit_requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard_elements`
--

DROP TABLE IF EXISTS `dashboard_elements`;
CREATE TABLE IF NOT EXISTS `dashboard_elements` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dashboard_elements`
--

INSERT INTO `dashboard_elements` (`id`, `name`, `key`, `created_at`, `updated_at`) VALUES
(1, 'Total Project', 1, '2024-03-04 10:56:09', '2024-03-04 10:56:09'),
(2, 'PO Amount', 2, '2024-03-04 10:56:09', '2024-03-04 10:56:09'),
(3, 'Total Invoice Raised', 3, '2024-03-04 10:56:09', '2024-03-04 10:56:09'),
(4, 'Total Invoices', 4, '2024-03-04 10:56:09', '2024-03-04 10:56:09'),
(5, 'Total Received Payment', 5, '2024-03-04 10:56:09', '2024-03-04 10:56:09'),
(6, 'Over Due Amount', 6, '2024-03-04 10:56:09', '2024-03-04 10:56:09'),
(7, 'PO Items Summery', 7, '2024-03-04 10:56:09', '2024-03-04 10:56:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investors`
--

DROP TABLE IF EXISTS `investors`;
CREATE TABLE IF NOT EXISTS `investors` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investors`
--

INSERT INTO `investors` (`id`, `name`, `mobile`, `email`, `password`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Dhaval Naphade', '7405349229', 'dhaval@gmail.com', '$2y$12$Lrn.DkC4e8NWdvbdysxvxOkgVsLRGwUawKCzDDAL6Mrai3yNsMPG.', 1, 1, '2023-12-25 20:08:50', '2023-12-26 07:26:33'),
(2, 'Mac User', '7894561233', 'mac@gmail.com', '$2y$12$a9wtDr1o1AvdurrlBKEiN.IWwtFOfyIb4UdD81EmA7/HCL9flTwRa', 1, 1, '2023-12-26 01:54:03', '2023-12-26 07:26:30'),
(3, 'Investor 1', '9638788737', 'investor1@gmail.com', '$2y$12$YJi9jfzd1aTGrV8nGeq18uEkQRKHBEQ7uYCPiPeFWqaIR4E1gdKtO', 1, 1, '2023-12-26 07:26:23', '2025-09-16 11:48:19'),
(4, 'Smartpaddle Technology Private Limited', '9081514666', 'SMART@VEPL.COM', '$2y$12$GDTRZrLtlisZhNbf3O6tUO.MquhFS0CFr/pQjrWLWRUjkRUOdf.HG', 1, 0, '2024-05-20 12:05:08', '2025-09-16 11:51:10'),
(5, 'Investor-1', '9638788738', 'investor-1@gmail.com', '$2y$12$brPRxsIJNM/gWwmSf4LnIO24MV.IBpI5szMMoP4k1uz9QgN7sfYrq', 1, 0, '2025-09-16 11:07:00', '2025-09-16 11:07:00'),
(6, 'Investor-2', '9081514669', 'investor-2@gmail.com', '$2y$12$mvGdqKz.8Ksd4GJDCuTjUOwesMGsIHb/t0FHIrsZVlZI2g6W3xMbq', 1, 0, '2025-09-16 21:47:05', '2025-09-16 21:47:24');

-- --------------------------------------------------------

--
-- Table structure for table `investor_password_resets`
--

DROP TABLE IF EXISTS `investor_password_resets`;
CREATE TABLE IF NOT EXISTS `investor_password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `investor_password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_qties`
--

DROP TABLE IF EXISTS `item_qties`;
CREATE TABLE IF NOT EXISTS `item_qties` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `po_item_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `qty` double(10,3) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_qties`
--

INSERT INTO `item_qties` (`id`, `po_item_id`, `supplier_id`, `qty`, `created_at`, `updated_at`) VALUES
(15, 1, 1, 50.000, '2024-01-25 09:11:00', '2024-01-25 09:11:00'),
(16, 1, 4, 50.000, '2024-01-25 09:11:00', '2024-01-25 09:11:00'),
(17, 2, 4, 50.000, '2024-01-25 09:11:00', '2024-01-25 09:11:00'),
(26, 5, 5, 50.000, '2024-01-25 10:53:17', '2024-01-25 10:53:17'),
(27, 6, 5, 50.000, '2024-01-25 10:53:17', '2024-01-25 10:53:17'),
(28, 6, 1, 50.000, '2024-01-25 10:53:17', '2024-01-25 10:53:17'),
(29, 7, 5, 50.000, '2024-01-25 10:53:17', '2024-01-25 10:53:17'),
(30, 14, 2, 100.000, '2024-05-10 10:38:27', '2024-05-10 10:38:27'),
(31, 13, 2, 150.000, '2024-05-10 10:39:07', '2024-05-10 10:39:07'),
(32, 18, 5, 120.000, '2024-05-20 12:08:30', '2024-05-20 12:08:30'),
(33, 15, 5, 200.000, '2024-05-20 12:08:44', '2024-05-20 12:08:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_07_28_104510_create_admins_table', 1),
(7, '2022_07_28_105010_create_admins_password_resets_table', 1),
(8, '2023_12_25_182751_create_investors_table', 1),
(9, '2023_12_25_184055_investor_password_resets', 1),
(10, '2022_07_28_120815_create_roles_table', 2),
(11, '2022_10_14_075834_create_modules_table', 2),
(12, '2022_10_14_080055_create_role_modules_table', 2),
(13, '2022_10_14_080138_create_dashboard_elements_table', 2),
(14, '2022_10_17_061059_create_role_elements_table', 2),
(15, '2023_12_26_015221_create_supplier_companies_table', 3),
(16, '2023_12_26_015243_create_authorized_people_table', 3),
(17, '2023_12_26_034908_create_states_table', 4),
(22, '2023_12_27_014925_create_client_company_contacts_table', 5),
(23, '2023_12_27_015357_create_client_company_authorized_people_table', 5),
(25, '2023_12_28_171832_create_product_variations_table', 6),
(38, '2023_12_27_014907_create_client_companies_table', 5),
(43, '2022_04_28_060257_create_policy_contents_table', 5),
(44, '2022_07_28_105010_create_client_password_resets_table', 5),
(45, '2023_12_30_071023_create_supplier_products_table', 6),
(46, '2023_12_30_190125_create_company_team_members_table', 7),
(47, '2024_01_17_174554_create_purchase_orders_table', 8),
(48, '2025_08_18_040538_create_api_call_log_table', 9),
(49, '2025_08_24_164152_update_client_companies_table', 10),
(50, '2025_08_30_021032_add_is_default_to_admins_table', 11),
(57, '2025_08_27_165801_create_client_company_invitations_table', 12),
(64, '2025_08_31_154451_update_client_companies_table', 13),
(66, '2025_09_01_170658_update_product_variations_table', 14),
(68, '2025_09_01_172812_update_client_companies_table', 15),
(69, '2025_09_02_083619_update_client_companies_table', 16),
(70, '2025_09_20_085833_create_zoho_tokens_table', 17),
(72, '2025_09_23_035944_create_zoho_webhooks_table', 18),
(76, '2025_09_25_035349_create_product_taxes_table', 19),
(81, '2025_09_27_091554_create_product_tax_groups_table', 20);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `key`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Organization Role', 'role', 'role', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(2, 'Investor', 'investor', 'investor', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(3, 'Supplier Company', 'supplier-company', 'supplier-company', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(4, 'Team', 'team', 'team', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(5, 'Client Company', 'client-company', 'client-company', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(6, 'Product', 'product', 'product', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(7, 'PO Module', 'po', 'po', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(8, 'Project', 'project', 'project', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(9, 'BOQ Module', 'boq', 'boq', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(10, 'Invoice', 'invoice', 'invoice', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(11, 'Transaction', 'transaction', 'transaction', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(12, 'Policy', 'policy', 'policy', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(13, 'Credit Request', 'credit', 'credit', '2023-12-26 06:59:44', '2023-12-26 06:59:44'),
(14, 'Invitation', 'invitation', 'invitation', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policy_contents`
--

DROP TABLE IF EXISTS `policy_contents`;
CREATE TABLE IF NOT EXISTS `policy_contents` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `policy_contents`
--

INSERT INTO `policy_contents` (`id`, `key`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 'TERMS', 'Terms & Conditions', '<h3>Terms and Conditions for Vivasvanna Exports</h3>\r\n\r\n<p><strong>Last Updated: September 2, 2025</strong></p>\r\n\r\n<p>Welcome to Vivasvanna Exports Pvt. Ltd. These Terms and Conditions&nbsp;&nbsp;govern your access to and use of our website, <a href=\"https://vivasvannaexports.com/\">vivasvannaexports.com</a>, including the dashboard features for Admin, Client, and Investor panels. By accessing or using our Website and its services, you agree to be bound by these Terms. If you do not agree, please do not use the Website or its services.</p>\r\n\r\n<p>1. General Terms</p>\r\n\r\n<p>1.1 <strong>Eligibility</strong>: You must be at least 18 years old and have the legal capacity to enter into contracts to use our Website and services. By using the Website, you represent that you meet these requirements.<br />\r\n1.2 <strong>Acceptance of Terms</strong>: Accessing the Website, registering an account, or using any services (including the dashboard) constitutes your acceptance of these Terms &amp; Conditions.<br />\r\n1.3 <strong>Modification of Terms</strong>: We reserve the right to modify these Terms at any time. Changes will be posted on this page with an updated &quot;<strong>September 2, 2025</strong>&quot; date. Your continued use of the Website after changes constitutes acceptance of the revised Terms.<br />\r\n1.4 <strong>Scope of Services</strong>: Vivasvanna Exports provides a platform for managing export/import activities, including a dashboard with Admin, Client, and Investor panels for managing transactions, tracking orders, viewing investment opportunities, and related activities.</p>\r\n\r\n<p>2. Dashboard Access and Panel-Specific Terms</p>\r\n\r\n<p>The Website includes a dashboard with three distinct panels: Admin, Client, and Investor. Each panel has specific functionalities and responsibilities. Below are the terms governing access and actions within these panels, with a focus on the Client panel.</p>\r\n\r\n<p>2.1 General Dashboard Terms</p>\r\n\r\n<ul>\r\n	<li><strong>Account Creation</strong>: To access the dashboard, you must create an account with accurate and complete information. You are responsible for maintaining the confidentiality of your account credentials (username and password).</li>\r\n	<li><strong>Account Security</strong>: You are responsible for all activities under your account. Notify us immediately at [<a href=\"mailto:info@vivasvannaexports.com\">info@vivasvannaexports.com</a>] if you suspect unauthorized access.</li>\r\n	<li><strong>Prohibited Actions</strong>: You may not:\r\n	<ul>\r\n		<li>Share your account credentials with others.</li>\r\n		<li>Attempt to access unauthorized areas of the Website or dashboard.</li>\r\n		<li>Use the dashboard for illegal, fraudulent, or harmful activities.</li>\r\n		<li>Interfere with the Website&rsquo;s functionality (e.g., hacking, introducing malware).</li>\r\n	</ul>\r\n	</li>\r\n	<li><strong>Termination of Access</strong>: We reserve the right to suspend or terminate your account for violating these Terms, engaging in suspicious activity, or for any reason at our discretion.</li>\r\n</ul>\r\n\r\n<p>2.2 Client Panel Terms and Conditions</p>\r\n\r\n<p>The Client panel is designed for registered clients to manage their orders, track shipments, communicate with Vivasvanna Exports, and access other services related to export/import activities. The following terms apply specifically to actions in the Client panel:</p>\r\n\r\n<ul>\r\n	<li><strong>Account Registration</strong>:\r\n\r\n	<ul>\r\n		<li>Clients must provide accurate business and personal details during registration (e.g., company name, contact information, tax ID if applicable).</li>\r\n		<li>You agree to update your information promptly if it changes.</li>\r\n	</ul>\r\n	</li>\r\n	<li><strong>Permitted Actions</strong>:\r\n	<ul>\r\n		<li>Place and manage orders for products/services offered by Vivasvanna Exports.</li>\r\n		<li>Track shipment status and delivery updates.</li>\r\n		<li>Communicate with our team via the dashboard&rsquo;s messaging or support features.</li>\r\n		<li>View invoices, payment history, and account statements.</li>\r\n	</ul>\r\n	</li>\r\n	<li><strong>Client Responsibilities</strong>:\r\n	<ul>\r\n		<li><strong>Accuracy of Orders</strong>: You are responsible for ensuring the accuracy of order details (e.g., product specifications, quantities, shipping address). Errors in provided information may result in delays or additional costs, for which you are liable.</li>\r\n		<li><strong>Payment Obligations</strong>: Payments for orders must be made as per the agreed terms (e.g., via dashboard payment gateways). Late payments may incur penalties or suspension of services.</li>\r\n		<li><strong>Compliance with Laws</strong>: You must comply with all applicable local and international laws related to exports/imports, including customs regulations, tariffs, and trade restrictions.</li>\r\n		<li><strong>Prohibited Actions</strong>: You may not:\r\n		<ul>\r\n			<li>Place orders for illegal goods or services.</li>\r\n			<li>Use the Client panel to mislead, defraud, or harm Vivasvanna Exports or other parties.</li>\r\n			<li>Share dashboard data (e.g., pricing, shipment details) with unauthorized third parties.</li>\r\n		</ul>\r\n		</li>\r\n	</ul>\r\n	</li>\r\n	<li><strong>Liability</strong>: Vivasvanna Exports is not liable for losses caused by your failure to provide accurate information, comply with laws, or follow these Terms.</li>\r\n	<li><strong>Data Usage</strong>: Information entered in the Client panel (e.g., order details, communications) may be used by Vivasvanna Exports to process orders, improve services, or comply with legal obligations, as outlined in our Privacy Policy.</li>\r\n</ul>\r\n\r\n<p>2.3 Admin Panel Terms</p>\r\n\r\n<p>The Admin panel is restricted to authorized personnel of Vivasvanna Exports. Clients and Investors are strictly prohibited from attempting to access this panel. Unauthorized access attempts may result in legal action.</p>\r\n\r\n<p>2.4 Investor Panel Terms</p>\r\n\r\n<p>The Investor panel is for registered investors to view investment opportunities, financial reports, or other data related to Vivasvanna Exports&rsquo; operations. Specific terms for the Investor panel are available upon registration and are subject to separate agreements.</p>\r\n\r\n<ul>\r\n</ul>\r\n\r\n<p>4. Intellectual Property</p>\r\n\r\n<ul>\r\n	<li>All content on the Website and dashboard, including text, logos, designs, and software, is owned by or licensed to Vivasvanna Exports and protected by intellectual property laws.</li>\r\n	<li>Clients may not reproduce, distribute, or use any content without prior written permission, except for personal, non-commercial use related to their account.</li>\r\n</ul>\r\n\r\n<p>5. Limitation of Liability</p>\r\n\r\n<ul>\r\n	<li><strong>Service Availability</strong>: We strive to ensure the Website and dashboard are available but are not liable for downtime, technical issues, or interruptions.</li>\r\n	<li><strong>Indirect Damages</strong>: To the fullest extent permitted by law, Vivasvanna Exports is not liable for indirect, incidental, or consequential damages arising from your use of the Website or services.</li>\r\n	<li><strong>Force Majeure</strong>: We are not liable for delays or failures due to events beyond our control (e.g., natural disasters, government restrictions).</li>\r\n</ul>\r\n\r\n<p>6. Termination</p>\r\n\r\n<ul>\r\n	<li>You may terminate your account by contacting [<a href=\"mailto:info@vivasvannaexports.com\">info@vivasvannaexports.com</a>]. Upon termination, you remain liable for any outstanding payments or obligations.</li>\r\n	<li>We may terminate your account or restrict access for violating these Terms, non-payment, or at our discretion with notice.</li>\r\n</ul>\r\n\r\n<p>7. Governing Law and Dispute Resolution</p>\r\n\r\n<ul>\r\n	<li><strong>Governing Law</strong>: These Terms are governed by the laws of [India/your country, specify if known].</li>\r\n	<li><strong>Disputes</strong>: Any disputes arising from these Terms or use of the Website will be resolved through negotiation. If unresolved, disputes will be subject to the exclusive jurisdiction of courts in [specify city/country, e.g., Mumbai, India].</li>\r\n</ul>\r\n\r\n<p>8. Contact Information</p>\r\n\r\n<p>For questions, support, or complaints regarding the Website, dashboard, or these Terms, contact us at:</p>\r\n\r\n<ul>\r\n	<li><strong>Email</strong>: [<a href=\"mailto:info@vivasvannaexports.com\">info@vivasvannaexports.com</a>]</li>\r\n	<li><strong>Address</strong>:SWARRNIM HOUSE, 3rd Floor, Arihant School of Pharmacy SWARRNIM UNIVERSITY CAMPUS, Adalaj, S.G Highway, Ahmedabad</li>\r\n</ul>', NULL, '2025-09-01 23:35:54');

-- --------------------------------------------------------

--
-- Table structure for table `ponotes`
--

DROP TABLE IF EXISTS `ponotes`;
CREATE TABLE IF NOT EXISTS `ponotes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `po_id` int NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ponotes`
--

INSERT INTO `ponotes` (`id`, `po_id`, `note`, `created_at`, `updated_at`) VALUES
(1, 24, 'DELIVERY AGAINST SCHEDUULE', '2024-12-02 07:59:41', '2024-12-02 07:59:41'),
(2, 24, 'VISCOSITY MORE THEN 4000', '2024-12-02 07:59:41', '2024-12-02 07:59:41'),
(3, 24, 'GRN TO CHECK BY FRIGHT TIGER', '2024-12-02 07:59:41', '2024-12-02 07:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gst` double NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_type`, `gst`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Product 1', 10.2, 1, 0, '2023-12-28 18:49:01', '2023-12-28 18:49:01'),
(2, 'BITUMENdd', 18, 1, 0, '2024-01-04 14:50:35', '2025-09-01 11:32:45'),
(3, 'BITUMEN EMULSION HDPE DRUMS', 18, 1, 0, '2024-01-09 10:49:08', '2024-01-09 10:49:08'),
(4, 'BITUMEN EMULSION MS DRUMS', 18, 1, 0, '2024-01-09 10:52:48', '2024-01-09 10:52:48'),
(5, 'CRMB BITUMEN bull', 18, 1, 0, '2024-01-09 10:56:54', '2025-09-01 11:31:42'),
(6, 'PMB', 18, 1, 0, '2024-01-09 10:59:06', '2024-01-09 10:59:06'),
(7, 'PMB', 18, 1, 0, '2024-01-09 10:59:13', '2024-01-09 10:59:13'),
(8, 'CEMENT BAG', 18, 1, 0, '2024-01-09 10:59:49', '2024-01-09 10:59:49'),
(9, 'CEMENT BAG', 18, 1, 0, '2024-01-09 10:59:53', '2024-01-09 10:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `product_taxes`
--

DROP TABLE IF EXISTS `product_taxes`;
CREATE TABLE IF NOT EXISTS `product_taxes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tax_id` varchar(121) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_name` varchar(121) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_name_formatted` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_percentage` decimal(8,2) NOT NULL DEFAULT '0.00',
  `tax_type` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_account_id` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `output_tax_account_name` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_payable_account_id` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_specific_type` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_state_cess` tinyint(1) NOT NULL DEFAULT '0',
  `is_inactive` tinyint(1) NOT NULL DEFAULT '0',
  `is_default_tax` tinyint(1) NOT NULL DEFAULT '0',
  `is_editable` tinyint(1) NOT NULL DEFAULT '1',
  `tax_specification` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diff_rate_reason` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `last_modified_time` timestamp NULL DEFAULT NULL,
  `raw` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_taxes_tax_id_unique` (`tax_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_taxes`
--

INSERT INTO `product_taxes` (`id`, `tax_id`, `tax_name`, `tax_name_formatted`, `tax_percentage`, `tax_type`, `tax_account_id`, `output_tax_account_name`, `tds_payable_account_id`, `tax_specific_type`, `is_state_cess`, `is_inactive`, `is_default_tax`, `is_editable`, `tax_specification`, `diff_rate_reason`, `start_date`, `end_date`, `status`, `description`, `last_modified_time`, `raw`, `created_at`, `updated_at`) VALUES
(1, '2279063000000035161', 'GST0', 'GST0 [0%]', 0.00, 'tax_group', '', NULL, '', '', 0, 0, 0, 1, 'intra', '', '', '', 'Active', '', '2025-04-22 10:22:15', '\"{\\\"tax_id\\\":\\\"2279063000000035161\\\",\\\"tax_name\\\":\\\"GST0\\\",\\\"tax_percentage\\\":0,\\\"tax_type\\\":\\\"tax_group\\\",\\\"tax_specific_type\\\":\\\"\\\",\\\"is_inactive\\\":false,\\\"is_default_tax\\\":false,\\\"is_editable\\\":true,\\\"tax_specification\\\":\\\"intra\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"last_modified_time\\\":\\\"2025-04-22T15:52:15+0530\\\",\\\"status\\\":\\\"Active\\\",\\\"tax_name_formatted\\\":\\\"GST0 [0%]\\\",\\\"tax_account_id\\\":\\\"\\\",\\\"tds_payable_account_id\\\":\\\"\\\",\\\"is_state_cess\\\":false,\\\"description\\\":\\\"\\\"}\"', '2025-09-27 08:05:03', '2025-09-27 08:15:09'),
(2, '2279063000000035179', 'GST18', 'GST18 [18%]', 18.00, 'tax_group', '', NULL, '', '', 0, 0, 0, 1, 'intra', '', '', '', 'Active', '', '2025-04-22 10:22:15', '\"{\\\"tax_id\\\":\\\"2279063000000035179\\\",\\\"tax_name\\\":\\\"GST18\\\",\\\"tax_percentage\\\":18,\\\"tax_type\\\":\\\"tax_group\\\",\\\"tax_specific_type\\\":\\\"\\\",\\\"is_inactive\\\":false,\\\"is_default_tax\\\":false,\\\"is_editable\\\":true,\\\"tax_specification\\\":\\\"intra\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"last_modified_time\\\":\\\"2025-04-22T15:52:15+0530\\\",\\\"status\\\":\\\"Active\\\",\\\"tax_name_formatted\\\":\\\"GST18 [18%]\\\",\\\"tax_account_id\\\":\\\"\\\",\\\"tds_payable_account_id\\\":\\\"\\\",\\\"is_state_cess\\\":false,\\\"description\\\":\\\"\\\"}\"', '2025-09-27 08:05:03', '2025-09-27 08:15:10'),
(3, '2279063000000035167', 'GST5', 'GST5 [5%]', 5.00, 'tax_group', '', NULL, '', '', 0, 0, 0, 1, 'intra', '', '', '', 'Active', '', '2025-04-22 10:22:15', '\"{\\\"tax_id\\\":\\\"2279063000000035167\\\",\\\"tax_name\\\":\\\"GST5\\\",\\\"tax_percentage\\\":5,\\\"tax_type\\\":\\\"tax_group\\\",\\\"tax_specific_type\\\":\\\"\\\",\\\"is_inactive\\\":false,\\\"is_default_tax\\\":false,\\\"is_editable\\\":true,\\\"tax_specification\\\":\\\"intra\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"last_modified_time\\\":\\\"2025-04-22T15:52:15+0530\\\",\\\"status\\\":\\\"Active\\\",\\\"tax_name_formatted\\\":\\\"GST5 [5%]\\\",\\\"tax_account_id\\\":\\\"\\\",\\\"tds_payable_account_id\\\":\\\"\\\",\\\"is_state_cess\\\":false,\\\"description\\\":\\\"\\\"}\"', '2025-09-27 08:05:03', '2025-09-27 08:15:11'),
(4, '2279063000000123146', 'IGST', 'IGST [18%]', 18.00, 'tax', '2279063000000035029', 'Output IGST', '2279063000000035041', 'igst', 0, 0, 0, 1, 'inter', '', '', '', 'Active', '', '2025-05-17 03:39:08', '\"{\\\"tax_id\\\":\\\"2279063000000123146\\\",\\\"tax_name\\\":\\\"IGST\\\",\\\"tax_percentage\\\":18,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_specific_type\\\":\\\"igst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"output_tax_account_name\\\":\\\"Output IGST\\\",\\\"tax_account_id\\\":\\\"2279063000000035029\\\",\\\"is_inactive\\\":false,\\\"is_default_tax\\\":false,\\\"is_editable\\\":true,\\\"tax_specification\\\":\\\"inter\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"last_modified_time\\\":\\\"2025-05-17T09:09:08+0530\\\",\\\"status\\\":\\\"Active\\\",\\\"tax_name_formatted\\\":\\\"IGST [18%]\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035041\\\",\\\"is_state_cess\\\":false,\\\"description\\\":\\\"\\\"}\"', '2025-09-27 08:05:03', '2025-09-27 08:15:11'),
(5, '2279063000000035071', 'IGST0', 'IGST0 [0%]', 0.00, 'tax', '2279063000000035029', 'Output IGST', '2279063000000035041', 'igst', 0, 0, 0, 0, 'inter', '', '', '', 'Active', '', '2025-05-17 03:39:08', '\"{\\\"tax_id\\\":\\\"2279063000000035071\\\",\\\"tax_name\\\":\\\"IGST0\\\",\\\"tax_percentage\\\":0,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_specific_type\\\":\\\"igst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"output_tax_account_name\\\":\\\"Output IGST\\\",\\\"tax_account_id\\\":\\\"2279063000000035029\\\",\\\"is_inactive\\\":false,\\\"is_default_tax\\\":false,\\\"is_editable\\\":false,\\\"tax_specification\\\":\\\"inter\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"last_modified_time\\\":\\\"2025-05-17T09:09:08+0530\\\",\\\"status\\\":\\\"Active\\\",\\\"tax_name_formatted\\\":\\\"IGST0 [0%]\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035041\\\",\\\"is_state_cess\\\":false,\\\"description\\\":\\\"\\\"}\"', '2025-09-27 08:05:03', '2025-09-27 08:15:12'),
(6, '2279063000000035077', 'IGST18', 'IGST18 [18%]', 18.00, 'tax', '2279063000000035029', 'Output IGST', '2279063000000035041', 'igst', 0, 0, 0, 0, 'inter', '', '', '', 'Active', '', '2025-05-17 03:39:08', '\"{\\\"tax_id\\\":\\\"2279063000000035077\\\",\\\"tax_name\\\":\\\"IGST18\\\",\\\"tax_percentage\\\":18,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_specific_type\\\":\\\"igst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"output_tax_account_name\\\":\\\"Output IGST\\\",\\\"tax_account_id\\\":\\\"2279063000000035029\\\",\\\"is_inactive\\\":false,\\\"is_default_tax\\\":false,\\\"is_editable\\\":false,\\\"tax_specification\\\":\\\"inter\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"last_modified_time\\\":\\\"2025-05-17T09:09:08+0530\\\",\\\"status\\\":\\\"Active\\\",\\\"tax_name_formatted\\\":\\\"IGST18 [18%]\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035041\\\",\\\"is_state_cess\\\":false,\\\"description\\\":\\\"\\\"}\"', '2025-09-27 08:05:03', '2025-09-27 08:15:12'),
(7, '2279063000000035073', 'IGST5', 'IGST5 [5%]', 5.00, 'tax', '2279063000000035029', 'Output IGST', '2279063000000035041', 'igst', 0, 0, 0, 0, 'inter', '', '', '', 'Active', '', '2025-05-17 03:39:08', '\"{\\\"tax_id\\\":\\\"2279063000000035073\\\",\\\"tax_name\\\":\\\"IGST5\\\",\\\"tax_percentage\\\":5,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_specific_type\\\":\\\"igst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"output_tax_account_name\\\":\\\"Output IGST\\\",\\\"tax_account_id\\\":\\\"2279063000000035029\\\",\\\"is_inactive\\\":false,\\\"is_default_tax\\\":false,\\\"is_editable\\\":false,\\\"tax_specification\\\":\\\"inter\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"last_modified_time\\\":\\\"2025-05-17T09:09:08+0530\\\",\\\"status\\\":\\\"Active\\\",\\\"tax_name_formatted\\\":\\\"IGST5 [5%]\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035041\\\",\\\"is_state_cess\\\":false,\\\"description\\\":\\\"\\\"}\"', '2025-09-27 08:05:03', '2025-09-27 08:15:13'),
(8, '2279063000000123140', 'Infra', 'Infra [18%]', 18.00, 'tax', '2279063000000035029', 'Output IGST', '2279063000000035041', 'igst', 0, 0, 0, 1, 'inter', '', '', '', 'Active', '', '2025-05-17 03:39:08', '\"{\\\"tax_id\\\":\\\"2279063000000123140\\\",\\\"tax_name\\\":\\\"Infra\\\",\\\"tax_percentage\\\":18,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_specific_type\\\":\\\"igst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"output_tax_account_name\\\":\\\"Output IGST\\\",\\\"tax_account_id\\\":\\\"2279063000000035029\\\",\\\"is_inactive\\\":false,\\\"is_default_tax\\\":false,\\\"is_editable\\\":true,\\\"tax_specification\\\":\\\"inter\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"last_modified_time\\\":\\\"2025-05-17T09:09:08+0530\\\",\\\"status\\\":\\\"Active\\\",\\\"tax_name_formatted\\\":\\\"Infra [18%]\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035041\\\",\\\"is_state_cess\\\":false,\\\"description\\\":\\\"\\\"}\"', '2025-09-27 08:05:03', '2025-09-27 08:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_tax_groups`
--

DROP TABLE IF EXISTS `product_tax_groups`;
CREATE TABLE IF NOT EXISTS `product_tax_groups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tax_group_id` varchar(121) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` varchar(121) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_name` varchar(121) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_name_formatted` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_percentage` decimal(8,2) NOT NULL DEFAULT '0.00',
  `tax_type` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_account_id` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `output_tax_account_name` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tds_payable_account_id` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_authority_id` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_authority_name` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_specific_type` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_state_cess` tinyint(1) NOT NULL DEFAULT '0',
  `tax_specification` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diff_rate_reason` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(121) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `last_modified_time` timestamp NULL DEFAULT NULL,
  `raw` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_tax_groups_tax_id_unique` (`tax_id`),
  KEY `product_tax_groups_tax_group_id_foreign` (`tax_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_tax_groups`
--

INSERT INTO `product_tax_groups` (`id`, `tax_group_id`, `tax_id`, `tax_name`, `tax_name_formatted`, `tax_percentage`, `tax_type`, `tax_account_id`, `output_tax_account_name`, `tds_payable_account_id`, `tax_authority_id`, `tax_authority_name`, `tax_specific_type`, `is_state_cess`, `tax_specification`, `diff_rate_reason`, `start_date`, `end_date`, `status`, `description`, `last_modified_time`, `raw`, `created_at`, `updated_at`) VALUES
(1, '2279063000000035081', '2279063000000035081', 'CGST0', 'CGST0 [0%]', 0.00, 'tax', '2279063000000035047', 'Output CGST', '2279063000000035053', '2279063000000030015', 'INTD', 'cgst', 0, 'intra', '', '', '', 'Active', '', NULL, '\"{\\\"tax_id\\\":\\\"2279063000000035081\\\",\\\"tax_name\\\":\\\"CGST0\\\",\\\"tax_name_formatted\\\":\\\"CGST0 [0%]\\\",\\\"tax_percentage\\\":0,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_account_id\\\":\\\"2279063000000035047\\\",\\\"output_tax_account_name\\\":\\\"Output CGST\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035053\\\",\\\"tax_specific_type\\\":\\\"cgst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"is_state_cess\\\":false,\\\"tax_specification\\\":\\\"intra\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"status\\\":\\\"Active\\\",\\\"description\\\":\\\"\\\",\\\"tax_group_id\\\":\\\"2279063000000035081\\\"}\"', '2025-09-27 10:23:11', '2025-09-27 10:23:11'),
(2, '2279063000000035083', '2279063000000035083', 'SGST0', 'SGST0 [0%]', 0.00, 'tax', '2279063000000035059', 'Output SGST', '2279063000000035065', '2279063000000030015', 'INTD', 'sgst', 0, 'intra', '', '', '', 'Active', '', NULL, '\"{\\\"tax_id\\\":\\\"2279063000000035083\\\",\\\"tax_name\\\":\\\"SGST0\\\",\\\"tax_name_formatted\\\":\\\"SGST0 [0%]\\\",\\\"tax_percentage\\\":0,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_account_id\\\":\\\"2279063000000035059\\\",\\\"output_tax_account_name\\\":\\\"Output SGST\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035065\\\",\\\"tax_specific_type\\\":\\\"sgst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"is_state_cess\\\":false,\\\"tax_specification\\\":\\\"intra\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"status\\\":\\\"Active\\\",\\\"description\\\":\\\"\\\",\\\"tax_group_id\\\":\\\"2279063000000035083\\\"}\"', '2025-09-27 10:23:11', '2025-09-27 10:23:11'),
(3, '2279063000000035093', '2279063000000035093', 'CGST9', 'CGST9 [9%]', 9.00, 'tax', '2279063000000035047', 'Output CGST', '2279063000000035053', '2279063000000030015', 'INTD', 'cgst', 0, 'intra', '', '', '', 'Active', '', NULL, '\"{\\\"tax_id\\\":\\\"2279063000000035093\\\",\\\"tax_name\\\":\\\"CGST9\\\",\\\"tax_name_formatted\\\":\\\"CGST9 [9%]\\\",\\\"tax_percentage\\\":9,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_account_id\\\":\\\"2279063000000035047\\\",\\\"output_tax_account_name\\\":\\\"Output CGST\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035053\\\",\\\"tax_specific_type\\\":\\\"cgst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"is_state_cess\\\":false,\\\"tax_specification\\\":\\\"intra\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"status\\\":\\\"Active\\\",\\\"description\\\":\\\"\\\",\\\"tax_group_id\\\":\\\"2279063000000035093\\\"}\"', '2025-09-27 10:23:12', '2025-09-27 10:23:12'),
(4, '2279063000000035095', '2279063000000035095', 'SGST9', 'SGST9 [9%]', 9.00, 'tax', '2279063000000035059', 'Output SGST', '2279063000000035065', '2279063000000030015', 'INTD', 'sgst', 0, 'intra', '', '', '', 'Active', '', NULL, '\"{\\\"tax_id\\\":\\\"2279063000000035095\\\",\\\"tax_name\\\":\\\"SGST9\\\",\\\"tax_name_formatted\\\":\\\"SGST9 [9%]\\\",\\\"tax_percentage\\\":9,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_account_id\\\":\\\"2279063000000035059\\\",\\\"output_tax_account_name\\\":\\\"Output SGST\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035065\\\",\\\"tax_specific_type\\\":\\\"sgst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"is_state_cess\\\":false,\\\"tax_specification\\\":\\\"intra\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"status\\\":\\\"Active\\\",\\\"description\\\":\\\"\\\",\\\"tax_group_id\\\":\\\"2279063000000035095\\\"}\"', '2025-09-27 10:23:12', '2025-09-27 10:23:12'),
(5, '2279063000000035085', '2279063000000035085', 'CGST2.5', 'CGST2.5 [2.5%]', 2.50, 'tax', '2279063000000035047', 'Output CGST', '2279063000000035053', '2279063000000030015', 'INTD', 'cgst', 0, 'intra', '', '', '', 'Active', '', NULL, '\"{\\\"tax_id\\\":\\\"2279063000000035085\\\",\\\"tax_name\\\":\\\"CGST2.5\\\",\\\"tax_name_formatted\\\":\\\"CGST2.5 [2.5%]\\\",\\\"tax_percentage\\\":2.5,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_account_id\\\":\\\"2279063000000035047\\\",\\\"output_tax_account_name\\\":\\\"Output CGST\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035053\\\",\\\"tax_specific_type\\\":\\\"cgst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"is_state_cess\\\":false,\\\"tax_specification\\\":\\\"intra\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"status\\\":\\\"Active\\\",\\\"description\\\":\\\"\\\",\\\"tax_group_id\\\":\\\"2279063000000035085\\\"}\"', '2025-09-27 10:23:13', '2025-09-27 10:23:13'),
(6, '2279063000000035087', '2279063000000035087', 'SGST2.5', 'SGST2.5 [2.5%]', 2.50, 'tax', '2279063000000035059', 'Output SGST', '2279063000000035065', '2279063000000030015', 'INTD', 'sgst', 0, 'intra', '', '', '', 'Active', '', NULL, '\"{\\\"tax_id\\\":\\\"2279063000000035087\\\",\\\"tax_name\\\":\\\"SGST2.5\\\",\\\"tax_name_formatted\\\":\\\"SGST2.5 [2.5%]\\\",\\\"tax_percentage\\\":2.5,\\\"tax_type\\\":\\\"tax\\\",\\\"tax_account_id\\\":\\\"2279063000000035059\\\",\\\"output_tax_account_name\\\":\\\"Output SGST\\\",\\\"tds_payable_account_id\\\":\\\"2279063000000035065\\\",\\\"tax_specific_type\\\":\\\"sgst\\\",\\\"tax_authority_id\\\":\\\"2279063000000030015\\\",\\\"tax_authority_name\\\":\\\"INTD\\\",\\\"is_state_cess\\\":false,\\\"tax_specification\\\":\\\"intra\\\",\\\"diff_rate_reason\\\":\\\"\\\",\\\"start_date\\\":\\\"\\\",\\\"end_date\\\":\\\"\\\",\\\"status\\\":\\\"Active\\\",\\\"description\\\":\\\"\\\",\\\"tax_group_id\\\":\\\"2279063000000035087\\\"}\"', '2025-09-27 10:23:14', '2025-09-27 10:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

DROP TABLE IF EXISTS `product_variations`;
CREATE TABLE IF NOT EXISTS `product_variations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `grade` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hsn_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `product_id`, `grade`, `hsn_code`, `unit`, `remarks`, `created_at`, `updated_at`) VALUES
(6, 1, '1', NULL, 'MT', 'lorem', '2023-12-28 19:05:11', '2023-12-28 19:05:11'),
(7, 1, '2', NULL, 'KG', 'lorem', '2023-12-28 19:05:11', '2023-12-28 19:05:11'),
(8, 1, '3', NULL, 'PERBAG', 'lorem', '2023-12-28 19:05:11', '2023-12-28 19:05:11'),
(11, 1, '6', NULL, 'PERBAG', 'edit lorem', '2023-12-28 19:05:11', '2023-12-28 19:05:11'),
(12, 1, '7', NULL, 'MT', 'repeat edit lorem', '2023-12-28 19:06:15', '2023-12-28 19:06:15'),
(13, 2, 'BULK BITUMEN VG 30', NULL, 'MT,KG', 'BULK', '2024-01-05 12:11:25', '2024-01-05 12:12:31'),
(14, 2, 'BULK BITUMEN VG 40', NULL, 'MT,KG', 'BULK', '2024-01-05 12:12:31', '2024-01-05 12:12:31'),
(15, 3, 'BITUMEN EMULSION RS 1- HDPE DRUMS', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:49:08', '2024-01-09 10:49:08'),
(16, 3, 'BITUMEN EMULSION RS2 - HDPE DRUMS', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:49:08', '2024-01-09 10:49:08'),
(17, 3, 'BITUMEN EMULSION  MS - HDPE DRUMS', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:49:08', '2024-01-09 10:49:08'),
(18, 3, 'BITUMEN EMULSION  SS 1 - HDPE DRUMS', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:49:08', '2024-01-09 10:49:08'),
(19, 3, 'BITUMEN EMULSION  SS2 - HDPE DRUMS', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:49:08', '2024-01-09 10:49:08'),
(20, 4, 'BITUMEN EMULSION RAPID SETTING 1 (RS1)', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:52:48', '2024-01-09 10:52:48'),
(21, 4, 'BITUMEN EMULSION RAPID SETTING 2(RS2)', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:52:48', '2024-01-09 10:52:48'),
(22, 4, 'BITUMEN EMULSION MEDIUM SETTING (MS )', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:52:48', '2024-01-09 10:52:48'),
(23, 4, 'BITUMEN EMULSION SLOW SETTING 1 (SS1)', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:52:48', '2024-01-09 10:52:48'),
(24, 4, 'BITUMEN EMULSION SLOW SETTING 1 (SS2)', NULL, 'MT,KG', 'DRUM PACKING IN 200 KGS - HDPE', '2024-01-09 10:52:48', '2024-01-09 10:52:48'),
(25, 2, 'bulk bitumen vg 40', NULL, 'MT,PERBAG', NULL, '2025-09-01 11:42:01', '2025-09-01 11:42:01');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `client_id`, `name`, `description`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 2, 'CDS INFRAPROJECTS LTD- DELHI VADODARA PKG 14', NULL, 1, 0, '2024-05-10 10:20:52', '2024-05-10 10:20:52'),
(2, 2, 'CDS INFRA PROJECTS LTD - DELHI KATRA PKG 2 - DAK2', NULL, 1, 0, '2024-05-10 10:21:23', '2024-05-10 10:21:23'),
(3, 2, 'CDS INFRA PROJECTS LTD - DELHI KATRA PKG 5', NULL, 1, 0, '2024-05-10 10:21:29', '2024-05-10 10:21:29'),
(4, 2, 'CDS INFRA PROJECTS LTD - AMRITSAR JAMNAGAR PKG3', NULL, 1, 0, '2024-05-10 10:21:46', '2024-05-10 10:21:46'),
(5, 4, 'KRC INFRAPROJECTS PVT LTD - AMRITSAR JAMNAGAR PKG2', NULL, 1, 0, '2024-05-10 10:22:07', '2024-05-10 10:22:07'),
(6, 3, 'NKC PROJECTS PVT LTD  AMRITSAR JAMNAGAR PKG 6', NULL, 1, 0, '2024-05-10 10:22:30', '2024-05-10 10:22:30'),
(7, 3, 'NKC PROJECTS PVT LTD AMRITSAR JAMNAGAR PKG 7', NULL, 1, 0, '2024-05-10 10:22:43', '2024-05-10 10:22:43'),
(8, 3, 'NKC PROJECTS PVT LTD AMRITSAR JAMNAGAR PKG 8', NULL, 1, 0, '2024-05-10 10:22:49', '2024-05-10 10:22:49'),
(9, 4, 'AAYODHYA - GHAZIPUR // NH -1011', 'TOTAL 54 KMS OF 6 LANE HIGHWAY RESURFACIING', 1, 0, '2024-12-02 07:57:57', '2024-12-02 07:57:57'),
(10, 19, 'bopal', '3bhk', 1, 0, '2025-08-26 10:11:46', '2025-08-26 10:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

DROP TABLE IF EXISTS `purchase_orders`;
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int NOT NULL,
  `project_id` int DEFAULT NULL,
  `boq_id` int DEFAULT NULL,
  `po_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` double(30,3) NOT NULL,
  `credit_day` int DEFAULT '0',
  `received_amount` double(30,3) DEFAULT '0.000',
  `po_copy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `client_id`, `project_id`, `boq_id`, `po_number`, `subtotal`, `credit_day`, `received_amount`, `po_copy`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '123123123123AAA', 50000.000, 0, -16000.000, '25121.pdf', 1, 1, '2024-01-24 01:52:47', '2024-05-20 12:10:57'),
(3, 1, 1, 1, '123456789', 65129.000, 0, 0.000, '97033.pdf', 1, 1, '2024-01-25 02:24:13', '2024-05-13 09:09:55'),
(4, 2, 1, 1, '2024/01-06456', 505000.000, 0, 0.000, '50574.pdf', 1, 1, '2024-01-25 09:28:31', '2024-01-25 09:33:50'),
(5, 2, 1, 1, '2024/01/06457', 605000.000, 0, 100000.000, '68447.pdf', 1, 1, '2024-01-25 09:33:37', '2024-05-13 09:10:31'),
(6, 2, 1, 1, '2024/01/39954', 150000.000, 0, 50000.000, '84038.pdf', 1, 1, '2024-01-25 11:36:36', '2024-05-13 09:10:56'),
(7, 2, 1, 1, 'djtest/00123', 20000.000, 0, -11000.000, '58077.pdf', 1, 1, '2024-01-25 11:44:50', '2024-05-20 12:11:28'),
(8, 2, 4, NULL, 'CDS/PO/GUJARAT PROJECT/HO/389', 1009608.000, 0, 0.000, '44031.pdf', 1, 0, '2024-05-10 10:29:22', '2024-05-10 10:29:22'),
(9, 2, 2, NULL, 'CDS/PO/DELHI-KARTA-2(HIGHWAY)/HO/651', 6814500.000, 0, 0.000, '83172.pdf', 1, 0, '2024-05-10 10:32:25', '2024-05-10 10:32:25'),
(10, 2, 1, NULL, 'CDS/PO/KOTA PROJECT RAJASTHAN/HO/769-AM1', 6814500.000, 0, 0.000, '26781.pdf', 1, 0, '2024-05-10 10:33:47', '2024-05-10 10:33:47'),
(11, 2, 4, NULL, 'AJ-PO-00-2122', 4543000.000, 0, 0.000, '44544.pdf', 1, 0, '2024-05-10 10:35:05', '2024-05-10 10:35:05'),
(13, 2, 1, NULL, 'H2POIND/00105/24-25', 9251200.000, 0, 0.000, '22160.pdf', 1, 0, '2024-05-20 07:45:34', '2024-05-20 07:45:34'),
(14, 2, 1, NULL, 'CDS/HO/23-24/17389', 445450000.000, 0, 0.000, '37792.pdf', 1, 1, '2024-05-20 07:47:31', '2024-05-20 07:49:55'),
(15, 2, 1, NULL, 'CDS/HO/23-24/17389', 445450000.000, 0, 0.000, '58401.pdf', 1, 1, '2024-05-20 07:47:36', '2024-05-20 07:49:59'),
(16, 2, 1, NULL, 'CDS/HO/23-24/17389', 445450000.000, 0, 0.000, '32177.pdf', 1, 1, '2024-05-20 07:48:16', '2024-05-20 07:50:03'),
(17, 2, 1, NULL, 'CDS/HO/23-27/17389', 445450000.000, 0, 0.000, '61073.pdf', 1, 1, '2024-05-20 07:49:11', '2024-05-20 07:50:09'),
(18, 2, 1, NULL, 'CDS/HO/23-24/17389', 445450000.000, 0, 0.000, '27535.pdf', 1, 0, '2024-05-20 07:49:36', '2024-05-20 07:49:36'),
(19, 2, 1, NULL, 'CDS/HO/23-24/17389', 445450000.000, 0, 0.000, '27535.pdf', 1, 1, '2024-05-20 07:49:36', '2024-05-20 08:56:37'),
(22, 2, 2, NULL, 'H2POIND/00105/24-25', 9251200.000, 0, 0.000, '46481.pdf', 1, 1, '2024-05-20 12:02:16', '2024-05-20 12:02:28'),
(23, 2, 3, NULL, 'D5POIND/00051/24-25', 5550720.000, 0, 0.000, '26508.pdf', 1, 0, '2024-05-20 12:03:58', '2024-05-20 12:03:58'),
(24, 4, 9, NULL, 'PO//23-24//5445', 47200000.000, 15, 0.000, '87652.pdf', 1, 0, '2024-12-02 07:59:41', '2024-12-02 07:59:41'),
(25, 2, 2, NULL, '112233', 29500000.000, 0, 0.000, '71827.pdf', 1, 0, '2025-01-06 12:37:13', '2025-01-06 12:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_invoices`
--

DROP TABLE IF EXISTS `purchase_order_invoices`;
CREATE TABLE IF NOT EXISTS `purchase_order_invoices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int DEFAULT NULL,
  `investor_id` int DEFAULT NULL,
  `po_id` int NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_copy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mark_as_paid` tinyint NOT NULL DEFAULT '0',
  `due_days` int DEFAULT NULL,
  `due_date` date NOT NULL,
  `grm` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lr_copy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eway_bill` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_invoices`
--

INSERT INTO `purchase_order_invoices` (`id`, `uuid`, `item_id`, `investor_id`, `po_id`, `invoice_date`, `invoice_number`, `invoice_amount`, `invoice_copy`, `mark_as_paid`, `due_days`, `due_date`, `grm`, `lr_copy`, `eway_bill`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, '', NULL, NULL, 1, NULL, '123456', '8000', '33233.jpg', 1, NULL, '2024-01-25', NULL, NULL, NULL, 1, 1, '2024-01-24 18:46:21', '2024-05-20 12:10:57'),
(2, '', NULL, NULL, 5, NULL, 'INV001', '100000', '67663.pdf', 1, NULL, '2024-01-31', NULL, NULL, NULL, 1, 0, '2024-01-25 09:50:16', '2024-01-25 10:55:29'),
(3, '', NULL, NULL, 5, NULL, 'INV002', '100000', '63673.pdf', 1, NULL, '2024-01-31', NULL, NULL, NULL, 1, 1, '2024-01-25 09:53:06', '2024-01-25 09:53:21'),
(4, '', NULL, NULL, 5, NULL, 'INV002', '100000', '98231.pdf', 0, NULL, '2024-01-31', NULL, NULL, NULL, 1, 0, '2024-01-25 09:53:47', '2024-01-25 10:55:37'),
(5, '', NULL, NULL, 6, NULL, 'INV101', '25000', '87296.pdf', 1, NULL, '2024-01-31', NULL, NULL, NULL, 1, 0, '2024-01-25 11:41:10', '2024-01-25 11:41:31'),
(6, '', NULL, NULL, 6, NULL, 'INV02', '50000', '17441.pdf', 1, NULL, '2024-01-25', NULL, NULL, NULL, 1, 0, '2024-01-25 11:42:04', '2024-01-25 11:42:04'),
(7, '', NULL, NULL, 7, NULL, '00123', '1000', '93963.pdf', 1, NULL, '2024-01-25', NULL, NULL, NULL, 1, 1, '2024-01-25 11:45:14', '2024-05-20 12:11:28'),
(8, '187c0358-990b-4d00-b78b-3ed364a8af14', NULL, 3, 11, NULL, 'GST/501/2023-24', '1291121.00', '71584.pdf', 0, 7, '2024-05-20', '53689.pdf', '67281.pdf', '65838.pdf', 1, 0, '2024-05-13 10:12:11', '2024-05-13 10:12:11'),
(9, 'f5f8d5c8-2c7a-4c86-a19b-55905f1dd651', NULL, 3, 18, NULL, 'GST/600/2023-24', '1284232', '81343.pdf', 0, 7, '2024-05-27', '53386.pdf', '82693.pdf', '16629.pdf', 1, 0, '2024-05-20 08:10:31', '2024-05-20 08:10:31'),
(10, '7ee3386c-0a8c-4ca1-8656-2d2d87e94439', NULL, 3, 18, NULL, 'GST/601/2023-24', '1213851', '97610.pdf', 0, 7, '2024-05-27', '17600.pdf', '79493.pdf', '86808.pdf', 1, 0, '2024-05-20 08:13:12', '2024-05-20 08:13:12'),
(11, '3220b63a-f38c-42ff-aebb-1e958b693ab5', NULL, 3, 18, NULL, 'GST/605/2023-24', '1048144', '35075.pdf', 0, 7, '2024-05-27', '14842.pdf', '18901.pdf', '59193.pdf', 1, 0, '2024-05-20 08:14:23', '2024-05-20 08:14:23'),
(12, 'ff9ef118-ab58-44f8-af67-4f8562ae07e8', NULL, 3, 18, NULL, 'GST/606/2023-24', '1210733', '61650.pdf', 0, 7, '2024-05-27', '84462.pdf', '30782.pdf', '61316.pdf', 1, 0, '2024-05-20 08:15:26', '2024-05-20 08:15:26'),
(13, '3ef22959-f2de-410c-b331-f683dfa47151', NULL, 3, 18, NULL, 'GST/610/2023-24', '1204497', '95903.pdf', 0, 7, '2024-05-27', '81506.pdf', '72812.pdf', '21251.pdf', 1, 0, '2024-05-20 08:17:11', '2024-05-20 08:17:11'),
(14, '502b96e0-6fca-4dc0-806b-c5bcd28573e7', NULL, 3, 18, NULL, 'GST/612/2023-24', '1032108', '87695.pdf', 0, 7, '2024-05-27', '98620.pdf', '61095.pdf', '18164.pdf', 1, 0, '2024-05-20 08:18:40', '2024-05-20 08:18:40'),
(15, '5f2ef0e2-a642-483f-82fe-943a6d2ccef9', NULL, 3, 18, NULL, 'GST/615/2023-24', '1306260', '29431.pdf', 0, 7, '2024-05-27', '84895.pdf', '99631.pdf', '16591.pdf', 1, 0, '2024-05-20 08:20:24', '2024-05-20 08:20:24'),
(16, '57b8ee59-1da6-480f-a3e8-003c7ce099d1', NULL, 3, 18, NULL, 'GST/616/2023-24', '1218306', '18261.pdf', 0, 7, '2024-05-27', '69947.pdf', '49591.pdf', '97796.pdf', 1, 0, '2024-05-20 08:21:49', '2024-05-20 08:21:49'),
(17, 'bd18bd6f-38bd-42e7-963f-1a8a2742a7ed', NULL, 3, 18, NULL, 'GST/617/2023-24', '1282005', '95555.pdf', 0, 7, '2024-05-27', '69307.pdf', '18860.pdf', '26133.pdf', 1, 0, '2024-05-20 08:23:23', '2024-05-20 08:23:23'),
(18, '7462129a-62e2-4c54-b20d-f2ac1df7029b', NULL, 3, 18, NULL, 'GST/618/2023-24', '1044580', '65928.pdf', 0, 7, '2024-05-27', '72264.pdf', '99712.pdf', '29095.pdf', 1, 0, '2024-05-20 08:25:34', '2024-05-20 08:25:34'),
(19, 'cf39bcb1-4fd9-417b-a005-6d8ef130772a', NULL, 3, 18, NULL, 'GST/622/2023-24', '1288687', '93630.pdf', 0, 7, '2024-05-27', '65249.pdf', '46735.pdf', '29553.pdf', 1, 0, '2024-05-20 08:27:05', '2024-05-20 08:27:05'),
(20, '4df4dd16-0ec5-46a5-99b8-fe91fe540758', NULL, 3, 18, NULL, 'GST/623/2023-24', '1066407', '54084.pdf', 0, 7, '2024-05-27', '93108.pdf', '93039.pdf', '75131.pdf', 1, 0, '2024-05-20 08:28:38', '2024-05-20 08:28:38'),
(21, '3c8f9a2f-dca3-4a94-a4ba-259ea4e6c8fc', NULL, 3, 18, NULL, 'GST/631/2023-24', '1180859', '72778.pdf', 0, 7, '2024-05-27', '28614.pdf', '93083.pdf', '46478.pdf', 1, 0, '2024-05-20 08:30:43', '2024-05-20 08:30:43'),
(22, 'ef9465e3-78c5-46e7-9478-02268b46fe1c', NULL, 3, 18, NULL, 'GST/632/2023-24', '1458403', '70849.pdf', 0, 7, '2024-05-27', '11475.pdf', '24225.pdf', '74559.pdf', 1, 0, '2024-05-20 08:32:03', '2024-05-20 08:32:03'),
(23, 'de66d8bb-feae-45be-bc31-d973a8207ee2', NULL, 3, 18, NULL, 'GST/633/2023-24', '1477558', '51299.pdf', 0, 7, '2024-05-27', '23522.pdf', '24784.pdf', '75509.pdf', 1, 0, '2024-05-20 08:33:39', '2024-05-20 08:33:39'),
(24, 'de57dcfc-7270-406c-afe4-8096b302df70', NULL, 3, 18, NULL, 'GST/639/2023-24', '1039680', '18291.pdf', 0, 7, '2024-05-27', '77042.pdf', '64213.pdf', '84544.pdf', 1, 0, '2024-05-20 09:56:16', '2024-05-20 09:56:16'),
(25, 'af36b02f-6f92-4a43-b560-995551641468', NULL, 3, 18, NULL, 'GST/640/2023-24', '1265969', '94353.pdf', 0, 7, '2024-05-27', '78211.pdf', '32214.pdf', '47871.pdf', 1, 0, '2024-05-20 09:57:59', '2024-05-20 09:57:59'),
(26, '0cf977f0-dc82-4684-86fd-2630342c5353', NULL, 3, 18, NULL, 'GST/641/2023-24', '1220978', '59920.pdf', 0, 7, '2024-05-27', '81825.pdf', '30321.pdf', '58512.pdf', 1, 0, '2024-05-20 10:00:01', '2024-05-20 10:00:01'),
(27, '2b55d910-db4d-4b21-a6e6-71c3efe5eda1', NULL, 3, 18, NULL, 'GST/642/2023-24', '1294478', '64072.pdf', 0, 7, '2024-05-27', '46836.pdf', '46309.pdf', '69796.pdf', 1, 0, '2024-05-20 11:22:31', '2024-05-20 11:22:31'),
(28, 'a7d405ce-4e52-43d9-bb93-232520371377', NULL, 3, 18, NULL, 'GST/644/2023-24', '1208506', '40762.pdf', 0, 7, '2024-05-27', '90406.pdf', '80324.pdf', '87910.pdf', 1, 0, '2024-05-20 11:25:09', '2024-05-20 11:25:09'),
(29, '2b51f482-3285-4b51-83fa-dce99cf14253', NULL, 3, 18, NULL, 'GST/645/2023-24', '1212960', '73085.pdf', 0, 7, '2024-05-27', '96270.pdf', '64770.pdf', '71940.pdf', 1, 0, '2024-05-20 12:03:04', '2024-05-20 12:09:59'),
(30, '33d4336f-5d7e-4328-8eb7-5476e623cbc1', NULL, 3, 18, NULL, 'GST/646/2023-24', '1246815', '13844.pdf', 0, 7, '2024-05-27', '31703.pdf', '48112.pdf', '81228.pdf', 1, 0, '2024-05-20 12:20:03', '2024-05-20 12:20:03'),
(31, '0a37ec0b-c862-4091-ac8f-e4c4cff100f2', NULL, 3, 18, NULL, 'GST/660/2023-24', '1299823', '15587.pdf', 0, 7, '2024-05-27', '27671.pdf', '18747.pdf', '63131.pdf', 1, 0, '2024-05-20 12:21:42', '2024-05-20 12:21:42'),
(32, '295d548b-dd81-476c-97ce-728dec7c71bf', NULL, 3, 18, NULL, 'GST/661/2023-24', '1062398', '55104.pdf', 0, 7, '2024-05-27', '55274.pdf', '58334.pdf', '88566.pdf', 1, 0, '2024-05-20 12:23:09', '2024-05-20 12:23:09'),
(33, '834f85d8-c2a4-432c-9795-6fe500ed6d2c', NULL, 3, 18, NULL, 'GST/662/2023-24', '1483349', '91424.pdf', 0, 7, '2024-05-27', '65456.pdf', '51407.pdf', '52246.pdf', 1, 0, '2024-05-20 12:24:27', '2024-05-20 12:24:27'),
(34, '45f9ec16-1362-4e76-8e61-87ee71eca0bb', NULL, 3, 18, NULL, 'GST/665/2023-24', '1203606', '84400.pdf', 0, 7, '2024-05-27', '24212.pdf', '41348.pdf', '71374.pdf', 1, 0, '2024-05-20 12:25:49', '2024-05-20 12:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

DROP TABLE IF EXISTS `purchase_order_items`;
CREATE TABLE IF NOT EXISTS `purchase_order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `boq_item_id` int DEFAULT NULL,
  `po_id` int NOT NULL,
  `category_id` int NOT NULL,
  `remaining_boq_qty` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `rate` double(30,2) NOT NULL,
  `freight` double(30,2) DEFAULT NULL,
  `fright_selection` int DEFAULT NULL,
  `subtotal` double(30,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_order_items`
--

INSERT INTO `purchase_order_items` (`id`, `boq_item_id`, `po_id`, `category_id`, `remaining_boq_qty`, `unit`, `qty`, `rate`, `freight`, `fright_selection`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, NULL, 3, 13, NULL, 'MT', 123, 123.00, NULL, NULL, 15129.00, '2024-01-25 02:24:13', '2024-01-25 02:24:13'),
(2, NULL, 3, 14, NULL, 'KG', 5000, 10.00, NULL, NULL, 50000.00, '2024-01-25 02:24:13', '2024-01-25 02:24:13'),
(5, NULL, 5, 13, '0', 'MT', 50, 100.00, NULL, NULL, 5000.00, '2024-01-25 09:43:13', '2024-01-25 09:43:13'),
(6, NULL, 5, 17, '0', 'KG', 100, 1000.00, NULL, NULL, 100000.00, '2024-01-25 09:43:13', '2024-01-25 09:43:13'),
(7, NULL, 5, 17, NULL, 'MT', 50, 10000.00, NULL, NULL, 500000.00, '2024-01-25 09:43:13', '2024-01-25 09:43:13'),
(8, NULL, 6, 16, NULL, 'MT', 50, 1000.00, NULL, NULL, 50000.00, '2024-01-25 11:36:36', '2024-01-25 11:36:36'),
(9, NULL, 6, 13, NULL, 'MT', 50, 2000.00, NULL, NULL, 100000.00, '2024-01-25 11:36:36', '2024-01-25 11:36:36'),
(10, NULL, 7, 15, '0', 'MT', 1000, 20.00, NULL, NULL, 20000.00, '2024-01-25 11:44:50', '2024-01-25 11:44:50'),
(11, NULL, 8, 14, NULL, 'MT', 23, 37200.00, 0.00, 1, 1009608.00, '2024-05-10 10:29:22', '2024-05-10 10:29:22'),
(12, NULL, 9, 14, NULL, 'MT', 150, 38500.00, 0.00, 1, 6814500.00, '2024-05-10 10:32:25', '2024-05-10 10:32:25'),
(13, NULL, 10, 14, NULL, 'MT', 150, 38500.00, 0.00, 1, 6814500.00, '2024-05-10 10:33:47', '2024-05-10 10:33:47'),
(14, NULL, 11, 14, NULL, 'MT', 100, 38500.00, 0.00, 1, 4543000.00, '2024-05-10 10:35:05', '2024-05-10 10:35:05'),
(15, NULL, 13, 14, NULL, 'MT', 200, 39200.00, 0.00, 1, 9251200.00, '2024-05-20 07:45:34', '2024-05-20 07:45:34'),
(17, NULL, 22, 14, NULL, 'MT', 200, 39200.00, 0.00, 1, 9251200.00, '2024-05-20 12:02:16', '2024-05-20 12:02:16'),
(18, NULL, 23, 14, NULL, 'MT', 120, 39200.00, 0.00, 1, 5550720.00, '2024-05-20 12:03:58', '2024-05-20 12:03:58'),
(19, NULL, 24, 14, NULL, 'MT', 1000, 40000.00, 0.00, 1, 47200000.00, '2024-12-02 07:59:41', '2024-12-02 07:59:41'),
(20, NULL, 25, 14, NULL, 'MT', 500, 50000.00, 0.00, 1, 29500000.00, '2025-01-06 12:37:13', '2025-01-06 12:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, 0, '2023-12-26 01:31:31', '2023-12-26 01:32:42'),
(2, 'OPERATION MANAGER', 1, 0, '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(3, 'CLIENT MANAGER', 1, 0, '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(4, 'FINANCE MANANGER', 1, 0, '2024-05-10 10:10:10', '2024-05-10 10:10:10'),
(5, 'CHEIF FINANCE OFFICER', 1, 0, '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(6, 'SALES HEAD', 1, 0, '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(7, 'Marketing', 1, 0, '2025-09-02 23:02:29', '2025-09-02 23:02:29');

-- --------------------------------------------------------

--
-- Table structure for table `role_elements`
--

DROP TABLE IF EXISTS `role_elements`;
CREATE TABLE IF NOT EXISTS `role_elements` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `element_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_elements`
--

INSERT INTO `role_elements` (`id`, `role_id`, `element_id`, `created_at`, `updated_at`) VALUES
(8, 1, 1, '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(9, 1, 2, '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(10, 1, 3, '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(11, 1, 4, '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(12, 1, 5, '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(13, 1, 6, '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(14, 1, 7, '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(15, 2, 1, '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(16, 2, 2, '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(17, 2, 3, '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(18, 2, 4, '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(19, 2, 5, '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(20, 2, 6, '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(21, 2, 7, '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(22, 3, 1, '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(23, 3, 2, '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(24, 3, 3, '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(25, 3, 4, '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(26, 3, 5, '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(27, 3, 6, '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(28, 3, 7, '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(36, 5, 1, '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(37, 5, 2, '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(38, 5, 3, '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(39, 5, 4, '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(40, 5, 5, '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(41, 5, 6, '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(42, 5, 7, '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(43, 6, 1, '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(44, 6, 2, '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(45, 6, 3, '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(46, 6, 4, '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(47, 6, 5, '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(48, 6, 6, '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(49, 6, 7, '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(50, 4, 1, '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(51, 4, 2, '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(52, 4, 3, '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(53, 4, 4, '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(54, 4, 5, '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(55, 4, 6, '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(56, 4, 7, '2024-05-10 11:18:12', '2024-05-10 11:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `role_modules`
--

DROP TABLE IF EXISTS `role_modules`;
CREATE TABLE IF NOT EXISTS `role_modules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `module_id` int NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_modules`
--

INSERT INTO `role_modules` (`id`, `role_id`, `module_id`, `action`, `created_at`, `updated_at`) VALUES
(15, 1, 1, 'add,edit,delete,list', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(16, 1, 2, 'add,edit,delete,list', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(17, 1, 3, 'add,edit,delete,list,authorized', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(18, 1, 4, 'add,edit,delete,list,status', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(19, 1, 5, 'add,edit,delete,list,verify,dashboard,download,setting,team,users', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(20, 1, 6, 'add,edit,delete,list', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(21, 1, 7, 'add,edit,delete,list,view,supplier,invoice', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(22, 1, 8, 'add,edit,delete,list', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(23, 1, 9, 'add,edit,delete,list,view,manage', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(24, 1, 10, 'edit,download,delete,list', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(25, 1, 11, 'list', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(26, 1, 12, 'edit,list', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(27, 1, 13, 'view,download,list', '2024-03-27 11:30:13', '2024-03-27 11:30:13'),
(28, 2, 5, 'list', '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(29, 2, 6, 'list', '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(30, 2, 7, 'list', '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(31, 2, 10, 'edit,download,list', '2024-05-10 10:07:13', '2024-05-10 10:07:13'),
(32, 3, 3, 'list', '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(33, 3, 5, 'list,verify,dashboard,download', '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(34, 3, 6, 'list', '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(35, 3, 7, 'add,edit,list,supplier,invoice', '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(36, 3, 8, 'add,list', '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(37, 3, 9, 'add,list,view,manage', '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(38, 3, 10, 'download,list', '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(39, 3, 11, 'list', '2024-05-10 10:08:56', '2024-05-10 10:08:56'),
(49, 5, 2, 'add,edit,delete,list', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(50, 5, 3, 'add,edit,delete,list,authorized', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(51, 5, 5, 'add,edit,delete,list,verify,dashboard,download,setting,team,users', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(52, 5, 6, 'add,edit,delete,list', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(53, 5, 7, 'add,edit,delete,list,view,supplier,invoice', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(54, 5, 8, 'add,edit,delete,list', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(55, 5, 9, 'add,edit,delete,list,view,manage', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(56, 5, 10, 'edit,download,delete,list', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(57, 5, 11, 'list', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(58, 5, 12, 'edit,list', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(59, 5, 13, 'view,download,list', '2024-05-10 10:11:48', '2024-05-10 10:11:48'),
(60, 6, 3, 'add,list,authorized', '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(61, 6, 5, 'add,list,verify,dashboard,download,setting,team,users', '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(62, 6, 6, 'add,edit,delete,list', '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(63, 6, 7, 'add,edit,list,view,supplier,invoice', '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(64, 6, 8, 'add,edit,list', '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(65, 6, 9, 'add,edit,list,view,manage', '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(66, 6, 10, 'edit,download,delete,list', '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(67, 6, 11, 'list', '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(68, 6, 13, 'view,download,list', '2024-05-10 10:14:13', '2024-05-10 10:14:13'),
(69, 4, 3, 'add,list,authorized', '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(70, 4, 5, 'add,list,verify,dashboard,download,setting,users', '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(71, 4, 6, 'add,list', '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(72, 4, 7, 'add,list,view,supplier,invoice', '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(73, 4, 8, 'add,list', '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(74, 4, 9, 'add,list', '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(75, 4, 10, 'edit,download,list', '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(76, 4, 11, 'list', '2024-05-10 11:18:12', '2024-05-10 11:18:12'),
(77, 1, 14, 'list,send,master_register,master_create', NULL, NULL),
(78, 7, 5, 'edit,list', '2025-09-02 23:02:29', '2025-09-02 23:02:29');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ANDHRA PRADESH', NULL, NULL),
(2, 'ASSAM', NULL, NULL),
(3, 'ARUNACHAL PRADESH', NULL, NULL),
(4, 'BIHAR', NULL, NULL),
(5, 'GUJARAT', NULL, NULL),
(6, 'HARYANA', NULL, NULL),
(7, 'HIMACHAL PRADESH', NULL, NULL),
(8, 'JAMMU & KASHMIR', NULL, NULL),
(9, 'KARNATAKA', NULL, NULL),
(10, 'KERALA', NULL, NULL),
(11, 'MADHYA PRADESH', NULL, NULL),
(12, 'MAHARASHTRA', NULL, NULL),
(13, 'MANIPUR', NULL, NULL),
(14, 'MEGHALAYA', NULL, NULL),
(15, 'MIZORAM', NULL, NULL),
(16, 'NAGALAND', NULL, NULL),
(17, 'ORISSA', NULL, NULL),
(18, 'PUNJAB', NULL, NULL),
(19, 'RAJASTHAN', NULL, NULL),
(20, 'SIKKIM', NULL, NULL),
(21, 'TAMIL NADU', NULL, NULL),
(22, 'TRIPURA', NULL, NULL),
(23, 'UTTAR PRADESH', NULL, NULL),
(24, 'WEST BENGAL', NULL, NULL),
(25, 'DELHI', NULL, NULL),
(26, 'GOA', NULL, NULL),
(27, 'PONDICHERY', NULL, NULL),
(28, 'LAKSHDWEEP', NULL, NULL),
(29, 'DAMAN & DIU', NULL, NULL),
(30, 'DADRA & NAGAR', NULL, NULL),
(31, 'CHANDIGARH', NULL, NULL),
(32, 'ANDAMAN & NICOBAR', NULL, NULL),
(33, 'UTTARANCHAL', NULL, NULL),
(34, 'JHARKHAND', NULL, NULL),
(35, 'CHATTISGARH', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_companies`
--

DROP TABLE IF EXISTS `supplier_companies`;
CREATE TABLE IF NOT EXISTS `supplier_companies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gstn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `iec_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pancard` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `gstn_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iec_code_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pancard_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_companies`
--

INSERT INTO `supplier_companies` (`id`, `uuid`, `company_logo`, `company_name`, `address`, `state_id`, `mobile`, `email`, `gstn`, `iec_code`, `pancard`, `is_active`, `is_delete`, `created_at`, `updated_at`, `gstn_image`, `iec_code_image`, `pancard_image`) VALUES
(1, NULL, '49311.jpg', 'Denvar Texas', 'Lorem ispum is standard test text', 1, '9865323232', 'denvar@texas.com', 'BBBBBBBBBBBBBBB', '1', 'DDDDDDDDDD', 1, 1, '2023-12-26 04:47:48', '2024-01-24 11:03:40', NULL, NULL, NULL),
(2, NULL, NULL, 'VIVAVSANNA EXPORTS PVT LTD', 'AHMEDABAD', 5, '9978955809', 'info@vivasvannaexports.com', '24AAGCV8932P1ZL', 'AAGCV8932P', 'AAGCV8932P', 1, 0, '2024-01-09 11:02:54', '2024-01-09 11:02:54', NULL, NULL, NULL),
(3, NULL, NULL, 'DEEPJYOTI WAX TRADERS PVT LTD', 'KOLKATA', 24, '9831023121', 'INFO.AMITWAXUDYOG@GMAIL.COM', '19AABCD4061C1ZL', 'AABCD4061C', 'AABCD4061C', 1, 0, '2024-01-09 11:05:45', '2024-01-09 11:05:45', NULL, NULL, NULL),
(4, 'e81a0276-5506-4e17-87ad-f2be04f5743b', NULL, 'DAILY WAY PETRO LLP', 'SHOP NO.25, VIPUL AGORA, MG ROAD, NEXT TO SAHARA MALL, GURGAON-122002', 6, '9036902902', 'petro@dailyway.in', '06AATFD2177L1ZX', 'AATFD2177L', 'AATFD2177L', 1, 0, '2024-04-04 12:04:13', '2024-04-04 12:04:13', '22667.pdf', '73089.pdf', '99295.pdf'),
(5, '30f0c34a-120f-44dd-aaf4-98fdce89b7e5', NULL, 'VIVASVANNA EXPORTS PVT LTD', '20 WOrld business house near parimal garden', 5, '9978955809', 'luv.jain@vivasvannaexports.com', '24AAGCV8932P1ZL', 'AAGCV8932P', 'AAGCV8932P', 1, 0, '2024-05-20 12:08:17', '2024-05-20 12:08:17', '70758.pdf', '62171.pdf', '70449.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_products`
--

DROP TABLE IF EXISTS `supplier_products`;
CREATE TABLE IF NOT EXISTS `supplier_products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_company_id` int NOT NULL,
  `product_id` int NOT NULL,
  `capacity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_products`
--

INSERT INTO `supplier_products` (`id`, `supplier_company_id`, `product_id`, `capacity`, `unit`, `created_at`, `updated_at`) VALUES
(1, 2, 13, '5000', 'MT', '2024-01-09 11:02:54', '2024-01-09 11:02:54'),
(2, 3, 13, '2000', 'MT', '2024-01-09 11:05:45', '2024-01-09 11:05:45'),
(3, 4, 14, '5000', 'MT', '2024-04-04 12:04:13', '2024-04-04 12:04:13'),
(4, 5, 14, '50000', 'MT', '2024-05-20 12:08:17', '2024-05-20 12:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `po_id` int DEFAULT NULL,
  `invoice_id` int DEFAULT NULL,
  `reference_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('PAID','PENDING') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(10,2) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '1',
  `is_delete` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `client_id`, `project_id`, `po_id`, `invoice_id`, `reference_number`, `type`, `amount`, `payment_date`, `is_active`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 11, 8, 'GST/501/2023-24', 'PENDING', 1291121.00, NULL, 1, 0, '2024-05-13 10:12:11', '2024-05-13 10:12:11'),
(2, 2, 1, 18, 9, 'GST/600/2023-24', 'PENDING', 1284232.00, NULL, 1, 0, '2024-05-20 08:10:31', '2024-05-20 08:10:31'),
(3, 2, 1, 18, 10, 'GST/601/2023-24', 'PENDING', 1213851.00, NULL, 1, 0, '2024-05-20 08:13:12', '2024-05-20 08:13:12'),
(4, 2, 1, 18, 11, 'GST/605/2023-24', 'PENDING', 1048144.00, NULL, 1, 0, '2024-05-20 08:14:23', '2024-05-20 08:14:23'),
(5, 2, 1, 18, 12, 'GST/606/2023-24', 'PENDING', 1210733.00, NULL, 1, 0, '2024-05-20 08:15:26', '2024-05-20 08:15:26'),
(6, 2, 1, 18, 13, 'GST/610/2023-24', 'PENDING', 1204497.00, NULL, 1, 0, '2024-05-20 08:17:11', '2024-05-20 08:17:11'),
(7, 2, 1, 18, 14, 'GST/612/2023-24', 'PENDING', 1032108.00, NULL, 1, 0, '2024-05-20 08:18:40', '2024-05-20 08:18:40'),
(8, 2, 1, 18, 15, 'GST/615/2023-24', 'PENDING', 1306260.00, NULL, 1, 0, '2024-05-20 08:20:24', '2024-05-20 08:20:24'),
(9, 2, 1, 18, 16, 'GST/616/2023-24', 'PENDING', 1218306.00, NULL, 1, 0, '2024-05-20 08:21:49', '2024-05-20 08:21:49'),
(10, 2, 1, 18, 17, 'GST/617/2023-24', 'PENDING', 1282005.00, NULL, 1, 0, '2024-05-20 08:23:23', '2024-05-20 08:23:23'),
(11, 2, 1, 18, 18, 'GST/618/2023-24', 'PENDING', 1044580.00, NULL, 1, 0, '2024-05-20 08:25:34', '2024-05-20 08:25:34'),
(12, 2, 1, 18, 19, 'GST/622/2023-24', 'PENDING', 1288687.00, NULL, 1, 0, '2024-05-20 08:27:05', '2024-05-20 08:27:05'),
(13, 2, 1, 18, 20, 'GST/623/2023-24', 'PENDING', 1066407.00, NULL, 1, 0, '2024-05-20 08:28:38', '2024-05-20 08:28:38'),
(14, 2, 1, 18, 21, 'GST/631/2023-24', 'PENDING', 1180859.00, NULL, 1, 0, '2024-05-20 08:30:43', '2024-05-20 08:30:43'),
(15, 2, 1, 18, 22, 'GST/632/2023-24', 'PENDING', 1458403.00, NULL, 1, 0, '2024-05-20 08:32:03', '2024-05-20 08:32:03'),
(16, 2, 1, 18, 23, 'GST/633/2023-24', 'PENDING', 1477558.00, NULL, 1, 0, '2024-05-20 08:33:39', '2024-05-20 08:33:39'),
(17, 2, 1, 18, 24, 'GST/639/2023-24', 'PENDING', 1039680.00, NULL, 1, 0, '2024-05-20 09:56:16', '2024-05-20 09:56:16'),
(18, 2, 1, 18, 25, 'GST/640/2023-24', 'PENDING', 1265969.00, NULL, 1, 0, '2024-05-20 09:57:59', '2024-05-20 09:57:59'),
(19, 2, 1, 18, 26, 'GST/641/2023-24', 'PENDING', 1220978.00, NULL, 1, 0, '2024-05-20 10:00:01', '2024-05-20 10:00:01'),
(20, 2, 1, 18, 27, 'GST/642/2023-24', 'PENDING', 1294478.00, NULL, 1, 0, '2024-05-20 11:22:31', '2024-05-20 11:22:31'),
(21, 2, 1, 18, 28, 'GST/644/2023-24', 'PENDING', 1208506.00, NULL, 1, 0, '2024-05-20 11:25:09', '2024-05-20 11:25:09'),
(23, 2, 1, 18, 29, 'GST/645/2023-24', 'PENDING', 1212960.00, NULL, 1, 0, '2024-05-20 12:09:59', '2024-05-20 12:09:59'),
(24, 2, 1, 18, 30, 'GST/646/2023-24', 'PENDING', 1246815.00, NULL, 1, 0, '2024-05-20 12:20:03', '2024-05-20 12:20:03'),
(25, 2, 1, 18, 31, 'GST/660/2023-24', 'PENDING', 1299823.00, NULL, 1, 0, '2024-05-20 12:21:42', '2024-05-20 12:21:42'),
(26, 2, 1, 18, 32, 'GST/661/2023-24', 'PENDING', 1062398.00, NULL, 1, 0, '2024-05-20 12:23:09', '2024-05-20 12:23:09'),
(27, 2, 1, 18, 33, 'GST/662/2023-24', 'PENDING', 1483349.00, NULL, 1, 0, '2024-05-20 12:24:27', '2024-05-20 12:24:27'),
(28, 2, 1, 18, 34, 'GST/665/2023-24', 'PENDING', 1203606.00, NULL, 1, 0, '2024-05-20 12:25:49', '2024-05-20 12:25:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zoho_tokens`
--

DROP TABLE IF EXISTS `zoho_tokens`;
CREATE TABLE IF NOT EXISTS `zoho_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `access_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refresh_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `zoho_tokens_access_token_unique` (`access_token`),
  UNIQUE KEY `zoho_tokens_refresh_token_unique` (`refresh_token`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zoho_tokens`
--

INSERT INTO `zoho_tokens` (`id`, `access_token`, `refresh_token`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, '1000.0d798f5f6e6c2bf50469d38f4933ed6b.40487c2e73067b23a114be6778c8e9f7', '1000.de79a2663c80882743d4c1edd28bc28c.e731a63136e4aff4284ab8bf4c836238', '2025-10-18 04:30:34', NULL, '2025-10-18 03:30:34');

-- --------------------------------------------------------

--
-- Table structure for table `zoho_webhooks`
--

DROP TABLE IF EXISTS `zoho_webhooks`;
CREATE TABLE IF NOT EXISTS `zoho_webhooks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `zoho_webhooks_module_event_unique` (`module_name`,`event`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zoho_webhooks`
--

INSERT INTO `zoho_webhooks` (`id`, `module_name`, `event`, `secret`, `url`, `created_at`, `updated_at`) VALUES
(1, 'items', 'create', 'dR8kWxFHO81CsD5C7F4oQkuTjLw13LpP', 'https://e293867333ac.ngrok-free.app/webhooks/zoho/items?event=create&secret=dR8kWxFHO81CsD5C7F4oQkuTjLw13LpP', '2025-09-23 04:22:51', '2025-09-22 22:54:56'),
(2, 'items', 'update', 'P1JFi4hUZ9vkhMxI4cpvSJlIquoycJyd', 'https://e293867333ac.ngrok-free.app/webhooks/zoho/items?event=update&secret=P1JFi4hUZ9vkhMxI4cpvSJlIquoycJyd', '2025-09-23 04:22:51', '2025-09-22 22:54:56'),
(3, 'items', 'delete', 'JdJPpXnhuHe6YfoQBECKboMsfrLpd0xW', 'https://e293867333ac.ngrok-free.app/webhooks/zoho/items?event=delete&secret=JdJPpXnhuHe6YfoQBECKboMsfrLpd0xW', '2025-09-23 04:22:51', '2025-09-22 22:54:56');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
