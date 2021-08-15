-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for sp-rest-api
CREATE DATABASE IF NOT EXISTS `sp-rest-api` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sp-rest-api`;

-- Dumping structure for table sp-rest-api.config
CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '0',
  `value` varchar(1000) NOT NULL DEFAULT '0',
  `notes` varchar(500) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table sp-rest-api.config: ~12 rows (approximately)
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` (`id`, `name`, `value`, `notes`) VALUES
	(1, 'sp_site_name', 'Paiton Dev', '0'),
	(2, 'sp_site_path', '/sites/PaitonDev', 'sub sites path only'),
	(3, 'client_id', '4b6a-a258-a04ff57e', 'sharepoint sites app principals\r\nhttps://paitonoperation.sharepoint.com/sites/PaitonDev/_layouts/15/appprincipals.aspx\r\nto create :\r\nhttps://paitonoperation.sharepoint.com/sites/PaitonDev/_layouts/15/appregnew.aspx\r\n '),
	(4, 'client_secret', '3V33BQ3XhvcyW6EaH4=', '0'),
	(5, 'app_domain', 'wira.localhost', '0'),
	(6, 'redirect_uri', 'https://wira.localhost', '0'),
	(7, 'tenant_id', 'b1ce-7114ab0c3a33', 'tenant ID , azure directory ID, see. https://portal.azure.com/#settings/directory'),
	(8, 'audience_principal_id', '000000000000', 'request get to -> https://<mysite.sharepoint.com>/_vti_bin/client.svc   with header Authorization: Bearer'),
	(9, 'authorization_code', '9gHGe1IepOmMMOt61_sv3T6dTArDnDSl5SZJbwoV3fYypiM7cTLA5j8xTyj0rpcQr9pfWCp94V-k0CkEHSATlnFvsN_X9UyvcSieJ7E2Z0VdIHjFLZskMBJdp97yGL_sxkc0L4PYwQbC3Qt4DPwbt6fetoKDqvVDzeqk0vwo9s6tNUZDdrSJ_gP3iH9hwslgIAA', '/doAzureACS'),
	(10, 'access_token', '4QUNFMDM3NiJ9.Y9Pkaqk6Co376C9v6EcajReNwZFH0TXODKVNVC6lyGrAi1sPgCnAyq1lD18N_niSb4HyGV6_aw4gvkjhc-zPCMWYMNfNjQkadPDP_sNjUVKVvPrh88vV9Pe2uraWIDOvEMMYwBoq8onMfHtcm7UsHKm8QwPUu8xXm3TUoCCyACf0-T_02TSFeStKtaKj9cVY7DjCI2NYg4Cei--d5vzgzGBEKtxvsh2yXaE9fbZbL-1tmd-aFz54eGREJoXt5BiKsqYlns57lUE3S8exF6_EoY9Se-MnYv8p-NrNSlYa0jqn5Rp_fhTUFv4Q_T86o8', ''),
	(11, 'refresh_token', 'sdbHxv4_xcHQinZF3YUHbfcnNR3dBoyAA', '/doAccessToken'),
	(13, 'sp_site', 'paitonoperation.sharepoint.com', 'main sharepoint site name');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
