SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;
START TRANSACTION;


CREATE TABLE `tbl_appointments` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(30) DEFAULT NULL,
  `date` varchar(100) DEFAULT NULL,
  `time_slot_start` int(25) DEFAULT NULL,
  `time_slot_end` int(25) DEFAULT NULL,
  `clinic_id` bigint(30) DEFAULT NULL,
  `doctor_id` bigint(30) NOT NULL,
  `flag` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mail_sent` varchar(100) NOT NULL,
  `user_not` int(11) NOT NULL,
  `doc_not` int(11) NOT NULL,
  `notification_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `patient_id` (`patient_id`),
  KEY `time_slot_start` (`time_slot_start`,`time_slot_end`),
  KEY `time_end_fk` (`time_slot_end`),
  CONSTRAINT `clinic_appointment_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `doctor_appointment_fk` FOREIGN KEY (`doctor_id`) REFERENCES `tbl_user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `patient_appointment_fk` FOREIGN KEY (`patient_id`) REFERENCES `tbl_user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `time_end_fk` FOREIGN KEY (`time_slot_end`) REFERENCES `tbl_timeslots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `time_start_fk` FOREIGN KEY (`time_slot_start`) REFERENCES `tbl_timeslots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=latin1;

INSERT INTO tbl_appointments( `id`, `patient_id`, `date`, `time_slot_start`, `time_slot_end`, `clinic_id`, `doctor_id`, `flag`, `created_date`, `modified_date`, `mail_sent`, `user_not`, `doc_not`, `notification_type` ) VALUES
("66","105","01/26/2016","45","47","1","1","1","2016-01-26 12:20:14","2016-01-26 07:20:14","","0","0","both"),
("67","105","1/26/2016","47","49","1","1","1","2016-01-26 12:22:02","2016-01-26 07:22:02","","0","0","both"),
("68","105","1/26/2016","43","45","1","1","0","2016-01-26 12:22:23","2016-01-26 07:22:23","","0","0","both"),
("69","105","1/26/2016","41","43","1","1","1","2016-01-26 12:31:01","2016-01-26 07:31:01","","0","0","both"),
("70","105","1/26/2016","23","25","1","1","1","2016-01-26 12:31:25","2016-01-26 07:31:25","","0","0","both"),
("71","105","1/26/2016","25","27","1","1","1","2016-01-26 12:31:40","2016-01-26 07:31:40","1","0","0","both"),
("100","105","3/12/2016","52","53","1","1","0","2016-03-12 11:26:32","2016-03-12 10:19:17","1","0","0","both"),
("106","105","03/12/2016","12","13","1","1","0","2016-03-12 14:29:45","2016-03-12 09:29:45","1","0","0","both"),
("107","105","3/12/2016","13","15","1","1","0","2016-03-12 14:30:05","2016-03-12 09:30:05","1","0","0","both"),
("110","105","3/12/2016","51","53","1","1","0","2016-03-12 15:19:34","2016-03-12 10:19:34","1","0","0","both"),
("111","105","3/12/2016","53","55","1","1","0","2016-03-12 15:19:46","2016-03-12 10:19:46","1","0","0",""),
("144","105","05/26/2016","85","87","1","1","0","2016-05-25 12:09:13","2016-05-25 08:09:13","1","0","0",""),
("145","105","05/27/2016","5","9","1","1","0","2016-05-26 06:33:43","2016-06-07 04:06:13","1","0","0",""),
("146","105","06/22/2016","13","14","1","1","0","2016-06-20 06:24:28","2016-06-20 02:24:28","","0","0",""),
("147","158","06/20/2016","25","27","1","1","0","2016-06-20 07:00:49","2016-06-20 03:00:49","1","0","0","mail"),
("148","158","06/20/2016","35","37","1","1","0","2016-06-20 07:05:29","2016-06-20 03:05:29","1","0","0","mail"),
("149","158","06/20/2016","84","86","1","1","0","2016-06-20 07:19:31","2016-06-20 03:33:14","1","0","0","both"),
("150","158","06/20/2016","81","83","1","1","0","2016-06-20 07:42:29","2016-06-20 03:42:29","1","0","0","mail"),
("151","158","06/20/2016","85","87","1","1","0","2016-06-20 07:47:18","2016-06-20 03:47:18","1","0","0","mail"),
("153","158","06/20/2016","85","87","1","1","0","2016-06-20 07:48:00","2016-06-20 03:48:25","1","0","0","both"),
("154","158","06/20/2016","85","87","1","1","0","2016-06-20 07:48:21","2016-06-20 03:53:00","1","0","0","both"),
("155","158","06/20/2016","86","88","1","1","0","2016-06-20 07:59:23","2016-06-20 03:59:23","1","0","0","both"),
("156","158","06/20/2016","87","89","1","1","0","2016-06-20 08:00:39","2016-06-20 04:00:39","1","0","0","mail"),
("157","158","06/20/2016","87","89","1","1","0","2016-06-20 08:00:51","2016-06-20 04:00:51","1","0","0","mail"),
("158","158","06/20/2016","87","89","1","1","0","2016-06-20 08:01:40","2016-06-20 04:01:40","1","0","0","mail"),
("159","158","06/20/2016","87","89","1","1","0","2016-06-20 08:02:01","2016-06-20 04:02:01","1","0","0","mail"),
("160","158","06/20/2016","89","91","1","1","0","2016-06-20 08:05:54","2016-06-20 04:05:54","1","0","0","sms");

("0","160","06/20/2016","87","89","1","1","0","2016-06-20 08:00:39","2016-06-20 04:00:39","1","0","0","mail"),
("0","160","06/20/2016","87","89","1","1","0","2016-06-20 08:00:51","2016-06-20 04:00:51","1","0","0","mail"),
("0","160","06/20/2016","87","89","1","1","0","2016-06-20 08:01:40","2016-06-20 04:01:40","1","0","0","mail"),
("0","160","06/20/2016","87","89","1","1","0","2016-06-20 08:02:01","2016-06-20 04:02:01","1","0","0","mail"),
("0","160","06/20/2016","89","91","1","1","0","2016-06-20 08:05:54","2016-06-20 04:05:54","1","0","0","sms");




CREATE TABLE `tbl_attachment` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `attachment` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(25) NOT NULL,
  `patient_id` int(25) NOT NULL,
  `clinic_id` int(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO tbl_attachment( `id`, `attachment`, `created_date`, `created_by`, `patient_id`, `clinic_id` ) VALUES
("12","","2015-10-16 22:15:02","1","76","1"),
("11","","2015-10-16 22:12:58","1","77","1"),
("10","","2015-10-16 22:05:09","1","76","1");




CREATE TABLE `tbl_form_master` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `form_title` varchar(100) DEFAULT NULL,
  `clinic_id` bigint(30) DEFAULT NULL,
  `file_path` varchar(200) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `clinic_id_2` (`clinic_id`),
  KEY `clinic_id_3` (`clinic_id`),
  CONSTRAINT `clinic_form_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

INSERT INTO tbl_form_master( `id`, `form_title`, `clinic_id`, `file_path`, `created_date`, `modified_date` ) VALUES
("6","0006A_(1)","1","1441953564_0006A_(1).pdf","2015-09-11 06:39:24","2015-09-11 12:09:24"),
("7","0032A","1","1441953604_0032A.pdf","2015-09-11 06:40:04","2015-09-11 12:10:04"),
("8","0041A","1","1441953631_0041A.pdf","2015-09-11 06:40:31","2015-09-11 12:10:31"),
("9","0806A","1","1441953654_0806A.pdf","2015-09-11 06:40:54","2015-09-11 12:10:54"),
("10","2144A","1","1441953681_2144A.pdf","2015-09-11 06:41:21","2015-09-11 12:11:21"),
("11","1824A","1","1441953709_1824A.pdf","2015-09-11 06:41:49","2015-09-11 12:11:49"),
("12","2232A","1","1441953738_2232A.pdf","2015-09-11 06:42:18","2015-09-11 12:12:18"),
("13","2397A_ITO","1","1441953783_2397A_ITO.pdf","2015-09-11 06:43:03","2015-09-11 12:13:03"),
("14","2647A0706","1","1441953813_2647A0706.pdf","2015-09-11 06:43:33","2015-09-11 12:13:33"),
("15","2721A","1","1441953835_2721A.pdf","2015-09-11 06:43:55","2015-09-11 12:13:55"),
("16","2929A","1","1441953865_2929A.pdf","2015-09-11 06:44:25","2015-09-11 12:14:25"),
("17","2996A_11_10_F","1","1441953890_2996A_11_10_F.pdf","2015-09-11 06:44:50","2015-09-11 12:14:50"),
("18","3074A","1","1441953922_3074A.pdf","2015-09-11 06:45:22","2015-09-11 12:15:22"),
("19","3164A","1","1441953955_3164A.pdf","2015-09-11 06:45:55","2015-09-11 12:15:55"),
("20","3306A_ClothingAllowanceApplication","1","1441954010_3306A_ClothingAllowanceApplication.pdf","2015-09-11 06:46:50","2015-09-11 12:16:50"),
("21","3585A","1","1441954061_3585A.pdf","2015-09-11 06:47:41","2015-09-11 12:17:41"),
("22","3958a","1","1441954090_3958a.pdf","2015-09-11 06:48:10","2015-09-11 12:18:10"),
("23","CEIRFormWkr","1","1441954118_CEIRFormWkr.pdf","2015-09-11 06:48:38","2015-09-11 12:18:38");




CREATE TABLE `tbl_inventory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) DEFAULT NULL,
  `clinic_id` bigint(30) NOT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `stock_count` int(10) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `category_id` (`category_id`),
  KEY `category_id_2` (`category_id`),
  KEY `clinic_id_2` (`clinic_id`),
  CONSTRAINT `category_inventory_fk` FOREIGN KEY (`category_id`) REFERENCES `tbl_inventory_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clinic_inventory_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

INSERT INTO tbl_inventory( `id`, `category_id`, `clinic_id`, `item_name`, `stock_count`, `created_date`, `modified_date` ) VALUES
("21","1","1","gloves","10","2015-09-12 11:19:04","2015-09-18 14:16:02"),
("22","1","1","new item","50","2015-09-12 11:45:49","2015-09-12 17:17:20"),
("23","15","1","first aids treatment box","100","2015-09-18 08:49:22","2015-09-18 14:19:22"),
("25","12","1","Test","100","2016-01-16 09:40:09","2016-01-16 04:40:09");




CREATE TABLE `tbl_inventory_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
  `clinic_id` bigint(30) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  CONSTRAINT `clinc_inventory_category_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

INSERT INTO tbl_inventory_category( `id`, `category_name`, `clinic_id`, `created_date`, `modified_date` ) VALUES
("1","category1","1","2015-08-08 06:12:04","2015-08-08 18:42:04"),
("12","category2","1","2015-09-12 11:14:43","2015-09-12 16:44:43"),
("14","category4","1","2015-09-12 11:48:30","2015-09-12 17:18:30"),
("15","category66","1","2015-09-18 08:48:39","2015-09-18 14:18:39"),
("17","category11","1","2016-01-16 09:40:44","2016-01-16 04:40:44");




CREATE TABLE `tbl_patient_additional_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `do_you_have_extended_health_covrage` varchar(255) DEFAULT NULL,
  `number` int(25) DEFAULT NULL,
  `do_you_wont_smoke` varchar(255) DEFAULT NULL,
  `do_you_excercise` varchar(255) DEFAULT NULL,
  `excercise_time_per_week` varchar(255) DEFAULT NULL,
  `do_you_sleep` varchar(255) DEFAULT NULL,
  `hours_of_sleep` varchar(255) DEFAULT NULL,
  `accident` varchar(255) DEFAULT NULL,
  `past_surgeries` varchar(255) DEFAULT NULL,
  `medication` varchar(255) DEFAULT NULL,
  `family_health` varchar(255) DEFAULT NULL,
  `patient_name_history` varchar(255) DEFAULT NULL,
  `dob_patient_history` varchar(255) DEFAULT NULL,
  `file_no_patient` int(25) DEFAULT NULL,
  `date_patient_history` int(25) DEFAULT NULL,
  `name_declaration_consent` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `dated_consent` varchar(255) DEFAULT NULL,
  `patient_name_consent` varchar(255) DEFAULT NULL,
  `dob_consent` varchar(255) DEFAULT NULL,
  `fileno_consent` int(25) DEFAULT NULL,
  `date_consent` varchar(255) DEFAULT NULL,
  `clinic_id` int(25) DEFAULT NULL,
  `user_id` int(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

INSERT INTO tbl_patient_additional_details( `id`, `do_you_have_extended_health_covrage`, `number`, `do_you_wont_smoke`, `do_you_excercise`, `excercise_time_per_week`, `do_you_sleep`, `hours_of_sleep`, `accident`, `past_surgeries`, `medication`, `family_health`, `patient_name_history`, `dob_patient_history`, `file_no_patient`, `date_patient_history`, `name_declaration_consent`, `signature`, `dated_consent`, `patient_name_consent`, `dob_consent`, `fileno_consent`, `date_consent`, `clinic_id`, `user_id` ) VALUES
("1","","","","","","","","","","","","","","","","","","","","","","","1","105"),
("11","no","20","yes","no","morning","no","8hr","no","yes","no","good","no","25","25","10","no","shiv","monday","madhrasi","yes","4","friday","1","36"),
("12","no","20","yes","no","morning","no","8hr","no","yes","no","good","no","25","25","10","no","shiv","monday","madhrasi","yes","4","friday","1","36"),
("25","","0","no","no","cvcv","no","ccvcv","cvc","cvcvcvcv","cvc","cvcv","cvcv","18-6-2016","0","18","cvccvcvcv","","18-6-2016","xcxvvc","18-6-2016","0","18-6-2016","1","185"),
("26","","0","no","no","cvcv","no","ccvcv","cvc","cvcvcvcv","cvc","cvcv","cvcv","18-6-2016","0","18","cvccvcvcv","","18-6-2016","xcxvvc","18-6-2016","0","18-6-2016","1","186"),
("27","","0","no","no","cvcv","no","ccvcv","cvc","cvcvcvcv","cvc","cvcv","cvcv","18-6-2016","0","18","cvccvcvcv","","18-6-2016","xcxvvc","18-6-2016","0","18-6-2016","1","187"),
("28","","1","no","no","8","no","8","tt","tt","tt","tt","tt","21-6-2016","0","22","tt","","11-6-2016","rock","21-6-2016","0","19-7-2016","1","189"),
("29","","0","no","no","5","no","5","5","rr","rr","rr","rr","20-6-2016","0","20","rrr","","20-6-2016","tt","20-6-2016","0","20-6-2016","1","190");




CREATE TABLE `tbl_patient_clinic_relation` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `clinic_id` bigint(30) NOT NULL,
  `patient_id` bigint(30) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `patient_id` (`patient_id`),
  KEY `patient_id_2` (`patient_id`),
  CONSTRAINT `clinic_patient_relation_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

INSERT INTO tbl_patient_clinic_relation( `id`, `clinic_id`, `patient_id`, `created_date` ) VALUES
("2","1","1","2015-07-31 15:40:44"),
("42","1","42","2015-09-08 16:04:37"),
("43","1","43","2015-09-08 16:11:12"),
("44","1","44","2015-09-12 08:12:25");




CREATE TABLE `tbl_patient_payments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(30) NOT NULL,
  `doctor_id` bigint(30) NOT NULL,
  `clinic_id` bigint(30) NOT NULL,
  `date` varchar(500) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `item_desc` varchar(255) NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `clinic_id` (`clinic_id`),
  CONSTRAINT `clinik_patient_payments_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `doctor_patient_payments_fk` FOREIGN KEY (`doctor_id`) REFERENCES `tbl_user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `patient_patient_payments_fk` FOREIGN KEY (`patient_id`) REFERENCES `tbl_user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

INSERT INTO tbl_patient_payments( `id`, `patient_id`, `doctor_id`, `clinic_id`, `date`, `amount`, `item_desc`, `status`, `payment_method`, `created_date`, `modified_date`, `created_by` ) VALUES
("41","105","60","1","01/12/2016","500","Charges","Pending","DebitCard","2016-01-19 12:28:59","2016-01-19 07:28:59","1"),
("43","105","60","1","01/30/2016","5000","Charges","Paid","DebitCard","2016-01-20 17:07:22","2016-01-20 12:07:22","1"),
("47","105","1","1","02/17/2016","888","Charges","Paid","Insurance","2016-02-10 15:05:06","2016-02-10 10:05:06","1"),
("48","105","1","1","02/17/2016","888","Charges","Paid","Insurance","2016-02-10 15:28:49","2016-02-10 10:28:49","1"),
("53","103","1","1","04/13/2016","50000","Charges description1","Paid","Cash","2016-04-20 12:27:08","2016-04-21 08:31:42","1"),
("54","105","60","1","04/21/2016","50000","Item Test12","Paid","Cash","2016-04-21 11:49:57","2016-04-21 08:30:53","1"),
("55","105","60","1","04/21/2016","100000","Descriptions12345","Paid","Cash","2016-04-21 12:28:09","2016-04-21 08:30:12","1");




CREATE TABLE `tbl_patients_master` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `mobile_no` varchar(100) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `clinic_id` bigint(30) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pincode` varchar(100) NOT NULL,
  `emer_mobile_no` varchar(100) NOT NULL,
  `profile_image` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `clinic_id_2` (`clinic_id`),
  CONSTRAINT `clinic_patient_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;






CREATE TABLE `tbl_patients_notes` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `notes` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `doctor_id` int(25) NOT NULL,
  `status` varchar(100) NOT NULL,
  `patient_id` int(25) NOT NULL,
  `clinic_id` int(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

INSERT INTO tbl_patients_notes( `id`, `notes`, `created_date`, `doctor_id`, `status`, `patient_id`, `clinic_id` ) VALUES
("1","Notes Check out closed","2016-01-27 07:58:22","1","Close","105","1"),
("2","notes new update","2016-01-27 08:20:17","1","Open","105","1"),
("5","dasd d asd","2016-02-03 13:28:14","1","Open","81","1"),
("6","hjggjygjygjyjg","2016-02-21 12:47:05","1","Close","81","1"),
("11","dadsd d sdsd","2016-03-29 11:47:26","43","Close","103","1"),
("12","dasdasdas","2016-03-29 11:49:33","60","Open","81","1"),
("13","dad asda adsas asdas sdasd asd dasd asd sdasd asds asd saas dasd sad asdas asd","2016-03-29 11:51:52","1","Open","81","1"),
("14","da dasd d\ndasDSA\nDdAS\ndDas\ndAS\nasDSd\nSAD\nasDASd\nASD\nasDAsd","2016-03-29 11:52:13","1","Open","81","1"),
("15","1\n2\n3\n4\n5\n6\n7\n8\n9\n0","2016-03-29 11:52:41","1","Open","81","1"),
("16","dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda dad asds sad dasdasdasd asd sadasd asdas asdas dasd asdasdasd sadas asda sdasd sda dasd asda sdadasda","2016-03-29 11:53:25","1","Open","81","1");




CREATE TABLE `tbl_payment_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_id` bigint(30) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_id` varchar(100) NOT NULL,
  `user_id` bigint(30) NOT NULL,
  `status` varchar(100) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `clinic_id` (`clinic_id`),
  CONSTRAINT `tbl_payment_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_payment_details_ibfk_2` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

INSERT INTO tbl_payment_details( `id`, `clinic_id`, `created_date`, `payment_id`, `user_id`, `status`, `ip_address`, `price`, `message` ) VALUES
("1","1","2015-10-04 11:28:48","ch_16sAfcB10w6wXwycpkPABw6I","1","succeeded","43.248.38.206","200",""),
("2","1","2015-10-04 11:54:38","ch_16sB4cB10w6wXwycHz0nCmh3","1","Payment completed successfully.","43.248.38.206","0","Congratulations, you\'re purchase of  is now complete. Your credit card ending in 4242 has been processed already. Now You can use the Vettree Files Applications.<a href=\'http://vettreefiles.com\'>Click Here</a>."),
("5","1","2015-11-08 12:24:49","","1","Payment Failed.","43.248.36.165","0","No such plan: Subscription 3"),
("6","1","2015-11-08 12:25:53","cus_7JVFNOnQ8Cj1k1","1","Payment completed successfully.","43.248.36.165","0","Congratulations, you\'re purchase of  is now complete. Your credit card ending in 4242 has been processed already. Now You can use the Vettree Files Applications.<a href=\'http://vettreefiles.com\'>Click Here</a>."),
("7","1","2015-11-08 12:31:56","cus_7JVLOFNU2EQ3K4","1","Payment completed successfully.","43.248.36.165","0","Congratulations, you\'re purchase of  is now complete. Your credit card ending in 4242 has been processed already. Now You can use the Vettree Files Applications.<a href=\'http://vettreefiles.com\'>Click Here</a>."),
("10","1","2015-12-18 17:03:17","cus_7YYkqtgYGYBWGN","1","Payment completed successfully.","45.126.144.163","0","Congratulations, you\'re purchase of  is now complete. Your credit card ending in 4242 has been processed already. Now You can use the Vettree Files Applications.<a href=\'http://vettreefiles.com\'>Click Here</a>."),
("12","1","2016-01-19 11:31:12","","1","Payment Failed.","45.126.147.117","0","You passed an empty string for \'plan\'. We assume empty values are an attempt to unset a parameter; however \'plan\' cannot be unset. You should remove \'plan\' from your request or supply a non-empty value."),
("18","1","2016-02-21 12:33:02","cus_7wq4ktHPEYkJoE","1","Payment completed successfully.","202.71.4.9","0","Congratulations, you\'re purchase of  is now complete. Your credit card ending in 4242 has been processed already. Now You can use the Vettree Files Applications.<a href=\'http://vettreefiles.com\'>Click Here</a>."),
("19","1","2016-03-21 15:36:15","cus_87kZZTjDfaUzmE","1","Payment completed successfully.","175.100.146.193","0","Congratulations, you\'re purchase of  is now complete. Your credit card ending in 4242 has been processed already. Now You can use the Vettree Files Applications.<a href=\'http://vettreefiles.com\'>Click Here</a>.");




CREATE TABLE `tbl_timeslot_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `time_slot_start` int(25) DEFAULT NULL,
  `time_slot_end` int(25) NOT NULL,
  `clinic_id` bigint(30) NOT NULL,
  `user_id` bigint(30) NOT NULL,
  `date` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `clinic_timeslot_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_timeslot_fk` FOREIGN KEY (`user_id`) REFERENCES `tbl_user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO tbl_timeslot_master( `id`, `time_slot_start`, `time_slot_end`, `clinic_id`, `user_id`, `date`, `created_date`, `modified_date` ) VALUES
("2","13","69","1","1","03/14/2016","2016-03-14 16:40:59","2016-03-14 12:40:59"),
("3","13","20","1","1","03/24/2016","2016-03-14 16:42:48","2016-03-14 12:42:48"),
("4","15","20","1","1","03/19/2016","2016-03-14 16:43:17","2016-03-14 12:43:17");




CREATE TABLE `tbl_user_clinic_relation` (
  `id` bigint(30) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(30) NOT NULL,
  `clinic_id` bigint(30) NOT NULL,
  `role_id` int(10) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `clinic_id` (`clinic_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `clinic_clinic_relation_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `doctor_clinic_relation_fk` FOREIGN KEY (`user_id`) REFERENCES `tbl_user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_clinic_relation_fk` FOREIGN KEY (`role_id`) REFERENCES `tbl_role_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=latin1;

INSERT INTO tbl_user_clinic_relation( `id`, `user_id`, `clinic_id`, `role_id`, `created_date` ) VALUES
("1","1","1","2","2015-07-31 08:47:01"),
("61","60","1","3","2015-09-25 12:25:35"),
("84","83","1","1","2015-10-23 21:06:00"),
("105","103","1","5","2016-01-16 09:23:33"),
("107","105","1","5","2016-01-19 12:26:01"),
("160","158","1","5","2016-05-11 08:58:34"),
("169","167","1","5","2016-06-15 07:27:13"),
("187","185","1","5","2016-06-18 07:42:29"),
("188","186","1","5","2016-06-18 07:49:54"),
("189","187","1","5","2016-06-18 07:54:22"),
("191","189","1","5","2016-06-18 09:54:13"),
("192","190","1","5","2016-06-20 13:36:10");




CREATE TABLE `tbl_user_waiting` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `reason_for` varchar(255) NOT NULL,
  `problem_begin` varchar(255) NOT NULL,
  `similar_symptoms_past` varchar(255) NOT NULL,
  `symptoms_better` varchar(255) NOT NULL,
  `symptoms_worse` varchar(255) NOT NULL,
  `treatment_concren` varchar(255) NOT NULL,
  `treatment` text NOT NULL,
  `distress_scale` varchar(255) NOT NULL,
  `user_id` int(25) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` int(25) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `clinic_id` int(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

INSERT INTO tbl_user_waiting( `id`, `reason_for`, `problem_begin`, `similar_symptoms_past`, `symptoms_better`, `symptoms_worse`, `treatment_concren`, `treatment`, `distress_scale`, `user_id`, `date`, `status`, `created_date`, `clinic_id` ) VALUES
("1","testtest","testsetsetset","","tsetsetset","testsetset","yes","stsetsetset","","105","05/11/2016 18:49","1","2016-05-11 13:19:33","1"),
("2","drfgdrgd","ggrgadrgg","yes","rdgbft","bsbnthnt","yes","bfsbsrhb","nopain","105","05/11/2016 18:56","0","2016-05-11 13:26:44","1"),
("3","drfgdrgd","testsetsetset","yes","tsetsetset","testsetset","yes","fghfgnhfn","nopain","103","05/11/2016 18:59","1","2016-05-11 13:29:24","1"),
("4","test","test","no","test","test","no","test","unbearablepain","105","05/11/2016 19:22","1","2016-05-11 13:53:10","1"),
("5","","","yes","","","yes","","nopain","103","05/11/2016 20:32","1","2016-05-11 14:55:26","1"),
("6","","","","","","","","","0","","1","2016-06-09 07:33:24","1"),
("7","","","yes","","","yes","","nopain","105","06/09/2016 13:4","1","2016-06-09 07:37:52","1"),
("8","test","test","yes","test","test","no","treatment","moderatepain","0","06/09/2016 13:10","1","2016-06-09 07:38:42","1"),
("9","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016 13:10","1","2016-06-09 07:40:09","1"),
("10","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016 13:15","1","2016-06-09 07:40:18","1"),
("11","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016","1","2016-06-14 13:19:43","1"),
("12","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016","1","2016-06-14 13:19:43","1"),
("14","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016 13:15","1","2016-06-14 13:21:55","1"),
("15","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016 13:15","1","2016-06-14 13:22:01","1"),
("16","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016","1","2016-06-14 14:17:15","1"),
("17","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016","1","2016-06-14 14:24:43","1"),
("18","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016 13:15","1","2016-06-15 04:55:46","1"),
("19","test","test","yes","test","test","no","treatment","moderate pain","105","06/09/2016 13:15","1","2016-06-15 05:00:49","1"),
("20","test","test","yes","test","test","no","treatment","moderate pain","105","06/09/2016","1","2016-06-15 05:59:39","1"),
("24","ttt","tt","No","tt","tt","No","ttt","","1","17/6/2016 12:22","1","2016-06-15 06:53:11","1"),
("25","ttt","tt","No","tt","tt","No","ttt","","1","17/6/2016 12:22","1","2016-06-15 06:53:15","1"),
("26","vcbvvc","vcbvc","No","cvbvcvcvcvcb","vcvc","No","vcbcvb","","1","16/6/2016 12:25","1","2016-06-15 06:55:20","1"),
("27","tt","tt","No","tt","tt","No","tt","","158","16/6/2016 12:30","1","2016-06-15 07:02:52","1"),
("28","tt","tt","No","tt","tt","No","tt","","158","16/6/2016 12:30","1","2016-06-15 07:02:54","1"),
("29","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016","1","2016-06-15 07:17:54","1"),
("30","test","test","yes","test","test","no","treatment","moderatepain","105","06/09/2016","1","2016-06-15 10:24:05","1"),
("31","cc","cc","No","cc","cc","No","c","No Pain","105","2016/05/15 04:28 PM","1","2016-06-15 11:07:50","1"),
("32","cc","cc","No","cc","cc","No","c","No Pain","105","2016/05/15 04:38 PM","1","2016-06-15 11:08:35","1"),
("33","test1","t2","No","t3","t4","No","t5","Moderate Pain","105","2016/05/15 04:38 PM","1","2016-06-15 11:09:51","1"),
("34","test1","t2","No","t3","t4","No","t5","Moderate Pain","105","2016/05/15 04:38 PM","1","2016-06-15 11:11:26","1"),
("35","test1","t2","no","t3","t4","no","t5","Moderate Pain","105","2016/05/15 04:38 PM","1","2016-06-15 11:13:07","1"),
("36","t1","t2","no","t4","t5","no","t6","Unbearable pain","103","2016/05/15 04:44 PM","1","2016-06-15 11:14:54","1"),
("37","te1","te2","no","te3","te4","no","te5","unbearable pain","158","2016/05/15 04:46 PM","1","2016-06-15 11:16:34","1"),
("38","te1","te2","no","te3","te4","no","te5","unbearable pain","158","2016/05/15 04:46 PM","1","2016-06-15 11:17:36","1"),
("39","te1","te2","no","te3","te4","no","te5","unbearablepain","158","2016/05/15 05:46 PM","1","2016-06-15 11:17:59","1"),
("40","te1","te2","No","te3","te4","No","te5","Unbearable pain","158","2016/05/16 05:46 PM","1","2016-06-15 11:24:55","1"),
("41","te1","te2","no","te3","te4","no","te5","unbearable pain","158","2016/05/26 05:46 PM","1","2016-06-15 11:27:15","1"),
("42","test","test","no","test","test","no","treatment","unbearablepain","105","07/09/2016","1","2016-06-15 11:36:00","1"),
("43","test","test","no","test","test","no","treatment","unbearable pain","105","07/09/2016","1","2016-06-15 11:36:33","1"),
("44","test","test","no","test","test","no","treatment","Unbearable pain","105","07/09/2016","1","2016-06-15 11:36:46","1"),
("45","test","test","no","test","test","no","treatment","Unbearable Pain","105","07/09/2016","1","2016-06-15 11:37:18","1"),
("46","test","test","no","test","test","no","treatment","Unbearable","105","","1","2016-06-15 11:37:58","1"),
("47","test","test","no","test","test","no","treatment","Unbearable Pain","105","07/09/2016","1","2016-06-15 11:38:23","1"),
("51","test","test","no","test","test","no","treatment","% %","105","07/09/2016","1","2016-06-15 11:48:10","1"),
("52","test","test","no","test","test","no","treatment","Unbearable %Pain","105","07/09/2016","1","2016-06-15 12:21:46","1"),
("53","test","test","no","test","test","no","treatment","Unbearable %Pain","105","07/09/2016","1","2016-06-15 12:21:54","1"),
("54","test","test","no","test","test","no","treatment","UnbearablePain","105","07/09/2016","1","2016-06-15 12:28:16","1"),
("55","testeee","teste","no","test","test","no","treatment","unbearablepain","105","07/09/2016","1","2016-06-15 12:29:12","1"),
("56","testeee","teste","no","test","test","no","treatment","unbearablepain","106","07/09/2016","1","2016-06-15 12:30:49","1"),
("57","","","","","","","","","0","","1","2016-06-16 13:15:12","1"),
("58","tttyyg","yo","no","cv","gh","no","gv","Unbearable pain","103","2016/05/16 06:57 PM","1","2016-06-16 13:27:47","1"),
("59","ffg","fg","no","fg","ghty","no","tt","Moderate Pain","105","2016/05/16 07:02 PM","1","2016-06-16 13:32:19","1"),
("60","gh","bhgh","no","hh","hjhh","no","gh","Moderate Pain","105","2016/05/16 07:04 PM","1","2016-06-16 13:34:47","1"),
("61","ghh","gh","no","ty","hy","no","yy","Moderate Pain","167","2016/05/16 07:23 PM","1","2016-06-16 13:53:46","1"),
("73","vv","vv","no","vvv","vv","no","vvv","Unbearable pain","185","18-6-2016","1","2016-06-18 07:42:29","1"),
("74","vv","vv","no","vvv","vv","no","vvv","Unbearable pain","186","18-6-2016","1","2016-06-18 07:49:54","1"),
("75","vv","vv","no","vvv","vv","no","vvv","Unbearable pain","187","18-6-2016","1","2016-06-18 07:54:22","1"),
("76","test1","test2","no","better","worse","no","test","Unbearable pain","189","18-6-2016","1","2016-06-18 09:54:13","1"),
("77","yyy","yyyy","no","yyyy","hhh","no","rrr","Moderate Pain","190","20-6-2016","1","2016-06-20 13:36:10","1");




CREATE TABLE `tbl_worked_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(30) NOT NULL,
  `clinic_id` bigint(30) NOT NULL,
  `date` varchar(100) DEFAULT NULL,
  `in_time` varchar(100) DEFAULT NULL,
  `out_time` varchar(100) DEFAULT NULL,
  `break_in_time` varchar(100) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `break_out_time` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `clinic_id` (`clinic_id`),
  CONSTRAINT `clinic_worked_log_fk` FOREIGN KEY (`clinic_id`) REFERENCES `tbl_clinic_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_worked_log_fk` FOREIGN KEY (`user_id`) REFERENCES `tbl_user_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

INSERT INTO tbl_worked_log( `id`, `user_id`, `clinic_id`, `date`, `in_time`, `out_time`, `break_in_time`, `created_date`, `modified_date`, `break_out_time` ) VALUES
("7","1","1","09/10/2015","08:00","19:02","12:00","2015-09-10 05:44:17","2015-09-12 12:11:45","12:00"),
("8","1","1","09/09/2015","09:31","18:31","12:00","2015-09-11 11:29:02","2015-09-11 16:59:02","12:00"),
("10","1","1","09/12/2015","08:10","18:00","12:00","2015-09-12 09:56:14","2015-09-12 15:26:55","12:00");


SET FOREIGN_KEY_CHECKS=1;
COMMIT;