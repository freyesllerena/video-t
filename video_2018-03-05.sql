# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 127.0.0.1 (MySQL 5.5.5-10.2.13-MariaDB)
# Base de données: video
# Temps de génération: 2018-03-05 05:47:19 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table categorie
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categorie`;

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;

INSERT INTO `categorie` (`id`, `name`)
VALUES
	(1,'comédie'),
	(2,'horreur'),
	(3,'action'),
	(4,'drame'),
	(5,'aventure'),
	(6,'fantastique');

/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table compteur
# ------------------------------------------------------------

DROP TABLE IF EXISTS `compteur`;

CREATE TABLE `compteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `compteur` WRITE;
/*!40000 ALTER TABLE `compteur` DISABLE KEYS */;

INSERT INTO `compteur` (`id`, `total`)
VALUES
	(1,11);

/*!40000 ALTER TABLE `compteur` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table film
# ------------------------------------------------------------

DROP TABLE IF EXISTS `film`;

CREATE TABLE `film` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_insertion` datetime DEFAULT NULL,
  `categorie` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `film` WRITE;
/*!40000 ALTER TABLE `film` DISABLE KEYS */;

INSERT INTO `film` (`id`, `titre`, `description`, `photo`, `date_insertion`, `categorie`)
VALUES
	(21,'3 BILLBOARDS, LES PANNEAUX DE LA VENGEANCE','Après des mois sans que l\'enquête sur la mort de sa fille ait avancé, Mildred Hayes prend les choses en main, affichant un message controversé visant le très respecté chef de la police sur trois grands panneaux à l\'entrée de leur ville.','187c321b45d4dafd9027fad9fda65993.jpeg','2018-03-05 05:31:19','drame'),
	(22,'BELLE ET SEBASTIEN 3 : LE DERNIER CHAPITRE','Deux ans ont passé. Sébastien est à l\'aube de l\'adolescence et Belle est devenue maman de trois adorables chiots. Pierre et Angelina sont sur le point de se marier et rêvent d\'une nouvelle vie, ailleurs... Au grand dam de Sébastien qui refuse de quitter sa montagne. Lorsque Joseph, l\'ancien maître de Belle, ressurgit bien décidé à récupérer sa chienne, Sébastien se retrouve face à une terrible menace. Plus que jamais, il va devoir tout mettre en œuvre pour protéger son amie et ses petits...','6cbac1263039fc3e97462557ff3d505c.jpeg','2018-03-05 05:32:37','aventure'),
	(23,'BEST OF POLAR SNCF','Une sélection “ Best of ” du Prix du Polar SNCF. Revivez les meilleures enquêtes et les plus grands succès du festival officiel des voyageurs français. L\'ACCORDEUR de Olivier Treiner ; KÉROSÈNE de Joachim Weissmann ; PENNY DREADFUL de Shane Atkinson ; CARJACK de Jeremiah Jones ; MR. INVISIBLE de Greg Ash ; HASTA QUE LA CELDA NOS SEPARE de Mariana Emmanuelli, Joserro Emmanuelli','ce1f196128a95bee7678754cb8566028.jpeg','2018-03-05 05:33:27','comédie'),
	(24,'BLACK PANTHER','Après les événements qui se sont déroulés dans Captain America : Civil War, T’Challa revient chez lui prendre sa place sur le trône du Wakanda, une nation africaine technologiquement très avancée. Mais lorsqu’un vieil ennemi resurgit, le courage de T’Challa est mis à rude épreuve, aussi bien en tant que souverain qu’en tant que Black Panther. Il se retrouve entraîné dans un conflit qui menace non seulement le destin du Wakanda, mais celui du monde entier…','7422446f869a0fc0f6a84b4fe8f52edf.jpeg','2018-03-05 05:34:46','action'),
	(25,'CARNIVORES','Mona rêve depuis toujours d’être comédienne.Au sortir du Conservatoire, elle est promise à un avenir brillant mais c’est Sam, sa sœur cadette, qui se fait repérer et devient rapidement une actrice de renom.À l’aube de la trentaine, à court de ressources, Mona est contrainte d’emménager chez sa sœur qui, fragilisée par un tournage éprouvant, lui propose de devenir son assistante.Sam néglige peu à peu son rôle d\'actrice, d\'épouse, de mère et finit par perdre pied. Ces rôles que Sam délaisse, Mona comprend qu\'elle doit s\'en emparer.','daee53d9de8926710ae4931d4ccaa659.jpeg','2018-03-05 05:37:36','drame'),
	(26,'CHARLOT FESTIVAL','Programme de 3 films : CHARLOT PATINE - CHARLOT POLICEMAN - CHARLOT EMIGRANT','52ad35380deb88068345a0d01ebe9c05.jpeg','2018-03-05 05:38:31','comédie'),
	(27,'LA CH\'TITE FAMILLE','Valentin D. et Constance Brandt, un couple d’architectes designers en vogue préparent le vernissage de leur rétrospective au Palais de Tokyo. Mais ce que personne ne sait, c’est que pour s’intégrer au monde du design et du luxe parisien, Valentin a menti sur ses origines prolétaires et ch\'tis. Alors, quand sa mère, son frère et sa belle-sœur débarquent par surprise au Palais de Tokyo, le jour du vernissage, la rencontre des deux mondes est fracassante. D’autant plus que Valentin, suite à un accident, va perdre la mémoire et se retrouver 20 ans en arrière, plus ch’ti que jamais !','6025037784b30e5f20358867857dd0ff.jpeg','2018-03-05 05:39:56','comédie'),
	(28,'CALL ME BY YOUR NAME','Été 1983. Elio Perlman, 17 ans, passe ses vacances dans la villa du XVIIe siècle que possède sa famille en Italie, à jouer de la musique classique, à lire et à flirter avec son amie Marzia. Son père, éminent professeur spécialiste de la culture gréco-romaine, et sa mère, traductrice, lui ont donné une excellente éducation, et il est proche de ses parents. Sa sophistication et ses talents intellectuels font d’Elio un jeune homme mûr pour son âge, mais il conserve aussi une certaine innocence, en particulier pour ce qui touche à l’amour. Un jour, Oliver, un séduisant Américain qui prépare son doctorat, vient travailler auprès du père d’Elio. Elio et Oliver vont bientôt découvrir l’éveil du désir, au cours d’un été ensoleillé dans la campagne italienne qui changera leur vie à jamais.','1794b4aa3b8d0ca6836557f5290f1428.jpeg','2018-03-05 05:41:14','drame'),
	(29,'JESUS, L\'ENQUETE','Lee Strobel, journaliste d’investigation au Chicago Tribune et athée revendiqué, est confronté à la soudaine conversion de son épouse au christianisme. Afin de sauver son couple, il se met à enquêter sur la figure du Christ, avec l\'ambition de prouver que celui-ci n\'est jamais ressuscité…','a0a3240605d8a9dc145310378923ad3a.jpeg','2018-03-05 05:43:29','drame'),
	(30,'LA FETE EST FINIE','LA FETE EST FINIE, c’est l’histoire d’une renaissance, celle de Céleste et Sihem. Arrivées le même jour dans un centre de désintoxication, elles vont sceller une amitié indestructible. Celle-ci sera autant une force qu’un obstacle lorsque, virées du centre, elles se retrouvent livrées à elles-mêmes, à l’épreuve du monde réel et de ses tentations. Le vrai combat commence alors, celui de l’abstinence et de la liberté, celui vers la vie.','486bfe8c8dcfbd5ae2252df0c6d62dde.jpeg','2018-03-05 05:44:40','drame'),
	(31,'LES GARCONS SAUVAGES','Début du vingtième siècle, cinq adolescents de bonne famille épris de liberté commettent un crime sauvage.  Ils sont repris en main par le Capitaine, le temps d\'une croisière répressive sur un voilier. Les garçons se mutinent. Ils échouent sur une île sauvage où se mêlent plaisir et végétation luxuriante. La métamorphose peut commencer…','8965fac4c10091aff56f29c9e6b520b6.jpeg','2018-03-05 05:46:17','fantastique');

/*!40000 ALTER TABLE `film` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table migration_versions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migration_versions`;

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;

INSERT INTO `migration_versions` (`version`)
VALUES
	('20180305004858');

/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
